<?php
namespace Akuma\BolsaAnalise\Service\Http;

use GuzzleHttp\Client;

use Akuma\BolsaAnalise\Service\Http\IHttpClient;

class GuzzleClient implements IHttpClient
{
    public function readBodyFromUrl(
        string $ds_url
    ): string {
        $objClient = new Client();

        $objResponse = $objClient->request(
            'GET',
            $ds_url
        );

        $ds_body = $objResponse->getBody();

        return $ds_body;
    }
}