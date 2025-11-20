<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Goniometry\Angle;

/**
 * Builds a Moon SynodicRhythm starting from an array of raw ephemeris response.
 */
class FromArray extends Builder
{
    /**
     * The keys the array data must have.
     *
     * @var array
     */
    protected array $columns = [
        "timestamp",
        "angular_distance"
    ];

    /**
     * It constructs the builder with raw data.
     *
     * @param mixed $data
     * @throws InvalidArgumentException if the array data does not 
     * have keys "timestamp" and "angular_distance" or if the array is empty.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->validateData();
    }

    /**
     * @return void
     * @throws InvalidArgumentException if the array data does not 
     * have keys "timestamp" and "angular_distance" or if the array is empty.
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
        $records = collect($this->data);
        $records->transform(function ($item) {
            $datetime = SwissEphemerisDateTime::createFromSwissEphemerisFormat($item["timestamp"]);
            $angle = Angle::createFromDecimal((float) trim($item["angular_distance"]));
            return new SynodicRhythmRecord($datetime, $angle);
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