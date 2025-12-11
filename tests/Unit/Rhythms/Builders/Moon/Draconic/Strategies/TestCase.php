<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Draconic\Strategies;

use MarcoConsiglio\Ephemeris\Enums\Cardinality;
use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Draconic\Node;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\StrategyTestCase;
use MarcoConsiglio\Goniometry\Angle;

abstract class TestCase extends StrategyTestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->tested_class = Node::class;
        $this->record_class = DraconicRecord::class;
        parent::setUp();
    }

    /**
     * Get a random DraconicRecord which is a lunar north node.
     *
     * @param bool $set_cardinality Weather the instance have 
     * the cardinality property already setted.
     * @return DraconicRecord
     */
    protected function getRandomNorthNodeRecord(bool $set_cardinality = false): DraconicRecord
    {
        $longitude = $this->getRandomPositiveSexadecimalValue();
        $record = new DraconicRecord(
            $this->date, 
            $this->getSpecificAngle($this->getBiasedLongitude($longitude)),
            $this->getSpecificAngle($this->getBiasedLongitude($longitude)),
            $this->getRandomMoonDailySpeed()
        );
        if ($set_cardinality) $record->cardinality = Cardinality::North;
        return $record;
    }

    /**
     * Get a random DraconicRecord which is a lunar south node.
     *
     * @param bool $set_cardinality Weather the instance have 
     * the cardinality property already setted.
     * @return DraconicRecord
     */
    protected function getRandomSouthNodeRecord(bool $set_cardinality = false): DraconicRecord
    {
        $longitude = $this->getRandomPositiveSexadecimalValue();
        $moon_longitude = $this->getSpecificAngle($this->getBiasedLongitude($longitude));
        $south_node_longitude = $this->getSpecificAngle($this->getBiasedLongitude($longitude));
        $opposite = $this->getSpecificAngle(-180);
        $north_node_longitude = Angle::sum($south_node_longitude, $opposite);
        $record = new DraconicRecord(
            $this->date,
            $moon_longitude,
            $north_node_longitude,
            $this->getRandomMoonDailySpeed()
        );
        $record->cardinality = Cardinality::South;
        return $record;
    }

    /**
     * Get a random DraconicRecord which is any Moon position
     * except for north and south nodes.
     * 
     * Of course the cardinality property is not setted, because
     * the moon in not in one of the two lunar nodes, therefor
     * is meaningless.
     *
     * @return DraconicRecord
     */
    protected function getRandomNonNodeRecord(): DraconicRecord
    {
        $longitude = $this->getRandomPositiveSexadecimalValue();
        $opposite = $this->getSpecificAngle(-180);
        [$north_min_longitude, $north_max_longitude] = $this->getDeltaExtremes($this->delta, $longitude); 
        $south_min_longitude = Angle::sum($this->getSpecificAngle($north_max_longitude), $opposite)->toDecimal();
        $south_max_longitude = Angle::sum($this->getSpecificAngle($north_min_longitude), $opposite)->toDecimal();
        $moon_longitude = $this->getSpecificAngle($longitude);
        $north_node_longitude = $this->getSpecificAngle(
            $this->faker->randomElement([
                $this->faker->randomFloat(PHP_FLOAT_DIG, $north_max_longitude, $south_min_longitude),
                $this->faker->randomFloat(PHP_FLOAT_DIG, $north_min_longitude, $south_max_longitude)
            ])
        );
        return new DraconicRecord(
            $this->date,
            $moon_longitude,
            $north_node_longitude,
            $this->getRandomMoonDailySpeed()
        );
    }
}