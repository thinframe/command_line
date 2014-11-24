<?php

namespace ThinFrame\CommandLine\IO\Formatter;

use League\CLImate\CLImate;
use ThinFrame\CommandLine\IO\OutputFormatterInterface;

/**
 * Class ClimateFormatter
 *
 * @package ThinFrame\CommandLine\IO\Formatter
 */
class ClimateFormatter implements OutputFormatterInterface
{
    /**
     * @var CLImate
     */
    protected $climate;

    /**
     * Constructor
     *
     * @param CLImate $CLImate
     */
    public function __construct(CLImate $CLImate)
    {
        $this->climate = $CLImate;
    }

    /**
     * Format a message
     *
     * @param string $message
     *
     * @return string
     */
    public function format($message)
    {
        ob_start();
        $this->climate->out($message);
        //strip last new line
        $content = substr($content = ob_get_contents(), 0, strlen($content) - 1);
        ob_end_clean();

        return $content;
    }
}
