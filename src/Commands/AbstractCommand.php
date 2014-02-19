<?php

/**
 * src/Commands/AbstractCommand.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\Commands;

use ThinFrame\CommandLine\IO\InputDriverInterface;
use ThinFrame\CommandLine\IO\OutputDriverInterface;

/**
 * Class AbstractCommand
 *
 * @package ThinFrame\CommandLine\Commands
 * @since   0.3
 */
abstract class AbstractCommand
{
    /**
     * @var AbstractCommand[]
     */
    private $childCommands = [];

    /**
     * Add a child command
     *
     * @param AbstractCommand $command
     */
    public function addChildCommand(AbstractCommand $command)
    {
        $this->childCommands[$command->getArgument()] = $command;
    }

    /**
     * Remove child command
     *
     * @param AbstractCommand $command
     */
    public function removeChildCommand(AbstractCommand $command)
    {
        unset($this->childCommands[$command->getArgument()]);
    }

    /**
     * Get all child commands
     *
     * @return AbstractCommand[]
     */
    public function getChildCommands()
    {
        return $this->childCommands;
    }

    /**
     * Set child commands
     *
     * @param array $childCommands
     */
    public function setChildCommands(array $childCommands)
    {
        $this->childCommands = $childCommands;
    }

    /**
     * Get command argument
     *
     * @return string
     */
    abstract public function getArgument();

    /**
     * Get command descriptions
     *
     * @return array
     */
    abstract public function getDescriptions();

    /**
     * Code that will be executed when command is triggered
     *
     * @param InputDriverInterface  $inputDriver
     * @param OutputDriverInterface $outputDriver
     *
     * @return bool
     */
    abstract public function execute(InputDriverInterface $inputDriver, OutputDriverInterface $outputDriver);
}
