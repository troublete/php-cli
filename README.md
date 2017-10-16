# Cli
> It's like meow, but for PHP. 

## Install

```bash
$ composer require troublete/cli
```

## Usage

Some script content, let's assume `cli.php`.

```php
<?php
require_once 'path/to/vendor/autoload.php';

use function Cli\cli;

$helpMessage = <<<HELP
Usage: command <options>

Options:
	--someFlag <value>		Will print the given value
HELP;

$app = cli($argv, $helpMessage);

if ($app->isCommand && $app->commandName === 'command') {
	if ($app->someFlag !== false) {
		$app->log($app->someFlag);
		exit;
	}
}
```

By calling the script with the following arguments, it'll output 🌈.

```bash
$ php cli.php command --someFlag 🌈
```

## API

### Functions

#### `cli(array $arguments, string $helpMessage, array $flagAliases = [], $showHelp = true): class@anonymous`

Function to instantiate a anonymous class instance with relevant information as public properties. So they are exposed and can be used directly.

| Property | Type | Description |
|---|---|---|
| composer | `\stdClass` | Contains the composer package information, read from `getcwd()` if available. |
| flags | `class@anonymous` | Contains the flags with simple API to use (see related package argv for more information). |
| isCommand | `bool` | Contains the information if the current call is a command call. |
| commandName | `string` | Contains the current comman name, given it's a command call, else empty. |


## Related Packages

* [Argv](https://github.com/troublete/argv) - Functional library to parse CLI arguments.

## License

GPL-2.0 © Willi Eßer
