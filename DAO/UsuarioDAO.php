<?php

namespace DAO;


use generic\MysqlFactory;

class UsuarioDAO extends MysqlFactory
{


    public function __construct()
    {
        parent::__construct();
    }

    public function insert($nome, $email, $senha)
    {
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $param = [
            ":nome" => $nome,
            ":email" => $email,
            ":senha" => $senha
        ];

        $retorno = $this->banco->executar($sql, $param);
        return true;
    }

    public function findAll()
    {
        $sql = 'SELECT id, nome, email, created_at FROM usuarios ORDER BY id DESC';
        $retorno = $this->banco->executar($sql);
        return $retorno;
    }

    public function findById($id)
    {
        $sql = 'SELECT id, nome, email, created_at FROM usuarios WHERE id=:id';
        $param = [":id" => $id];
        $retorno = $this->banco->executar($sql, $param);
        return $retorno;
    }

    public function findByEmail($email)
    {
        $sql = 'SELECT * FROM usuarios WHERE email=:email';
        $param = [':email' => $email];
        $resultado = $this->banco->executar($sql, [':email' => $email]);

        return $resultado ? $resultado[0] : null;
    }

    public function update($id, $nome, $email, $senha)
    {
        $sql = "UPDATE usuarios SET nome=:nome, email=:email, senha=:senha WHERE id=:id";

        $param = [
            ':nome' => $nome,
            ':email' => $email,
            ':senha' => $senha,
            ':id' => $id
        ];
        $retorno = $this->banco->executar($sql, $param);
        return true;
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM usuarios WHERE id=:id';
        $param = [':id' => $id];
        $retorno = $this->banco->executar($sql, $param);
        return true;
    }
}