<?php
namespace MarcoConsiglio\Ephemeris\Tests\Traits;

use InvalidArgumentException;

/**
 * This trait provides equal or not equal comparison Parameterized Tests.
 */
trait WithRecordsComparison
{
       /**
     * The maximum number of comparable properties.
     * 
     * @var int
     */
    private const MAX_PROPERTIES = 8;

    /**
     * The index used to find a pair of equal arguments in the 
     * testing dataset.
     * 
     * @var int
     */
    protected const EQUAL = 1;

    /**
     * The index used to find a pair of different arguments in 
     * the testing dataset.
     * 
     * @var int
     */
    protected const DIFFERENT = 0;

    /**
     * Calculate every possible disposition with repetition in 
     * which a property could be equal or different.
     * 
     * @param int $disposition_length The length of each 
     * disposition.
     * @return array[]
     */
    private function calcDispositions(int $disposition_length): array
    {
        $disposition_length = abs($disposition_length);
        if ($disposition_length > self::MAX_PROPERTIES) $disposition_length = self::MAX_PROPERTIES;
        $total_cases = $this->getTotalDispositions($disposition_length);
        $cases = range(0, $total_cases - 1);
        $binary_cases = [];
        foreach ($cases as $case) {
            $binary = decbin($case);
            $binary_cases[] = $this->toIntegerBits(
                $this->fillWithTrailingZeros($binary, $disposition_length)
            );
        }
        return $binary_cases;
    }

    /**
     * Arrange all possible comparison cases taking the correct 
     * couple of arguments from the dataset.
     * 
     * @param array $dataset The dataset from which to take the 
     * arguments to test.
     * @param int $disposition_length The length of each 
     * disposition.
     * @return array[]
     */
    protected function getValuesToCompare(array $dataset, int $disposition_length): array {
        $dispositions = $this->calcDispositions($disposition_length);
        $values_to_compare = [];
        foreach ($dispositions as $case => $properties_comparison_results) {
            foreach ($properties_comparison_results as $property_index => $comparison_result) {
                // This fetch a couple of property arguments.
                $values_to_compare[$case][$property_index] = $dataset[$property_index][$comparison_result];
            }
        }
        return $values_to_compare;
    }

    /**
     * Test whether two objects are equal or different. This is a Parameterized Test.
     * 
     * @param int $properties_number The number of properties of the class being 
     * compared.
     * @throws \InvalidArgumentException if $properties_number exceed MAX_PROPERTIES constant.
     * @return void
     */
    protected function testEqualComparison(int $properties_number)
    {
        $max_comparable_properties = self::MAX_PROPERTIES;
        $properties_number = abs($properties_number);
        if ($properties_number > $max_comparable_properties) {
            throw new InvalidArgumentException("Currently, you can compare items that have a maximum of $max_comparable_properties properties.");
        }
        $total_cases = $this->getTotalDispositions($properties_number);
        $values_to_compare = $this->getValuesToCompare(
            $this->getComparisonDataset(),
            $properties_number
        );
        foreach($values_to_compare as $case => $couples) {
            $records = $this->getRecordsToCompare($couples);
            $case_number = $case + 1;
            // All cases except the last one regards different objects.
            if ($case_number != $total_cases) {
                $this->testRecordsNotEqual($case_number, $records);
            }
            // The last case is when all properties are equals therefor the two objects are equal.
            if ($case_number == $total_cases) {
                $this->testRecordsEqual($case_number, $records);
            }
        }
    }

    /**
     * Test two records are equal. This is a Parameterized Test.
     * 
     * @param int $case_number The case number being tested.
     * @param array $records An array of two records that will be fed to the comparison method.
     * @return void
     */
    protected function testRecordsEqual(int $case_number, array $records)
    {
        $this->assertObjectEquals($records[0], $records[1], "equals", 
            $this->getComparisonFailureMessage($case_number, $records)
        );
    }

    /**
     * Test two records are different. This is a Parameterized Test.
     * 
     * @param int $case_number The case number being tested.
     * @param array $records An array of two records that will be fed to the comparison method.
     * @return void
     */
    protected function testRecordsNotEqual(int $case_number, array $records)
    {
        $this->assertObjectNotEquals($records[0], $records[1], "equals", 
            $this->getComparisonFailureMessage($case_number, $records)
        );
    }

    /**
     * Return a comparison dataset with different and equal arguments.
     * 
     * @return array
     */
    abstract protected function getComparisonDataset(): array;

    /**
     * Construct the two records to be compared with some $property_couples 
     * representing an equal or different property
     * 
     * @param array $property_couples
     * @return array
     */
    abstract protected function getRecordsToCompare(array $property_couples): array;

    /**
     * Calculate the total dispositions with repetition of N properties
     * to be compared, considering the elements composing the disposistions
     * will be two, different comparison result and equal comparison result.
     * 
     * @param int $properties_number
     * @return float|int|object
     */
    protected function getTotalDispositions(int $properties_number) 
    {
        $properties_number = abs($properties_number);
        return 2 ** $properties_number;
    }

    /**
     * Take a binary number string representation and fill it with missing
     * trailing zeros.
     *  
     * @param string $binary_string The string representation of a binary number.
     * @param int $max_length The maximum number of digits in the binary number.
     * @return string
     */
    private function fillWithTrailingZeros(string $binary_string, int $max_length): string
    {
        $max_length = abs($max_length);
        if ($max_length > self::MAX_PROPERTIES) $max_length = self::MAX_PROPERTIES;
        return substr(
            $this->getTrailingZeroMask($max_length),
            0,
            $max_length - strlen($binary_string)
        ) . $binary_string;
    }

    /**
     * Return an all zeros bit mask of $length bits.
     * 
     * @param int $length The maximum length of the bit mask.
     * @return string
     */
    private function getTrailingZeroMask(int $length): string
    {
        $length = abs($length);
        if ($length > self::MAX_PROPERTIES) $length = self::MAX_PROPERTIES;
        $trailing_zeros = "";
        for ($i = 0; $i < $length - 1; $i++) {
            $trailing_zeros .= "0";
        }
        return $trailing_zeros;     
    }

    /**
     * Cast a string binary number to an array composed of
     * integer bits (0 or 1).
     * 
     * @param string $binary_string The string binary number to cast.
     * @return array
     */
    private function toIntegerBits(string $binary_string): array
    {
        $bits = str_split($binary_string);
        foreach ($bits as $position => $value) {
            $bits[$position] = (int) $value;
        }
        return $bits;
    }

    /**
     * Return a failure message for a comparison failure.
     * 
     * @param int $case_number
     * @param array $records
     * @return string
     */
    private function getComparisonFailureMessage(int $case_number, array $records): string
    {
        $first_record = $records[0];
        $second_record = $records[1];
        return "Comparison test case n. $case_number failed with records\n$first_record\n$second_record\n";
    }
}