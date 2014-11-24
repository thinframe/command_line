<?php

/**
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO\Helper;

use ThinFrame\CommandLine\IO\ArgumentsContainer;

/**
 * ArgumentsContainerFactory
 *
 * @package ThinFrame\CommandLine\IO\Helpers
 */
class ArgumentsContainerFactory
{
    /**
     * Create a arguments container from cli argv
     *
     * @return ArgumentsContainer
     */
    public static function createFromServerArgv()
    {
        return new ArgumentsContainer(isset($_SERVER['argv']) ? $_SERVER['argv'] : []);
    }
}
