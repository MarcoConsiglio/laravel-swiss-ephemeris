<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use MarcoConsiglio\Ephemeris\Tests\TestCase;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;

class LaravelSwissEphemerisTest extends TestCase
{
    public function setUp(): void
    {
        $this->ephemeris = new LaravelSwissEphemeris(
            config("ephemeris.latitude"), 
            config("ephemeris.longitude"),
            config("ephemeris.timezone")
        );
    }

}
