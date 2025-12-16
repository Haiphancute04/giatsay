<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaGiamGia;
use Illuminate\Http\Request;

class MaGiamGiaController extends Controller
{
    public function index()
    {
        $maGiamGias = MaGiamGia::latest()->paginate(10);
        return view('admin.magiamgias.index', compact('maGiamGias'));
    }

    public function create()
    {
        return view('admin.magiamgias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ma_code' => 'required|string|max:191|unique:ma_giam_gias',
            'loai_giamgia' => 'required|in:percent,fixed',
            'giatri' => 'required|numeric|min:0',
            'dieukien_toithieu' => 'nullable|numeric|min:0',
            'soluong_phathanh' => 'required|integer|min:1',
            'ngay_batdau' => 'nullable|date',
            'ngay_ketthuc' => 'nullable|date|after_or_equal:ngay_batdau',
            'trangthai' => 'required|boolean',
        ]);

        MaGiamGia::create($validated);

        return redirect()->route('admin.ma-giam-gias.index')->with('success', __('Coupon created successfully!'));
    }

    public function edit(MaGiamGia $maGiamGia)
    {
        return view('admin.magiamgias.edit', compact('maGiamGia'));
    }

    public function update(Request $request, MaGiamGia $maGiamGia)
    {
        $validated = $request->validate([
            'ma_code' => 'required|string|max:191|unique:ma_giam_gias,ma_code,' . $maGiamGia->id,
            'loai_giamgia' => 'required|in:percent,fixed',
            'giatri' => 'required|numeric|min:0',
            'dieukien_toithieu' => 'nullable|numeric|min:0',
            'soluong_phathanh' => 'required|integer|min:1',
            'ngay_batdau' => 'nullable|date',
            'ngay_ketthuc' => 'nullable|date|after_or_equal:ngay_batdau',
            'trangthai' => 'required|boolean',
        ]);

        $maGiamGia->update($validated);

        return redirect()->route('admin.ma-giam-gias.index')->with('success', __('Coupon updated successfully!'));
    }

    public function destroy(MaGiamGia $maGiamGia)
    {
        try {
            $maGiamGia->delete();
            return redirect()->route('admin.ma-giam-gias.index')->with('success', __('Coupon deleted successfully!'));
        } catch (\Exception $e) {
            return redirect()->route('admin.ma-giam-gias.index')->with('error', __('Cannot delete! Coupon used in orders.'));
        }
    }
}