<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class pedido extends Model
{
    use SoftDeletes;

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function contato()
    {
        return $this->belongsTo(Contato::class);
    }
}