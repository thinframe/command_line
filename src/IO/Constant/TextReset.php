<?php

/**
 * /src/IO/Constants/TextReset.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO\Constant;

use ThinFrame\Foundation\DataType\AbstractEnum;

/**
 * Class TextReset
 *
 * @package ThinFrame\CommandLine\IO\Constants
 * @since   0.2
 */
class TextReset extends AbstractEnum
{
    const ALL       = 0;
    const BOLD      = 21;
    const DIM       = 22;
    const UNDERLINE = 24;
    const BLINK     = 25;
    const REVERSE   = 27;
    const HIDDEN    = 28;
}
