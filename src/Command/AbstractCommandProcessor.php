<?php

/**
 * src/Commands/AbstractCommandProcessor.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\Command;

/**
 * Class AbstractCommandProcessor
 *
 * @package ThinFrame\CommandLine\Commands
 * @since   0.3
 */
abstract class AbstractCommandProcessor
{
    /**
     * @var bool
     */
    private $stopped = false;

    /**
     * Set if processor is stopped
     *
     * @param boolean $stopped
     */
    public function setStopped($stopped = true)
    {
        $this->stopped = $stopped;
    }

    /**
     * Check if processor is stopped
     *
     * @return boolean
     */
    public function isStopped()
    {
        return $this->stopped;
    }

    /**
     * Visit command and process it
     *
     * @param AbstractCommand $command
     * @param int             $depth
     */
    public function visit(AbstractCommand $command, $depth = 0)
    {
        $this->process($command, $depth);
        foreach ($command->getChildCommands() as $childCommand) {
            if ($this->isStopped()) {
                return;
            }
            $this->visit($childCommand, $depth + 1);
        }
    }

    /**
     * Do something with a command
     *
     * @param AbstractCommand $command
     * @param int             $dept
     *
     */
    abstract protected function process(AbstractCommand $command, $dept);
}
