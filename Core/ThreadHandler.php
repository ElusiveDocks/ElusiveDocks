<?php

namespace ElusiveDocks\Core;

/**
 * Class ThreadHandler
 * @package ElusiveDocks\Core
 */
class ThreadHandler
{
    /** @var ThreadPool|null $Pool */
    private $Pool = null;
    private $Identifier = '';
    private $Headers = [];
    private $Properties = [];
    private $Responses = [];

    /**
     * ThreadHandler constructor.
     *
     * @param ThreadPool $Pool
     * @param string $Identifier
     */
    public function __construct(ThreadPool $Pool, $Identifier)
    {
        $this->setIdentifier($Identifier);
        $this->setPool($Pool);
        $this->getPool()->getThreadManager()->addThreadHandler($this);
    }

    /**
     * @return ThreadHandler|null
     */
    public function runThread()
    {
        return $this->getPool()->runThreads(
            $this->getIdentifier()
        );
    }

    /**
     * @return ThreadPool|null
     */
    public function getPool(): ?ThreadPool
    {
        return $this->Pool;
    }

    /**
     * @param ThreadPool|null $Pool
     * @return ThreadHandler
     */
    public function setPool(?ThreadPool $Pool): ThreadHandler
    {
        $this->Pool = $Pool;
        return $this;
    }

    /**
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->Identifier;
    }

    /**
     * @param string $Identifier
     * @return ThreadHandler
     */
    public function setIdentifier(string $Identifier): ThreadHandler
    {
        $this->Identifier = $Identifier;
        return $this;
    }

    /**
     * @param string $Key
     * @param string $Value
     * @return ThreadHandler
     */
    public function setHeader(string $Key, string $Value): ThreadHandler
    {
        $this->Headers[$Key] = $Value;
        return $this;
    }

    /**
     * @param string $Key
     * @return null|string
     */
    public function getHeader(string $Key): ?string
    {
        if (isset($this->Headers[$Key])) {
            return $this->Headers[$Key];
        }
        return null;
    }

    /**
     * @param string $Key
     * @param string $Value
     * @return ThreadHandler
     */
    public function setProperty(string $Key, string $Value): ThreadHandler
    {
        $this->Properties[$Key] = $Value;
        return $this;
    }

    /**
     * @param string $Key
     * @return null|string
     */
    public function getProperty(string $Key): ?string
    {
        if (isset($this->Properties[$Key])) {
            return $this->Properties[$Key];
        }
        return null;
    }

    /**
     * @param string $Key
     * @param string $Value
     * @return ThreadHandler
     */
    public function setResponse(string $Key, string $Value): ThreadHandler
    {
        $this->Responses[$Key] = $Value;
        return $this;
    }

    /**
     * @param string $Key
     * @return null|string
     */
    public function getResponse(string $Key): ?string
    {
        if (isset($this->Responses[$Key])) {
            return $this->Responses[$Key];
        }
        return null;
    }

    /**
     * @return null|string
     */
    public function getResult()
    {
        return $this->getResponse('response');
    }
}
