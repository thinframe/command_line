<?php

/**
 * src/Commands/Processors/CommandFinderProcessor.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\Command\Processor;

use ThinFrame\CommandLine\Command\AbstractCommand;
use ThinFrame\CommandLine\Command\AbstractCommandProcessor;
use ThinFrame\CommandLine\IO\ArgumentsContainerInterface;

/**
 * Class CommandFinderProcessor
 *
 * @package ThinFrame\CommandLine\Commands\Processors
 * @since   0.3
 */
class CommandFinderProcessor extends AbstractCommandProcessor
{
    /**
     * @var AbstractCommand|null
     */
    private $command = null;

    /**
     * @var ArgumentsContainerInterface
     */
    private $argumentsContainer;

    /**
     * Constructor
     *
     * @param ArgumentsContainerInterface $argumentsContainer
     */
    public function __construct(ArgumentsContainerInterface $argumentsContainer)
    {
        $this->argumentsContainer = $argumentsContainer;
    }

    /**
     * Get command
     *
     * @return null|AbstractCommand
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Do something with a command
     *
     * @param AbstractCommand $command
     * @param int             $dept
     *
     */
    protected function process(AbstractCommand $command, $dept)
    {
        if ($command->getArgument() != $this->argumentsContainer->getArgumentsAtIndex($dept)) {
            return;
        }
        if (count($command->getChildCommands()) == 0) {
            $this->command = $command;
            $this->setStopped();
        } elseif ($this->argumentsContainer->getArgumentsCount() - 1 == $dept) {
            $this->command = $command;
            $this->setStopped();
        }
    }
}
