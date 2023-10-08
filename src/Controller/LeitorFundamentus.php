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
use Akuma\BolsaAnalise\Service\AcaoDadosFundamentalistaService;


class LeitorFundamentus {

    private $objAcaoService;
    private $objAcaoDadosFundamentalistaService;

    public function __construct(
        AcaoService $objAcaoService,
        AcaoDadosFundamentalistaService $objAcaoDadosFundamentalistaService
    ) {
        $this->objAcaoService = $objAcaoService;
        $this->objAcaoDadosFundamentalistaService = $objAcaoDadosFundamentalistaService;
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

        // insere a acao
        $objAcao = $this->objAcaoService->inserirAcao([
            'ds_papel' => $ds_papel,
            'ds_tipo_papel' => $ds_tipo_papel,
            'ds_nome_empresa' => $ds_nome_empresa,
            'ds_setor' => $ds_setor,
            'ds_subsetor' => $ds_subsetor
        ]);

        $dt_balanco = \DateTime::createFromFormat("d/m/Y", $arrValores['Últ balanço processado']);
        $vl_valor_mercado = $arrValores['Valor de mercado'];
        $vl_valor_firma = $arrValores['Valor da firma'];

        $nr_qtd_acoes = $arrValores['Nro. Ações'];
        $vl_ativo = $arrValores['Ativo'];
        $vl_div_bruta = $arrValores['Dív. Bruta'];
        $vl_disponibilidades = $arrValores['Disponibilidades'];
        $vl_div_liquida = $arrValores['Dív. Líquida'];
        $vl_ativo_circulante = $arrValores['Ativo Circulante'];
        $vl_patrimonio_liquido = $arrValores['Patrim. Líq'];
        $vl_receita_liquida = $arrValores['Receita Líquida'];
        $vl_ebit = $arrValores['EBIT'];
        $vl_lucro_liquido = $arrValores['Lucro Líquido'];

        $vl_p_l = $arrValores['P/L'];
        $vl_lpa = $arrValores['LPA'];
        $vl_p_vp = $arrValores['P/VP'];
        $vl_vpa = $arrValores['VPA'];
        $vl_p_ebit = $arrValores['P/EBIT'];
        $vl_margem_bruta = $arrValores['Marg. Bruta'];
        $vl_psr = $arrValores['PSR'];
        $vl_margem_ebit = $arrValores['Marg. EBIT'];
        $vl_p_ativos = $arrValores['P/Ativos'];
        $vl_margem_liquida = $arrValores['Marg. Líquida'];
        $vl_p_capital_giro = $arrValores['P/Cap. Giro'];
        $vl_ebit_ativo = $arrValores['EBIT / Ativo'];
        $vl_p_ativ_circ_liq = $arrValores['P/Ativ Circ Liq'];
        $vl_roic = $arrValores['ROIC'];
        $vl_roe = $arrValores['ROE'];
        $vl_ev_ebitda = $arrValores['EV / EBITDA'];
        $vl_ev_ebit = $arrValores['EV / EBIT'];
        $vl_div_br_patrim = $arrValores['Div Br/ Patrim'];
        $vl_cres_rec = $arrValores['Cres. Rec (5a)'];
        $vl_giro_ativos = $arrValores['Giro Ativos'];

        // insere os dados fundamenalistas
        $objAcaoDadosFundamentalistaService = $this->objAcaoDadosFundamentalistaService
            ->inserirAcaoDadosFundamentalista(
                $objAcao,
                [
                    'dt_balanco' => $dt_balanco,
                    'vl_valor_mercado' => $vl_valor_mercado,
                    'vl_valor_firma' => $vl_valor_firma,


                    'nr_qtd_acoes' => $nr_qtd_acoes,
                    'vl_ativo' => $vl_ativo,
                    'vl_div_bruta' => $vl_div_bruta,
                    'vl_disponibilidades' => $vl_disponibilidades,
                    'vl_div_liquida' => $vl_div_liquida,
                    'vl_ativo_circulante' => $vl_ativo_circulante,
                    'vl_patrimonio_liquido' => $vl_patrimonio_liquido,
                    'vl_receita_liquida' => $vl_receita_liquida,
                    'vl_ebit' => $vl_ebit,
                    'vl_lucro_liquido' => $vl_lucro_liquido,
                    'vl_p_l' => $vl_p_l,
                    'vl_lpa' => $vl_lpa,
                    'vl_p_vp' => $vl_p_vp,
                    'vl_vpa' => $vl_vpa,
                    'vl_p_ebit' => $vl_p_ebit,
                    'vl_margem_bruta' => $vl_margem_bruta,
                    'vl_psr' => $vl_psr,
                    'vl_margem_ebit' => $vl_margem_ebit,
                    'vl_p_ativos' => $vl_p_ativos,
                    'vl_margem_liquida' => $vl_margem_liquida,
                    'vl_p_capital_giro' => $vl_p_capital_giro,
                    'vl_ebit_ativo' => $vl_ebit_ativo,
                    'vl_p_ativ_circ_liq' => $vl_p_ativ_circ_liq,
                    'vl_roic' => $vl_roic,
                    'vl_roe' => $vl_roe,
                    'vl_ev_ebitda' => $vl_ev_ebitda,
                    'vl_ev_ebit' => $vl_ev_ebit,
                    'vl_div_br_patrim' => $vl_div_br_patrim,
                    'vl_cres_rec' => $vl_cres_rec,
                    'vl_giro_ativos' => $vl_giro_ativos,

                ]
            );

        dump($objAcaoDadosFundamentalistaService);

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