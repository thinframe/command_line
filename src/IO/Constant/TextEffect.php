<?php

/**
 * /src/IO/Constants/TextEffect.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO\Constant;

use ThinFrame\Foundation\DataType\AbstractEnum;

/**
 * Class TextEffect
 *
 * @package ThinFrame\CommandLine\IO\Constants
 * @since   0.2
 */
class TextEffect extends AbstractEnum
{
    const BOLD      = 1;
    const DIM       = 2;
    const UNDERLINE = 4;
    const BLINK     = 5;
    const REVERSE   = 7;
    const HIDDEN    = 8;
}
