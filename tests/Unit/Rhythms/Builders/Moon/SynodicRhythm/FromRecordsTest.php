<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\SynodicRhythm;

use InvalidArgumentException;
use stdClass;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder as BuilderInterface;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\BuilderTestCase;
use MarcoConsiglio\Goniometry\Angle;

#[TestDox("The Moon\SynodicRhythm\FromRecords builder")]
#[CoversClass(FromRecords::class)]
#[UsesClass(Angle::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[UsesClass(SynodicRhythmRecord::class)]
class FromRecordsTest extends BuilderTestCase
{
    /**
     * Test data.
     *
     * @var array
     */
    protected array $data;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $t1 = (new SwissEphemerisDateTime)->minutes(0)->seconds(0);
        $t2 = $t1->copy()->addHour();
        $this->data = [
            0 => [
                "timestamp" => $t1->toGregorianTT(),
                "angular_distance" => $this->faker->randomFloat(1, -360, 360)
            ],
            1 => [
                "timestamp" => $t2->toGregorianTT(),
                "angular_distance" => $this->faker->randomFloat(1, -360, 360)
            ]
        ];
    }

    #[TestDox("can build a Moon\SynodicRhythm collection from Moon\SynodicRhythmRecord instances.")]
    public function test_build_synodic_rhythm_from_records()
    {
        // Arrange in setUp()
        $builder_class = $this->getBuilderClass();
        $builder_interface = BuilderInterface::class;
        $record_class = SynodicRhythmRecord::class;
        $records = [];
        foreach ($this->data as $item) {
            $records[] = new SynodicRhythmRecord(
                SwissEphemerisDateTime::createFromSwissEphemerisFormat($item["timestamp"]),
                Angle::createFromDecimal((float) $item["angular_distance"])
            );
        }
        
        // Act
        $builder = new $builder_class($records);
        $collection = $builder->fetchCollection();

        // Assert
        $this->assertInstanceOf($builder_interface, $builder, "The $builder_class builder must implement the $builder_interface interface.");
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
        $data = [new stdClass, new stdClass];

        // Assert
        $this->expectException(InvalidArgumentException::class);

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
