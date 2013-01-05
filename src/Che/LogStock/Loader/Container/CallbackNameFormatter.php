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
 * Service name formatting with callback
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
class CallbackNameFormatter implements ServiceNameFormatter
{
    /**
     * @var callback
     */
    private $callback;

    /**
     * Constructor
     *
     * @param callback $callback Formatter callback. Signature: string function(string $name);
     */
    public function __construct($callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('Callback is not callable');
        }
        $this->callback = $callback;
    }

    /**
     * Get callback
     *
     * @return callback
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * {@inheritDoc}
     */
    public function formatServiceName($name)
    {
        return call_user_func($this->callback, $name);
    }
}
