<?php
declare(strict_types=1);

namespace Akuma\BolsaAnalise\Domain\Repository;

use App\Domain\Model\Usuario;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class UsuarioSQLiteRepository implements IUsuarioRepository
{
    private EntityManager $em;
    private EntityRepository $objRepository;

    // private $em;
    // private $objRepository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;

        $this->objRepository = $this->em->getRepository(
            \Akuma\BolsaAnalise\Domain\Model\Usuario::class
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

    public function findAll(): array
    {
        return $this->getRepository()
            ->findAll();
    }

    public function findUsuarioById(int $id): Usuario
    {
        $arrUsuario = $this->getEntityManager()->find(
            \App\Domain\Model\Usuario::class,
            $id
        );

        if ($arrUsuario == null) {
            throw new \Exception("Usuario " . $id . " não encontrado");
        }

        return $arrUsuario;
    }

    public function insert(array $arrValores): Usuario
    {
        if (!isset($arrValores['ds_nome'])) {
            throw new \Exception('Campo ds_nome não informado');
        }

        $objNovo = new Usuario(
            null,
            $arrValores['ds_nome']
        );

        $this->getEntityManager()
            ->persist($objNovo);

        $this->getEntityManager()
            ->flush();

        return $objNovo;
    }

    public function update(int $id, array $arrValores): bool
    {
        if (!isset($arrValores['ds_nome'])) {
            throw Exception('Campo ds_nome não informado');
        }

        $objUsuario = $this->findUsuarioById($id);
        $objUsuario->setDsNome($arrValores['ds_nome']);

        $this->getEntityManager()->
            persist($objUsuario);

        $this->getEntityManager()
            ->flush();

        return true;
    }

    public function delete(int $id): bool
    {
        $objUsuario = $this->findUsuarioById($id);

        $this->getEntityManager()
            ->remove($objUsuario);

        $this->getEntityManager()
            ->flush();

        return true;
    }
}