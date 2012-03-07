<?php
/*
 * Copyright (c)
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Tests\Loader;

use Che\LogStock\Loader\HierarchicalLoggerLoader;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Test for HierarchicalLoggerLoader
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class HierarchicalLoggerLoaderTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $loader;
    /**
     * @var HierarchicalLoggerLoader
     */
    private $hierarchyLoader;
    /**
     * @var \Che\LogStock\Logger;
     */
    private $logger;

    protected function setUp()
    {
        $this->loader = $this->getMock('Che\LogStock\Loader\LoggerLoader');
        $this->hierarchyLoader = new HierarchicalLoggerLoader($this->loader, '$');
        $this->logger = $this->getMock('Che\LogStock\Logger', array(), array(), '', false);
    }

    /**
     * @test If internal loader found logger, hierarchy loader just returns it
     */
    public function directLoadIfExists()
    {
        $this->loader->expects(self::once())
            ->method('load')
            ->with('LogStock$Logger')
            ->will(self::returnValue($this->logger));

        $logger = $this->hierarchyLoader->load('LogStock$Logger');

        self::assertSame($this->logger, $logger);
    }

    /**
     * @test If loader did not find logger it should load parent
     */
    public function loadParentLogger()
    {
        $this->loader->expects(self::at(0))
            ->method('load')
            ->with('LogStock$Logger$Loader')
            ->will(self::returnValue(null));

        $this->loader->expects(self::at(1))
            ->method('load')
            ->with('LogStock$Logger')
            ->will(self::returnValue(null));

        $this->loader->expects(self::at(2))
            ->method('load')
            ->with('LogStock')
            ->will(self::returnValue($this->logger));

        $logger = $this->hierarchyLoader->load('LogStock$Logger$Loader');

        self::assertSame($this->logger, $logger);
    }

    /**
     * @test If no parents where found, null should be returned
     */
    public function noParentsLoadsNull()
    {
        $this->loader->expects(self::at(0))
            ->method('load')
            ->with('LogStock$Logger')
            ->will(self::returnValue(null));

        $this->loader->expects(self::at(1))
            ->method('load')
            ->with('LogStock')
            ->will(self::returnValue(null));

        $logger = $this->hierarchyLoader->load('LogStock$Logger');

        self::assertNull($logger);
    }
}
