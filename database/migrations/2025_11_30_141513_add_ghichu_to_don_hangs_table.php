<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('don_dat_lichs', function (Blueprint $table) {
            $table->text('ghichu')->nullable()->after('diachigiaonhan');
        });
    }

    public function down(): void
    {
        Schema::table('don_dat_lichs', function (Blueprint $table) {
            $table->dropColumn('ghichu');
        });
    }
    
};
