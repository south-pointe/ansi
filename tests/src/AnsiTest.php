<?php declare(strict_types=1);

namespace Tests\SouthPointe\Ansi;

use AssertionError;
use SouthPointe\Ansi\Ansi;
use SouthPointe\Ansi\Buffer;
use SouthPointe\Ansi\Codes\Color;
use SouthPointe\Ansi\Stream;
use Tests\SouthPointe\Ansi\Helpers\IntEnumSample;
use Tests\SouthPointe\Ansi\Helpers\StringableSample;
use Tests\SouthPointe\Ansi\Helpers\StringEnumSample;
use const STDOUT;

class AnsiTest extends TestCase
{
    public function test_stream(): void
    {
        $this->assertInstanceOf(Stream::class, Ansi::stream());
    }

    public function test_buffer(): void
    {
        $this->assertInstanceOf(Buffer::class, Ansi::buffer());
    }

    public function test_sequence(): void
    {
        $this->assertSame(
            'test' . 'stringable sample' . 'enum sample',
            Ansi::sequence('test', new StringableSample(), StringEnumSample::Case)
        );
    }

    public function test_sequence_with_IntBackedEnum(): void
    {
        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('Expected a string. Got: 1.');
        Ansi::sequence(IntEnumSample::Case);
    }

    public function test_line(): void
    {
        $this->assertSame("\e[0m\r\n", Ansi::line());
        $this->assertSame("t\e[0m\r\n", Ansi::line('t'));
    }

    public function test_bell(): void
    {
        $this->assertSame("\x07", Ansi::bell());
    }

    public function test_backspace(): void
    {
        $this->assertSame("\x08", Ansi::backspace());
    }

    public function test_tab(): void
    {
        $this->assertSame("\t", Ansi::tab());
    }

    public function test_lineFeed(): void
    {
        $this->assertSame("\n", Ansi::lineFeed());
    }

    public function test_carriageReturn(): void
    {
        $this->assertSame("\r", Ansi::carriageReturn());
    }

    public function test_cursorUp(): void
    {
        $this->assertSame("\e[1A", Ansi::cursorUp());
        $this->assertSame("\e[20A", Ansi::cursorUp(20));
        $this->assertSame("", Ansi::cursorUp(0));
    }

    public function test_cursorUp_with_negative_cells(): void
    {
        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('$cells must be >= 0. Got -1.');
        Ansi::cursorUp(-1);
    }

    public function test_cursorDown(): void
    {
        $this->assertSame("\e[1B", Ansi::cursorDown());
        $this->assertSame("\e[20B", Ansi::cursorDown(20));
        $this->assertSame("", Ansi::cursorDown(0));
    }

    public function test_cursorDown_with_negative_cells(): void
    {
        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('$cells must be >= 0. Got -1.');
        Ansi::cursorDown(-1);
    }

    public function test_cursorForward(): void
    {
        $this->assertSame("\e[1C", Ansi::cursorForward());
        $this->assertSame("\e[20C", Ansi::cursorForward(20));
        $this->assertSame("", Ansi::cursorForward(0));
    }

    public function test_cursorForward_with_negative_cells(): void
    {
        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('$cells must be >= 0. Got -1.');
        Ansi::cursorForward(-1);
    }

    public function test_cursorBack(): void
    {
        $this->assertSame("\e[1D", Ansi::cursorBack());
        $this->assertSame("\e[20D", Ansi::cursorBack(20));
        $this->assertSame("", Ansi::cursorBack(0));
    }

    public function test_cursorBack_with_negative_cells(): void
    {
        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('$cells must be >= 0. Got -1.');
        Ansi::cursorBack(-1);
    }

    public function test_cursorNextLine(): void
    {
        $this->assertSame("\e[1E", Ansi::cursorNextLine());
        $this->assertSame("\e[20E", Ansi::cursorNextLine(20));
        $this->assertSame("", Ansi::cursorNextLine(0));
    }

    public function test_cursorNextLine_with_negative_cells(): void
    {
        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('$cells must be >= 0. Got -1.');
        Ansi::cursorNextLine(-1);
    }

