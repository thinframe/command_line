<?php

/**
 * /src/ThinFrame/CommandLine/DependencyInjection/CommandsCompilerPass.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class CommandsCompilerPass
 *
 * @package ThinFrame\CommandLine\DependencyInjection
 * @since   0.2
 */
class CommandsCompilerPass implements CompilerPassInterface
{
    const DEFAULT_MANAGER_TAG = 'thinframe.cli.commander';
    const PARENT_COMMAND_TAG  = 'thinframe.cli.parent_command';
    const CHILD_COMMAND_TAG   = 'thinframe.cli.child_command';
    /**
     * @var null|string
     */
    private $defaultManagerId = null;

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @throws LogicException
     */
    public function process(ContainerBuilder $container)
    {
        $this->preChecks($container);
        foreach ($container->findTaggedServiceIds(self::PARENT_COMMAND_TAG) as $commandId => $options) {
            foreach ($options as $option) {
                $this->injectParentCommand(
                    $commandId,
                    isset($option['manager']) ? $option['manager'] : $this->defaultManagerId,
                    $container
                );
            }
        }
        foreach ($container->findTaggedServiceIds(self::CHILD_COMMAND_TAG) as $commandId => $options) {
            foreach ($options as $option) {
                if (!isset($option['parent'])) {
                    throw new LogicException('Missing parent command id for service "' . $commandId . '"');
                }
                $this->injectChildCommand($commandId, $option['parent'], $container);
            }
        }
    }

    /**
     * Check for settings integrity
     *
     * @param ContainerBuilder $container
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\LogicException
     */
    private function preChecks(ContainerBuilder $container)
    {
        $managers = $container->findTaggedServiceIds(self::DEFAULT_MANAGER_TAG);

        if (count($managers) == 0) {
            throw new LogicException('A default commander is required');
        } elseif (count($managers) > 1) {
            throw new LogicException('A single service can be tagged as default commander');
        } else {
            $this->defaultManagerId = key($managers);
        }
    }

    /**
     * Inject a parent command into commands manager
     *
     * @param string           $commandId command id
     * @param string           $managerId manager id
     * @param ContainerBuilder $container
     */
    private function injectParentCommand($commandId, $managerId, ContainerBuilder $container)
    {
        $container->getDefinition($managerId)->addMethodCall('addCommand', [new Reference($commandId)]);
    }

    /**
     * Inject a child command into commands manager
     *
     * @param string           $childCommandId  child command reference id
     * @param string           $parentCommandId parent command reference id
     * @param ContainerBuilder $container       container
     */
    private function injectChildCommand($childCommandId, $parentCommandId, ContainerBuilder $container)
    {
        $container->getDefinition($parentCommandId)->addMethodCall('addChildCommand', [new Reference($childCommandId)]);
    }
}
