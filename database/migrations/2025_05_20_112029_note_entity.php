<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('note_table', function (Blueprint $table) {
            $table->id(); // auto-incremental
            $table->string('header');
            $table->text('text');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('timestamp');
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('note_table');
    }
};
