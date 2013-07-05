<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\LogStock;

use Psr\Log\LogLevel as BaseLogLevel;

/**
 * Class LogLevel
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class LogLevel extends BaseLogLevel
{
    /**
     * Get level values
     *
     * @return array [severity => name]
     */
    public static function getValues()
    {
        return [
            self::EMERGENCY,
            self::ALERT,
            self::CRITICAL,
            self::ERROR,
            self::WARNING,
            self::NOTICE,
            self::INFO,
            self::DEBUG
        ];
    }

    /**
     * Get level severity
     * @link http://tools.ietf.org/html/rfc3164
     *
     * @param string $level
     *
     * @return int Positive integer, less is more important
     */
    public static function getLevelSeverity($level)
    {
        if (($index = array_search($level, self::getValues(), true)) === false) {
            throw new \InvalidArgumentException(sprintf('Unknown level "%s"', $level));
        }

        return $index;
    }
}