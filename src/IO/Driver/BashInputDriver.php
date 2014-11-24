<?php

/**
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO\Driver;

use ThinFrame\CommandLine\IO\ArgumentsContainerInterface;
use ThinFrame\CommandLine\IO\InputDriverInterface;
use ThinFrame\CommandLine\IO\OutputDriverInterface;
use ThinFrame\Pcntl\Helper\Exec;

/**
 * BashInputDriver
 *
 * @package ThinFrame\CommandLine\IO\Drivers
 * @since   0.3
 */
class BashInputDriver implements InputDriverInterface
{
    /**
     * @var OutputDriverInterface
     */
    private $outputDriver;
    /**
     * @var ArgumentsContainerInterface
     */
    private $argumentsContainer;

    /**
     * Constructor
     *
     * @param OutputDriverInterface $outputDriver
     */
    public function __construct(OutputDriverInterface $outputDriver)
    {
        $this->outputDriver = $outputDriver;
    }

    /**
     * Set arguments container
     *
     * @param ArgumentsContainerInterface $argumentsContainer
     *
     * @return $this
     */
    public function setArgumentsContainer(ArgumentsContainerInterface $argumentsContainer)
    {
        $this->argumentsContainer = $argumentsContainer;

        return $this;
    }

    /**
     * Get arguments container
     *
     * @return ArgumentsContainerInterface
     */
    public function getArgumentsContainer()
    {
        return $this->argumentsContainer;
    }

    /**
     * Read line
     *
     * @return string
     */
    public function readLine()
    {
        return trim(fgets(STDIN));
    }

    /**
     * Read password
     *
     * @return string
     */
    public function readPassword()
    {
        $result = Exec::viaPipe('bash -c \'read -s password && echo $password\'');

        return $result->getStdOut();
    }

    /**
     * Read user choice
     *
     * @param string $question
     * @param array  $variants
     * @param string $errorMessage
     *
     * @return string
     */
    public function readChoice($question, array $variants, $errorMessage = 'Invalid input')
    {
        $variantsBackup = $variants;
        $variants[0]    = '<bold>' . $variants[0] . '</bold>';
        while (true) {
            $this->outputDriver->writeLine($question . ' [' . implode(', ', $variants) . ']');
            $response = $this->readLine();
            if (in_array($response, $variants)) {
                return $response;
            } elseif ($response == '') {
                return $variantsBackup[0];
            }
            $this->outputDriver->writeLine($errorMessage);
        }

        return '';
    }

    /**
     * Prompt user for info
     *
     * @param string $question
     *
     * @return string
     */
    public function prompt($question)
    {
        $this->outputDriver->write($question . ' ');

        return $this->readLine();
    }
}
