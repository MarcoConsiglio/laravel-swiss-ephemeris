<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces;

/**
 * The behaviour of a rhythm builder.
 */
interface Builder
{
    // /**
    //  * 1°, validates raw data.
    //  *
    //  * @return void
    //  */
    // public function validateData();

    // /**
    //  * 2°, builds records of the rhythm.
    //  *
    //  * @return void
    //  */
    // public function buildRecords();

    /**
     * Fetch the builded collection.
     *
     * @return mixed
     */
    public function fetchCollection();
}