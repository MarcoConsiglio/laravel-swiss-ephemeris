<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Dummy;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\Phases\PhaseStrategy;

/**
 * A class Stub refering to an incorrect PhaseStrategy.
 */
class NonExistentMoonStrategy extends PhaseStrategy
{
    /**
     * Non-existent implementation of the parent abstract method.
     *
     * @return void
     */
    public function found() {}
}