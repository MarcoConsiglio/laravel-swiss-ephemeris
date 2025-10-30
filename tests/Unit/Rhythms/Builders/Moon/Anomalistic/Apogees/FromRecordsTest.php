<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Anomalistic\Apogees;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Apogees\FromRecords;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\BuilderTestCase;
use stdClass;

#[CoversClass(FromRecords::class)]
#[TestDox("The Moon\Apogees\FromRecords builder")]
class FromRecordsTest extends BuilderTestCase
{
    #[TestDox("can build an Apogees collection from ApogeeRecord instances.")]
    public function test_builds_apogees_collection_from_records()
    {
        // Arrange
        /** @var ApogeeRecord&MockObject $record_1 */
        /** @var ApogeeRecord&MockObject $record_2 */
        $record_1 = $this->getMocked(ApogeeRecord::class);
        $record_2 = $this->getMocked(ApogeeRecord::class);
        $builder = new FromRecords([$record_1, $record_2]);

        // Act
        $records = $builder->fetchCollection();

        // Assert
        $this->assertContainsOnlyInstancesOf(ApogeeRecord::class, $records,
            $this->iterableMustContains("array", ApogeeRecord::class)
        );
        $this->assertCount(2, $records);
    }

    #[TestDox("cannot build a Moon\Apogees collection without Moon\ApogeeRecords instances.")]
    public function test_from_records_builder_wants_apogee_records()
    {
        // Arrange
        $record_1 = $this->getMocked(stdClass::class);
        $record_2 = $this->getMocked(stdClass::class);
        $builder_class = FromRecords::class;
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The builder $builder_class must have an array of ".ApogeeRecord::class.".");
       
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