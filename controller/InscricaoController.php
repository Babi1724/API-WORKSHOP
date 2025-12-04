<?php

namespace controllers;


use Services\InscricaoService;


class InscricaoController
{
    private InscricaoService $service;

    public function __construct() {}

    public function index(): void
    {
        $service = new InscricaoService();
        return $resultado = $service->listAll();
    }

    public function show(int $id): void
    {
        $row = $this->service->getById($id);
        if (!$row) {
            $this->json(['error' => 'Inscrição não encontrada'], 404);
            return;
        }
        $this->json($row);
    }

    public function listByUsuario(int $usuario_id): void
    {
        $rows = $this->service->listByUsuario($usuario_id);
        $this->json($rows);
    }

    public function store(): void
    {
        try {
            $data = $this->input();
            $id = $this->service->create($data);
            $this->json(['id' => $id], 201);
        } catch (InvalidArgumentException $e) {
            $this->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            $this->json(['error' => 'Erro interno', 'message' => $e->getMessage()], 500);
        }
    }

    public function delete(int $id): void
    {
        $ok = $this->service->delete($id);
        if ($ok) $this->json([], 204);
        else $this->json(['error' => 'Não foi possível deletar'], 500);
    }
}