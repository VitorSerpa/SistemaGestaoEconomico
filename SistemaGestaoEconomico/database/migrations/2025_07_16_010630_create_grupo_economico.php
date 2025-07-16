<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grupoEconomico', function (Blueprint $table) {
            $table->id("id_grupo");
            $table->string('nome_grupo', 100);
            $table->dateTime('data_criacao');
            $table->dateTime('ultima_atualizacao');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grupoEconomico');
    }
};