<?php
namespace App\DAO;

use PDO;
use App\Models\Usuario;

class UsuarioDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(Usuario $u): int
    {
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nome'=>$u->nome,
            ':email'=>$u->email,
            ':senha'=>$u->senha // lembrando: deve ser hashado
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function findAll(): array
    {
        return $this->pdo->query('SELECT id, nome, email, created_at FROM usuarios ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT id, nome, email, created_at FROM usuarios WHERE id=:id');
        $stmt->execute([':id'=>$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE email=:email');
        $stmt->execute([':email'=>$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function update(int $id, Usuario $u): bool
    {
        $sql = "UPDATE usuarios SET nome=:nome, email=:email, senha=:senha WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nome'=>$u->nome,
            ':email'=>$u->email,
            ':senha'=>$u->senha,
            ':id'=>$id
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM usuarios WHERE id=:id');
        return $stmt->execute([':id'=>$id]);
    }
}