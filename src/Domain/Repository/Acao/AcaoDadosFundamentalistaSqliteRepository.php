<?php
declare(strict_types=1);

namespace Akuma\BolsaAnalise\Domain\Repository\Acao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use Akuma\BolsaAnalise\Domain\Model\Acao;
use Akuma\BolsaAnalise\Domain\Model\AcaoDadosFundamentalista;

class AcaoDadosFundamentalistaSQLiteRepository implements IAcaoDadosFundamentalistaRepository
{
    private EntityManager $em;
    private EntityRepository $objRepository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        $this->objRepository = $this->em->getRepository(
            \Akuma\BolsaAnalise\Domain\Model\AcaoDadosFundamentalista::class
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
    ): AcaoDadosFundamentalista  {
        // busca pela acao
        // e por algo realizado na data atual
        $objQuery = $this->getEntityManager()
            ->createQuery(
                "SELECT adf FROM "
                . "\Akuma\BolsaAnalise\Domain\Model\AcaoDadosFundamentalista adf "
                . "WHERE "
                . "adf.objAcao = :objAcao "
                . "AND DATE_DIFF(adf.dt_cadastro, :dt_cadastro) >= 0"
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
                . " não possui dados fundamentalistas para a data: "
                . $objDtPesquisa->format("d/m/Y")
            );
        }

        return $arrResult[0];
    }

    public function insert(
        Acao $objAcao,
        array $arrValores
    ): AcaoDadosFundamentalista {
        try {
            $objAcaoDadosFundamentalista = $this->findByDate(
                $objAcao,
                new \DateTime("now")
            );

            return $objAcaoDadosFundamentalista;
        } catch (\Exception $e) {
            $objAcaoDadosFundamentalista = null;
        }

        $objAcaoDadosFundamentalista = new AcaoDadosFundamentalista(
            $objAcao,
            $arrValores
        );

        $this->getEntityManager()
            ->persist($objAcaoDadosFundamentalista);

        $this->getEntityManager()
            ->flush();

        return $objAcaoDadosFundamentalista;
    }
}