<?php

namespace ThinFrame\CommandLine\IO\Helper;

use League\CLImate\CLImate;

/**
 * Class ClimateFilter
 *
 * @package ThinFrame\CommandLine\IO\Helper
 */
class ClimateFactory
{
    /**
     * @param $class
     * @param $output
     *
     * @return CLImate
     */
    public static function getClimate($class, $output)
    {
        /** @var CLImate $climate */
        $climate = new $class($output);

        $climate->style->addCommand('warning', 'yellow');

        return $climate;
    }
}