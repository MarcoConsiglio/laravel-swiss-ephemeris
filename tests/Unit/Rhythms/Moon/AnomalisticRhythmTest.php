<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Moon;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use MarcoConsiglio\Ephemeris\Records\Moon\AnomalisticRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\FromCollections;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\AnomalisticRhythm;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\RhythmTestCase;

#[TestDox("The Moon AnomalisticRhythm collection")]
#[CoversClass(AnomalisticRhythm::class)]
#[UsesClass(FromCollections::class)]
#[UsesClass(AnomalisticRecord::class)]
class AnomalisticRhythmTest extends RhythmTestCase
{
    #[TestDox("is a collection of AnomalisticRecord instances.")]
    public function test_moon_apogees_is_a_collection(): void
    {
        // Arrange
        /** @var FromCollections&MockObject $builder */
        $builder = $this->getMocked(FromCollections::class);
        $builder->expects($this->once())->method("fetchCollection")->willReturn([
            $this->getMocked(AnomalisticRecord::class),
            $this->getMocked(AnomalisticRecord::class),
            $this->getMocked(AnomalisticRecord::class),
            $this->getMocked(AnomalisticRecord::class)
        ]);

        // Act
        $anomalistic_rhythm = new AnomalisticRhythm($builder);

        // Assert
        $this->assertContainsOnlyInstancesOf(AnomalisticRecord::class, $anomalistic_rhythm,
            $this->iterableMustContains(AnomalisticRecord::class, AnomalisticRecord::class)
        );
    }

    #[TestDox("can return a specific AnomalisticRecord.")]
    public function test_getters(): void
    {
        // Arrange
        /** @var FromCollections&MockObject $builder */
        $builder = $this->getMocked(FromCollections::class);
        $builder->method("fetchCollection")->willReturn([
            $this->getMocked(AnomalisticRecord::class),
            $this->getMocked(AnomalisticRecord::class),
            $this->getMocked(AnomalisticRecord::class)
        ]);
        $anomalistic_rhythm = new AnomalisticRhythm($builder);

        // Act
        $first_record = $anomalistic_rhythm->first();
        $last_record = $anomalistic_rhythm->last(); 
        $a_record = $anomalistic_rhythm->get(1); 

        // Assert
        $this->assertInstanceOf(AnomalisticRecord::class, $first_record, 
            $this->methodMustReturn(AnomalisticRhythm::class, "first", AnomalisticRecord::class)
        );
        $this->assertInstanceOf(AnomalisticRecord::class, $last_record, 
            $this->methodMustReturn(AnomalisticRhythm::class, "last", AnomalisticRecord::class)
        );
        $this->assertInstanceOf(AnomalisticRecord::class, $a_record, 
            $this->methodMustReturn(AnomalisticRhythm::class, "get", AnomalisticRecord::class)
        );
    }
}