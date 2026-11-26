<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Aman dijalankan walau tabel sudah ada.
        if (Schema::hasTable('complaint_histories')) {
            return;
        }

        Schema::create('complaint_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('complaint_id')->index();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('status', 30);
            $table->text('catatan')->nullable();
            $table->boolean('notified')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('complaint_histories');
    }
};