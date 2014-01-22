<?php

/**
 * /src/DependencyInjection/OutputDriverAwareTrait.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\DependencyInjection;

use ThinFrame\CommandLine\IO\OutputDriverInterface;

/**
 * Class OutputDriverAwareTrait
 * @package ThinFrame\CommandLine\DependencyInjection
 * @since 0.2
 */
trait OutputDriverAwareTrait
{
    /**
     * @var OutputDriverInterface
     */
    protected $outputDriver;

    /**
     * Attach a instance of the output driver
     *
     * @param OutputDriverInterface $outputDriver
     */
    public function setOutputDriver(OutputDriverInterface $outputDriver)
    {
        $this->outputDriver = $outputDriver;
    }
}
