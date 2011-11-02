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
use Che\LogStock\Adapter\SystemLoggerAdapter;

use Che\LogStock\Loader\LoggerLoader;
use Che\LogStock\Loader\NullLoggerLoader;

/**
 * Static factory for loggers
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
class LoggerFactory
{
    /**
     * @var Logger
     */
    private static $rootLogger;
    /**
     * @var LoggerLoader
     */
    private static $loader;

    /**
     * Get root logger. All missed loggers will fallback to this logger
     *
     * @return Logger
     */
    public static function getRootLogger()
    {
        if (!self::$rootLogger) {
            self::$rootLogger = new Logger(new SystemLoggerAdapter());
        }

        return self::$rootLogger;
    }

    /**
     * Initialize root logger
     *
     * @param LoggerAdapter $adapter Adapter for logger
     */
    public static function initRootLogger(LoggerAdapter $adapter)
    {
        self::$rootLogger = new Logger($adapter);
    }

    /**
     * Get logger loader
     *
     * @return LoggerLoader
     */
    public static function getLoader()
    {
        if (!self::$loader) {
            self::$loader = new NullLoggerLoader();
        }

        return self::$loader;
    }

    /**
     * Initialize loader for loggers
     *
     * @param LoggerLoader $loader Logger loader
     */
    public static function initLoader(LoggerLoader $loader)
    {
        self::$loader = $loader;
    }

    /**
     * Get logger by name.
     *
     * @param string $name
     *
     * @return Logger
     */
    public static function getLogger($name)
    {
        return self::getLoader()->load($name) ?: self::getRootLogger();
    }
}
