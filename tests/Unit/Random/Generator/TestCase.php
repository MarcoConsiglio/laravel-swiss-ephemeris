<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Random\Generator;

use Faker\Generator;
use MarcoConsiglio\Ephemeris\Tests\Random\Validator\AngularDelta as AngularDeltaValidator;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase as UnitTestCase;
use PHPUnit\Framework\MockObject\MockObject;

class TestCase extends UnitTestCase
{
    /**
     * Replace the `Faker\Generator` implementetion with one that return `true`
     * every time the `$boolean()` property is called.
     */
    protected function trickFakerToGetTrueOut(): Generator&MockObject
    {
        $builder = $this->getMockBuilder(Generator::class);
        $builder->onlyMethods(["__call"]);
        $faker_mock = $builder->getMock();
        $faker_mock->expects($this->atLeastOnce())->method("__call")->with("boolean")->willReturn(true);
        return $faker_mock;
    }

    /**
     * Replace the `Faker\Generator` implementetion with one that return `false`
     * every time the `$boolean()` property is called.
     */
    protected function trickFakerToGetFalseOut(): Generator&MockObject
    {
        $builder = $this->getMockBuilder(Generator::class);
        $builder->onlyMethods(["__call"]);
        $faker_mock = $builder->getMock();
        $faker_mock->expects($this->atLeastOnce())->method("__call")->with("boolean")->willReturn(false);
        return $faker_mock;
    }
}