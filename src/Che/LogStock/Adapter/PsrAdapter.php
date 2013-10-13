<?php
/*
 * Copyright (c)
 * Kirill chEbba Chebunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Adapter;

use Psr\Log\LoggerInterface;

/**
 * LoggerAdapter for PSR-3 loggers
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */
class PsrAdapter implements LogAdapter
{
    const CONTEXT_NAME_KEY = '_logger';

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritDoc}
     */
    public function log(LogRecord $record)
    {
        $context = $record->getContext();
        $context[self::CONTEXT_NAME_KEY] = $record->getLogger();

        $this->logger->log($record->getLevel(), $record->getMessage(), $context);
    }
}