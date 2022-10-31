# ANSI sequence generator library for PHP

![Phpunit](https://github.com/south-pointe/ansi/actions/workflows/test.yml/badge.svg)
![GitHub](https://img.shields.io/github/license/south-pointe/ansi)

This library will enable you to easily generate ANSI sequence strings in CLI.

The list below are some things you can do with this library.

- Set foreground/background color
- Set font styles (bold/italic)
- Move cursor positions
- Clear the screen
- Get the terminal size

## Prerequisites

- PHP 8.1+

## Installation

```
composer require south-pointe/ansi
```

## Example

```php
use SouthPointe\Ansi\Ansi;
use SouthPointe\Ansi\Codes\Color;

// Change foreground text to blue.
echo Ansi::foreground(Color::Blue);

// You can also set color by 256-color mode.
echo Ansi::foreground(Color::code(12));

// Move the cursor back by 2.
echo Ansi::cursorBack(2);

// Add "test" + "\e[0m" (reset style) + "\r" (carriage return) + "\n" (new line)
echo Ansi::line('test');

// Ansi::buffer() will allow you to chain multiple sequences.
echo Ansi::buffer()
    ->bold()
    ->foreground(Color::Gray)
    ->text('foo bar')
    ->resetStyle()
    ->toString();

// Will send the string to STDOUT
echo Ansi::buffer()
    ->resetStyle()
    ->flush(STDOUT);

// Returns the size of the terminal as ['row' => int, 'column' => int].
echo Ansi::getTerminalSize();
```

## License

This is an open-sourced software licensed under the [MIT License](LICENSE).

## References

- [ANSI escape code - Wikipedia](https://en.wikipedia.org/wiki/ANSI_escape_code)
- [ANSI Escape Codes - Gist](https://gist.github.com/fnky/458719343aabd01cfb17a3a4f7296797)
- [Chapter 6. ANSI Escape Sequences: Colours and Cursor Movement - Bash Prompt HOWTO](https://tldp.org/HOWTO/Bash-Prompt-HOWTO/c327.html)
