<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Tests\Loader;

use Che\LogStock\Loader\HierarchicalLogLoader;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Test for HierarchicalLoggerLoader
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class HierarchicalLogLoaderTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $loader;
    /**
     * @var HierarchicalLogLoader
     */
    private $hierarchyLoader;
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $adapter;

    protected function setUp()
    {
        $this->loader = $this->getMock('Che\LogStock\Loader\LogAdapterLoader');
        $this->hierarchyLoader = new HierarchicalLogLoader($this->loader, '$');
        $this->adapter = $this->getMock('Che\LogStock\Adapter\LogAdapter');
    }

    /**
     * @test If internal loader found logger, hierarchy loader just returns it
     */
    public function directLoadIfExists()
    {
        $this->loader->expects(self::once())
            ->method('load')
            ->with('LogStock$Logger')
            ->will($this->returnValue($this->adapter));

        $adapter = $this->hierarchyLoader->load('LogStock$Logger');

        $this->assertSame($this->adapter, $adapter);
    }

    /**
     * @test If loader did not find logger it should load parent
     */
    public function loadParentLogger()
    {
        $this->loader->expects(self::at(0))
            ->method('load')
            ->with('LogStock$Logger$Loader')
            ->will($this->returnValue(null));

        $this->loader->expects(self::at(1))
            ->method('load')
            ->with('LogStock$Logger')
            ->will($this->returnValue(null));

        $this->loader->expects(self::at(2))
            ->method('load')
            ->with('LogStock')
            ->will($this->returnValue($this->adapter));

        $adapter = $this->hierarchyLoader->load('LogStock$Logger$Loader');

        $this->assertSame($this->adapter, $adapter);
    }

    /**
     * @test Logger with empty name is loaded at the end of hierarchy
     */
    public function emptyNameLogger()
    {
        $this->loader->expects(self::at(0))
            ->method('load')
            ->with('LogStock$Logger')
            ->will($this->returnValue(null));

        $this->loader->expects(self::at(1))
            ->method('load')
            ->with('LogStock')
            ->will($this->returnValue(null));

        $this->loader->expects(self::at(2))
            ->method('load')
            ->with('')
            ->will($this->returnValue($this->adapter));

        $adapter = $this->hierarchyLoader->load('LogStock$Logger');

        $this->assertSame($this->adapter, $adapter);
    }

    /**
     * @test If no parents where found, null should be returned
     */
    public function noParentsLoadsNull()
    {
        $this->loader->expects($this->at(0))
            ->method('load')
            ->with('LogStock$Logger')
            ->will($this->returnValue(null));

        $this->loader->expects($this->at(1))
            ->method('load')
            ->with('LogStock')
            ->will($this->returnValue(null));

        $this->loader->expects($this->at(2))
            ->method('load')
            ->with('')
            ->will($this->returnValue(null));

        $adapter = $this->hierarchyLoader->load('LogStock$Logger');

        $this->assertNull($adapter);
    }
}
