<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DanhMuc;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DanhMucController extends Controller
{
    public function index()
    {
        $danhMucs = DanhMuc::latest()->paginate(10);
        return view('admin.danhmucs.index', compact('danhMucs'));
    }

    public function create()
    {
        return view('admin.danhmucs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tendanhmuc' => 'required|string|max:191|unique:danh_mucs',
        ]);

        DanhMuc::create([
            'tendanhmuc' => $validated['tendanhmuc'],
            'tendanhmuc_slug' => Str::slug($validated['tendanhmuc']),
        ]);

        return redirect()->route('admin.danh-mucs.index')->with('success', __('Category created successfully!'));
    }

    public function show(DanhMuc $danhMuc)
    {

    }

    public function edit(DanhMuc $danhMuc) 
    {
        return view('admin.danhmucs.edit', compact('danhMuc'));
    }

    public function update(Request $request, DanhMuc $danhMuc)
    {
        $validated = $request->validate([
            'tendanhmuc' => 'required|string|max:191|unique:danh_mucs,tendanhmuc,' . $danhMuc->id,
        ]);

        $danhMuc->update([
            'tendanhmuc' => $validated['tendanhmuc'],
            'tendanhmuc_slug' => Str::slug($validated['tendanhmuc']),
        ]);

        return redirect()->route('admin.danh-mucs.index')->with('success', __('Category updated successfully!'));
    }

    public function destroy(DanhMuc $danhMuc)
    {
        try {
            $danhMuc->delete();
            return redirect()->route('admin.danh-mucs.index')->with('success', __('Category deleted successfully!'));
        } catch (\Exception $e) {
            return redirect()->route('admin.danh-mucs.index')->with('error', __('Cannot delete! Category has services.'));
        }
    }
}