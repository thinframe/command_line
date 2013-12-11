<?php

/**
 * /src/ThinFrame/CommandLine/Commands/Iterators/CompletionIterator.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\Commands\Iterators;

use Stringy\StaticStringy;
use ThinFrame\CommandLine\ArgumentsContainer;
use ThinFrame\CommandLine\Commands\AbstractCommand;
use ThinFrame\CommandLine\Commands\AbstractCommandIterator;

/**
 * Class CompletionIterator
 *
 * @package ThinFrame\CommandLine\Commands\Iterators
 * @since   0.2
 */
class CompletionIterator extends AbstractCommandIterator
{
    /**
     * @var ArgumentsContainer
     */
    private $argumentsContainer;
    /**
     * @var array
     */
    private $arguments;
    /**
     * @var int
     */
    private $currentIndex;

    /**
     * Constructor
     *
     * @param ArgumentsContainer $argumentsContainer
     */
    public function __construct(ArgumentsContainer $argumentsContainer)
    {
        $this->argumentsContainer = $argumentsContainer;
        $this->arguments          = $argumentsContainer->getArguments();
        $this->currentIndex       = $argumentsContainer->getOption('current') - 1;
    }

    /**
     * Visit logic for completion iterator
     *
     * @param AbstractCommand $command
     * @param int             $depth
     *
     * @overwrite
     */
    public function visit(AbstractCommand $command, $depth = 0)
    {
        if ($this->currentIndex == $depth) {
            $this->process($command);
        } elseif ($depth < $this->currentIndex && $command->getArgument() == $this->argumentsContainer->getArgumentAt(
                $depth + 2
            )
        ) {
            foreach ($command->getChildCommands() as $childCommand) {
                $this->visit($childCommand, $depth + 1);
            }
        }
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
        if (is_null($this->argumentsContainer->getArgumentAt($this->currentIndex + 2))) {
            echo $command->getArgument() . ' ';
        } elseif (StaticStringy::startsWith(
            $command->getArgument(),
            $this->argumentsContainer->getArgumentAt($this->currentIndex + 2)
        )
        ) {
            echo $command->getArgument() . ' ';
        }
    }
}
