<?php declare(strict_types=1);

namespace Tests\SouthPointe\Ansi\Helpers;

use Stringable;

class StringableSample implements Stringable
{

    public function __toString(): string
    {
        return 'stringable sample';
    }
}
