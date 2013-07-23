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
use Che\LogStock\Adapter\PsrAdapter;
use PHPUnit_Framework_TestCase as TestCase;
use Psr\Log\LogLevel;

/**
 * PsrAdapter test
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class PsrAdapterTest extends TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $logger;
    /**
     * @var PsrAdapter
     */
    private $adapter;
    
    protected function setUp()
    {
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');
        $this->adapter = new PsrAdapter($this->logger);
    }

    /**
     * @test Log method proxies to Monolog ZF compatible methods
     */
    public function logUsesZfMethods()
    {
        $modifiedContext = $context = ['foo' => 'bar'];
        $modifiedContext[PsrAdapter::CONTEXT_NAME_KEY] = 'name';

        $this->logger
            ->expects($this->once())
            ->method('log')
            ->with(LogLevel::INFO, 'message text', $modifiedContext)
        ;

        $this->adapter->log(new LogRecord('name', LogLevel::INFO, 'message text', $context));
    }
}
