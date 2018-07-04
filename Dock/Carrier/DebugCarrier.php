<?php

namespace ElusiveDocks\Dock\Carrier;

use ElusiveDocks\Core\AbstractCarrier;
use ElusiveDocks\Core\Contract\Carrier\CarrierInterface;
use Symfony\Component\VarDumper\Dumper\DataDumperInterface;

/**
 * Class DebugCarrier
 * @package ElusiveDocks\Dock\Carrier
 */
class DebugCarrier extends AbstractCarrier implements CarrierInterface
{
    /** @var null|DataDumperInterface $dumper */
    private $dumper = null;

    /**
     * @inheritDoc
     */
    public function __construct(DataDumperInterface $dumper)
    {
        $this->dumper = $dumper;
    }

    /**
     * @return null|DataDumperInterface
     */
    public function getDumper(): ?DataDumperInterface
    {
        return $this->dumper;
    }

    /**
     * @param null|DataDumperInterface $dumper
     * @return DebugCarrier
     */
    public function setDumper(?DataDumperInterface $dumper): DebugCarrier
    {
        $this->dumper = $dumper;
        return $this;
    }

}
