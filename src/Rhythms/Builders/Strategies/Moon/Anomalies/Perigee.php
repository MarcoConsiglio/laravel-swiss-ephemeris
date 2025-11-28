<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Anomalies;

use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;

/**
 * This strategy is used to find an PerigeeRecord
 * representing the Moon in its perigee.
 */
class Perigee extends AnomalisticStrategy
{
    /**
     * It constructs the PerigeeStrategy with a PerigeeRecord.
     *
     * @param PerigeeRecord $record
     * @param int $sampling_rate The sampling rate of the ephemeris expressed in minutes.
     */
    public function __construct(PerigeeRecord $record, int $sampling_rate)
    {
        $this->record = $record;
        $this->sampling_rate = $sampling_rate;
        $this->delta = $this->calculateDelta();
    }
    
    /**
     * Returns the record only if the Moon is close to its perigee.
     *
     * @return PerigeeRecord|null
     */
    public function found(): ?PerigeeRecord
    {
        if($this->isAbout(
            $this->record->moon_longitude->toDecimal(),
            $this->record->perigee_longitude->toDecimal(),
            $this->delta
        )) return $this->record;
        else return null;
    }
}