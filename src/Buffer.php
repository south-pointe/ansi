<?php declare(strict_types=1);

namespace SouthPointe\Ansi;

use BackedEnum;
use SouthPointe\Ansi\Codes\Color;
use SouthPointe\Ansi\Codes\Sgr;
use Stringable;
use function assert;
use function fwrite;
use function implode;
use function is_resource;
use const STDOUT;

final class Buffer implements Stringable
{
    /**
     * @var list<string>
     */
    protected array $buffer = [];

    /**
     * @param string|Stringable|BackedEnum ...$sequences
     * @return $this
     */
    public function sequence(string|Stringable|BackedEnum ...$sequences): self
    {
        return $this->buffer(Ansi::sequence(...$sequences));
    }

    /**
     * @param string $text
     * @return $this
     */
    public function text(string $text): self
    {
        return $this->buffer(Ansi::text($text));
    }

    /**
     * @param string $text
     * @return $this
     */
    public function line(string $text): self
    {
        return $this->buffer(Ansi::line($text));
    }

    /**
     * @return $this
     */
    public function bell(): self
    {
        return $this->buffer(Ansi::bell());
    }

    /**
     * @return $this
     */
    public function backspace(): self
    {
        return $this->buffer(Ansi::backspace());
    }

    /**
     * @return $this
     */
    public function tab(): self
    {
        return $this->buffer(Ansi::tab());
    }

    /**
     * @return $this
     */
    public function lineFeed(): self
    {
        return $this->buffer(Ansi::lineFeed());
    }

    /**
     * @return $this
     */
    public function carriageReturn(): self
    {
        return $this->buffer(Ansi::carriageReturn());
    }

    /**
     * @param int $cells
     * @return $this
     */
    public function cursorUp(int $cells = 1): self
    {
        return $this->buffer(Ansi::cursorUp($cells));
    }

    /**
     * @param int $cells
     * @return $this
     */
    public function cursorDown(int $cells = 1): self
    {
        return $this->buffer(Ansi::cursorDown($cells));
    }

    /**
     * @param int $cells
     * @return $this
     */
    public function cursorForward(int $cells = 1): self
    {
        return $this->buffer(Ansi::cursorForward($cells));
    }

    /**
     * @param int $cells
     * @return $this
     */
    public function cursorBack(int $cells = 1): self
    {
        return $this->buffer(Ansi::cursorBack($cells));
    }

    /**
     * @param int $cells
     * @return $this
     */
    public function cursorNextLine(int $cells = 1): self
    {
        return $this->buffer(Ansi::cursorNextLine($cells));
    }

    /**
     * @param int $cells
     * @return $this
     */
    public function cursorPreviousLine(int $cells = 1): self
    {
        return $this->buffer(Ansi::cursorPreviousLine($cells));
    }

    /**
     * @param int $row
     * @param int $column
     * @return $this
     */
    public function cursorPosition(int $row, int $column): self
    {
        return $this->buffer(Ansi::cursorPosition($row, $column));
    }

    /**
     * @return $this
     */
    public function eraseScreen(): self
    {
        return $this->buffer(Ansi::eraseScreen());
    }

    /**
     * @return $this
     */
    public function eraseToEndOfScreen(): self
    {
        return $this->buffer(Ansi::eraseToEndOfScreen());
    }

    /**
     * @return $this
     */
    public function eraseFromStartOfScreen(): self
    {
        return $this->buffer(Ansi::eraseFromStartOfScreen());
    }

    /**
     * @return $this
     */
    public function eraseSavedLines(): self
    {
        return $this->buffer(Ansi::eraseSavedLines());
    }

    /**
     * @return $this
     */
    public function eraseLine(): self
    {
        return $this->buffer(Ansi::eraseLine());
    }

    /**
     * @return $this
     */
    public function eraseToEndOfLine(): self
    {
        return $this->buffer(Ansi::eraseToEndOfLine());
    }

    /**
     * @return $this
     */
    public function eraseFromStartOfLine(): self
    {
        return $this->buffer(Ansi::eraseFromStartOfLine());
    }

    /**
     * @param int $lines
     * @return $this
     */
    public function scrollUp(int $lines = 1): self
    {
        return $this->buffer(Ansi::scrollUp($lines));
    }

    /**
     * @param int $lines
     * @return $this
     */
    public function scrollDown(int $lines = 1): self
    {
        return $this->buffer(Ansi::scrollDown($lines));
    }

    /**
     * @return $this
     */
    public function foreground(Color $color): self
    {
        return $this->buffer(Ansi::foreground($color));
    }

    /**
     * @param Color $color
     * @return $this
     */
    public function background(Color $color): self
    {
        return $this->buffer(Ansi::background($color));
    }

    /**
     * @param Color $color
     * @param Sgr $section
     * @return $this
     */
    public function color(Color $color, Sgr $section): self
    {
        return $this->buffer(Ansi::color($color, $section));
    }

    /**
     * @return $this
     */
    public function resetStyle(): self
    {
        return $this->buffer(Ansi::resetStyle());
    }

    /**
     * @param bool $toggle
     * @return $this
     */
    public function bold(bool $toggle = true): self
    {
        return $this->buffer(Ansi::bold($toggle));
    }

    /**
     * @param bool $toggle
     * @return $this
     */
    public function italic(bool $toggle = true): self
    {
        return $this->buffer(Ansi::italic($toggle));
    }

    /**
     * @param bool $toggle
     * @return $this
     */
    public function underline(bool $toggle = true): self
    {
        return $this->buffer(Ansi::underline($toggle));
    }

    /**
     * @return $this
     */
    public function blink(bool $toggle = true): self
    {
        return $this->buffer(Ansi::blink($toggle));
    }


    /**
     * @param resource $to
     * @return $this
     */
    public function flush(mixed $to = STDOUT): self
    {
        assert(is_resource($to), '$to must be a resource type.');

        fwrite($to, $this->toString());
        return $this->clear();
    }

    /**
     * @return $this
     */
    public function clear(): self
    {
        $this->buffer = [];
        return $this;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return implode('', $this->buffer);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * @param string $string
     * @return $this
     */
    protected function buffer(string $string): self
    {
        $this->buffer[] = $string;
        return $this;
    }
}
