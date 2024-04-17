<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pedido extends Model
{
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function contato()
    {
        return $this->belongsTo(Contato::class);
    }
}