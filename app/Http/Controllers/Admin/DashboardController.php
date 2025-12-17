<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DonDatLich;
use App\Models\DanhMuc;
use App\Models\DichVu;
use App\Models\MaGiamGia;
use App\Models\DanhGia;
use App\Models\TinhTrang;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalOrders = DonDatLich::count();
        $totalCategories = DanhMuc::count();
        $totalServices = DichVu::count();
        $totalCoupons = MaGiamGia::count();
        $totalReviews = DanhGia::count();
        $totalStatuses = TinhTrang::count();
        $totalBanners = Banner::count();
        $completedState = TinhTrang::where('ten_trangthai', 'Đã hoàn thành')->first();
        $completedId = $completedState ? $completedState->id : 4;

        $ordersPerMonth = DonDatLich::select(
        DB::raw('EXTRACT(MONTH FROM created_at) as month'), // Sửa dòng này
        DB::raw('COUNT(*) as total_orders'),
        DB::raw("SUM(CASE WHEN tinhtrang_id = $completedId THEN tongtien ELSE 0 END) as total_revenue")
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw('EXTRACT(MONTH FROM created_at)')) // Sửa group by để chuẩn PostgreSQL
        ->orderBy('month')
        ->get();

        $months = [];
        $dataOrders = [];
        $dataRevenue = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = "Tháng $i";
            $monthData = $ordersPerMonth->firstWhere('month', $i);
            $dataOrders[] = $monthData ? $monthData->total_orders : 0;
            $dataRevenue[] = $monthData ? $monthData->total_revenue : 0;
        }

        $statusStats = DonDatLich::select('tinhtrang_id', DB::raw('count(*) as total'))
            ->with('tinhTrang')
            ->groupBy('tinhtrang_id')
            ->get();

        $statusLabels = [];
        $statusData = [];
        $statusColors = []; 

        $bootstrapColors = [
            'primary'   => '#0d6efd', 
            'secondary' => '#6c757d', 
            'success'   => '#198754', 
            'danger'    => '#dc3545', 
            'warning'   => '#ffc107', 
            'info'      => '#0dcaf0', 
            'light'     => '#f8f9fa',
            'dark'      => '#212529',
        ];

        foreach ($statusStats as $stat) {
            $tenTinhTrang = 'Không xác định';
            $mauSac = 'secondary';

            if ($stat->tinhTrang) {
                $tenTinhTrang = $stat->tinhTrang->ten_trangthai 
                             ?? $stat->tinhTrang->tentinhtrang 
                             ?? $stat->tinhTrang->ten 
                             ?? 'Không tên';
            
                $mauSac = $stat->tinhTrang->mau_sac ?? 'secondary';
            }

            $statusLabels[] = $tenTinhTrang;
            $statusData[] = $stat->total;
            
            $statusColors[] = $bootstrapColors[$mauSac] ?? '#6c757d';
        }

        return view('admin.dashboard', compact(
            'totalUsers', 'totalOrders', 'totalCategories', 'totalServices', 
            'totalCoupons', 'totalReviews', 'totalStatuses', 'totalBanners',
            'months', 'dataOrders', 'dataRevenue', 
            'statusLabels', 'statusData', 'statusColors' 
        ));
    }
}