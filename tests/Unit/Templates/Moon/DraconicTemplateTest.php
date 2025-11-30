<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Templates\Moon;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Templates\Moon\DraconicTemplate;
use MarcoConsiglio\Ephemeris\Tests\Unit\Templates\TemplateTestCase;
use PHPUnit\Framework\Attributes\TestDox;

#[TestDox("The Moon\DraconicTemplate")]
class DraconicTemplateTest extends TemplateTestCase
{
    #[TestDox("is the template used to build Moon\DraconicRhythm collection.")]
    public function test_query_template()
    {
        // Arrange
        $this->response_file = "./tests/SwissEphemerisResponses/Moon/draconic_decimal.txt";
        $start_date = SwissEphemerisDateTime::create(2000);
        $days = 30;
        $step_size = 60;
        $command = $this->getMocked(Command::class);
        $command->expects($this->any())->method("addFlag");
        $runner = new FakeRunner(standardOutput: $this->getFakeSwetestResponse());
        $template = new DraconicTemplate();

    }
}