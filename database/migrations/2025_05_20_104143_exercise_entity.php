<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * crea la tabla de ejercicios
     * Esta tabla almacena los ejercicios disponibles en la aplicación, incluyendo su nombre, descripción e imagen.
     */
    public function up(): void
    {
        Schema::create('exercise_table', function (Blueprint $table) {
            $table->id(); 
            $table->string('name');
            $table->text('description');
            $table->string('imageUri');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_table');
    }
};
