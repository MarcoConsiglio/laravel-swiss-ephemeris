<?php

namespace MarcoConsiglio\Ephemeris;

use Illuminate\Console\Command;
use DestinyLab\Swetest;

class EphemerisCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 
        "ephemeris:query 
        {query : The query passed to swetest executable. Remember to first escape the query with '\' }";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Wrapper of swetest executable (Swiss Ephemeris).';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $swetest = new Swetest(__DIR__."/../../lib/");
        $swetest->query($this->getUnescapedQuery())->execute();
        foreach($swetest->getOutput() as $line) {
            $this->line($line);
        }
        return Command::SUCCESS;
    }

    /**
     * Unescape swetest query parameters string.
     *
     * @return string
     */
    protected function getUnescapedQuery()
    {
        return str_replace("\\", "", $this->argument("query"));
    }
}