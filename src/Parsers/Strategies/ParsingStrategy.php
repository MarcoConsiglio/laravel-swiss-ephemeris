<?php
namespace MarcoConsiglio\Ephemeris\Parsers\Strategies;

abstract class ParsingStrategy implements Strategy
{
    /**
     * The text to be examined.
     *
     * @var string
     */
    protected string $text;

    /**
     * Construct the Error ParsingStrategy
     * with the $text to be examined.
     *
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->text = $text;
    }
} 