<?php
declare(strict_types=1);

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../config/database.php';

use App\Controllers\WorkshopController;
use App\Controllers\UsuarioController;
use App\Controllers\InscricaoController;

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri,'/');
$parts = explode('/', ltrim($uri,'/'));

$pdo = getPDO();

try {
    // Rota base
    $entity = $parts[0] ?? '';
    $id = isset($parts[1]) && is_numeric($parts[1]) ? (int)$parts[1] : null;
    $action = $parts[1] ?? '';

    switch($entity){
        case 'workshops':
            $controller = new WorkshopController($pdo);
            if($method==='GET' && !$id) $controller->index();
            elseif($method==='GET' && $id) $controller->show($id);
            elseif($method==='POST') $controller->store();
            elseif(($method==='PUT'||$method==='PATCH') && $id) $controller->update($id);
            elseif($method==='DELETE' && $id) $controller->delete($id);
            else http_response_code(405);
            break;

        case 'usuarios':
            $controller = new UsuarioController($pdo);
            if($method==='GET' && !$id) $controller->index();
            elseif($method==='GET' && $id) $controller->show($id);
            elseif($method==='POST') $controller->store();
            elseif(($method==='PUT'||$method==='PATCH') && $id) $controller->update($id);
            elseif($method==='DELETE' && $id) $controller->delete($id);
            else http_response_code(405);
            break;

        case 'inscricoes':
            $controller = new InscricaoController($pdo);
            if($method==='GET' && $id) $controller->show($id);
            elseif($method==='GET' && isset($_GET['usuario_id'])) $controller->listByUsuario((int)$_GET['usuario_id']);
            elseif($method==='POST') $controller->store();
            elseif($method==='DELETE' && $id) $controller->delete($id);
            else http_response_code(405);
            break;

        default:
            http_response_code(404);
            echo json_encode(['error'=>'Rota não encontrada']);
    }

} catch(Exception $e){
    http_response_code(500);
    echo json_encode(['error'=>'Erro interno','message'=>$e->getMessage()]);
}
