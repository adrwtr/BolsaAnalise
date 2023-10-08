<?php
namespace Akuma\BolsaAnalise\Service;

use Akuma\BolsaAnalise\Domain\Repository\Acao\IAcaoRepository;
use Akuma\BolsaAnalise\Domain\Model\Acao;

use Akuma\BolsaAnalise\Domain\Repository\Acao\IAcaoDadosFundamentalistaRepository;
use Akuma\BolsaAnalise\Domain\Model\AcaoDadosFundamentalista;

class AcaoDadosFundamentalistaService
{
    /**
     * @var IAcaoDadosFundamentalistaRepository
     */
    protected $objAcaoDadosFundamentalistaRepository;

    public function __construct(
        IAcaoDadosFundamentalistaRepository $objIAcaoDadosFundamentalistaRepository
    ) {
        $this->objAcaoDadosFundamentalistaRepository = $objIAcaoDadosFundamentalistaRepository;
    }

    public function getAcaoDadosFundamentalistaRepository() : IAcaoDadosFundamentalistaRepository {
        return $this->objAcaoDadosFundamentalistaRepository;
    }

    public function procurarAcao($ds_papel): AcaoDadosFundamentalista
    {
        return $this->getAcaoDadosFundamentalistaRepository()
            ->find($ds_papel);
    }

    public function inserirAcaoDadosFundamentalista(
        Acao $objAcao,
        $arrDados) : AcaoDadosFundamentalista {
        $objAcaoDadosFundamentalista = null;

        $objAcaoDadosFundamentalista = $this->getAcaoDadosFundamentalistaRepository()
            ->insert(
                $objAcao,
                $arrDados
            );

        return $objAcaoDadosFundamentalista;
    }
}