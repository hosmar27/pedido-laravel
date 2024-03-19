<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contato;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class ContatoController extends Controller
{
    public function up(): void
    {
        Schema::create('contatos', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable();
            $table->string('cpf')->unique();
            $table->string('telefone')->unique();
            $table->string('email')->unique();
            $table->string('login')->unique();
            $table->string('senha');
            $table->string('cliente')->unique();
            $table->timestamps();
        });
    }
}
