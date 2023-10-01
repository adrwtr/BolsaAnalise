<?php
// bootstrap.php

use Doctrine\Common\Cache\Psr6\DoctrineProvider;
use Doctrine\ORM\EntityManager;
use Doctrine\annotations;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    $settings = require __DIR__ . '/settings.php';
    $settings = $settings["settings"];


    // Use the ArrayAdapter or the FilesystemAdapter depending on the value of the 'dev_mode' setting
    // You can substitute the FilesystemAdapter for any other cache you prefer from the symfony/cache library
    $cache = $settings['doctrine']['dev_mode'] ?
        DoctrineProvider::wrap(new ArrayAdapter()) :
        DoctrineProvider::wrap(new FilesystemAdapter($settings['doctrine']['cache_dir']));

    $config = Setup::createAnnotationMetadataConfiguration(
        $settings['doctrine']['metadata_dirs'],
        $settings['doctrine']['dev_mode'],
        null,
        $cache,
        false
    );

    $containerBuilder->addDefinitions([
        // lista de services
        EntityManager::class => EntityManager::create($settings['doctrine']['connection'], $config)
    ]);
};