<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Anomalistic\Perigees;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Perigees\FromRecords;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\BuilderTestCase;
use stdClass;

#[CoversClass(FromRecords::class)]
#[TestDox("The Moon\Perigees\FromRecords builder")]
class FromRecordsTest extends BuilderTestCase
{
    #[TestDox("can build an Perigees collection from PerigeeRecord instances.")]
    public function test_builds_apogees_collection_from_records()
    {
        // Arrange
        /** @var PerigeeRecord&MockObject $record_1 */
        /** @var PerigeeRecord&MockObject $record_2 */
        $record_1 = $this->getMocked(PerigeeRecord::class);
        $record_2 = $this->getMocked(PerigeeRecord::class);
        $builder = new FromRecords([$record_1, $record_2]);

        // Act
        $records = $builder->fetchCollection();

        // Assert
        $this->assertContainsOnlyInstancesOf(PerigeeRecord::class, $records,
            $this->iterableMustContains("array", PerigeeRecord::class)
        );
        $this->assertCount(2, $records);
    }

    #[TestDox("cannot build a Moon\Perigees collection without Moon\ApogeeRecords instances.")]
    public function test_from_records_builder_wants_apogee_records()
    {
        // Arrange
        $record_1 = $this->getMocked(stdClass::class);
        $record_2 = $this->getMocked(stdClass::class);
        $builder_class = FromRecords::class;
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The builder $builder_class must have an array of ".PerigeeRecord::class.".");
       
        // Act
        $builder = new FromRecords([$record_1, $record_2]);

    }

    /**
     * Get the current SUT class.
     * 
     * @return string
     */
    protected function getBuilderClass(): string
    {
        return FromRecords::class;
    }
}