<?php

namespace App\Http\Controllers;

use App\Models\DichVu;
use App\Models\DanhMuc;
use Illuminate\Http\Request;

class DichVuController extends Controller
{
    public function show(DichVu $dichVu)
    {
        $danhGias = $dichVu->danhGias()
                            ->where('trangthai', true)
                            ->with('user') 
                            ->latest()
                            ->paginate(5);

        $dichVuLienQuan = DichVu::where('danhmuc_id', $dichVu->danhmuc_id)
                                ->where('id', '!=', $dichVu->id) 
                                ->take(4)
                                ->get();

        return view('dichvu.show', compact('dichVu', 'danhGias', 'dichVuLienQuan'));
    }

    public function showByCategory(DanhMuc $danhMuc)
    {
        $danhMucs = DanhMuc::all();
        $dichVus = $danhMuc->dichVus()->paginate(12);
        return view('danhmuc.show', compact('danhMuc', 'danhMucs', 'dichVus'));
    }
}