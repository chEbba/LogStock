LogStock - Static Logger Manager [![Build Status](https://travis-ci.org/chEbba/LogStock.png?branch=master)](https://travis-ci.org/chEbba/LogStock)
============================================

Logging functionality is required in all classes, so it is one of situations where static code is a good choice.
Now you can create more logs with your preferred logging library.

Installation
------------

[Composer package](http://packagist.org/packages/che/log-stock "che/log-stock") is available.

Or just clone the repository (or download versions by tags) and include the library with PSR-0 autoloader.

Usage
-----

    namespace Acme\Foo;

    use Che\LogStock\LoggerManager;

    class Bar
    {
        private $logger;

        public function __construct()
        {
            $this->logger = LoggerManager::getLogger(__CLASS__);
        }

        public function doSomething($param)
        {
            $this->logger->info('Do something.', array('param' => $param));
            //...
        }
    }

Integration
-----------

* Symfony2 - [LogStockBundle](https://github.com/chEbba/LogStockBundle).

Author
------

Kirill chEbba Chebunin <iam@chebba.org>.

License
-------

LogStock is subject to the MIT license that is bundled with this package in the file LICENSE.
