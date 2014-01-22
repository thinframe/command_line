<?php

/**
 * /src/IO/Drivers/ShortCodesOutputDriver.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO\Drivers;

use ThinFrame\CommandLine\IO\Constants\BackgroundColor;
use ThinFrame\CommandLine\IO\Constants\ForegroundColor;
use ThinFrame\CommandLine\IO\Constants\TextEffect;
use ThinFrame\CommandLine\IO\Constants\TextReset;
use ThinFrame\CommandLine\IO\Helpers\Bash;
use ThinFrame\CommandLine\IO\Helpers\StringTransformer;
use ThinFrame\CommandLine\IO\OutputDriverInterface;
use ThinFrame\Foundation\Helpers\ShortCodesProcessor;

/**
 * Class ShortCodesOutputDriver
 *
 * @package ThinFrame\CommandLine\IO\Drivers
 * @since   0.2
 */
class ShortCodesOutputDriver implements OutputDriverInterface
{
    /**
     * @var ShortCodesProcessor
     */
    private $shortCodesProcessor;

    /**
     * Constructor
     *
     * @param ShortCodesProcessor $shortCodesProcessor
     */
    public function __construct(ShortCodesProcessor $shortCodesProcessor)
    {
        $this->shortCodesProcessor = $shortCodesProcessor;
        $this->registerShortCodes();
    }

    /**
     * register driver short codes
     */
    private function registerShortCodes()
    {
        $context = $this;
        $handler = function ($attributes, $content = null, $tag = null, ShortCodesProcessor $processor = null) use (
            $context
        ) {
            return $this->parseShortCodes($attributes, $content, $tag, $processor);
        };
        $context->shortCodesProcessor->registerShortCode('format', $handler);
        $context->shortCodesProcessor->registerShortCode('center', $handler);
        $context->shortCodesProcessor->registerShortCode('sideways', $handler);
        $context->shortCodesProcessor->registerShortCode('success', $handler);
        $context->shortCodesProcessor->registerShortCode('error', $handler);
        $context->shortCodesProcessor->registerShortCode('info', $handler);
    }

    /**
     * Parse short codes
     *
     * @param                     $attributes
     * @param null                $content
     * @param null                $tag
     * @param ShortCodesProcessor $processor
     *
     * @return mixed|null|string
     */
    private function parseShortCodes($attributes, $content = null, $tag = null, ShortCodesProcessor $processor = null)
    {
        $content          = $this->shortCodesProcessor->parseContent($content);
        $backgroundColors = BackgroundColor::getMap();
        $foregroundColors = ForegroundColor::getMap();
        $textEffects      = TextEffect::getMap();

        $options = [];

        switch ($tag) {
            case "format":
                $backgroundColor = strtoupper(isset($attributes['background']) ? $attributes['background'] : 'system');
                $foregroundColor = strtoupper(isset($attributes['foreground']) ? $attributes['foreground'] : 'system');
                $effects         = isset($attributes['effects']) ? explode(" ", $attributes['effects']) : array();

                $options[] = $backgroundColors->get($backgroundColor)->getOrElse(BackgroundColor::SYSTEM);
                $options[] = $foregroundColors->get($foregroundColor)->getOrElse(ForegroundColor::SYSTEM);

                foreach ($effects as $effect) {
                    $effect = strtoupper($effect);
                    if ($textEffects->containsKey($effect)) {
                        $options[] = $textEffects->get($effect)->get();
                    }
                }

                $options[] = TextReset::ALL;

                $content = StringTransformer::transformText($content, $options);
                break;
            case "center":
                $sizes   = Bash::getScreenSizes();
                $content = str_pad($content, $sizes['width'], " ", STR_PAD_BOTH);
                break;
            case "sideways":
                $sizes   = Bash::getScreenSizes();
                $content = str_replace(
                    "%MIDDLE%",
                    str_repeat(" ", $sizes['width'] - strlen(Bash::removeStyles($content)) + 6),
                    $content
                );
                break;
            case "success":
                $content = $processor->parseContent(
                    '[format foreground="green" effects="bold" background="black"][sideways] ' .
                    $content . '%MIDDLE%[/sideways][/format]'
                );
                break;
            case "error":
                $content = $processor->parseContent(
                    '[format foreground="white" effects="bold" background="red"][sideways] ' .
                    $content . '%MIDDLE%[/sideways][/format]'
                );
                break;
            case "info":
                $content = $processor->parseContent(
                    '[format foreground="white" effects="bold" background="blue"][sideways] ' .
                    $content . '%MIDDLE%[/sideways][/format]'
                );
                break;
        }

        return $content;
    }

    /**
     * Send output to driver
     *
     * @param string $string
     * @param array  $variables
     * @param bool   $error
     *
     * @return mixed
     */
    public function send($string, array $variables = [], $error = false)
    {
        if ($error) {
            $output = STDERR;
        } else {
            $output = STDOUT;
        }
        fwrite($output, $this->shortCodesProcessor->parseContent($this->interpolate($string, $variables)));
    }

    /**
     * Interpolate variables into string
     *
     * @param string $string
     * @param array  $variables
     *
     * @return string
     */
    private function interpolate($string, array $variables)
    {
        foreach ($variables as $key => $value) {
            $string = str_replace('{' . $key . '}', $value, $string);
        }

        return $string;
    }
}
