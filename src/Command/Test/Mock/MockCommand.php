<?php

namespace ThinFrame\CommandLine\Command\Test\Mock;

use ThinFrame\CommandLine\Command\AbstractCommand;
use ThinFrame\CommandLine\IO\InputDriverInterface;
use ThinFrame\CommandLine\IO\OutputDriverInterface;

/**
 * Class MockCommand
 *
 * @package ThinFrame\CommandLine\Command\Test
 */
class MockCommand extends AbstractCommand
{
    protected $argument;

    protected $callback;

    /**
     * Constructor
     *
     * @param  string  $argument
     * @param callback $callback
     */
    public function __construct($argument, $callback)
    {
        $this->argument = $argument;
        $this->callback = $callback;
    }

    /**
     * Get command argument
     *
     * @return string
     */
    public function getArgument()
    {
        return $this->argument;
    }

    /**
     * Get command descriptions
     *
     * @return array
     */
    public function getDescriptions()
    {
        return [$this->argument => sprintf('%s description', $this->argument)];
    }

    /**
     * Code that will be executed when command is triggered
     *
     * @param InputDriverInterface  $inputDriver
     * @param OutputDriverInterface $outputDriver
     *
     * @return bool
     */
    public function execute(InputDriverInterface $inputDriver, OutputDriverInterface $outputDriver)
    {
        $callback = $this->callback;
        $callback($this, $inputDriver, $outputDriver);
    }
}
