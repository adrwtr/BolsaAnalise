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

    public function getArrAcoes()
    {
        return [
            'PETR4'
            , 'VALE3'
            , 'SAPR4'
            , 'ABEV3'
            , 'ITSA4'
            , 'COGN3'
            , 'UGPA3'
            , 'BBAS3'
        ];
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