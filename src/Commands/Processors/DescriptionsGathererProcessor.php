<?php

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
        return $this->descriptions;
    }
}
