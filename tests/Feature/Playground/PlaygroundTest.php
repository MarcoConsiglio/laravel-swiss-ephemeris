<?php
namespace MarcoConsiglio\Ephemeris\Tests\Feature\Playground;

use MarcinOrlowski\TextTable\TextTable;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase as LunarPhase;
use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;

/**
 * This TestCase is intended to be a playground, so you can try out
 * the features of this software.
 * 
 * Use `$this->expectNotToPerformAssertions()` to make the test pass
 * while trying this software features as you wish.
 */
#[CoversNothing]
#[TestDox("With Laravel Swiss Ephemeris")]
class PlaygroundTest extends TestCase
{
    #[TestDox("you can make a lunar calendar.")]
    #[Test]
    public function lunar_calendar(): void
    {
        $this->expectNotToPerformAssertions();
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm($this->now->round("hour"));
        // Get all lunar phases.
        $lunar_phases = $synodic_rhythm->getPhases(LunarPhase::cases());
        $calendar = new TextTable(["DATETIME", "LUNAR PHASE"]);
        $lunar_phases->each(function ($phase) use ($calendar) {
            /** @var PhaseRecord $phase */
            $calendar->addRow([$this->datetime($phase->timestamp), $this->getLunarPhaseIcon($phase)]);
        });
        $this->writeHeader("Lunar Calendar");
        $this->writeTable($calendar);
        $this->writeToFile("lunar_calendar.txt");
    }

    // Add here your test method to try out the 
    // laravel-swiss-ephemeris features.
    #[TestDox("you can know on which days the pizza will leavening best or worst.")]
    #[Test]
    public function pizza_leavening(): void
    {
        $this->expectNotToPerformAssertions();
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm($this->now->round("hour"));
        $moon_phases = $synodic_rhythm->getPhases([LunarPhase::NewMoon, LunarPhase::FullMoon]);
        $draconic_rhyhtm = $this->ephemeris->getMoonDraconicRhythm($this->now->round("hour"));
        $this->writeHeader("Pizza Almanac");
        $this->writeLine("With new moon, use less salt.");
        $this->writeLine("With full moon, use more salt.");
        $salt_table = new TextTable(["DATETIME", "LUNAR PHASE", "SALT"]);
        $moon_phases->each(function ($phase) use ($salt_table) {
            /** @var PhaseRecord $phase */
            $salt = $phase->type == LunarPhase::FullMoon ? "++" : "--";
            $salt_table->addRow([$this->datetime($phase->timestamp), $phase->type->name, $salt]);
        });
        $this->writeTable($salt_table);
        $this->writeLine("\nAvoid leavening the pizza on these days:");
        $nodes_table = new TextTable(["DATETIME", "LUNAR NODE"]);
        $draconic_rhyhtm->each(function ($node) use ($nodes_table) {
            /** @var DraconicRecord $node */
            $nodes_table->addRow([$this->datetime($node->timestamp), $node->cardinality->name]);
        });
        $this->writeTable($nodes_table);
        $this->writeToFile("pizza.txt");
    }

    #[TestDox("you can know on which days there's the best mushroom gathering.")]
    #[Test]
    public function mushroom_gathering(): void
    {
        $this->expectNotToPerformAssertions();
        $days = 90;
        $full_moons = $this->ephemeris->getMoonSynodicRhythm($this->now, $days)->getPhases([LunarPhase::FullMoon]);
        $anomalistic_rhythm = $this->ephemeris->getMoonAnomalisticRhythm($this->now, $days);
        $perigees = collect($anomalistic_rhythm->all());
        $perigees = $perigees->filter(function ($record) {
            return $record->isPerigee();
        });
        $calendar = collect(array_merge($full_moons->all(), $perigees->all()));
        $calendar = $calendar->sort(function ($itemA, $itemB) {
            /** @var PerigeeRecord|PhaseRecord $itemA */
            /** @var PerigeeRecord|PhaseRecord $itemB */
            /** @var SwissEphemerisDateTime $timestampA */
            /** @var SwissEphemerisDateTime $timestampB */
            $timestampA = $itemA->timestamp;
            $timestampB = $itemB->timestamp;
            if ($timestampA->greaterThanOrEqualTo($timestampB)) return 1;
            else return -1;
        });
        $this->writeHeader("Mushroom Almanac");
        $this->writeLine("A full moon and perigee on the same day\nare very favorable for mushroom growth.");
        $table = new TextTable(["DATETIME", "LUNAR EVENT"]);
        $calendar->each(function ($record) use ($table) {
            /** @var PerigeeRecord|PhaseRecord $record */
            if ($record instanceof PerigeeRecord) {
                $table->addRow([$this->datetime($record->timestamp), "Moon Perigee"]);
            }
            if ($record instanceof PhaseRecord) {
                $table->addRow([$this->datetime($record->timestamp), "Full Moon"]);
            }
        });
        $this->writeTable($table);
        $this->writeToFile("mushrooms.txt");
    }
}