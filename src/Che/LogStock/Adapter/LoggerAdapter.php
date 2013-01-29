<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Adapter;

/**
 * Logger adapter. Common interface for adapters of different logger libraries
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
interface LoggerAdapter
{
    /**
     * Log message
     *
     * @param string $name Logger name
     * @param int    $level Log level one of the Logger::* constants
     * @param string $message Log message
     * @param array  $context An array of extra information
     */
    public function log($name, $level, $message, array $context = array());
}
