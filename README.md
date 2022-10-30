# ANSI sequence generator library for PHP

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
