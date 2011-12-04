<?php
/*
 * Copyright (c) 2011 
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Tests\Loader;

use Che\LogStock\Loader\NullLoggerLoader;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Test for NullLoggerLoader
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class NullLoggerLoaderTest extends TestCase
{
    /**
     * @var NullLoggerLoader
     */
    private $loader;

    protected function setUp()
    {
        $this->loader = new NullLoggerLoader();
    }

    /**
     * @test Null loader loads nothing
     */
    public function loadAlwaysNull()
    {
        self::assertNull($this->loader->load('logger'));
    }
}
