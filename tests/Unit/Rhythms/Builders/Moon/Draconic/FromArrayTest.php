<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Draconic;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\DraconicRhythm\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\DraconicRhythm;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\FromArrayTestCase;

#[TestDox("The DraconicRhythm FromArray builder")]
#[CoversClass(FromArray::class)]
#[UsesClass(DraconicRhythm::class)]
class FromArrayTest extends FromArrayTestCase
{
    /**
     * Setup the test environment.
     */
    #[\Override]
    public function setUp(): void
    {
        parent::setUp();
        $this->sampling_rate = 60;
    }

    #[TestDox("can build a Moon DraconicRhythm collection.")]
    public function test_build_draconic_rhythm(): void
    {
        // Arrange
        $builder_class = $this->getBuilderClass();
        $builder = new $builder_class($this->data, $this->sampling_rate);

        // Act
        $rhythm = new DraconicRhythm($builder);

        // Assert
        $this->assertContainsOnlyInstancesOf(DraconicRecord::class, $rhythm);
        $this->assertCount(2, $rhythm);
    }

    #[TestDox("require \"astral_object\" column key in its raw data.")]
    public function test_require_astral_object_column(): void
    {
        // Arrange
        $column = "astral_object";
        $builder_class = $this->getBuilderClass();
        unset($this->data[0][$column]);
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($this->getBuilderMissingKeyErrorMessage($builder_class, $column));
        
        // Act
        new $builder_class($this->data, $this->sampling_rate);
    }

    #[TestDox("require \"timestamp\" column key in its raw data.")]
    public function test_require_timestamp_column(): void
    {
        // Arrange
        $column = "timestamp";
        $builder_class = $this->getBuilderClass();
        unset($this->data[0][$column]);
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($this->getBuilderMissingKeyErrorMessage($builder_class, $column));
        
        // Act
        new $builder_class($this->data, $this->sampling_rate);
    }

    #[TestDox("require \"longitude\" column key in its raw data.")]
    public function test_require_longitude_column(): void
    {
        // Arrange
        $column = "longitude";
        $builder_class = $this->getBuilderClass();
        unset($this->data[0][$column]);
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($this->getBuilderMissingKeyErrorMessage($builder_class, $column));
        
        // Act
        new $builder_class($this->data, $this->sampling_rate);
    }

    #[TestDox("require \"daily_speed\" column key in its raw data.")]
    public function test_require_daily_speed_column(): void
    {
        // Arrange
        $column = "daily_speed";
        $builder_class = $this->getBuilderClass();
        unset($this->data[0][$column]);
        
        // Assert
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($this->getBuilderMissingKeyErrorMessage($builder_class, $column));
        
        // Act
        new $builder_class($this->data, $this->sampling_rate);
    }

    /**
     * Get the current SUT class.
     */
    protected function getBuilderClass(): string
    {
        return FromArray::class;
    }

    protected function getRawData(): array
    {
        return [
            0 => [
                "astral_object" => "Moon",
                "timestamp" => "06.03.2002 15:00:00 TT",
                "longitude" => "262.6391284",
                "daily_speed" => "12.8895235"
            ],
            1 => [
                "astral_object" => "true Node",
                "timestamp" => "06.03.2002 15:00:00 TT",
                "longitude" => "83.3604529",
                "daily_speed" => "0.0003887"
            ],
            // Start selection (south node)
            2 => [
                "astral_object" => "Moon",
                "timestamp" => "06.03.2002 16:00:00 TT",
                "longitude" => "263.1758818",
                "daily_speed" => "12.8746426"
            ],
            3 => [
                "astral_object" => "true Node",
                "timestamp" => "06.03.2002 16:00:00 TT",
                "longitude" => "83.3604642",
                "daily_speed" => "0.0001438"
            ],
            // End selection
            4 => [
                "astral_object" => "Moon",
                "timestamp" => "06.03.2002 17:00:00 TT",
                "longitude" => "263.7120178",
                "daily_speed" => "12.8598875"
            ],
            5 => [
                "astral_object" => "true Node",
                "timestamp" => "06.03.2002 17:00:00 TT",
                "longitude" => "83.3604644",
                "daily_speed" => "-0.0001384"
            ],     
            6 => [
                "astral_object" => "Moon",
                "timestamp" => "21.03.2002 7:00:00 TT",
                "longitude" => "80.7645136",
                "daily_speed" => "12.8168975"
            ],
            7 => [
                "astral_object" => "true Node",
                "timestamp" => "21.03.2002 7:00:00 TT",
                "longitude" => "81.4351514",
                "daily_speed" => "-0.0003977"
            ],
            // Start selection (north node)
            8 => [
                "astral_object" => "Moon",
                "timestamp" => "21.03.2002 8:00:00 TT",
                "longitude" => "81.2988484",
                "daily_speed" => "12.8312154"
            ],
            9 => [
                "astral_object" => "true Node",
                "timestamp" => "21.03.2002 8:00:00 TT",
                "longitude" => "81.4351425",
                "daily_speed" => "-0.0000376"
            ],     
            // End selection
            10 => [
                "astral_object" => "Moon",
                "timestamp" => "21.03.2002 9:00:00 TT",
                "longitude" => "81.8337825",
                "daily_speed" => "12.8456591"
            ],   
            11 => [
                "astral_object" => "true Node",
                "timestamp" => "21.03.2002 9:00:00 TT",
                "longitude" => "81.4351478",
                "daily_speed" => "0.0002859"
            ],
        ];
    }
}