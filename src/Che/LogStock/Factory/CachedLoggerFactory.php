<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Factory;

/**
 * Proxy logger factory caches created named loggers in memory
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class CachedLoggerFactory implements LoggerFactory
{
    private $loggers = [];
    private $nestedFactory;

    public function __construct(LoggerFactory $nestedFactory)
    {
        $this->nestedFactory = $nestedFactory;
    }

    /**
     * Get nested logger factory
     *
     * @return LoggerFactory
     */
    public function getNestedFactory()
    {
        return $this->nestedFactory;
    }

    /**
     * Clear all cached loggers
     */
    public function release()
    {
        $this->loggers = [];
    }

    /**
     * {@inheritDoc}
     */
    public function getLogger($name)
    {
        if (!isset($this->loggers[$name])) {
            $this->loggers[$name] = $this->nestedFactory->getLogger($name);
        }

        return $this->loggers[$name];
    }
}