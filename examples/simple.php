<?php
chdir(__DIR__ . '/..');
require_once getcwd() . '/vendor/autoload.php';

use function Cli\cli;

$helpMessage = <<<HELP
Usage: <command> <options>

Commands:
	print					🦄

Options:
	--someFlag <value>		Will print the given value

HELP;

$app = cli($argv, $helpMessage);

if ($app->isCommand && $app->commandName === 'print') {
	$app->print('🦄');
}

if ($app->flags->someFlag !== false) {
	$app->print($app->flags->someFlag);
	exit;
}
