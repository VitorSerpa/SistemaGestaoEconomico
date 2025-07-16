<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('Bandeira', function (Blueprint $table) {
            $table->id("id_bandeira");
            $table->string('nome_bandeira', 100);
            $table->unsignedBigInteger('id_grupo');
            $table->dateTime('data_criacao');
            $table->dateTime('ultima_atualizacao');

            $table->foreign('id_grupo')
                  ->references('id_grupo')->on('grupoEconomico')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Bandeira');
    }
};