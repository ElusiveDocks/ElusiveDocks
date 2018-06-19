<?php

namespace ElusiveDocks\Core\Contract\Kernel;

/**
 * Interface ResponseInterface
 * @package ElusiveDocks\Core\Contract\Kernel
 */
interface ResponseInterface
{
    /**
     * @return ResponseInterface
     */
    public function send(): ResponseInterface;
}
