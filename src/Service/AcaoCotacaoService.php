<?php
namespace Akuma\BolsaAnalise\Service;

use Akuma\BolsaAnalise\Domain\Repository\Acao\IAcaoRepository;
use Akuma\BolsaAnalise\Domain\Model\Acao;

use Akuma\BolsaAnalise\Domain\Repository\Acao\IAcaoCotacaoRepository;
use Akuma\BolsaAnalise\Domain\Model\AcaoCotacao;

class AcaoCotacaoService
{
    /**
     * @var IAcaoCotacaoRepository
     */
    protected $objAcaoCotacaoRepository;

    public function __construct(
        IAcaoCotacaoRepository $objIAcaoCotacaoRepository
    ) {
        $this->objAcaoCotacaoRepository = $objIAcaoCotacaoRepository;
    }

    public function getAcaoCotacaoRepository() : IAcaoCotacaoRepository {
        return $this->objAcaoCotacaoRepository;
    }

    public function inserirAcaoCotacao(
        Acao $objAcao,
        $arrDados
    ) : AcaoCotacao {
        $objAcaoCotacao = null;

        $objAcaoCotacao = $this->getAcaoCotacaoRepository()
            ->insert(
                $objAcao,
                $arrDados
            );

        return $objAcaoCotacao;
    }
}