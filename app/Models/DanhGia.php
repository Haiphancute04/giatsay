<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dichVu()
    {
        return $this->belongsTo(DichVu::class, 'dichvu_id');
    }

    public function donDatLich()
    {
        return $this->belongsTo(DonDatLich::class, 'dondatlich_id');
    }
}