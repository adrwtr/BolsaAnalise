<?php
namespace Akuma\BolsaAnalise\Service;

use Akuma\BolsaAnalise\Domain\Repository\IUsuarioRepository;

class UsuarioService
{
    /**
     * @var IUsuarioRepository
     */
    protected $objUsuarioRepository;

    public function __construct(
        IUsuarioRepository $objUsuarioRepository
    ) {
        $this->objUsuarioRepository = $objUsuarioRepository;
    }

    public function getUsuarioRepository() {
        return $this->objUsuarioRepository;
    }

    public function listarUsuarios(): array
    {
        return $this->getUsuarioRepository()->findAll();
    }

    public function procurarUsuario($id): array
    {
        return $this->getUsuarioRepository()
            ->findUsuarioById($id)
            ->jsonSerialize();
    }

    public function inserirUsuario($objJsonBody)
    {
        $objUsuario = null;

        if (isset($objJsonBody->ds_nome)) {
            $arrDados = ["ds_nome" => $objJsonBody->ds_nome];

            $objUsuario = $this->getUsuarioRepository()->insert(
                $arrDados
            );
        }

        // var_dump($this->listarUsuarios());

        return $objUsuario;
    }

    public function alterarUsuario($id, $objJsonBody)
    {
        if (isset($objJsonBody->ds_nome)) {
            $arrDados = ["ds_nome" => $objJsonBody->ds_nome];

            $sn_alterado = $this->getUsuarioRepository()->update(
                $id,
                $arrDados
            );
        }

        // var_dump($this->listarUsuarios());

        return $sn_alterado;
    }

    public function excluirUsuario($id)
    {
        $sn_excluido = $this->getUsuarioRepository()->delete(
            $id
        );

        // var_dump($this->listarUsuarios());

        return $sn_excluido;
    }
}