<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . '../vendor/autoload.php';

$commandLineApp = new \ThinFrame\CommandLine\CommandLineApplication();
$commandLineApp->make();

$inputDriver = $commandLineApp->getContainer()->get('cli.input_driver');
/* @var $inputDriver \ThinFrame\CommandLine\IO\InputDriverInterface */

echo 'Type something:' . PHP_EOL;

var_dump($inputDriver->readLine());

var_dump($inputDriver->prompt("What is your favorite food? "));

echo 'Type a dummy password:' . PHP_EOL;

var_dump($inputDriver->readPassword());

$inputDriver->readChoice(
    "What is your favorite continent? ",
    ['North America', 'South America', 'Europe', 'Asia', 'Africa', 'Australia']
);
