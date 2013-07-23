<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Adapter;

use Psr\Log\AbstractLogger;

/**
 * Logger implementation through adapter
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class Logger extends AbstractLogger
{
    /**
     * @var LogAdapter
     */
    private $adapter;
    /**
     * @var string
     */
    private $name;

    /**
     * Constructor
     *
     * @param LogAdapter $adapter Internal logger adapter
     * @param string        $name    Logger name
     */
    public function __construct(LogAdapter $adapter, $name)
    {
        $this->adapter = $adapter;
        $this->name = $name;
    }

    /**
     * Get adapter for this logger
     *
     * @return LogAdapter
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
