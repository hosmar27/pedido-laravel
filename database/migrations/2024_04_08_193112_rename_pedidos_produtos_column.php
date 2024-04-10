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
        Schema::table('stnk', function(Blueprint $table) {
            $table->renameColumn('id_stnk', 'id');
        });
    }

};