<?php

namespace ThinFrame\CommandLine\Command\Test;

use ThinFrame\CommandLine\Command\AbstractCommand;
use ThinFrame\CommandLine\Command\Commander;
use ThinFrame\CommandLine\Command\CompgenCommand;
use ThinFrame\CommandLine\Command\Processor\CommandFinderProcessor;
use ThinFrame\CommandLine\Command\Processor\CompletionProcessor;
use ThinFrame\CommandLine\Command\Processor\DescriptionsGathererProcessor;
use ThinFrame\CommandLine\Command\Test\Mock\MockCommand;
use ThinFrame\CommandLine\CommandLineApplication;
use ThinFrame\CommandLine\IO\ArgumentsContainer;
use ThinFrame\CommandLine\IO\Driver\BashInputDriver;
use ThinFrame\CommandLine\IO\Driver\BashOutputDriver;
use ThinFrame\CommandLine\IO\InputDriverInterface;
use ThinFrame\CommandLine\IO\OutputDriverInterface;

/**
 * Class CommanderTest
 *
 * @package ThinFrame\CommandLine\Command\Test
 */
class CommanderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CommandLineApplication
     */
    protected $application;

    protected $calledCommands = [];

    /**
     * Set up
     */
    protected function setUp()
    {
        $this->application = new CommandLineApplication();
        $this->application->make();

        /** @var Commander $commander */
        $commander = $this->application->getContainer()->get('cli.commander');

        $this->calledCommands = [];

        $triggerCallback = function (
            AbstractCommand $command,
            InputDriverInterface $inputDriver,
            OutputDriverInterface $outputDriver
        ) {
            $this->calledCommands[$command->getArgument()] = true;
        };

        $server  = new MockCommand('server', $triggerCallback);
        $run     = new MockCommand('run', $triggerCallback);
        $stop    = new MockCommand('stop', $triggerCallback);
        $verbose = new MockCommand('verbose', $triggerCallback);

        $server->setChildCommands([$run, $stop]);
        $run->addChildCommand($verbose);
        $run->removeChildCommand($verbose);
        $run->addChildCommand($verbose);

        $help  = new MockCommand('help', $triggerCallback);
        $debug = new MockCommand('debug', $triggerCallback);

        $commander->setCommands([$help, $debug]);

        $commander->addCommand($server);

        $commander->addCommand(new CompgenCommand($commander));


    }

    /**
     * Get commander
     *
     * @return Commander
     */
    protected function getCommander()
    {
        return $this->application->getContainer()->get('cli.commander');
    }

    /**
     * Test `server` command
     */
    public function testServerCommand()
    {
        $processor = new CommandFinderProcessor(new ArgumentsContainer(['test', 'server']));
        $this->getCommander()->executeProcessor($processor);

        $this->assertNotNull($processor->getCommand());
        $this->assertEquals('server', $processor->getCommand()->getArgument());

        $processor->getCommand()->execute(
            $this->application->getContainer()->get('cli.input_driver'),
            $this->application->getContainer()->get('cli.output_driver')
        );

        $this->assertArrayHasKey($processor->getCommand()->getArgument(), $this->calledCommands);
    }

    /**
     * Test `server run` processor
     */
    public function testServerRunCommand()
    {
        $processor = new CommandFinderProcessor(new ArgumentsContainer(['test', 'server', 'run']));
        $this->getCommander()->executeProcessor($processor);

        $this->assertNotNull($processor->getCommand());
        $this->assertEquals('run', $processor->getCommand()->getArgument());

        $processor->getCommand()->execute(
            $this->application->getContainer()->get('cli.input_driver'),
            $this->application->getContainer()->get('cli.output_driver')
        );

        $this->assertArrayHasKey($processor->getCommand()->getArgument(), $this->calledCommands);
    }

    /**
     * Test `help` command
     */
    public function testHelpCommand()
    {
        $processor = new CommandFinderProcessor(new ArgumentsContainer(['test', 'help']));

        $this->getCommander()->executeProcessor($processor);

        $this->assertNotNull($processor->getCommand());
        $this->assertEquals('help', $processor->getCommand()->getArgument());

        $processor->getCommand()->execute(
            $this->application->getContainer()->get('cli.input_driver'),
            $this->application->getContainer()->get('cli.output_driver')
        );

        $this->assertArrayHasKey($processor->getCommand()->getArgument(), $this->calledCommands);
    }

    /**
     * Test command not found
     */
    public function testCommandNotFound()
    {
        $notFoundCommands = ['unknown_command', 'helps', 'run', 'stop', 'verbose', ''];

        foreach ($notFoundCommands as $command) {
            $processor = new CommandFinderProcessor(new ArgumentsContainer([$command]));

            $this->getCommander()->executeProcessor($processor);
            $this->assertNull($processor->getCommand());
        }
    }

    /**
     * Test the presence of the descriptions
     */
    public function testDescriptionsGathererProcessor()
    {
        $this->getCommander()->executeProcessor($processor = new DescriptionsGathererProcessor());
        $expected = ['server', 'run', 'help', 'verbose'];
        foreach ($expected as $command) {
            $this->assertArrayHasKey($command, $processor->getDescriptions());
        }
    }

    /**
     * Test completion processor
     */
    public function testCompletionProcessor()
    {
        //test subcommand completion
        $processor = new CompletionProcessor($argumentsContainer = new ArgumentsContainer([
            'php',
            'test.php',
            'compgen',
            'server',
            '--current=2'
        ]));


        $this->getCommander()->executeProcessor($processor);

        $this->assertEquals(['run', 'stop'], $processor->getWords());

        //test primary command completion
        $processor = new CompletionProcessor($argumentsContainer = new ArgumentsContainer([
            'php',
            'test.php',
            'compgen',
            'serv',
            '--current=1'
        ]));


        $this->getCommander()->executeProcessor($processor);

        $this->assertEquals(['server'], $processor->getWords());

        //test primary command completion
        $processor = new CompletionProcessor($argumentsContainer = new ArgumentsContainer([
            'php',
            'test.php',
            'compgen',
            'service',
            '--current=1'
        ]));


        $this->getCommander()->executeProcessor($processor);

        $this->assertEquals([], $processor->getWords());


        //test subcommand completion
        $processor = new CompletionProcessor($argumentsContainer = new ArgumentsContainer([
            'php',
            'test.php',
            'compgen',
            'service',
            'run',
            '--current=3'
        ]));


        $this->getCommander()->executeProcessor($processor);

        $this->assertEquals([], $processor->getWords());

        //test completion command

        $processor = new CommandFinderProcessor($argumentsContainer = new ArgumentsContainer([
            'php',
            'compgen',
            'service',
            'run',
            '--current=3'
        ]));

        $this->getCommander()->executeProcessor($processor);

        $this->assertTrue($processor->getCommand() instanceof CompgenCommand);

        $inputDriver = new BashInputDriver($output = new BashOutputDriver());

        $inputDriver->setArgumentsContainer($argumentsContainer);

        $processor->getCommand()->execute($inputDriver, $output);
    }

    /**
     * Test commands operations
     */
    public function testCommands()
    {
        $commands = $this->getCommander()->getCommands();

        $this->assertEquals(4, count($commands));

        foreach ($commands as $command) {
            $this->getCommander()->removeCommand($command);
        }

        $this->assertEquals(0, count($this->getCommander()->getCommands()));
    }
}
