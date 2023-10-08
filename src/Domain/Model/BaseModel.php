<?php
namespace Akuma\BolsaAnalise\Domain\Model;

use JsonSerializable;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\MappedSuperclass;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 * @MappedSuperclass
 */
class BaseModel
{
    /**
     * @var \DateTime
     * @Column(type="datetime", unique=false, nullable=false)
     */
    protected $dt_cadastro;

    /**
     * @var \DateTime
     * @Column(type="datetime", unique=false, nullable=false)
     */
    protected $dt_atualizacao;

    /**
     * @var \DateTime|null
     * @Column(type="datetime", unique=false, nullable=true)
     */
    protected $dt_exclusao;
}