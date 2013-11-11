<?php

/**
 * /src/ThinFrame/CommandLine/Commands/Commander.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\Commands;

use ThinFrame\CommandLine\ArgumentsContainer;

/**
 * Class Commander
 *
 * @package ThinFrame\CommandLine\Commands
 * @since   0.2
 */
class Commander
{
    /**
     * @var AbstractCommand[]
     */
    private $commands = [];
    /**
     * @var ArgumentsContainer
     */
    private $arguments;

    /**
     * Constructor
     *
     * @param ArgumentsContainer $argumentsContainer
     */
    public function __construct(ArgumentsContainer $argumentsContainer)
    {
        $this->arguments = $argumentsContainer;
    }

    /**
     * Add a new command to the stack
     *
     * @param AbstractCommand $command
     */
    public function addCommand(AbstractCommand $command)
    {
        $this->commands[$command->getArgument()] = $command;
    }

    /**
     * Send an iterator to visit all commands
     *
     * @param AbstractCommandIterator $iterator
     */
    public function iterate(AbstractCommandIterator $iterator)
    {
        foreach ($this->commands as $command) {
            $iterator->visit($command);
        }
    }
}
