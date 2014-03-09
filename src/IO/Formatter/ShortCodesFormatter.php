<?php

/**
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO\Formatter;

use ThinFrame\CommandLine\IO\Constant\BackgroundColor;
use ThinFrame\CommandLine\IO\Constant\ForegroundColor;
use ThinFrame\CommandLine\IO\Constant\TextEffect;
use ThinFrame\CommandLine\IO\Constant\TextReset;
use ThinFrame\CommandLine\IO\Helper\Bash;
use ThinFrame\CommandLine\IO\Helper\StringTransformer;
use ThinFrame\CommandLine\IO\OutputFormatterInterface;
use ThinFrame\Foundation\Helper\ShortCodesProcessor;

/**
 * Class ShortCodesFormatter
 *
 * @package ThinFrame\CommandLine\IO\Formatters
 * @since   0.3
 */
class ShortCodesFormatter implements OutputFormatterInterface
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
     * Register supported shortcodes
     */
    private function registerShortCodes()
    {
        $this->shortCodesProcessor->registerShortCode('format', [$this, 'parse']);
        $this->shortCodesProcessor->registerShortCode('center', [$this, 'parse']);
        $this->shortCodesProcessor->registerShortCode('sideways', [$this, 'parse']);
        $this->shortCodesProcessor->registerShortCode('success', [$this, 'parse']);
        $this->shortCodesProcessor->registerShortCode('error', [$this, 'parse']);
        $this->shortCodesProcessor->registerShortCode('info', [$this, 'parse']);
    }

    /**
     * Handles shortcodes parsing
     *
     * @param array               $attributes
     * @param null|string         $content
     * @param null|string         $tag
     * @param ShortCodesProcessor $processor
     *
     * @return string
     */
    public function parse($attributes, $content = null, $tag = null, ShortCodesProcessor $processor = null)
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
                        $options[] = $textEffects->get($effect)->getOrElse(null);
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
     * Format a message
     *
     * @param string $message
     *
     * @return string
     */
    public function format($message)
    {
        return $this->shortCodesProcessor->parseContent($message);
    }
}
