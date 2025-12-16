<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDonDatLich extends Model
{
    use HasFactory;
    protected $table = 'chi_tiet_don_dat_lichs';
    protected $guarded = [];

    public function donDatLich()
    {
        return $this->belongsTo(DonDatLich::class, 'dondatlich_id');
    }

    public function dichVu()
    {
        return $this->belongsTo(DichVu::class, 'dichvu_id');
    }
}