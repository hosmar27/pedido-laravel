<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class produto extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'produtos';

    public function pedidos_produtos():HasMany
    {
        return $this->hasMany(PedidoProduto::class);
    }

    public function setTotalAttribute()
    {
        $this->attributes['total'] = $this->quantidade * $this->valor;
    }

}
