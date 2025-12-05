<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies;

use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategy;
use MarcoConsiglio\Goniometry\Angle;

class Node extends Strategy
{
    /**
     * The record to analize.
     *
     * @var DraconicRecord
     */
    protected DraconicRecord $record;

    /**
     * It constructs the strategy with a DraconicRecord.
     *
     * @param DraconicRecord $record
     * @param int $sampling_rate The sampling rate of the ephemeris expressed in minutes.
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
     * @return DraconicRecord|null
     */
    public function found(): DraconicRecord|null
    {
        if (
            $this->isANode($this->record->moon_longitude, $this->record->node_longitude) ||
            $this->isANode($this->record->moon_longitude, $this->record->opposite_node_longitude)
        ) {
            // Calc node cardinality here and return the record with cardinality setted.
            return $this->record;
        }
        else return null;
    }

    protected function isANode(Angle $moon_longitude, Angle $node_longitude): bool
    {
        return $this->isAbout(
            $moon_longitude->toDecimal(),
            $node_longitude->toDecimal(),
            $this->delta
        );
    }

    /**
     * It returns the daily speed of the record the strategy uses.
     *
     * @return float
     */
    protected function getSpeed(): float
    {
        return $this->record->daily_speed;
    }
}