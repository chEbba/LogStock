<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Factory;

use Che\LogStock\Adapter\LogAdapter;
use Che\LogStock\Adapter\Logger;
use Che\LogStock\Loader\LogAdapterLoader;

/**
 * Loads adapters through loader and returns loggers
 * If adapter is not found fallbackAdapter is used
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class AdapterLoaderFactory implements LoggerFactory
{
    private $loader;
    private $fallbackAdapter;

    public function __construct(LogAdapterLoader $loader, LogAdapter $fallbackAdapter)
    {
        $this->loader = $loader;
        $this->fallbackAdapter = $fallbackAdapter;
    }

    /**
     * {@inheritDoc}
     */
    public function getLogger($name)
    {
        return new Logger($this->loader->load($name) ?: $this->fallbackAdapter, $name);
    }
}