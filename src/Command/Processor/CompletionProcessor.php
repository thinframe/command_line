<?php

/**
 * src/Commands/Processors/CompletionProcessor.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\Command\Processor;

use Stringy\StaticStringy;
use ThinFrame\CommandLine\Command\AbstractCommand;
use ThinFrame\CommandLine\Command\AbstractCommandProcessor;
use ThinFrame\CommandLine\IO\ArgumentsContainerInterface;

/**
 * Class CompletionProcessor
 *
 * @package ThinFrame\CommandLine\Commands\Processors
 * @since   0.3
 */
class CompletionProcessor extends AbstractCommandProcessor
{
    /**
     * @var ArgumentsContainerInterface
     */
    private $argumentsContainer;
    /**
     * @var int
     */
    private $currentIndex;

    /**
     * @var array
     */
    private $words = [];

    /**
     * Constructor
     *
     * @param ArgumentsContainerInterface $argumentsContainer
     */
    public function __construct(ArgumentsContainerInterface $argumentsContainer)
    {
        $this->argumentsContainer = $argumentsContainer;
        $this->currentIndex       = $argumentsContainer->getOptionValue('current') - 1;
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
        } elseif ($depth < $this->currentIndex && $command->getArgument(
            ) == $this->argumentsContainer->getArgumentsAtIndex(
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
        if (is_null($this->argumentsContainer->getArgumentsAtIndex($this->currentIndex + 2))) {
            $this->words[] = $command->getArgument();
        } elseif (StaticStringy::startsWith(
            $command->getArgument(),
            $this->argumentsContainer->getArgumentsAtIndex($this->currentIndex + 2)
        )
        ) {
            $this->words[] = $command->getArgument();
        }
    }

    /**
     * Get completion words
     *
     * @return array
     */
    public function getWords()
    {
        return $this->words;
    }
}
