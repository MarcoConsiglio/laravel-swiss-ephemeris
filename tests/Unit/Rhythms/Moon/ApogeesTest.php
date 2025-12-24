<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Moon;

use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Apogees\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Apogees;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\RhythmTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The Moon Apogees collection")]
#[CoversClass(Apogees::class)]
#[UsesClass(FromArray::class)]
#[UsesClass(ApogeeRecord::class)]
class ApogeesTest extends RhythmTestCase
{
    #[TestDox("is a collection of ApogeeRecord instances.")]
    public function test_moon_apogees_is_a_collection(): void
    {
        // Arrange
        /** @var FromArray&MockObject $apogees_builder */
        $apogees_builder = $this->getMocked(FromArray::class);
        $apogees_builder->expects($this->once())->method("fetchCollection")->willReturn([
            $this->getMocked(ApogeeRecord::class),
            $this->getMocked(ApogeeRecord::class),
            $this->getMocked(ApogeeRecord::class),
            $this->getMocked(ApogeeRecord::class)
        ]);

        // Act
        $apogees = new Apogees($apogees_builder);

        // Assert
        $this->assertContainsOnlyInstancesOf(ApogeeRecord::class, $apogees,
            $this->iterableMustContains(Apogees::class, ApogeeRecord::class)
        );
    }

    #[TestDox("can return a specific ApogeeRecord.")]
    public function test_getters(): void
    {
        // Arrange
        /** @var FromArray&MockObject $apogees_builder */
        $apogees_builder = $this->getMocked(FromArray::class);
        $apogees_builder->method("fetchCollection")->willReturn([
            $this->getMocked(ApogeeRecord::class),
            $this->getMocked(ApogeeRecord::class),
            $this->getMocked(ApogeeRecord::class)
        ]);
        $apogees = new Apogees($apogees_builder);

        // Act
        $first_record = $apogees->first();
        $last_record = $apogees->last(); 
        $a_record = $apogees->get(1); 

        // Assert
        $this->assertInstanceOf(ApogeeRecord::class, $first_record, 
            $this->methodMustReturn(Apogees::class, "first", ApogeeRecord::class)
        );
        $this->assertInstanceOf(ApogeeRecord::class, $last_record, 
            $this->methodMustReturn(Apogees::class, "last", ApogeeRecord::class)
        );
        $this->assertInstanceOf(ApogeeRecord::class, $a_record, 
            $this->methodMustReturn(Apogees::class, "get", ApogeeRecord::class)
        );
    }
}