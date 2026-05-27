<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Records;

use MarcoConsiglio\Ephemeris\Records\DailySpeed;
use MarcoConsiglio\Ephemeris\Tests\Unit\Records\TestCase as RecordTestCase;
use Override;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The DailySpeed")]
#[CoversClass(DailySpeed::class)]
class DailySpeedTest extends RecordTestCase
{
    protected DailySpeed $daily_speed;

    #[Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->daily_speed = DailySpeed::createFromDecimal(
            $this->randomSexadecimal()
        );
    }

    #[TestDox("can be created from sexadecimal degrees.")]
    public function test_create_from_decimal(): void
    {
        // Assert
        $this->assertInstanceOf(DailySpeed::class, $this->daily_speed);
    }

    #[TestDox("can be casted to string.")]
    public function test_cast_to_string(): void
    {
        // Assert
        $this->assertIsString((string) $this->daily_speed);
    }
}