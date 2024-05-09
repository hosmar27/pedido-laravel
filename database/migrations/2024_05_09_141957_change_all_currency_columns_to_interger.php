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
        Schema::table('produtos', function (Blueprint $table) {
            $table->integer('valor')->change();
        });

        Schema::table('pedidos', function (Blueprint $table) {
            $table->integer('total')->nullable()->change();
            $table->integer('frete')->nullable()->change();
        });

        Schema::table('pedidos_produtos', function (Blueprint $table) {
            $table->integer('valor')->change();
            $table->integer('desconto')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('interger', function (Blueprint $table) {
            //
        });
    }
};
