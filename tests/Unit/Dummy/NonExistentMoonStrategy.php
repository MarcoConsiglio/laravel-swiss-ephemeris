<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Dummy;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\MoonPhases\Strategies\MoonPhaseStrategy;

/**
 * A class Stub used in MoonPhaseTest.
 */
class NonExistentMoonStrategy extends MoonPhaseStrategy
{
    /**
     * Non-existent implementation of the parent abrstract method.
     *
     * @return void
     */
    public function found() {}
}