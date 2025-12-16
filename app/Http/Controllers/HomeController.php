<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\DichVu;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{

    public function index()
    {
        $locale = App::getLocale(); 
        $checkField = ($locale == 'en') ? 'title_en' : 'title_vi';

        $banners = Banner::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();
        
        $danhMucs = DanhMuc::with(['dichVus' => function($query) {
            $query->orderBy('dongia', 'asc'); 
        }])->get();

        $dichVuNoiBat = DichVu::withAvg(['danhGias' => function($query) {
                                    $query->where('trangthai', true); 
                                }], 'rating') 
                                ->withCount(['danhGias' => function($query) {
                                    $query->where('trangthai', true);
                                }]) 
                                ->orderByDesc('danh_gias_avg_rating') 
                                ->take(8)
                                ->get();

        return view('home', compact('banners', 'danhMucs', 'dichVuNoiBat'));
    }
}