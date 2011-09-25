<?php
/*
 * License
 */

namespace Che\LogStock\Adapter;

/**
 * Description of LoggerAdapter
 *
 * @author Kirill chEbba Chebunin <iam at chebba.org>
 */
interface LoggerAdapter
{
    /**
     * Log message
     *
     * @param int    $level Log level one of the Logger::* constants
     * @param string $message Log message
     * @param array  $context An array of extra information
     */
    public function log($level, $message, array $context = array());
}
