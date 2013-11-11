<?php

/**
 * /src/ThinFrame/CommandLine/Commands/AbstractCommandIterator.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\Commands;

/**
 * Class AbstractCommandIterator
 *
 * @package ThinFrame\CommandLine\Commands
 * @since   0.2
 */
abstract class AbstractCommandIterator
{
    private $stopped = false;

    /**
     * Visit a specific command
     *
     * @param AbstractCommand $command
     * @param int             $depth
     */
    public function visit(AbstractCommand $command, $depth = 0)
    {
        if ($this->isStopped()) {
            return;
        }
        $this->process($command, $depth);
        foreach ($command->getChildCommands() as $childCommand) {
            $this->visit($childCommand, $depth + 1);
        }
    }

    /**
     * Check if iterator is stopped
     *
     * @return bool
     */
    public function isStopped()
    {
        return $this->stopped;
    }

    /**
     * Logic that will be executed when command is visited
     *
     * @param AbstractCommand $command
     * @param int             $depth
     *
     * @return mixed
     */
    abstract function process(AbstractCommand $command, $depth = 0);

    /**
     * Stop iterator
     */
    public function stop()
    {
        $this->stopped = true;
    }
}
