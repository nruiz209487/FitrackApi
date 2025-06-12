<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla de notas
     * Esta tabla almacena las notas de los usuarios, incluyendo el encabezado, el texto, el ID del usuario y la marca de tiempo.
     * La tabla también incluye una referencia al usuario que creó la nota, lo que permite asociar cada nota con un usuario específico.
     * Además, la tabla utiliza el método `constrained` para establecer una relación de clave foránea con la tabla de usuarios, asegurando que las notas estén asociadas a usuarios existentes.
     */
    public function up(): void
    {
        Schema::create('note_table', function (Blueprint $table) {
            $table->id(); 
            $table->string('header');
            $table->text('text');
            $table->foreignId('userId')->constrained('users')->onDelete('cascade');
            $table->string('timestamp');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('note_table');
    }
};
