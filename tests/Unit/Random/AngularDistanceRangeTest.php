<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random;

use MarcoConsiglio\Ephemeris\Tests\Random\AngularDistanceRange;
use MarcoConsiglio\FakerPhpNumberHelpers\NextFloat;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;

#[CoversClass(AngularDistanceRange::class)]
#[TestDox("The AngularDistanceRange")]
class AngularDistanceRangeTest extends TestCase
{
    #[TestDox("express an angular distance range from -180° to +180°.")]
    public function test_extremes(): void
    {
        // Arrange
        $min = NextFloat::after(-180);
        $max = NextFloat::before(180);

        // Act & Assert
        $this->assertEquals($min, AngularDistanceRange::min());
        $this->assertEquals($max, AngularDistanceRange::max());
    }
}