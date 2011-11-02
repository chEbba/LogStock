<?php
/*
 * Copyright (c) 2011 
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Loader\Container;

/**
 * Description of IdFormatter
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
interface IdFormatter
{
    /**
     * Format id
     *
     * @param string $id Original id
     *
     * @return string Formatted id
     */
    public function formatId($id);
}
