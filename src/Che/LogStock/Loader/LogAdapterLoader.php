<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Loader;

use Che\LogStock\Adapter\LogAdapter;

/**
 * Logger loader finds logger adapters by name
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
interface LogAdapterLoader
{
    /**
     * Load log adapter by name
     *
     * @param string $name Logger name
     *
     * @return LogAdapter|null Log adapter object or null if no adapter found
     */
    public function loadAdapter($name);
}
