<?php
/*
 * Copyright (c) 2011 
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

/**
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

spl_autoload_register(function($name) {
    if (strpos($name, 'Che\LogStock') !== 0) {
        return false;
    }

    $fileName = __DIR__ . '/../src/' . str_replace('\\', '/', $name) . '.php';
    if (!file_exists($fileName)) {
        return false;
    }

    require_once $fileName;
    return true;
});
