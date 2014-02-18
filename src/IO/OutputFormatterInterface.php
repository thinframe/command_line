<?php

/**
 * src/IO/OutputFormatterInterface.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO;

/**
 * Interface OutputDecoratorInterface
 *
 * @package ThinFrame\CommandLine\IO
 * @since   0.3
 */
interface OutputFormatterInterface
{
    /**
     * Format a message
     *
     * @param string $message
     *
     * @return string
     */
    public function format($message);
}
