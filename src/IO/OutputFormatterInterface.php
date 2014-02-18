<?php

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
