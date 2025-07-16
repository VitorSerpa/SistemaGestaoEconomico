<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('Colaborador', function (Blueprint $table) {
            $table->id("id_colaborador");
            $table->string('nome', 100);
            $table->string('email', 150);
            $table->string('CPF', 14);
            $table->unsignedBigInteger('id_unidade');
            $table->dateTime('data_criacao');
            $table->dateTime('ultima_atualizacao');

            $table->foreign('id_unidade')
                  ->references('id_unidade')->on('Unidade')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Colaborador');
    }
};