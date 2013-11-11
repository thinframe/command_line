<?php

/**
 * /src/ThinFrame/CommandLine/IO/Drivers/SimpleOutputDriver.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO\Drivers;

use ThinFrame\CommandLine\IO\OutputDriverInterface;
use ThinFrame\Foundation\Helpers\Strings\StringGenerator;

/**
 * Class SimpleOutputDriver
 *
 * @package ThinFrame\CommandLine\IO\Drivers
 * @since   0.2
 */
class SimpleOutputDriver implements OutputDriverInterface
{
    /**
     * Send output
     *
     * @param string $string
     * @param array  $variables
     * @param bool   $error
     */
    public function send($string, array $variables = array(), $error = false)
    {
        if ($error) {
            $output = STDERR;
        } else {
            $output = STDOUT;
        }
        fwrite($output, StringGenerator::interpolate($string, $variables));
    }
}
