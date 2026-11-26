<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
Schema::create('complaints', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->string('nis')->nullable(); 
    $table->string('kategori', 50);
    $table->string('lokasi', 120);
    $table->string('judul', 150);
    $table->text('isi');
    $table->string('foto')->nullable();
    $table->string('status', 20)->default('Menunggu')->index();
    $table->text('tanggapan')->nullable();
    $table->foreignId('ditangani_oleh')->nullable()->constrained('users')->nullOnDelete();
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};