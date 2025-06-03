<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exercise_log_table', function (Blueprint $table) {
            $table->id(); // auto-incremental PK
            $table->unsignedBigInteger('exerciseId');
            $table->string('date');
            $table->float('weight');
            $table->integer('reps');
            $table->foreignId('userId')->constrained('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercise_log_table');
    }
};
