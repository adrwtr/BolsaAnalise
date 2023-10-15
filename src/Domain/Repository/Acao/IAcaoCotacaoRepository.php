<?php
namespace Akuma\BolsaAnalise\Domain\Repository\Acao;

use Akuma\BolsaAnalise\Domain\Model\AcaoCotacao;
use Akuma\BolsaAnalise\Domain\Model\Acao;

interface IAcaoCotacaoRepository
{
    public function insert(Acao $objAcao, array $arrValores): AcaoCotacao;
    public function findByDate(Acao $objAcao, \DateTime $objDtPesquisa): AcaoCotacao;
}