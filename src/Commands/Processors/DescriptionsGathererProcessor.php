<?php

/**
 * src/Commands/Processors/DescriptionsGathererProcessor.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\Commands\Processors;

use ThinFrame\CommandLine\Commands\AbstractCommand;
use ThinFrame\CommandLine\Commands\AbstractCommandProcessor;

/**
 * Class DescriptionsGathererProcessor
 *
 * @package ThinFrame\CommandLine\Commands\Processors
 * @since   0.3
 */
class DescriptionsGathererProcessor extends AbstractCommandProcessor
{
    /**
     * @var array
     */
    private $descriptions = [];

    /**
     * Do something with a command
     *
     * @param AbstractCommand $command
     * @param int             $dept
     *
     */
    protected function process(AbstractCommand $command, $dept)
    {
        $this->descriptions = array_merge($this->descriptions, $command->getDescriptions());
    }

    /**
     * Get gathered descriptions
     *
     * @return array
     */
    public function getDescriptions()
    {
        ksort($this->descriptions);

        return $this->descriptions;
    }
}
