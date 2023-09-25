<?php
namespace Akuma\BolsaAnalise\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

use GuzzleHttp\Client;



class LeitorFundamentus {
    public function action(Request $request, Response $response, array $args) : Response
    {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://www.fundamentus.com.br',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);

        $response = $client->request('GET', '/detalhes.php?papel=VALE3');
        $body = $response->getBody();

         // Suppress libxml errors
        libxml_use_internal_errors(true);


        $document = new \DOMDocument();
        $document->loadHtml($body, LIBXML_NOWARNING | LIBXML_NOERROR);
        $tableElement = $document->getElementsByTagName("td");

        foreach($tableElement as $tableRow) {
            dump($tableRow->nodeValue);
            // and so on ..
            // do your processing of table rows and data here
        }
        die();
        $response->getBody()->write("teste of groups");
        return $response;
    }
}