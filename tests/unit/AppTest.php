<?php

use function Cli\cli;

class AppTest extends \Codeception\Test\Unit
{
	public function testHelpMessageOutput()
	{
		$handler = fopen('php://temp', 'rw');
		cli([], 'help', [], true, [$handler]);
		rewind($handler);
		$output = stream_get_contents($handler);
		$this->assertEquals('help', $output);
	}

	public function testHelpMessageOutputByFlag()
	{
		$handler = fopen('php://temp', 'rw');
		cli(['script.php', '--help'], 'help', [], true, [$handler]);
		rewind($handler);
		$output = stream_get_contents($handler);
		$this->assertEquals('help', $output);
	}

	public function testSuppressedHelpMessageOutput()
	{
		$handler = fopen('php://temp', 'rw');
		cli([], 'help', [], false, [$handler]);
		rewind($handler);
		$output = stream_get_contents($handler);
		$this->assertEquals('', $output);
	}

	public function testSuppressedHelpMessageOutputByFlag()
	{
		$handler = fopen('php://temp', 'rw');
		cli(['script.php', '--help'], 'help', [], false, [$handler]);
		rewind($handler);
		$output = stream_get_contents($handler);
		$this->assertEquals('help', $output);
	}

	public function testSuppressedHelpMessageOutputByWrongFlag()
	{
		$handler = fopen('php://temp', 'rw');
		cli(['script.php', '--flag'], 'help', [], false, [$handler]);
		rewind($handler);
		$output = stream_get_contents($handler);
		$this->assertEquals('', $output);
	}

	public function testArgumentCount()
	{
		$app = cli(['script.php', '--flag'], 'help');
		$this->assertEquals(1, count($app->arguments));

		$app = cli(['script.php'], 'help');
		$this->assertEquals(0, count($app->arguments));

		$app = cli(['script.php', 'command', '--flag', 'flagValue'], 'help');
		$this->assertEquals(3, count($app->arguments));
	}

	public function testCheckIfCommand()
	{
		$app = cli(['script.php', 'command', '--flag', 'flagValue'], 'help');
		$this->assertTrue($app->isCommand);
		$this->assertEquals('command', $app->commandName);

		$app = cli(['script.php', '--flag', 'flagValue'], 'help');
		$this->assertFalse($app->isCommand);
		$this->assertEquals('', $app->commandName);
	}

	public function testCheckFlags()
	{
		$app = cli(['script.php', '--flag', 'flagValue', '--someOtherFlag'], 'help');
		$this->assertTrue($app->flags->someOtherFlag);
		$this->assertEquals('flagValue', $app->flags->flag);

		$app = cli(['script.php', '--flag', 'flagValue'], 'help');
		$this->assertFalse($app->flags->otherFlag);
	}
}