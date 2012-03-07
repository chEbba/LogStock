<?php
/*
 * Copyright (c)
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Loader;

/**
 * Logger loader wrapper with hierarchy support.
 * Uses separator to detect parent logger for fallback.
 *
 * For example loader with '\' separator will try to load
 * logger with foo\bar name as a parent of missed foo\bar\baz logger.
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
class HierarchicalLoggerLoader implements LoggerLoader
{
    /**
     * @var LoggerLoader
     */
    private $loader;
    /**
     * @var string
     */
    private $separator;

    /**
     * Constructor
     *
     * @param LoggerLoader $loader    Wrapped loader
     * @param string       $separator Hierarchy separator
     */
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

    /**
     * Get name for parent loader
     *
     * @param string $name Child logger name
     *
     * @return string Parent name, an empty string means there is no parent for this name
     */
    protected function getParentName($name)
    {
        return (string) substr($name, 0, strrpos($name, $this->separator));
    }
}
