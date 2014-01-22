<?php

/**
 * /src/CommandLineApplication.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine;

use ThinFrame\Applications\AbstractApplication;
use ThinFrame\Applications\DependencyInjection\AwareDefinition;
use ThinFrame\Applications\DependencyInjection\ContainerConfigurator;
use ThinFrame\CommandLine\DependencyInjection\CommandsCompilerPass;

/**
 * Class CommandLineApplication
 *
 * @package ThinFrame\CommandLine
 * @since   0.2
 */
class CommandLineApplication extends AbstractApplication
{
    /**
     * initialize configurator
     *
     * @param ContainerConfigurator $configurator
     *
     * @return mixed
     */
    public function initializeConfigurator(ContainerConfigurator $configurator)
    {
        $configurator->addCompilerPass(new CommandsCompilerPass());

        $configurator->addAwareDefinition(
            new AwareDefinition(
                '\ThinFrame\CommandLine\DependencyInjection\OutputDriverAwareTrait',
                'setOutputDriver',
                'thinframe.cli.output_driver'
            )
        );
        $configurator->addAwareDefinition(
            new AwareDefinition(
                '\ThinFrame\CommandLine\DependencyInjection\InputDriverAwareTrait',
                'setInputDriver',
                'thinframe.cli.input_driver'
            )
        );
    }

    /**
     * Get application name
     *
     * @return string
     */
    public function getApplicationName()
    {
        return 'ThinFrameCommandLine';
    }

    /**
     * Get configuration files
     *
     * @return mixed
     */
    public function getConfigurationFiles()
    {
        return [
            'resources/services.yml'
        ];
    }

    /**
     * Get parent applications
     *
     * @return AbstractApplication[]
     */
    protected function getParentApplications()
    {
        return [];
    }
}
