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
 * Adapter for system logging (through error_log)
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
class SystemLoggerAdapter implements LoggerAdapter
{
    public function log($level, $message, array $context = array())
    {
        $levelName = Logger::getLevelName($level);
        if (!$levelName) {
            throw new \InvalidArgumentException("Unknown level '$level'");
        }

        $message = sprintf('[%s] %s | %s', $levelName, $message, json_encode($context));
        error_log($message);
    }
}
