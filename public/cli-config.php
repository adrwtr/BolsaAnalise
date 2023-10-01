<?php

// cli-config.php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

use Slim\Factory\AppFactory;
use DI\ContainerBuilder;
use Slim\Factory\ServerRequestCreatorFactory;

require __DIR__ . '/../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

$container = require_once __DIR__ . '/../src/Config/doctrine-bootstrap.php';
$container($containerBuilder);

$container = $containerBuilder->build();


return ConsoleRunner::createHelperSet($container->get(EntityManager::class));