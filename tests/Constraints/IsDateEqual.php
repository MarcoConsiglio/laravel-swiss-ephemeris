<?php
namespace MarcoConsiglio\Ephemeris\Tests\Constraints;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * This Constraint is used to assert that a date is equal to another.
 */
class IsDateEqual extends Constraint
{
    /**
     * The date to be compared with an $other date.
     *
     * @var CarbonInterface
     */
    protected CarbonInterface $date;

    /**
     * Construct the constraint with a $date.
     *
     * @param CarbonInterface $date
     */
    public function __construct(CarbonInterface $date)
    {
        $this->date = $date;
    }
    
    /**
     * Evaluates the constraint for parameter $other. Returns true if the
     * constraint is met, false otherwise.
     *
     * This method can be overridden to implement the evaluation algorithm.
     * 
     * @return bool
     */
    protected function matches($other): bool
    {
        return $this->date->equalTo($other);
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

    /**
     * Returns a string representation of the object.
     * 
     * @return string
     */
    public function toString(): string
    {
        return "equals '$this->date'";
    }
}