<?php
namespace Akuma\BolsaAnalise\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Akuma\BolsaAnalise\Service\LeitorUrl;
use Akuma\BolsaAnalise\Service\AcaoService;
use Akuma\BolsaAnalise\Service\AcaoCotacaoService;

class LeitorPrecoAcao {

    private LeitorUrl $objLeitorUrl;
    private $objAcaoService;
    private $objAcaoCotacaoService;
    public function __construct(
        AcaoService $objAcaoService,
        AcaoCotacaoService $objAcaoCotacaoService,
        LeitorUrl $objLeitorUrl,
    ) {
        $this->objAcaoService = $objAcaoService;
        $this->objAcaoCotacaoService = $objAcaoCotacaoService;

        $this->objLeitorUrl = $objLeitorUrl;
    }


    public function lerPrecos(Request $request, Response $response, array $args) : Response
    {
        $arrAcoes = $this->objAcaoService->getArrAcoes();

        foreach($arrAcoes as $ds_papel) {
            $ds_body = $this->objLeitorUrl->lerUrl(
                'https://brapi.dev/api/quote/'
                    . $ds_papel
                    .'?token=' . $_ENV['COTACAO_API_TOKEN']
            );

            // $ds_body = $this->objLeitorUrl->fakeLerUrlAcoes();

            $objInfo = json_decode($ds_body);
            $objValores = $objInfo->results[0];

            $ds_papel = $objValores->symbol;
            $vl_media_200_dias = $objValores->twoHundredDayAverage;
            $vl_preco_dia = $objValores->regularMarketPrice;
            $vl_volume_dia = $objValores->regularMarketVolume;
            $vl_media_volume_90_dias = $objValores->averageDailyVolume3Month;
            $vl_media_volume_10_dias = $objValores->averageDailyVolume10Day;

            $objAcao = $this->objAcaoService->procurarAcao(
                $ds_papel
            );

            // insere a acao
            $objAcaoCotacao = $this->objAcaoCotacaoService->inserirAcaoCotacao(
                $objAcao,
                [
                    'ds_papel' => $ds_papel,
                    'vl_media_200_dias' => $vl_media_200_dias,
                    'vl_preco_dia' => $vl_preco_dia,
                    'vl_volume_dia' => $vl_volume_dia,
                    'vl_media_volume_90_dias' => $vl_media_volume_90_dias,
                    'vl_media_volume_10_dias' => $vl_media_volume_10_dias
                ]
            );
        }

        $response->getBody()->write("Leitura completa");

        return $response;
    }
}