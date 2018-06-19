<?php

namespace ElusiveDocks\Core\Contract\Kernel;

/**
 * Interface RequestInterface
 * @package ElusiveDocks\Core\Contract\Kernel
 */
interface RequestInterface
{
    /**
     * @return RequestInterface
     */
    public function capture(): RequestInterface;
}
