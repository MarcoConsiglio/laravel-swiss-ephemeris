<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Templates\Moon\SynodicRhythmTemplate;
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
    protected array $columns;

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
        $this->columns = SynodicRhythmTemplate::getColumns();
        $this->validateData();
    }

    /**
     * @return void
     * @throws InvalidArgumentException if the array data does not 
     * have keys "timestamp" and "angular_distance" or if the array is empty.
     */
    protected function validateData()
    {
        $this_class = self::class;
        if (empty($this->data)) {
            throw new InvalidArgumentException("The $this_class builder cannot work with an empty array.");
        }
        $columns = $this->columns;
        $records = collect($this->data);
        $records->each(function ($value) use ($this_class, $columns) {
            if(!isset($value[$columns[0]])) {
                throw new InvalidArgumentException("The $this_class builder must have \"$columns[0]\" column.");    
            }
            if(!isset($value[$columns[1]])) {
                throw new InvalidArgumentException("The $this_class builder must have \"$columns[1]\" column.");
            }
            if(!isset($value[$columns[2]])) {
                throw new InvalidArgumentException("The $this_class builder must have \"$columns[2]\" column.");
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
        $columns = $this->columns;
        $records = collect($this->data);
        $records->transform(function ($item) use ($columns) {
            $datetime = SwissEphemerisDateTime::createFromSwissEphemerisFormat($item[$columns[0]]);
            $angle = Angle::createFromDecimal((float) trim($item[$columns[1]]));
            $daily_speed = (float) trim($item[$columns[2]]);
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