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
 * Loader wrapper with hierarchy support.
 * Uses separator to detect parent logger for fallback.
 *
 * For example loader with "\" separator will try to load
 * loggers with "foo\bar", "foo" and "" names as parents for missed "foo\bar\baz" logger.
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */ 
class HierarchicalLogLoader implements LogAdapterLoader
{
    /**
     * @var LogAdapterLoader
     */
    private $nestedLoader;
    /**
     * @var string
     */
    private $separator;

    /**
     * Constructor
     *
     * @param LogAdapterLoader $nestedLoader Nested loader
     * @param string           $separator    Hierarchy separator
     */
    public function __construct(LogAdapterLoader $nestedLoader, $separator = '\\')
    {
        $this->nestedLoader = $nestedLoader;
        $this->separator = $separator;
    }

    /**
     * Get nested loader
     *
     * @return LogAdapterLoader
     */
    public function getNestedLoader()
    {
        return $this->nestedLoader;
    }

    /**
     * Get separator
     *
     * @return string
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     * {@inheritDoc}
     */
    public function load($name)
    {
        while ($name) {
            $logger = $this->nestedLoader->load($name);
            if ($logger) {
                return $logger;
            }

            $name = $this->getParentName($name);
        }

        // Try to load loader with empty name ""
        return $this->nestedLoader->load($name);
    }

    /**
     * Get name for parent loader
     *
     * @param string $name Child logger name
     *
     * @return string Parent name, an empty string is the top level parent
     */
    protected function getParentName($name)
    {
        return (string) substr($name, 0, (int) strrpos($name, $this->separator));
    }
}
