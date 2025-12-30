<?php
namespace MarcoConsiglio\Ephemeris\Tests\Feature\Playground;

use DateTimeZone;
use Override;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use MarcinOrlowski\TextTable\TextTable;
use MarcoConsiglio\Ephemeris\Enums\Moon\Phase;
use MarcoConsiglio\Ephemeris\Observer\Topocentric;
use MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord;
use MarcoConsiglio\Ephemeris\Tests\Feature\TestCase as FeatureTestCase;

class TestCase extends FeatureTestCase
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
        $this->now = Carbon::now($this->timezone);
        $this->now->setLocale($this->locale);
    }

    /**
     * Set the location of the observer.
     * 
     * @param float $latitude
     * @param float $longitude
     * @param int $altitude
     * @param string $location_name
     * @param string $locale
     * @param string $timezone
     */
    protected function setLocation(
        float $latitude = 51.0,
        float $longitude = 0.0,
        int $altitude = 26,
        string $location_name = "Greenwich Royal Observatory, United Kingdom",
        string $locale = "en_UK",
        string $timezone = "Europe/London" 
    ): void {
        $this->ephemeris->pov = new Topocentric(
            $latitude,
            $longitude,
            $altitude
        );
        $this->location_name = $location_name;
        $this->locale = $locale;
        $this->timezone = $timezone;
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

    /**
     * Format a Carbon datetime with timezone and locale.
     *
     * @param CarbonInterface $datetime
     * @return string
     */
    protected function datetime(CarbonInterface $datetime): string
    {
        $datetime->setTimezone($this->timezone)->setLocale($this->locale);
        return $datetime->isoFormat("LLL");
    }

    /**
     * Render the $table as string output.
     *
     * @param TextTable $table
     * @return void
     */
    protected function writeTable(TextTable $table): void
    {
        $this->writeLine($table->renderAsString());
    }

    /**
     * Get the corresponding icon of a lunar $phase.
     *
     * @param PhaseRecord $phase
     * @return string
     */
    protected function getLunarPhaseIcon(PhaseRecord $phase): string
    {
        switch ($phase->type) {
            case Phase::NewMoon:
                return "🌑";
                break;
            case Phase::FirstQuarter:
                return "🌓";
                break;
            case Phase::FullMoon:
                return "🌕";
                break;
            case Phase::ThirdQuarter:
                return "🌗";
                break;
        }
        return "Icon not available";
    }
}