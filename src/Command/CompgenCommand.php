<?php

/**
 * src/Commands/CompgenCommand.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\Command;

use ThinFrame\CommandLine\Command\Processor\CompletionProcessor;
use ThinFrame\CommandLine\IO\InputDriverInterface;
use ThinFrame\CommandLine\IO\OutputDriverInterface;

/**
 * Class CompgenCommands
 *
 * @package ThinFrame\CommandLine\Commands
 * @since   0.2
 */
class CompgenCommand extends AbstractCommand
{
    /**
     * @var Commander
     */
    private $commander;

    /**
     * Constructor
     *
     * @param Commander $commander
     */
    public function __construct(Commander $commander)
    {
        $this->commander = $commander;
    }

    /**
     * Get command argument
     *
     * @return string
     */
    public function getArgument()
    {
        return 'compgen';
    }

    /**
     * Get command descriptions
     *
     * @return array
     */
    public function getDescriptions()
    {
        return [];
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
        $this->commander->executeProcessor($processor = new CompletionProcessor($inputDriver->getArgumentsContainer()));
        $outputDriver->write(implode(" ", $processor->getWords()));

        return true;
    }
}
