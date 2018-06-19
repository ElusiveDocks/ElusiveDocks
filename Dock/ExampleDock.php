<?php

namespace ElusiveDocks\Dock;

use ElusiveDocks\Core\AbstractDock;
use ElusiveDocks\Core\Contract\Carrier\CarrierInterface;
use ElusiveDocks\Core\Contract\Dock\DockInterface;

/**
 * Class ExampleDock
 * @package ElusiveDocks\Dock
 */
class ExampleDock extends AbstractDock implements DockInterface
{
    /**
     * @inheritDoc
     */
    public function run(CarrierInterface $carrier): CarrierInterface
    {
        if( $carrier instanceof ExampleCarrier) {

            $carrier->setExamplePropertyA(
                $carrier->getExamplePropertyA() +1
            );

            $carrier = (new Example2Carrier())->setExamplePropertyA($carrier->getExamplePropertyA());

            return $carrier;
        }

        if( $carrier instanceof Example2Carrier) {

            $carrier->setExamplePropertyA(
                $carrier->getExamplePropertyA() +10
            );

//            $carrier = (new Example2Carrier())->setExamplePropertyA($carrier->getExamplePropertyA());

            return $carrier;
        }

        return $carrier;
    }
}
