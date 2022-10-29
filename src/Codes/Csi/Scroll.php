<?php declare(strict_types=1);

namespace SouthPointe\Ansi\Codes\Csi;

use SouthPointe\Ansi\Codes\Csi;

final class Scroll extends Sequences
{
    /**
     * @param int $lines
     * @return static
     */
    public static function up(int $lines = 1): self
    {
        return new self((string) $lines, Csi::ScrollUp);
    }

    /**
     * @param int $lines
     * @return static
     */
    public static function down(int $lines = 1): self
    {
        return new self((string) $lines, Csi::ScrollDown);
    }
}
