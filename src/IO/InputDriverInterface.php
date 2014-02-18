<?php

namespace ThinFrame\CommandLine\IO;

/**
 * Interface InputDriverInterface
 *
 * @package ThinFrame\CommandLine\IO
 * @since   0.3
 */
interface InputDriverInterface
{
    /**
     * Set arguments container
     *
     * @param ArgumentsContainerInterface $argumentsContainer
     *
     * @return $this
     */
    public function setArgumentsContainer(ArgumentsContainerInterface $argumentsContainer);

    /**
     * Get arguments container
     *
     * @return ArgumentsContainerInterface
     */
    public function getArgumentsContainer();

    /**
     * Read line
     *
     * @return string
     */
    public function readLine();

    /**
     * Read password
     *
     * @return string
     */
    public function readPassword();

    /**
     * Read user choice
     *
     * @param        $question
     * @param array  $variants
     * @param string $errorMessage
     *
     * @return string
     */
    public function readChoice($question, array $variants, $errorMessage = 'Invalid input');

    /**
     * Prompt user for info
     *
     * @param string $question
     *
     * @return string
     */
    public function prompt($question);
}
