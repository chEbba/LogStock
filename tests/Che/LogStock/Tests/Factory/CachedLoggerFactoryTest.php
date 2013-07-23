<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\LogStock\Tests\Factory;

use Che\LogStock\Factory\CachedLoggerFactory;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Class CachedLoggerFactoryTest
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
class CachedLoggerFactoryTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $nested;
    /**
     * @var CachedLoggerFactory
     */
    private $factory;

    /**
     * Setup nested mock and cached factory
     */
    protected function setUp()
    {
        $this->nested = $this->getMock('Che\LogStock\Factory\LoggerFactory');
        $this->factory = new CachedLoggerFactory($this->nested);
    }

    /**
     * @test getLogger proxies to nested only for the first time
     */
    public function useNestedOnce()
    {
        $logger = $this->getMock('Psr\Log\LoggerInterface');
        $this->nested
            ->expects($this->once())
            ->method('getLogger')
            ->with('foo')
            ->will($this->returnValue($logger))
        ;

        $this->assertSame($logger, $this->factory->getLogger('foo'));
        $this->assertSame($logger, $this->factory->getLogger('foo'));
    }

    /**
     * @test if cache is cleared nested factory is used to retrieve logger
     */
    public function cacheClear()
    {
        $logger1 = $this->getMock('Psr\Log\LoggerInterface');
        $logger2 = $this->getMock('Psr\Log\LoggerInterface');
        $this->nested
            ->expects($this->at(0))
            ->method('getLogger')
            ->with('foo')
            ->will($this->returnValue($logger1))
        ;
        $this->nested
            ->expects($this->at(1))
            ->method('getLogger')
            ->with('foo')
            ->will($this->returnValue($logger2))
        ;

        $this->assertSame($logger1, $this->factory->getLogger('foo'));
        $this->factory->release();
        $this->assertSame($logger2, $this->factory->getLogger('foo'));
    }
}
