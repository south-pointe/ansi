<?php declare(strict_types=1);

namespace SouthPointe\Ansi\Codes\Csi;

use SouthPointe\Ansi\Codes\Csi;
use Stringable;

abstract class Sequences implements Stringable
{
    protected function __construct(
        private readonly string $value,
        private readonly Csi $code,
    )
    {
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value . $this->code->value;
    }
}
