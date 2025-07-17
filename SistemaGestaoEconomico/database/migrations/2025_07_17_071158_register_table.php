<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logs_grupos', function (Blueprint $table) {
            $table->id();
            $table->string('grupo');   // Pode ser ID ou nome do grupo
            $table->string('acao');    // Ex: criado, atualizado, deletado
            $table->timestamp('hora')->useCurrent(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_table');
    }
};
