<?php declare(strict_types=1);

namespace Tests\SouthPointe\Ansi;

use InvalidArgumentException;
use SouthPointe\Ansi\Buffer;
use SouthPointe\Ansi\Codes\Color;
use function assert;
use function fread;
use function fseek;
use function is_resource;
use function tmpfile;

class BufferTest extends TestCase
{
    private function buffer(): Buffer
    {
        return new Buffer();
    }

    public function test_text(): void
    {
        $buffer = $this->buffer()->text('test text');

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals('test text', $buffer->toString());
    }

    public function test_line(): void
    {
        $buffer = $this->buffer()->line('t');

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("t\e[0m\r\n", $buffer->toString());
    }

    public function test_bell(): void
    {
        $buffer = $this->buffer()->bell();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\x07", $buffer->toString());
    }

    public function test_backspace(): void
    {
        $buffer = $this->buffer()->backspace();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\x08", $buffer->toString());
    }

    public function test_tab(): void
    {
        $buffer = $this->buffer()->tab();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\t", $buffer->toString());
    }

    public function test_lineFeed(): void
    {
        $buffer = $this->buffer()->lineFeed();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\n", $buffer->toString());
    }

    public function test_carriageReturn(): void
    {
        $buffer = $this->buffer()->carriageReturn();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\r", $buffer->toString());
    }

    public function test_cursorUp(): void
    {
        $buffer = $this->buffer()->cursorUp();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[1A", $buffer->toString());
    }

    public function test_cursorDown(): void
    {
        $buffer = $this->buffer()->cursorDown();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[1B", $buffer->toString());
    }

    public function test_cursorForward(): void
    {
        $buffer = $this->buffer()->cursorForward();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[1C", $buffer->toString());
    }

    public function test_cursorBack(): void
    {
        $buffer = $this->buffer()->cursorBack();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[1D", $buffer->toString());
    }

    public function test_cursorNextLine(): void
    {
        $buffer = $this->buffer()->cursorNextLine();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[1E", $buffer->toString());
    }

    public function test_cursorPreviousLine(): void
    {
        $buffer = $this->buffer()->cursorPreviousLine();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[1F", $buffer->toString());
    }

    public function test_cursorPosition(): void
    {
        $buffer = $this->buffer()->cursorPosition(1, 2);

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[1;2H", $buffer->toString());
    }

    public function test_eraseScreen(): void
    {
        $buffer = $this->buffer()->eraseScreen();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[2J", $buffer->toString());
    }

    public function test_eraseToEndOfScreen(): void
    {
        $buffer = $this->buffer()->eraseToEndOfScreen();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[0J", $buffer->toString());
    }

    public function test_eraseFromStartOfScreen(): void
    {
        $buffer = $this->buffer()->eraseFromStartOfScreen();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[1J", $buffer->toString());
    }

    public function test_eraseSavedLines(): void
    {
        $buffer = $this->buffer()->eraseSavedLines();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[3J", $buffer->toString());
    }

    public function test_eraseLine(): void
    {
        $buffer = $this->buffer()->eraseLine();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[2K", $buffer->toString());
    }

    public function test_eraseToEndOfLine(): void
    {
        $buffer = $this->buffer()->eraseToEndOfLine();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[0K", $buffer->toString());
    }

    public function test_eraseFromStartOfLine(): void
    {
        $buffer = $this->buffer()->eraseFromStartOfLine();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[1K", $buffer->toString());
    }

    public function test_scrollUp(): void
    {
        $buffer = $this->buffer()->scrollUp();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[1S", $buffer->toString());
    }

    public function test_scrollDown(): void
    {
        $buffer = $this->buffer()->scrollDown();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[1T", $buffer->toString());
    }

    public function test_resetStyle(): void
    {
        $buffer = $this->buffer()->resetStyle();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[0m", $buffer->toString());
    }

    public function test_bold(): void
    {
        $buffer = $this->buffer()->bold();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[1m", $buffer->toString());
    }

    public function test_italic(): void
    {
        $buffer = $this->buffer()->italic();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[3m", $buffer->toString());
    }

    public function test_underline(): void
    {
        $buffer = $this->buffer()->underline();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[4m", $buffer->toString());
    }

    public function test_blink(): void
    {
        $buffer = $this->buffer()->blink();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[5m", $buffer->toString());
    }

    public function test_foregroundColor(): void
    {
        $buffer = $this->buffer()->foregroundColor(Color::Red);

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[38;5;9m", $buffer->toString());
    }

    public function test_backgroundColor(): void
    {
        $buffer = $this->buffer()->backgroundColor(Color::Red);

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals("\e[48;5;9m", $buffer->toString());
    }

    public function test_clear(): void
    {
        $buffer = $this->buffer()
            ->text('1')
            ->clear();

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals('', $buffer->toString());
    }

    public function test_flush(): void
    {
        $temp = tmpfile();
        assert(is_resource($temp));

        $buffer = $this->buffer()->text('1')->flush($temp);
        fseek($temp, 0);

        self::assertInstanceOf(Buffer::class, $buffer);
        self::assertEquals('1', fread($temp, 10));
    }

    public function test_flush_non_resource(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a resource. Got: integer');
        $this->buffer()->flush(1);
    }

    public function test_toString(): void
    {
        self::assertEquals('', $this->buffer()->toString());

        $string = $this->buffer()
            ->text('1')
            ->resetStyle()
            ->toString();

        self::assertIsString($string);
        self::assertEquals("1\e[0m", $string);
    }

    public function test_cast_to_string(): void
    {
        self::assertEquals('a', (string) $this->buffer()->text('a'));
    }
}
