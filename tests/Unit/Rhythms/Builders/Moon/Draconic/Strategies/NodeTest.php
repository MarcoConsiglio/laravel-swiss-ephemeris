<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Draconic\Strategies;

use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Draconic\Node;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\MoonStrategyTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The Moon\Node strategy")]
#[CoversClass(Node::class)]
class NodeTest extends TestCase
{

    #[TestDox("can find the Moon in north node.")]
    public function test_can_find_moon_apogees()
    {
        // // Arrange
        // $apogee_record = $this->getApogeeRecord();
        // $non_apogee_record = $this->getNonApogeeRecord();
        // $strategy_1 = $this->makeStrategy($apogee_record);
        // $strategy_2 = $this->makeStrategy($non_apogee_record);
        // $this->checkStrategyImplementsInterface($strategy_1);
        // $this->checkStrategyExtendsAbstract($strategy_1);

        // // Act
        // $accepted_record = $strategy_1->found();
        // $not_accepted_record = $strategy_2->found();
        
        // // Assert
        // $this->assertRecordFound($apogee_record, $accepted_record);
        // $this->assertRecordNotFound($not_accepted_record);
    }
}