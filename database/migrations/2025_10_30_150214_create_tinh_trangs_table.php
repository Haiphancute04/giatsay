<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tinh_trangs', function (Blueprint $table) {
            $table->id();
			$table->string('ten_trangthai'); 
            $table->string('ten_hienthi')->nullable(); 
            $table->string('mau_sac')->default('secondary'); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tinh_trangs');
    }
};
