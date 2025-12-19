<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Templates\Moon;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use ErrorException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Apogees;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Templates\Moon\ApogeeTemplate;
use MarcoConsiglio\Ephemeris\Tests\Unit\Templates\TemplateTestCase;

#[CoversClass(ApogeeTemplate::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[UsesClass(FakeRunner::class)]
#[UsesClass(Command::class)]
#[UsesClass(Apogees::class)]
#[TestDox("The Moon ApogeeTemplate")]
class ApogeeTemplateTest extends TemplateTestCase
{
    #[TestDox("is the template used to build a Moon\Apogees collection.")]
    public function test_query_template()
    {
        // Arrange
        $this->response_file = "./tests/SwissEphemerisResponses/Moon/apogees_decimal.txt";
        $start_date = SwissEphemerisDateTime::create(2000);
        $days = 30;
        $step_size = 60;
        /** @var Command&MockObject $command */
        $command = $this->getMocked(Command::class);
        $command->expects($this->any())->method("addFlag");
        $runner = new FakeRunner(standardOutput: $this->getFakeSwetestResponse());
        $template = new ApogeeTemplate($start_date, $days, $step_size, $runner, $command);

        // Act
        $object = $template->getResult();

        // Assert
        $this->assertInstanceOf(Apogees::class, $object);
    }

    public function test_parse_error()
    {
        // Arrange
        $this->response_file = "./tests/SwissEphemerisResponses/Moon/apogees_malformed.txt";
        $start_date = SwissEphemerisDateTime::create(2000);
        $days = 30;
        $step_size = 60;
        /** @var Command&MockObject $command */
        $command = $this->getMocked(Command::class);
        $runner = new FakeRunner(standardOutput: $this->getFakeSwetestResponse());
        $template = new ApogeeTemplate($start_date, $days, $step_size, $runner, $command);

        // Assert
        $this->expectException(ErrorException::class);
        
        // Act
        $template->getResult();   
        
    }
}