<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonDatLich extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'don_dat_lichs';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tinhTrang()
    {
        return $this->belongsTo(TinhTrang::class, 'tinhtrang_id');
    }

    public function maGiamGia()
    {
        return $this->belongsTo(MaGiamGia::class, 'magiamgia_id');
    }

    public function chiTietDonDatLichs()
    {
        return $this->hasMany(ChiTietDonDatLich::class, 'dondatlich_id');
    }

    public function danhGias()
    {
        return $this->hasMany(DanhGia::class, 'dondatlich_id');
    }

   
}