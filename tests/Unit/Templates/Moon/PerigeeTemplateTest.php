<?php
namespace MarcoConsiglio\Ephemeris\Tests\Unit\Templates\Moon;

use AdamBrett\ShellWrapper\Command;
use AdamBrett\ShellWrapper\Runners\FakeRunner;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\MockObject\MockObject;
use MarcoConsiglio\Ephemeris\Rhythms\Moon\Perigees;
use MarcoConsiglio\Ephemeris\SwissEphemerisDateTime;
use MarcoConsiglio\Ephemeris\Templates\Moon\PerigeeTemplate;
use MarcoConsiglio\Ephemeris\Tests\Unit\Templates\TemplateTestCase;

#[CoversClass(PerigeeTemplate::class)]
#[UsesClass(SwissEphemerisDateTime::class)]
#[UsesClass(FakeRunner::class)]
#[UsesClass(Command::class)]
#[UsesClass(Perigees::class)]
#[TestDox("The Moon\PerigeeTemplate")]
class PerigeeTemplateTest extends TemplateTestCase
{
    protected string $response_file = "./tests/SwissEphemerisResponses/Moon/perigees_decimal.txt";

    #[TestDox("is the template used to build a Moon\Perigees collection.")]
    public function test_query_template()
    {
        // Arrange
        $start_date = SwissEphemerisDateTime::create(2000);
        $days = 30;
        $step_size = 60;
        /** @var Command&MockObject $command */
        $command = $this->getMocked(Command::class);
        $command->expects($this->any())->method("addFlag");
        $runner = new FakeRunner(standardOutput: $this->getFakeSwetestResponse());
        $template = new PerigeeTemplate($start_date, $days, $step_size, $runner, $command);

        // Act
        $object = $template->getResult();

        // Assert
        $this->assertInstanceOf(Perigees::class, $object);
    }
}