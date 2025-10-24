<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Anomalies;

use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;

/**
 * This strategy is used to find an ApogeeRecord
 * representing the Moon in its apogee.
 */
class ApogeeStrategy extends AnomalisticStrategy
{
    /**
     * Constructs the ApogeeStrategy with an ApogeeRecord.
     *
     * @param ApogeeRecord $record
     */
    public function __construct(ApogeeRecord $record)
    {
        $this->record = $record;
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
            $this->delta)
        ) {
            return $this->record;
        }
        return null;
    }
}