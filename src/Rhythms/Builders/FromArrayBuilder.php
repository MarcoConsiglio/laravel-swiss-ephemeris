<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders;

use InvalidArgumentException;

/**
 * The generic behaviour of a builder that uses an array
 * of raw ephemeris data.
 */
abstract class FromArrayBuilder extends Builder
{
    /**
     * The keys the array data must have.
     *
     * @var array
     */
    protected array $columns;

    /**
     * Check if $columns are present as keys
     * in the array data passed into the builder.
     *
     * @param array $columns The keys the array must have.
     * @return void
     * @throws InvalidArgumentException if one or more columns 
     * are missing from the data passed to the builder.
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
     * Return an exception message for a malformed
     * array data passed to the builder.
     *
     * @param string $builder_class
     * @param string $key
     * @return string
     */
    protected function getMalformedArrayMessage(string $builder_class, string $key): string
    {
        return "The $builder_class builder must have \"$key\" key in its raw array data.";
    }
}