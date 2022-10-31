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
use function dump;
use function fread;
use function fwrite;
use function implode;
use function php_sapi_name;
use function shell_exec;
use function sscanf;
use function system;
use function trim;
use const STDIN;
use const STDOUT;

final class Ansi
{
    public static function buffer(): Buffer
    {
        return new Buffer();
    }

    /**
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
     * @param string $text
     * @return string
     */
    public static function text(string $text): string
    {
        return self::sequence($text);
    }

    /**
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
     * @return string
     */
    public static function bell(): string
    {
        return self::sequence(C0::Bell);
    }

    /**
     * @return string
     */
    public static function backspace(): string
    {
        return self::sequence(C0::Backspace);
    }

    /**
     * @return string
     */
    public static function tab(): string
    {
        return self::sequence(C0::Tab);
    }

    /**
     * @return string
     */
    public static function lineFeed(): string
    {
        return self::sequence(C0::LineFeed);
    }

    /**
     * @return string
     */
    public static function carriageReturn(): string
    {
        return self::sequence(C0::CarriageReturn);
    }

    /**
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
     * @param int $row
     * @param int $column
     * @return string
     */
    public static function cursorPosition(int $row, int $column): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Cursor::position($row, $column));
    }

    /**
     * @return string
     */
    public static function eraseScreen(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Erase::screen());
    }

    /**
     * @return string
     */
    public static function eraseToEndOfScreen(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Erase::toEndOfScreen());
    }

    /**
     * @return string
     */
    public static function eraseFromStartOfScreen(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Erase::fromStartOfScreen());
    }

    /**
     * @return string
     */
    public static function eraseSavedLines(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Erase::savedLines());
    }

    /**
     * @return string
     */
    public static function eraseLine(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Erase::line());
    }

    /**
     * @return string
     */
    public static function eraseToEndOfLine(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Erase::toEndOfLine());
    }

    /**
     * @return string
     */
    public static function eraseFromStartOfLine(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Erase::fromStartOfLine());
    }

    /**
     * New lines are added at the bottom.
     *
     * @param int $lines
     * @return string
     */
    public static function scrollUp(int $lines = 1): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Scroll::up($lines));
    }

    /**
     * New lines are added at the bottom.
     *
     * @param int $lines
     * @return string
     */
    public static function scrollDown(int $lines = 1): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Scroll::down($lines));
    }

    /**
     * @return string
     */
    public static function resetStyle(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Sgr::Reset, Csi::Sgr);
    }

    /**
     * @param bool $toggle
     * @return string
     */
    public static function bold(bool $toggle = true): string
    {
        return self::sequence(C0::Escape, Fe::CSI, ($toggle ? Sgr::Bold : Sgr::NormalIntensity), Csi::Sgr);
    }

    /**
     * @param bool $toggle
     * @return string
     */
    public static function italic(bool $toggle = true): string
    {
        return self::sequence(C0::Escape, Fe::CSI, ($toggle ? Sgr::Italic : Sgr::NotItalic), Csi::Sgr);
    }

    /**
     * @param bool $toggle
     * @return string
     */
    public static function underline(bool $toggle = true): string
    {
        return self::sequence(C0::Escape, Fe::CSI, ($toggle ? Sgr::Underline : Sgr::NotUnderlined), Csi::Sgr);
    }

    /**
     * @param bool $toggle
     * @return string
     */
    public static function blink(bool $toggle = true): string
    {
        return self::sequence(C0::Escape, Fe::CSI, ($toggle ? Sgr::Blink : Sgr::NotBlinking), Csi::Sgr);
    }

    /**
     * @see https://en.wikipedia.org/wiki/ANSI_escape_code#8-bit
     * @param Color $color
     * @return string
     */
    public static function foreground(Color $color): string
    {
        return self::color(Sgr::SetForegroundColor, $color);
    }

    /**
     * @see https://en.wikipedia.org/wiki/ANSI_escape_code#8-bit
     * @param Color $color
     * @return string
     */
    public static function background(Color $color): string
    {
        return self::color(Sgr::SetBackgroundColor, $color);
    }

    /**
     * @param Sgr $section
     * @param Color $color
     * @return string
     */
    protected static function color(Sgr $section, Color $color): string
    {
        return self::sequence(C0::Escape, Fe::CSI, $section, $color, Csi::Sgr);
    }

    /**
     * @return string
     */
    public static function deviceStatusReport(): string
    {
        return self::sequence(C0::Escape, Fe::CSI, Csi::DeviceStatusReport);
    }

    /**
     * @return array{ row: int, column: int }
     */
    public static function getTerminalSize(): array
    {
        self::assertCliMode(__METHOD__);

        $current = self::captureDeviceStatusReport();

        // Move as far away as it can to determine the max cursor position.
        fwrite(STDOUT, self::cursorPosition(9999, 9999));

        // get the max position which is the size of the terminal.
        $size = self::captureDeviceStatusReport();

        // Restore cursor position.
        fwrite(STDOUT, self::cursorPosition(...$current));

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
            fwrite(STDOUT, self::deviceStatusReport());
            $code = trim((string) fread(STDIN, 100));
            sscanf($code, "\e[%d;%dR", $row, $column);
            return compact('row', 'column');
        }
        finally {
            system("stty $stty");
        }
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
