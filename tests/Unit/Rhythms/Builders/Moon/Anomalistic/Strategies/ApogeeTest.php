<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Anomalistic\Strategies;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Anomalies\Apogee;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Anomalistic\Strategies\TestCase;

#[CoversClass(Apogee::class)]
#[UsesClass(ApogeeRecord::class)]
#[TestDox("The Moon Apogee AnomalisticStrategy")]
class ApogeeTest extends TestCase
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
        parent::setUp();
    }

    #[TestDox("can find a Moon apogee.")]
    public function test_can_find_moon_apogees()
    {
        // Arrange
        $apogee_record = $this->getApogeeRecord();
        $non_apogee_record = $this->getNonApogeeRecord();
        $strategy_1 = $this->makeStrategy($apogee_record);
        $strategy_2 = $this->makeStrategy($non_apogee_record);
        $this->checkStrategyImplementsInterface($strategy_1);
        $this->checkStrategyExtendsAbstract($strategy_1);

        // Act
        $accepted_record = $strategy_1->found();
        $not_accepted_record = $strategy_2->found();
        
        // Assert
        $this->assertRecordFound($apogee_record, $accepted_record);
        $this->assertRecordNotFound($not_accepted_record);
    }
}