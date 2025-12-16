<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('danh_gias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->foreignId('dichvu_id')->constrained('dich_vus')->onDelete('cascade'); 
            $table->foreignId('dondatlich_id')->nullable()->constrained('don_dat_lichs')->onDelete('set null');
            $table->unsignedTinyInteger('rating'); 
            $table->text('binhluan')->nullable(); 
            $table->boolean('trangthai')->default(false);
            $table->timestamps();
            $table->unique(['user_id', 'dichvu_id', 'dondatlich_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('danh_gias');
        
    }
    
};
