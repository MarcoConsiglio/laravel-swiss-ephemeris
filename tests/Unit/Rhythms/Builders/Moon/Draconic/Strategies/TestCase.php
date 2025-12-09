<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Draconic\Strategies;

use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Draconic\Node;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\MoonStrategyTestCase;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\StrategyTestCase;

abstract class TestCase extends MoonStrategyTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->tested_class = Node::class;
        $this->record_class = DraconicRecord::class;
        parent::setUp();
    }

    protected function getNorthNodeRecord(): DraconicRecord
    {
        return new DraconicRecord(
            $this->date, 
            $this->getRandomAngle(),
            $this->getRandomAngle(),
            $this->getRandomMo
        );
    }
}