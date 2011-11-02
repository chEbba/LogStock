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
 * Simple id formatter for replacing one separator to another
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
class SeparatorIdFormatter implements IdFormatter
{
    /**
     * @var string
     */
    private $from;
    /**
     * @var string
     */
    private $to;

    /**
     * Constructor
     *
     * @param string $from Separator for replace
     * @param string $to   Replacement separator
     */
    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }


    public function formatId($id)
    {
        return str_replace($this->from, $this->to, $id);
    }
}
