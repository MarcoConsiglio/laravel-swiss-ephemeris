<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Anomalies;

use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;

/**
 * This strategy is used to find an ApogeeRecord
 * representing the Moon in its apogee.
 */
class Apogee extends AnomalisticStrategy
{
    /**
     * It constructs the ApogeeStrategy with an ApogeeRecord.
     *
     * @param ApogeeRecord $record
     * @param int $sampling_rate The sampling rate of the ephemeris expressed in minutes.
     */
    public function __construct(ApogeeRecord $record, int $sampling_rate)
    {
        $this->record = $record;
        $this->sampling_rate = $sampling_rate;
        $this->delta = $this->calculateDelta();
    }
    
    /**
     * Returns the record only if the Moon is close to its apogee.
     *
     * @return ApogeeRecord|null
     */
    public function found(): ?ApogeeRecord
    {
        if($this->isAbout(
            $this->record->moon_longitude->toDecimal(),
            $this->record->apogee_longitude->toDecimal(),
            $this->delta
        )) return $this->record;
        else return null;
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