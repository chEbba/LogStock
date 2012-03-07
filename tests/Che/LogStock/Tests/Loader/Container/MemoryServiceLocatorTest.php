<?php
/*
 * Copyright (c)
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Tests\Loader\Container;

use Che\LogStock\Loader\Container\MemoryServiceLocator;
use PHPUnit_Framework_TestCase as TestCase;

/**
 * Description of MemoryServiceLocatorTest
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class MemoryServiceLocatorTest extends TestCase
{
    /**
     * @var MemoryServiceLocator
     */
    private $locator;

    protected function setUp()
    {
        $this->locator = new MemoryServiceLocator();
    }

    /**
     * @test getService returns previously set service
     */
    public function setGetRemoveService()
    {
        $service = new \stdClass();

        $this->locator->setService('service', $service);

        self::assertSame($service, $this->locator->getService('service'));
        self::assertSame($service, $this->locator->removeService('service'));
        self::assertNull($this->locator->getService('service'));
        self::assertNull($this->locator->removeService('service'));
    }
}
