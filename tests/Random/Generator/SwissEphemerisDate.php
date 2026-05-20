<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Generator;

use Carbon\Carbon;
use Faker\Generator;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Random\SwissEphemerisDateRange;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\SwissEphemerisDate as SwissEphemerisDateValidator;
use MarcoConsiglio\FakerPhpNumberHelpers\Random\Generator as RandomGenerator;

class SwissEphemerisDate extends RandomGenerator
{
    public function __construct(
        Generator $generator, 
        SwissEphemerisDateValidator $validator,
        protected SwissEphemerisDateRange $range
    ) {
        return parent::__construct($generator, $validator);
    }

    public function generate(): SwissEphemerisDateTime
    {
        $this->validate();
        $min_year = "{$this->range->start}-01-01";
        $max_year = "{$this->range->end}-12-31";
        $random_date = new Carbon($this->generator->dateTimeBetween($min_year, $max_year));
        return SwissEphemerisDateTime::createFromCarbon($random_date);
    }

    protected function validate(): void
    {
        $this->range->validate($this->validator);
    }
}