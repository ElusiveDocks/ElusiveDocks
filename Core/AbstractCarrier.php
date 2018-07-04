<?php

namespace ElusiveDocks\Core;

use ElusiveDocks\Core\Contract\Carrier\CarrierInterface;

/**
 * Class AbstractCarrier
 * @package ElusiveDocks\Core
 */
class AbstractCarrier implements CarrierInterface
{
    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return serialize($this);
    }
}
