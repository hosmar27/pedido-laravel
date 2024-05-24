<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['pedidos_produtos'];

    protected $table = 'pedidos';

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function contato()
    {
        return $this->belongsTo(Contato::class);
    }

    public function pedidos_produtos()
    {
        return $this->hasMany(PedidoProduto::class);
    }
}