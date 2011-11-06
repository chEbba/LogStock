<?php
/*
 * Copyright (c) 2011 
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Tests;

use Che\LogStock\LoggerFactory;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * LoggerFactory Test
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
class LoggerFactoryTest extends TestCase
{
    /**
     * @test If no logger set, the default should be returned
     */
    public function defaultRootLogger()
    {
        self::assertInstanceOf('Che\LogStock\Adapter\SystemLoggerAdapter', LoggerFactory::getRootLogger()->getAdapter());
    }

    /**
     * @test initRootLogger set new rootLogger
     */
    public function initRootLoggerReplaceLogger()
    {
        $adapter = $this->getMock('Che\LogStock\Adapter\LoggerAdapter');
        LoggerFactory::initRootLogger($adapter);
        self::assertEquals($adapter, LoggerFactory::getRootLogger()->getAdapter());
    }

    /**
     * @test If no loader set, the default loader should be returned
     */
    public function defaultLoader()
    {
        self::assertInstanceOf('Che\LogStock\Loader\NullLoggerLoader', LoggerFactory::getLoader());
    }

    /**
     * @test initLoader set new LoggerLoader
     */
    public function initLoaderReplaceLoader()
    {
        $loader = $this->getMock('Che\LogStock\Loader\LoggerLoader');
        LoggerFactory::initLoader($loader);
        self::assertEquals($loader, LoggerFactory::getLoader());
    }

    /**
     * @test If no logger found, root logger should be returned
     */
    public function rootLoggerFallback()
    {
        self::assertEquals(LoggerFactory::getRootLogger(), LoggerFactory::getLogger('not_exists'));
    }

    /**
     * @test getLogger uses loader to find loggers
     */
    public function namedLogger()
    {
        $logger = $this->getMock('Che\LogStock\Logger', array(), array(), '', false);
        $loader = $this->getMock('Che\LogStock\Loader\LoggerLoader');
        $loader->expects(self::once())
            ->method('load')
            ->with('name')
            ->will(self::returnValue($logger));

        LoggerFactory::initLoader($loader);

        self::assertEquals($logger, LoggerFactory::getLogger('name'));
    }
}
