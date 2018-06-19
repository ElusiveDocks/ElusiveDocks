<?php

namespace ElusiveDocks\Dock;


use ElusiveDocks\Core\AbstractDock;
use ElusiveDocks\Core\Contract\Carrier\CarrierInterface;
use ElusiveDocks\Core\Contract\Dock\DockInterface;

class ThreadDock1 extends AbstractDock implements DockInterface
{
    /**
     * @inheritDoc
     */
    public function run(CarrierInterface $carrier): CarrierInterface
    {
        dump(__CLASS__ . ' Sleep 1s');
        sleep(1);
        dump(__CLASS__ . ' Sleep Done.');

        return $carrier;
    }
}