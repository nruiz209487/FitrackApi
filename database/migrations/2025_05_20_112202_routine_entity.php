<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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

    public function down(): void
    {
        Schema::dropIfExists('routine_table');
    }
};
