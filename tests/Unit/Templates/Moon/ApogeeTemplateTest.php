<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Templates\Moon;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Apogees;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Templates\Moon\ApogeeTemplate;
use MarcoConsiglio\Ephemeris\Tests\Unit\Templates\TemplateTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The ApogeeTemplate")]
#[CoversClass(ApogeeTemplate::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[UsesClass(FakeRunner::class)]
#[UsesClass(Command::class)]
#[UsesClass(Apogees::class)]
class ApogeeTemplateTest extends TemplateTestCase
{
    protected string $response_file = "./tests/SwissEphemerisResponses/Moon/apogees.txt";

    #[TestDox("is the template used to build a Moon\Apogees collection.")]
    public function test_query_template()
    {
        // Arrange
        $start_date = $this->getMockedSwissEphemerisDateTime(2000);
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
}