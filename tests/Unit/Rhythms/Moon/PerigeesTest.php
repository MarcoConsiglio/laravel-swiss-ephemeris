<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Moon;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Perigees\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Perigees;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\RhythmTestCase;

#[TestDox("The Moon\Perigees collection")]
#[CoversClass(Perigees::class)]
#[UsesClass(FromArray::class)]
#[UsesClass(PerigeeRecord::class)]
class PerigeesTest extends RhythmTestCase
{
    #[TestDox("is a collection of PerigeeRecord instances.")]
    public function test_moon_apogees_is_a_collection()
    {
        // Arrange
        /** @var FromArray&MockObject $apogees_builder */
        $apogees_builder = $this->getMocked(FromArray::class);
        $apogees_builder->expects($this->once())->method("fetchCollection")->willReturn([
            $this->getMocked(PerigeeRecord::class),
            $this->getMocked(PerigeeRecord::class),
            $this->getMocked(PerigeeRecord::class),
            $this->getMocked(PerigeeRecord::class)
        ]);

        // Act
        $apogees = new Perigees($apogees_builder);

        // Assert
        $this->assertContainsOnlyInstancesOf(PerigeeRecord::class, $apogees,
            $this->iterableMustContains(Perigees::class, PerigeeRecord::class)
        );
    }

    #[TestDox("can return a specific PerigeeRecord.")]
    public function test_getters()
    {
        // Arrange
        /** @var FromArray&MockObject $apogees_builder */
        $apogees_builder = $this->getMocked(FromArray::class);
        $apogees_builder->method("fetchCollection")->willReturn([
            $this->getMocked(PerigeeRecord::class),
            $this->getMocked(PerigeeRecord::class),
            $this->getMocked(PerigeeRecord::class)
        ]);
        $apogees = new Perigees($apogees_builder);

        // Act
        $first_record = $apogees->first();
        $last_record = $apogees->last(); 
        $a_record = $apogees->get(1); 

        // Assert
        $this->assertInstanceOf(PerigeeRecord::class, $first_record, 
            $this->methodMustReturn(Perigees::class, "first", PerigeeRecord::class)
        );
        $this->assertInstanceOf(PerigeeRecord::class, $last_record, 
            $this->methodMustReturn(Perigees::class, "last", PerigeeRecord::class)
        );
        $this->assertInstanceOf(PerigeeRecord::class, $a_record, 
            $this->methodMustReturn(Perigees::class, "get", PerigeeRecord::class)
        );
    }
}