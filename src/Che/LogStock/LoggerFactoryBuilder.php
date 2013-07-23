<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock;

use Che\LogStock\Adapter\LogAdapter;
use Che\LogStock\Adapter\SystemLogAdapter;
use Che\LogStock\Factory\AdapterLoaderFactory;
use Che\LogStock\Factory\CachedLoggerFactory;
use Che\LogStock\Factory\LoggerFactory;
use Che\LogStock\Loader\HierarchicalLogLoader;
use Che\LogStock\Loader\LogAdapterLoader;
use Che\LogStock\Loader\NullLoggerLoader;
use Che\LogStock\Loader\ServiceLocatorLoader;
use Che\ServiceLocator\MemoryServiceLocator;
use Che\ServiceLocator\ServiceLocator;

/**
 * Helper builder for default factories
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class LoggerFactoryBuilder
{
    protected $cache = true;
    protected $hierarchy = true;
    protected $factory;
    protected $loader;
    protected $fallbackAdapter;
    protected $serviceLocator;

    /**
     * Disable logger caching
     * By default all created loggers will be stored in memory
     *
     * @return $this Provides the fluent interface
     *
     * @see CachedLoggerFactory
     */
    public function disableCache()
    {
        $this->cache = false;

        return $this;
    }

    /**
     * Disable logger hierarchy support
     *
     * @return $this Provides the fluent interface
     *
     * @see HierarchicalLogLoader
     */
    public function disableHierarchy()
    {
        $this->hierarchy = false;

        return $this;
    }

    /**
     * Set custom factory
     * Cache support will be still effective
     *
     * @param LoggerFactory $factory
     *
     * @return $this Provides the fluent interface
     */
    public function factory(LoggerFactory $factory)
    {
        $this->factory = $factory;

        return $this;
    }

    /**
     * Set custom adapter loader for adapter factory
     * If none provided, null or service locator
     *
     * @param LogAdapterLoader $loader
     *
     * @return $this
     *
     * @see AdapterLoaderFactory
     * @see serviceLocator()
     */
    public function loader(LogAdapterLoader $loader)
    {
        $this->loader = $loader;

        return $this;
    }

    /**
     * Set custom fallbackAdapter for adapter factory
     * Default system adapter is used if none set
     *
     * @param LogAdapter $adapter
     *
     * @return $this
     *
     * @see AdapterLoaderFactory
     * @see SystemLogAdapter
     */
    public function fallbackAdapter(LogAdapter $adapter)
    {
        $this->fallbackAdapter = $adapter;

        return $this;
    }

    /**
     * Set service locator for loader
     * If provided service locator loader will be used, custom or null otherwise
     *
     * @param ServiceLocator $serviceLocator
     *
     * @return $this
     *
     * @see ServiceLocatorLoader
     * @see NullLoggerLoader
     * @see loader()
     */
    public function serviceLocator(ServiceLocator $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;

        return $this;
    }

    /**
     * Build factory
     *
     * @return LoggerFactory
     */
    public function build()
    {
        if (!$this->factory) {
            $this->factory = $this->createDefaultFactory();
        }

        return $this->cache ? new CachedLoggerFactory($this->factory) : $this->factory;
    }

    /**
     * Build and register factory in LoggerManager
     *
     * @return LoggerFactory
     */
    public function register()
    {
        $factory = $this->build();
        LoggerManager::registerFactory($factory);

        return $factory;
    }

    /**
     * Create default adapter loader with optional hierarchy wrapper
     *
     * @return LoggerFactory
     *
     * @see disableHierarchy()
     * @see loader()
     * @see fallbackAdapter()
     */
    protected function createDefaultFactory()
    {
        $loader = $this->loader ? : $this->createDefaultLoader();
        if ($this->hierarchy) {
            $loader = new HierarchicalLogLoader($loader);
        }
        $rootAdapter = $this->fallbackAdapter ? : $this->createDefaultFallbackAdapter();

        return new AdapterLoaderFactory($loader, $rootAdapter);
    }

    /**
     * Create default service locator loader
     *
     * @return LogAdapterLoader
     *
     * @see serviceLocator()
     */
    protected function createDefaultLoader()
    {
        return new ServiceLocatorLoader($this->serviceLocator ?: $this->createDefaultServiceLocator());
    }

    /**
     * Create empty memory service locator
     *
     * @return ServiceLocator
     */
    protected function createDefaultServiceLocator()
    {
        return new MemoryServiceLocator();
    }

    /**
     * Create default system adapter
     *
     * @return LogAdapter
     */
    protected function createDefaultFallbackAdapter()
    {
        return new SystemLogAdapter();
    }
}