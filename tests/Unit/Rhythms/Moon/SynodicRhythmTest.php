<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Moon;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Records\Moon\Period;
use MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord;
use MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromArray;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\FromRecords;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Periods;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Phases;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\RhythmTestCase;

#[CoversClass(SynodicRhythm::class)]
#[UsesClass(SynodicRhythmRecord::class)]
#[UsesClass(Period::class)]
#[UsesClass(Periods::class)]
#[UsesClass(Phase::class)]
#[UsesClass(PhaseRecord::class)]
#[UsesClass(Phases::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[TestDox("The Moon SynodicRhythm collection")]
class SynodicRhythmTest extends RhythmTestCase
{
    #[TestDox("is a collection of Moon SynodicRhythmRecord instances.")]
    public function test_synodic_rhythm_has_records()
    {
        // Arrange
        $record_1 = $this->getMocked(SynodicRhythmRecord::class);
        $record_2 = $this->getMocked(SynodicRhythmRecord::class);
        $record_3 = $this->getMocked(SynodicRhythmRecord::class);
        $record_4 = $this->getMocked(SynodicRhythmRecord::class);
        /** @var FromArray&MockObject $from_array_builder */
        $from_array_builder = $this->getMocked(FromArray::class);
        $from_array_builder->expects($this->once())->method("fetchCollection")->willReturn([
            $record_1, $record_2, $record_3, $record_4
        ]);
        /** @var FromRecords&MockObject $from_records_builder */
        $from_records_builder = $this->getMocked(FromRecords::class);
        $from_records_builder->expects($this->once())->method("fetchCollection")->willReturn([
            $record_1, $record_2, $record_3, $record_4
        ]);

        // Act
        $synodic_rhythm_from_raw_ephemeris = new SynodicRhythm($from_array_builder, $this->sampling_rate);
        $synodic_rhythm_from_records = new SynodicRhythm($from_records_builder, $this->sampling_rate);

        // Assert
        $this->assertContainsOnlyInstancesOf(
            SynodicRhythmRecord::class, 
            $synodic_rhythm_from_raw_ephemeris,
            $this->iterableMustContains(SynodicRhythm::class, SynodicRhythmRecord::class)    
        );
        $this->assertContainsOnlyInstancesOf(
            SynodicRhythmRecord::class, 
            $synodic_rhythm_from_records,
            $this->iterableMustContains(SynodicRhythm::class, SynodicRhythmRecord::class)    
        );
    }

    #[TestDox("can return a Moon\Periods collection.")]
    public function test_get_periods()
    {
        // Arrange
        $synodic_rhythm = $this->getSynodicRhythm();

        // Act
        $periods = $synodic_rhythm->getPeriods();

        // Assert
        $this->assertInstanceOf(Periods::class, $periods,
            $this->methodMustReturn(SynodicRhythm::class, "getPeriods", Periods::class)
        );
        $this->assertContainsOnlyInstancesOf(Period::class, $periods,
            $this->iterableMustContains(Periods::class, Period::class)
        );
    }

    #[TestDox("can return a Moon\Phases collection.")]
    public function test_get_phases()
    {
        // Arrange
        $synodic_rhythm = $this->getSynodicRhythm();   
        
        // Act
        $phases = $synodic_rhythm->getPhases(Phase::cases());

        // Assert
        $this->assertInstanceOf(Phases::class, $phases,
            $this->methodMustReturn(SynodicRhythm::class, "getPhases", Phases::class)
        );
        $this->assertContainsOnlyInstancesOf(PhaseRecord::class, $phases,
            $this->iterableMustContains(Phases::class, PhaseRecord::class)
        );
    }

    #[TestDox("can return a specific Moon SynodicRhythmRecord instance.")]
    public function test_getters()
    {
        // Arrange
        $synodic_rhythm = $this->getSynodicRhythm();
        
        // Act
        $first_record = $synodic_rhythm->first();
        $last_record = $synodic_rhythm->last();
        $a_record = $synodic_rhythm->get(1);

        // Assert
        $this->assertInstanceOf(SynodicRhythmRecord::class, $first_record,
            $this->methodMustReturn(SynodicRhythm::class, "first", SynodicRhythmRecord::class)
        );
        $this->assertInstanceOf(SynodicRhythmRecord::class, $last_record,
            $this->methodMustReturn(SynodicRhythm::class, "last", SynodicRhythmRecord::class)
        );
        $this->assertInstanceOf(SynodicRhythmRecord::class, $a_record,
            $this->methodMustReturn(SynodicRhythm::class, "get", SynodicRhythmRecord::class)
        );
    }
}
