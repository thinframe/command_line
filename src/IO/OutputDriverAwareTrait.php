<?php

/**
 * src/IO/OutputDriverAwareTrait.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO;

/**
 * Class OutputDriverAwareTrait
 *
 * @package ThinFrame\CommandLine\IO
 * @since   0.3
 */
trait OutputDriverAwareTrait
{
    /**
     * @var OutputDriverInterface
     */
    protected $outputDriver;

    /**
     * Attach the output driver to the current class instance
     *
     * @param OutputDriverInterface $outputDriver
     *
     * @return $this
     */
    public function setOutputDriver(OutputDriverInterface $outputDriver)
    {
        $this->outputDriver = $outputDriver;

        return $this;
    }
}
