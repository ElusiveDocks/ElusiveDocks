<?php

namespace ElusiveDocks\Core;

class ThreadManager
{

    private $Statistics = [];
    private $Errors = [];

    private $ThreadHandlers = [];
    private $ThreadPools = [];

    final public function __construct()
    {
    }

    public function debugStart($Identifier)
    {
        $this->Statistics[$Identifier]['start'] = microtime(true);
    }

    public function debugStop($Identifier, $Thread)
    {
        $this->Statistics[$Identifier]['end'] = microtime(true);
        $this->Statistics[$Identifier]['api'] = curl_getinfo($Thread['handle'], CURLINFO_EFFECTIVE_URL);
        $this->Statistics[$Identifier]['time'] = curl_getinfo($Thread['handle'], CURLINFO_TOTAL_TIME);
        $this->Statistics[$Identifier]['code'] = curl_getinfo($Thread['handle'], CURLINFO_HTTP_CODE);
    }

    /**
     * @param ThreadHandler $threadHandler
     * @return ThreadManager
     */
    public function addThreadHandler(ThreadHandler $threadHandler): ThreadManager
    {
        $this->ThreadHandlers[$threadHandler->getIdentifier()] = $threadHandler;
        return $this;
    }

    /**
     * @param $Identifier
     * @return ThreadHandler
     */
    public function getThreadHandler($Identifier): ThreadHandler
    {
        return $this->ThreadHandlers[$Identifier];
    }

    /**
     * @param ThreadPool $threadPool
     * @return ThreadManager
     */
    public function addThreadPool(ThreadPool $threadPool): ThreadManager
    {
        $this->ThreadPools[] = $threadPool;
        return $this;
    }

    /**
     * @param string $Identifier
     * @param string $Key
     * @param string $Value
     * @return ThreadManager
     */
    public function setThreadHeader(string $Identifier, string $Key, string $Value): ThreadManager
    {
        try {
            $this->ThreadHandlers[$Identifier]->setHeader($Key, $Value);
            return $this;
        } catch (\Throwable $throwable) {
            $this->Errors[] = $throwable->getMessage();
            return $this;
        }
    }

    public function runThreads()
    {
        /** @var ThreadHandler $threadHandler */
        foreach ($this->ThreadHandlers as $threadHandler) {
            $threadHandler->runThread();
        }
    }

    public function viewStatistics($Work = 0)
    {

        dump($this->Errors);

        $Width = 100;
        // Find Min/Max/Step for Width

        $Min = PHP_INT_MAX;
        $Max = 0;
        $Step = 0;
        foreach ($this->Statistics as $Benchmark) {
            if (!isset($Benchmark['start'])) {
                $Benchmark['start'] = PHP_INT_MAX;
            }
            if (!isset($Benchmark['end'])) {
                $Benchmark['end'] = 0;
            }

            $Min = min($Benchmark['start'], $Min);
            $Max = max($Benchmark['end'], $Max);
            $Range = $Max - $Min;
            $Step = floatval($Range / $Width);
        }

        foreach($this->Statistics as $Benchmark) {
            print '<div style="clear: both; font-family: monospace; border: 1px solid silver; padding:5px; margin : 5px;">'.$this->tplAscii($Benchmark, $Min, $Max, $Width, $Step, $Work).'</div>';
        }
    }

    private function tplAscii($timer, $Min, $Max, $Width, $Step, $Work)
    {
        $lpad = $rpad = 0;
        $lspace = $chars = $rspace = '';
        if ($timer['start'] > $Min) {
            $lpad = intval(($timer['start'] - $Min) / $Step);
        }
        if (isset($timer['end']) && $timer['end'] < $Max) {
            $rpad = intval(($Max - $timer['end']) / $Step);
        } else {
            $rpad = 0;
        }
        $mpad = $Width - $lpad - $rpad;
        if ($lpad > 0) {
            $lspace = str_repeat('<div style="float: left; width: 5px; height: 5px; background-color: red; border-right: 1px solid red;"></div>', $lpad);
        }
        if ($mpad > 0) {
            $chars = str_repeat('<div style="float: left; width: 5px; height: 5px; background-color: orange; border-right: 1px solid silver;"></div>', $mpad);
        }
        if ($rpad > 0) {
            $rspace = str_repeat('<div style="float: left; width: 5px; height: 5px; background-color: green; border-right: 1px solid silver;"></div>', $rpad);
        }

        if( isset($timer['api']) && isset($timer['code']) && isset($timer['time'])) {

            return
                '<div>' . $timer['api'] . '</div>'
                . '<div style="clear: both;">' . $lspace . $chars . $rspace . '</div>'
                . '<div style="clear: both;"> Code: '
                . $timer['code'] . ': ' .//$timer['start'].' - '.$timer['end'].' = '.
                $timer['time'] . ' ' . ($Work > 0 ? round(100 / $Work * $timer['time'], 2) . '%' : '')
                . '</div>';
        }
    }

    /**
     * @return ThreadHandler[]
     */
    public function getThreadHandlers(): array
    {
        return $this->ThreadHandlers;
    }
}
