<?php
/*
 * Copyright (c)
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Loader\Container;

/**
 * Dynamic Service Locator interface
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
interface ServiceLocator 
{
    /**
     * Get service by name
     *
     * @param string $name Service name
     *
     * @return object|null Service for this name, or null if service is not exist
     */
    public function getService($name);
}
