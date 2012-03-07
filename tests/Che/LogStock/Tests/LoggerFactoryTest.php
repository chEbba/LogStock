<?php
/*
 * Copyright (c)
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
     * @test If no adapter was set, the default should be returned
     */
    public function defaultRootAdapter()
    {
        self::assertInstanceOf('Che\LogStock\Adapter\SystemLoggerAdapter', LoggerFactory::getRootAdapter());
    }

    /**
     * @test initRootAdapter set new rootAdapter
     */
    public function initRootLoggerReplaceAdapter()
    {
        $adapter = $this->getMock('Che\LogStock\Adapter\LoggerAdapter');
        LoggerFactory::initRootAdapter($adapter);
        self::assertEquals($adapter, LoggerFactory::getRootAdapter());
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
     * @test If no adapter was found, logger with the default adapter should be returned
     */
    public function rootLoggerFallback()
    {
        $logger = LoggerFactory::getLogger('not_exists');
        self::assertEquals(LoggerFactory::getRootAdapter(), $logger->getAdapter());
        self::assertEquals('not_exists', $logger->getName());
    }

    /**
     * @test getLogger uses loader to find adapters
     */
    public function namedLogger()
    {
        $adapter = $this->getMock('Che\LogStock\Adapter\LoggerAdapter');
        $loader = $this->getMock('Che\LogStock\Loader\LoggerLoader');
        $loader->expects(self::once())
            ->method('load')
            ->with('name')
            ->will(self::returnValue($adapter));

        LoggerFactory::initLoader($loader);


        self::assertEquals($adapter, LoggerFactory::getLogger('name')->getAdapter());
    }

    /**
     * @test getLogger always return same instance for same name
     */
    public function sameLogger()
    {
        self::assertSame(LoggerFactory::getLogger('name'), LoggerFactory::getLogger('name'));
    }
}
