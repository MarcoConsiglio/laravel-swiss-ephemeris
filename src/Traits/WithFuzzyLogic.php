<?php
namespace MarcoConsiglio\Ephemeris\Traits;

use InvalidArgumentException;
use MarcoConsiglio\Goniometry\Angle;
use RoundingMode;

/**
 * Support for fuzzy logic.
 */
trait WithFuzzyLogic
{
    /**
     * Check if a $number is almost equal to $expected.
     *
     * @param float   $number   First operand.
     * @param float   $expected Second operand.
     * @param float   $delta    The delta tolerance at which the condition is true.
     * @return boolean
     */
    protected function isAbout(float $number, float $expected, float $delta): bool
    {
        [$min, $max] = $this->getDeltaExtremes($delta, $number);
        return $expected >= $min && $expected <= $max;
    }

    /**
     * Check if a $number is almost equal to $expected considering
     * $number like an absolute angular value, that is the minimum
     * value is 0° and the maximum value is 360°.
     *
     * @param float $number
     * @param float $expected
     * @param float $delta
     * @return boolean
     */
    protected function isAboutAbsolute(float $number, float $expected, float $delta): bool
    {
        [$min, $max] = $this->getAbsDeltaExtremes($delta, $number);
        if ($min > $max) {
            return (
                ($number >= $min && $number <= Angle::MAX_DEGREES) ||
                ($number >= 0 && $number <= $max)
            );
        } else return $expected >= $min && $expected <= $max;
    }

    /**
     * Check that $alpha is nearly equal to $beta, 
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
     * Calculate the min and max extremes for a fuzzy condition with angular values.
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
        $delta = abs($delta);
        $delta = $this->normalizeAngularValue($delta, $limit);
        if ($limit == null) $limit = 360;
        return [
            $this->getMinDeltaExtremes($number, $delta, $limit),
            $this->getMaxDeltaExtremes($number, $delta, $limit)
        ];
    }    

    /**
     * Calculate the absolute min and max extremes for a fuzzy condition with angular values.
     *
     * @param float $delta The neighborhood.
     * @param float $number The central point of the neighborhood.
     * @return float[] The first element is the minimum, the second element is the maximum.
     */
    protected function getAbsDeltaExtremes(float $delta, float $number): array
    {
        $number = abs($number);
        $this->checkIsAngularValue($number);
        return [
            $this->getAbsMinDeltaExtremes($number, $delta),
            $this->getAbsMaxDeltaExtremes($number, $delta)
        ];
    }    

    /**
     * Calculate the lower extreme of the $delta angle,
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
        return $this->normalizeAngularValue($number - $this->getEpsilon($delta), $limit);
    }

    /**
     * Calculate the lower extreme of the $delta angle,
     * with the center being $number.
     *
     * @param float $number
     * @param float $delta
     * @return float
     */
    private function getAbsMinDeltaExtremes(float $number, float $delta): float
    {
        $delta = abs($delta);
        $min = $number - $this->getEpsilon($delta);
        return $this->toAbsoluteAngularValue($min);
    }

    /**
     * Calculate the higher extreme of the $delta angle,
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
        return $this->normalizeAngularValue($number + $this->getEpsilon($delta), $limit);
    }
    
    /**
     * Calculate the higher extreme of the $delta angle,
     * with the center being $number.
     *
     * @param float $number
     * @param float $delta
     * @return float
     */
    private function getAbsMaxDeltaExtremes(float $number, float $delta): float
    {
        $delta = abs($delta);
        $max = $number + $this->getEpsilon($delta);
        return $this->toAbsoluteAngularValue($max);
    }

    /**
     * Return the epsilon relative error value,
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
     * Transform an $angle value maintaing it between 
     * $limit° or 360° if $limit is not specifified.
     *
     * @param float $angle
     * @param float|null|null $limit
     * @return float
     */
    protected function normalizeAngularValue(float $angle, float|null $limit = null): float
    {
        if ($limit !== null) {
            $limit = abs($limit);
            if ($angle < -$limit) return -$limit;
            if ($angle > $limit) return $limit;
            return $angle;
        } else {
            if ($angle < -Angle::MAX_DEGREES) return -Angle::MAX_DEGREES;
            if ($angle > Angle::MAX_DEGREES) return Angle::MAX_DEGREES;
            return $angle;
        }
    }

    /**
     * Calculate the min and max angular extremes for a fuzzy condition.
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

    /**
     * Transform an angular value to an absolute value.
     * 
     * Warning! This is not the same as the abs() function.
     *
     * @param float $angle
     * @return float
     */
    protected function toAbsoluteAngularValue(float $angle): float
    {
        if ($angle < 0) return Angle::MAX_DEGREES + $angle;
        if ($angle > Angle::MAX_DEGREES) return $angle -  Angle::MAX_DEGREES;
        return $angle;
    }

    protected function isAbsoluteAngularValue(float $angle): bool
    {
        return $angle >= 0 && $angle <= Angle::MAX_DEGREES;
    }

    protected function checkIsAngularValue(float $angle): void
    {
        if (! $this->isAbsoluteAngularValue(abs($angle)))
            throw new InvalidArgumentException("$angle\° is not an acceptable angular value.");
    }
}