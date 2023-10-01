<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Slim\Factory\ServerRequestCreatorFactory;

use Akuma\BolsaAnalise\Controller\LeitorFundamentus;

require __DIR__ . '/../vendor/autoload.php';


// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

// Set up DI
$fndi = require __DIR__ . '/../src/Config/di.php';
$fndi($containerBuilder, false);

$doctrine = require_once __DIR__ . '/../src/Config/doctrine-bootstrap.php';
$doctrine($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);


// $container->set('LeitorFundamentus', function (ContainerInterface $container) {
//     // retrieve the 'view' from the container
//     // $view = $container->get('IUsuarioRepository');

//     return new LeitorFundamentus($container);
// });


$app->group('/reader', function (Group $group) use ($app) {
    $group->get(
        '/fundamentus',
        [LeitorFundamentus::class, 'action']
    );

    $group->get(
        '/usuario',
        [LeitorFundamentus::class, 'usuario'],
        $app->getContainer()
    );
});


$app->run();