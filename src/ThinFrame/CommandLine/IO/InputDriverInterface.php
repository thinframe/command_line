<?php

/**
 * /src/ThinFrame/CommandLine/IO/InputDriverInterface.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO;

/**
 * Interface InputDriverInterface
 *
 * @package ThinFrame\CommandLine\IO
 * @since   0.2
 */
interface InputDriverInterface
{
    /**
     * Get user input
     *
     * @return string
     */
    public function readPlain();

    /**
     * Get user password input
     *
     * @return string
     */
    public function readPassword();

    /**
     * Multi choice selection
     *
     * @param string $outputText
     * @param array  $variants
     * @param string $failMessage
     *
     * @return string
     */
    public function readChoice($outputText, array $variants, $failMessage = "Invalid input\n");

    /**
     * Prompt user for something
     *
     * @param string $outputText
     *
     * @return string
     */
    public function prompt($outputText);
}
