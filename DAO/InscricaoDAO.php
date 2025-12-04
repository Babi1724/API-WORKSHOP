<?php

namespace DAO;

use generic\MysqlFactory;

class InscricaoDAO extends MysqlFactory
{


    public function __construct()
    {
        parent::__construct();
    }

    public function insert(Inscricao $i): int
    {
        $sql = "INSERT INTO inscricoes (usuario_id, workshop_id) VALUES (:usuario_id, :workshop_id)";
        $param = [
            ':usuario_id' => $i->usuario_id,
            ':workshop_id' => $i->workshop_id
        ];
        $retorno = $this->banco->executar($sql, $param);
    }

    public function findAll(): array
    {
        return $this->pdo->query('SELECT * FROM inscricoes ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM inscricoes WHERE id=:id');
        $param = [':id' => $id];
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function findByUsuarioId(int $usuario_id): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM inscricoes WHERE usuario_id=:usuario_id');
        $param = [':usuario_id' => $usuario_id];
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM inscricoes WHERE id=:id';
        $param = [':id' => $id];
        $retorno = $this->banco->executar($sql, $param);
        return true;
    }
}