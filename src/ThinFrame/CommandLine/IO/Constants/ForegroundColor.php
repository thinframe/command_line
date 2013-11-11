<?php

/**
 * /src/ThinFrame/CommandLine/IO/Constants/ForegroundColor.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO\Constants;

use ThinFrame\Foundation\DataTypes\AbstractEnum;

/**
 * Class ForegroundColor
 *
 * @package ThinFrame\CommandLine\IO\Constants
 * @since   0.2
 */
class ForegroundColor extends AbstractEnum
{
    const SYSTEM       = 39;
    const BLACK        = 30;
    const DARK_GRAY    = 90;
    const BLUE         = 34;
    const LIGHT_BLUE   = 94;
    const GREEN        = 32;
    const LIGHT_GREEN  = 92;
    const CYAN         = 36;
    const LIGHT_CYAN   = 96;
    const RED          = 31;
    const LIGHT_RED    = 91;
    const PURPLE       = 35;
    const LIGHT_PURPLE = 95;
    const BROWN        = 33;
    const YELLOW       = 93;
    const LIGHT_GRAY   = 37;
    const WHITE        = 97;
}
