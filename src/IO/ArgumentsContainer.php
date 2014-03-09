<?php

/**
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO;

/**
 * Class ArgumentsContainer
 *
 * @package ThinFrame\CommandLine
 * @since   0.2
 */
class ArgumentsContainer implements ArgumentsContainerInterface
{
    /**
     * @var array
     */
    private $options = [];
    /**
     * @var array
     */
    private $arguments = [];
    /**
     * @var array
     */
    private $flags = [];

    /**
     * Constructor
     */
    public function __construct(array $arguments)
    {
        array_shift($arguments);
        foreach ($arguments as $argument) {
            $this->parseUnknownArgument($argument);
        }
    }

    /**
     * Parse unknown argument
     *
     * @param string $argument
     */
    private function parseUnknownArgument($argument)
    {
        if (strlen($argument) > 2 && substr($argument, 0, 2) == '--') {
            $this->parseOption($argument);
        } elseif (strlen($argument) >= 2 && substr($argument, 0, 1) == '-') {
            $this->parseFlag($argument);
        } else {
            $this->parseArgument($argument);
        }
    }

    /**
     * Parse command line option
     *
     * @param string $option
     */
    private function parseOption($option)
    {
        $option = substr($option, 2);
        $parts  = explode("=", $option, 2);
        if (count($parts) > 1) {
            if (isset($this->options[$parts[0]])) {
                return;
            }
            $this->options[$parts[0]] = $parts[1];
        } else {
            if (isset($this->options[$option])) {
                return;
            }
            $this->options[$option] = true;
        }
    }

    /**
     * Parse command line flag
     *
     * @param string $flag
     */
    private function parseFlag($flag)
    {
        $flag  = substr($flag, 1);
        $flags = str_split($flag);
        foreach ($flags as $flag) {
            if (isset($this->flags[$flag])) {
                continue;
            }
            $this->flags[] = $flag;
        }
    }

    /**
     * Parse command line argument
     *
     * @param string $argument argument
     */
    private function parseArgument($argument)
    {
        $this->arguments[] = $argument;
    }

    /**
     * Check if flag provided
     *
     * @param string $flag
     *
     * @return boolean
     */
    public function isFlaggedWith($flag)
    {
        return in_array($flag, $this->flags);
    }

    /**
     * Get all provided flags
     *
     * @return array
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * Set provided flags
     *
     * @param array $flags
     *
     * @return $this
     */
    public function setFlags(array $flags)
    {
        $this->flags = $flags;

        return $this;
    }

    /**
     * Check if option is provided
     *
     * @param string $optionName
     *
     * @return boolean
     */
    public function isOptionProvided($optionName)
    {
        return isset($this->options[$optionName]);
    }

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Get option value
     *
     * @param string $optionName
     *
     * @return string
     */
    public function getOptionValue($optionName)
    {
        return $this->isOptionProvided($optionName) ? $this->options[$optionName] : null;
    }

    /**
     * Set provided options
     *
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Check if argument is provided
     *
     * @param string $argument
     *
     * @return boolean
     */
    public function isArgumentsProvided($argument)
    {
        return in_array($argument, $this->arguments);
    }

    /**
     * Get the provided argument at a specific index
     *
     * @param int $index
     *
     * @return string|null
     */
    public function getArgumentsAtIndex($index)
    {
        return isset($this->arguments[$index]) ? $this->arguments[$index] : null;
    }

    /**
     * Get arguments count
     *
     * @return int
     */
    public function getArgumentsCount()
    {
        return count($this->arguments);
    }

    /**
     * Set arguments
     *
     * @param array $arguments
     *
     * @return $this
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }
}
