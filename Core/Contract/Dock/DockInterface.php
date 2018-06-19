<?php

namespace ElusiveDocks\Core\Contract\Dock;

use ElusiveDocks\Core\Contract\Carrier\CarrierInterface;

/**
 * Interface DockInterface
 * @package ElusiveDocks\Core\Contract\Dock
 */
interface DockInterface
{
    /**
     * @param CarrierInterface $carrier
     * @return DockInterface
     */
    public function addCarrier(CarrierInterface $carrier): DockInterface;

    /**
     * @return CarrierInterface[]
     */
    public function getCarriers(): array;

    /**
     * @return array
     */
    public function getCarrierClasses(): array;

    /**
     * @param CarrierInterface $carrier
     * @return bool
     */
    public function hasCarrier(CarrierInterface $carrier): bool;

    /**
     * @param CarrierInterface[] $carriers
     * @return DockInterface
     */
    public function setCarriers(array $carriers): DockInterface;

    /**
     * @param CarrierInterface $carrier
     * @return CarrierInterface
     */
    public function run(CarrierInterface $carrier): CarrierInterface;
}
