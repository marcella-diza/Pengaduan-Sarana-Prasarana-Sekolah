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
        Schema::table('complaints', function (Blueprint $table) {
            $table->string('prioritas', 20)->default('Sedang');
            $table->string('petugas', 100)->nullable();
            $table->dateTime('estimasi_selesai')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropColumn(['prioritas', 'petugas', 'estimasi_selesai']);
        });
    }
};
