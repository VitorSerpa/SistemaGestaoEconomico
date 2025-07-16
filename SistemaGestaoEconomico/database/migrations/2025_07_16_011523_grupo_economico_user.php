<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grupo_economico_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('id_grupo');
            $table->foreign('id_grupo')->references('id_grupo')->on('grupoEconomico')->onDelete('cascade');
            $table->primary(['user_id', 'id_grupo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grupo_economico_user');
    }
};
