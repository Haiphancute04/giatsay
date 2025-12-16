<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TinhTrang;
use Illuminate\Http\Request;

class TinhTrangController extends Controller
{
    public function index()
    {
        $tinhTrangs = TinhTrang::paginate(10);
        return view('admin.tinhtrangs.index', compact('tinhTrangs'));
    }

    public function create()
    {
        return view('admin.tinhtrangs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ten_trangthai' => 'required|string|max:191|unique:tinh_trangs,ten_trangthai',
            'ten_hienthi' => 'nullable|string|max:191',
            'mau_sac' => 'required|string', 
        ]);

        TinhTrang::create($validated);

        return redirect()->route('admin.tinh-trangs.index')->with('success', __('Status added successfully!'));
    }

    public function edit(TinhTrang $tinhTrang)
    {
        return view('admin.tinhtrangs.edit', compact('tinhTrang'));
    }

    public function update(Request $request, TinhTrang $tinhTrang)
    {
        $validated = $request->validate([
            'ten_trangthai' => 'required|string|max:191|unique:tinh_trangs,ten_trangthai,' . $tinhTrang->id,
            'ten_hienthi' => 'nullable|string|max:191',
            'mau_sac' => 'required|string',
        ]);

        $tinhTrang->update($validated);

        return redirect()->route('admin.tinh-trangs.index')->with('success', __('Status updated successfully!'));
    }

    public function destroy(TinhTrang $tinhTrang)
    {
        try {
            if($tinhTrang->donDatLichs()->count() > 0){
                return redirect()->route('admin.tinh-trangs.index')->with('error', __('Cannot delete! Status used in orders.'));
            }
            
            $tinhTrang->delete();
            return redirect()->route('admin.tinh-trangs.index')->with('success', __('Status deleted successfully!'));
        } catch (\Exception $e) {
            return redirect()->route('admin.tinh-trangs.index')->with('error', __('Error deleting status.'));
        }
    }
}