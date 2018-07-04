<?php

namespace ElusiveDocks\Dock;


use ElusiveDocks\Core\AbstractDock;
use ElusiveDocks\Core\Contract\Carrier\CarrierInterface;
use ElusiveDocks\Core\Contract\Dock\DockInterface;

class ThreadDock3 extends AbstractDock implements DockInterface
{
    /**
     * @inheritDoc
     */
    public function run(CarrierInterface $carrier = null): ?CarrierInterface
    {
        dump(__CLASS__ . ' Sleep 3s');
        sleep(3);
        dump(__CLASS__ . ' Sleep Done.');

        return $carrier;
    }
}
