<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
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
 * @license http://www.opensource.org/licenses/mit-license.php MIT
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
    private $adapter;


    protected function setUp()
    {
        $this->locator = $this->getMock('Che\LogStock\Loader\Container\ServiceLocator');
        $this->formatter = $this->getMock('Che\LogStock\Loader\Container\ServiceNameFormatter');
        $this->loader = new ServiceLocatorLoader($this->locator, $this->formatter);
        $this->adapter = $this->getMock('Che\LogStock\Adapter\LoggerAdapter', array(), array(), '', false);
    }

    /**
     * @test Loader uses locator and formatter to find adapter services
     */
    public function locatorAndFormatter()
    {
        $this->expectsLocator($this->adapter);

        $adapter = $this->loader->load('adapter');

        self::assertSame($this->adapter, $adapter);
    }

    /**
     * @test If no service found, null should be returned
     */
    public function notFound()
    {
        $this->expectsLocator(null);

        $adapter = $this->loader->load('adapter');

        self::assertNull($adapter);
    }

    /**
     * @test If service found but is not LoggerAdapter, null should be returned
     */
    public function notLogger()
    {
        $this->expectsLocator(new \stdClass());

        $logger = $this->loader->load('adapter');

        self::assertNull($logger);
    }

    /**
     * Expects locator and formatter calls
     *
     * @param mixed $value Locator return value
     */
    private function expectsLocator($value)
    {
        $this->locator->expects(self::once())
            ->method('getService')
            ->with('adapter_service')
            ->will(self::returnValue($value));

        $this->formatter->expects(self::once())
            ->method('formatServiceName')
            ->with('adapter')
            ->will(self::returnValue('adapter_service'));
    }
}
