<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Tests;

use Che\LogStock\LoggerFactoryBuilder;
use Che\LogStock\LoggerManager;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Tests for LoggerManager
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class LoggerManagerTest extends TestCase
{
    /**
     * @test if no factory was set a default factory is created with builder
     */
    public function defaultFactory()
    {
        $builder = new LoggerFactoryBuilder();

        $this->assertEquals($builder->build(), LoggerManager::getFactory());
    }

    /**
     * @test logger manager use logger from factory
     */
    public function loggerFromFactory()
    {
        $logger = $this->getMock('Psr\Log\LoggerInterface');
        $factory = $this->getMock('Che\LogStock\Factory\LoggerFactory');
        $factory->expects($this->once())->method('getLogger')->with('_name_')->will($this->returnValue($logger));

        LoggerManager::registerFactory($factory);
        $this->assertEquals($logger, LoggerManager::getLogger('_name_'));
    }
}
