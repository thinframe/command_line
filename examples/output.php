<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

$commandLineApp = new \ThinFrame\CommandLine\CommandLineApplication();
$commandLineApp->make();

$outputDriver = $commandLineApp->getContainer()->get('cli.output_driver');
/* @var $outputDriver \ThinFrame\CommandLine\IO\OutputDriverInterface */

$outputDriver->writeLine("Hello world!");

$outputDriver->writeLine("[info]You will be amazed[/info]");

$outputDriver->writeLine("[error]... or not[/error]");

$outputDriver->writeLine(
    "[format foreground='cyan' background='black' effects='bold underline']... but let's check this out first![/format]"
);

$outputDriver->writeLine("[center]Embrace it[/center]");

$outputDriver->write("[sideways]Or ... %MIDDLE% FORK IT  [/sideways]");