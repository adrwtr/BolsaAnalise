<?php
declare(strict_types=1);

namespace Akuma\BolsaAnalise\Domain\Model;

use JsonSerializable;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @Table(name="usuario")
 */
class Usuario implements JsonSerializable
{
    /**
     * @var int|null
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", unique=false, nullable=false)
     */
    private $ds_nome;

    /**
     * @param int|null  $id
     * @param string    $ds_nome
     */
    public function __construct(?int $id, string $ds_nome)
    {
        $this->id = $id;
        $this->ds_nome = $ds_nome;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDsNome(): string
    {
        return $this->ds_nome;
    }

    /**
     * @return string
     */
    public function setDsNome($ds_valor): string
    {
        $this->ds_nome = $ds_valor;
        return $this->ds_nome;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): JsonSerializable
    {
        return [
            'id' => $this->id,
            'ds_nome' => $this->ds_nome
        ];
    }
}