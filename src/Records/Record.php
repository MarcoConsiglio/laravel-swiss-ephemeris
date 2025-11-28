<?php
namespace MarcoConsiglio\Ephemeris\Records;

/**
 * It defines the abstract concept of a record of the 
 * ephemeris of a celestial object.
 */
abstract class Record
{
    /**
     * The daily speed of the celestial object at the 
     * time to which the record refers expressed in
     * decimal degrees per day.
     * 
     * @var float
     */
    public protected(set) float $daily_speed;
}