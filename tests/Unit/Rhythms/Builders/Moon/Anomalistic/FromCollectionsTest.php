<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Anomalistic;

use MarcoConsiglio\Ephemeris\Records\Moon\AnomalisticRecord;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\FromCollections;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Apogees\FromRecords as ApogeesBuilder;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\Perigees\FromRecords as PerigeesBuilder;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Apogees;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Perigees;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\BuilderTestCase;
use MarcoConsiglio\Goniometry\Angle;

#[CoversClass(FromCollections::class)]
#[UsesClass(ApogeeRecord::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[UsesClass(Angle::class)]
#[UsesClass(ApogeesBuilder::class)]
#[UsesClass(PerigeesBuilder::class)]
#[UsesClass(Angle::class)]
#[TestDox("The Moon AnomalisticRhythm\FromCollections builder")]
class FromCollectionsTest extends BuilderTestCase
{
    #[TestDox("can build an AnomalisticRhythm collection from Apogees and Perigees collections.")]
    public function test_build_anomalistic_rhythm_from_apogees_and_perigees_collection()
    {
        // Arrange
        $d1 = SwissEphemerisDateTime::create(2000);
        $d2 = $d1->copy()->addMonth();
        $d3 = $d2->copy()->addMonth();
        $d4 = $d3->copy()->addMonth();
        $s = $this->getRandomMoonDailySpeed();
        /** @var Angle&MockObject $a */
        $a = $this->getMocked(Angle::class);
        $apogee_1 =  new ApogeeRecord( $d1, $a, $a, $s);
        $perigee_1 = new PerigeeRecord($d2, $a, $a, $s);
        $apogee_2 =  new ApogeeRecord( $d3, $a, $a, $s);
        $perigee_2 = new PerigeeRecord($d4, $a, $a, $s);
        $apogees_collection = new Apogees(new ApogeesBuilder([$apogee_1, $apogee_2]));
        $perigees_collection = new Perigees(new PerigeesBuilder([$perigee_1, $perigee_2]));
        $builder = new FromCollections($apogees_collection, $perigees_collection);
        $this->checkBuilderInterface(Builder::class, $builder);

        // Act
        $records = $builder->fetchCollection();

        // Assert
        $record_class = AnomalisticRecord::class;
        $this->assertContainsOnlyInstancesOf($record_class, $records,
            $this->methodMustReturn($this->getBuilderClass(), "fetchCollection", $record_class)
        );
        $this->assertDate($records[0]->timestamp, $d1);
        $this->assertDate($records[1]->timestamp, $d2);
        $this->assertDate($records[2]->timestamp, $d3);
        $this->assertDate($records[3]->timestamp, $d4);
    }

    /**
     * Get the current SUT class.
     * 
     * @return string
     */
    protected function getBuilderClass(): string
    {
        return FromCollections::class;
    }
}