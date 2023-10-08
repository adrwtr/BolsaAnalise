<?php
declare(strict_types=1);

namespace Akuma\BolsaAnalise\Domain\Model;

use JsonSerializable;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @Entity
 * @Table(name="acao_dados_fundamentalista")
 */
class AcaoDadosFundamentalista extends BaseModel
{
    /**
     * @var int|null
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="Acao", inversedBy="arrAcaoDadosFundamentalista")
     * @JoinColumn(name="acao_id", referencedColumnName="id", nullable=false)
     */
    private $objAcao;

    /**
     * @var \DateTime
     * @Column(type="datetime", unique=false, nullable=false)
     */
    private $dt_leitura;

    /**
     * @var \DateTime
     * @Column(type="datetime", unique=false, nullable=false)
     */
    private $dt_balanco;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_valor_mercado;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_valor_firma;

    /**
     * @var int
     * @Column(type="integer", unique=false, nullable=false)
     */
    private $nr_qtd_acoes;

    // balanço patrimonial


    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_ativo;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_div_bruta;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_disponibilidades;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_div_liquida;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_ativo_circulante;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_patrimonio_liquido;


    // demonstrativo de resultados ultimos 3 meses

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_receita_liquida;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_ebit;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_lucro_liquido;


    // indicadores fundamentalistas

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_p_l;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_lpa;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_p_vp;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_vpa;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_p_ebit;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_margem_bruta;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_psr;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_margem_ebit;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_p_ativos;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_margem_liquida;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_p_capital_giro;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_ebit_ativo;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_p_ativ_circ_liq;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_roic;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_roe;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_ev_ebitda;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_ev_ebit;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_div_br_patrim;


    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_cres_rec;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=false)
     */
    private $vl_giro_ativos;


}