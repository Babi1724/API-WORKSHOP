<?php

namespace Services;

use DAO\UsuarioDAO;

use JWTAuth as GlobalJWTAuth;
use stdClass;


class UsuarioService extends UsuarioDAO
{





    public function listAll()
    {
        return parent::findAll();
    }

    public function getById(int $id): ?array
    {
        return parent::findById($id);
    }

    public function create($nome, $email, $senha)
    {

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        return parent::insert($nome, $email, $senha_hash);
    }

    public function update($id, $nome, $email, $senha)
    {
        if (isset($senha)) {
            $senha = password_hash($senha, PASSWORD_DEFAULT);
        }


        return parent::update($id, $nome, $email, $senha);
    }


    public function delete($id)
    {
        return parent::delete($id);
    }
    public function validate($email)
    {
        return parent::findByEmail($email);
    }

    public function autenticar($nome, $id)
    {
        $jwt = new GlobalJWTAuth();
        $objeto = new stdClass();

        $objeto->id = "$id";
        $objeto->nome  = "$nome";



        return $jwt->criarchave(json_encode($objeto));
    }
}
