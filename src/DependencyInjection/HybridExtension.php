<?php

/**
 * src/DependencyInjection/HybridExtension.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\Reference;
use ThinFrame\Foundation\Exceptions\LogicException;

/**
 * Class HybridExtension
 *
 * @package ThinFrame\CommandLine\DependencyInjection
 * @since   0.3
 */
class HybridExtension implements ExtensionInterface, CompilerPassInterface
{
    /**
     * @var array
     */
    private $config;

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     *
     * @throws LogicException
     */
    public function process(ContainerBuilder $container)
    {
        $container
            ->setDefinition(
                'cli.output_driver',
                new DefinitionDecorator($this->config['io']['output_driver_service'])
            );
        $container
            ->setDefinition(
                'cli.input_driver',
                new DefinitionDecorator($this->config['io']['input_driver_service'])
            )
            ->addMethodCall('setArgumentsContainer', [new Reference('cli.arguments_container')]);
        $container
            ->setDefinition(
                'cli.arguments_container',
                new DefinitionDecorator($this->config['io']['arguments_container_service'])
            );

        foreach ($this->config['io']['output_formatters'] as $formatter) {
            $container->getDefinition('cli.output_driver')->addMethodCall(
                'addFormatter',
                [new Reference($formatter['service'])]
            );
        }

        foreach ($container->findTaggedServiceIds($this->config['commands']['parent_tag']) as $serviceId => $tags) {
            $container->getDefinition($this->config['commands']['service'])->addMethodCall(
                'addCommand',
                [new Reference($serviceId)]
            );
        }

        foreach ($container->findTaggedServiceIds($this->config['commands']['child_tag']) as $serviceId => $tags) {
            foreach ($tags as $tag) {
                if (!isset($tag['parent'])) {
                    throw new LogicException(
                        'Missing parent attribute (' .
                        $this->config['commands']['child_tag'] . ' tag) for service' . $serviceId
                    );
                }
                $container->getDefinition($tags['parent'])->addMethodCall(
                    'addChildCommand',
                    [new Reference($serviceId)]
                );
            }
        }
    }

    /**
     * Loads a specific configuration.
     *
     * @param array            $config    An array of configuration values
     * @param ContainerBuilder $container A ContainerBuilder instance
     *
     * @throws \InvalidArgumentException When provided tag is not defined in this extension
     *
     * @api
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $processor = new Processor();

        $this->config = $processor->processConfiguration(new Configuration(), $config);
    }

    /**
     * Returns the namespace to be used for this extension (XML namespace).
     *
     * @return string The XML namespace
     *
     * @api
     */
    public function getNamespace()
    {
        return null;
    }

    /**
     * Returns the base path for the XSD files.
     *
     * @return string The XSD base path
     *
     * @api
     */
    public function getXsdValidationBasePath()
    {
        return null;
    }

    /**
     * Returns the recommended alias to use in XML.
     *
     * This alias is also the mandatory prefix to use when using YAML.
     *
     * @return string The alias
     *
     * @api
     */
    public function getAlias()
    {
        return 'command_line';
    }
}
