<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanhGia;
use Illuminate\Http\Request;

class DanhGiaController extends Controller
{
    public function index()
    {
        $danhGias = DanhGia::with(['user', 'dichVu'])
                            ->latest()
                            ->paginate(15);
                            
        return view('admin.danhgias.index', compact('danhGias'));
    }

    public function toggleStatus(DanhGia $danhGia)
    {
        $danhGia->trangthai = !$danhGia->trangthai;
        $danhGia->save();
        return redirect()->route('admin.danhgias.index')
                         ->with('success', __('Review status updated successfully!'));
    }

    public function destroy(DanhGia $danhGia)
    {
        $danhGia->delete();
        return redirect()->route('admin.danhgias.index')
                         ->with('success', __('Review deleted successfully!'));
    }
}