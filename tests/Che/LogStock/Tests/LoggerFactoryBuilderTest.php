<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Tests;

use Che\LogStock\Factory\CachedLoggerFactory;
use Che\LogStock\LoggerFactoryBuilder;
use Che\LogStock\LoggerManager;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Test for LoggerFactoryBuilder
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class LoggerFactoryBuilderTest extends TestCase
{
    /**
     * Create builder
     *
     * @return LoggerFactoryBuilder
     */
    protected function builder()
    {
        return new LoggerFactoryBuilder();
    }

    /**
     * @test factory with adapter loader is used by default and optionally wrapped with cache
     */
    public function adapterLoaderFactory()
    {
        /** @var CachedLoggerFactory $cached */
        $cached = $this->builder()->build();
        $this->assertInstanceOf('Che\LogStock\Factory\CachedLoggerFactory', $cached);
        $this->assertInstanceOf('Che\LogStock\Factory\AdapterLoaderFactory', $cached->getNestedFactory());

        $this->assertInstanceOf('Che\LogStock\Factory\AdapterLoaderFactory', $this->builder()->disableCache()->build());
    }

    /**
     * @test custom factory can be set and will be optionally wrapped with cache
     */
    public function customFactory()
    {
        $factory = $this->getMock('Che\LogStock\Factory\LoggerFactory');
        /** @var CachedLoggerFactory $cached */
        $cached = $this->builder()->factory($factory)->build();
        $this->assertInstanceOf('Che\LogStock\Factory\CachedLoggerFactory', $cached);
        $this->assertSame($factory, $cached->getNestedFactory());
        $this->assertSame($factory, $this->builder()->factory($factory)->disableCache()->build());
    }

    /**
     * @test register built factory in LoggerManager
     */
    public function registerBuiltFactory()
    {
        $this->assertSame($this->builder()->register(), LoggerManager::getFactory());
    }
}
