<?php
namespace MarcoConsiglio\Ephemeris\Exceptions;

use ErrorException;

/**
 * This Exception is thrown when the Swiss Ephemeris fail to answer the query.
 */
class SwissEphemerisError extends ErrorException
{
    /**
     * Construct the exception with a list of errors found in the Swiss Ephemeris executable output.
     *
     * @param array $errors The errors list.
     */
    public function __construct(array $errors) 
    {
        // $this->removeNonStringElements($errors);    
        $unique_errors = $this->unique($errors);
        $this->message = $this->makeMessage($unique_errors);
        $this->severity = E_RECOVERABLE_ERROR;
    }

    /**
     * Removes duplicates errors.
     *
     * @param array $errors
     * @return array
     */
    protected function unique(array $errors): array
    {
        return array_unique($errors);
    }

    /**
     * Makes a string error message.
     *
     * @param array $errors
     * @return string
     */
    protected function makeMessage(array $errors): string
    {
        return implode(PHP_EOL, $errors);
    }

    // /**
    //  * Check the errors are all strings. Remove the non-string elements.
    //  *
    //  * @param array $errors The errors list.
    //  * @return void
    //  */
    // protected function removeNonStringElements(array &$errors)
    // {
    //     foreach ($errors as $index => $error) {
    //         if(!is_string($error)) {
    //             unset($errors[$index]);
    //         }
    //     }
    // }
}