    public function test_cursorPreviousLine(): void
    {
        $this->assertSame("\e[1F", Ansi::cursorPreviousLine());
        $this->assertSame("\e[20F", Ansi::cursorPreviousLine(20));
        $this->assertSame("", Ansi::cursorPreviousLine(0));
    }

    public function test_cursorPreviousLine_with_negative_cells(): void
    {
        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage('$cells must be >= 0. Got -1.');
        Ansi::cursorPreviousLine(-1);
    }

    public function test_cursorPosition(): void
    {
        $this->assertSame("\e[0;0H", Ansi::cursorPosition(0, 0));
        $this->assertSame("\e[1;2H", Ansi::cursorPosition(1, 2));
        $this->assertSame("\e[-3;3H", Ansi::cursorPosition(-3, 3));
    }

    public function test_eraseScreen(): void
    {
        $this->assertSame("\e[2J", Ansi::eraseScreen());
    }

    public function test_eraseToEndOfScreen(): void
    {
        $this->assertSame("\e[0J", Ansi::eraseToEndOfScreen());
    }

    public function test_eraseFromStartOfScreen(): void
    {
        $this->assertSame("\e[1J", Ansi::eraseFromStartOfScreen());
    }

    public function test_eraseSavedLines(): void
    {
        $this->assertSame("\e[3J", Ansi::eraseSavedLines());
    }

    public function test_eraseLine(): void
    {
        $this->assertSame("\e[2K", Ansi::eraseLine());
    }

    public function test_eraseToEndOfLine(): void
    {
        $this->assertSame("\e[0K", Ansi::eraseToEndOfLine());
    }

    public function test_eraseFromStartOfLine(): void
    {
        $this->assertSame("\e[1K", Ansi::eraseFromStartOfLine());
    }

    public function test_scrollUp(): void
    {
        $this->assertSame("\e[1S", Ansi::scrollUp());
        $this->assertSame("\e[0S", Ansi::scrollUp(0));
        $this->assertSame("\e[20S", Ansi::scrollUp(20));
    }

    public function test_scrollDown(): void
    {
        $this->assertSame("\e[1T", Ansi::scrollDown());
        $this->assertSame("\e[0T", Ansi::scrollDown(0));
        $this->assertSame("\e[20T", Ansi::scrollDown(20));
    }

    public function test_resetStyle(): void
    {
        $this->assertSame("\e[0m", Ansi::resetStyle());
    }

    public function test_bold(): void
    {
        $this->assertSame("\e[1m", Ansi::bold());
        $this->assertSame("\e[22m", Ansi::bold(false));
    }

    public function test_italic(): void
    {
        $this->assertSame("\e[3m", Ansi::italic());
        $this->assertSame("\e[23m", Ansi::italic(false));
    }

    public function test_underline(): void
    {
        $this->assertSame("\e[4m", Ansi::underline());
        $this->assertSame("\e[24m", Ansi::underline(false));
    }

    public function test_blink(): void
    {
        $this->assertSame("\e[5m", Ansi::blink());
        $this->assertSame("\e[25m", Ansi::blink(false));
    }

    public function test_foregroundColor(): void
    {
        $this->assertSame("\e[38;5;9m", Ansi::fgColor(Color::Red));
    }

    public function test_backgroundColor(): void
    {
        $this->assertSame("\e[48;5;9m", Ansi::bgColor(Color::Red));
    }

    public function test_deviceStatusReport(): void
    {
        $this->assertSame("\e[6n", Ansi::deviceStatusReport());
    }

    public function test_getTerminalSize(): void
    {
        if (!posix_isatty(STDOUT)) {
            $this->markTestSkipped('tty required to get terminal size.');
        }

        $position = Ansi::getTerminalSize();
        $this->assertArrayHasKey('row', $position);
        $this->assertArrayHasKey('column', $position);
        $this->assertIsInt($position['row']);
        $this->assertIsInt($position['column']);
    }
}
