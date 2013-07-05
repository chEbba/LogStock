<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
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
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
class LoggerFactory
{
    /**
     * @var Logger
     */
    private static $rootAdapter;
    /**
     * @var LoggerLoader
     */
    private static $loader;
    /**
     * @var array Logger map
     */
    private static $loggers = array();

    /**
     * Initialize root logger adapter
     *
     * @param LoggerAdapter $adapter Adapter for logger
     */
    public static function initRootAdapter(LoggerAdapter $adapter)
    {
        self::$rootAdapter = $adapter;
    }

    /**
     * Get root logger adapter. All missed adapters will fallback to this adapter
     *
     * @return LoggerAdapter
     */
    public static function getRootAdapter()
    {
        if (!self::$rootAdapter) {
            self::$rootAdapter = new SystemLoggerAdapter();
        }

        return self::$rootAdapter;
    }

    /**
     * Initialize loader for logger adapters
     *
     * @param LoggerLoader $loader Logger loader
     */
    public static function initLoader(LoggerLoader $loader)
    {
        self::$loader = $loader;
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
     * Get logger by name
     *
     * @param string $name
     *
     * @return Logger
     */
    public static function getLogger($name)
    {
        // Return exist logger or create new from adapter
        return isset(self::$loggers[$name]) ?
            self::$loggers[$name] :
            self::$loggers[$name] = new Logger(self::loadAdapter($name), $name)
        ;
    }

    /**
     * Load adapter by name
     *
     * @param string $name
     *
     * @return LoggerAdapter
     */
    private static function loadAdapter($name)
    {
        return self::getLoader()->load($name) ?: self::getRootAdapter();
    }
}
