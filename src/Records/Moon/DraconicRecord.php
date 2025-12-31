<?php
namespace MarcoConsiglio\Ephemeris\Records\Moon;

use MarcoConsiglio\Goniometry\Angle;
use MarcoConsiglio\Ephemeris\Enums\Cardinality;
use MarcoConsiglio\Ephemeris\Records\MovingObjectRecord;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;

/**
 * Represents a moment when the moon 
 * passes over the point of intersection 
 * between its orbit and the plane of 
 * the ecliptic.
 */
class DraconicRecord extends MovingObjectRecord
{
    /**
     * The current Moon longitude. It represents the
     * Moon position.
     * 
     * @var Angle
     */
    public protected(set) Angle $moon_longitude;
    
    /**
     * The current node longitude.
     * 
     * The Swiss Ephemeris returns only one of the two nodes.
     * This is the one returned by the Swiss Ephemeris.
     * 
     * @var Angle
     */
    public protected(set) Angle $north_node_longitude;

    /**
     * The current south node longitude.
     * 
     * The Swiss Ephemeris returns only one of the two nodes.
     * This is the one opposite to the only node presents in
     * the ephemeris response.
     * 
     * @var Angle
     */
    public Angle $south_node_longitude {
        get {
            return $this->oppositeLongitude($this->north_node_longitude);
        }
    }

    /**
     * The cardinality of this node.
     *
     * @var Cardinality
     */
    public Cardinality|null $cardinality = null {
        set(Cardinality|null $cardinality) {
            if ($this->cardinality === null)
                $this->cardinality = $cardinality;
        }
    }

    /**
     * Construct the Moon DraconicRecord.
     *
     */
    public function __construct(
        SwissEphemerisDateTime $timestamp,
        Angle $moon_longitude,
        Angle $north_node_longitude,
        float $moon_daily_speed
    ) {
        $this->timestamp = $timestamp;
        $this->moon_longitude = $moon_longitude;
        $this->north_node_longitude = $north_node_longitude;
        $this->daily_speed = $moon_daily_speed;
    }

    /**
     * Calculate the opposite angle of a longitude value.
     */
    protected function oppositeLongitude(Angle $longitude): Angle
    {
        $opposite = Angle::createFromValues(180, direction: Angle::CLOCKWISE);
        $angle = Angle::sum($longitude, $opposite);
        if ($angle->isClockwise()) {
            $full = Angle::createFromValues(Angle::MAX_DEGREES);
            $angle = Angle::sum($full, $angle);
        }
        return $angle;
    }

    /**
     * Return true if this record is a north node.
     */
    public function isNorthNode(): bool
    {
        return $this->cardinality == Cardinality::North;
    }

    /**
     * Return true if this record is a south node.
     */
    public function isSouthNode(): bool
    {
        return $this->cardinality == Cardinality::South;
    }

    /**
     * Pack the object properties in an associative array.
     * 
     * @return array{daily_speed:string,moon_longitude:string,timestamp:string,north_node_longitude:string,south_node_longitude:string,cardinality:string}
     */
    #[\Override]
    protected function packProperties(): array
    {
        $cardinality = $this->cardinality !== null ? $this->enumToString($this->cardinality) : $this->cardinality;
        return array_merge(self::getParentProperties(), [
            "moon_longitude" => "{$this->moon_longitude->toDecimal()}°",
            "timestamp" => $this->timestamp->toDateTimeString(),
            "north_node_longitude" => "{$this->north_node_longitude->toDecimal()}°",
            "south_node_longitude" => "{$this->south_node_longitude->toDecimal()}°",
            "cardinality" => $cardinality
        ]);
    }

    /**
     * Get the parent properties packed in an associative 
     * array.
     * 
     * @return array{daily_speed:string}
     */
    #[\Override]
    protected function getParentProperties(): array
    {
        return parent::packProperties();
    }

    /**
     * Check if this record is equal to $another_record.
     */
    public function equals(DraconicRecord $another_record): bool
    {
        $a = $this->timestamp == $another_record->timestamp;
        $b = $this->moon_longitude == $another_record->moon_longitude;
        $c = $this->north_node_longitude == $another_record->north_node_longitude;
        $d = $this->daily_speed == $another_record->daily_speed;
        return $a && $b && $c && $d;
    }
}