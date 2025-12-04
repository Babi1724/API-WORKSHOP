<?php

namespace DAO;

use PDO;
use Models\Workshop;

class WorkshopDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(Workshop $w): int
    {
        $sql = "INSERT INTO workshops (titulo, descricao, data, local, vagas, instrutor_email)
                VALUES (:titulo, :descricao, :data, :local, :vagas, :instrutor_email)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $w->titulo,
            ':descricao' => $w->descricao,
            ':data' => $w->data,
            ':local' => $w->local,
            ':vagas' => $w->vagas,
            ':instrutor_email' => $w->instrutor_email
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function findAll(): array
    {
        return $this->pdo->query('SELECT * FROM workshops ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM workshops WHERE id=:id');
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function update(int $id, Workshop $w): bool
    {
        $sql = "UPDATE workshops SET titulo=:titulo, descricao=:descricao, data=:data, local=:local, vagas=:vagas, instrutor_email=:instrutor_email WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':titulo' => $w->titulo,
            ':descricao' => $w->descricao,
            ':data' => $w->data,
            ':local' => $w->local,
            ':vagas' => $w->vagas,
            ':instrutor_email' => $w->instrutor_email,
            ':id' => $id
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM workshops WHERE id=:id');
        return $stmt->execute([':id' => $id]);
    }
}