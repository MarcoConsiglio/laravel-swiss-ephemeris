<?php
namespace MarcoConsiglio\Ephemeris\Tests\Random;

use MarcoConsiglio\FakerPhpNumberHelpers\IntRange;

class SwissEphemerisDateRange extends IntRange
{
    /**
     * The maximum year allowed.
     * 
     * @var int MAX
     */
    public const int MAX = 2399;

    /**
     * The minimum number allowed.
     * 
     * @var int MIN
     */
    public const int MIN = 1800;

    public function __construct(int $start_year = self::MIN, int $end_year = self::MAX)
    {
        return parent::__construct($start_year, $end_year);
    }
}