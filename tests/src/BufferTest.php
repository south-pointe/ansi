<?php declare(strict_types=1);

namespace Tests\SouthPointe\Ansi;

use SouthPointe\Ansi\Buffer;
use SouthPointe\Ansi\Codes\Color;

class BufferTest extends TestCase
{
    private function buffer(): Buffer
    {
        return new Buffer();
    }

    public function test_text(): void
    {
        $buffer = $this->buffer()->text('test text');

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame('test text', $buffer->toString());
    }

    public function test_line(): void
    {
        $buffer = $this->buffer()->line('t');

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("t\e[0m\r\n", $buffer->toString());
    }

    public function test_bell(): void
    {
        $buffer = $this->buffer()->bell();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\x07", $buffer->toString());
    }

    public function test_backspace(): void
    {
        $buffer = $this->buffer()->backspace();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\x08", $buffer->toString());
    }

    public function test_tab(): void
    {
        $buffer = $this->buffer()->tab();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\t", $buffer->toString());
    }

    public function test_lineFeed(): void
    {
        $buffer = $this->buffer()->lineFeed();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\n", $buffer->toString());
    }

    public function test_carriageReturn(): void
    {
        $buffer = $this->buffer()->carriageReturn();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\r", $buffer->toString());
    }

    public function test_cursorUp(): void
    {
        $buffer = $this->buffer()->cursorUp();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[1A", $buffer->toString());
    }

    public function test_cursorDown(): void
    {
        $buffer = $this->buffer()->cursorDown();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[1B", $buffer->toString());
    }

    public function test_cursorForward(): void
    {
        $buffer = $this->buffer()->cursorForward();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[1C", $buffer->toString());
    }

    public function test_cursorBack(): void
    {
        $buffer = $this->buffer()->cursorBack();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[1D", $buffer->toString());
    }

    public function test_cursorNextLine(): void
    {
        $buffer = $this->buffer()->cursorNextLine();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[1E", $buffer->toString());
    }

    public function test_cursorPreviousLine(): void
    {
        $buffer = $this->buffer()->cursorPreviousLine();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[1F", $buffer->toString());
    }

    public function test_cursorPosition(): void
    {
        $buffer = $this->buffer()->cursorPosition(1, 2);

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[1;2H", $buffer->toString());
    }

    public function test_eraseScreen(): void
    {
        $buffer = $this->buffer()->eraseScreen();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[2J", $buffer->toString());
    }

    public function test_eraseToEndOfScreen(): void
    {
        $buffer = $this->buffer()->eraseToEndOfScreen();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[0J", $buffer->toString());
    }

    public function test_eraseFromStartOfScreen(): void
    {
        $buffer = $this->buffer()->eraseFromStartOfScreen();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[1J", $buffer->toString());
    }

    public function test_eraseSavedLines(): void
    {
        $buffer = $this->buffer()->eraseSavedLines();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[3J", $buffer->toString());
    }

    public function test_eraseLine(): void
    {
        $buffer = $this->buffer()->eraseLine();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[2K", $buffer->toString());
    }

    public function test_eraseToEndOfLine(): void
    {
        $buffer = $this->buffer()->eraseToEndOfLine();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[0K", $buffer->toString());
    }

    public function test_eraseFromStartOfLine(): void
    {
        $buffer = $this->buffer()->eraseFromStartOfLine();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[1K", $buffer->toString());
    }

    public function test_scrollUp(): void
    {
        $buffer = $this->buffer()->scrollUp();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[1S", $buffer->toString());
    }

    public function test_scrollDown(): void
    {
        $buffer = $this->buffer()->scrollDown();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[1T", $buffer->toString());
    }

    public function test_resetStyle(): void
    {
        $buffer = $this->buffer()->resetStyle();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[0m", $buffer->toString());
    }

    public function test_bold(): void
    {
        $buffer = $this->buffer()->bold();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[1m", $buffer->toString());
    }

    public function test_italic(): void
    {
        $buffer = $this->buffer()->italic();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[3m", $buffer->toString());
    }

    public function test_underline(): void
    {
        $buffer = $this->buffer()->underline();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[4m", $buffer->toString());
    }

    public function test_blink(): void
    {
        $buffer = $this->buffer()->blink();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[5m", $buffer->toString());
    }

    public function test_foregroundColor(): void
    {
        $buffer = $this->buffer()->fgColor(Color::Red);

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[38;5;9m", $buffer->toString());
    }

    public function test_backgroundColor(): void
    {
        $buffer = $this->buffer()->bgColor(Color::Red);

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame("\e[48;5;9m", $buffer->toString());
    }

    public function test_extract(): void
    {
        $buffer = $this->buffer();

        $string = $buffer
            ->text('1')
            ->extract();

        $this->assertSame('1', $string);
        $this->assertSame('', $buffer->toString());
    }

    public function test_clear(): void
    {
        $buffer = $this->buffer()
            ->text('1')
            ->clear();

        $this->assertInstanceOf(Buffer::class, $buffer);
        $this->assertSame('', $buffer->toString());
    }

    public function test_toString(): void
    {
        $this->assertSame('', $this->buffer()->toString());

        $string = $this->buffer()
            ->text('1')
            ->resetStyle()
            ->toString();

        $this->assertIsString($string);
        $this->assertSame("1\e[0m", $string);
    }

    public function test_cast_to_string(): void
    {
        $this->assertSame('a', (string) $this->buffer()->text('a'));
    }
}
