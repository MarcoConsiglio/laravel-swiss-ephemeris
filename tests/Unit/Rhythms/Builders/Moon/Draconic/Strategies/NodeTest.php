<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Draconic\Strategies;

use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Draconic\Node;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Goniometry\Angle;

#[TestDox("The Moon Node strategy")]
#[CoversClass(Node::class)]
class NodeTest extends TestCase
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

    #[TestDox("can find when the Moon is in its north node.")]
    public function test_can_find_a_north_node()
    {
        // Arrange
        $north_node_record = $this->getRandomNorthNodeRecord();
        $strategy = $this->makeStrategy($north_node_record);

        // Act
        $accepted_record = $strategy->found();

        // Assert
        $this->assertRecordFound($north_node_record, $accepted_record);
    }

    #[TestDox("can find when the Moon is in its south node.")]
    public function test_can_find_a_south_node()
    {
        // Arrange
        $south_node_record = $this->getRandomSouthNodeRecord();
        $non_node_record = $this->getRandomNonNodeRecord();
        $strategy_1 = $this->makeStrategy($south_node_record);
        $strategy_2 = $this->makeStrategy($non_node_record);

        // Act
        $accepted_record = $strategy_1->found();

        // Assert
        $this->assertRecordFound($south_node_record, $accepted_record);
        $this->assertNull($strategy_2->found());
    }

    /**
     * Construct the strategy to test.
     *
     * @param DraconicRecord $record
     * @return Node
     */
    protected function makeStrategy(DraconicRecord $record): Node
    {
        return new $this->tested_class($record, $this->sampling_rate);
    }
}