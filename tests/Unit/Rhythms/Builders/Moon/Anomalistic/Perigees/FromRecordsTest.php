<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Anomalistic\Perigees;

use InvalidArgumentException;
use stdClass;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder as BuilderInterface;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Perigees\FromRecords;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\BuilderTestCase;

#[CoversClass(FromRecords::class)]
#[TestDox("The Moon Perigees\FromRecords builder")]
class FromRecordsTest extends BuilderTestCase
{
    #[TestDox("can build an Perigees collection from PerigeeRecord instances.")]
    public function test_builds_apogees_collection_from_records(): void
    {
        // Arrange
        $record_class = PerigeeRecord::class;
        $builder_class = $this->getBuilderClass();
        /** @var PerigeeRecord&MockObject $record_1 */
        /** @var PerigeeRecord&MockObject $record_2 */
        $record_1 = $this->getMocked($record_class);
        $record_2 = $this->getMocked($record_class);
        $builder = new $builder_class([$record_1, $record_2]);
        $this->checkBuilderInterface(BuilderInterface::class, $builder);

        // Act
        $records = $builder->fetchCollection();

        // Assert
        $this->assertContainsOnlyInstancesOf($record_class, $records,
            $this->iterableMustContains("array", $record_class)
        );
        $this->assertCount(2, $records);
    }

    #[TestDox("cannot build a Moon\Perigees collection without Moon\ApogeeRecords instances.")]
    public function test_from_records_builder_wants_perigee_records(): void
    {
        // Arrange
        $record_1 = $this->getMocked(stdClass::class);
        $record_2 = $this->getMocked(stdClass::class);
        $builder_class = $this->getBuilderClass();
        $record_class = PerigeeRecord::class;
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The $builder_class builder must have an array of $record_class instances.");
       
        // Act
        new FromRecords([$record_1, $record_2]);
    }

    /**
     * Get the current SUT class.
     */
    protected function getBuilderClass(): string
    {
        return FromRecords::class;
    }
}