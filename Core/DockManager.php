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
            if ($dock->hasCarrier($carrier)) {
                $newCarrier = $dock->run($carrier);
                if ($carrier !== $newCarrier) {
                    dump('Run Dock: ' . get_class($dock) . ' Carrier: ' . get_class($carrier) . ' > ' . get_class($newCarrier));
                } else {
                    dump('Run Dock: ' . get_class($dock) . ' Carrier: ' . get_class($newCarrier));
                }
                $carrier = $newCarrier;

            } else {
                dump('Skip Dock: ' . get_class($dock) . ' Carrier: ' . get_class($carrier));
            }
        }
        return $carrier;
    }

}
