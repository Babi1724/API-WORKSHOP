<?php

namespace Controllers;

use Core\Controller;
use DAO\WorkshopDAO;
use Services\WorkshopService;
use PDO;
use InvalidArgumentException;

class WorkshopController
{
    private WorkshopService $service;

    public function __construct(PDO $pdo)
    {
        $dao = new WorkshopDAO($pdo);
        $this->service = new WorkshopService($dao);
    }

    public function index(): void
    {
        $rows = $this->service->listAll();
        $this->json($rows);
    }

    public function show(int $id): void
    {
        $row = $this->service->getById($id);
        if (!$row) {
            $this->json(['error' => 'Workshop não encontrado'], 404);
            return;
        }
        $this->json($row);
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

    public function update(int $id): void
    {
        try {
            $data = $this->input();
            $ok = $this->service->update($id, $data);
            $this->json(['success' => $ok], $ok ? 200 : 500);
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
