<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Draconic;

use MarcoConsiglio\Ephemeris\Enums\Cardinality;
use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategy;
use MarcoConsiglio\Goniometry\Angle;

/**
 * The strategy used to find a lunar node.
 */
class Node extends Strategy
{
    /**
     * The record to analize.
     *
     * @var DraconicRecord
     */
    protected DraconicRecord $record;

    /**
     * Construct the strategy with a DraconicRecord.
     *
     * @param int $sampling_rate The sampling rate of the ephemeris
     * expressed in minutes per each step of the ephemeris response.
     */
    public function __construct(DraconicRecord $record, int $sampling_rate)
    {
        $this->record = $record;
        $this->sampling_rate = $sampling_rate;
        $this->delta = $this->calculateDelta();
    }

    /**
     * Find an exact record which is a Moon node.
     *
     */
    public function found(): DraconicRecord|null
    {
        if ($this->isANode($this->record->moon_longitude, $this->record->north_node_longitude)) {
            $this->record->cardinality = Cardinality::North;
            return $this->record;
        }
        if ($this->isANode($this->record->moon_longitude, $this->record->south_node_longitude)) {
            $this->record->cardinality = Cardinality::South;
            return $this->record;
        }
        else return null;
    }

    /**
     * Check if the record refers to a lunar node.
     */
    protected function isANode(Angle $moon_longitude, Angle $node_longitude): bool
    {
        return $this->isAboutAbsolute(
            $moon_longitude->toDecimal(),
            $node_longitude->toDecimal(),
            $this->delta
        );
    }

    /**
     * Return the daily speed of the record the strategy uses.
     */
    protected function getSpeed(): float
    {
        return $this->record->daily_speed;
    }
}