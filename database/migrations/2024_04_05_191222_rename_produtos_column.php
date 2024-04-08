<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('produtos', function(Blueprint $table) {
            $table->renameColumn('quantidade', 'estoque');
        });
    }


    public function down()
    {
        Schema::dropIfExists('produtos.estoque');
    }
};