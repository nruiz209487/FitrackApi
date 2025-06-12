<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de ubicaciones objetivo
     * Esta tabla almacena las ubicaciones objetivo para los usuarios, incluyendo el nombre, la posición y el radio en metros.
     * La tabla también incluye una referencia al usuario que creó la ubicación, lo que permite asociar cada ubicación con un usuario específico.
     */
    public function up(): void
    {
        Schema::create('target_location_table', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->float('radiusMeters');
            $table->foreignId('userId')->constrained('users')->onDelete('cascade');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_location_table');
    }
};
