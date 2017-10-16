<?php
namespace Cli;

use function Argv\{cleanArguments, getFlags, getCommand, isCommandCall};

/**
 * Helper function to create a simple CLI application
 * @param array $arguments
 * @param string $helpMessage
 * @param array $flagAliases
 * @param bool|boolean $showHelp
 * @param array $outputStreams
 * @return null
 */
function cli(
	array $arguments, 
	string $helpMessage, 
	array $flagAliases = [], 
	bool $showHelp = true,
	array $outputStreams = [STDOUT]
) {
	return new class($arguments, $helpMessage, $flagAliases, $showHelp, $outputStreams) {

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

		/**
		 * Contains an array of output streams on which the print command will write
		 * @var array
		 */
		protected $outputStreams;

		public function __construct(
			array $arguments, 
			string $helpMessage, 
			array $flagAliases, 
			bool $showHelp = false,
			array $outputStreams = [STDOUT]
		) {
			$cleanedArguments = cleanArguments($arguments);
			
			$this->isCommand = isCommandCall($cleanedArguments);
			
			if ($this->isCommand) {
				$this->commandName = getCommand($cleanedArguments);
			}
			
			$this->arguments = $cleanedArguments;
			$this->helpMessage = $helpMessage;
			$this->flags = getFlags($cleanedArguments, $flagAliases);
			$this->composer = @json_decode(@file_get_contents(getcwd() . '/composer.json')) ?? new \stdClass();
			$this->outputStreams = $outputStreams;

			if (
				(
					count($cleanedArguments) < 1
					&& $showHelp === true
				)
				|| $this->flags->help !== false
			) {
				$this->print($helpMessage);
			}
		}

		/**
		 * General purpose logging method to std out
		 * @param string $contents
		 * @return class@anonymous
		 */
		public function print(string $contents)
		{
			foreach ($this->outputStreams as $stream) {
				fwrite($stream, $contents);
			}

			return $this;
		}
	};
}