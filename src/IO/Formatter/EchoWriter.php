<?php

namespace ThinFrame\CommandLine\IO\Formatter;

use League\CLImate\Util\Writer\WriterInterface;

/**
 * Class EchoWriter
 *
 * @package ThinFrame\CommandLine\IO\Formatter
 */
class EchoWriter implements WriterInterface
{
    /**
     * @param  string $content
     */
    public function write($content)
    {
        echo $content;
    }
}
