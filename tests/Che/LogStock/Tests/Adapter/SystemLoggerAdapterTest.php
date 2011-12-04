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
use Che\LogStock\Adapter\SystemLoggerAdapter;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * SystemLoggerAdapter Test
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
class SystemLoggerAdapterTest extends TestCase
{
    /**
     * @var SystemLoggerAdapter
     */
    private $adapter;
    /**
     * @var string
     */
    private $errorLog;
    /**
     * @var string
     */
    private $oldErrorLog;

    protected function setUp()
    {
        $this->adapter = new SystemLoggerAdapter();

        // Set error_log and save old value
        $this->oldErrorLog = ini_get('error_log');
        $this->errorLog = tempnam(sys_get_temp_dir(), 'logstock_log');
        ini_set('error_log', $this->errorLog);
    }

    protected function tearDown()
    {
        // Remove tmp log file
        @unlink($this->errorLog);
        // Restore error_log
        ini_set('error_log', $this->oldErrorLog);
    }


    /**
     * @test log method uses error log for logging
     */
    public function errorLogMessage()
    {
        $lvl = Logger::ERR;
        $message = 'Message text';
        $context = array('foo' => 'bar');

        $this->adapter->log($lvl, $message, $context);

        $text = file_get_contents($this->errorLog);

        $this->assertContains(sprintf('[%s] %s | %s', Logger::getLevelName($lvl), $message, json_encode($context)), $text);
    }

    /**
     * @test log with wrong level throws exception
     * @expectedException InvalidArgumentException
     */
    public function wrongLevel()
    {
        $this->adapter->log(666, 'o_O');
    }
}
