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
     * Constructs the PerigeeStrategy with a PerigeeRecord.
     *
     * @param PerigeeRecord $record
     */
    public function __construct(PerigeeRecord $record)
    {
        $this->record = $record;
    }
    
    /**
     * Returns the record only if the Moon is close to its perigee.
     *
     * @return PerigeeRecord|null
     */
    public function found(): ?PerigeeRecord
    {
        if($this->isAbout(
            $this->record->moon_longitude->toDecimal(2), 
            $this->record->perigee_longitude->toDecimal(2), 
            $this->delta)
        ) {
            return $this->record;
        }
        return null;
    }
}