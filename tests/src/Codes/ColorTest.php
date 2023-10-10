<?php declare(strict_types=1);

namespace Tests\SouthPointe\Ansi\Codes;

use AssertionError;
use SouthPointe\Ansi\Codes\Color;
use Tests\SouthPointe\Ansi\TestCase;

class ColorTest extends TestCase
{
    public function test_code(): void
    {
        $color = Color::code(0);

        self::assertEquals(Color::Black, $color);
    }

    public function test_code_out_of_bound(): void
    {
        $this->expectException(AssertionError::class);
        $this->expectExceptionMessage("Expected code: 256 to exist.");
        Color::code(256);
    }
}
