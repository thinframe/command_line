<?php

namespace ThinFrame\CommandLine\Command\Test;

use ThinFrame\CommandLine\IO\ArgumentsContainer;

/**
 * Class ArgumentsContainerTest
 *
 * @package ThinFrame\CommandLine\Command\Test
 */
class ArgumentsContainerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test simple arguments
     */
    public function testSimpleArguments()
    {
        $argumentsContainer = new ArgumentsContainer(['entry_file', 'firstArgument', 'secondArgument']);

        $this->assertTrue($argumentsContainer->hasArgument('firstArgument'));
        $this->assertTrue($argumentsContainer->hasArgument('secondArgument'));

        $this->assertEquals('firstArgument', $argumentsContainer->getArgumentAtIndex(0));
        $this->assertEquals('secondArgument', $argumentsContainer->getArgumentAtIndex(1));

        $this->assertEquals(2, $argumentsContainer->getArgumentsCount());

        $this->assertEquals(['firstArgument', 'secondArgument'], $argumentsContainer->getArguments());
    }

    /**
     * Test duplicated arguments
     */
    public function testDuplicatedArguments()
    {
        $argumentsContainer = new ArgumentsContainer([
            'entry_file',
            'firstArgument',
            'secondArgument',
            'firstArgument'
        ]);

        $this->assertEquals(3, $argumentsContainer->getArgumentsCount());

        $this->assertEquals(['firstArgument', 'secondArgument', 'firstArgument'], $argumentsContainer->getArguments());
    }

    /**
     * Test simple flags
     */
    public function testSimpleFlags()
    {
        $argumentsContainer = new ArgumentsContainer(['entry_file', '-v', '-f']);

        $this->assertTrue($argumentsContainer->hasFlag('v'));
        $this->assertTrue($argumentsContainer->hasFlag('f'));
    }

    /**
     * Test duplicated flags
     */
    public function testDuplicatedFlags()
    {
        $argumentsContainer = new ArgumentsContainer(['entry_file', '-v', '-f', '-v']);

        $this->assertCount(3, $argumentsContainer->getFlags());
    }

    /**
     * Test chained flags
     */
    public function testChainedFlags()
    {
        $argumentsContainer = new ArgumentsContainer(['entry_file', '-vgcs']);

        $this->assertTrue($argumentsContainer->hasFlag('v'));
        $this->assertTrue($argumentsContainer->hasFlag('g'));
        $this->assertTrue($argumentsContainer->hasFlag('c'));
        $this->assertTrue($argumentsContainer->hasFlag('s'));

        $this->assertCount(4, $argumentsContainer->getFlags());
    }

    /**
     * Test standard options
     */
    public function testStandardOptions()
    {
        $argumentsContainer = new ArgumentsContainer(['entry_file', '--target=self', '--user=sorin', '--test']);

        $this->assertTrue($argumentsContainer->hasOption('target'));
        $this->assertTrue($argumentsContainer->hasOption('user'));
        $this->assertTrue($argumentsContainer->hasOption('test'));

        $this->assertEquals('self', $argumentsContainer->getOption('target'));
        $this->assertEquals('sorin', $argumentsContainer->getOption('user'));
        $this->assertEquals(true, $argumentsContainer->getOption('test'));

        $this->assertEquals(['target' => 'self', 'user' => 'sorin', 'test' => true], $argumentsContainer->getOptions());
    }

    /**
     * Test duplicated options
     */
    public function testDuplicatedOptions()
    {
        $argumentsContainer = new ArgumentsContainer(['entry_file', '--target=self', '--user=sorin', '--target=blank']);

        $this->assertEquals('self', $argumentsContainer->getOption('target'));
        $this->assertCount(2, $argumentsContainer->getOptions());
    }
}
