<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('don_dat_lichs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('tenkhachhang');
            $table->string('sdt_khachhang')->index();
            $table->text('diachigiaonhan');
			$table->timestamp('thoi_gian_lay_hang')->nullable(); 
			$table->timestamp('thoi_gian_giao_hang_du_kien')->nullable(); 
            $table->decimal('tamtinh', 15, 2)->unsigned(); 
            $table->foreignId('magiamgia_id')->nullable()->constrained('ma_giam_gias')->onDelete('set null');
            $table->decimal('tien_giamgia', 15, 2)->unsigned()->default(0); 
            $table->decimal('tongtien', 15, 2)->unsigned(); 
            $table->foreignId('tinhtrang_id')->constrained('tinh_trangs')->default(1); 
			$table->boolean('trangthai_danhgia')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('don_dat_lichs');
        
    }
};
