<?php

/**
 * /src/ThinFrame/CommandLine/ArgumentsContainer.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine;

/**
 * Class ArgumentsContainer
 *
 * @package ThinFrame\CommandLine
 * @since   0.2
 */
class ArgumentsContainer
{
    /**
     * @var array
     */
    private $arguments = array();
    /**
     * @var array
     */
    private $options = array();
    /**
     * @var array
     */
    private $flags = array();

    /**
     * class constructor
     */
    public function __construct()
    {
        $this->parse();
    }

    /**
     * parse $_SERVER['argv']
     */
    private function parse()
    {
        $arguments = isset($_SERVER['argv']) ? $_SERVER['argv'] : [];
        array_shift($arguments);
        foreach ($arguments as $argument) {
            $this->parseUnknownArgument($argument);
        }
    }

    /**
     * parse unknown argument
     *
     * @param string $argument argument that will be parsed
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
     * parse option
     *
     * @param string $option option
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
     * parse flag
     *
     * @param string $flag flag
     */
    private function parseFlag($flag)
    {
        $flag  = substr($flag, 1);
        $flags = str_split($flag);
        foreach ($flags as $flag) {
            if (isset($this->flags[$flag])) {
                continue;
            }
            $this->flags[$flag] = true;
        }
    }

    /**
     * parse argument
     *
     * @param string $argument argument
     */
    private function parseArgument($argument)
    {
        $parts = explode("=", $argument, 2);
        if (count($parts) == 2) {
            if (isset($this->arguments[$parts[0]])) {
                return;
            }
            $this->arguments[$parts[0]] = $parts[1];
        } else {
            if (isset($this->arguments[$argument])) {
                return;
            }
            $this->arguments[$argument] = true;
        }
    }

    /**
     * check if flag provided
     *
     * @param string $flag flag identifier
     *
     * @return bool
     */
    public function isFlag($flag)
    {
        return isset($this->flags[$flag]);
    }

    /**
     * get all provided flags
     *
     * @return array
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * get all provided options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * get provided option
     *
     * @param string $option option name
     *
     * @return null|bool|string
     */
    public function getOption($option)
    {
        return $this->isOption($option) ? $this->options[$option] : null;
    }

    /**
     * check if option provided
     *
     * @param string $option option name
     *
     * @return bool
     */
    public function isOption($option)
    {
        return isset($this->options[$option]);
    }

    /**
     * get all provided arguments
     *
     * @return array
     */
    public function getArguments()
    {
        return array_keys($this->arguments);
    }

    /**
     * get specific argument
     *
     * @param string $argument argument name
     *
     * @return null|bool|string
     */
    public function getArgument($argument)
    {
        return $this->isArgument($argument) ? $this->arguments[$argument] : null;
    }

    /**
     * check if argument is provided
     *
     * @param string $argument argument name
     *
     * @return bool
     */
    public function isArgument($argument)
    {
        return isset($this->arguments[$argument]);
    }

    /**
     * get argument at specified index
     *
     * @param int $index index of the argument
     *
     * @return null|string
     */
    public function getArgumentAt($index)
    {
        $counter = 0;
        foreach ($this->arguments as $argument => $value) {
            unset($value);
            if ($counter == $index) {
                return $argument;
            }
            $counter++;
        }

        return null;
    }

    /**
     * get the total number of arguments
     *
     * @return int
     */
    public function getArgumentsCount()
    {
        return count($this->arguments);
    }
}
