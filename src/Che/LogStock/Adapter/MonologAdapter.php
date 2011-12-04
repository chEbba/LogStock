<?php
/*
 * Copyright (c) 2011 
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Adapter;

use Che\LogStock\Logger;

/**
 * Logger adapter for Monolog
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
class MonologAdapter implements LoggerAdapter
{
    /**
     * @var \Monolog\Logger
     */
    private $logger;

    /**
     * Constructor
     *
     * @param \Monolog\Logger $logger Monolog logger instance
     */
    public function __construct(\Monolog\Logger $logger)
    {
        $this->logger = $logger;
    }

    public function log($level, $message, array $context = array())
    {
        // Use ZF compatible methods to rely on Monolog internal level mapping
        $method = self::getLevelMethod($level);
        if (!$method) {
            throw new \InvalidArgumentException("Unknown level '$level'");
        }
        call_user_func(array($this->logger, $method), $message, $context);
    }

    private static function getLevelMethod($level)
    {
        $levelName = Logger::getLevelName($level);
        return $levelName ? strtolower($levelName) : null;
    }
}
