<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $table = 'clientes';

    protected $cascadeDeletes = ['Contato','Pedido'];

    protected $fillable = ['id','nome'];

    public function Contato()
    {
        return $this->hasMany(Contato::class);
    }

    public function Pedido()
    {
        return $this->hasMany(Pedido::class);
    }
}
