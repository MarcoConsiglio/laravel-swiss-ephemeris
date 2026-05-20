<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Traits;

use MarcoConsiglio\Ephemeris\Records\DailySpeed;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Traits\RandomData;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\AngularDistance;
use MarcoConsiglio\Goniometry\Degrees;
use MarcoConsiglio\Goniometry\SexadecimalDegrees;
use PHPUnit\Framework\Attributes\CoversTrait;

#[CoversTrait(RandomData::class)]
class RandomDataTest extends TestCase
{
    public function test_randomSpeed(): void
    {
        // Arrange
        $class = new class {
            use RandomData;

            public function random(float $min, float $max): float
            {
                $this->setUpFaker();
                return $this->randomSpeed($min, $max);
            }
        };

        // Act
        $speed = $class->random(10, 14);

        // Assert
        $this->assertIsFloat($speed);
        $this->assertGreaterThanOrEqual(10, $speed);
        $this->assertLessThanOrEqual(14, $speed);
    }

    public function test_randomMoonDailySpeed(): void
    {
        // Arrange
        $class =  new class {
            use RandomData;

            public function random(): DailySpeed
            {
                $this->setUpFaker();
                return $this->randomMoonDailySpeed();
            }
        };

        // Act
        $moon_daily_speed = $class->random();

        // Assert
        $this->assertInstanceOf(DailySpeed::class, $moon_daily_speed);
    }

    public function test_randomSamplingRate(): void
    {
        // Arrange
        $class = new class {
            use RandomData;

            public function random(): int
            {
                $this->setUpFaker();
                return $this->randomSamplingRate();
            }
        };

        // Act
        $sampling_rate = $class->random();

        // Assert
        $this->assertIsInt($sampling_rate);
    }

    public function test_randomSwissEphemerisDateTime(): void
    {
        // Arrange
        $class = new class {
            use RandomData;

            public function random(): SwissEphemerisDateTime
            {
                $this->setUpFaker();
                return $this->randomSwissEphemerisDateTime();
            }
        };

        // Act
        $date_time = $class->random();

        // Assert
        $this->assertInstanceOf(SwissEphemerisDateTime::class, $date_time);
    }

    public function test_randomLongitude(): void
    {
        // Arrange
        $class = new class {
            use RandomData;

            public function random(float $min = 0.0, float $max = Degrees::MAX): Angle
            {
                $this->setUpFaker();
                return $this->randomLongitude($min, $max);
            }
        };

        // Act
        $longitude = $class->random();

        // Assert
        $this->assertInstanceOf(Angle::class, $longitude);
    }

    public function test_inaccurateRandomLongitude(): void
    {
        // Arrange
        $class = new class {
            use RandomData;

            public function random(float $center_value, Angle $delta, int $precision = PHP_FLOAT_DIG): Angle
            {
                $this->setUpFaker();
                $this->setDelta($delta);
                return $this->inaccurateRandomLongitude($center_value, $precision);
            }

        };

        // Act
        $longitude = $class->random(
            $this->positiveRandomAngle()->toFloat(),
            $this->positiveRandomAngle(max: 90)
        );

        // Assert
        $this->assertInstanceOf(Angle::class, $longitude);
    }

    public function test_inaccurateRandomLongitudeExceptFor(): void
    {
        // Arrange
        $class = new class {
            use RandomData;

            public function random(float $excluded_center_value, Angle $delta, int $precision = PHP_FLOAT_DIG): Angle
            {
                $this->setUpFaker();
                $this->setDelta($delta);
                return $this->inaccurateRandomLongitudeExceptFor($excluded_center_value, $precision);
            }
        };

        // Act
        $longitude = $class->random(
            $this->positiveRandomAngle()->toFloat(),
            $this->positiveRandomAngle(max: 90)
        );

        // Assert
        $this->assertInstanceOf(Angle::class, $longitude);
    }

    public function test_randomLatitude(): void
    {
        // Arrange
        $class = new class {
            use RandomData;

            public function random(
                float $min = -90.0, 
                float $max = 90.0, 
                int $precision = PHP_FLOAT_DIG
            ): Angle {
                $this->setUpFaker();
                return $this->randomLatitude($min, $max, $precision);
            }
        };

        // Act
        $latitude = $class->random();

        // Assert
        $this->assertInstanceOf(Angle::class, $latitude);
    }

    public function test_inaccurateRandomAngularDistance(): void
    {
        // Arrange
        $class = new class {
            use RandomData;

            public function random(
                float $center_value,
                float|SexadecimalDegrees $delta, 
                int $precision = PHP_FLOAT_DIG
            ): AngularDistance {
                $this->setUpFaker();
                $this->setDelta($delta);
                return $this->inaccurateRandomAngularDistance($center_value, $precision);
            } 
        };
        $center_value = $this->randomAngularDistance();
        $delta = $this->positiveRandomAngle(max: 90);

        // Act
        $angle = $class->random($center_value->toFloat(), $delta->toSexadecimalDegrees());

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $angle);
    }

    public function test_inaccurateRandomAngularDistanceExceptFor(): void
    {
        // Arrange
        $class = new class {
            use RandomData;

            public function random(
                float $excluded_center_value, 
                float|SexadecimalDegrees $delta,
                int $precision = PHP_FLOAT_DIG
            ): AngularDistance {
                $this->setUpFaker();
                $this->setDelta($delta);
                return $this->inaccurateRandomAngularDistanceExceptFor(
                    $excluded_center_value, $precision
                );
            }
        };
        $center_value = $this->randomAngularDistance();
        $epsilon = Angle::createFromValues($this->randomDegrees(max: 45)->value());
        $delta = $epsilon->sum($epsilon);

        // Act
        $angle = $class->random($center_value->toFloat(), $delta->toSexadecimalDegrees());

        // Assert
        $this->assertInstanceOf(AngularDistance::class, $angle);
    }
}