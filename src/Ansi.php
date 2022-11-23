<?php declare(strict_types=1);

namespace SouthPointe\Ansi;

use BackedEnum;
use SouthPointe\Ansi\Codes\C0;
use SouthPointe\Ansi\Codes\Color;
use SouthPointe\Ansi\Codes\Csi;
use SouthPointe\Ansi\Codes\Csi\Cursor;
use SouthPointe\Ansi\Codes\Csi\Erase;
use SouthPointe\Ansi\Codes\Csi\Scroll;
use SouthPointe\Ansi\Codes\Fe;
use SouthPointe\Ansi\Codes\Sgr;
use Stringable;
use Webmozart\Assert\Assert;
use function assert;
use function compact;
use function fopen;
use function fread;
use function fwrite;
use function implode;
use function php_sapi_name;
use function shell_exec;
use function sscanf;
use function system;
use function trim;

final class Ansi
{
    /**
     * Returns a similar ANSI instance which can be used to chain several sequences.
     * @return Buffer
     */
    public static function buffer(): Buffer
    {
        return new Buffer();
    }

    /**
     * Turns given sequences into proper string format.
     *
     * @param string|Stringable|BackedEnum ...$sequences
     * @return string
     */
    public static function sequence(string|Stringable|BackedEnum ...$sequences): string
    {
        $casted = [];

        foreach ($sequences as $sequence) {
            $string = match (true) {
                $sequence instanceof BackedEnum => $sequence->value,
                $sequence instanceof Stringable => $sequence->__toString(),
                default => $sequence,
            };
            Assert::string($string);
            $casted[] = $string;
        }

        return implode('', $casted);
    }

    /**
     * A Returns ANSI codes which combines the following sequences.
     * - The given text
     * - Reset style
     * - Carriage return
     * - Line feed
     *
     * @param string $text
     * @return string
     */
    public static function line(string $text = ''): string
    {
        return
            self::sequence($text) .
            self::resetStyle() .
            self::carriageReturn() .
            self::lineFeed();
    }

    /**
     * Returns ANSI codes for ringing the bell.
     *
     * @return string
     */
    public static function bell(): string
    {
        return self::sequence(C0::Bell);
    }

    /**
     * Returns ANSI codes for moving the cursor back.
     *
     * @return string
     */
    public static function backspace(): string
    {
        return self::sequence(C0::Backspace);
    }

    /**
     * Returns ANSI codes for moving the cursor to the right 8 times.
     *
     * @return string
     */
    public static function tab(): string
    {
        return self::sequence(C0::Tab);
    }

    /**
     * Returns ANSI codes for moving to the next line and scrolling the display up
     * if the cursor is at bottom of the screen.
     *
     * @return string
     */
    public static function lineFeed(): string
    {
        return self::sequence(C0::LineFeed);
    }

    /**
     * Returns ANSI codes for moving the cursor to column 0.
     *
     * @return string
     */
    public static function carriageReturn(): string
    {
        return self::sequence(C0::CarriageReturn);
    }

    /**
     * Returns ANSI codes which will move the cursor up by the given amount.
     *
     * @param int $cells
     * @return string
     */
    public static function cursorUp(int $cells = 1): string
    {
        Assert::greaterThanEq($cells, 0);
        return $cells > 0
            ? self::sequence(C0::Escape, Fe::CSI, Cursor::up($cells))
            : '';
    }

    /**
     * Returns ANSI codes which will move the cursor down by the given amount.
     *
     * @param int $cells
     * @return string
     */
    public static function cursorDown(int $cells = 1): string
    {
        Assert::greaterThanEq($cells, 0);
        return $cells > 0
            ? self::sequence(C0::Escape, Fe::CSI, Cursor::down($cells))
            : '';
    }

    /**
     * Returns ANSI codes which will move the cursor forward by the given amount.
     *
     * @param int $cells
     * @return string
     */
    public static function cursorForward(int $cells = 1): string
    {
        Assert::greaterThanEq($cells, 0);
        return $cells > 0
            ? self::sequence(C0::Escape, Fe::CSI, Cursor::forward($cells))
            : '';
    }

