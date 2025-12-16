<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Banner extends Model
{
    protected $fillable = [
        'image', 
        'title_vi', 'title_en', 
        'description_vi', 'description_en', 
        'link', 'order', 'is_active'
    ];

    public function getTitleAttribute()
    {
        $locale = App::getLocale();
        
        if ($locale == 'en') {
            return $this->attributes['title_en'];
        }

        return $this->attributes['title_vi'];
    }

    public function getDescriptionAttribute()
    {
        $locale = App::getLocale();
        
        if ($locale == 'en') {
            return $this->attributes['description_en'];
        }

        return $this->attributes['description_vi'];
    }
}