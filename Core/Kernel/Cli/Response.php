<?php

namespace ElusiveDocks\Core\Kernel\Cli;

use ElusiveDocks\Core\Contract\Kernel\ResponseInterface;
use ElusiveDocks\Core\Kernel\AbstractResponse;

/**
 * Class Response
 * @package ElusiveDocks\Core\Kernel\Cli
 */
class Response extends AbstractResponse implements ResponseInterface
{
    /**
     * @inheritDoc
     */
    public function send(): ResponseInterface
    {
        $this->sendContent();

        return $this;
    }

    private function sendContent()
    {
        dump(__METHOD__);
    }
}
