<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Draconic\Strategies;

use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Draconic\Node;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\MoonStrategyTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The Moon\Node strategy")]
#[CoversClass(Node::class)]
class NodeTest extends TestCase
{

    #[TestDox("can find the Moon in north node.")]
    public function test_can_find_moon_apogees()
    {
        $this->markTestIncomplete();
    }
}