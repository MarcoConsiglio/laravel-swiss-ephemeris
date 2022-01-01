<?php
namespace MarcoConsiglio\Ephemeris\Traits;

/**
 * Supports fuzzy conditions.
 */
trait WithFuzzyCondition
{
    /**
     * Check if a $number is about $expected.
     *
     * @param float   $number
     * @param float   $expected
     * @param float   $delta    The delta tolerance.
     * @return boolean
     */
    protected function isAbout(float $number, float $expected, float $delta = 1): bool
    {
        return $number >= $expected - abs($delta) && $number <= $expected + abs($delta);
    }
}