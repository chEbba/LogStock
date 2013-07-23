<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Adapter;

use Che\LogStock\LogLevel;

/**
 * Adapter for system logging (through error_log)
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
class SystemLogAdapter implements LogAdapter
{
    /**
     * @var int
     */
    private $severityLimit;

    /**
     * Constructor with level limit support
     *
     * @param string $levelLimit LogLevel::* constants. Max level to log message.
     *
     * @see LogLevel::getLevelSeverity
     */
    public function __construct($levelLimit = LogLevel::WARNING)
    {
        $this->severityLimit = LogLevel::getLevelSeverity($levelLimit);
    }

    /**
     * {@inheritDoc}
     */
    public function log(LogRecord $record)
    {
        $severity = LogLevel::getLevelSeverity($record->getLevel());

        // Do not log anything with not important level
        if ($severity >= $this->severityLimit) {
            return;
        }

        $message = sprintf(
            "[%s] %s: %s (%s)",
            strtoupper($record->getLevel()),
            $record->getLogger(),
            $record->getInterpolatedMessage(),
            json_encode($record->getContext())
        );
        error_log($message);
    }
}
