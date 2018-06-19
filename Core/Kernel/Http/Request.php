<?php

namespace ElusiveDocks\Core\Kernel\Http;

use ElusiveDocks\Core\Contract\Kernel\RequestInterface;
use ElusiveDocks\Core\Kernel\AbstractRequest;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

/**
 * Class Request
 * @package ElusiveDocks\Core\Kernel\Http
 */
class Request extends AbstractRequest implements RequestInterface
{
    /**
     * @inheritDoc
     */
    public function capture(): RequestInterface
    {
        $symfonyRequest = SymfonyRequest::createFromGlobals();


        return $this;
    }

}
