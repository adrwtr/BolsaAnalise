<?php
namespace Akuma\BolsaAnalise\Domain\Repository\Acao;

use Akuma\BolsaAnalise\Domain\Model\AcaoDadosFundamentalista;
use Akuma\BolsaAnalise\Domain\Model\Acao;

interface IAcaoDadosFundamentalistaRepository
{
    public function insert(Acao $objAcao, array $arrValores): AcaoDadosFundamentalista;
    public function findByDate(Acao $objAcao, \DateTime $objDtPesquisa): AcaoDadosFundamentalista;
}