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

    /**
     * Calculates the min and max extremes for a fuzzy condition.
     *
     * @param float $delta
     * @param float $number
     * @return array The first element is the minimum, the second element is the maximum.
     */
    protected function getDeltaExtremes(float $delta, float $number): array
    {
        $min = $number - abs($delta);
        $max = $number + abs($delta);
        if ($min < -180) {
            $min = -180;
        } 
        if ($max > 180) {
            $max = 180;
        }
        return [
            $number - abs($delta), 
            $number + abs($delta)
        ];
    }
}