<?php

/**
 * src/IO/Helpers/StringTransformer.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\CommandLine\IO\Helper;

use ThinFrame\CommandLine\IO\Constant\BackgroundColor;
use ThinFrame\CommandLine\IO\Constant\ForegroundColor;
use ThinFrame\CommandLine\IO\Constant\TextEffect;
use ThinFrame\CommandLine\IO\Constant\TextReset;
use ThinFrame\Foundation\Exception\InvalidArgumentException;

/**
 * Class StringTransformer
 *
 * @package ThinFrame\CommandLine\IO\Helpers
 * @since   0.2
 */
class StringTransformer
{
    /**
     * Transform text to bash format
     *
     * @param       $text
     * @param array $options
     *
     * @return string
     * @throws InvalidArgumentException
     */
    public static function transformText($text, $options = array())
    {
        foreach ($options as $option) {
            $invalid = !ForegroundColor::isValid($option);
            $invalid = $invalid && !BackgroundColor::isValid($option);
            $invalid = $invalid && !TextEffect::isValid($option);
            $invalid = $invalid && !TextReset::isValid($option);

            if ($invalid) {
                throw new InvalidArgumentException('Invalid option provided');
            }
            if (TextReset::isValid($option)) {
                $text .= self::getOption($option);
            } else {
                $text = self::getOption($option) . $text;
            }
        }

        return $text;
    }

    /**
     * Get option
     *
     * @param $value
     *
     * @return string
     */
    protected static function getOption($value)
    {
        return sprintf("\033[%sm", $value);
    }
}
