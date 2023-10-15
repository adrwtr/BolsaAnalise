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

use Akuma\BolsaAnalise\Domain\Model\Acao;

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
    public $id;

    /**
     * @ManyToOne(targetEntity="Acao", inversedBy="arrAcaoDadosFundamentalista")
     * @JoinColumn(name="acao_id", referencedColumnName="id", nullable=false)
     */
    public Acao $objAcao;

    /**
     * @var string
     * @Column(type="string", unique=false, nullable=true)
     */
    public $ds_papel;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_preco_dia;

    /**
     * @var \DateTime
     * @Column(type="datetime", unique=false, nullable=true)
     */
    public $dt_balanco;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_valor_mercado;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_valor_firma;

    /**
     * @var int
     * @Column(type="integer", unique=false, nullable=true)
     */
    public $nr_qtd_acoes;

    // balanço patrimonial


    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_ativo;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_div_bruta;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_disponibilidades;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_div_liquida;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_ativo_circulante;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_patrimonio_liquido;


    // demonstrativo de resultados ultimos 3 meses

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_receita_liquida;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_ebit;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_lucro_liquido;


    // indicadores fundamentalistas

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_p_l;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_lpa;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_p_vp;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_vpa;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_p_ebit;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_margem_bruta;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_psr;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_margem_ebit;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_p_ativos;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_margem_liquida;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_p_capital_giro;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_ebit_ativo;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_p_ativ_circ_liq;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_roic;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_roe;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_ev_ebitda;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_ev_ebit;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_div_br_patrim;


    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_cres_rec;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_giro_ativos;

    public function __construct(
        Acao $objAcao,
        $arrDados
    ) {
        $this->objAcao = $objAcao;

        foreach($arrDados as $ds_campo => $mixed_valor) {
            $this->$ds_campo = $mixed_valor;
        }

        $this->dt_cadastro = new \DateTime("now");
        $this->dt_atualizacao = new \DateTime("now");
        $this->dt_exclusao = null;
    }

}