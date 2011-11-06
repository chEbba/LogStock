<?php
/*
 * Copyright (c) 2011
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Tests;

use Che\LogStock\Logger;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Logger test
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
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
        $this->adapter = $this->getMock('Che\LogStock\Adapter\LoggerAdapter');
        $this->logger = new Logger($this->adapter);
    }

    /**
     * @test Getter for adapter
     */
    public function getAdapterReturnsAdapter()
    {
        self::assertEquals($this->adapter, $this->logger->getAdapter());
    }

    /**
     * @test Get levels
     */
    public function getLevelsReturnAssocArray()
    {
        self::assertEquals(array(
            Logger::EMERG  => 'EMERG',
            Logger::ALERT  => 'ALERT',
            Logger::CRIT   => 'CRIT',
            Logger::ERR    => 'ERR',
            Logger::WARN   => 'WARN',
            Logger::NOTICE => 'NOTICE',
            Logger::INFO   => 'INFO',
            Logger::DEBUG  => 'DEBUG'
        ), Logger::getLevels());
    }

    /**
     * @test Main log method fallback to adapter
     */
    public function testLogUsesAdapter()
    {
        $level = Logger::INFO;
        $message = 'message';
        $context = array('foo' => 'bar');

        $this->adapter->expects(self::once())
            ->method('log')
            ->with($level, $message, $context);

        $this->logger->log($level, $message, $context);
    }

    /**
     * @test All alias methods for level logging
     * @dataProvider aliasData
     */
    public function aliasMethods($method, $level, $message, array $context)
    {
        $this->testAliasMethod($method, $level, $message, $context);
    }

    /**
     * Get data for aliasMethods
     *
     * @return array
     */
    public function aliasData()
    {
        return array(
            array('emerg',  Logger::EMERG,  'message1', array('foo' => 'bar1')),
            array('alert',  Logger::ALERT,  'message2', array('foo' => 'bar2')),
            array('crit',   Logger::CRIT,   'message3', array('foo' => 'bar3')),
            array('err',    Logger::ERR,    'message4', array('foo' => 'bar4')),
            array('warn',   Logger::WARN,   'message5', array('foo' => 'bar5')),
            array('notice', Logger::NOTICE, 'message6', array('foo' => 'bar6')),
            array('info',   Logger::INFO,   'message7', array('foo' => 'bar7')),
            array('debug',  Logger::DEBUG,  'message8', array('foo' => 'bar8'))
        );
    }

    /**
     * Test alias method
     *
     * @param string $method
     * @param int    $level
     * @param string $message
     * @param array  $context
     */
    private function testAliasMethod($method, $level, $message, array $context)
    {
        $this->adapter->expects(self::once())
            ->method('log')
            ->with($level, $message, $context);

        call_user_func(array($this->logger, $method), $message, $context);
    }
}
?>
