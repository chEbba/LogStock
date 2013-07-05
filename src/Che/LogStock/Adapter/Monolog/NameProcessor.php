<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Adapter\Monolog;

use Che\LogStock\Adapter\PsrAdapter;

/**
 * Monolog Processor for Logger name. It moves name to extra, which can be used in string templates
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class NameProcessor
{
    /**
     * Move name from context to extra
     *
     * @param array $record
     *
     * @return array
     */
    public function __invoke(array $record)
    {
        if (!isset($record['context'][PsrAdapter::CONTEXT_NAME_KEY])) {
            return $record;
        }

        $record['extra'][PsrAdapter::CONTEXT_NAME_KEY] = $record['context'][PsrAdapter::CONTEXT_NAME_KEY];
        unset($record['context'][PsrAdapter::CONTEXT_NAME_KEY]);

        return $record;
    }
}
