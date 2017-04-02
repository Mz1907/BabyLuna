<?php

namespace AdminBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/*
 * Ce fichier permet d'enregistrer dans le container de services les services contenu dans services.yml
 */
class AdminExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        // ...
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        // ...
        $loader->load('admin.yml');
        $loader->load('services.yml');
    }
}