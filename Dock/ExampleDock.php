<?php

namespace ElusiveDocks\Dock;

use ElusiveDocks\Core\AbstractDock;
use ElusiveDocks\Core\Contract\Carrier\CarrierInterface;
use ElusiveDocks\Core\Contract\Dock\DockInterface;
use ElusiveDocks\Dock\Carrier\Example2Carrier;
use ElusiveDocks\Dock\Carrier\ExampleCarrier;

/**
 * Class ExampleDock
 * @package ElusiveDocks\Dock
 */
class ExampleDock extends AbstractDock implements DockInterface
{
    /**
     * @inheritDoc
     */
    public function run(CarrierInterface $carrier = null): ?CarrierInterface
    {
        if( $carrier instanceof ExampleCarrier) {

            $carrier->setExamplePropertyA(
                $carrier->getExamplePropertyA() +1
            );

            return (new Example2Carrier())->setExamplePropertyB($carrier->getExamplePropertyA());
        }

        if( $carrier instanceof Example2Carrier) {

            $carrier->setExamplePropertyB(
                $carrier->getExamplePropertyB() + 10
            );

            return (new ExampleCarrier())->setExamplePropertyA($carrier->getExamplePropertyB());
        }

        return $carrier;
    }
}
