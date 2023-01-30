<?php

namespace MarcoConsiglio\Ephemeris\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use MarcoConsiglio\Ephemeris\LaravelSwissEphemeris;
use MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord;
use Illuminate\Support\Facades\Storage;

class MoonCommand extends Command
{
    /**
     * The date argument name.
     */
    protected const DATE = "date";

    /**
     * The days argument name.
     */
    protected const DAYS = "days";

    /**
     * The minutes argument name.
     */
    protected const MINUTES = "minutes";

    /**
     * The file argument name.
     */
    protected const FILE = "file";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swetest:moon_synodic
    {'.self::DATE.' : The date from which to start the query.}
    {'.self::DAYS.'? : The duration in days of the time interval to query.}
    {'.self::MINUTES.'? : The duration in minutes of each response record.}
    {--'.self::FILE.'=? : The filename to save the data to.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the synodic rhythm of the Moon.';

    protected $ephemeris = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->ephemeris = new LaravelSwissEphemeris(
            config("ephemeris.latitude"),
            config("ephemeris.longitude"),
            config("ephemeris.timezone")
        );
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info("Fetching data...");
        try {
            $date = new Carbon($this->argument(self::DATE));
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }
        $synodic_rhythm = $this->ephemeris->getMoonSynodicRhythm($date);
        $rows = [];
        /** @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $record */
        foreach ($synodic_rhythm as $record) {
            $rows[] = $this->getTableRow($record);
        }
        $headers = ["Timestamp", "Angular distance", "Percentage"];
        if ($this->hasOption(self::FILE)) {
            $filename = $this->option(self::FILE);
            $this->info("Writing ephemeris data to $filename ...");
            $data = array_merge([0 => $headers], $rows);
            $content = $this->arrayToString($data, "\t\t");
            try {
                Storage::put($filename, $content);
            } catch (\Throwable $e) {
                $this->error($e->getMessage());
            }
        } else {
            $this->table($headers, $rows, "symfony-style-guide");
        }
        return 0;
    }

    /**
     * It explodes a SynodicRhythmRecord.
     *
     * @param \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $record
     * @return array
     */
    private function getTableRow(SynodicRhythmRecord $record) {
        $sign = $record->angular_distance->direction;
        $angle = [
            $record->angular_distance->degrees * $sign,
            $record->angular_distance->minutes,
            abs($record->angular_distance->seconds)
        ];
        return [
            $record->timestamp->toGregorianDate(),
            implode("\t", $angle),
            $record->percentage * 100
        ];
    }

    /**
     * It transforms an array into a string. Each element of the array makes up a row.
     * An empty array produces an empty string.
     *
     * @param array  $array
     * @param string $separator
     * @param string $new_line
     * @return string
     */
    private function arrayToString(array $array, string $separator = "\t", string $new_line = "\n") {
        $content = "";
        foreach ($array as $record) {
           $content .= implode($separator, $record) . $new_line;
        }
        return $content;
    }
}
