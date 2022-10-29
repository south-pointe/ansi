<?php declare(strict_types=1);

namespace SouthPointe\Ansi\Codes;

enum C0: string
{
    /**
     * Makes an audible noise
     */
    case Bell = "\x07";

    /**
     * Moves back the cursor. \b does not work for some reason.
     */
    case Backspace = "\x08";

    /**
     * Moves the cursor right 8 times
     * Alias: \x09
     */
    case Tab = "\t";

    /**
     * Move to next line and scrolls the display up if at bottom of the screen
     * Alias: \x0A
     */
    case LineFeed = "\n";

    /**
     * Moves the cursor to column zero
     * Alias: \x0D
     */
    case CarriageReturn = "\r";

    /**
     * Starts all the escape sequences
     * Alias: \x1B
     */
    case Escape = "\e";
}
