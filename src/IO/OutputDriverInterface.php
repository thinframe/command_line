<?php

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
     *
     * @return $this
     */
    public function write($message, $newLine = false);

    /**
     * Write message to output with new line at the end
     *
     * @param string $message
     *
     * @return $this
     */
    public function writeLine($message);

    /**
     * Set output formatter
     *
     * @param OutputFormatterInterface $outputDecorator
     *
     * @return $this
     */
    public function setFormatter(OutputFormatterInterface $outputDecorator = null);
}
