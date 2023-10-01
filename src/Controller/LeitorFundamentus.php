<?php
namespace Akuma\BolsaAnalise\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

use Akuma\BolsaAnalise\Service\LeitorUrl;

class LeitorFundamentus {
    public function action(Request $request, Response $response, array $args) : Response
    {
        $objLeitorUrl = new LeitorUrl();
        $body = $objLeitorUrl->fakeLerUrl();
        $body = base64_decode($body);

         // Suppress libxml errors
        libxml_use_internal_errors(true);

        $document = new \DOMDocument();
        $document->loadHtml($body, LIBXML_NOWARNING | LIBXML_NOERROR);
        $tableElement = $document->getElementsByTagName("td");

        $arrValores = [];

        $arrMetaDado = [
            'Papel'
            , 'Cotação'
            , 'Tipo'
            , 'Data últ cot'
            , 'Empresa'
            , 'Setor'
            , 'Subsetor'
            , 'Valor de mercado'
            , 'Últ balanço processado'
            , 'Valor da firma'
            , 'Nro. Ações'
            , 'P/L'
            , 'LPA'
            , 'P/VP'
            , 'VPA'
            , 'P/EBIT'
            , 'Marg. Bruta'
            , 'PSR'
            , 'Marg. EBIT'
            , 'P/Ativos'
            , 'Marg. Líquida'
            , 'P/Cap. Giro'
            , 'EBIT / Ativo'
            , 'P/Ativ Circ Liq'
            , 'ROIC'
            , 'Div. Yield'
            , 'ROE'
            , 'EV / EBITDA'
            , 'Liquidez Corr'
            , 'EV / EBIT'
            , 'Div Br/ Patrim'
            , 'Cres. Rec (5a)'
            , 'Giro Ativos'
            , 'Ativo'
            , 'Dív. Bruta'
            , 'Disponibilidades'
            , 'Dív. Líquida'
            , 'Ativo Circulante'
            , 'Patrim. Líq'
            , 'Receita Líquida'
            , 'EBIT'
            , 'Lucro Líquido'
        ];

        foreach($tableElement as $id => $tableRow) {
            $string_valor_atual = $tableRow->nodeValue;
            $string_valor_atual = str_replace("?", "", $string_valor_atual);
            $string_valor_atual = trim($string_valor_atual);

            if (in_array($string_valor_atual, $arrMetaDado)) {
                $string_valor_desejado = $tableElement[$id+1]->nodeValue;

                $string_valor_desejado = preg_replace("/\r|\n/", "", $string_valor_desejado);
                $string_valor_desejado = trim(str_replace("\"","", $string_valor_desejado));
                $string_valor_desejado = ltrim($string_valor_desejado, "\n");

                $arrValores[$string_valor_atual] = $string_valor_desejado;
            }
        }
        var_dump($arrValores);

        die();
        $response->getBody()->write("teste of groups");
        return $response;
    }
}