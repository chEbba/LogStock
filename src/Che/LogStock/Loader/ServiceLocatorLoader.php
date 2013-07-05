<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Loader;

use Che\LogStock\Adapter\LoggerAdapter;
use Che\ServiceLocator\ServiceLocator;

/**
 * Loader which uses ServiceLocator for finding loggers
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
class ServiceLocatorLoader implements LoggerLoader
{
    /**
     * @var ServiceLocator
     */
    private $locator;

    /**
     * Constructor
     *
     * @param ServiceLocator $locator Locator instance
     */
    public function __construct(ServiceLocator $locator)
    {
        $this->locator = $locator;
    }

    /**
     * {@inheritDoc}
     */
    public function load($name)
    {
        $service = $this->locator->getService($name);

        return ($service instanceof LoggerAdapter) ? $service : null;
    }
}
