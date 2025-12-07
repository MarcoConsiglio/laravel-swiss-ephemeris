<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders;

use InvalidArgumentException;
use MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces\Builder as BuilderInterface;

/**
 * The abstract constructor that builds ephemeris collection from a 
 * specific type of input.
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
     * The data used to construct a collection.
     *
     * @var mixed
     */
    protected $data;

    /**
     * The sampling rate of the ephemeris expressed in 
     * minutes per each step of the ephemeris response.
     *
     * @var integer
     */
    protected int $sampling_rate;

    /**
     * Validate data.
     *
     * @return void
     */
    abstract protected function validateData();

    /**
     * Build records.
     *
     * @return void
     */
    abstract protected function buildRecords();

    /**
     * Fetch the result.
     *
     * @return mixed
     */
    abstract public function fetchCollection();

    /**
     * Validate records passed into the builder.
     *
     * @param string $record_class
     * @return void
     * @throws InvalidArgumentException if at least one item
     * is not a $record_class type.
     */
    protected function validateRecords(string $record_class)
    {
        $records = collect($this->data);
        $concrete_builder = static::class;
        $records->each(function ($item) use ($record_class, $concrete_builder){
            if (! $item instanceof $record_class) {
                throw new InvalidArgumentException(
                    $this->getInvalidRecordTypeMessage($concrete_builder, $record_class)
                );
            }
        });
    }

    /**
     * Check if the array data passed into
     * the builder is empty.
     *
     * @return void
     * @throws InvalidArgumentException if array data is empty.
     */
    protected function checkEmptyData()
    {
        if (empty($this->data)) {
            throw new InvalidArgumentException(
                $this->getEmptyDataMessage(static::class)
            );
        }       
    }

    /**
     * Return an exception message for a
     * record type mismatch.
     *
     * @param string $builder_class
     * @param string $record_class
     * @return string
     */
    protected function getInvalidRecordTypeMessage(string $builder_class, string $record_class): string
    {
        return "The $builder_class builder must have an array of $record_class instances.";
    }

    /**
     * Return an exception message for an
     * empty array data.
     *
     * @param string $builder_class
     * @return string
     */
    protected function getEmptyDataMessage(string $builder_class): string
    {
        return "The $builder_class builder cannot work with empty array data.";
    }
}