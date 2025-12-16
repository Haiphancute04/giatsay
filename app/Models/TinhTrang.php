<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinhTrang extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function donDatLichs()
    {
        return $this->hasMany(DonDatLich::class, 'tinhtrang_id');
    }
}