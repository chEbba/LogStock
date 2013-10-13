<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock;

use Che\LogStock\Factory\LoggerFactory;
use Psr\Log\LoggerInterface;

/**
 * Globally manages named loggers
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
class LoggerManager
{
    private static $factory;

    /**
     * Register factory for loggers
     *
     * DO NOT USE THIS METHOD IN YOUR APPLICATION CODE
     * THIS METHOD IS FOR STARTUP CONFIGURATION ONLY
     *
     * @param LoggerFactory $factory
     */
    public static function registerFactory(LoggerFactory $factory)
    {
        self::$factory = $factory;
    }

    /**
     * Get factory for loggers
     *
     * @return LoggerFactory
     */
    public static function getFactory()
    {
        if (!self::$factory) {
            self::$factory = (new LoggerFactoryBuilder())->build();
        }

        return self::$factory;
    }

    /**
     * Get logger by name
     *
     * @param string $name
     *
     * @return LoggerInterface
     */
    public static function getLogger($name)
    {
        return self::getFactory()->getLogger($name);
    }
}
