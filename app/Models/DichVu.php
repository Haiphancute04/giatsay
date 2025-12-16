<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DichVu extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'la_gia_dao_dong' => 'boolean',
        'dongia' => 'decimal:2',
        'dongia_toida' => 'decimal:2',
    ];

    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'danhmuc_id');
    }

    public function chiTietDonDatLichs()
    {
        return $this->hasMany(ChiTietDonDatLich::class, 'dichvu_id');
    }

    public function danhGias()
    {
        return $this->hasMany(DanhGia::class, 'dichvu_id');
    }
}