<?php

/**
 * src/IO/Drivers/BashOutputDriver.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO\Driver;

use ThinFrame\CommandLine\IO\OutputDriverInterface;
use ThinFrame\CommandLine\IO\OutputFormatterInterface;

/**
 * Class BashOutputDriver
 *
 * @package ThinFrame\CommandLine\IO\Drivers
 * @since   0.3
 */
class BashOutputDriver implements OutputDriverInterface
{
    /**
     * @var \SplObjectStorage
     */
    private $outputFormatters;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->outputFormatters = new \SplObjectStorage();
    }


    /**
     * Write message to output
     *
     * @param string $message
     * @param bool   $newLine
     * @param bool   $error
     *
     * @return $this
     */
    public function write($message, $newLine = false, $error = false)
    {
        $message .= ($newLine ? PHP_EOL : '');

        foreach ($this->outputFormatters as $formatter) {
            /* @var $formatter OutputFormatterInterface */
            $message = $formatter->format($message);
        }

        if ($error) {
            fwrite(STDERR, $message);
        } else {
            fwrite(STDOUT, $message);
        }

        return $this;
    }

    /**
     * Write message to output with new line at the end
     *
     * @param string $message
     * @param bool   $error
     *
     * @return $this
     */
    public function writeLine($message, $error = false)
    {
        return $this->write($message, true, $error);
    }

    /**
     * Add output formatter
     *
     * @param OutputFormatterInterface $outputFormatter
     *
     * @return $this
     */
    public function addFormatter(OutputFormatterInterface $outputFormatter)
    {
        if (!$this->outputFormatters->contains($outputFormatter)) {
            $this->outputFormatters->attach($outputFormatter);
        }

        return $this;
    }

    /**
     * Get output formatters
     *
     * @return OutputFormatterInterface[]
     */
    public function getFormatters()
    {
        return iterator_to_array($this->outputFormatters);
    }

    /**
     * Remove output formatter
     *
     * @param OutputFormatterInterface $outputFormatter
     *
     * @return $this
     */
    public function removeFormatter(OutputFormatterInterface $outputFormatter)
    {
        $this->outputFormatters->detach($outputFormatter);

        return $this;
    }
}
