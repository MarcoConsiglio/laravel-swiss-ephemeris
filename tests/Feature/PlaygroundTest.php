<?php
namespace MarcoConsiglio\Ephemeris\Tests\Feature;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Observer\Topocentric;
use MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord;
use PHPUnit\Framework\Attributes\CoversNothing;

/**
 * This TestCase is intended to be a playground for testing features.
 * 
 * Use `$this->expectNotToPerformAssertions()` to make the test pass
 * while trying this software features as you wish.
 */
#[CoversNothing]
class PlaygroundTest extends TestCase
{
    /**
     * The playground folder not committed to the code repository.
     */
    const string PLAYGROUND_FOLDER = "./tests/playground";

    // Add here your test method to try out the 
    // laravel-swiss-ephemeris features.
    public function test_pizza(): void
    {
        $this->expectNotToPerformAssertions();
        // Avezzano, Italy.
        $this->ephemeris->pov = new Topocentric(
            42.0412,
            13.4397,
            695
        );
        $date = new Carbon("2025-12-20");
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm($date);
        $moon_phases = $synodic_rhythm->getPhases([Phase::NewMoon, Phase::FullMoon]);
        $draconic_rhyhtm = $this->ephemeris->getMoonDraconicRhythm($date);
        $output_1[] = "With new moon, use less salt.\n";
        $output_1[] = "With full moon, use more salt.\n";
        $output_1[] = "DATETIME\t\t\t\tLUNAR PHASE\tSALT\n";
        $output_2[] = "\nAvoid leavening the pizza on these days:\n";
        $output_2[] = "DATETIME\t\t\t\tLUNAR NODE\n";
        foreach ($moon_phases as $phase) {
            /** @var PhaseRecord $phase */
            $salt = $phase->type == Phase::FullMoon ? "\t++" : "\t\t--";
            $output_1[] = "{$phase->timestamp}\t\t{$phase->type->name}{$salt}\n";
        }
        foreach ($draconic_rhyhtm as $node) {
            /** @var DraconicRecord $node */
            $output_2[] = "{$node->timestamp}\t\t{$node->cardinality->name}\n";
        }
        file_put_contents(
            $this->getPlaygroundFileName("pizza.txt"),
            array_merge($output_1, $output_2)
        );
    }

    /**
     * Returns a playground file name not committed to the code repository,
     *
     * @param string $filename
     * @return string
     */
    protected function getPlaygroundFileName(string $filename): string
    {
        return self::PLAYGROUND_FOLDER . DIRECTORY_SEPARATOR . $filename;
    }
}