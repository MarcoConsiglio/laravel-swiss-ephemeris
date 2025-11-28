<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\DraconicRhythm;

use MarcoConsiglio\Ephemeris\Rhythms\Builders\Builder;

class FromArray extends Builder
{

    /**
     * It constructs the builder with raw data.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->validateData();
    }

    protected function validateData()
    {
        
    }

    protected function buildRecords()
    {
        
    }

    public function fetchCollection()
    {
        
    }
}