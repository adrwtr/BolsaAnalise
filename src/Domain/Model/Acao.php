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

use Doctrine\Common\Collections\ArrayCollection;


use Akuma\BolsaAnalise\Domain\Model\BaseModel;

/**
 * @Entity
 * @Table(name="acao")
 */
class Acao extends BaseModel
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
     * @Column(type="string", unique=false, nullable=false)
     */
    public $ds_papel;

    /**
     * @var string
     * @Column(type="string", unique=false, nullable=false)
     */
    public $ds_tipo_papel;

    /**
     * @var string
     * @Column(type="string", unique=false, nullable=false)
     */
    public $ds_nome_empresa;

    /**
     * @var string
     * @Column(type="string", unique=false, nullable=false)
     */
    public $ds_setor;

    /**
     * @var string
     * @Column(type="string", unique=false, nullable=false)
     */
    public $ds_subsetor;

    /**
     * @OneToMany(targetEntity="AcaoDadosFundamentalista", mappedBy="objAcao")
     */
    public $arrAcaoDadosFundamentalista;

    /**
     * @OneToMany(targetEntity="AcaoCotacao", mappedBy="objAcao")
     */
    public $arrAcaoCotacao;

    public function __construct(
        string $ds_papel,
        string $ds_nome_empresa = '',
        string $ds_tipo_papel = '',
        string $ds_setor = '',
        string $ds_subsetor = ''
    ) {
        $this->ds_papel = $ds_papel;
        $this->ds_tipo_papel = $ds_tipo_papel;
        $this->ds_nome_empresa = $ds_nome_empresa;
        $this->ds_setor = $ds_setor;
        $this->ds_subsetor = $ds_subsetor;

        $this->dt_cadastro = new \DateTime("now");
        $this->dt_atualizacao = new \DateTime("now");
        $this->dt_exclusao = null;

        $this->arrAcaoDadosFundamentalista = new ArrayCollection();
        $this->arrAcaoCotacao = new ArrayCollection();
    }
}