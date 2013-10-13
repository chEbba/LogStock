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
}
