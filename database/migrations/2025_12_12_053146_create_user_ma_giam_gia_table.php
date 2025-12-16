<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_ma_giam_gia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('ma_giam_gia_id')->constrained('ma_giam_gias')->onDelete('cascade');
            $table->boolean('is_used')->default(false);
            $table->timestamp('ngay_luu')->useCurrent();
            $table->unique(['user_id', 'ma_giam_gia_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_ma_giam_gia');
    }
};