<?php

/**
 * /src/Commands/AbstractCommand.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\Commands;

use ThinFrame\CommandLine\ArgumentsContainer;

/**
 * Class AbstractCommand
 *
 * @package ThinFrame\CommandLine\AbstractCommand
 * @since   0.2
 */
abstract class AbstractCommand
{
    /**
     * @var AbstractCommand[]
     */
    private $childCommands = [];

    /**
     * Add a new child command
     *
     * @param AbstractCommand $command
     */
    public function addChildCommand(AbstractCommand $command)
    {
        $this->childCommands[$command->getArgument()] = $command;
    }

    /**
     * Get the argument the will trigger this command
     *
     * @return string
     */
    abstract public function getArgument();

    /**
     * Get child commands
     *
     * @return AbstractCommand[]
     */
    public function getChildCommands()
    {
        return $this->childCommands;
    }

    /**
     * Get the descriptions for this command
     *
     * @return string[]
     */
    abstract public function getDescriptions();

    /**
     * This method will be called if this command is triggered
     *
     * @param ArgumentsContainer $arguments
     *
     * @return mixed
     */
    abstract public function execute(ArgumentsContainer $arguments);
}
