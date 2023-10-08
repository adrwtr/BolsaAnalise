<?php
namespace Akuma\BolsaAnalise\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

use Psr\Container\ContainerInterface;

use Akuma\BolsaAnalise\Service\LeitorUrl;
// use Akuma\BolsaAnalise\Service\UsuarioService;
use Akuma\BolsaAnalise\Service\AcaoService;

class LeitorFundamentus {

    private $objAcaoService;

    public function __construct(AcaoService $objAcaoService)
    {
        $this->objAcaoService = $objAcaoService;
    }


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

        $arrMetaDado = $this->getArrMetaDados();

        foreach($tableElement as $id => $tableRow) {
            $string_valor_atual = $tableRow->nodeValue;
            $string_valor_atual = $this->limparStringMetadado($string_valor_atual);

            if (in_array($string_valor_atual, $arrMetaDado)) {
                $string_valor_desejado = $tableElement[$id+1]->nodeValue;
                $string_valor_desejado = $this->limparStringValor($string_valor_desejado);

                $arrValores[$string_valor_atual] = $string_valor_desejado;
            }
        }

        $ds_papel = $arrValores['Papel'];
        $ds_tipo_papel = $arrValores['Tipo'];
        $ds_nome_empresa = $arrValores['Empresa'];
        $ds_setor = $arrValores['Setor'];
        $ds_subsetor = $arrValores['Subsetor'];

        $enti = $this->objAcaoService->inserirAcao([
            'ds_papel' => $ds_papel,
            'ds_tipo_papel' => $ds_tipo_papel,
            'ds_nome_empresa' => $ds_nome_empresa,
            'ds_setor' => $ds_setor,
            'ds_subsetor' => $ds_subsetor
        ]);
        dump($enti);
        die();

        die();
        $response->getBody()->write("teste of groups");
        return $response;
    }



    private function limparStringMetadado($string_valor_atual) : string
    {
        $string_valor_atual = str_replace("?", "", $string_valor_atual);
        $string_valor_atual = trim($string_valor_atual);

        return $string_valor_atual;
    }

    private function limparStringValor($string_valor_desejado) : string
    {
        $string_valor_desejado = preg_replace("/\r|\n/", "", $string_valor_desejado);
        $string_valor_desejado = trim(str_replace("\"","", $string_valor_desejado));
        $string_valor_desejado = ltrim($string_valor_desejado, "\n");

        return $string_valor_desejado;
    }

    private function getArrMetaDados()
    {
        return [
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
    }
}