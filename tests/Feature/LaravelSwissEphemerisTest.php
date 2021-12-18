<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use MarcoConsiglio\Ephemeris\Tests\TestCase;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm;
use MarcoConsiglio\Trigonometry\Angle;

class LaravelSwissEphemerisTest extends TestCase
{
    public function test_synodic_rhythm()
    {
        // Arrange
        $angular_distance = "angular_distance";
        $timestamp = "timestamp";
        $name = "name";
        $synodic_rhythm = "percentage";

        // Act
        $response = $this->ephemeris->getMoonSynodicRhythm((new Carbon)->format("d.m.Y"), 1);

        // Assert
        // assertArrayKey() method is not reliable.
        $this->assertInstanceOf(SynodicRhythm::class, $response, 
            "The response should be a Collection instance, but ".gettype($response)." found.");
        // // $this->assertArrayNotHasKey($name, $response->all(), 
        // //     "The response must not contain '$name' key.");
        // $this->assertCount(24, $response, 
        //     "The response should have 24 records (1 per hour in a day). This one has ".count($response)." records.");
        // $this->assertContainsOnlyInstancesOf(Carbon::class, $response->pluck($timestamp)->all(), 
        //     "All '$timestamp' elements should be Carbon instances.");
        // $this->assertContainsOnlyInstancesOf(Angle::class, $response->pluck($angular_distance)->all(), 
        //     "All '$angular_distance' should be Angle instances.");
        // // $this->assertArrayHasKey($synodic_rhythm, $response->all(),
        // //     "The response must contain the '$synodic_rhythm' column.");
        // $this->assertContainsOnly("float", $response->pluck($synodic_rhythm)->all(),
        //     "All '$synodic_rhythm' elements should be float type.");
    }

}
