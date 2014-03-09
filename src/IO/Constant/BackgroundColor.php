<?php

/**
 * /src/IO/Constants/BackgroundColor.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO\Constant;

use ThinFrame\Foundation\DataType\AbstractEnum;

/**
 * Class BackgroundColor
 *
 * @package ThinFrame\CommandLine\IO\Constants
 * @since   0.2
 */
class BackgroundColor extends AbstractEnum
{
    const SYSTEM        = 49;
    const BLACK         = 40;
    const RED           = 41;
    const GREEN         = 42;
    const YELLOW        = 43;
    const BLUE          = 44;
    const MAGENTA       = 45;
    const CYAN          = 46;
    const LIGHT_GRAY    = 46;
    const DARK_GRAY     = 100;
    const LIGHT_RED     = 101;
    const LIGHT_GREEN   = 102;
    const LIGHT_YELLOW  = 103;
    const LIGHT_BLUE    = 104;
    const LIGHT_MAGENTA = 105;
    const LIGHT_CYAN    = 106;
    const WHITE         = 107;
}
