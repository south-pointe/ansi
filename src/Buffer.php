<?php declare(strict_types=1);

namespace SouthPointe\Ansi;

use SouthPointe\Ansi\Codes\Color;
use Stringable;
use Webmozart\Assert\Assert;
use function fwrite;
use function implode;
use const STDOUT;

final class Buffer implements Stringable
{
    /**
     * @var list<string>
     */
    protected array $buffer = [];

    /**
     * Add text to buffer.
     *
     * @param string $text
     * @return $this
     */
    public function text(string $text): self
    {
        return $this->buffer(Ansi::sequence($text));
    }

    /**
     * Add the following sequences to buffer.
     * - The given text
     * - Reset style
     * - Carriage return
     * - Line feed
     *
     * @param string $text
     * @return $this
     */
    public function line(string $text): self
    {
        return $this->buffer(Ansi::line($text));
    }

    /**
     * Add a bell ringer to buffer.
     *
     * @return $this
     */
    public function bell(): self
    {
        return $this->buffer(Ansi::bell());
    }

    /**
     * Add a backspace sequence to buffer.
     *
     * @return $this
     */
    public function backspace(): self
    {
        return $this->buffer(Ansi::backspace());
    }

    /**
     * Add a tab sequence to buffer.
     *
     * @return $this
     */
    public function tab(): self
    {
        return $this->buffer(Ansi::tab());
    }

    /**
     * Add a line feed to buffer.
     *
     * @return $this
     */
    public function lineFeed(): self
    {
        return $this->buffer(Ansi::lineFeed());
    }

    /**
     * Add a carriage return to buffer.
     *
     * @return $this
     */
    public function carriageReturn(): self
    {
        return $this->buffer(Ansi::carriageReturn());
    }

    /**
     * Add sequences to buffer which will move the cursor up by a given amount.
     *
     * @param int $cells
     * @return $this
     */
    public function cursorUp(int $cells = 1): self
    {
        return $this->buffer(Ansi::cursorUp($cells));
    }

    /**
     * Add sequences to buffer which will move the cursor down by a given amount.
     *
     * @param int $cells
     * @return $this
     */
    public function cursorDown(int $cells = 1): self
    {
        return $this->buffer(Ansi::cursorDown($cells));
    }

    /**
     * Add sequences to buffer which will move the cursor forward by a given amount.
     *
     * @param int $cells
     * @return $this
     */
    public function cursorForward(int $cells = 1): self
    {
        return $this->buffer(Ansi::cursorForward($cells));
    }

    /**
     * Add sequences to buffer which will move the cursor back by a given amount.
     *
     * @param int $cells
     * @return $this
     */
    public function cursorBack(int $cells = 1): self
    {
        return $this->buffer(Ansi::cursorBack($cells));
    }

    /**
     * Add sequences to buffer which will move the cursor to the beginning of the next line.
     *
     * @param int $cells
     * @return $this
     */
    public function cursorNextLine(int $cells = 1): self
    {
        return $this->buffer(Ansi::cursorNextLine($cells));
    }

    /**
     * Add a sequences to buffer which will move the cursor to the beginning of the previous line.
     *
     * @param int $cells
     * @return $this
     */
    public function cursorPreviousLine(int $cells = 1): self
    {
        return $this->buffer(Ansi::cursorPreviousLine($cells));
    }

    /**
     * Add a sequences to buffer which will move the cursor to the given position.
     *
     * @param int $row
     * @param int $column
     * @return $this
     */
    public function cursorPosition(int $row, int $column): self
    {
        return $this->buffer(Ansi::cursorPosition($row, $column));
    }

    /**
     * Add sequences to buffer which will erase the entire screen.
     *
     * @return $this
     */
    public function eraseScreen(): self
    {
        return $this->buffer(Ansi::eraseScreen());
    }

    /**
     * Add sequences to buffer which will erase from cursor position to the end of screen.
     *
     * @return $this
     */
    public function eraseToEndOfScreen(): self
    {
        return $this->buffer(Ansi::eraseToEndOfScreen());
    }

