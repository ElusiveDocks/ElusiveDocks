<?php

namespace ElusiveDocks\Core\Kernel;

use ElusiveDocks\Core\Contract\Kernel\KernelInterface;
use ElusiveDocks\Core\Contract\Kernel\RequestInterface;
use ElusiveDocks\Core\Contract\Kernel\ResponseInterface;
use ElusiveDocks\Core\Kernel\Cli\Response;

/**
 * Class CliKernel
 * @package ElusiveDocks\Core\Kernel
 */
class CliKernel implements KernelInterface
{

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        $response = new Response();

        return $response;
    }
}
