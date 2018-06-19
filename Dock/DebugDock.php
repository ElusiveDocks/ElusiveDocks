<?php

namespace ElusiveDocks\Dock;

use ElusiveDocks\Core\AbstractDock;
use ElusiveDocks\Core\Contract\Carrier\CarrierInterface;
use ElusiveDocks\Core\Contract\Dock\DockInterface;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class DebugDock
 * @package ElusiveDocks\Dock
 */
class DebugDock extends AbstractDock implements DockInterface
{
    /**
     * @inheritDoc
     */
    public function run(CarrierInterface $carrier): CarrierInterface
    {

        VarDumper::setHandler(function ($var) {
            $dumper = new HtmlDumper();
            $cloner = new VarCloner();
            $handler = function ($var) use ($dumper, $cloner) {
                $dumper->dump($cloner->cloneVar($var));
            };
            VarDumper::setHandler($handler);
            $handler($var);
        });

//        dd(phpinfo());

        return $carrier;
    }

}
