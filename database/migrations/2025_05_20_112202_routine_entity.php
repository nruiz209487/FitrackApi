<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de rutinas
     * Esta tabla almacena las rutinas de ejercicios, incluyendo su nombre, descripción, imagen y los IDs de los ejercicios asociados.
     * La tabla también incluye una referencia al usuario que creó la rutina, lo que permite asociar cada rutina con un usuario específico.
     */
    public function up(): void
    {
        Schema::create('routine_table', function (Blueprint $table) {
            $table->id(); 
            $table->string('name');
            $table->text('description');
            $table->string('imageUri');
            $table->string('exerciseIds');
            $table->foreignId('userId')->constrained('users')->onDelete('cascade');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routine_table');
    }
};
