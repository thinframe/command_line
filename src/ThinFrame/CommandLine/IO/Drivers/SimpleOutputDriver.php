<?php

/**
 * /src/ThinFrame/CommandLine/IO/Drivers/SimpleOutputDriver.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO\Drivers;

use ThinFrame\CommandLine\IO\OutputDriverInterface;

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
        fwrite($output, $this->interpolate($string, $variables));
    }

    /**
     * Interpolate variables into string
     *
     * @param string $string
     * @param array  $variables
     */
    private function interpolate($string, array $variables)
    {
        foreach ($variables as $key => $value) {
            $string = str_replace('{' . $key . '}', $value, $string);
        }
    }
}
