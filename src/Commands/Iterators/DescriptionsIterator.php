<?php

/**
 * /src/Commands/Iterators/DescriptionsIterator.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\Commands\Iterators;

use ThinFrame\CommandLine\Commands\AbstractCommand;
use ThinFrame\CommandLine\Commands\AbstractCommandIterator;

/**
 * Class DescriptionsIterator
 *
 * @package ThinFrame\CommandLine\Commands\Iterators
 * @since   0.2
 */
class DescriptionsIterator extends AbstractCommandIterator
{
    private $descriptions = [];

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
        $this->descriptions = array_merge($this->descriptions, $command->getDescriptions());
    }

    /**
     * Get collected descriptions
     *
     * @return array
     */
    public function getDescriptions()
    {
        return $this->descriptions;
    }
}
