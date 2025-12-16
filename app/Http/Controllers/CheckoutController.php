<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\DonDatLich;
use App\Models\ChiTietDonDatLich;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\MaGiamGia;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Cart::content()->isEmpty()) {
            return redirect()->route('cart.index')->with('error', __('Your laundry bag is empty!'));
        }

        return view('checkout.index', [
            'cartItems' => Cart::content(),
            'total' => Cart::total(0, '', ''),
            'user' => Auth::user(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tenkhachhang' => 'required|string|max:255',
            'sdt_khachhang' => 'required|string|max:15',
            'diachigiaonhan' => 'required|string|max:255',
            'thoi_gian_lay_hang' => 'required|date_format:Y-m-d H:i', 
            'thoi_gian_giao_hang_du_kien' => 'required|date_format:Y-m-d H:i',
            'ma_giam_gia' => 'nullable|string',
            'ghichu' => 'nullable|string',
        ]);
        
        if (Cart::content()->isEmpty()) {
            return redirect()->route('cart.index')->with('error', __('Laundry bag is empty, cannot checkout.'));
        }

        try {
            $rawTotal = Cart::total(0, '', ''); 
            $total = (float)preg_replace('/[^0-9.]/', '', $rawTotal); 
            $discount = 0;
            $maGiamGiaId = null;
            $coupon = null; 
            
            if ($request->filled('ma_giam_gia')) {
                $code = $request->ma_giam_gia;
                $coupon = MaGiamGia::where('ma_code', $code)->first();

                if (!$coupon) {
                    return redirect()->back()->withInput()->with('error', __('Invalid voucher code.'));
                }

                if ($coupon->trangthai == 0 || $coupon->soluong_dasudung >= $coupon->soluong_phathanh) {
                    return redirect()->back()->withInput()->with('error', __('Voucher is invalid (Expired or Locked).'));
                }

                if ($coupon->ngay_ketthuc && now()->gt($coupon->ngay_ketthuc)) {
                    return redirect()->back()->withInput()->with('error', __('Voucher has expired.'));
                }

                if ($coupon->dieukien_toithieu !== null && $total < $coupon->dieukien_toithieu) {
                    return redirect()->back()->withInput()->with('error', 
                        __('Order minimum value not met.') . ' (' . __('Minimum required') . ': ' . number_format($coupon->dieukien_toithieu, 0, ',', '.') . ' đ)'
                    );
                }

                $maGiamGiaId = $coupon->id;
                if ($coupon->loai_giamgia == "percent") {
                    $discount = $total * ($coupon->giatri / 100);
                } else {
                    $discount = $coupon->giatri;
                }
                
                if ($discount > $total) $discount = $total;
            }
            
            DB::beginTransaction();

            $donDatLich = new DonDatLich();
            $donDatLich->user_id = Auth::id();
            $donDatLich->magiamgia_id = $maGiamGiaId;
            $donDatLich->tenkhachhang = $request->tenkhachhang;
            $donDatLich->sdt_khachhang = $request->sdt_khachhang;
            $donDatLich->diachigiaonhan = $request->diachigiaonhan;
            $donDatLich->thoi_gian_lay_hang = $request->thoi_gian_lay_hang;
            $donDatLich->thoi_gian_giao_hang_du_kien = $request->thoi_gian_giao_hang_du_kien;
            $donDatLich->tongtien = max(0, $total - $discount); 
            $donDatLich->tinhtrang_id = 1; 
            $donDatLich->tamtinh = $total;
            $donDatLich->ghichu = $request->ghichu ?? null;
            $donDatLich->tien_giamgia = $discount;
            $donDatLich->save(); 

            foreach (Cart::content() as $item) {
                $chiTiet = new ChiTietDonDatLich();
                $chiTiet->dondatlich_id = $donDatLich->id; 
                $chiTiet->dichvu_id = $item->id;
                $chiTiet->tendichvu = $item->name;
                $chiTiet->soluong = $item->qty;
                $chiTiet->dongia = $item->price;
                $chiTiet->thanhtien = $item->qty * $item->price; 
                $chiTiet->save();
            }

            if ($coupon) {
                $coupon->increment('soluong_dasudung');
                if ($coupon->soluong_dasudung >= $coupon->soluong_phathanh) {
                    $coupon->update(['trangthai' => 0]); 
                }
                DB::table('user_ma_giam_gia')
                    ->where('user_id', Auth::id())
                    ->where('ma_giam_gia_id', $coupon->id)
                    ->update(['is_used' => true]);
            }

            Cart::destroy();
            DB::commit();

            return redirect()->route('dashboard')->with('success', __('Booking successful!') . ' ' . __('Booking ID') . ': #' . $donDatLich->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with('error', __('System error') . ': ' . $e->getMessage());
        }
    }
}