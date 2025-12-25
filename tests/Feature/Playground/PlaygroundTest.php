<?php
namespace MarcoConsiglio\Ephemeris\Tests\Feature\Playground;

use Carbon\Carbon;
use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Observer\Topocentric;
use MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord;
use MarcoConsiglio\Ephemeris\Tests\Feature\TestCase;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;

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
    /**
     * The playground folder not committed to the code repository.
     */
    const string PLAYGROUND_FOLDER = "./tests/playground";

    /**
     * The demo output.
     *
     * @var string[]
     */
    protected array $output;

    // Add here your test method to try out the 
    // laravel-swiss-ephemeris features.
    #[TestDox("you can know on which days the pizza will leavening best or worst.")]
    #[Test]
    public function pizza_leavening(): void
    {
        $this->expectNotToPerformAssertions();
        // Set your locale here.
        $location_name = "Avezzano, Italy";
        $this->ephemeris->pov = new Topocentric(
            $lat = 42.0412,
            $long = 13.4397,
            $alt = 695
        );
        $date = new Carbon("2025-12-20");
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm($date);
        $moon_phases = $synodic_rhythm->getPhases([Phase::NewMoon, Phase::FullMoon]);
        $draconic_rhyhtm = $this->ephemeris->getMoonDraconicRhythm($date);
        $this->writeLine("+---------------+");
        $this->writeLine("| Pizza Almanac |");
        $this->writeLine("+---------------+");
        $this->writeLine("");
        $this->writeLine("Location: {$location_name}");
        $this->writeLine("Lat: {$lat}° Long: {$long}° Alt: {$alt}m\n");
        $this->writeLine("With new moon, use less salt.");
        $this->writeLine("With full moon, use more salt.");
        $this->writeLine("DATETIME\t\t\t\tLUNAR PHASE\tSALT");
        foreach ($moon_phases as $phase) {
            /** @var PhaseRecord $phase */
            $salt = $phase->type == Phase::FullMoon ? "\t++" : "\t\t--";
            $this->writeLine("{$phase->timestamp}\t\t{$phase->type->name}{$salt}");
        }
        $this->writeLine("\nAvoid leavening the pizza on these days:");
        $this->writeLine("DATETIME\t\t\t\tLUNAR NODE");
        foreach ($draconic_rhyhtm as $node) {
            /** @var DraconicRecord $node */
            $this->writeLine("{$node->timestamp}\t\t{$node->cardinality->name}");
        }
        $this->writeToFile("pizza.txt");
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

    /**
     * Write a line of text in the demo output.
     *
     * @param string $text
     * @return void
     */
    protected function writeLine(string $text): void
    {
        $this->output[] = "$text\n";
    }

    /**
     * Write the demo output in $filename.
     */
    protected function writeToFile(string $filename): void
    {
        file_put_contents(
            $this->getPlaygroundFileName($filename),
            $this->output
        );
    }
}