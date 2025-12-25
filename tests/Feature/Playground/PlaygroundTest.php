<?php
namespace MarcoConsiglio\Ephemeris\Tests\Feature\Playground;

use Override;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use DateTimeZone;
use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Observer\Topocentric;
use MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord;
use MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
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

    /**
     * The timezone of the observer.
     *
     * @var DateTimeZone|string|null
     */
    protected DateTimeZone|string|int $timezone = "Europe/London"; 

    /**
     * The locale of the observer.
     *
     * @var string
     */
    protected string $locale = "en_UK";

    /**
     * The location name where is placed the observer.
     *
     * @var string
     */
    protected string $location_name = "Greenwich Royal Observatory, United Kingdom";

    /**
     * The current datetime.
     *
     * @var CarbonInterface
     */
    protected CarbonInterface $now;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    #[Override]
    public function setUp(): void
    {
        parent::setUp();
        // Set here your location. Default to Greenwich.
        $this->setLocation();
    }

    // Add here your test method to try out the 
    // laravel-swiss-ephemeris features.
    #[TestDox("you can know on which days the pizza will leavening best or worst.")]
    #[Test]
    public function pizza_leavening(): void
    {
        $this->expectNotToPerformAssertions();
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm($this->now);
        $moon_phases = $synodic_rhythm->getPhases([Phase::NewMoon, Phase::FullMoon]);
        $draconic_rhyhtm = $this->ephemeris->getMoonDraconicRhythm($this->now);
        $this->writeHeader("Pizza Almanac");
        $this->writeLine("With new moon, use less salt.");
        $this->writeLine("With full moon, use more salt.");
        $this->writeLine("DATETIME\t\t\t\tLUNAR PHASE\t\tSALT");
        $moon_phases->each(function ($phase) {
            /** @var PhaseRecord $phase */
            $salt = $phase->type == Phase::FullMoon ? "\t++" : "\t\t--";
            $this->writeLine("{$this->datetime($phase->timestamp)}\t\t{$phase->type->name}{$salt}");
        });
        $this->writeLine("\nAvoid leavening the pizza on these days:");
        $this->writeLine("DATETIME\t\t\t\tLUNAR NODE");
        $draconic_rhyhtm->each(function ($node) {
            /** @var DraconicRecord $node */
            $this->writeLine("{$this->datetime($node->timestamp)}\t\t{$node->cardinality->name}");
        });
        $this->writeToFile("pizza.txt");
    }

    #[TestDox("you can know on which days there's the best mushroom gathering.")]
    #[Test]
    public function mushroom_gathering(): void
    {
        $this->expectNotToPerformAssertions();
        $days = 90;
        $full_moons = $this->ephemeris->getMoonSynodicRhythm($this->now, $days)->getPhases([Phase::FullMoon]);
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
        $calendar->each(function ($record) {
            /** @var PerigeeRecord|PhaseRecord $record */
            if ($record instanceof PerigeeRecord) {
                $this->writeLine($this->datetime($record->timestamp)."\t\tMoon Perigee");
            }
            if ($record instanceof PhaseRecord) {
                $this->writeLine($this->datetime($record->timestamp)."\t\tFull Moon");
            }
        });
        $this->writeToFile("mushrooms.txt");
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
    protected function writeLine(string|null $text = null): void
    {
        $this->output[] = $text.PHP_EOL;
    }

    /**
     * Write an horizontal line.
     *
     * @param integer $size The line size expressed in char length.
     * @return string
     */
    protected function writeHorizontalLine(int $size): void
    {
        $line = "";
        for ($i = 0; $i < $size - 2; $i++) {
            $line .= "-";
        }
        $vertex = "+";
        $this->writeLine($vertex.$line.$vertex);
    }

    /**
     * Write an header composed of a title and the location
     * of the observer.
     *
     * @param string $title
     * @return void
     */
    protected function writeHeader(string $title): void
    {
        $title_size = strlen($title);
        $this->writeHorizontalLine($title_size + 4);
        $this->writeLine("| $title |");
        $this->writeHorizontalLine($title_size + 4);
        $this->writeLine();
        $this->writeNowDatetime();
        $this->writeLocation();
        $this->writeLine();
    }

    /**
     * Write the location of the observer.
     *
     * @return void
     */
    protected function writeLocation(): void
    {
        $this->writeLine("Location: {$this->location_name}");
        if ($this->ephemeris->pov instanceof Topocentric) {
            $latitude = $this->ephemeris->pov->latitude;
            $longitude = $this->ephemeris->pov->longitude;
            $altitude = $this->ephemeris->pov->altitude;
            $this->writeLine("Lat: {$latitude}° Long: {$longitude}° Alt: {$altitude}m\n");     
        }
    }

    /**
     * Write the current datetime.
     *
     * @return void
     */
    protected function writeNowDatetime(): void
    {
        $datetime = $this->datetime(Carbon::now());
        $this->writeLine("Today is: $datetime");
    }

    /**
     * Write the demo output in a file.
     *
     * @param string $filename The name of the output file.
     * @return void
     */
    protected function writeToFile(string $filename): void
    {
        file_put_contents(
            $this->getPlaygroundFileName($filename),
            $this->output
        );
    }

    protected function setLocation(
        float $latitude = 51.0,
        float $longitude = 0.0,
        int $altitude = 26,
        string $location_name = "Greenwich Royal Observatory, United Kingdom",
        string $locale = "en_UK",
        string $timezone = "Europe/London" 
    ): void
    {
        $this->ephemeris->pov = new Topocentric(
            $latitude,
            $longitude,
            $altitude
        );
        $this->location_name = $location_name;
        $this->locale = $locale;
        $this->timezone = $timezone;
    }

    protected function datetime(CarbonInterface $datetime): string
    {
        return $datetime->setTimezone($this->timezone)->isoFormat("LLL");
    }
}