    /**
     * Add sequences to buffer which will erase from start of screen to the cursor position.
     *
     * @return $this
     */
    public function eraseFromStartOfScreen(): self
    {
        return $this->buffer(Ansi::eraseFromStartOfScreen());
    }

    /**
     * Add sequences to buffer which will erase all lines saved in the scrollback buffer.
     *
     * @return $this
     */
    public function eraseSavedLines(): self
    {
        return $this->buffer(Ansi::eraseSavedLines());
    }

    /**
     * Add sequences to buffer which will erases the entire line.
     * Cursor position will not change.
     *
     * @return $this
     */
    public function eraseLine(): self
    {
        return $this->buffer(Ansi::eraseLine());
    }

    /**
     * Add sequences to buffer which will erase from cursor position to the end of the line.
     *
     * @return $this
     */
    public function eraseToEndOfLine(): self
    {
        return $this->buffer(Ansi::eraseToEndOfLine());
    }

    /**
     * Add sequences to buffer which will erase from start of the line to cursor position.
     *
     * @return $this
     */
    public function eraseFromStartOfLine(): self
    {
        return $this->buffer(Ansi::eraseFromStartOfLine());
    }

    /**
     * Add sequences to buffer which will scroll the screen up by a given amount.
     *
     * @param int $lines
     * @return $this
     */
    public function scrollUp(int $lines = 1): self
    {
        return $this->buffer(Ansi::scrollUp($lines));
    }

    /**
     * Add sequences to buffer which will scroll the screen down by a given amount.
     *
     * @param int $lines
     * @return $this
     */
    public function scrollDown(int $lines = 1): self
    {
        return $this->buffer(Ansi::scrollDown($lines));
    }

    /**
     * Add sequences to buffer which will reset all applied styles.
     *
     * @return $this
     */
    public function resetStyle(): self
    {
        return $this->buffer(Ansi::resetStyle());
    }

    /**
     * Add sequences to buffer which will apply bold styling to succeeding text.
     *
     * @param bool $toggle
     * @return $this
     */
    public function bold(bool $toggle = true): self
    {
        return $this->buffer(Ansi::bold($toggle));
    }

    /**
     * Add sequences to buffer which will apply italic styling to succeeding text.
     *
     * @param bool $toggle
     * @return $this
     */
    public function italic(bool $toggle = true): self
    {
        return $this->buffer(Ansi::italic($toggle));
    }

    /**
     * Add sequences to buffer which will add underline to succeeding text.
     *
     * @param bool $toggle
     * @return $this
     */
    public function underline(bool $toggle = true): self
    {
        return $this->buffer(Ansi::underline($toggle));
    }

    /**
     * Add sequences to buffer which will make succeeding text blink.
     *
     * @return $this
     */
    public function blink(bool $toggle = true): self
    {
        return $this->buffer(Ansi::blink($toggle));
    }

    /**
     * Add sequences to buffer which will apply the given color to the foreground on succeeding text.
     *
     * @return $this
     */
    public function foreground(Color $color): self
    {
        return $this->buffer(Ansi::foreground($color));
    }

    /**
     * Add sequences to buffer which will apply the given color to the background on succeeding text.
     *
     * @param Color $color
     * @return $this
     */
    public function background(Color $color): self
    {
        return $this->buffer(Ansi::background($color));
    }

    /**
     * Flush the buffer to the given resource.
     *
     * @param resource $to
     * @return $this
     */
    public function flush(mixed $to = STDOUT): self
    {
        Assert::resource($to);
        fwrite($to, $this->toString());
        return $this->clear();
    }

    /**
     * Clears all buffer.
     *
     * @return $this
     */
    public function clear(): self
    {
        $this->buffer = [];
        return $this;
    }

    /**
     * Concatenates the buffer and output it as string.
     *
     * @return string
     */
    public function toString(): string
    {
        return implode('', $this->buffer);
    }

    /**
     * @see self::toString
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * Add the given string to buffer and return itself for convenience.
     *
     * @param string $string
     * @return $this
     */
    protected function buffer(string $string): self
    {
        $this->buffer[] = $string;
        return $this;
    }
}
