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
 * Chain of ServiceNameFormatters.
 * Formatters are applied in direct order, while stored in stack
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
class ServiceNameFormatterChain implements ServiceNameFormatter
{
    /**
     * @var ServiceNameFormatter[]
     */
    private $formatterStack;

    /**
     * Constructor
     *
     * @param array $formatters
     */
    public function __construct(array $formatters = array())
    {
        $this->formatterStack = array();
        foreach ($formatters as $formatter) {
            $this->pushFormatter($formatter);
        }
    }

    /**
     * Push formatter
     *
     * @param ServiceNameFormatter $formatter
     *
     * @return ServiceNameFormatterChain Provides fluent interface
     */
    public function pushFormatter(ServiceNameFormatter $formatter)
    {
        array_push($this->formatterStack, $formatter);
        return $this;
    }

    /**
     * Pop formatter
     *
     * @param ServiceNameFormatter $formatter
     *
     * @return ServiceNameFormatter Popped formatter
     */
    public function popFormatter(ServiceNameFormatter $formatter)
    {
        return array_pop($this->formatterStack);
    }

    public function formatServiceName($name)
    {
        foreach ($this->formatterStack as $formatter) {
            $name = $formatter->formatServiceName($name);
        }

        return $name;
    }
}
