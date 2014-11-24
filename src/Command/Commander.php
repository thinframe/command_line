<?php

/**
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\Command;

use ThinFrame\CommandLine\IO\InputDriverAwareTrait;
use ThinFrame\CommandLine\IO\OutputDriverAwareTrait;

/**
 * Commander
 *
 * @package ThinFrame\CommandLine\Commands
 * @since   0.3
 */
class Commander
{
    use InputDriverAwareTrait;
    use OutputDriverAwareTrait;

    /**
     * @var AbstractCommand[]
     */
    private $commands = [];

    /**
     * Register a new parent command
     *
     * @param AbstractCommand $command
     */
    public function addCommand(AbstractCommand $command)
    {
        $this->commands[$command->getArgument()] = $command;
    }

    /**
     * Remove a parent command
     *
     * @param AbstractCommand $command
     */
    public function removeCommand(AbstractCommand $command)
    {
        unset($this->commands[$command->getArgument()]);
    }

    /**
     * Get all registered commands
     *
     * @return AbstractCommand[]
     */
    public function getCommands()
    {
        return $this->commands;
    }

    /**
     * Override all commands with a new stack
     *
     * @param AbstractCommand[] $commands
     */
    public function setCommands(array $commands)
    {
        foreach ($commands as $command) {
            $this->addCommand($command);
        }
    }

    /**
     * Execute a processor on all the commands
     *
     * @param AbstractCommandProcessor $processor
     */
    public function executeProcessor(AbstractCommandProcessor $processor)
    {
        array_walk(
            $this->commands,
            function (AbstractCommand $command) use ($processor) {
                $processor->visit($command);
            }
        );
    }
}
