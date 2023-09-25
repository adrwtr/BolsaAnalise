<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use DI\ContainerBuilder;
use Slim\Factory\ServerRequestCreatorFactory;

use Akuma\BolsaAnalise\Controller\LeitorFundamentus;

require __DIR__ . '/../vendor/autoload.php';


$app = AppFactory::create();

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world!");
    return $response;
});


$app->group('/reader', function (Group $group) {
    $group->get(
        '/fundamentus',
        [LeitorFundamentus::class, 'action']
    );
});


$app->run();