<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random;

use MarcoConsiglio\Ephemeris\Tests\Random\LatitudeRange;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[TestDox("The LatitudeRange")]
#[CoversClass(LatitudeRange::class)]
class LatitudeRangeTest extends TestCase
{
    #[TestDox("express a latitude range from -90° to +90°.")]
    public function test_extremes(): void
    {
        // Act & Assert
        $this->assertEquals(-90, LatitudeRange::min());
        $this->assertEquals(+90, LatitudeRange::max());
    }
}