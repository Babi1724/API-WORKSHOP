<?php

namespace Services;

use DAO\InscricaoDAO;
use DAO\UsuarioDAO;
use DAO\WorkshopDAO;



class InscricaoService extends InscricaoDAO
{


    public function listAll()
    {
        return parent::findAll();
    }

    public function getById(int $id): ?array
    {
        return parent::findById($id);
    }

    public function listByUsuario(int $usuario_id)
    {
        return parent::findByUsuarioId($usuario_id);
    }

    public function create(array $data): int
    {
        $this->validate($data);
        $i = new Inscricao($data);
        return parent::insert($i);
    }

    public function delete(int $id): bool
    {
        return parent::delete($id);
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