<?php
namespace MarcoConsiglio\Ephemeris\Exceptions;

use ErrorException;

/**
 * This Exception is thrown when the Swiss Ephemeris fail to answer the query.
 */
class SwissEphemerisError extends ErrorException
{
    /**
     * The list of errors found in the Swiss Ephemeris output.
     *
     * @var array
     */
    public array $errors_list = [];

    /**
     * Construct the exception with a list of errors found in the Swiss Ephemeris executable output.
     *
     * @param array $errors The errors list.
     */
    public function __construct(array $errors) 
    {
        $this->removeNonStringElements($errors);    

        // Check for duplicates and then push the errors into the errors list.
        $unique_errors = array_unique($errors);
        $this->errors_list = $unique_errors;
        $this->message = implode(PHP_EOL, $this->errors_list);
        $this->severity = E_RECOVERABLE_ERROR;
    }

    /**
     * Check the errors are all strings. Remove the non-string elements.
     *
     * @param array $errors The errors list.
     * @return void
     */
    protected function removeNonStringElements(array &$errors)
    {
        foreach ($errors as $index => $error) {
            if(!is_string($error)) {
                unset($errors[$index]);
            }
        }
    }
}