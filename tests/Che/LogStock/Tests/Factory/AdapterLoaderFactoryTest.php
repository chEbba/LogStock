<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\LogStock\Tests\Factory;

use Che\LogStock\Factory\AdapterLoaderFactory;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Class AdapterLoaderFactoryTest
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class AdapterLoaderFactoryTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $loader;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $fallbackAdapter;
    /**
     * @var AdapterLoaderFactory
     */
    private $factory;

    /**
     * Setup factory with mocked tooAdapter and loader
     */
    protected function setUp()
    {
        $this->loader = $this->getMock('Che\LogStock\Loader\LogAdapterLoader');
        $this->fallbackAdapter = $this->getMock('Che\LogStock\Adapter\LogAdapter');
        $this->factory = new AdapterLoaderFactory($this->loader, $this->fallbackAdapter);
    }

    /**
     * @test factory creates logger from loaded adapter
     */
    public function loggerFromLoadedAdapter()
    {
        $adapter = $this->getMock('Che\LogStock\Adapter\LogAdapter');
        $this->loader
            ->expects($this->once())
            ->method('load')
            ->with('foo')
            ->will($this->returnValue($adapter))
        ;

        $this->assertSame($adapter, $this->factory->getLogger('foo')->getAdapter());
    }

    /**
     * @test if adapter is not found, fallback one is used
     */
    public function fallbackOnNotFoundAdapter()
    {
        $this->loader
            ->expects($this->once())
            ->method('load')
            ->with('foo')
            ->will($this->returnValue(null))
        ;

        $this->assertSame($this->fallbackAdapter, $this->factory->getLogger('foo')->getAdapter());
    }
}
