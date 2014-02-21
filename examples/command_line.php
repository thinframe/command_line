<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

$commandLineApp = new \ThinFrame\CommandLine\CommandLineApplication();
$commandLineApp->make();

$commander = $commandLineApp->getContainer()->get('cli.commander');

/* @var $commander \ThinFrame\CommandLine\Commands\Commander */
class DummyCommand extends \ThinFrame\CommandLine\Commands\AbstractCommand
{
    /**
     * @var string
     */
    private $argument;

    /**
     * Constructor
     *
     * @param string $argument
     */
    public function __construct($argument)
    {
        $this->argument = $argument;
    }

    /**
     * Get command argument
     *
     * @return string
     */
    public function getArgument()
    {
        return $this->argument;
    }

    /**
     * Get command descriptions
     *
     * @return array
     */
    public function getDescriptions()
    {
        return [$this->argument => 'Description of ' . $this->argument];
    }

    /**
     * Code that will be executed when command is triggered
     *
     * @param \ThinFrame\CommandLine\IO\InputDriverInterface  $inputDriver
     * @param \ThinFrame\CommandLine\IO\OutputDriverInterface $outputDriver
     *
     * @return bool
     */
    public function execute(
        \ThinFrame\CommandLine\IO\InputDriverInterface $inputDriver,
        \ThinFrame\CommandLine\IO\OutputDriverInterface $outputDriver
    ) {
        $outputDriver->writeLine("Executed " . $this->argument . " command");
    }
}

$server  = new \DummyCommand('server');
$run     = new \DummyCommand('run');
$stop    = new \DummyCommand('stop');
$verbose = new \DummyCommand('verbose');
$server->addChildCommand($run);
$server->addChildCommand($stop);
$run->addChildCommand($verbose);

$help  = new \DummyCommand('help');
$debug = new \DummyCommand('debug');

$commander->addCommand($server);
$commander->addCommand($help);
$commander->addCommand($debug);
$commander->addCommand(new \ThinFrame\CommandLine\Commands\CompgenCommand($commander));

$commander->executeProcessor(
    $processor = new \ThinFrame\CommandLine\Commands\Processors\CommandFinderProcessor(
        $commandLineApp->getContainer()->get('cli.arguments_container')
    )
);

if ($processor->getCommand()) {
    $processor->getCommand()->execute(
        $commandLineApp->getContainer()->get('cli.input_driver'),
        $commandLineApp->getContainer()->get('cli.output_driver')
    );
}
