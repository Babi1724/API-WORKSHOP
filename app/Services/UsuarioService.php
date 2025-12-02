<?php
namespace App\Services;

use App\DAO\UsuarioDAO;
use App\Models\Usuario;
use InvalidArgumentException;

class UsuarioService
{
    private UsuarioDAO $dao;

    public function __construct(UsuarioDAO $dao)
    {
        $this->dao = $dao;
    }

    public function listAll(): array
    {
        return $this->dao->findAll();
    }

    public function getById(int $id): ?array
    {
        return $this->dao->findById($id);
    }

    public function create(array $data): int
    {
        $this->validate($data);
        $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
        $u = new Usuario($data);
        return $this->dao->insert($u);
    }

    public function update(int $id, array $data): bool
    {
        if (isset($data['senha'])) {
            $data['senha'] = password_hash($data['senha'], PASSWORD_DEFAULT);
        }
        $u = new Usuario($data);
        return $this->dao->update($id, $u);
    }

    public function delete(int $id): bool
    {
        return $this->dao->delete($id);
    }

    private function validate(array $data): void
    {
        if (empty($data['nome'] ?? null)) {
            throw new InvalidArgumentException('Nome é obrigatório');
        }
        if (empty($data['email'] ?? null)) {
            throw new InvalidArgumentException('Email é obrigatório');
        }
        if (empty($data['senha'] ?? null)) {
            throw new InvalidArgumentException('Senha é obrigatória');
        }
    }
}
