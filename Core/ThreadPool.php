<?php

namespace ElusiveDocks\Core;


use ElusiveDocks\Core\Exception\UnexpectedException;

class ThreadPool
{
    private $ThreadManager = null;
    private $CurlHandler = null;
    private $CurlPool = [];
    private $CurlSize = 256;

    private $Properties = [
        'code' => CURLINFO_HTTP_CODE,
        'time' => CURLINFO_TOTAL_TIME,
        'length' => CURLINFO_CONTENT_LENGTH_DOWNLOAD,
        'type' => CURLINFO_CONTENT_TYPE,
        'url' => CURLINFO_EFFECTIVE_URL
    ];
    private $isRunning = 0;
    private $isStatus = 0;
    private $delayFactor = 1.1;

    /**
     * @inheritDoc
     */
    public function __construct(ThreadManager $threadManager)
    {
        $this->ThreadManager = $threadManager;
        $this->CurlHandler = curl_multi_init();
        $this->CurlPool = [];

        $this->getThreadManager()->addThreadPool($this);
    }

    /**
     * @return ThreadManager|null
     */
    public function getThreadManager(): ?ThreadManager
    {
        return $this->ThreadManager;
    }

    /**
     * @param string $EndPoint
     * @param array $Options
     * @return ThreadHandler
     * @throws UnexpectedException
     */
    public function createThread($EndPoint, $Options = [])
    {
        if( count($this->CurlPool) < $this->CurlSize ) {
            $Thread = curl_init($EndPoint);
            curl_setopt($Thread, CURLOPT_RETURNTRANSFER, 1);
            foreach ($Options as $Option => $Value) {
                curl_setopt($Thread, $Option, $Value);
            }
            return $this->injectThread($Thread);
        } else {
            throw new UnexpectedException('Max pool size '.$this->CurlSize);
        }
    }

    /**
     * @param resource $Thread
     * @return ThreadHandler
     * @throws UnexpectedException
     */
    private function injectThread($Thread)
    {
        if (gettype($Thread) !== 'resource') {
            throw new UnexpectedException('Parameter must be a valid curl handle!');
        }

        $Identifier = $this->createIdentifier($Thread);
        $this->CurlPool[$Identifier] = $Thread;

        curl_setopt($Thread, CURLOPT_HEADERFUNCTION, [$this, 'headerCallback']);

        $code = curl_multi_add_handle($this->CurlHandler, $Thread);

        $this->getThreadManager()->debugStart($Identifier);

        // (1)
        if ($code === CURLM_OK || $code === CURLM_CALL_MULTI_PERFORM) {
            do {
                $this->isStatus = curl_multi_exec($this->CurlHandler, $this->isRunning);
            } while ($this->isStatus === CURLM_CALL_MULTI_PERFORM);

            return new ThreadHandler($this, $Identifier);
        } else {
            throw new UnexpectedException('Could not create thread!');
        }
    }

    /**
     * @param $Thread
     * @return string
     */
    private function createIdentifier($Thread)
    {
        return (string)$Thread;
    }

    /**
     * @param null $Identifier
     * @return ThreadHandler|null
     */
    public function runThreads($Identifier = null): ?ThreadHandler
    {
        if ($Identifier === null) {
            return null;
        } else {

            $ThreadHandler = $this->getThreadManager()->getThreadHandler($Identifier);

            if ($ThreadHandler->getResponse('code') !== null) {
                return $ThreadHandler;
            }

            $InnerDelay = $OuterDelay = 1;

            while ($this->isRunning && ($this->isStatus == CURLM_OK || $this->isStatus == CURLM_CALL_MULTI_PERFORM)) {

                $this->delayExecution($OuterDelay);
                $OuterDelay = $this->delayCalculation($OuterDelay);

                $ThreadSelectCode = curl_multi_select($this->CurlHandler, 0);

                // bug in PHP 5.3.18+ where curl_multi_select can return -1
                // https://bugs.php.net/bug.php?id=63411
                if ($ThreadSelectCode === -1) {
                    usleep(100000);
                }

                // see pull request https://github.com/jmathai/php-multi-curl/pull/17
                // details here http://curl.haxx.se/libcurl/c/libcurl-errors.html
                if ($ThreadSelectCode >= CURLM_CALL_MULTI_PERFORM) {
                    do {
                        $this->isStatus = curl_multi_exec($this->CurlHandler, $this->isRunning);

                        $this->delayExecution($InnerDelay);
                        $InnerDelay = $this->delayCalculation($InnerDelay);

                    } while ($this->isStatus == CURLM_CALL_MULTI_PERFORM);

                    $InnerDelay = 1;
                }

                while(false !== ($Response = curl_multi_info_read($this->CurlHandler)))
                {
                    $this->storeResponse($Response);
                }

                if ($ThreadHandler->getResponse('data') !== null) {
                    return $ThreadHandler;
                }
            }

            return null;
        }
    }

    /**
     * @param array $Response
     * @param bool $isAsynchronous
     */
    private function storeResponse(array $Response, $isAsynchronous = true): void
    {
        $Identifier = $this->createIdentifier($Response['handle']);

        $this->getThreadManager()->debugStop($Identifier, $Response);

        $ThreadHandler = $this->getThreadManager()->getThreadHandler($Identifier);

        if($isAsynchronous) {
            $ThreadHandler->setResponse('data', curl_multi_getcontent($Response['handle']));
        } else {
            $ThreadHandler->setResponse('data', curl_exec($Response['handle']));
        }

        $ThreadHandler->setResponse('response', $ThreadHandler->getResponse('data'));

        foreach($this->Properties as $Key => $Value)
        {
            $ThreadHandler->setProperty($Key, curl_getinfo($Response['handle'], $Value));
        }

        if($isAsynchronous) {
            curl_multi_remove_handle($this->CurlHandler, $Response['handle']);
        }

        curl_close($Response['handle']);
    }

    /**
     * @param int $Value
     * @return void
     */
    private function delayExecution(int $Value): void
    {
        usleep(intval($Value));
    }

    /**
     * @param int $Value
     * @return int
     */
    private function delayCalculation(int $Value): int
    {
        return intval(max(1, ($Value * $this->delayFactor)));
    }

    /**
     * @param string $Identifier
     * @return resource|null
     */
    public function getThread(string $Identifier)
    {
        return $this->CurlPool[$Identifier];
    }

    /**
     * @param $Thread
     * @param $Header
     * @return int
     */
    private function headerCallback($Thread, $Header)
    {
        $Headers = trim($Header);
        $PayloadPos = strpos($Headers, ':');
        if ($PayloadPos > 0) {
            $Key = substr($Headers, 0, $PayloadPos);
            $Value = preg_replace('/^\W+/', '', substr($Headers, $PayloadPos));

            $this->getThreadManager()->setThreadHeader(
                $this->createIdentifier($Thread), $Key, $Value
            );
        }
        return strlen($Header);
    }
}
