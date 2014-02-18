<?php

/**
 * src/IO/ArgumentsContainerInterface.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO;

/**
 * Interface ArgumentsContainerInterface
 *
 * @package ThinFrame\CommandLine\IO
 * @since   0.3
 */
interface ArgumentsContainerInterface
{
    /**
     * Check if flag provided
     *
     * @param string $flag
     *
     * @return boolean
     */
    public function isFlaggedWith($flag);

    /**
     * Get all provided flags
     *
     * @return array
     */
    public function getFlags();

    /**
     * Set provided flags
     *
     * @param array $flags
     *
     * @return $this
     */
    public function setFlags(array $flags);

    /**
     * Check if option is provided
     *
     * @param string $optionName
     *
     * @return boolean
     */
    public function isOptionProvided($optionName);

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions();

    /**
     * Get option value
     *
     * @param string $optionName
     *
     * @return string
     */
    public function getOptionValue($optionName);

    /**
     * Set provided options
     *
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options);

    /**
     * Check if argument is provided
     *
     * @param string $argument
     *
     * @return boolean
     */
    public function isArgumentsProvided($argument);

    /**
     * Get the provided argument at a specific index
     *
     * @param int $index
     *
     * @return string|null
     */
    public function getArgumentsAtIndex($index);

    /**
     * Get arguments count
     *
     * @return int
     */
    public function getArgumentsCount();

    /**
     * Set arguments
     *
     * @param array $arguments
     *
     * @return $this
     */
    public function setArguments(array $arguments);
}
