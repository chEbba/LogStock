LogStock - Static Logger Factory for PHP 5.3
============================================

Logging functionality is required in all classes, so it is one of situations where static code is a good choice.
Now you can create more logs with your preferred logging library.

Installation
------------

You can just clone the repository (or download versions by tags) and include the library with PSR-0 autoloader.

Or use the [composer packages](http://packagist.org/packages/che/log-stock "che/log-stock").


Usage
-----

    namespace Acme\Foo;

    use Che\LogStock\LoggerFactory;

    use Che\LogStock\Adapter\Monolog\MonologAdapter;

    use Che\LogStock\Loader\HierarchicalLoggerLoader;
    use Che\LogStock\Loader\ServiceLocatorLoader;
    use Che\LogStock\Loader\Container\MemoryServiceLocator;

    /* Create Monolog $logger */
    //...

    $serviceLocator = new MemoryServiceLocator();
    $serviceLocator->setService('Acme\Foo', new MonologAdapter($logger));

    LoggerFactory::initLoader(new ServiceLocatorLoader($serviceLocator));

    class Bar
    {
        public function doSomething($param)
        {
            // This message will be hanled by configured monolog instance
            LoggerFactory::getLogger(__CLASS__)->info('Do something.', array('param' => $param));
            //...
        }
    }

Concepts
--------

Logger is a wrapper around adapters for 3rd party logging libraries.

Logger instances depend on logger names. Factory tries to find an adapter from a loader for requested name. If nothing was found, logger with a root adapter is returned. So LoggerFactory ALWAYS return an instance of logger.


Adapters
--------

*   _SystemLoggerAdapter_ - wrapper around [error_log](http://www.php.net/manual/en/function.error-log.php "error_log") function with $message_type = 0.
    Log level limit can be configured (default is WARN). The default root adapter.
*   _MonologAdapter_ - adapter for [Monolog library](https://github.com/Seldaek/monolog "Monolog"). Bundled with NameProcessor which stores logger name in extra.log_stock.name.
*   _ZendLogAdapter_ - adapter for Zend_Log [ZF2](https://github.com/zendframework/zf2 "ZF2") version is comming soon.

Loaders
-------

*   _NullLoggerLoader_ - default loader (if no loader was initialized) which loads nothing (so all loggers will use root adapter).
*   _ServiceLocatorLoader_ - uses ServiceLocator to find service. Simple MemoryServiceLocator is bundled.
*   _HierarchicalLoggerLoader_ - the main feature of LogStock. Wrapper around another loader to support hierarchy in names.
    The default usage is using class names as logger names, so this loader will try to find an adapter by class, than by namespace hiearchy.

Example:
Wrapped loader returns _Adapter1_ for _Acme_ and _Adapter2_ for _Acme\\Foo_.
HierarchicalLoggerLoader will return _Adapter1_ for _Acme\\Baz_ or _Acme\\Baz\\Bar_ and _Adapter2_ for _Acme\\Foo\\Bar_.

Integration
-----------

* Symfony2 - [LogStockBundle](https://github.com/chEbba/LogStockBundle).

Author
------

Kirill chEbba Chebunin <iam@chebba.org>.

License
-------

LogStock is subject to the MIT license that is bundled with this package in the file LICENSE.