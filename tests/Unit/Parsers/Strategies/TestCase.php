<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Parsers\Strategies;

use RoundingMode;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase as UnitTestCase;

class TestCase extends UnitTestCase
{
    /**
     * Round the $number to 11 decimal places.
     */
    protected function round(float $number): float
    {
        return round($number, 11, RoundingMode::HalfTowardsZero);
    }
}