<?php
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

use Doctrine\Common\Collections\ArrayCollection;


use Akuma\BolsaAnalise\Domain\Model\BaseModel;
use Akuma\BolsaAnalise\Domain\Model\Acao;

/**
 * @Entity
 * @Table(name="acao_cotacao")
 */
class AcaoCotacao extends BaseModel
{
    /**
     * @var int|null
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    public $id;

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
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_volume_dia;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_media_200_dias;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_media_volume_90_dias;

    /**
     * @var float
     * @Column(type="float", unique=false, nullable=true)
     */
    public $vl_media_volume_10_dias;

    /**
     * @ManyToOne(targetEntity="Acao", inversedBy="arrAcaoCotacao")
     * @JoinColumn(name="acao_id", referencedColumnName="id", nullable=false)
     */
    public Acao $objAcao;

    public function __construct(
        Acao $objAcao,
        $ds_papel,
        $vl_media_200_dias,
        $vl_preco_dia,
        $vl_volume_dia,
        $vl_media_volume_90_dias,
        $vl_media_volume_10_dias
    ) {
        $this->objAcao = $objAcao;

        $this->objAcao = $objAcao;
        $this->ds_papel = $ds_papel;
        $this->vl_media_200_dias = $vl_media_200_dias;
        $this->vl_preco_dia = $vl_preco_dia;
        $this->vl_volume_dia = $vl_volume_dia;
        $this->vl_media_volume_90_dias = $vl_media_volume_90_dias;
        $this->vl_media_volume_10_dias = $vl_media_volume_10_dias;

        $this->dt_cadastro = new \DateTime("now");
        $this->dt_atualizacao = new \DateTime("now");
        $this->dt_exclusao = null;
    }
}