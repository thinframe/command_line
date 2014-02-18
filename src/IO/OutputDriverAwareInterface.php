<?php

/**
 * src/IO/OutputDriverAwareInterface.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO;

/**
 * Interface OutputDriverAwareInterface
 *
 * @package ThinFrame\CommandLine\IO
 * @since   0.3
 */
interface OutputDriverAwareInterface
{
    /**
     * Attach the output driver to the current class instance
     *
     * @param OutputDriverAwareInterface $outputDriver
     *
     * @return $this
     */
    public function setOutputDriver(OutputDriverAwareInterface $outputDriver);
}
