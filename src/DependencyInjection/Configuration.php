<?php

/**
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration
 *
 * @package ThinFrame\CommandLine\DependencyInjection
 * @since   0.3
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('command_line');


        $rootNode
            ->children()
                ->arrayNode('io')
                    ->children()
                        ->scalarNode('output_driver_service')
                            ->defaultValue('cli.abstract.bash_output_driver')
                        ->end()
                        ->scalarNode('input_driver_service')
                            ->defaultValue('cli.abstract.bash_input_driver')
                        ->end()
                        ->scalarNode('arguments_container_service')
                            ->defaultValue('cli.abstract.arguments_container')
                        ->end()
                        ->arrayNode('output_formatters')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('service')
                                        ->isRequired()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('commands')
                    ->children()
                        ->scalarNode('service')
                            ->defaultValue('cli.commander')
                        ->end()
                        ->scalarNode('parent_tag')
                            ->defaultValue('cli.commander')
                        ->end()
                        ->scalarNode('child_tag')
                            ->defaultValue('cli.child_command')
                        ->end()
                    ->end()
                 ->end()
            ->end();

        return $treeBuilder;
    }
}
