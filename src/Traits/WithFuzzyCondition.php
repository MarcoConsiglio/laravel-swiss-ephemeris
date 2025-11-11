<?php
namespace MarcoConsiglio\Ephemeris\Traits;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Builders\FromAngles;
use MarcoConsiglio\Goniometry\Operations\Sum;
use RoundingMode;

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
     * It checks that $alpha is nearly equal to $beta, 
     * taking into account an angular neighborhood of $delta.
     *
     * @param Angle $alfa
     * @param Angle $beta
     * @param Angle $delta
     * @return boolean
     */
    protected function isAboutAngle(Angle $alfa, Angle $beta, Angle $delta){
        [$min, $max] = $this->getAngularDeltaExtrems($delta, $alfa);
        $beta = $beta->toDecimal(PHP_FLOAT_DIG);
        return $min <= $beta && $max >= $beta;
    }

    /**
     * Calculates the min and max extremes for a fuzzy condition.
     *
     * @param float $delta The neighborhood.
     * @param float $number The central point of the neighborhood.
     * @param float|null $limit If setted, it limits the lower extreme to -$limit and the higher
     * extreme to +$limit. Useful when dealing with synodic rhythms.
     * @return float[] The first element is the minimum, the second element is the maximum.
     */
    protected function getDeltaExtremes(float $delta, float $number, float|null $limit = null): array
    {
        $epsilon = round($delta / 2, 4, RoundingMode::HalfTowardsZero);
        $min = $number - abs($epsilon);
        $max = $number + abs($epsilon);
        if ($limit !== null) {
            if ($min < -$limit) {
                $min = -$limit;
            } 
            if ($max > $limit) {
                $max = $limit;
            }
        }
        if ($limit == null) {
            if ($min < 0) return [360 + $min, $max];
            if ($max > 360) return [$min, $max - 360];
        }
        return [$min, $max];
    }

    /**
     * Calculates the min and max angular extremes for a fuzzy condition.
     *
     * @param Angle $delta The neighborhood.
     * @param Angle $angle The central point of the neighborhood.
     * @return float[] the min and max extremes with the center being $angle.
     */
    protected function getAngularDeltaExtrems(Angle $delta, Angle $angle): array
    {
        $epsilon = round(
            $delta->toDecimal(PHP_FLOAT_DIG) / 2,
            PHP_FLOAT_DIG, RoundingMode::HalfTowardsZero
        );
        $angle = $angle->toDecimal(PHP_FLOAT_DIG);
        $min = round($angle - $epsilon, PHP_FLOAT_DIG, RoundingMode::HalfTowardsZero);
        $max = round($angle + $epsilon, PHP_FLOAT_DIG, RoundingMode::HalfTowardsZero);
        return [$min, $max];
    }
}