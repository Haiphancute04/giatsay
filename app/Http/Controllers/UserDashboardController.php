<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\DonDatLich; 

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $completedOrders = DonDatLich::where('user_id', $user->id)
                                    ->where('tinhtrang_id', 4) 
                                    ->count();
        
        $loyaltyPoints = $completedOrders % 10;
        $isRewardReached = ($completedOrders > 0 && $loyaltyPoints == 0);
        $donDatLichs = DonDatLich::where('user_id', $user->id)
                            ->with('tinhTrang')
                            ->latest()
                            ->paginate(10); 

        return view('dashboard', compact('donDatLichs', 'loyaltyPoints', 'isRewardReached', 'completedOrders'));
    }

    public function cancelOrder($id)
    {
        $donDatLich = DonDatLich::findOrFail($id);

        if ($donDatLich->user_id != auth()->id()) {
            abort(403, __('You do not have permission to modify this order.'));
        }

        if ($donDatLich->tinhtrang_id == 1) {
            $donDatLich->tinhtrang_id = 5; 
            $donDatLich->save();

            return redirect()->back()->with('success', __('Booking cancelled successfully.'));
        }

        return redirect()->back()->with('error', __('Cannot cancel order once it has been processed.'));
    }
}