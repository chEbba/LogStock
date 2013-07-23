<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Adapter\Tests;

use Che\LogStock\Adapter\Logger;
use Che\LogStock\Adapter\LogRecord;
use PHPUnit_Framework_TestCase as TestCase;
use Psr\Log\LogLevel;

/**
 * Logger tests
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class LoggerTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $adapter;
    /**
     * @var Logger
     */
    private $logger;

    protected function setUp()
    {
        $this->adapter = $this->getMock('Che\LogStock\Adapter\LogAdapter');
        $this->logger = new Logger($this->adapter, 'name');
    }

    /**
     * @test Getter for adapter
     */
    public function getAdapterReturnsAdapter()
    {
        $this->assertEquals($this->adapter, $this->logger->getAdapter());
    }

    /**
     * @test Getter for name
     */
    public function getNameReturnsName()
    {
        $this->assertEquals('name', $this->logger->getName());
    }

    /**
     * @test Main log method fallback to adapter
     */
    public function logUsesAdapter()
    {
        $level = LogLevel::INFO;
        $message = 'message';
        $context = ['foo' => 'bar'];

        $this->adapter
            ->expects($this->once())
            ->method('log')
            ->with(new LogRecord('name', $level, $message, $context))
        ;

        $this->logger->log($level, $message, $context);
    }
}
