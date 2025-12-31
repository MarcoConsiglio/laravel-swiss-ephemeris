<?php
namespace MarcoConsiglio\Ephemeris\Exceptions;

use Exception;
use Throwable;

/**
 * This Exception is thrown when an invalid point of view
 * strategy is being passed to a concrete QueryTemplate.
 * 
 * @codeCoverageIgnore until it is actualy used somewhere.
 */
class InvalidPointOfView extends Exception
{
    public function __construct(string $query_template_class, string $observer_strategy_class, int $code = 0, Throwable|null $previous = null)
    {
        $message = "$query_template_class class cannot accept a $observer_strategy_class point of view.";
        return parent::__construct($message, $code, $previous);
    }
}