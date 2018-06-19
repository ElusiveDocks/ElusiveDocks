<?php

namespace ElusiveDocks\Core;

use ElusiveDocks\Core\Contract\Carrier\CarrierInterface;
use ElusiveDocks\Core\Contract\Dock\DockInterface;

/**
 * Class AbstractDock
 * @package ElusiveDocks\Core
 */
abstract class AbstractDock implements DockInterface
{
    /** @var CarrierInterface[] $carriers */
    private $carriers = [];

    /**
     * @inheritDoc
     */
    public function hasCarrier(CarrierInterface $carrier): bool
    {
        if (empty($this->carriers)) {
            return true;
        }
        if( isset($this->carriers[get_class($carrier)]) ) {
            return true;
        }
        return false;
    }

    /**
     * @inheritdoc
     */
    public function getCarriers(): array
    {
        return $this->carriers;
    }

    /**
     * @inheritdoc
     */
    public function getCarrierClasses(): array
    {
        return array_keys($this->carriers);
    }

    /**
     * @inheritdoc
     */
    public function setCarriers(array $carriers): DockInterface
    {
        foreach( $carriers as $carrier) {
            $this->addCarrier($carrier);
        }
        return $this;
    }

    /**
     * @inheritdoc
     */
    public function addCarrier(CarrierInterface $carrier): DockInterface
    {
        $this->carriers[get_class($carrier)] = $carrier;
        return $this;
    }

}
