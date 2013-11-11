<?php

/**
 * /src/ThinFrame/CommandLine/IO/Drivers/BashInputDriver.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO\Drivers;

use ThinFrame\CommandLine\IO\InputDriverInterface;
use ThinFrame\CommandLine\IO\OutputDriverInterface;
use ThinFrame\Pcntl\Helpers\Exec;

/**
 * Class BashInputDriver
 *
 * @package ThinFrame\CommandLine\IO\Drivers
 * @since   0.2
 */
class BashInputDriver implements InputDriverInterface
{
    /**
     * @var OutputDriverInterface
     */
    private $outputDriver;

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
     * Get user password input
     *
     * @return string
     */
    public function readPassword()
    {
        $result = Exec::viaPipe('bash -c \'read -s password && echo $password\'');

        return trim($result['stdOut']);
    }

    /**
     * Multi choice selection
     *
     * @param string $outputText
     * @param array  $variants
     * @param string $failMessage
     *
     * @return string
     */
    public function readChoice($outputText, array $variants, $failMessage = "Invalid input\n")
    {
        while (true) {
            $this->outputDriver->send($outputText);
            $this->outputDriver->send(' [' . implode(',', $variants) . ']:');
            $response = $this->readPlain();
            if (in_array($response, $variants)) {
                return $response;
            } else {
                $this->outputDriver->send($failMessage);
            }
        }

        return null;
    }

    /**
     * Get user input
     *
     * @return string
     */
    public function readPlain()
    {
        return trim(fgets(STDIN));
    }

    /**
     * Prompt user for something
     *
     * @param string $outputText
     *
     * @return string
     */
    public function prompt($outputText)
    {
        $this->outputDriver->send($outputText);

        return $this->readPlain();
    }
}
