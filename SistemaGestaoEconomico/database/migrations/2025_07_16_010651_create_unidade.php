<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('Unidade', function (Blueprint $table) {
            $table->id("id_unidade");
            $table->string('nome_fantasia', 100);
            $table->string('razao_social', 100);
            $table->string('CNPJ', 14);
            $table->unsignedBigInteger('id_bandeira');
            $table->dateTime('data_criacao');
            $table->dateTime('ultima_atualizacao');

            $table->foreign('id_bandeira')
                  ->references('id_bandeira')->on('Bandeira')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Unidade');
    }
};