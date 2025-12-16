<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TinhTrang; 

class TinhTrangSeeder extends Seeder
{
    public function run(): void
    {
        TinhTrang::create(['ten_trangthai' => 'Chờ xử lý', 'ten_hienthi' => 'Chờ xử lý', 'mau_sac' => 'warning']);
        TinhTrang::create(['ten_trangthai' => 'Đang giặt ủi', 'ten_hienthi' => 'Đang xử lý', 'mau_sac' => 'info']);
        TinhTrang::create(['ten_trangthai' => 'Đang giao hàng', 'ten_hienthi' => 'Đang giao', 'mau_sac' => 'primary']);
        TinhTrang::create(['ten_trangthai' => 'Đã hoàn thành', 'ten_hienthi' => 'Hoàn thành', 'mau_sac' => 'success']);
        TinhTrang::create(['ten_trangthai' => 'Đã hủy', 'ten_hienthi' => 'Đã hủy', 'mau_sac' => 'danger']);
    }
}