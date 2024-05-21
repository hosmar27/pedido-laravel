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

    public static function total($query) {
        $query = PedidoProduto::select("SELECT pedidos.id, pedidos_produtos.pedido_id, pedidos_produtos.valor, pedidos_produtos.quantidade, pedidos_produtos.desconto,
        ((valor-desconto)*quantidade) AS pedidos_produtos.total
        FROM `pedidos_produtos`
        JOIN `pedidos` ON pedidos_produtos.pedido_id = pedidos.id
        AND pedidos.deleted_at IS NULL
        AND pedidos_produtos.deleted_at;")->find();
        $total = collect($query)->toArray();

        return $total;
    }


}