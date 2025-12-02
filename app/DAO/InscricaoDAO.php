<?php
namespace App\DAO;

use PDO;
use App\Models\Inscricao;

class InscricaoDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(Inscricao $i): int
    {
        $sql = "INSERT INTO inscricoes (usuario_id, workshop_id) VALUES (:usuario_id, :workshop_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':usuario_id'=>$i->usuario_id,
            ':workshop_id'=>$i->workshop_id
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function findAll(): array
    {
        return $this->pdo->query('SELECT * FROM inscricoes ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM inscricoes WHERE id=:id');
        $stmt->execute([':id'=>$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function findByUsuarioId(int $usuario_id): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM inscricoes WHERE usuario_id=:usuario_id');
        $stmt->execute([':usuario_id'=>$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM inscricoes WHERE id=:id');
        return $stmt->execute([':id'=>$id]);
    }
}
