<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Tests\Adapter;

use Che\LogStock\Adapter\LogRecord;
use Che\LogStock\Adapter\SystemLogAdapter;
use PHPUnit_Framework_TestCase as TestCase;
use Psr\Log\LogLevel;

/**
 * SystemLoggerAdapter Test
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
class SystemLoggerAdapterTest extends TestCase
{
    /**
     * @var SystemLogAdapter
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

    /**
     * Create adapter and set error_log to tmp file
     */
    protected function setUp()
    {
        $this->adapter = new SystemLogAdapter();

        // Set error_log and save old value
        $this->oldErrorLog = ini_get('error_log');
        $this->errorLog = tempnam(sys_get_temp_dir(), 'logstock_log');
        ini_set('error_log', $this->errorLog);
    }

    /**
     * Remove error log file and restore ini parameter
     */
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
        $lvl = LogLevel::ERROR;
        $message = 'Message text';
        $context = ['foo' => 'bar'];

        $this->adapter->log(new LogRecord('name', $lvl, $message, $context));

        $text = file_get_contents($this->errorLog);

        $this->assertContains(sprintf("[%s] %s: %s (%s)", strtoupper($lvl), 'name', $message, json_encode($context)), $text);
    }
}
