<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder as BuilderInterface;

abstract class Builder implements BuilderInterface
{
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