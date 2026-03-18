<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm;

use InvalidArgumentException;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\FromArrayBuilder;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Templates\Moon\SynodicRhythmTemplate;

/**
 * Build a Moon SynodicRhythm starting from an array of raw ephemeris response.
 */
class FromArray extends FromArrayBuilder
{

    /**
     * Construct the builder with raw data.
     *
     * @param mixed $data
     * @throws \InvalidArgumentException if one or more columns 
     * are missing from the data passed to the builder.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->columns = SynodicRhythmTemplate::getColumns();
        $this->validateData();
    }

    /**
     * Validate data.
     * 
     * @return void
     * @throws \InvalidArgumentException if one or more columns 
     * are missing from the data passed to the builder.
     */
    protected function validateData()
    {
        $this->checkEmptyData();
        $this->validateArrayData($this->columns);
    }

    /**
     * Build SynodicRhythmRecord instances.
     *
     * @return void
     */
    protected function buildRecords()
    {
        $columns = $this->columns;
        $records = collect($this->data);
        $records->transform(function ($item) use ($columns) {
            $datetime = SwissEphemerisDateTime::createFromSwissEphemerisFormat($item[$columns[0]]);
            $angle = Angle::createFromDecimal((float) trim((string) $item[$columns[1]]));
            $daily_speed = (float) trim((string) $item[$columns[2]]);
            return new SynodicRhythmRecord($datetime, $angle, $daily_speed);
        });
        $this->data = $records->all();
    }

    /**
     * Fetch the builded array of Moon SynodicRhythmRecord instances.
     *
     * @return SynodicRhythmRecord[]
     */
    public function fetchCollection(): array
    {
        if (!$this->builded) $this->buildRecords();
        return $this->data;
    }
}