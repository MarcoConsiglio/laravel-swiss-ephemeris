<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use MarcoConsiglio\Ephemeris\Enums\Moon\Period as PeriodType;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Traits\StringableRecord;
use Stringable;

/**
 * Represents a fraction of the Moon phase cicle, 
 * i.e. a waxing or a waning Moon period.
 */
class Period implements Stringable
{
    use StringableRecord;

    /**
     * Start timestamp of this period.
     *
     * @var SwissEphemerisDateTime
     */
    public protected(set) SwissEphemerisDateTime $start;

    /**
     * End timestamp of this period.
     *
     * @var SwissEphemerisDateTime
     */
    public protected(set) SwissEphemerisDateTime $end;

    /**
     * The type of this period (waning or waxing).
     *
     * @var PeriodType
     */
    public protected(set) PeriodType $type;

    /**
     * Construct a Moon period.
     *
     * @param SwissEphemerisDateTime $start
     * @param SwissEphemerisDateTime $end
     * @param PeriodType $type
     */
    public function __construct(SwissEphemerisDateTime $start, SwissEphemerisDateTime $end, PeriodType $type)
    {
        $this->start = $start;
        $this->end = $end;
        $this->type = $type;
    }

    /**
     * Tells if this period is waxing.
     *
     * @return boolean
     */
    public function isWaxing(): bool
    {
        return $this->type == PeriodType::Waxing;
    }

    /**
     * Tells if this period is waning.
     *
     * @return boolean
     */
    public function isWaning(): bool
    {
        return $this->type == PeriodType::Waning;
    }

    /**
     * Pack the object properties in an associative array.
     * 
     * @return array{end:string,start:string,type:mixed}
     */
    protected function packProperties(): array
    {
        return [
            "start" => $this->start->toDateTimeString(),
            "end" => $this->end->toDateTimeString(),
            "type" => $this->enumToString($this->type)
        ];
    }

    /**
     * Get the parent properties packed in an associative 
     * array.
     * 
     * @return array
     */
    protected function getParentProperties(): array {return [];}
}