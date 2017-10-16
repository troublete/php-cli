<?php
namespace Cli;

use function Argv\{cleanArguments, getFlags, getCommand, isCommandCall};

/**
 * Helper function to create a simple CLI application
 * @param array $arguments
 * @param string $helpMessage
 * @param array $flagAliases
 * @param bool|boolean $showHelp
 * @return null
 */
function cli(
	array $arguments, 
	string $helpMessage, 
	array $flagAliases = [], 
	bool $showHelp = true
) {
	return new class($arguments, $helpMessage, $flagAliases, $showHelp) {

		/**
		 * Contains the $argv arguments, cleaned (=removed script name)
		 * @var array
		 */
		public $arguments = [];

		/**
		 * Contains the help message shown on call or if no arguments are provided
		 * @var string
		 */
		public $helpMessage = '';

		/**
		 * Contents of the composer.json file, if available
		 * @var \stdClass
		 */
		public $composer;

		/**
		 * Contains all the flags based on the provided arguments
		 * @var class@anonymous
		 */
		public $flags;

		/**
		 * Contains the information if given argument call is a command call
		 * @var boolean
		 */
		public $isCommand = false;

		/**
		 * Contains command name if provided by arguments
		 * @var string
		 */
		public $commandName = '';

		public function __construct(
			array $arguments, 
			string $helpMessage, 
			array $flagAliases, 
			bool $showHelp = false
		) {
			$cleanedArguments = cleanArguments($arguments);

			if (
				count($cleanedArguments) < 1
				&& $showHelp === true
			) {
				$this->print($helpMessage);
				exit;
			}

			$this->commandName = getCommand($cleanedArguments);
			$this->isCommand = isCommandCall($cleanedArguments);
			$this->arguments = $cleanedArguments;
			$this->helpMessage = $helpMessage;
			$this->flags = getFlags($cleanedArguments, $flagAliases);
			$this->composer = @json_decode(@file_get_contents(getcwd() . '/composer.json')) ?? new \stdClass();

			if ($this->flags->help !== false) {
				$this->print($helpMessage);
				exit;
			}
		}

		/**
		 * General purpose logging method to std out
		 * @param string $contents
		 * @return class@anonymous
		 */
		public function print(string $contents)
		{
			fwrite(STDOUT, $contents);
			return $this;
		}
	};
}