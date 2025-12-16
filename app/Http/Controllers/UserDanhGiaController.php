<?php

namespace App\Http\Controllers;

use App\Models\DanhGia;
use App\Models\DonDatLich;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDanhGiaController extends Controller
{
    public function create(DonDatLich $donDatLich)
    {
        if ($donDatLich->user_id !== Auth::id()) {
            abort(403, __('You do not have permission to review this booking.'));
        }

        if ($donDatLich->tinhtrang_id !== 4) {
            return redirect()->route('dashboard')->with('error', __('Booking not completed, cannot review.'));
        }

        if ($donDatLich->trangthai_danhgia == 1) {
            return redirect()->route('dashboard')->with('error', __('This booking has already been reviewed.'));
        }
        
        $chiTiet = $donDatLich->chiTietDonDatLichs->first();
        if (!$chiTiet) {
             return redirect()->route('dashboard')->with('error', __('Service not found in booking.'));
        }

        return view('danhgia.create', compact('donDatLich', 'chiTiet'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'don_dat_lich_id' => 'required|exists:don_dat_lichs,id',
            'so_sao' => 'required|integer|min:1|max:5',
            'noi_dung' => 'nullable|string|max:1000',
        ]);
        
        $donDatLich = DonDatLich::find($request->don_dat_lich_id);
        
        if ($donDatLich->user_id !== Auth::id() || $donDatLich->trangthai_danhgia == 1 || $donDatLich->tinhtrang_id !== 4) {
            return redirect()->route('dashboard')->with('error', __('Invalid review request.'));
        }
        
        $dichVuId = $donDatLich->chiTietDonDatLichs->first()->dichvu_id;
        
        DanhGia::create([
            'user_id' => Auth::id(),
            'dondatlich_id' => $donDatLich->id,
            'dichvu_id' => $dichVuId,
            'rating' => $request->so_sao,
            'binhluan' => $request->noi_dung,
            'trangthai' => 0, 
        ]);

        $donDatLich->update(['trangthai_danhgia' => 1]);
        return redirect()->route('dashboard')->with('success', __('Your review has been submitted and is pending approval.'));
    }
}