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
 * Log record object
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class LogRecord
{
    private $logger;
    private $level;
    private $message;
    private $context;

    /**
     * @param string $logger  Logger name
     * @param string $level   LogLevel::* constants
     * @param string $message Log message
     * @param array  $context Context for logging
     *
     * @throws \InvalidArgumentException On wrong level
     */
    public function __construct($logger, $level, $message, array $context = [])
    {
        if (array_search($level, LogLevel::getValues()) === false) {
            throw new \InvalidArgumentException("Unknown level '$level'");
        }

        $this->logger = (string) $logger;
        $this->level = $level;
        $this->message = (string) $message;
        $this->context = $context;
    }

    /**
     * Logger name
     *
     * @return string
     */
    public function getLogger()
    {
        return $this->logger;
    }

    /**
     * Log level
     *
     * @return string LogLevel::*
     * @see LogLevel
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Log message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Log context
     *
     * @return array
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Get message with replaced context keys base on PSR-3 rules
     * @link http://www.php-fig.org/psr/3/
     *
     * @return string
     */
    public function getInterpolatedMessage()
    {
        static $message;

        if ($message === null) {
            if (empty($this->context) || false === strpos($this->message, '{')) {
                $message = $this->message;
            } else {
                $replace = [];
                foreach ($this->context as $key => $val) {
                    $replace['{' . $key . '}'] = (string) $val;
                }

                $message = strtr($this->message, $replace);
            }
        }

        return $message;
    }
}
