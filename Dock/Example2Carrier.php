<?php

namespace ElusiveDocks\Dock;

use ElusiveDocks\Core\AbstractCarrier;
use ElusiveDocks\Core\Contract\Carrier\CarrierInterface;

/**
 * Class Example2Carrier
 * @package ElusiveDocks\Dock
 */
class Example2Carrier extends AbstractCarrier implements CarrierInterface
{
    /** @var int $examplePropertyB */
    private $examplePropertyB = 0;

    /**
     * @return int
     */
    public function getExamplePropertyB(): int
    {
        return $this->examplePropertyB;
    }

    /**
     * @param int $examplePropertyB
     * @return Example2Carrier
     */
    public function setExamplePropertyB(int $examplePropertyB): Example2Carrier
    {
        $this->examplePropertyB = $examplePropertyB;
        return $this;
    }
}
