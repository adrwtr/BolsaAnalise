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

    public function find(string $ds_papel) : AcaoDadosFundamentalista
    {
        // $objAcao = $this->getEntityManager()
        //     ->getRepository(
        //         \Akuma\BolsaAnalise\Domain\Model\Acao::class,
        //     )->findOneBy([
        //         'ds_papel' => $ds_papel,
        //         'dt_exclusao' => null
        //     ]);

        // if ($objAcao == null) {
        //     throw new \Exception(
        //         "Acao de papel "
        //         . $ds_papel
        //         . " não encontrada"
        //     );
        // }

        // return $objAcao;
    }

    public function insert(
        Acao $objAcao,
        array $arrValores
    ): AcaoDadosFundamentalista
    {
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