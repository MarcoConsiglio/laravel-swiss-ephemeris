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
     * The data used to create the Moon SynodicRhythm collection.
     *
     * @var array
     */
    protected array $data;

    /**
     * The raw ephemeris response.
     *
     * @var array
     */
    protected array $records = [];

    /**
     * Constructs the builder with raw data.
     *
     * @param mixed $data
     * @throws \InvalidArgumentException if passed data is not array with "timestamp" and "angular_distance" keys.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->validateData();
    }

    /**
     * @return void
     * @throws \InvalidArgumentException if passed data is not array with "timestamp" and "angular_distance" keys.
     */
    protected function validateData()
    {
        $this_class = self::class;
        if (empty($this->data)) {
            throw new InvalidArgumentException("The $this_class builder cannot work with an empty array.");
        }

        $records = collect($this->data);
        $records->filter(function ($value, $key) use ($this_class) {
            if(!isset($value["timestamp"])) {
                throw new InvalidArgumentException("The $this_class builder must have \"timestamp\" column.");    
            }
            if(!isset($value["angular_distance"])) {
                throw new InvalidArgumentException("The $this_class builder must have \"angular_distance\" column.");
            }
            return $value;
        });
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
        $this->records = $records->all();
    }

    /**
     * Fetch the builded array of Moon SynodicRhythmRecord instances.
     *
     * @return SynodicRhythmRecord[]
     */
    public function fetchCollection(): array
    {
        if (!$this->builded) $this->buildRecords();
        return $this->records;
    }
}