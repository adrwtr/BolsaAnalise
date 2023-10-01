<?php
declare(strict_types=1);

namespace Akuma\BolsaAnalise\Domain\Repository;

use App\Domain\Model\Usuario;

interface IUsuarioRepository
{
    /**
     * @return Usuario[]
     */
    public function findAll(): array;

    public function insert(array $arrValores): Usuario;

    public function update(int $id, array $arrValores): bool;

    public function delete(int $id): bool;

    /**
     * @param int $id
     * @return Usuario
     * @throws Exception
     */
    public function findUsuarioById(int $id): Usuario;
}