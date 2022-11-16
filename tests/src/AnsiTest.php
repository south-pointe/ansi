<?php declare(strict_types=1);

namespace Tests\SouthPointe\Ansi;

use InvalidArgumentException;
use SouthPointe\Ansi\Ansi;
use SouthPointe\Ansi\Buffer;
use SouthPointe\Ansi\Codes\Color;
use Tests\SouthPointe\Ansi\Helpers\IntEnumSample;
use Tests\SouthPointe\Ansi\Helpers\StringableSample;
use Tests\SouthPointe\Ansi\Helpers\StringEnumSample;
use const STDOUT;

class AnsiTest extends TestCase
{
    public function test_buffer(): void
    {
        self::assertInstanceOf(Buffer::class, Ansi::buffer());
    }

    public function test_sequence(): void
    {
        self::assertEquals(
            'test' . 'stringable sample' . 'enum sample',
            Ansi::sequence('test', new StringableSample(), StringEnumSample::Case)
        );
    }

    public function test_sequence_with_IntBackedEnum(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a string. Got: integer');
        Ansi::sequence(IntEnumSample::Case);
    }

    public function test_line(): void
    {
        self::assertEquals("\e[0m\r\n", Ansi::line());
        self::assertEquals("t\e[0m\r\n", Ansi::line('t'));
    }

    public function test_bell(): void
    {
        self::assertEquals("\x07", Ansi::bell());
    }

    public function test_backspace(): void
    {
        self::assertEquals("\x08", Ansi::backspace());
    }

    public function test_tab(): void
    {
        self::assertEquals("\t", Ansi::tab());
    }

    public function test_lineFeed(): void
    {
        self::assertEquals("\n", Ansi::lineFeed());
    }

    public function test_carriageReturn(): void
    {
        self::assertEquals("\r", Ansi::carriageReturn());
    }

    public function test_cursorUp(): void
    {
        self::assertEquals("\e[1A", Ansi::cursorUp());
        self::assertEquals("\e[20A", Ansi::cursorUp(20));
        self::assertEquals("", Ansi::cursorUp(0));
    }

    public function test_cursorUp_with_negative_cells(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a value greater than or equal to 0. Got: -1');
        Ansi::cursorUp(-1);
    }

    public function test_cursorDown(): void
    {
        self::assertEquals("\e[1B", Ansi::cursorDown());
        self::assertEquals("\e[20B", Ansi::cursorDown(20));
        self::assertEquals("", Ansi::cursorDown(0));
    }

    public function test_cursorDown_with_negative_cells(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a value greater than or equal to 0. Got: -1');
        Ansi::cursorDown(-1);
    }

    public function test_cursorForward(): void
    {
        self::assertEquals("\e[1C", Ansi::cursorForward());
        self::assertEquals("\e[20C", Ansi::cursorForward(20));
        self::assertEquals("", Ansi::cursorForward(0));
    }

    public function test_cursorForward_with_negative_cells(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a value greater than or equal to 0. Got: -1');
        Ansi::cursorForward(-1);
    }

    public function test_cursorBack(): void
    {
        self::assertEquals("\e[1D", Ansi::cursorBack());
        self::assertEquals("\e[20D", Ansi::cursorBack(20));
        self::assertEquals("", Ansi::cursorBack(0));
    }

    public function test_cursorBack_with_negative_cells(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a value greater than or equal to 0. Got: -1');
        Ansi::cursorBack(-1);
    }

    public function test_cursorNextLine(): void
    {
        self::assertEquals("\e[1E", Ansi::cursorNextLine());
        self::assertEquals("\e[20E", Ansi::cursorNextLine(20));
        self::assertEquals("", Ansi::cursorNextLine(0));
    }

    public function test_cursorNextLine_with_negative_cells(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a value greater than or equal to 0. Got: -1');
        Ansi::cursorNextLine(-1);
    }

