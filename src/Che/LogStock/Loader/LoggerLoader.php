<?php
/*
 * Copyright (c) 2011 
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Loader;

/**
 * Description of LoggerLoader
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
interface LoggerLoader
{
    /**
     * Load logger by name
     *
     * @param string $name
     *
     * @return Logger|null Logger by name or null if no logger found
     */
    public function load($name);
}
