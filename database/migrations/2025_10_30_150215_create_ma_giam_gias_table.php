<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ma_giam_gias', function (Blueprint $table) {
            $table->id();
			$table->string('ma_code')->unique(); 
            $table->enum('loai_giamgia', ['percent', 'fixed'])->default('fixed'); 
            $table->decimal('giatri', 15, 2); 
            $table->decimal('dieukien_toithieu', 15, 2)->unsigned()->nullable(); 
            $table->integer('soluong_phathanh')->unsigned(); 
            $table->integer('soluong_dasudung')->unsigned()->default(0);
            $table->timestamp('ngay_batdau')->nullable(); 
            $table->timestamp('ngay_ketthuc')->nullable();
            $table->boolean('trangthai')->default(true);
            $table->timestamps();
        });
    }
	
    public function down(): void
    {
        Schema::dropIfExists('ma_giam_gias');
    }
};
