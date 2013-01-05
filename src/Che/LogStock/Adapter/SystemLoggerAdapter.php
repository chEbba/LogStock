<?php
/*
 * Copyright (c)
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Adapter;

use Che\LogStock\Logger;

/**
 * Adapter for system logging (through error_log)
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
class SystemLoggerAdapter implements LoggerAdapter
{
    /**
     * @var int
     */
    private $levelLimit;

    /**
     * Constructor with level limit support
     * @param int $levelLimit Max level to log message (less is more critical)
     */
    public function __construct($levelLimit = Logger::WARN)
    {
        $this->levelLimit = (int) $levelLimit;
    }

    /**
     * {@inheritDoc}
     */
    public function log($name, $level, $message, array $context = array())
    {
        $levelName = Logger::getLevelName($level);
        if (!$levelName) {
            throw new \InvalidArgumentException("Unknown level '$level'");
        }

        // Do not log anything with not important level
        if ($level >= $this->levelLimit) {
            return;
        }

        $message = sprintf("[%s] %s: %s (%s)", $levelName, $name, $message, json_encode($context));
        error_log($message);
    }
}