    /**
     * Returns ANSI codes which will move the cursor backwards by the given amount.
     *
     * @param int $cells
     * @return string
     */
    public static function cursorBack(int $cells = 1): string
    {
        Assert::greaterThanEq($cells, 0);
        return $cells > 0
            ? self::sequence(C0::Escape, Fe::CSI, Cursor::back($cells))
            : '';
    }

    /**
     * Returns ANSI codes which moves cursor to the beginning of line, and move down by the given amount.
     *
     * @param int $cells
     * @return string
     */
    public static function cursorNextLine(int $cells = 1): string
    {
        Assert::greaterThanEq($cells, 0);
        return $cells > 0
            ? self::sequence(C0::Escape, Fe::CSI, Cursor::nextLine($cells))
            : '';
    }

    /**
     * Returns ANSI codes which moves cursor to the beginning of line, and move up by the given amount.
     *
     * @param int $cells
     * @return string
     */
    public static function cursorPreviousLine(int $cells = 1): string
    {
        Assert::greaterThanEq($cells, 0);
        return $cells > 0
            ? self::sequence(C0::Escape, Fe::CSI, Cursor::prevLine($cells))
            : '';
    }

    /**
     * Returns ANSI codes which moves the cursor to the given position.
     * In order to get the current position, { @see self::getTerminalSize() }
     *
     * @param int $row
     * @param int $column
     * @return string
     */
    public static function cursorPosition(int $row, int $column): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Cursor::position($row, $column));
    }

    /**
     * Returns ANSI codes which will erase the entire screen.
     *
     * @return string
     */
    public static function eraseScreen(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Erase::screen());
    }

    /**
     * Returns ANSI codes which will erase from the cursor position to the end of screen.
     *
     * @return string
     */
    public static function eraseToEndOfScreen(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Erase::toEndOfScreen());
    }

    /**
     * Returns ANSI codes which will erase from the start of screen to the cursor position.
     *
     * @return string
     */
    public static function eraseFromStartOfScreen(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Erase::fromStartOfScreen());
    }

    /**
     * Returns ANSI codes which clears the screen and deletes all lines saved in the scrollback buffer.
     *
     * @return string
     */
    public static function eraseSavedLines(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Erase::savedLines());
    }

    /**
     * Returns ANSI codes which erases the entire line.
     * Cursor position will not change.
     *
     * @return string
     */
    public static function eraseLine(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Erase::line());
    }

    /**
     * Returns ANSI codes which erase from cursor position to the end of the line.
     * @return string
     */
    public static function eraseToEndOfLine(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Erase::toEndOfLine());
    }

    /**
     * Returns ANSI codes which erases from the beginning of the line to the cursor position.
     * @return string
     */
    public static function eraseFromStartOfLine(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Erase::fromStartOfLine());
    }

    /**
     * Returns ANSI codes which will scroll the screen up by a given amount.
     *
     * @param int $lines
     * @return string
     */
    public static function scrollUp(int $lines = 1): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Scroll::up($lines));
    }

    /**
     * Returns ANSI codes which will scroll the screen down by a given amount.
     *
     * @param int $lines
     * @return string
     */
    public static function scrollDown(int $lines = 1): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Scroll::down($lines));
    }

    /**
     * Returns ANSI codes which will reset the style of the output.
     *
     * @return string
     */
    public static function resetStyle(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Sgr::Reset, Csi::Sgr);
    }

    /**
     * Returns ANSI codes which applies bold styling to succeeding text.
     *
     * @param bool $toggle
     * @return string
     */
    public static function bold(bool $toggle = true): string
    {
        return self::sequence(C0::Escape, Fe::CSI, ($toggle ? Sgr::Bold : Sgr::NormalIntensity), Csi::Sgr);
    }

    /**
     * Returns ANSI codes which applies italic styling to succeeding text.
     *
     * @param bool $toggle
     * @return string
     */
    public static function italic(bool $toggle = true): string
    {
        return self::sequence(C0::Escape, Fe::CSI, ($toggle ? Sgr::Italic : Sgr::NotItalic), Csi::Sgr);
    }

    /**
     * Returns ANSI codes which underlines to succeeding text.
     *
     * @param bool $toggle
     * @return string
     */
    public static function underline(bool $toggle = true): string
    {
        return self::sequence(C0::Escape, Fe::CSI, ($toggle ? Sgr::Underline : Sgr::NotUnderlined), Csi::Sgr);
    }

    /**
     * Returns ANSI codes which makes succeeding text blink.
     *
     * @param bool $toggle
     * @return string
     */
    public static function blink(bool $toggle = true): string
    {
        return self::sequence(C0::Escape, Fe::CSI, ($toggle ? Sgr::Blink : Sgr::NotBlinking), Csi::Sgr);
    }

    /**
     * Returns ANSI codes which applies the given color to the foreground font.
     *
     * @see https://en.wikipedia.org/wiki/ANSI_escape_code#8-bit
     * @param Color $color
     * @return string
     */
    public static function fgColor(Color $color): string
    {
        return self::color(Sgr::SetForegroundColor, $color);
    }

    /**
     * Returns ANSI codes which applies the given color to the background font.
     *
     * @see https://en.wikipedia.org/wiki/ANSI_escape_code#8-bit
     * @param Color $color
     * @return string
     */
    public static function bgColor(Color $color): string
    {
        return self::color(Sgr::SetBackgroundColor, $color);
    }

    /**
     * Returns ANSI codes which applies the given color to foreground or background.
     *
     * @param Sgr $section
     * @param Color $color
     * @return string
     */
    protected static function color(Sgr $section, Color $color): string
    {
        return self::sequence(C0::Escape, Fe::CSI, $section, ';5;', $color, Csi::Sgr);
    }

    /**
     * Returns ANSI codes which gives the device status report.
     *
     * @return string
     */
    public static function deviceStatusReport(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Csi::DeviceStatusReport);
    }

    /**
     * A helper method which will get the terminal size of the current terminal.
     *
     * @return array{ row: int, column: int }
     */
    public static function getTerminalSize(): array
    {
        self::assertCliMode(__METHOD__);

        $stdout = self::getStdout();

        $current = self::captureDeviceStatusReport();

        // Move as far away as it can to determine the max cursor position.
        fwrite($stdout, self::cursorPosition(9999, 9999));

        // get the max position which is the size of the terminal.
        $size = self::captureDeviceStatusReport();

        // Restore cursor position.
        fwrite($stdout, self::cursorPosition(...$current));

        return $size;
    }

    /**
     * @return array{ row: int, column: int }
     */
    private static function captureDeviceStatusReport(): array
    {
        // backup original stty mode
        $stty = trim((string) shell_exec('stty -g'));

        // set stty mode
        system("stty -icanon -echo");

        try {
            $stdout = self::getStdout();
            fwrite($stdout, self::deviceStatusReport());
            $code = trim((string) fread(self::getStdin(), 100));
            sscanf($code, "\e[%d;%dR", $row, $column);
            return compact('row', 'column');
        }
        finally {
            system("stty $stty");
        }
    }

    /**
     * @return resource
     */
    private static function getStdout(): mixed
    {
        $stdout = fopen('php://stdout', 'w');
        assert($stdout !== false);
        return $stdout;
    }

    /**
     * @return resource
     */
    private static function getStdin(): mixed
    {
        $stdin = fopen('php://stdin', 'r');
        assert($stdin !== false);
        return $stdin;
    }

    /**
     * @param string $function
     * @return void
     */
    private static function assertCliMode(string $function): void
    {
        assert(php_sapi_name() === 'cli', "$function only works in cli mode.");
    }
}
