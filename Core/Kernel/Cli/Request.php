<?php

namespace ElusiveDocks\Core\Kernel\Cli;

use ElusiveDocks\Core\Contract\Kernel\RequestInterface;
use ElusiveDocks\Core\Kernel\AbstractRequest;
use Symfony\Component\Console\Input\ArgvInput;

/**
 * Class Request
 * @package ElusiveDocks\Core\Kernel\Cli
 */
class Request extends AbstractRequest implements RequestInterface
{
    /**
     * @inheritDoc
     */
    public function capture(): RequestInterface
    {
        $input = new ArgvInput();

        dump($input);

        return $this;
    }

}
