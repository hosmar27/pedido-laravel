<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::table('pedidos_produtos', function(Blueprint $table) {
            $table->renameColumn('pedido_id', 'pedidos_id');
            $table->renameColumn('produto_id', 'produtos_id');
        });
    }


    public function down()
    {
        Schema::table('pedidos_produtos', function(Blueprint $table) {
            $table->renameColumn('pedidos_id', 'pedido_id');
            $table->renameColumn('produtos_id', 'produto_id');
        });
    }

};