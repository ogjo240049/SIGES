<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->dropForeign(['id_inventario']);
        });

        Schema::table('compras', function (Blueprint $table) {
            $table->unsignedBigInteger('id_inventario')->nullable()->change();
            $table->foreign('id_inventario')
                ->references('id_inventario')
                ->on('inventarios')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('compras')
            ->whereNull('id_inventario')
            ->delete();

        Schema::table('compras', function (Blueprint $table) {
            $table->dropForeign(['id_inventario']);
        });

        Schema::table('compras', function (Blueprint $table) {
            $table->unsignedBigInteger('id_inventario')->nullable(false)->change();
            $table->foreign('id_inventario')
                ->references('id_inventario')
                ->on('inventarios');
        });
    }
};
