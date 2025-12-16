<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\DanhMuc;
use App\Models\DichVu;
use App\Models\MaGiamGia;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(TinhTrangSeeder::class);

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin', 
            'password' => bcrypt('123456'),
        ]);

        User::factory(10)->create();
        DanhMuc::factory(5)->create();
        DichVu::factory(30)->create();
        MaGiamGia::factory(10)->create();
    }
}