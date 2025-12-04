<?php

namespace controller;

use Services\UsuarioService;

class Usuario
{


    public function __construct() {}

    public function index()
    {
        $service = new UsuarioService();
        return $resultado = $service->listAll();
    }

    public function store($nome, $email, $senha)
    {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        $nome = $data["nome"] ?? null;
        $email = $data["email"] ?? null;
        $senha = $data["senha"] ?? null;

        $service = new UsuarioService();
        $resultado = $service->create($nome, $email, $senha);

        if ($resultado) {
            return ["message" => "Inserçao bem-sucedida."];
        } else {
            return ["message" => "Inserçao mal-sucedida."];
        }
    }

    public function update($id, $nome, $email, $senha)
    {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        $id =  $data["id"] ?? null;
        $nome = $data["nome"] ?? null;
        $email = $data["email"] ?? null;
        $senha = $data["senha"] ?? null;

        $service = new UsuarioService();
        $resultado = $service->update($id, $nome, $email, $senha);

        if ($resultado) {
            http_response_code(200);
            return ["message" => "Alteração realizada com sucesso."];
        } else {
            http_response_code(400);
            return ["message" => "Erro ao realizar a alteração."];
        }
    }

    public function delete($id)
    {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);
        $id =  $data["id"] ?? null;
        $service = new UsuarioService();
        $resultado = $service->delete($id);
        if ($resultado) {
            http_response_code(200);
            return ["message" => "Exclusão realizada com sucesso."];
        } else {
            http_response_code(400);
            return ["message" => "Erro ao realizar a alteração."];
        }
    }
    public function validate()
    {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        $email = $data["email"] ?? null;
        $senha = $data["senha"] ?? null;

        $service = new UsuarioService();
        $resultado = $service->validate($email);

        if ($resultado && password_verify($senha, $resultado['senha'])) {

            $id = $resultado['id'];
            $nome = $resultado['nome'];


            $token = $service->autenticar($nome, $id);
            return [
                "message" => "Login bem-sucedido.",
                "token" => $token,
                "usuario" => [
                    "id" => $id,
                    "nome" => $nome
                ]
            ];
        } else {

            http_response_code(401);
            return ["erro" => "Credenciais inválidas."];
            exit;
        }
    }
    public function autenticar($nome, $id)
    {
        $service = new UsuarioService();
        return $service->autenticar($nome, $id);
    }
}
