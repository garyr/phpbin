<?php

namespace Phpbin\Extension;

use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Route implements ExtensionInterface
{
    public function load(array $config, ContainerBuilder $container)
    {

    }

    public function getNamespace()
    {

    }

    public function getXsdValidationBasePath()
    {

    }

    public function getAlias()
    {
        return "routes";

    }
}