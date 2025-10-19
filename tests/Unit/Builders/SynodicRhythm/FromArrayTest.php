<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit\Builders\MoonSynodicRhythm;

use Carbon\Carbon;
use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonSynodicRhythm\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Tests\Traits\WithReflection;
use MarcoConsiglio\Ephemeris\Tests\Unit\Builders\BuilderTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The MoonSynodicRhythm/FromArray builder")]
#[CoversClass(FromArray::class)]
class FromArrayTest extends BuilderTestCase
{
    use WithReflection;

    /**
     * Test data.
     *
     * @var array
     */
    protected array $data;

    /**
     * This method is called before each test.
     * 
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $t1 = (new Carbon())->hour(12)->minutes(0)->seconds(0);
        $t2 = $t1->copy()->addHour();
        $this->data = [
            0 => [
                "timestamp" => $t1->format("d.m.Y H:m:i")." UT",
                "angular_distance" => fake()->randomFloat(1, -360, 360)
            ],
            1 => [
                "timestamp" => $t2->format("d.m.Y H:m:i")." UT",
                "angular_distance" => fake()->randomFloat(1, -360, 360)
            ]
        ];
    }

    #[TestDox("can build an array of MoonSynodicRhythmRecords starting from an array of raw ephemeris data.")]
    public function test_build_synodic_rhythm_from_array()
    {
        // Arrange

        // Act
        /** @var \MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonSynodicRhythm\FromArray $builder */
        $builder = new FromArray($this->data);
        $synodic_rhythm_records = $builder->fetchCollection();

        // Assert
        $this->assertIsArray($synodic_rhythm_records, 
            "The FromArray builder must produce an array.");
        $this->assertContainsOnlyInstancesOf(MoonSynodicRhythmRecord::class, $synodic_rhythm_records, 
            "The FromArray builder must contains only MoonSynodicRhythmRecord(s).");
        $this->assertCount(count($this->data), $synodic_rhythm_records, 
            "The FromArray builder must produce the same ammount of records as the input.");
    }

    #[TestDox("require the 'timestamp' ephemeris column.")]
    public function test_from_array_builder_wants_timestamp_column()
    {
        /**
         * Missing key "timestamp"
         */
        // Arrange
        unset($this->data[0]["timestamp"]);
        
        // Act & Assert
        $this->expectException(InvalidArgumentException::class);
        $builder = new FromArray($this->data);
        $builder->validateData();
    }

    #[TestDox("require the 'angular_distance' ephemeris column")]
    public function test_from_array_builder_wants_angular_distance_column()
    {   
        /**
         * Missing key "angular_distance"
         */
        // Arrange
        unset($this->data[0]["angular_distance"]);

        // Act & Assert
        $this->expectException(InvalidArgumentException::class);
        $builder = new FromArray($this->data);
        $builder->validateData();
    }

    #[TestDox("cannot build a MoonSynodicRhythm with an empty array.")]
    public function test_validate_data_method()
    {
        // Act
        $builder = new FromArray([]);
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The FromArray builder cannot work with an empty array.");
        
        // Arrange
        $builder->validateData();
    }

    /**
     * Returns the FromArray builder class.
     *
     * @return string
     */
    protected function getBuilderClass(): string
    {
        return FromArray::class;
    }
}
