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
        $record = array(
            'context' => array(MonologAdapter::NAME_KEY => 'name'),
            'extra' => array()
        );

        self::assertEquals(
            array(
                'context' => array(),
                'extra' => array(MonologAdapter::NAME_KEY => 'name')
            ),
            $this->processor->__invoke($record)
        );
    }

    /**
     * @test __invoke do nothing if context does not have name parameter
     */
    public function doNothingIfNoParameter()
    {
        $record = array(
            'context' => array(),
            'extra' => array()
        );

        self::assertEquals(
            array(
                'context' => array(),
                'extra' => array()
            ),
            $this->processor->__invoke($record)
        );
    }
}
