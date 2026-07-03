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
        Schema::table('vehiculos', function (Blueprint $table) {
            if (!Schema::hasColumn('vehiculos', 'nombre')) {
                $table->string('nombre')->nullable()->after('matricula');
            }
            if (!Schema::hasColumn('vehiculos', 'placa')) {
                $table->string('placa')->nullable()->after('nombre');
            }
            if (!Schema::hasColumn('vehiculos', 'concesionario')) {
                $table->string('concesionario')->nullable()->after('serie');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehiculos', function (Blueprint $table) {
            $table->dropColumn(['nombre', 'placa', 'concesionario']);
        });
    }
};
