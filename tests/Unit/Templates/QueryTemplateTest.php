<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Templates;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\Exceptions\SwissEphemerisError;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Templates\Moon\SynodicRhythmTemplate;
use MarcoConsiglio\Ephemeris\Templates\QueryTemplate;

#[CoversClass(QueryTemplate::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[UsesClass(SwissEphemerisError::class)]
#[UsesClass(SynodicRhythmTemplate::class)]
#[TestDox("The abstract QueryTemplate")]
class QueryTemplateTest extends TemplateTestCase
{
    protected string $response_file;

    #[TestDox("removes warning lines when it encounters them.")]
    public function test_checkWarnings_removes_warnings_lines(): void
    {
        // Arrange
        $this->response_file = "./tests/SwissEphemerisResponses/warnings.txt";
        /** @var SwissEphemerisDateTime&MockObject $date*/
        $date = $this->getMockedSwissEphemerisDateTime();
        $shell = new FakeRunner(standardOutput: $this->getFakeSwetestResponse());
        /** @var Command&MockObject $command */
        $command = $this->getMocked(Command::class);
        /** @var SynodicRhythmTemplate&MockObject $template */
        $template = $this->getMocked(
            SynodicRhythmTemplate::class, [
                "setFlags", "setArguments", "setHeader", "checkErrors", "checkNotices",
                "removeEmptyLines", "parseOutput", "remapColumns", "buildObject", "fetchObject"
            ],
            original_constructor: true,
            constructor_arguments: [$date, 30, 60, null, $shell, $command]
        );

        // Act
        $template->getResult();

        // Assert
        $this->assertCount(1, $template->warnings);
    }

    #[TestDox("removes notices lines when it encounters them.")]
    public function test_checkNotices_removes_notices_lines(): void
    {
        // Arrange
        $this->response_file = "./tests/SwissEphemerisResponses/warnings.txt";
        /** @var SwissEphemerisDateTime&MockObject $date*/
        $date = $this->getMockedSwissEphemerisDateTime();
        $shell = new FakeRunner(standardOutput: $this->getFakeSwetestResponse());
        /** @var Command&MockObject $command */
        $command = $this->getMocked(Command::class);
        /** @var SynodicRhythmTemplate&MockObject $template */
        $template = $this->getMocked(
            SynodicRhythmTemplate::class, [
                "setFlags", "setArguments", "setHeader", "checkErrors", "checkWarnings",
                "removeEmptyLines", "parseOutput", "remapColumns", "buildObject", "fetchObject"
            ],
            original_constructor: true,
            constructor_arguments: [$date, 30, 60, null, $shell, $command]
        );

        // Act
        $template->getResult();

        // Assert
        $this->assertCount(1, $template->notices);
    }

    #[TestDox("can throw SwissEphemerisError exception if there is some error in the raw output.")]
    public function test_checkErrors_catch_SwissEphemerisError(): void
    {
        // Arrange
        $this->response_file = "./tests/SwissEphemerisResponses/errors.txt";
        $date = $this->getMockedSwissEphemerisDateTime();
        $shell = new FakeRunner(standardOutput: $this->getFakeSwetestResponse());
        $command = $this->getMocked(Command::class);
        /** @var SynodicRhythmTemplate&MockObject $template */
        $template = $this->getMocked(
            SynodicRhythmTemplate::class, [
                "setFlags", "setArguments", "setHeader", "checkWarnings", "checkNotices",
                "removeEmptyLines", "parseOutput", "remapColumns", "buildObject", "fetchObject"
            ],
            original_constructor: true,
            constructor_arguments: [$date, 30, 60, null, $shell, $command]
        );

        // Assert
        $this->expectException(SwissEphemerisError::class);
        $this->expectExceptionMessage("swetest executable returned an error");

        // Act
        $template->getResult();
    }
}