<?php

namespace App\Imports;

use App\Models\DichVu;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DichVuImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['ten_dich_vu'])) {
            return null;
        }

        return new DichVu([
            'tendichvu'       => $row['ten_dich_vu'],
            'tendichvu_slug'  => Str::slug($row['ten_dich_vu']), 
            'danhmuc_id'      => $row['id_danh_muc'], 
            'motadichvu'      => $row['mo_ta'] ?? null,
            'dongia'          => $row['don_gia'] ?? 0,
            'dongia_toida'    => $row['don_gia_toi_da'] ?? null,
            'donvitinh'       => $row['don_vi_tinh'] ?? 'kg',
            'la_gia_dao_dong' => isset($row['la_gia_dao_dong']) ? $row['la_gia_dao_dong'] : 0,
            'hinhanh'         => $row['hinhanh'] ?? null, 
            'motadichvu'         => $row['motadichvu'] ?? null,
        
        ]);
    }
}