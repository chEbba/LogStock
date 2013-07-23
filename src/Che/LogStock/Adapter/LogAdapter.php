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
interface LogAdapter
{
    /**
     * Log message
     *
     * @param LogRecord $record
     */
    public function log(LogRecord $record);
}
