<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock;

use Che\LogStock\Adapter\LoggerAdapter;
use Che\LogStock\Adapter\LogRecord;
use Psr\Log\AbstractLogger;

/**
 * Logger provides extended functionality around LoggerAdapter
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class Logger extends AbstractLogger
{
    /**
     * @var LoggerAdapter
     */
    private $adapter;
    /**
     * @var string
     */
    private $name;

    /**
     * Constructor
     *
     * @param LoggerAdapter $adapter Internal logger adapter
     * @param string        $name    Logger name
     */
    public function __construct(LoggerAdapter $adapter, $name)
    {
        $this->adapter = $adapter;
        $this->name = $name;
    }

    /**
     * Get adapter for this logger
     *
     * @return LoggerAdapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function log($level, $message, array $context = array())
    {
        $this->adapter->log(new LogRecord($this->name, $level, $message, $context));
    }
}
