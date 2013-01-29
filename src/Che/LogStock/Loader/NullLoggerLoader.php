<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Loader;

/**
 * Logger loader which always returns null
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
class NullLoggerLoader implements LoggerLoader
{
    /**
     * {@inheritDoc}
     */
    public function load($name)
    {
        return null;
    }
}
