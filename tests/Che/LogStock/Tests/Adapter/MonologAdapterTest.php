<?php
/*
 * Copyright (c) 2011
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Tests\Adapter;

use Che\LogStock\Logger;
use Che\LogStock\Adapter\MonologAdapter;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * MonologAdapter test
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class MonologAdapterTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $monolog;
    /**
     * @var MonologAdapter
     */
    private $adapter;
    
    protected function setUp()
    {
        if (!class_exists('Monolog\Logger')) {
            self::markTestSkipped('Monolog is not installed');
            return;
        }

        $this->monolog = $this->getMock('Monolog\Logger', array(), array(), '', false);
        $this->adapter = new MonologAdapter($this->monolog);
    }

    /**
     * @test Log method proxies to Monolog ZF compatible methods
     * @dataProvider zfMethodData
     */
    public function logUsesZfMethods($method, $level, $message, $context)
    {
        $this->expectsZfMethod($method, $message, $context);
        $this->adapter->log($level, $message, $context);
    }

    /**
     * Test data for zf compatible methods
     * 
     * @return array An array of arrays [$method, $level, $message, $context]
     */
    public function zfMethodData()
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
     * @test log should throw an exception on wrong level
     * @expectedException \InvalidArgumentException
     */
    public function exceptionOnWrongLevel()
    {
        $this->adapter->log('unknown', 'message', array('context' => 'cool'));
    }

    /**
     * Add expects for zf method
     * 
     * @param string $method
     * @param string $message
     * @param array  $context
     */
    private function expectsZfMethod($method, $message, $context)
    {
        $this->monolog->expects(self::once())
            ->method($method)
            ->with($message, $context);
    }
}
