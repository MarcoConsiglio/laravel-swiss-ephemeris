<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Moon;

use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\DraconicRhythm\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\DraconicRhythm;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\RhythmTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;

#[CoversClass(DraconicRhythm::class)]
#[TestDox("The Moon DraconicRhythm")]
class DraconicRhythmTest extends RhythmTestCase
{
    #[TestDox("is a collection of DraconicRecord instances.")]
    public function test_draconic_rhythm_has_records(): void
    {
        // Arrange
        $record_1 = $this->getMocked(DraconicRecord::class);
        $record_2 = $this->getMocked(DraconicRecord::class);
        /** @var FromArray&MockObject $builder */
        $builder = $this->getMocked(FromArray::class);
        $builder->expects($this->once())->method("fetchCollection")->willReturn([$record_1, $record_2]);

        // Assert
        $this->assertContainsOnlyInstancesOf(DraconicRecord::class, $builder->fetchCollection());
    }

    #[TestDox("can return a specific Moon DraconicRecord instance.")]
    public function test_getters(): void
    {
        // Arrange
        $record_1 = new DraconicRecord(
            $this->getRandomSwissEphemerisDateTime(), 
            $this->getRandomAngle(), 
            $this->getRandomAngle(), 
            $this->getRandomMoonDailySpeed()
        );
        $record_2 = new DraconicRecord(
            $this->getRandomSwissEphemerisDateTime(), 
            $this->getRandomAngle(), 
            $this->getRandomAngle(), 
            $this->getRandomMoonDailySpeed()
        );
        $record_3 = new DraconicRecord(
            $this->getRandomSwissEphemerisDateTime(), 
            $this->getRandomAngle(), 
            $this->getRandomAngle(), 
            $this->getRandomMoonDailySpeed()
        );
        /** @var FromArray&MockObject $builder */
        $builder = $this->getMocked(FromArray::class);
        $builder->expects($this->once())->method("fetchCollection")->willReturn([$record_1, $record_2, $record_3]);
        $rhythm = new DraconicRhythm($builder);

        // Assert
        $this->assertInstanceOf(DraconicRecord::class, $rhythm->first());
        $this->assertInstanceOf(DraconicRecord::class, $rhythm->last());
        $this->assertInstanceOf(DraconicRecord::class, $rhythm->get(1));
    }
}