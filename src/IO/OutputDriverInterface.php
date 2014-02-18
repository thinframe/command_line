<?php

/**
 * src/IO/OutputDriverInterface.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO;

/**
 * Interface OutputDriverInterface
 *
 * @package ThinFrame\CommandLine\IO
 * @since   0.3
 */
interface OutputDriverInterface
{
    /**
     * Write message to output
     *
     * @param string $message
     * @param bool   $newLine
     * @param bool   $error
     *
     * @return $this
     */
    public function write($message, $newLine = false, $error = false);

    /**
     * Write message to output with new line at the end
     *
     * @param string $message
     * @param bool   $error
     *
     * @return $this
     */
    public function writeLine($message, $error = false);

    /**
     * Add output formatter
     *
     * @param OutputFormatterInterface $outputFormatter
     *
     * @return $this
     */
    public function addFormatter(OutputFormatterInterface $outputFormatter);

    /**
     * Get output formatters
     *
     * @return OutputFormatterInterface[]
     */
    public function getFormatters();

    /**
     * Remove output formatter
     *
     * @param OutputFormatterInterface $outputFormatter
     *
     * @return $this
     */
    public function removeFormatter(OutputFormatterInterface $outputFormatter);
}
