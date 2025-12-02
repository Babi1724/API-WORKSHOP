<?php
namespace App\Services;

use App\DAO\InscricaoDAO;
use App\DAO\UsuarioDAO;
use App\DAO\WorkshopDAO;
use App\Models\Inscricao;
use InvalidArgumentException;

class InscricaoService
{
    private InscricaoDAO $dao;
    private UsuarioDAO $usuarioDao;
    private WorkshopDAO $workshopDao;

    public function __construct(InscricaoDAO $dao, UsuarioDAO $usuarioDao, WorkshopDAO $workshopDao)
    {
        $this->dao = $dao;
        $this->usuarioDao = $usuarioDao;
        $this->workshopDao = $workshopDao;
    }

    public function listAll(): array
    {
        return $this->dao->findAll();
    }

    public function getById(int $id): ?array
    {
        return $this->dao->findById($id);
    }

    public function listByUsuario(int $usuario_id): array
    {
        return $this->dao->findByUsuarioId($usuario_id);
    }

    public function create(array $data): int
    {
        $this->validate($data);
        $i = new Inscricao($data);
        return $this->dao->insert($i);
    }

    public function delete(int $id): bool
    {
        return $this->dao->delete($id);
    }

    private function validate(array $data): void
    {
        if (empty($data['usuario_id'] ?? null) || empty($data['workshop_id'] ?? null)) {
            throw new InvalidArgumentException('Usuário e Workshop são obrigatórios para inscrição');
        }
        if (!$this->usuarioDao->findById($data['usuario_id'])) {
            throw new InvalidArgumentException('Usuário não existe');
        }
        if (!$this->workshopDao->findById($data['workshop_id'])) {
            throw new InvalidArgumentException('Workshop não existe');
        }
    }
}
