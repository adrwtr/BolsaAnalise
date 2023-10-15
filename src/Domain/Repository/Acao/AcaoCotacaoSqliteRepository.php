<?php
declare(strict_types=1);

namespace Akuma\BolsaAnalise\Domain\Repository\Acao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use Akuma\BolsaAnalise\Domain\Model\Acao;
use Akuma\BolsaAnalise\Domain\Model\AcaoCotacao;

class AcaoCotacaoSQLiteRepository implements IAcaoCotacaoRepository
{
    private EntityManager $em;
    private EntityRepository $objRepository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        $this->objRepository = $this->em->getRepository(
            \Akuma\BolsaAnalise\Domain\Model\AcaoCotacao::class
        );
    }

    public function getRepository()
    {
        return $this->objRepository;
    }

    public function getEntityManager()
    {
        return $this->em;
    }

    public function findByDate(
        Acao $objAcao,
        \DateTime $objDtPesquisa
    ): AcaoCotacao  {
        // busca pela acao
        // e por algo realizado na data atual
        $objQuery = $this->getEntityManager()
            ->createQuery(
                "SELECT ac FROM "
                . "\Akuma\BolsaAnalise\Domain\Model\AcaoCotacao ac "
                . "WHERE "
                . "ac.objAcao = :objAcao "
                . "AND DATE_DIFF(ac.dt_cadastro, :dt_cadastro) >= 0"
            );

        $objQuery->setParameter(
            'objAcao',
            $objAcao
        );

        $objQuery->setParameter(
            'dt_cadastro',
            $objDtPesquisa
        );

        $arrResult = $objQuery->getResult();

        if (count($arrResult) <= 0) {
            throw new \Exception(
                "A Acao de papel "
                . $objAcao->ds_papel
                . " não possui cotação para a data: "
                . $objDtPesquisa->format("d/m/Y")
            );
        }

        return $arrResult[0];
    }

    public function insert(
        Acao $objAcao,
        array $arrValores
    ): AcaoCotacao {
        try {
            $objAcaoCotacao = $this->findByDate(
                $objAcao,
                new \DateTime("now")
            );

            return $objAcaoCotacao;
        } catch (\Exception $e) {
            $objAcaoCotacao = null;
        }

        $objAcaoCotacao = new AcaoCotacao(
            $objAcao,
            $arrValores['ds_papel'],
            $arrValores['vl_media_200_dias'],
            $arrValores['vl_preco_dia'],
            $arrValores['vl_volume_dia'],
            $arrValores['vl_media_volume_90_dias'],
            $arrValores['vl_media_volume_10_dias']
        );

        $this->getEntityManager()
            ->persist($objAcaoCotacao);

        $this->getEntityManager()
            ->flush();

        return $objAcaoCotacao;
    }
}