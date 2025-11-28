<?php
namespace MarcoConsiglio\Ephemeris\Traits;

use MarcoConsiglio\Goniometry\Angle;
use RoundingMode;

/**
 * Support for fuzzy logic.
 */
trait WithFuzzyLogic
{
    /**
     * It checks if a $number is almost equal to $expected.
     *
     * @param float   $number   First operand.
     * @param float   $expected Second operand.
     * @param float   $delta    The delta tolerance at which the condition is true.
     * @return boolean
     */
    protected function isAbout(float $number, float $expected, float $delta): bool
    {
        $epsilon = abs($delta) / 2;
        return $number >= $expected - $epsilon && $number <= $expected + $epsilon;
    }

    /**
     * It checks that $alpha is nearly equal to $beta, 
     * taking into account an angular neighborhood of $delta.
     *
     * @param Angle $alfa The first angle operand.
     * @param Angle $beta The second angle operand.
     * @param Angle $delta The delta tolerance at which the condition is true.
     * @return boolean
     */
    protected function isAboutAngle(Angle $alfa, Angle $beta, Angle $delta){
        [$min, $max] = $this->getAngularDeltaExtrems($delta, $alfa);
        $beta = $beta->toDecimal();
        return $min <= $beta && $max >= $beta;
    }

    /**
     * Calculates the min and max extremes for a fuzzy condition with angular values.
     *
     * @param float $delta The neighborhood.
     * @param float $number The central point of the neighborhood.
     * @param float|null $limit If setted, it limits the lower extreme to -$limit and the higher
     * extreme to +$limit. Useful when dealing with synodic rhythms which angular distance never 
     * exedes +/-180°.
     * @return float[] The first element is the minimum, the second element is the maximum.
     */
    protected function getDeltaExtremes(float $delta, float $number, float|null $limit = null): array
    {
        $delta = $this->normalizeAngularValue(abs($delta), $limit);
        if ($limit == null) $limit = 360;
        return [
            $this->getMinDeltaExtremes($number, $delta, $limit),
            $this->getMaxDeltaExtremes($number, $delta, $limit)
        ];
    }

    /**
     * It calculates the lower extreme of the $delta angle,
     * with the center being $number.
     *
     * @param float $number
     * @param float $delta
     * @param float|null|null $limit
     * @return float
     */
    private function getMinDeltaExtremes(float $number, float $delta, float|null $limit = null): float
    {
        $delta = abs($delta);
        if ($limit !== null) {
            return $this->normalizeAngularValue($number - $this->getEpsilon($delta), $limit);
        } else {
            return $this->normalizeAngularValue($number - $this->getEpsilon($delta));
        }
    }

    /**
     * It calculates the higher extreme of the $delta angle,
     * with the center being $number.
     *
     * @param float $number
     * @param float $delta
     * @param float|null|null $limit
     * @return float
     */
    private function getMaxDeltaExtremes(float $number, float $delta, float|null $limit = null): float
    {
        $delta = abs($delta);
        if ($limit !== null) {
            return $this->normalizeAngularValue($number + $this->getEpsilon($delta), $limit);
        } else {
            return $this->normalizeAngularValue($number + $this->getEpsilon($delta));
        }
    }

    /**
     * It returns the epsilon relative error value,
     * based on $delta.
     *
     * @param float $delta
     * @return float
     */
    private function getEpsilon(float $delta): float
    {
        return $delta / 2;
    }

    /**
     * It transform an $angle value maintaing it between 
     * $limit° or 360° if $limit is not specifified.
     *
     * @param float $angle
     * @param float|null|null $limit
     * @return float
     */
    private function normalizeAngularValue(float $angle, float|null $limit = null): float
    {
        if ($limit !== null) {
            $limit = abs($limit);
            if ($angle < -$limit) return -$limit;
            if ($angle > $limit) return $limit;
            return $angle;
        } else {
            if ($angle < -360) return -360;
            if ($angle > 360) return 360;
            return $angle;
        }
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