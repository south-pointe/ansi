<?php declare(strict_types=1);

namespace SouthPointe\Ansi\Codes;

use function array_key_exists;

enum Color: string
{
    case Black = '0';
    case Maroon = '1';
    case Green = '2';
    case Olive = '3';
    case Navy = '4';
    case Purple = '5';
    case Teal = '6';
    case Silver = '7';
    case Gray = '8';
    case Red = '9';
    case Lime = '10';
    case Yellow = '11';
    case Blue = '12';
    case Fuchsia = '13';
    case Aqua = '14';
    case White = '15';
    case Gray0 = '16';
    case NavyBlue = '17';
    case DarkBlue = '18';
    case Blue3_A = '19';
    case Blue3_B = '20';
    case Blue1 = '21';
    case DarkGreen = '22';
    case DeepSkyBlue4_A = '23';
    case DeepSkyBlue4_B = '24';
    case DeepSkyBlue4_C = '25';
    case DodgerBlue3 = '26';
    case DodgerBlue2 = '27';
    case Green4 = '28';
    case SpringGreen4 = '29';
    case Turquoise4 = '30';
    case DeepSkyBlue3_A = '31';
    case DeepSkyBlue3_B = '32';
    case DodgerBlue1 = '33';
    case Green3_A = '34';
    case SpringGreen3_A = '35';
    case DarkCyan = '36';
    case LightSeaGreen = '37';
    case DeepSkyBlue2 = '38';
    case DeepSkyBlue1 = '39';
    case Green3_2 = '40';
    case SpringGreen3_B = '41';
    case SpringGreen2_A = '42';
    case Cyan3 = '43';
    case DarkTurquoise = '44';
    case Turquoise2 = '45';
    case Green1 = '46';
    case SpringGreen2_B = '47';
    case SpringGreen1 = '48';
    case MediumSpringGreen = '49';
    case Cyan2 = '50';
    case Cyan1 = '51';
    case DarkRed_A = '52';
    case DeepPink4_A = '53';
    case Purple4_A = '54';
    case Purple4_B = '55';
    case Purple3 = '56';
    case BlueViolet = '57';
    case Orange4_A = '58';
    case Gray37 = '59';
    case MediumPurple4 = '60';
    case SlateBlue3_A = '61';
    case SlateBlue3_B = '62';
    case RoyalBlue1 = '63';
    case Chartreuse4 = '64';
    case DarkSeaGreen4_A = '65';
    case PaleTurquoise4 = '66';
    case SteelBlue = '67';
    case SteelBlue3 = '68';
    case CornflowerBlue = '69';
    case Chartreuse3_A = '70';
    case DarkSeaGreen4_B = '71';
    case CadetBlue_A = '72';
    case CadetBlue_B = '73';
    case SkyBlue3 = '74';
    case SteelBlue1_A = '75';
    case Chartreuse3_B = '76';
    case PaleGreen3_A = '77';
    case SeaGreen3 = '78';
    case Aquamarine3 = '79';
    case MediumTurquoise = '80';
    case SteelBlue1_B = '81';
    case Chartreuse2_A = '82';
    case SeaGreen2 = '83';
    case SeaGreen1_A = '84';
    case SeaGreen1_B = '85';
    case Aquamarine1_A = '86';
    case DarkSlateGray2 = '87';
    case DarkRed_B = '88';
    case DeepPink4_B = '89';
    case DarkMagenta_A = '90';
    case DarkMagenta_B = '91';
    case DarkViolet_A = '92';
    case Purple_A = '93';
    case Orange4_B = '94';
    case LightPink4 = '95';
    case Plum4 = '96';
    case MediumPurple3_A = '97';
    case MediumPurple3_B = '98';
    case SlateBlue1 = '99';
    case Yellow4_A = '100';
    case Wheat4 = '101';
    case Gray53 = '102';
    case LightSlateGray = '103';
    case MediumPurple = '104';
    case LightSlateBlue = '105';
    case Yellow4_B = '106';
    case DarkOliveGreen3_A = '107';
    case DarkSeaGreen = '108';
    case LightSkyBlue3_A = '109';
    case LightSkyBlue3_B = '110';
    case SkyBlue2 = '111';
    case Chartreuse2_B = '112';
    case DarkOliveGreen3_B = '113';
    case PaleGreen3_B = '114';
    case DarkSeaGreen3_A = '115';
    case DarkSlateGray3 = '116';
    case SkyBlue1 = '117';
    case Chartreuse1 = '118';
    case LightGreen_A = '119';
    case LightGreen_B = '120';
    case PaleGreen1_A = '121';
    case Aquamarine1_B = '122';
    case DarkSlateGray1 = '123';
    case Red3_A = '124';
    case DeepPink4 = '125';
    case MediumVioletRed = '126';
    case Magenta3_A = '127';
    case DarkViolet_B = '128';
    case Purple_B = '129';
    case DarkOrange3_A = '130';
    case IndianRed_A = '131';
    case HotPink3_A = '132';
    case MediumOrchid3 = '133';
    case MediumOrchid = '134';
    case MediumPurple2_A = '135';
    case DarkGoldenrod = '136';
    case LightSalmon3_A = '137';
    case RosyBrown = '138';
    case Gray63 = '139';
    case MediumPurple2_B = '140';
    case MediumPurple1 = '141';
    case Gold3_A = '142';
    case DarkKhaki = '143';
    case NavajoWhite3 = '144';
    case Gray69 = '145';
    case LightSteelBlue3 = '146';
    case LightSteelBlue = '147';
    case Yellow3_A = '148';
    case DarkOliveGreen3 = '149';
    case DarkSeaGreen3_B = '150';
    case DarkSeaGreen2_A = '151';
    case LightCyan3 = '152';
    case LightSkyBlue1 = '153';
    case GreenYellow = '154';
    case DarkOliveGreen2 = '155';
    case PaleGreen1_B = '156';
    case DarkSeaGreen2_B = '157';
    case DarkSeaGreen1_A = '158';
    case PaleTurquoise1 = '159';
    case Red3_B = '160';
    case DeepPink3_A = '161';
    case DeepPink3_B = '162';
    case Magenta3_B = '163';
    case Magenta3_C = '164';
    case Magenta2_A = '165';
    case DarkOrange3_B = '166';
    case IndianRed_B = '167';
    case HotPink3_B = '168';
    case HotPink2 = '169';
    case Orchid = '170';
    case MediumOrchid1_A = '171';
    case Orange3 = '172';
    case LightSalmon3_B = '173';
    case LightPink3 = '174';
    case Pink3 = '175';
    case Plum3 = '176';
    case Violet = '177';
    case Gold3_B = '178';
    case LightGoldenrod3 = '179';
    case Tan = '180';
    case MistyRose3 = '181';
    case Thistle3 = '182';
    case Plum2 = '183';
    case Yellow3_B = '184';
    case Khaki3 = '185';
    case LightGoldenrod2 = '186';
    case LightYellow3 = '187';
    case Gray84 = '188';
    case LightSteelBlue1 = '189';
    case Yellow2 = '190';
    case DarkOliveGreen1_A = '191';
    case DarkOliveGreen1_B = '192';
    case DarkSeaGreen1_B = '193';
    case Honeydew2 = '194';
    case LightCyan1 = '195';
    case Red1 = '196';
    case DeepPink2 = '197';
    case DeepPink1_A = '198';
    case DeepPink1_B = '199';
    case Magenta2_B = '200';
    case Magenta1 = '201';
    case OrangeRed1 = '202';
    case IndianRed1_A = '203';
    case IndianRed1_B = '204';
    case HotPink_A = '205';
    case HotPink_B = '206';
    case MediumOrchid1_B = '207';
    case DarkOrange = '208';
    case Salmon1 = '209';
    case LightCoral = '210';
    case PaleVioletRed1 = '211';
    case Orchid2 = '212';
    case Orchid1 = '213';
    case Orange1 = '214';
    case SandyBrown = '215';
    case LightSalmon1 = '216';
    case LightPink1 = '217';
    case Pink1 = '218';
    case Plum1 = '219';
    case Gold1 = '220';
    case LightGoldenrod2_A = '221';
    case LightGoldenrod2_B = '222';
    case NavajoWhite1 = '223';
    case MistyRose1 = '224';
    case Thistle1 = '225';
    case Yellow1 = '226';
    case LightGoldenrod1 = '227';
    case Khaki1 = '228';
    case Wheat1 = '229';
    case Cornsilk1 = '230';
    case Gray100 = '231';
    case Gray3 = '232';
    case Gray7 = '233';
    case Gray11 = '234';
    case Gray15 = '235';
    case Gray19 = '236';
    case Gray23 = '237';
    case Gray27 = '238';
    case Gray30 = '239';
    case Gray35 = '240';
    case Gray39 = '241';
    case Gray42 = '242';
    case Gray46 = '243';
    case Gray50 = '244';
    case Gray54 = '245';
    case Gray58 = '246';
    case Gray62 = '247';
    case Gray66 = '248';
    case Gray70 = '249';
    case Gray74 = '250';
    case Gray78 = '251';
    case Gray82 = '252';
    case Gray85 = '253';
    case Gray89 = '254';
    case Gray93 = '255';

    /**
     * @param int $code
     * @return self
     */
    public static function code(int $code): self
    {
        static $mapped = null;
        if ($mapped === null) {
            $mapped = [];
            foreach (self::cases() as $case) {
                $mapped[$case->value] = $case;
            }
        }

        assert(array_key_exists($code, $mapped), "Expected code: {$code} to exist.");

        return $mapped[$code];
    }
}
