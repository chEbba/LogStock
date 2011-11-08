<?php
/*
 * Copyright (c) 2011 
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock;

use Che\LogStock\Adapter\LoggerAdapter;

/**
 * Logger provides extended functionality around LoggerAdapter
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class Logger
{
    /** Emergency: system is unusable */
    const EMERG = 0;
    /** Alert: action must be taken immediately */
    const ALERT = 1;
    /** Critical: critical conditions */
    const CRIT = 2;
    /** Error: error conditions */
    const ERR = 3;
    /** Warning: warning conditions */
    const WARN = 4;
    /** Notice: normal but significant condition */
    const NOTICE = 5;
    /** Informational: informational messages */
    const INFO = 6;
    /** Debug: debug messages */
    const DEBUG = 7;

    private static $LEVELS = array(
        Logger::EMERG  => 'EMERG',
        Logger::ALERT  => 'ALERT',
        Logger::CRIT   => 'CRIT',
        Logger::ERR    => 'ERR',
        Logger::WARN   => 'WARN',
        Logger::NOTICE => 'NOTICE',
        Logger::INFO   => 'INFO',
        Logger::DEBUG  => 'DEBUG'
    );

    private $adapter;

    /**
     * Constructor
     *
     * @param LoggerAdapter $adapter
     */
    public function __construct(LoggerAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Get adapter for this logger
     *
     * @return LoggerAdapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Get list of levels
     *
     * @return array Level code => Level name
     */
    public static function getLevels()
    {
        return self::$LEVELS;
    }

    /**
     * Get level name by code
     *
     * @param int $code Level code
     *
     * @return string|null Level name or null if code is not exists
     */
    public static function getLevelName($code)
    {
        return isset(self::$LEVELS[$code]) ? self::$LEVELS[$code] : null;
    }

    /**
     * Log message
     *
     * @param int    $level Log level one of the Logger::* constants
     * @param string $message Log message
     * @param array  $context An array of extra information
     */
    public function log($level, $message, array $context = array())
    {
        if (!isset(self::$LEVELS[$level])) {
            throw new \InvalidArgumentException("Unknown level '$level'");
        }
        $this->adapter->log($level, $message, $context);
    }

    /**
     * Log message with Emergency level
     *
     * @param string $message Log message
     * @param array  $context An array of extra information
     */
    public function emerg($message, array $context = array())
    {
        $this->log(self::EMERG, $message, $context);
    }

    /**
     * Log message with Alert level
     *
     * @param string $message Log message
     * @param array  $context An array of extra information
     */
    public function alert($message, array $context = array())
    {
        $this->log(self::ALERT, $message, $context);
    }

    /**
     * Log message with Critical level
     *
     * @param string $message Log message
     * @param array  $context An array of extra information
     */
    public function crit($message, array $context = array())
    {
        $this->log(self::CRIT, $message, $context);
    }

    /**
     * Log message with Error level
     *
     * @param string $message Log message
     * @param array  $context An array of extra information
     */
    public function err($message, array $context = array())
    {
        $this->log(self::ERR, $message, $context);
    }

    /**
     * Log message with Warning level
     *
     * @param string $message Log message
     * @param array  $context An array of extra information
     */
    public function warn($message, array $context = array())
    {
        $this->log(self::WARN, $message, $context);
    }

    /**
     * Log message with Notice level
     *
     * @param string $message Log message
     * @param array  $context An array of extra information
     */
    public function notice($message, array $context = array())
    {
        $this->log(self::NOTICE, $message, $context);
    }

    /**
     * Log message with Informational level
     *
     * @param string $message Log message
     * @param array  $context An array of extra information
     */
    public function info($message, array $context = array())
    {
        $this->log(self::INFO, $message, $context);
    }

    /**
     * Log message with Debug level
     *
     * @param string $message Log message
     * @param array  $context An array of extra information
     */
    public function debug($message, array $context = array())
    {
        $this->log(self::DEBUG, $message, $context);
    }
}
