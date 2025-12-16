<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaGiamGia extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function donDatLichs()
    {
        return $this->hasMany(DonDatLich::class, 'magiamgia_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_ma_giam_gia', 'ma_giam_gia_id', 'user_id');
    }

    public function isCollectedByUser($userId)
    {
        return $this->users()->where('user_id', $userId)->exists();
    }
}