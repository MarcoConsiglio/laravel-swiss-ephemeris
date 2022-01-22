<?php
namespace MarcoConsiglio\Ephemeris\Tests\Constraints;

use Carbon\Carbon;
use PHPUnit\Framework\Constraint\Constraint;

class IsDateEqual extends Constraint
{
    protected int $year = 1;

    protected int $month = 1;

    protected int $day = 1;

    protected int $hour = 0;
    
    protected int $minute = 0;

    protected int $second = 0;

    public function __construct($year, $month, $day, $hour, $minute, $second)
    {
        $this->year = $year;
        $this->month = $month;
        $this->day = $day;
        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
    }
    
    protected function matches($other): bool
    {
        if ($other->year != $this->year) {
            return false;
        }
        if ($other->month != $this->month) {
            return false;
        }
        if ($other->day != $this->day) {
            return false;
        }
        if ($other->hour != $this->hour) {
            return false;
        }
        if ($other->minute != $this->minute) {
            return false;
        }
        if ($other->second != $this->second) {
            return false;
        }
        return true;
    }

    /**
     * Returns the description of the failure.
     *
     * The beginning of failure messages is "Failed asserting that" in most
     * cases. This method should return the second part of that sentence.
     *
     * To provide additional failure information additionalFailureDescription
     * can be used.
     *
     * @param mixed $other evaluated value or object
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    protected function failureDescription($other): string
    {
       return parent::failureDescription($other->toDateTimeString());
    }

    public function toString(): string
    {
        $expected_date = Carbon::create(
            $this->year,
            $this->month, 
            $this->day,
            $this->hour,
            $this->minute,
            $this->second
        );
        return "equals '$expected_date'";
    }
}