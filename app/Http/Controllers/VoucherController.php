<?php

namespace App\Http\Controllers;

use App\Models\MaGiamGia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = MaGiamGia::where('trangthai', 1) 
            ->whereColumn('soluong_dasudung', '<', 'soluong_phathanh') 
            ->where(function($q) {
                $q->whereNull('ngay_batdau')
                  ->orWhereDate('ngay_batdau', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('ngay_ketthuc')
                  ->orWhereDate('ngay_ketthuc', '>=', now());
            })
            ->latest()
            ->get();

        return view('vouchers.index', compact('vouchers'));
    }

    public function collect(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => __('Please login to save voucher!')]);
        }

        $user = Auth::user();
        $voucher = MaGiamGia::find($id);

        if (!$voucher) {
            return response()->json(['success' => false, 'message' => __('Voucher does not exist!')]);
        }

        if ($user->vouchers()->where('ma_giam_gia_id', $id)->exists()) {
            return response()->json(['success' => false, 'message' => __('You have already saved this voucher!')]);
        }
        
        if ($voucher->soluong_phathanh <= $voucher->soluong_dasudung) {
             return response()->json(['success' => false, 'message' => __('Voucher usage limit reached!')]);
        }

        $user->vouchers()->attach($id);
        return response()->json(['success' => true, 'message' => __('Voucher saved successfully!')]);
    }

    public function myVouchers()
    {
        $user = Auth::user();
        $vouchers = $user->vouchers()
                        ->orderByPivot('ngay_luu', 'desc')
                        ->get();
        return view('vouchers.my_vouchers', compact('vouchers'));
    }
}