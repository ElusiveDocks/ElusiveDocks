<?php

namespace ElusiveDocks\Core\Kernel\Http;

use ElusiveDocks\Core\Contract\Kernel\ResponseInterface;
use ElusiveDocks\Core\Exception\Kernel\KernelException;
use ElusiveDocks\Core\Exception\UnexpectedException;
use ElusiveDocks\Core\Kernel\AbstractResponse;

/**
 * Class Response
 * @package ElusiveDocks\Core\Kernel\Http
 */
class Response extends AbstractResponse implements ResponseInterface
{
    use StatusTrait;

    /**
     * @inheritDoc
     */
    public function send(): ResponseInterface
    {
        $this->sendHeaders();
        $this->sendContent();

        return $this;
    }

    /**
     * @return ResponseInterface
     * @throws KernelException
     * @throws UnexpectedException
     */
    private function sendHeaders(): ResponseInterface
    {
        if ($this->isHeaderAvailable()) {
            $this->sendStatus(404);
        }

        return $this;
    }

    /**
     * @return bool
     */
    private function isHeaderAvailable()
    {
        if (headers_sent()) {
            return false;
        }
        return true;
    }

    /**
     * @param int $code
     * @param string $version 1.1
     * @throws KernelException
     * @throws UnexpectedException
     */
    private function sendStatus(int $code, string $version = '1.1')
    {
        header(
            sprintf(
                'HTTP/%s %s %s',
                $version,
                $this->getStatusCode($code),
                $this->getStatusText($code)
            ),
            true, $code
        );
    }

    private function sendContent()
    {
        dump(__METHOD__);
    }
}
