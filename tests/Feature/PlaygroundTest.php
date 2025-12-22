<?php
namespace MarcoConsiglio\Ephemeris\Tests\Feature;

use PHPUnit\Framework\Attributes\CoversNothing;

/**
 * This TestCase is intended to be a playground for testing features.
 * 
 * Use `$this->expectNotToPerformAssertions()` to make the test pass
 * while trying this software features as you wish.
 */
#[CoversNothing]
class PlaygroundTest extends TestCase
{
    /**
     * The playground folder not committed to the code repository.
     */
    const string PLAYGROUND_FOLDER = "./tests/playground";

    // Add here your test method to try out the 
    // laravel-swiss-ephemeris features.

    /**
     * Returns a playground file name not committed to the code repository,
     *
     * @param string $filename
     * @return string
     */
    protected function getPlaygroundFileName(string $filename): string
    {
        return self::PLAYGROUND_FOLDER . DIRECTORY_SEPARATOR . $filename;
    }
}