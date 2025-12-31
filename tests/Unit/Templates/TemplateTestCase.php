<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Templates;

use MarcoConsiglio\Ephemeris\Observer\PointOfView;
use MarcoConsiglio\Ephemeris\Observer\Topocentric;
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
    protected string $response_file;

    /**
     * A random testing TopocentricLocale. 
     *
     * @var PointOfView
     */
    protected PointOfView $pov;

    /**
     * Setup the test environment.
     */
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        $this->pov = $this->getRandomTopocentricPOV();
    }

    /**
     * Returns an already generated swetest executable response,
     * reading it from a file specified in $response_file.
     * Use it to not trigger a call to the executable during tests. 
     *
     */
    protected function getFakeSwetestResponse(): string
    {
        $content = file_get_contents($this->response_file);
        return $content === false ? "" : $content;
    }

    /**
     * Returns a random Topocentric PointOfView.
     */
    protected function getRandomTopocentricPOV(): Topocentric
    {
        $longitude = $this->getRandomPositiveSexadecimalValue();
        $latitude = $this->getRandomRelativeSexadecimalValue(90);
        $altitude = $this->faker->numberBetween(0, 4000);
        return new Topocentric($latitude, $longitude, $altitude);
    }
}