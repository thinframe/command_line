<?php

/**
 * /src/DependencyInjection/InputDriverAwareTrait.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\DependencyInjection;


use ThinFrame\CommandLine\IO\InputDriverInterface;

/**
 * Class InputDriverAwareTrait
 * @package ThinFrame\CommandLine\DependencyInjection
 * @since 0.2
 */
trait InputDriverAwareTrait
{
    /**
     * @var InputDriverInterface
     */
    private $inputDriver;

    /**
     * Attach input driver to the
     *
     * @param InputDriverInterface $inputDriver
     */
    public function setInputDriver(InputDriverInterface $inputDriver)
    {
        $this->inputDriver = $inputDriver;
    }
}
