<?php
/*
 * Copyright (c)
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Loader\Container;

use Che\LogStock\Logger;

/**
 * Description of MemoryServiceLocator
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
class MemoryServiceLocator implements ServiceLocator
{
    /**
     * @var array
     */
    private $loggers = array();

    /**
     * Set logger service
     *
     * @param string $name   Service name
     * @param object $logger Logger instance
     *
     * @return MemoryServiceLocator Provides fluent interface
     */
    public function setService($name, $logger)
    {
        $this->loggers[$name] = $logger;

        return $this;
    }

    /**
     * @param string $name Service name
     *
     * @return Logger|null Removed logger or null if logger is not exists
     */
    public function removeService($name)
    {
        if (!isset($this->loggers[$name])) {
             return null;
        }

        $logger = $this->loggers[$name];
        unset($this->loggers[$name]);

        return $logger;
    }

    public function getService($name)
    {
        return isset($this->loggers[$name]) ? $this->loggers[$name] : null;
    }

}
