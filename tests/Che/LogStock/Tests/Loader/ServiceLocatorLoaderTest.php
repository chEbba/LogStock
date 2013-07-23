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
     * @var ServiceLocatorLoader
     */
    private $loader;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $adapter;

    protected function setUp()
    {
        $this->locator = $this->getMock('Che\ServiceLocator\ServiceLocator');
        $this->loader = new ServiceLocatorLoader($this->locator);
        $this->adapter = $this->getMock('Che\LogStock\Adapter\LogAdapter');
    }

    /**
     * @test Loader uses locator to find adapter services
     */
    public function loadWithLocator()
    {
        $this->expectsLocator($this->adapter);

        $adapter = $this->loader->load('adapter_service');

        $this->assertSame($this->adapter, $adapter);
    }

    /**
     * @test If no service found, null should be returned
     */
    public function notFound()
    {
        $this->expectsLocator(null);

        $adapter = $this->loader->load('adapter_service');

        $this->assertNull($adapter);
    }

    /**
     * @test If service found but is not LogAdapter, null should be returned
     */
    public function notAdapter()
    {
        $this->expectsLocator(new \stdClass());

        $adapter = $this->loader->load('adapter_service');

        $this->assertNull($adapter);
    }

    /**
     * Expects locator and formatter calls
     *
     * @param mixed $value Locator return value
     */
    private function expectsLocator($value)
    {
        $this->locator
            ->expects($this->once())
            ->method('getService')
            ->with('adapter_service')
            ->will($this->returnValue($value))
        ;
    }
}
