<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dich_vus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('danhmuc_id')->constrained('danh_mucs')->onDelete('restrict'); 
            
            $table->string('tendichvu')->index(); 
            $table->string('tendichvu_slug')->unique(); 
            $table->text('motadichvu')->nullable();
            $table->decimal('dongia', 15, 2)->unsigned()->default(0); 
            $table->string('donvitinh');
            $table->string('hinhanh')->nullable();
            $table->decimal('rating_trungbinh', 3, 2)->default(0); 
            $table->unsignedInteger('soluong_danhgia')->default(0);
            $table->timestamps();
        });
    }
	
    public function down(): void
    {
        Schema::dropIfExists('dich_vus');
    }
};
