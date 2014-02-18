<?php

/**
 * src/IO/Helpers/Bash.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO\Helpers;

use ThinFrame\Foundation\Constants\OS;
use ThinFrame\Foundation\Helpers\System;

/**
 * Class Bash
 *
 * @package ThinFrame\CommandLine\IO\Helpers
 * @since   0.2
 */
class Bash
{
    /**
     * Remove bash styles
     *
     * @param string $string
     *
     * @return string
     */
    public static function removeStyles($string)
    {
        if (System::getOS()->equals(OS::DARWIN) || System::getOS()->equals(OS::LINUX)) {
            return trim(shell_exec('echo "' . $string . '" | sed -r "s/\x1B\[([0-9]{1,2}(;[0-9]{1,2})?)?[m|K]//g"'));
        } else {
            return $string;
        }
    }

    /**
     * Get bash terminal width and height
     *
     * @return array
     */
    public static function getScreenSizes()
    {
        if (!(System::getOS()->equals(OS::DARWIN) || System::getOS()->equals(OS::LINUX))) {
            return ['width' => 100, 'height' => 100];
        }
        preg_match_all("/rows.([0-9]+);.columns.([0-9]+);/", strtolower(exec('stty -a |grep columns')), $output);
        if (sizeof($output) == 3) {
            return array(
                "height" => isset($output[1][0]) ? $output[1][0] : 100,
                "width"  => isset($output[2][0]) ? $output[2][0] : 100
            );
        } else {
            return array(
                "width"  => 100,
                "height" => 100
            );
        }
    }
}
