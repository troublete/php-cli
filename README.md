# Cli
> It's like [meow](https://www.npmjs.com/package/meow), but for PHP. 

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
```

By calling the script with the following arguments, it'll output 🌈.

```bash
$ php cli.php --someFlag 🌈
```

By calling the script with the following arguments, it'll output 🦄🌈.

```bash
$ php cli.php print --someFlag
```

For examples see `/examples`.

## API

### Functions

#### `cli(array $arguments, string $helpMessage, array $flagAliases = [], $showHelp = true): class@anonymous`

Function to instantiate an anonymous class instance with relevant information as public properties. So they are exposed and can be used directly.

##### Properties

| Property | Type | Description |
|---|---|---|
| composer | `\stdClass` | Contains the composer package information, read from `getcwd()` if available. |
| flags | `class@anonymous` | Contains the flags with simple API to use (see related package argv for more information). |
| isCommand | `bool` | Contains the information if the current call is a command call. |
| commandName | `string` | Contains the current comman name, given it's a command call, else empty. |

##### Methods

| Method | Description |
|---|---|
| `print(string $contents)` | Method to print something in the default output stream of PHP (just to have a common way of doing this) |


## Related Packages

* [Argv](https://github.com/troublete/argv) - Functional library to parse CLI arguments
* [Crayon](https://github.com/troublete/crayon) - Functional library for colorful CLI output

## License

GPL-2.0 © Willi Eßer
