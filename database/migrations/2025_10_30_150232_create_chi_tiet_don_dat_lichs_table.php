<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('chi_tiet_don_dat_lichs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dondatlich_id')->constrained('don_dat_lichs')->onDelete('cascade');
            $table->foreignId('dichvu_id')->constrained('dich_vus')->onDelete('restrict');
            $table->string('tendichvu'); 
            $table->decimal('soluong', 10, 2)->unsigned()->default(1); 
            $table->decimal('dongia', 15, 2)->unsigned(); 
            $table->decimal('thanhtien', 15, 2)->unsigned();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('chi_tiet_don_dat_lichs');
    }
};
