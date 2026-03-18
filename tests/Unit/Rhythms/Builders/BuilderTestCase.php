<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders;

use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;

abstract class BuilderTestCase extends TestCase
{    
    /**
     * The file with a raw ephemeris response.
     *
     * @var string
     */
    protected string $response_file;

    /**
     * The sampling rate of the ephemeris expressed 
     * in minutes per each step of the ephemeris response.
     *
     * @var integer
     */
    protected int $sampling_rate;

    /**
     * Get the current SUT class.
     */
    protected abstract function getBuilderClass(): string;

    /**
     * This is a Guard Assertion that checks if the builder
     * implements a specific interface.
     */
    protected function checkBuilderInterface(string $builder_interface, object $builder): void
    {
        $builder_class = $builder::class;
        $this->assertInstanceOf($builder_interface, $builder, 
            "The $builder_class builder must implement the $builder_interface interface."
        );
    }
}