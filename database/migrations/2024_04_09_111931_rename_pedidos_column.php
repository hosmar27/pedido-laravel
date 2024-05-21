<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pedidos', function(Blueprint $table){
            $table->renameColumn('clientes_id', 'cliente_id');
            $table->renameColumn('contatos_id', 'contato_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos', function(Blueprint $table){
            $table->renameColumn('cliente_id', 'clientes_id');
            $table->renameColumn('contato_id', 'contatos_id');
        });
    }
};
