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
            $table->decimal('valor',8,2)->change();
        });

        Schema::table('pedidos', function (Blueprint $table) {
            $table->decimal('total',8,2)->nullable()->change();
            $table->decimal('frete',8,2)->nullable()->change();
        });

        Schema::table('pedidos_produtos', function (Blueprint $table) {
            $table->decimal('valor',8,2)->change();
            $table->decimal('desconto',8,2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropColumn('valor',8,2);
        });

        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn('total',8,2);
            $table->dropColumn('frete',8,2);
        });

        Schema::table('pedidos_produtos', function (Blueprint $table) {
            $table->dropColumn('valor',8,2);
            $table->dropColumn('desconto',8,2);
        });
    }
};
