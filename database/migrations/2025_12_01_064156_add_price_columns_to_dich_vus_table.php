<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dich_vus', function (Blueprint $table) {
            $table->boolean('la_gia_dao_dong')->default(false)->after('dongia');
            $table->decimal('dongia_toida', 15, 2)->nullable()->after('la_gia_dao_dong'); 
        });
    }

    public function down(): void
    {
        Schema::table('dich_vus', function (Blueprint $table) {
            $table->dropColumn(['la_gia_dao_dong', 'dongia_toida']);
        });
    }
};
