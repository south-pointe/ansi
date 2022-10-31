# ANSI sequence generator library for PHP

![GitHub](https://img.shields.io/github/license/south-pointe/ansi)

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

// You can also set color by code (0 ~ 255)
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

// return an array that contains position of row and column.
echo Ansi::getTerminalSize();
```
