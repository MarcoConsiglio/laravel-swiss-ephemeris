<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders;

use InvalidArgumentException;
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
     * The data used to construct a builder.
     *
     * @var mixed
     */
    protected $data;

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

    /**
     * It checks if $columns are present as keys
     * in the array data passed into the builder.
     *
     * @param array $columns
     * @return void
     */
    protected function validateArrayData(array $columns)
    {
        $data = collect($this->data);
        $concrete_builder = static::class;
        $data->each(function ($item) use ($columns, $concrete_builder) {
            foreach ($columns as $key) {
                if(!isset($item[$key])) {
                    throw new InvalidArgumentException(
                        $this->getMalformedArrayMessage($concrete_builder, $key)
                    );    
                }
            }
        });
    }

    /**
     * It validates records passed into the builder.
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
     * It checks if the array data passed into
     * the builder is empty.
     *
     * @return void
     * @throws InvalidArgumentException if array data is empty.private
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
     * It returns an exception message for a malformed
     * array data passed to the builder.
     *
     * @param string $builder_class
     * @param string $key
     * @return string
     */
    public static function getMalformedArrayMessage(string $builder_class, string $key): string
    {
        return "The $builder_class builder must have \"$key\" key in its raw array data.";
    }

    /**
     * It returns an exception message for a
     * record type mismatch.
     *
     * @param string $builder_class
     * @param string $record_class
     * @return string
     */
    public static function getInvalidRecordTypeMessage(string $builder_class, string $record_class): string
    {
        return "The $builder_class builder must have an array of $record_class instances.";
    }

    /**
     * It returns an exception message for an
     * empty array data.
     *
     * @param string $builder_class
     * @return string
     */
    public static function getEmptyDataMessage(string $builder_class): string
    {
        return "The $builder_class builder cannot work with empty array data.";
    }
}