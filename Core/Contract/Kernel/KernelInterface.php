<?php

namespace ElusiveDocks\Core\Contract\Kernel;

/**
 * Interface KernelInterface
 * @package ElusiveDocks\Core\Contract\Kernel
 */
interface KernelInterface
{
    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request): ResponseInterface;
}
