<?php
declare(strict_types=1);

namespace Akuma\BolsaAnalise\Domain\Repository\Acao;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

use Akuma\BolsaAnalise\Domain\Model\Acao;

class AcaoSQLiteRepository implements IAcaoRepository
{
    private EntityManager $em;
    private EntityRepository $objRepository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        $this->objRepository = $this->em->getRepository(
            \Akuma\BolsaAnalise\Domain\Model\Acao::class
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

    public function find(string $ds_papel) : Acao
    {
        $objAcao = $this->getEntityManager()
            ->getRepository(
                \Akuma\BolsaAnalise\Domain\Model\Acao::class,
            )->findOneBy([
                'ds_papel' => $ds_papel,
                'dt_exclusao' => null
            ]);

        if ($objAcao == null) {
            throw new \Exception(
                "Acao de papel "
                . $ds_papel
                . " não encontrada"
            );
        }

        return $objAcao;
    }

    public function insert(array $arrValores): Acao
    {
        if (!isset($arrValores['ds_papel'])) {
            throw new \Exception('Campo ds_nome não informado');
        }

        try {
            $objAcao = $this->find($arrValores['ds_papel']);

            if ($objAcao != null) {
                return $objAcao;
            }
        } catch (\Exception $e) {
            $objAcao = null;
        }

        $objAcao = new Acao(
            $arrValores['ds_papel'],
            $arrValores['ds_nome_empresa'] ?? '',
            $arrValores['ds_tipo_papel'] ?? '',
            $arrValores['ds_setor'] ?? '',
            $arrValores['ds_subsetor'] ?? ''
        );

        $this->getEntityManager()
            ->persist($objAcao);

        $this->getEntityManager()
            ->flush();

        return $objAcao;
    }
}