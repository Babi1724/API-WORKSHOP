<?php
namespace App\Models;
use App\Core\Model;

class Usuario extends Model
{
    public ?int $id = null;
    public string $nome;
    public string $email;
    public string $senha;
    public ?string $created_at = null;

    public function __construct(array $data = [])
    {
        foreach($data as $k=>$v){
            if(property_exists($this,$k)) $this->{$k}=$v;
        }
    }
}