<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonDatLich;
use App\Models\TinhTrang;
use App\Models\MaGiamGia; 
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Log; 

class DonDatLichController extends Controller
{
    public function index(Request $request)
    {
        $query = DonDatLich::with(['user', 'tinhTrang']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('tenkhachhang', 'like', '%' . $search . '%');
        }

        $donDatLichs = $query->latest()->paginate(15);
                            
        return view('admin.dondatlichs.index', compact('donDatLichs'));
    }
    
    public function show(DonDatLich $donDatLich)
    {
        $donDatLich->load(['user', 'tinhTrang', 'maGiamGia', 'chiTietDonDatLichs.dichVu']);
        $tinhTrangs = TinhTrang::all();
        
        return view('admin.dondatlichs.show', compact('donDatLich', 'tinhTrangs'));
    }

    public function updateStatus(Request $request, DonDatLich $donDatLich)
    {
        $validated = $request->validate([
            'tinhtrang_id' => 'required|exists:tinh_trangs,id',
        ]);

        $oldStatusId = $donDatLich->tinhtrang_id;
        $newStatusId = (int)$validated['tinhtrang_id']; 

        $donDatLich->update([
            'tinhtrang_id' => $newStatusId,
        ]);

        try {
            $completedStatus = TinhTrang::where('id', 4) 
                                        ->orWhere('ten_trangthai', 'LIKE', '%oàn thành%') 
                                        ->orWhere('ten_hienthi', 'LIKE', '%oàn thành%')
                                        ->first();

            if ($completedStatus) {
               
                if ($newStatusId == $completedStatus->id && $oldStatusId != $completedStatus->id) {
                    
                    if ($donDatLich->user_id) { 
                        Log::info("Đơn hàng #{$donDatLich->id} đã hoàn thành. Bắt đầu tính tích lũy cho User ID: {$donDatLich->user_id}");
                        $this->checkAndRewardUser($donDatLich->user, $completedStatus->id);
                    } else {
                        Log::warning("Đơn hàng #{$donDatLich->id} là khách vãng lai (Không có User ID). Bỏ qua tích lũy.");
                    }
                }
            } else {
                Log::error("CRITICAL ERROR: Không tìm thấy bất kỳ trạng thái nào có tên chứa 'Hoàn thành' hoặc ID=4 trong database.");
            }
        } catch (\Exception $e) {
            Log::error("LỖI EXCEPTION: " . $e->getMessage());
        }

        return redirect()->route('admin.dondatlichs.show', $donDatLich->id)
                         ->with('success', __('Cập nhật trạng thái thành công!'));
    }

    private function checkAndRewardUser($user, $completedStatusId)
    {
        if (!$user) return;

        $completedCount = DonDatLich::where('user_id', $user->id)
                                    ->where('tinhtrang_id', $completedStatusId)
                                    ->count();

        Log::info("User {$user->id} - Tổng đơn hoàn thành: {$completedCount}");

        if ($completedCount > 0 && $completedCount % 10 == 0) {
            Log::info("--> User {$user->id} ĐẠT MỐC THƯỞNG! Đang tạo voucher...");

            $code = 'GIFT' . strtoupper(Str::random(3)) . rand(100, 999);

            try {
                $voucher = MaGiamGia::create([
                    'ma_code'           => $code,
                    'loai_giamgia'      => 'fixed',
                    'giatri'            => 40000,      
                    'dieukien_toithieu' => 0,
                    'soluong_phathanh'  => 1,
                    'soluong_dasudung'  => 0,
                    'ngay_batdau'       => now(),
                    'ngay_ketthuc'      => now()->addDays(30),
                    'trangthai'         => true,
                ]);

                if (method_exists($user, 'vouchers')) {
                    $user->vouchers()->attach($voucher->id, [
                        'is_used' => false,
                        'ngay_luu' => now()
                    ]);
                } else {
                    \DB::table('user_ma_giam_gia')->insert([
                        'user_id' => $user->id,
                        'ma_giam_gia_id' => $voucher->id,
                        'is_used' => false,
                        'ngay_luu' => now()
                    ]);
                }

                Log::info("--> Đã tạo thành công Voucher: {$code}");
            } catch (\Exception $e) {
                Log::error("--> Lỗi khi tạo voucher: " . $e->getMessage());
            }

        } else {
            $remain = 10 - ($completedCount % 10);
            Log::info("--> Chưa đủ điều kiện. Cần thêm {$remain} đơn.");
        }
    }
}