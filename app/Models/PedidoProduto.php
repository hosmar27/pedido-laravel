<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PedidoProduto extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'pedidos_produtos';

    protected $casts = [
        'decimal:2' => 'double',
    ];

    public function pedidos_produtos():HasMany
    {
        return $this->hasMany(PedidoProduto::class);
    }
}
