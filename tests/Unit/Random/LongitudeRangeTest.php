<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random;

use MarcoConsiglio\Ephemeris\Tests\Random\LongitudeRange;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[TestDox("The LongitudeRange")]
#[CoversClass(LongitudeRange::class)]
class LongitudeRangeTest extends TestCase
{
    #[TestDox("express a longitude range from 0° to 360°.")]
    public function test_extremes(): void
    {
        // Arrange
        $min = 0;
        $max = NextFloat::before(360);

        // Act & Assert
        $this->assertEquals($min, LongitudeRange::min());
        $this->assertEquals($max, LongitudeRange::max());
    }
}