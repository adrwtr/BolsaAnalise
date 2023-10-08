<?php
namespace Akuma\BolsaAnalise\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

use Psr\Container\ContainerInterface;

class Index {

    public function indexAction(
        Request $request,
        Response $response,
        array $args
    ) : Response {
        $response->getBody()->write("hello world");
        return $response;
    }
}