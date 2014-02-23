<?php

namespace ThinFrame\CommandLine;

use PhpCollection\Map;
use ThinFrame\Applications\AbstractApplication;
use ThinFrame\Applications\DependencyInjection\ContainerConfigurator;
use ThinFrame\Applications\DependencyInjection\InterfaceInjectionRule;
use ThinFrame\Applications\DependencyInjection\TraitInjectionRule;
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
        $configurator->addResources(
            [
                'Resources/services/services.yml',
                'Resources/services/config.yml'
            ]
        );

        $configurator->addExtension($hybridExtension = new HybridExtension());
        $configurator->addCompilerPass($hybridExtension);

        $configurator->addInjectionRule(
            new TraitInjectionRule(
                '\ThinFrame\CommandLine\IO\OutputDriverAwareTrait',
                'cli.output_driver',
                'setOutputDriver')
        );

        $configurator->addInjectionRule(
            new TraitInjectionRule(
                '\ThinFrame\CommandLine\IO\InputDriverAwareTrait',
                'cli.input_driver',
                'setInputDriver')
        );

        $configurator->addInjectionRule(
            new InterfaceInjectionRule(
                '\ThinFrame\CommandLine\IO\OutputDriverAwareInterface',
                'cli.output_driver',
                'setOutputDriver'
            )
        );
        $configurator->addInjectionRule(
            new InterfaceInjectionRule(
                '\ThinFrame\CommandLine\IO\InputDriverAwareInterface',
                'cli.input_driver',
                'setInputDriver'
            )
        );
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
