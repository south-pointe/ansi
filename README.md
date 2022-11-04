# ANSI sequence generator library for PHP

![Test](https://github.com/south-pointe/ansi/actions/workflows/test.yml/badge.svg)
[![codecov](https://codecov.io/gh/south-pointe/ansi/branch/main/graph/badge.svg?token=1PV8FB4O4O)](https://codecov.io/gh/south-pointe/ansi)
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

## Methods

### Ansi

> This is the main class you should be using to generate the sequence codes.  
All methods in this class are static.

- `Ansi::buffer(): Buffer` Starts a buffered instance. Used for chaining sequences.
- `Ansi::line($text): string` Output text, reset style, and move to the new line.
- `Ansi::bell(): string` Rings the bell.
- `Ansi::backspace(): string` Moves the cursor back.
- `Ansi::tab(): string` Moves the cursor by 8 spaces.
- `Ansi::lineFeed(): string` Moves to the next line and scroll screen up.
- `Ansi::carriageReturn(): string` Moves cursor to column 0.
- `Ansi::cursorUp(int $n = 1): string` Moves the cursor up `$n` rows.
- `Ansi::cursorDown(int $n = 1): string` Moves the cursor down `$n` rows.
- `Ansi::cursorForward(int $n = 1): string` Moves the cursor forward `$n` cells.
- `Ansi::cursorBack(int $n = 1): string` Moves the cursor back `$n` cells.
- `Ansi::cursorNextLine(int $n = 1): string` Moves the cursor to the start of line and move down by `$n`.
- `Ansi::cursorPreviousLine(int $n = 1): string` Moves the cursor to the start of line and move up by `$n`.
- `Ansi::cursorPosition(int $row, int $column): string` Moves the cursor to the specified position.
- `Ansi::eraseScreen(): string` Erases the entire screen.
- `Ansi::eraseToEndOfScreen(): string` Erases from the cursor position to the end of screen.
- `Ansi::eraseFromStartOfScreen(): string` Erases from the start of screen to the cursor position.
- `Ansi::eraseSavedLines(): string` Clears the screen and deletes all lines saved in the scrollback buffer.
- `Ansi::eraseLine(): string` Erases the entire line. Cursor Position will not change.
- `Ansi::eraseToEndOfLine(): string` Erases from cursor position to the end of the line.
- `Ansi::eraseFromStartOfLine(): string` Erases from the start of the line to the cursor position.
- `Ansi::scrollUp(int $lines = 1): string` Scrolls the screen up by `$lines`.
- `Ansi::scrollDown(int $lines = 1): string` Scrolls the screen down by `$lines`.
- `Ansi::resetStyle(): string` Resets the style of the output.
- `Ansi::bold(bool $toggle = true): string` Applies bold styling to succeeding text.
- `Ansi::italic(bool $toggle = true): string` Applies italic styling to succeeding text.
- `Ansi::underline(bool $toggle = true): string` Underlines to succeeding text.
- `Ansi::blink(bool $toggle = true): string` Makes succeeding text blink.
- `Ansi::foreground(Color $color): string` Applies the given color to the foreground font.
- `Ansi::foreground(Color $color): string` Applies the given color to the background font.
- `Ansi::deviceStatusReport(): string` Gives the device status report.
- `Ansi::getTerminalSize(): array{ row: int, column: int }` Get the terminal size of the current terminal.  

### Buffer

> This class should be instantiated by calling `Ansi::buffer()`.  
Buffered class contains all methods in `Ansi` class except `getTerminalSize`.  

- `text(string $text): self` Adds text to buffer.
- `flush(resource $to): self` Flushes all sequences buffered to the given resource.
- `clear(): self` Clears all sequences stored in the buffer.
- `toString(): string` Coverts all buffered sequences to string.

### Color

> Enum that contains shortcut names for 8-bit colors.  
Check out the [actual class](src/Codes/Color.php) for all the names.

- `Color::code(int $code): self` Gets the color by number.  


## License

This is an open-sourced software licensed under the [MIT License](LICENSE).

## References

- [ANSI escape code - Wikipedia](https://en.wikipedia.org/wiki/ANSI_escape_code)
- [ANSI Escape Codes - Gist](https://gist.github.com/fnky/458719343aabd01cfb17a3a4f7296797)
- [Chapter 6. ANSI Escape Sequences: Colours and Cursor Movement - Bash Prompt HOWTO](https://tldp.org/HOWTO/Bash-Prompt-HOWTO/c327.html)
