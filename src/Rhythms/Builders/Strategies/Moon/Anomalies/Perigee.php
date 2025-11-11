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
        if($this->isAboutAngle(
            $this->record->moon_longitude, 
            $this->record->perigee_longitude, 
            $this->angular_delta)
        ) {
            return $this->record;
        }
        return null;
    }
}