<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('logs_grupos', function (Blueprint $table) {
            $table->string('objeto')->nullable()->after('grupo');
        });
    }

    public function down(): void
    {
        Schema::table('logs_grupos', function (Blueprint $table) {
            $table->dropColumn('objeto');
        });
    }
};
