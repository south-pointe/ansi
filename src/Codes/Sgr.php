<?php declare(strict_types=1);

namespace SouthPointe\Ansi\Codes;

enum Sgr: string
{
    case Reset = '0';
    case Bold = '1';
    case Italic = '3';
    case Underline = '4';
    case Blink = '5';
    case NormalIntensity = '22';
    case NotItalic = '23';
    case NotUnderlined = '24';
    case NotBlinking = '25';
    case SetForegroundColor = '38;5;';
    case SetBackgroundColor = '48;5;';
}
