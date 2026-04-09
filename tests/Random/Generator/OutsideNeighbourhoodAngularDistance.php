<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random\Generator;

use MarcoConsiglio\Ephemeris\Tests\Random\AngularDistanceRange;
use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Goniometry\Random\Generator\Angle as AngleGenerator;

class OutsideNeighbourhoodAngularDistance extends AngleGenerator
{
    public function generate(int $precision = PHP_FLOAT_DIG): Angle
    {
        $this->validate();
        if ($this->generator->boolean())
            return Angle::createFromDecimal(
                $this->generator->randomFloat(
                    $precision,
                    $this->range->end,
                    AngularDistanceRange::max()
                )
            );
        else
            return Angle::createFromDecimal(
                $this->generator->randomFloat(
                    $precision,
                    AngularDistanceRange::min(),
                    $this->range->start
                )
            );
    }
}