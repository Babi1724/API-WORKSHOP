<?php
namespace App\Models;
use App\Core\Model;

class Inscricao extends Model
{
    public ?int $id = null;
    public int $usuario_id;
    public int $workshop_id;
    public ?string $inscrito_em = null;

    public function __construct(array $data = [])
    {
        foreach($data as $k=>$v){
            if(property_exists($this,$k)) $this->{$k}=$v;
        }
    }
}