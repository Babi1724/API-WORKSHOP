<?php
namespace App\Services;

use App\DAO\WorkshopDAO;
use App\Models\Workshop;
use InvalidArgumentException;

class WorkshopService
{
    private WorkshopDAO $dao;

    public function __construct(WorkshopDAO $dao)
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
        $w = new Workshop($data);
        return $this->dao->insert($w);
    }

    public function update(int $id, array $data): bool
    {
        if (isset($data['titulo']) && trim((string)$data['titulo']) === '') {
            throw new InvalidArgumentException('Título inválido');
        }
        $w = new Workshop($data);
        return $this->dao->update($id, $w);
    }

    public function delete(int $id): bool
    {
        return $this->dao->delete($id);
    }

    private function validate(array $data): void
    {
        if (empty($data['titulo'] ?? null)) {
            throw new InvalidArgumentException('Título é obrigatório');
        }
        if (isset($data['vagas']) && !is_numeric($data['vagas'])) {
            throw new InvalidArgumentException('Vagas deve ser um número');
        }
    }
}