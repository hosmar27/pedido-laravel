<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('pedidos', function(Blueprint $table) {
            $table->renameColumn('clientes_id', 'cliente_id');
            $table->renameColumn('contatos_id', 'contato_id');
        });
    }


    public function down()
    {
        Schema::table('pedidos', function(Blueprint $table) {
            $table->renameColumn('cliente_id', 'clientes_id');
            $table->renameColumn('contato_id', 'contatos_id');
        });
    }

};