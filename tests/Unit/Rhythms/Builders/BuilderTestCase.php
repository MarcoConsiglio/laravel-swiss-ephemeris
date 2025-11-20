<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders;

use PHPUnit\Framework\MockObject\MockObject;
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
     * Get the current SUT class.
     * 
     * @return string
     */
    protected abstract function getBuilderClass(): string;
}