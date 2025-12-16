<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DichVu;
use App\Models\DanhMuc;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DichVuExport;
use App\Imports\DichVuImport;
class DichVuController extends Controller
{
    public function index()
    {
        $dichVus = DichVu::with('danhMuc')->latest()->paginate(10);
        return view('admin.dichvus.index', compact('dichVus'));
    }

    public function create()
    {
        $danhMucs = DanhMuc::all();
        return view('admin.dichvus.create', compact('danhMucs'));
    }

    public function store(Request $request)
    {
        $isVariable = $request->has('la_gia_dao_dong');

        $validated = $request->validate([
            'tendichvu' => 'required|string|max:191|unique:dich_vus',
            'danhmuc_id' => 'required|exists:danh_mucs,id',
            'donvitinh' => 'required|string|max:50',
            'motadichvu' => 'nullable|string',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dongia' => 'required|numeric|min:0',
            'dongia_toida' => $isVariable ? 'required|numeric|gt:dongia' : 'nullable|numeric',
        ], [
            'dongia_toida.required' => __('Please enter max price.'),
            'dongia_toida.gt' => __('Max price must be greater than min price.'),
        ]);

        $dataPath = null;
        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $filename = $file->getClientOriginalName(); 
            $dataPath = $file->storeAs('dichvu', $filename, 'public');
        }

        DichVu::create([
            'tendichvu' => $validated['tendichvu'],
            'tendichvu_slug' => Str::slug($validated['tendichvu']),
            'danhmuc_id' => $validated['danhmuc_id'],
            'dongia' => $validated['dongia'],
            'la_gia_dao_dong' => $isVariable ? 1 : 0, 
            'dongia_toida' => $isVariable ? $validated['dongia_toida'] : null,
            'donvitinh' => $validated['donvitinh'],
            'motadichvu' => $validated['motadichvu'],
            'hinhanh' => $dataPath,
        ]);

        return redirect()->route('admin.dich-vus.index')->with('success', __('Service created successfully!'));
    }

    public function edit(DichVu $dichVu)
    {
        $danhMucs = DanhMuc::all();
        return view('admin.dichvus.edit', compact('dichVu', 'danhMucs'));
    }

    public function update(Request $request, DichVu $dichVu)
    {
        $isVariable = $request->has('la_gia_dao_dong');

        $validated = $request->validate([
            'tendichvu' => 'required|string|max:191|unique:dich_vus,tendichvu,' . $dichVu->id,
            'danhmuc_id' => 'required|exists:danh_mucs,id',
            'donvitinh' => 'required|string|max:50',
            'motadichvu' => 'nullable|string',
            'hinhanh' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dongia' => 'required|numeric|min:0',
            'dongia_toida' => $isVariable ? 'required|numeric|gt:dongia' : 'nullable|numeric',
        ], [
            'dongia_toida.required' => __('Please enter max price.'),
            'dongia_toida.gt' => __('Max price must be greater than min price.'),
        ]);

        $dataPath = $dichVu->hinhanh;
        if ($request->hasFile('hinhanh')) {
            if ($dichVu->hinhanh) {
                Storage::disk('public')->delete($dichVu->hinhanh);
            }
            $file = $request->file('hinhanh');
            $filename = $file->getClientOriginalName(); 
            $dataPath = $file->storeAs('dichvu', $filename, 'public');
        }

        $dichVu->update([
            'tendichvu' => $validated['tendichvu'],
            'tendichvu_slug' => Str::slug($validated['tendichvu']),
            'danhmuc_id' => $validated['danhmuc_id'],
            'dongia' => $validated['dongia'],
            'la_gia_dao_dong' => $isVariable ? 1 : 0,
            'dongia_toida' => $isVariable ? $validated['dongia_toida'] : null,
            'donvitinh' => $validated['donvitinh'],
            'motadichvu' => $validated['motadichvu'],
            'hinhanh' => $dataPath,
        ]);

        return redirect()->route('admin.dich-vus.index')->with('success', __('Service updated successfully!'));
    }

    public function destroy(DichVu $dichVu)
    {
        try {
             if ($dichVu->hinhanh) {
                Storage::disk('public')->delete($dichVu->hinhanh);
            }
            $dichVu->delete();
            return redirect()->route('admin.dich-vus.index')->with('success', __('Service deleted successfully!'));
        } catch (\Exception $e) {
            return redirect()->route('admin.dich-vus.index')->with('error', __('Cannot delete! Service used in orders.'));
        }
    }
    public function export()
    {
        return Excel::download(new DichVuExport, 'danh-sach-dich-vu.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);

        try {
            Excel::import(new DichVuImport, $request->file('file'));
            return redirect()->route('admin.dich-vus.index')->with('success', 'Nhập dữ liệu thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin.dich-vus.index')->with('error', 'Lỗi nhập file: ' . $e->getMessage());
        }
    }
}