    public function test_cursorPreviousLine(): void
    {
        self::assertEquals("\e[1F", Ansi::cursorPreviousLine());
        self::assertEquals("\e[20F", Ansi::cursorPreviousLine(20));
        self::assertEquals("", Ansi::cursorPreviousLine(0));
    }

    public function test_cursorPreviousLine_with_negative_cells(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a value greater than or equal to 0. Got: -1');
        Ansi::cursorPreviousLine(-1);
    }

    public function test_cursorPosition(): void
    {
        self::assertEquals("\e[0;0H", Ansi::cursorPosition(0, 0));
        self::assertEquals("\e[1;2H", Ansi::cursorPosition(1, 2));
        self::assertEquals("\e[-3;3H", Ansi::cursorPosition(-3, 3));
    }

    public function test_eraseScreen(): void
    {
        self::assertEquals("\e[2J", Ansi::eraseScreen());
    }

    public function test_eraseToEndOfScreen(): void
    {
        self::assertEquals("\e[0J", Ansi::eraseToEndOfScreen());
    }

    public function test_eraseFromStartOfScreen(): void
    {
        self::assertEquals("\e[1J", Ansi::eraseFromStartOfScreen());
    }

    public function test_eraseSavedLines(): void
    {
        self::assertEquals("\e[3J", Ansi::eraseSavedLines());
    }

    public function test_eraseLine(): void
    {
        self::assertEquals("\e[2K", Ansi::eraseLine());
    }

    public function test_eraseToEndOfLine(): void
    {
        self::assertEquals("\e[0K", Ansi::eraseToEndOfLine());
    }

    public function test_eraseFromStartOfLine(): void
    {
        self::assertEquals("\e[1K", Ansi::eraseFromStartOfLine());
    }

    public function test_scrollUp(): void
    {
        self::assertEquals("\e[1S", Ansi::scrollUp());
        self::assertEquals("\e[0S", Ansi::scrollUp(0));
        self::assertEquals("\e[20S", Ansi::scrollUp(20));
    }

    public function test_scrollDown(): void
    {
        self::assertEquals("\e[1T", Ansi::scrollDown());
        self::assertEquals("\e[0T", Ansi::scrollDown(0));
        self::assertEquals("\e[20T", Ansi::scrollDown(20));
    }

    public function test_resetStyle(): void
    {
        self::assertEquals("\e[0m", Ansi::resetStyle());
    }

    public function test_bold(): void
    {
        self::assertEquals("\e[1m", Ansi::bold());
        self::assertEquals("\e[22m", Ansi::bold(false));
    }

    public function test_italic(): void
    {
        self::assertEquals("\e[3m", Ansi::italic());
        self::assertEquals("\e[23m", Ansi::italic(false));
    }

    public function test_underline(): void
    {
        self::assertEquals("\e[4m", Ansi::underline());
        self::assertEquals("\e[24m", Ansi::underline(false));
    }

    public function test_blink(): void
    {
        self::assertEquals("\e[5m", Ansi::blink());
        self::assertEquals("\e[25m", Ansi::blink(false));
    }

    public function test_foregroundColor(): void
    {
        self::assertEquals("\e[38;5;9m", Ansi::fgColor(Color::Red));
    }

    public function test_backgroundColor(): void
    {
        self::assertEquals("\e[48;5;9m", Ansi::bgColor(Color::Red));
    }

    public function test_deviceStatusReport(): void
    {
        self::assertEquals("\e[6n", Ansi::deviceStatusReport());
    }

    public function test_getTerminalSize(): void
    {
        if (!posix_isatty(STDOUT)) {
            $this->markTestSkipped('tty required to get terminal size.');
        }

        $position = Ansi::getTerminalSize();
        self::assertArrayHasKey('row', $position);
        self::assertArrayHasKey('column', $position);
        self::assertIsInt($position['row']);
        self::assertIsInt($position['column']);
    }
}
