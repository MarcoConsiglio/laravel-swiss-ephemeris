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
     */
    public function __construct(CarbonInterface $date)
    {
        $this->date = $date;
    }
    
    /**
     * Evaluates the constraint for parameter $other. Return true if the
     * constraint is met, false otherwise.
     *
     * This method can be overridden to implement the evaluation algorithm.
     */
    #[\Override]
    protected function matches($other): bool
    {
        return $this->date->equalTo($other);
    }

    /**
     * Return the description of the failure.
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
    #[\Override]
    protected function failureDescription($other): string
    {
       return parent::failureDescription($other->toDateTimeString());
    }

    /**
     * Return a string representation of the object.
     */
    public function toString(): string
    {
        return "equals '$this->date'";
    }
}