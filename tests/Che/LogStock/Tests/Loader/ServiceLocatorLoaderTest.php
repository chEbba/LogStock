<?php
/*
 * Copyright (c) 2011 
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Tests\Loader;

use Che\LogStock\Loader\ServiceLocatorLoader;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Test for ServiceLocatorLoader
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class ServiceLocatorLoaderTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $locator;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $formatter;
    /**
     * @var ServiceLocatorLoader
     */
    private $loader;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $logger;


    protected function setUp()
    {
        $this->locator = $this->getMock('Che\LogStock\Loader\Container\ServiceLocator');
        $this->formatter = $this->getMock('Che\LogStock\Loader\Container\ServiceNameFormatter');
        $this->loader = new ServiceLocatorLoader($this->locator, $this->formatter);
        $this->logger = $this->getMock('Che\LogStock\Logger', array(), array(), '', false);
    }

    /**
     * @test Loader uses locator and formatter to find logger services
     */
    public function locatorAndFormatter()
    {
        $this->expectsLocator($this->logger);

        $logger = $this->loader->load('logger');

        self::assertSame($this->logger, $logger);
    }

    /**
     * @test If no service found, null should be returned
     */
    public function notFound()
    {
        $this->expectsLocator(null);

        $logger = $this->loader->load('logger');

        self::assertNull($logger);
    }

    /**
     * @test If service found but is not Logger, null should be returned
     */
    public function notLogger()
    {
        $this->expectsLocator(new \stdClass());

        $logger = $this->loader->load('logger');

        self::assertNull($logger);
    }

    /**
     * Expects locator and formatter calls
     *
     * @param $value Locator return value
     */
    private function expectsLocator($value)
    {
        $this->locator->expects(self::once())
            ->method('getService')
            ->with('logger_service')
            ->will(self::returnValue($value));

        $this->formatter->expects(self::once())
            ->method('formatServiceName')
            ->with('logger')
            ->will(self::returnValue('logger_service'));
    }
}
