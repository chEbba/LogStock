<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock;

use Psr\Log\LogLevel as BaseLogLevel;

/**
 * LogLevel enhanced with helper methods
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
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
     * @param string $level self::* constant
     *
     * @return int Non-negative integer, less is more important
     * @throws \InvalidArgumentException on wrong level
     */
    public static function getLevelSeverity($level)
    {
        if (($index = array_search($level, self::getValues(), true)) === false) {
            throw new \InvalidArgumentException(sprintf('Unknown level "%s"', $level));
        }

        return $index;
    }
}
