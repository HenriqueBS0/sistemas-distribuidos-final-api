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
        Schema::create('tarefas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 75);
            $table->text('descricao');
            $table->enum('estado', ['criada', 'iniciada', 'concluida'])->default('criada');
            $table->foreignId('projeto_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['projeto_id', 'titulo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tarefas');
    }
};
