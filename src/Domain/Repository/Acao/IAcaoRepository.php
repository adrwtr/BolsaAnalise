<?php
namespace Akuma\BolsaAnalise\Domain\Repository\Acao;

use Akuma\BolsaAnalise\Domain\Model\Acao;

interface IAcaoRepository
{
    public function insert(array $arrValores): Acao;
    public function find(string $ds_papel): Acao;
}