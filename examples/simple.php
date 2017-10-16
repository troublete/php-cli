<?php
chdir(__DIR__ . '/..');
require_once getcwd() . '/vendor/autoload.php';

use function Cli\cli;

$helpMessage = <<<HELP
Usage: <options>

Options:
	--someFlag <value>		Will print the given value
HELP;

$app = cli($argv, $helpMessage);

if ($app->flags->someFlag !== false) {
	$app->log($app->someFlag);
	exit;
}