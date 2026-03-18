<?php 
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Rhythms\Builders;

abstract class FromArrayTestCase extends BuilderTestCase
{
    /**
     * Test data.
     *
     * @var array
     */
    protected array $data;

    /**
     * Setup the test environment.
     */
    #[\Override]
    public function setUp(): void
    {
        parent::setUp();
        $this->data = $this->getRawData();
    }
    
    /**
     * Return raw ephemeris data to test the builder.
     */
    protected abstract function getRawData(): array;

    /**
     * Get an error message thrown when a builder accepting raw array data
     * didn't find a certain key (column) in the array (ephemeris table).
     */
    protected function getBuilderMissingKeyErrorMessage(string $builder_class, string $key): string
    {
        return "The $builder_class builder must have \"$key\" key in its raw array data.";
    }
}