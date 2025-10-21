<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Templates\Moon;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm;
use MarcoConsiglio\Ephemeris\Templates\Moon\SynodicRhythmTemplate;
use MarcoConsiglio\Ephemeris\Tests\Unit\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;

#[CoversClass(SynodicRhythmTemplate::class)]
#[UsesClass(Command::class)]
#[UsesClass(SynodicRhythm::class)]
#[TestDox("The MoonSynodicRhythmTemplate")]
class SynodicRhythmTemplateTest extends TestCase
{
    protected const RESPONSE_FILE = "./tests/SwissEphemerisResponses/Moon/synodic_rhythm.txt";

    #[TestDox("is the template used to build a MoonSynodicRhythm.")]
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
        $template = new SynodicRhythmTemplate($start_date, $days, $step_size, $runner, $command);

        // Act
        $object = $template->getResult();

        // Assert
        $this->assertInstanceOf(SynodicRhythm::class, $object);
    }

    protected function getFakeSwetestResponse(): string
    {
        $content = file_get_contents(static::RESPONSE_FILE);
        return $content === false ? "" : $content;
    }
}