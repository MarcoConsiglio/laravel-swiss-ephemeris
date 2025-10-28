<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\Moon\Anomalies\Strategies;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Anomalies\Apogee;

#[CoversClass(Apogee::class)]
#[UsesClass(ApogeeRecord::class)]
#[TestDox("The Apogee AnomalisticStrategy")]
class ApogeeStrategyTest extends AnomalisticStrategyTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->tested_class = Apogee::class;
        $this->record_class = ApogeeRecord::class;
        $this->delta = 0.1;
        parent::setUp();
    }

    #[TestDox("can find a Moon apogee.")]
    public function test_can_find_moon_apogees()
    {
        // Arrange
        $apogee_record = $this->getApogeeRecord();
        $non_apogee_record = $this->getNonApogeeRecord(90.0);
        $strategy_1 = $this->makeStrategy($apogee_record);
        $strategy_2 = $this->makeStrategy($non_apogee_record);
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
        $this->assertRecordFound($apogee_record, $accepted_record);
        $this->assertRecordNotFound($not_accepted_record);
    }
}