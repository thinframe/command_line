<?php

namespace ThinFrame\CommandLine;

use PhpCollection\Map;
use ThinFrame\Applications\AbstractApplication;
use ThinFrame\Applications\DependencyInjection\ContainerConfigurator;
use ThinFrame\CommandLine\DependencyInjection\HybridExtension;

/**
 * Class CommandLineApplication
 *
 * @package ThinFrame\CommandLine
 * @since   0.3
 */
class CommandLineApplication extends AbstractApplication
{
    /**
     * Get application name
     *
     * @return string
     */
    public function getName()
    {
        return $this->reflector->getShortName();
    }

    /**
     * Get application parents
     *
     * @return AbstractApplication[]
     */
    public function getParents()
    {
        return [];
    }

    /**
     * Set different options for the container configurator
     *
     * @param ContainerConfigurator $configurator
     */
    protected function setConfiguration(ContainerConfigurator $configurator)
    {
        $configurator->addResource('Resources/services/io.yml');
        $configurator->addResource('Resources/services/config.yml');
        $configurator->addExtension($hybridExtension = new HybridExtension());
        $configurator->addCompilerPass($hybridExtension);
    }

    /**
     * Set application metadata
     *
     * @param Map $metadata
     *
     */
    protected function setMetadata(Map $metadata)
    {
        //noop
    }
}
