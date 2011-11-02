<?php
/*
 * Copyright (c) 2011 
 * Kirill chEbba Cheunin <iam@chebba.org>
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.
 */

namespace Che\LogStock\Loader;

use Che\LogStock\Loader\Container\IdFormatter;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * ContainerLoader uses container for finding loggers
 * 
 * @author Kirill chEbba Chebunin <iam@chebba.org>
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */ 
class ContainerLoader implements LoggerLoader
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var IdFormatter
     */
    private $idFormatter;

    /**
     * Constructor
     *
     * @param ContainerInterface $container   Container
     * @param IdFormatter|null   $idFormatter Optional formatter for id converting
     */
    public function __construct(ContainerInterface $container, IdFormatter $idFormatter = null)
    {
        $this->container = $container;
        $this->idFormatter = $idFormatter;
    }

    /**
     * Get container
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Get formatter
     *
     * @return IdFormatter
     */
    public function getIdFormatter()
    {
        return $this->idFormatter;
    }

    public function load($name)
    {
        $id = $this->idFormatter ? $this->idFormatter->formatId($name) : $name;
        return $this->container->get($id, ContainerInterface::NULL_ON_INVALID_REFERENCE);
    }
}
