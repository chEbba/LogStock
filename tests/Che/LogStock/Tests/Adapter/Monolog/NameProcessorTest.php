<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Tests\Adapter\Monolog;

use Che\LogStock\Adapter\Monolog\MonologAdapter;
use Che\LogStock\Adapter\Monolog\NameProcessor;
use Che\LogStock\Adapter\PsrAdapter;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * NameProcessor test
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class NameProcessorTest extends TestCase
{
    /**
     * @var NameProcessor
     */
    private $processor;
    
    protected function setUp()
    {
        $this->processor = new NameProcessor();
    }

    /**
     * @test __invoke move name parameter in record
     */
    public function moveNameParameter()
    {
        $record = [
            'context' => [PsrAdapter::CONTEXT_NAME_KEY => 'name'],
            'extra' => []
        ];

        self::assertEquals(
            [
                'context' => [],
                'extra' => [PsrAdapter::CONTEXT_NAME_KEY => 'name']
            ],
            $this->processor->__invoke($record)
        );
    }

    /**
     * @test __invoke if context does not have name parameter use empty parameter
     */
    public function setEmptyIfNoParameter()
    {
        $record = [
            'context' => [],
            'extra' => []
        ];

        self::assertEquals(
            [
                'context' => [],
                'extra' => [PsrAdapter::CONTEXT_NAME_KEY => '']
            ],
            $this->processor->__invoke($record)
        );
    }
}
