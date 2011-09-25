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
 * Description of HierarchicalLoggerLoader
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
class HierarchicalLoggerLoader implements LoggerLoader
{
    private $loader;

    private $separator;

    public function __construct(LoggerLoader $loader, $separator = '\\')
    {
        $this->loader = $loader;
        $this->separator = $separator;
    }

    public function load($name)
    {
        while ($name) {
            $logger = $this->loader->load($name);
            if ($logger) {
                return $logger;
            }

            $name = $this->getParentName($name);
        }

        return null;
    }

    public function getParentName($name)
    {
        return (string) substr($name, 0, strrpos($name, $this->separator));
    }
}
