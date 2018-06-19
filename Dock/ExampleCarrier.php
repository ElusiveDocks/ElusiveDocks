<?php

namespace ElusiveDocks\Dock;

use ElusiveDocks\Core\AbstractCarrier;
use ElusiveDocks\Core\Contract\Carrier\CarrierInterface;

/**
 * Class ExampleCarrier
 * @package ElusiveDocks\Dock
 */
class ExampleCarrier extends AbstractCarrier implements CarrierInterface
{
    /** @var int $examplePropertyA */
    private $examplePropertyA = 0;

    /**
     * @return int
     */
    public function getExamplePropertyA(): int
    {
        return $this->examplePropertyA;
    }

    /**
     * @param int $examplePropertyA
     * @return ExampleCarrier
     */
    public function setExamplePropertyA(int $examplePropertyA): ExampleCarrier
    {
        $this->examplePropertyA = $examplePropertyA;
        return $this;
    }

}
