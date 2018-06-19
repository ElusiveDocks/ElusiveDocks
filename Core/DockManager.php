<?php

namespace ElusiveDocks\Core;

use ElusiveDocks\Core\Contract\Carrier\CarrierInterface;
use ElusiveDocks\Core\Contract\Dock\DockInterface;

/**
 * Class DockManager
 * @package ElusiveDocks\Core
 */
class DockManager
{
    /** @var DockInterface[] $dockRegister */
    private $dockRegister = [];

    /**
     * @param DockInterface $dock
     * @return DockManager
     */
    public function addDock(DockInterface $dock): DockManager
    {
        $this->dockRegister[] = $dock;
        return $this;
    }

    /**
     * @param CarrierInterface $carrier
     * @return CarrierInterface
     */
    public function run(CarrierInterface $carrier): CarrierInterface
    {

        foreach ($this->dockRegister as $dock) {
            var_dump( get_class($carrier) );
            var_dump( $dock->getCarrierClasses() );
            if( $dock->hasCarrier( $carrier ) ) {
                $carrier = $dock->run($carrier);
            }
        }
        return $carrier;
    }

}
