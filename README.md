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

$app = cli($argv, 'Usage: <flags>');

if ($app->flags->someFlag !== false) {
	$app->print($app->flags->someFlag);
	exit;
}
```

By calling the script with the following arguments, it'll output 🌈.

```bash
$ php cli.php --someFlag 🌈
```

For examples see `/examples`.

## API

### Functions

#### `cli($arguments, $helpMessage, $flagAliases = [], $showHelp = true, $outputStreams = [])`

Function to instantiate an anonymous class instance with relevant information as public properties. So they are exposed and can be used directly.

##### Arguments

| Argument | Type | Description |
|---|---|---|
| $arguments | `array` | The arguments from which the script shall take the flags and values (should be in most cases `$argv`). |
| $helpMessage | `string` | The help/welcome message that shall be shown on script call with `--help` or when no arguments are provided (flag based, see `$showHelp`). |
| $flagAliases | `array` | An array with short aliases for flags. For example `['h' => 'help']`, would allow that `-h` is used instead of `--help`. |
| $showHelp | `bool` | Flag to determine if the help message should be shown on call without arguments. |
| $outputStreams | `array` | Array of output streams the `print()` method will write to when called. (defaults to `STDOUT`) |

##### Properties

| Property | Type | Description |
|---|---|---|
| composer | `\stdClass` | Contains the composer package information, read from `getcwd()` if available. |
| flags | `class@anonymous` | Contains the flags with simple API to use (see related package argv for more information). |
| isCommand | `bool` | Contains the information if the current call is a command call. |
| commandName | `string` | Contains the current comman name, given it's a command call, else empty. |
| helpMessage | `string` | Contains the help message defined for the CLI. |

##### Methods

| Method | Description |
|---|---|
| `print(string $contents)` | Method to print something in the set output streams (just to have a common way of doing this, see `$outputStreams`) |


## Related Packages

* [Argv](https://github.com/troublete/argv) - Functional library to parse CLI arguments
* [Crayon](https://github.com/troublete/crayon) - Functional library for colorful CLI output

## License

GPL-2.0 © Willi Eßer
