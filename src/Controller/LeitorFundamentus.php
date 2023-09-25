<?php
namespace Akuma\BolsaAnalise\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class LeitorFundamentus {
    public function action(Request $request, Response $response, array $args) : Response
    {
        $response->getBody()->write("teste of groups");
        return $response;
    }
}