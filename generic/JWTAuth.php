<?php


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuth
{
    private string $key = "6c1cc6a169d32c3c470bc019f47921e1175dee5a4b4f29dcc5acac7cc990be6eahbsudfinasdljfgbsduiyfHAIFBNasihfbasdonfjkhabdASJDohbo";

    public function criarchave($dados)
    {
        $hora = time();
        $payload = [
            'iat' => $hora,
            'exp' => $hora +  180000,
            'uid' => $dados
        ];
        $jwt = JWT::encode($payload, $this->key, 'HS256');
        return $jwt;
    }
    public function verificar()
    {
        try {
            if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
                http_response_code(406);
                return false;
            }
            $autorizacao = $_SERVER['HTTP_AUTHORIZATION'];

            $token = str_replace('Bearer', '', $autorizacao);
            $token = trim($token);
            $decodificar = JWT::decode($token, new Key($this->key, 'HS256'));
            $hora = time();
            if ($hora > $decodificar->exp) {
                http_response_code(408);
                return false;
            }
            return $decodificar;
        } catch (Exception $e) {
            error_log("Erro de decodificação JWT: " . $e->getMessage()); // Adicione este log
            http_response_code(401);
            return false;
        }
    }
}