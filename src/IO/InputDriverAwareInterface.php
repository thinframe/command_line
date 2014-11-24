<?php

/**
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO;

/**
 * InputDriverAwareInterface
 *
 * @package ThinFrame\CommandLine\IO
 * @since   0.3
 */
interface InputDriverAwareInterface
{
    /**
     * Attach the input driver to the current class instance
     *
     * @param InputDriverInterface $inputDriver
     *
     * @return $this
     */
    public function setInputDriver(InputDriverInterface $inputDriver);
}
