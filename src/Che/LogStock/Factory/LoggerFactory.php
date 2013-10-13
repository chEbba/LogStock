<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Factory;

use Che\LogStock\Adapter\Logger;

/**
 * Factory for named loggers
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
interface LoggerFactory
{
    /**
     * @param string $name
     *
     * @return Logger
     */
    public function getLogger($name);
}
