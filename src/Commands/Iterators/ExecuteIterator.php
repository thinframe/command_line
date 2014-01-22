<?php

/**
 * /src/Commands/Iterators/ExecuteIterator.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\Commands\Iterators;

use ThinFrame\CommandLine\ArgumentsContainer;
use ThinFrame\CommandLine\Commands\AbstractCommand;
use ThinFrame\CommandLine\Commands\AbstractCommandIterator;

/**
 * Class ExecuteIterator
 *
 * @package ThinFrame\CommandLine\Commands\Iterators
 * @since   0.2
 */
class ExecuteIterator extends AbstractCommandIterator
{
    /**
     * @var ArgumentsContainer
     */
    private $argumentsContainer;

    /**
     * Constructor
     *
     * @param ArgumentsContainer $container
     */
    public function __construct(ArgumentsContainer $container)
    {
        $this->argumentsContainer = $container;
    }

    /**
     * Logic that will be executed when command is visited
     *
     * @param AbstractCommand $command
     * @param int             $depth
     *
     * @return mixed
     */
    function process(AbstractCommand $command, $depth = 0)
    {
        if ($command->getArgument() != $this->argumentsContainer->getArgumentAt($depth)) {
            return;
        }
        if (count($command->getChildCommands()) == 0) {
            $command->execute($this->argumentsContainer);
            $this->stop();
        } elseif ($this->argumentsContainer->getArgumentsCount() - 1 == $depth) {
            $command->execute($this->argumentsContainer);
            $this->stop();
        }
    }
}
