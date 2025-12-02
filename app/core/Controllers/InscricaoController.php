<?php
namespace App\Controllers;

use App\Core\Controller;
use App\DAO\InscricaoDAO;
use App\DAO\UsuarioDAO;
use App\DAO\WorkshopDAO;
use App\Services\InscricaoService;
use PDO;
use InvalidArgumentException;

class InscricaoController extends Controller
{
    private InscricaoService $service;

    public function __construct(PDO $pdo)
    {
        $dao = new InscricaoDAO($pdo);
        $usuarioDao = new UsuarioDAO($pdo);
        $workshopDao = new WorkshopDAO($pdo);
        $this->service = new InscricaoService($dao, $usuarioDao, $workshopDao);
    }

    public function index(): void
    {
        $rows = $this->service->listAll();
        $this->json($rows);
    }

    public function show(int $id): void
    {
        $row = $this->service->getById($id);
        if(!$row){
            $this->json(['error'=>'Inscrição não encontrada'],404);
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
            $this->json(['id'=>$id],201);
        } catch(InvalidArgumentException $e) {
            $this->json(['error'=>$e->getMessage()],400);
        } catch(\Exception $e) {
            $this->json(['error'=>'Erro interno','message'=>$e->getMessage()],500);
        }
    }

    public function delete(int $id): void
    {
        $ok = $this->service->delete($id);
        if($ok) $this->json([],204);
        else $this->json(['error'=>'Não foi possível deletar'],500);
    }
}
