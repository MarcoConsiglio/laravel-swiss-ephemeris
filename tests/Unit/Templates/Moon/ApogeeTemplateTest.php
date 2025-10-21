<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Templates\Moon;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Apogees;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Templates\Moon\ApogeeTemplate;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;

#[TestDox("The MoonAnomalisticRhythm")]
#[CoversClass(ApogeeTemplate::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[UsesClass(FakeRunner::class)]
#[UsesClass(Command::class)]
#[UsesClass(Apogees::class)]
class ApogeeTemplateTest extends TestCase
{
    protected const RESPONSE_FILE = "./tests/SwissEphemerisResponses/Moon/anomalistic_rhythm.txt";
    #[TestDox("is the template used to build a MoonAnomalisticRhythm.")]
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

    protected function getFakeSwetestResponse(): string
    {
        $content = file_get_contents(static::RESPONSE_FILE);
        return $content === false ? "" : $content;
    }
}