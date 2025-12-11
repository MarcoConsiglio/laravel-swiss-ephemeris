<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\SynodicRhythm;

use InvalidArgumentException;
use stdClass;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\BuilderTestCase;
use MarcoConsiglio\Goniometry\Angle;

#[TestDox("The Moon\SynodicRhythm\FromRecords builder")]
#[CoversClass(FromRecords::class)]
#[UsesClass(Angle::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[UsesClass(SynodicRhythmRecord::class)]
class FromRecordsTest extends BuilderTestCase
{
    #[TestDox("can build a Moon\SynodicRhythm collection from Moon\SynodicRhythmRecord instances.")]
    public function test_build_synodic_rhythm_from_records()
    {
        // Arrange in setUp()
        $builder_class = $this->getBuilderClass();
        $record_class = SynodicRhythmRecord::class;
        for ($i=0; $i < 2; $i++) { 
            $records[$i] = new SynodicRhythmRecord(
                $this->getRandomSwissEphemerisDateTime(),
                $this->getRandomAngle(180),
                $this->getRandomMoonDailySpeed()
            );
        }
        
        // Act
        $builder = new $builder_class($records);
        $this->checkBuilderInterface(Builder::class, $builder);
        $collection = $builder->fetchCollection();

        // Assert
        $this->assertIsArray($collection,
            $this->methodMustReturn($builder_class, "fetchCollection", "array")
        );       
        $this->assertContainsOnlyInstancesOf($record_class, $collection,
            $this->iterableMustContains("array", $record_class)
        ); 
    }

    #[TestDox("cannot build a Moon\SynodicRhythm collection without Moon\SynodicRhythmRecord instances.")]
    public function test_from_records_builder_wants_synodic_rhythm_records()
    {
        // Arrange
        $builder_class = $this->getBuilderClass();
        $record_class = SynodicRhythmRecord::class;
        $data = [new stdClass, new stdClass];

        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The $builder_class builder must have an array of $record_class instances.");

        // Act
       new $builder_class($data);
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
