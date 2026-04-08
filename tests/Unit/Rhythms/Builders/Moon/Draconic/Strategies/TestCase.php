<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\Draconic\Strategies;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Ephemeris\Enums\Cardinality;
use MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Draconic\Node;
use MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders\Moon\StrategyTestCase;
use MarcoConsiglio\Goniometry\Enums\Direction;

abstract class TestCase extends StrategyTestCase
{
    /**
     * Setup the test environment.
     */
    #[\Override]
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
     */
    protected function getRandomNorthNodeRecord(bool $set_cardinality = false): DraconicRecord
    {
        $longitude = $this->positiveRandomSexadecimal();
        $moon_longitude = $this->getAbsoluteLongitude($longitude);
        $longitude = $moon_longitude->toFloat();
        $north_node_longitude = $this->getAbsoluteLongitude($longitude);
        $record = new DraconicRecord(
            $this->date, 
            $moon_longitude,
            $north_node_longitude,
            $this->daily_speed
        );
        if ($set_cardinality) $record->cardinality = Cardinality::North;
        return $record;
    }

    /**
     * Get a random DraconicRecord which is a lunar south node.
     *
     * @param bool $set_cardinality Weather the instance have
     * the cardinality property already setted.
     */
    protected function getRandomSouthNodeRecord(bool $set_cardinality = false): DraconicRecord
    {
        $longitude = $this->positiveRandomSexadecimal();
        $moon_longitude = $this->getAbsoluteLongitude($longitude);
        $longitude = $moon_longitude->toFloat();
        $south_node_longitude = $this->getAbsoluteLongitude($longitude);
        $north_node_longitude = $this->getOppositeAbsoluteLongitude($south_node_longitude);
        $record = new DraconicRecord(
            $this->date,
            $moon_longitude,
            $north_node_longitude,
            $this->daily_speed
        );
        if ($set_cardinality) $record->cardinality = Cardinality::South;
        return $record;
    }

    /**
     * Get a random DraconicRecord which is any Moon position
     * except for north and south nodes.
     *
     * Of course the cardinality property is not setted, because
     * the moon in not in one of the two lunar nodes, therefor
     * is meaningless.
     */
    protected function getRandomNonNodeRecord(): DraconicRecord
    {
        $opposite = Angle::createFromValues(180, direction: Direction::CLOCKWISE);
        $north_node_longitude = $this->positiveRandomSexadecimal();
        $north_node_angle_longitude = Angle::createFromDecimal($north_node_longitude);
        $south_max_longitude = Angle::absSum($north_node_angle_longitude, $opposite)->toFloat();
        [$north_min_longitude, $north_max_longitude] = $this->getDeltaExtremes($this->delta, $north_node_longitude); 
        $south_min_longitude = Angle::absSum(Angle::createFromDecimal($north_max_longitude), $opposite)->toFloat();
        $south_max_longitude = Angle::absSum(Angle::createFromDecimal($north_min_longitude), $opposite)->toFloat();
        $moon_angle_longitude = Angle::createFromDecimal(
            $this->faker->randomElement([
                $this->randomFloat($north_max_longitude, $south_min_longitude),
                $this->randomFloat($south_max_longitude, $north_min_longitude)
            ])
        );
        return new DraconicRecord(
            $this->date,
            $moon_angle_longitude,
            $north_node_angle_longitude,
            $this->daily_speed
        );
    }
}