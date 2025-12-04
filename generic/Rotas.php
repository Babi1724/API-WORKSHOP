<?php

namespace generic;

class Rotas
{
    private $endpoints = [];

    public function __construct()
    {
        $this->endpoints = [
            "usuario" => new Acao([
                Acao::GET => new Endpoint("Usuario", "index"),
                Acao::POST => new Endpoint("Usuario", "store"),
                Acao::PUT => new Endpoint("Usuario", "update", true),
                Acao::DELETE => new Endpoint("Usuario", "delete", true)

            ]),
            "autenticar" => new Acao([

                Acao::POST => new Endpoint("Usuario", "validate")
            ])
        ];
    }
    public function executar($rota)
    {
        if (isset($this->endpoints[$rota])) {
            $endpoint = $this->endpoints[$rota];
            $dados = $endpoint->executar();
            $retorno = new Retorno();
            $retorno->dados = $dados;
            return $retorno;
        }
        return null;
    }
}