<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders;

use MarcoConsiglio\Ephemeris\Parsers\Strategies\Strategy;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\BuilderStrategy;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Ephemeris\Traits\WithFuzzyLogic;

abstract class StrategyTestCase extends TestCase
{
    use WithFuzzyLogic;

    /**
     * The sampling rate of the ephemeris expressed in minutes 
     * per each step of the ephemeris response.
     *
     * @var integer
     */
    protected int $sampling_rate;

    /**
     * The angular neighborhood within which to accept a record.
     * 
     * It represents the maximum error accepted to select some
     * angular ephemeris value and discard others.  
     *
     * @var float
     */
    protected float $delta;

    /**
     * A fake daily speed of the record expressed in decimal degrees per day.
     *
     * @var float
     */
    protected float $daily_speed;

    /**
     * The strategy class name.
     *
     * @var string
     */
    protected string $tested_class;

    /**
     * The record type that the
     * strategy accept.
     *
     * @var string
     */
    protected string $record_class;

    /**
     * The strategy name.
     *
     * @var string
     */
    protected string $strategy_basename;

    /**
     * The interface implemented in concrete strategies.
     *
     * @var string
     */
    protected string $strategy_interface = BuilderStrategy::class;

    /**
     * The abstract class extended by a concrete strategy.
     *
     * @var string
     */
    protected string $abstract_strategy = Strategy::class;
    

    /**
     * The strategy being tested.
     *
     * @var BuilderStrategy
     */
    protected BuilderStrategy $strategy;

    /**
     * A testing date.
     *
     * @var SwissEphemerisDateTime
     */
    protected SwissEphemerisDateTime $date;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->date = SwissEphemerisDateTime::create(2000);
        $this->strategy_basename = class_basename($this->tested_class);
    }
    /**
     * Assert $expected_record equals the $actual_record.
     *
     * @param mixed $expected_record
     * @param mixed $actual_record
     * @return void
     */
    protected function assertRecordFound($expected_record, $actual_record)
    {
        $this->assertInstanceOf($this->record_class, $actual_record, <<<TEXT
The {$this->strategy_basename} strategy must find an instance of type {$this->record_class} with delta {$this->delta}° and sampling rate {$this->sampling_rate} min.
The accepted record should be:
$expected_record
TEXT
        );
        $this->assertObjectEquals($expected_record, $actual_record, "equals",
            "The $this->strategy_basename strategy failed to find the correct record."
        );
    }

    /**
     * Asssert the actual record is null.
     *
     * @param mixed $actual_record
     * @return void
     */
    protected function assertRecordNotFound($actual_record)
    {
        $this->assertNull($actual_record, <<<TEXT
The {$this->strategy_basename} strategy accepted a record that must be rejected with delta {$this->delta}° and sampling rate {$this->sampling_rate} min.
The record to be rejected is:
$actual_record
TEXT
        );
    }
}