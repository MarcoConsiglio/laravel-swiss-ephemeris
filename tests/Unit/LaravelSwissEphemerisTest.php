<?php

namespace MarcoConsiglio\Ephemeris\Tests\Unit;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;
use MarcoConsiglio\Ephemeris\Tests\TestCase;

class LaravelSwissEphemerisTest extends TestCase
{
    const LIB_DATE_FORMAT = "d.m.Y";

    /**
     * The underlaying swiss ephemeris library.
     *
     * @var \MarcoConsiglio\Ephemeris\LaravelSwissEphemeris
     */
    protected $ephemeris;

    public function setUp(): void
    {
        $this->ephemeris = new LaravelSwissEphemeris(
            config("ephemeris.latitude"), 
            config("ephemeris.longitude"),
            config("ephemeris.timezone")
        );
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_moon_synodic_rhythm()
    {
        $response = $this->ephemeris->getMoonSynodicRhythm(
            (new Carbon)->format(self::LIB_DATE_FORMAT)
        );
        $this->assertTrue(true);
    }
}
