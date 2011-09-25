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
 * Description of DefaultLoggerAdapter
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
class DefaultLoggerAdapter implements LoggerAdapter
{
    public function log($level, $message, array $context = array())
    {
        $levels = Logger::getLevels();
        if (!isset($levels[$level])) {
            throw new \InvalidArgumentException('Unknown level');
        }

        $message = sprintf('[%s] %s | %s', $levels[$level], $message, json_encode($context));
        error_log($message);
    }
}
