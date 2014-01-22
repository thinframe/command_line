<?php

/**
 * /src/IO/OutputDriverInterface.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO;

/**
 * Interface OutputDriverInterface
 *
 * @package ThinFrame\CommandLine\IO
 * @since   0.2
 */
interface OutputDriverInterface
{
    /**
     * Send output
     *
     * @param string $string
     * @param array  $variables
     * @param bool   $error
     */
    public function send($string, array $variables = array(), $error = false);
}
