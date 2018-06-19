<?php

namespace ElusiveDocks\Core\Kernel;

use ElusiveDocks\Core\Contract\Kernel\KernelInterface;
use ElusiveDocks\Core\Contract\Kernel\RequestInterface;
use ElusiveDocks\Core\Contract\Kernel\ResponseInterface;
use ElusiveDocks\Core\DockManager;
use ElusiveDocks\Core\Kernel\Http\Response;
use ElusiveDocks\Dock\Example2Carrier;
use ElusiveDocks\Dock\ExampleCarrier;
use ElusiveDocks\Dock\ExampleDock;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class HttpKernel
 * @package ElusiveDocks\Core\Kernel
 */
class HttpKernel implements KernelInterface
{

    /**
     * @inheritdoc
     */
    public function handle(RequestInterface $request): ResponseInterface
    {
        $response = new Response();


        $dm = new DockManager();

        $dm->addDock((new ExampleDock())->addCarrier(new ExampleCarrier()));

        $dm->addDock((new ExampleDock())->setCarriers([new Example2Carrier(),new ExampleCarrier()]));

        $dm->addDock((new ExampleDock())->addCarrier(new ExampleCarrier()));
        $dm->addDock((new ExampleDock())->addCarrier(new Example2Carrier()));

        $carrier = $dm->run(
            new ExampleCarrier()
        );

        var_dump($carrier);

        return $response;
    }
}
