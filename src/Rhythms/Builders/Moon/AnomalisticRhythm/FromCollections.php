<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm;

use MarcoConsiglio\Ephemeris\Records\Moon\AnomalisticRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Apogees;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Perigees;

/**
 * Build a Moon AnomalisticRhythm collection from
 * a Moon Apogees collection and a Moon Perigees 
 * collection.
 */
class FromCollections extends Builder
{
    /**
     * The Apogees collection.
     *
     * @var Apogees
     */
    protected Apogees $apogees;

    /**
     * The Perigees collection.
     *
     * @var Perigees
     */
    protected Perigees $perigees;

    /**
     * Construct the builder with
     * the two apogee and perigee collections.
     */
    public function __construct(Apogees $apogees, Perigees $perigees)
    {
        $this->apogees = $apogees;
        $this->perigees = $perigees;
    }

    /**
     * Validate data.
     *
     * @return void
     * @codeCoverageIgnore
     */
    protected function validateData()
    {
        // No need to validate data.
    }

    /**
     * Build records.
     *
     * @return void
     */
    protected function buildRecords()
    {
        $this->data = collect([$this->apogees, $this->perigees])
            ->collapse()
            ->sort(function ($previous_record, $next_record) {
                /** @var AnomalisticRecord $previous_record */
                /** @var AnomalisticRecord $next_record */
                if ($previous_record->timestamp->equalTo($next_record->timestamp))
                    return 0; // @codeCoverageIgnore
                $sort = $previous_record->timestamp->greaterThan($next_record->timestamp);
                return $sort == true ? 1 : -1;
            })->values()->all();
    }

    /**
     * Fetch the result.
     *
     * @return AnomalisticRecord[]
     */
    public function fetchCollection(): array
    {
        if (!$this->builded) $this->buildRecords();
        return $this->data;
    }
}