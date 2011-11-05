<?php
/*
 * Copyright (c) 2011 
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Loader;

use Che\LogStock\Loader\Container\ServiceLocator;
use Che\LogStock\Loader\Container\ServiceNameFormatter;

/**
 * ServiceLocatorLoader uses ServiceLocator for finding loggers
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
class ServiceLocatorLoader implements LoggerLoader
{
    /**
     * @var ServiceLocator
     */
    private $locator;
    /**
     * @var ServiceNameFormatter
     */
    private $formatter;

    /**
     * Constructor
     *
     * @param ServiceLocator              $locator   ServiceLocator
     * @param ServiceNameFormatter|null   $formatter Optional formatter for name converting
     */
    public function __construct(ServiceLocator $locator, ServiceNameFormatter $formatter = null)
    {
        $this->locator = $locator;
        $this->formatter = $formatter;
    }

    /**
     * Get ServiceLocator
     *
     * @return ServiceLocator
     */
    public function getLocator()
    {
        return $this->locator;
    }

    /**
     * Get formatter
     *
     * @return ServiceNameFormatter
     */
    public function getFormatter()
    {
        return $this->formatter;
    }

    public function load($name)
    {
        $name = $this->formatter ? $this->formatter->formatServiceName($name) : $name;
        return $this->locator->getService($name);
    }
}
