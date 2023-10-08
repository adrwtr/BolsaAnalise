<?php
namespace Akuma\BolsaAnalise\Service;

use Akuma\BolsaAnalise\Domain\Repository\Acao\IAcaoRepository;
use Akuma\BolsaAnalise\Domain\Model\Acao;

class AcaoService
{
    /**
     * @var IAcaoRepository
     */
    protected $objAcaoRepository;

    public function __construct(
        IAcaoRepository $objAcaoRepository
    ) {
        $this->objAcaoRepository = $objAcaoRepository;
    }

    public function getAcaoRepository() {
        return $this->objAcaoRepository;
    }

    public function procurarAcao($ds_papel): Acao
    {
        return $this->getAcaoRepository()
            ->find($ds_papel);
    }

    public function inserirAcao($arrDados)
    {
        $objAcao = null;

        $objAcao = $this->getAcaoRepository()->insert(
            $arrDados
        );

        return $objAcao;
    }
}