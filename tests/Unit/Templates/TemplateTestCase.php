<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Templates;

use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;

/**
 * Test case for a Template Design Patter. 
 */
abstract class TemplateTestCase extends TestCase
{
    /**
     * The file path containing an already generated response output 
     * of the swiss ephemeris executable.
     * 
     * Use it to not trigger a call to the executable during tests. 
     * @var string
     */
    abstract protected string $response_file {get; set;}

    /**
     * Gets an already generated swetest executable response, 
     * reading it from a file specified in $response_file.
     * Use it to not trigger a call to the executable during tests.  
     *
     * @return string
     */
    protected function getFakeSwetestResponse(): string
    {
        $content = file_get_contents($this->response_file);
        return $content === false ? "" : $content;
    }
}