<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Templates;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use MarcoConsiglio\Ephemeris\Exceptions\SwissEphemerisError;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Templates\Moon\SynodicRhythmTemplate;
use MarcoConsiglio\Ephemeris\Templates\QueryTemplate;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;

#[CoversClass(QueryTemplate::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[UsesClass(SwissEphemerisError::class)]
#[UsesClass(Command::class)]
#[UsesClass(FakeRunner::class)]
#[UsesClass(SynodicRhythmTemplate::class)]
#[TestDox("The abstract QueryTemplate")]
class QueryTemplateTest extends TemplateTestCase
{
    protected string $response_file;

    #[TestDox("removes warning lines when it encounters them.")]
    public function test_check_warnings_removes_warnings_lines()
    {
        // Arrange
        $this->response_file = "./tests/SwissEphemerisResponses/warnings.txt";
        /** @var SwissEphemerisDateTime&MockObject $date*/
        $date = $this->getMocked(SwissEphemerisDateTime::class);
        $shell = new FakeRunner(standardOutput: $this->getFakeSwetestResponse());
        /** @var Command&MockObject $command */
        $command = $this->getMocked(Command::class);
        /** @var SynodicRhythmTemplate&MockObject $template */
        $template = $this->getMocked(
            SynodicRhythmTemplate::class, [
                "prepareFlags", "prepareArguments", "setHeader", "checkErrors", "checkNotices",
                "removeEmptyLines", "parseOutput", "remapColumns", "buildObject", "fetchObject"
            ],
            original_constructor: true,
            constructor_arguments: [$date, 30, 60, $shell, $command]
        );

        // Act
        $template->getResult();

        // Assert
        $this->assertCount(1, $template->warnings);
    }

    #[TestDox("removes notices lines when it encounters them.")]
    public function test_check_notices_removes_notices_lines()
    {
        // Arrange
        $this->response_file = "./tests/SwissEphemerisResponses/warnings.txt";
        /** @var SwissEphemerisDateTime&MockObject $date*/
        $date = $this->getMocked(SwissEphemerisDateTime::class);
        $shell = new FakeRunner(standardOutput: $this->getFakeSwetestResponse());
        /** @var Command&MockObject $command */
        $command = $this->getMocked(Command::class);
        /** @var SynodicRhythmTemplate&MockObject $template */
        $template = $this->getMocked(
            SynodicRhythmTemplate::class, [
                "prepareFlags", "prepareArguments", "setHeader", "checkErrors", "checkWarnings",
                "removeEmptyLines", "parseOutput", "remapColumns", "buildObject", "fetchObject"
            ],
            original_constructor: true,
            constructor_arguments: [$date, 30, 60, $shell, $command]
        );

        // Act
        $template->getResult();

        // Assert
        $this->assertCount(1, $template->notices);
    }
}