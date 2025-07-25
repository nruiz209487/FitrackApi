<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * crea la tabla de registro de ejercicios
     * Esta tabla almacena el registro de ejercicios realizados por los usuarios, incluyendo el ID del ejercicio, la fecha, el peso utilizado y las repeticiones.
     * La tabla también incluye una referencia al usuario que realizó el ejercicio, lo que permite asociar cada registro con un usuario específico.
     */
    public function up(): void
    {
        Schema::create('exercise_log_table', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('exerciseId');
            $table->string('date');
            $table->float('weight');
            $table->integer('reps');
            $table->foreignId('userId')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_log_table');
    }
};
