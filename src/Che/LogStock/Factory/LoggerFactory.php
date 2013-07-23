<?php
/**
 * @LICENSE_TEXT
 */

namespace Che\LogStock\Factory;

/**
 * Class LoggerFactory
 *
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 */
interface LoggerFactory
{
    public function getLogger($name);
}