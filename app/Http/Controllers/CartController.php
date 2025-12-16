<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\DichVu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    private function syncCartToDatabase()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            DB::table('shoppingcart')->where('identifier', $userId)->delete();
            Cart::store($userId);
            Cart::restore($userId);
        }
    }

    public function index()
    {
        $cartItems = Cart::content();
        return view('cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'dichvu_id' => 'required|exists:dich_vus,id',
            'soluong' => 'required|numeric|min:0.1', 
        ]);

        $dichVu = DichVu::findOrFail($request->dichvu_id);

        Cart::add([
            'id' => $dichVu->id,
            'name' => $dichVu->tendichvu,
            'qty' => $request->soluong,
            'price' => $dichVu->dongia,
            'weight' => 0, 
            'options' => [
                'donvitinh' => $dichVu->donvitinh,
                'hinhanh' => $dichVu->hinhanh,
            ],
        ]);

        $this->syncCartToDatabase();

        return redirect()->back()->with('success', __('Added service to laundry bag!'));
    }

    public function update(Request $request, $rowId)
    {
        $request->validate(['soluong' => 'required|numeric|min:0.1']);

        if ($request->soluong <= 0) {
            Cart::remove($rowId);
            $this->syncCartToDatabase();
            return redirect()->route('cart.index')->with('success', __('Removed service from laundry bag!'));
        }

        Cart::update($rowId, $request->soluong); 
        $this->syncCartToDatabase();
        
        return redirect()->route('cart.index')->with('success', __('Quantity updated successfully!'));
    }

    public function remove($rowId)
    {
        Cart::remove($rowId);
        $this->syncCartToDatabase();
        return redirect()->route('cart.index')->with('success', __('Removed service from laundry bag!'));
    }

    public function clear()
    {
        Cart::destroy();
        if (Auth::check()) {
            DB::table('shoppingcart')->where('identifier', Auth::id())->delete();
        }
        return redirect()->route('cart.index')->with('success', __('Cleared laundry bag successfully!'));
    }
}