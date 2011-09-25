<?php
/*
 * Copyright (c) 2011 
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock;

use Che\LogStock\Adapter\DefaultLoggerAdapter;
use Che\LogStock\Loader\NullLoggerLoader;

/**
 * Description of LoggerFactory
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
class LoggerFactory
{
    /**
     * @var Logger Root logger
     */
    private static $rootLogger;

    private static $loader;

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

    /**
     * Get root logger
     *
     * @return Logger
     */
    public static function getRootLogger()
    {
        if (!self::$rootLogger) {
            self::$rootLogger = new Logger(new DefaultLoggerAdapter());
        }

        return self::$rootLogger;
    }

    /**
     * Get loader
     *
     * @return Loader\LoggerLoader
     */
    public static function getLoader()
    {
        if (!self::$loader) {
            self::$loader = new NullLoggerLoader();
        }

        return self::$loader;
    }
}
