@extends('layouts.app')

@section('title', 'Túi đồ của bạn')

@section('content')

<h2 class="fw-bold mb-4">🛒 {{ __('your laundry bag') }}</h2> 

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if ($cartItems->isNotEmpty())
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-bold text-center" style="width: 100px;">{{ __('Image') }}</th> 
                                    <th class="fw-bold text-center">{{ __('Services') }}</th>
                                    <th class="fw-bold text-center" style="width: 150px;">{{ __('Unit price') }}</th> 
                                    <th class="fw-bold text-center" style="width: 120px;">{{ __('Quantity') }}</th> 
                                    <th class="fw-bold text-center" style="width: 150px;">{{ __('Total') }}</th> 
                                    <th class="fw-bold text-center" style="width: 50px;">{{ __('Delete') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cartItems as $item)
                                    <tr>
                                        <!-- Ảnh -->
                                        <td class="text-center">
                                            @if (isset($item->options['hinhanh']))
                                                <img src="{{ asset('storage/' . $item->options['hinhanh']) }}" 
                                                     alt="{{ $item->name }}" 
                                                     style="width: 80px; height: 60px; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <img src="https://placehold.co/80x60/6EC6FF/fff?text=Giatsay" alt="N/A">
                                            @endif
                                        </td>
                                        
                                        <!-- Tên dịch vụ -->
                                        <td class="text-center">
                                            <h6 class="mb-0">{{ $item->name }}</h6>
                                            <small class="text-muted">ĐVT: {{ $item->options['donvitinh'] ?? 'N/A' }}</small>
                                        </td>
                                        
                                        <!-- Đơn giá -->
                                        <td class="text-center">{{ number_format($item->price) }} đ</td>
                                        
                                        <!-- Số lượng (Form Cập nhật) -->
                                        <td class="text-center">
                                            <form action="{{ route('cart.update', $item->rowId) }}" method="POST" class="d-flex">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" 
                                                       name="soluong" 
                                                       value="{{ $item->qty }}" 
                                                       min="1" 
                                                       step="1"
                                                       class="form-control form-control-sm text-center" 
                                                       onchange="this.form.submit()" 
                                                       style="width: 90px; height: 32px;">
                                            </form>
                                        </td>
                                        
                                        <!-- Thành tiền -->
                                        <td class="text-center">{{ number_format($item->subtotal) }} đ</td>
                                        
                                        <!-- Xóa (Form Remove) -->
                                        <td class="text-center">
                                            <form action="{{ route('cart.remove', $item->rowId) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa">
                                                    <span class="material-symbols-outlined" style="font-size: 18px;">close</span>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Tổng tiền và Đặt hàng -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header fw-bold text-center">{{ __('Booking Summary') }}</div> 
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ __(' Subtotal') }} ({{ Cart::count() }} {{ __('Services') }}):</span> 
                        <span class="fw-semibold">{{ number_format(Cart::subtotal(0, '', '')) }} đ</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <span>VAT (0%):</span>
                        <span class="fw-semibold">{{ number_format(Cart::tax(0, '', '')) }} đ</span>
                    </div>

                    <div class="d-flex justify-content-between mb-4 border-top pt-2">
                        <h5 class="fw-bold mb-0">{{ __(' Total') }}:</h5>
                        <h5 class="fw-bold text-danger mb-0">{{ number_format(Cart::total(0, '', '')) }} đ</h5>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn btn-success w-100 btn-lg">{{ __('Start Confirm Booking') }}</a> 
                    
                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa toàn bộ túi đồ?');" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary w-100 btn-sm">{{ __('Clear Bag') }}</button> 
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-info text-center py-5">
        <span class="material-symbols-outlined d-block mb-2" style="font-size: 48px;">shopping_cart</span>
        <h4 class="alert-heading">{{ __('empty laundry bag') }}!</h4> 
        <p>{{ __('News5') }}</p>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">{{ __('return to home page') }}</a> 
    </div>
@endif

@endsection