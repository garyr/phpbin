<?php

namespace Phpbin\Application;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

trait ApplicationTrait
{
    /**
     * @var ContainerBuilder
     */
    protected $container;

    protected $loader;

    public function initContainer()
    {
        // Set up container
        $root = realpath(__DIR__ . '/../../../');

        $this->container = new ContainerBuilder();
        $this->loader = new YamlFileLoader($this->container, new FileLocator($root . '/config/'));
        $this->loader->load('services/services.yml');

        $this->container->setParameter('cache_dir', $root . '/cache/');

        $this->container->setParameter('app_root_dir', $root);
        $this->container->setParameter('www_root_dir', $root . '/web');
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer(ContainerBuilder $container)
    {
        $this->container = $container;
    }

    public function getLoader()
    {
        return $this->loader;
    }
}