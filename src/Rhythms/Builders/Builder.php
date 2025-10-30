<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder as BuilderInterface;

/**
 * A builder constructs ephemeris object from a specific
 * type of input.
 * 
 * The specific type of input determines the concrete builder class.
 */
abstract class Builder implements BuilderInterface
{
    /**
     * Indicates wheather the builder completed
     * its work or not.
     *
     * @var boolean
     */
    protected bool $builded = false;

    /**
     * Validates data.
     *
     * @return void
     */
    abstract protected function validateData();

    /**
     * Builds records.
     *
     * @return void
     */
    abstract protected function buildRecords();

    /**
     * Fetches the result.
     *
     * @return mixed
     */
    abstract public function fetchCollection();
}