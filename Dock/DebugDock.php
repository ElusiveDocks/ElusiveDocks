<?php

namespace ElusiveDocks\Dock;

use ElusiveDocks\Core\AbstractDock;
use ElusiveDocks\Core\Contract\Carrier\CarrierInterface;
use ElusiveDocks\Core\Contract\Dock\DockInterface;
use ElusiveDocks\Dock\Carrier\DebugCarrier;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

/**
 * Class DebugDock
 * @package ElusiveDocks\Dock
 */
class DebugDock extends AbstractDock implements DockInterface
{
    /**
     * @inheritDoc
     */
    public function run(CarrierInterface $carrier = null): ?CarrierInterface
    {

        if( $carrier instanceof DebugCarrier ) {
            $dumper = $carrier->getDumper();
        } else {
            $dumper = new HtmlDumper();
        }

        VarDumper::setHandler(function ($var) use ($dumper) {
            $cloner = new VarCloner();
            $handler = function ($var) use ($dumper, $cloner) {
                $dumper->dump($cloner->cloneVar($var));
            };
            VarDumper::setHandler($handler);
            $handler($var);
        });

        $whoops = new Run;
        $whoops->pushHandler(new PrettyPageHandler);
        $whoops->register();

        return $carrier;
    }

}
