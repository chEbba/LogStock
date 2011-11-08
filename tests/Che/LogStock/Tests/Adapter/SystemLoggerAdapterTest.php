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

    protected function setUp()
    {
        $this->adapter = new SystemLoggerAdapter();
    }

    /**
     * @test log method uses error log for logging
     */
    public function errorLogMessage()
    {
        $lvl = Logger::ERR;
        $message = 'Message text';
        $context = array('foo' => 'bar');

        $tmpLog = tempnam(sys_get_temp_dir(), 'php_test_log');

        // Set error_log
        $oldErrorLog = ini_get('error_log');
        ini_set('error_log', $tmpLog);

        $this->adapter->log($lvl, $message, $context);

        // Restore error_log
        ini_set('error_log', $oldErrorLog);

        $text = file_get_contents($tmpLog);
        @unlink($tmpLog);

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
