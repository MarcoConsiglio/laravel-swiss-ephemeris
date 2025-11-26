<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Anomalistic\Strategies;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Anomalies\Perigee;

#[CoversClass(Perigee::class)]
#[UsesClass(PerigeeRecord::class)]
#[TestDox("The Perigee AnomalisticStrategy")]
class PerigeeStrategyTest extends AnomalisticStrategyTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->tested_class = Perigee::class;
        $this->record_class = PerigeeRecord::class;
        parent::setUp();
    }

    #[TestDox("can find a Moon perigee.")]
    public function test_can_find_moon_perigees()
    {
        // Arrange
        $perigee_record = $this->getPerigeeRecord();
        $non_perigee_record = $this->getNonPerigeeRecord();
        $strategy_1 = $this->makeStrategy($perigee_record);
        $strategy_2 = $this->makeStrategy($non_perigee_record);
        //      Guard Assertions
        $this->assertInstanceOf($this->strategy_interface, $strategy_1, 
            $this->mustImplement($this->tested_class, $this->strategy_interface)
        );
        $this->assertInstanceOf($this->abstract_strategy, $strategy_1, 
            $this->mustExtend($this->tested_class, $this->abstract_strategy)
        );

        // Act
        $accepted_record = $strategy_1->found();
        $not_accepted_record = $strategy_2->found();
        
        // Assert
        $this->assertRecordFound($perigee_record, $accepted_record);
        $this->assertRecordNotFound($not_accepted_record);
    }
}