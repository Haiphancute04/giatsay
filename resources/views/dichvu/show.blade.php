@extends('layouts.app')

@section('title', $dichVu->tendichvu)

@section('content')
<style>
    /* ... (Giữ nguyên style cũ của bạn) ... */
    .service-title { font-size: 2rem; font-weight: 700; color: #2A2A2A; }
    .price-box { background: #f8fbff; border-left: 4px solid #4da3ff; padding: 15px; border-radius: 10px; }
    .star-fill { color: #ffc107; }
    .star-empty { color: #e4e5e9; }
    .related-card:hover { transform: translateY(-4px); transition: 0.2s; box-shadow: 0 4px 18px rgba(0,0,0,0.12); }
</style>

@php
    $isAdmin = Auth::check() && Auth::user()->role === 'admin';
@endphp

{{-- PHẦN TRÊN: THÔNG TIN VÀ ĐẶT HÀNG --}}
<div class="row {{ $isAdmin ? 'justify-content-center' : '' }}">
    
    {{-- CỘT TRÁI: Luôn là col-md-8 --}}
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <img src="{{ $dichVu->hinhanh ? asset('hello/' . $dichVu->hinhanh) : 'https://placehold.co/1200x800?text=Giatsay' }}"
                 class="card-img-top"
                 alt="{{ $dichVu->tendichvu }}"
                 style="max-height: 380px; object-fit: cover;">
            
            <div class="card-body px-4 py-4">
                <h1 class="service-title">{{ $dichVu->tendichvu }}</h1>
                <hr>
                <h4 class="mb-3 text-primary fw-bold">{{ __('service description') }}</h4> 
                <p style="white-space: pre-line; font-size: 1.05rem; line-height: 1.6;">
                    {{ $dichVu->motadichvu ?? __('No service description available') }}
                </p>
            </div>
        </div>

        {{-- ĐÁNH GIÁ --}}
        <div class="card shadow-sm mt-4 border-0 rounded-4">
            <div class="card-header bg-white border-0 py-3">
                <h4 class="fw-bold text-primary">{{ __('Review') }} ({{ $danhGias->total() }})</h4>
            </div>

            <div class="card-body">
                @forelse ($danhGias as $danhGia)
                    <div class="rating-box mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            
                            {{-- CỤM TRÁI: AVATAR + TÊN --}}
                            <div class="d-flex align-items-center">
                                @if($danhGia->user)
                                    <img src="{{ $danhGia->user->avatar_url }}" 
                                         alt="{{ $danhGia->user->name }}" 
                                         class="rounded-circle me-2 border"
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    {{-- Fallback nếu user đã bị xóa --}}
                                    <img src="{{ asset('assets/img/default-user.png') }}" 
                                         alt="User" 
                                         class="rounded-circle me-2 border"
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                @endif

                                <strong>{{ $danhGia->user->name ?? 'Người dùng' }}</strong>
                            </div>

                            {{-- CỤM PHẢI: NGÀY THÁNG --}}
                            <small class="text-muted">{{ $danhGia->created_at->format('d/m/Y') }}</small>
                        </div>

                        <div class="my-1 ms-5"> {{-- Thêm ms-5 để sao thẳng hàng với tên (tùy chọn) --}}
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star-fill {{ $i <= $danhGia->rating ? 'star-fill' : 'star-empty' }}"></i>
                            @endfor
                        </div>
                        
                        {{-- Nội dung comment --}}
                        <p class="mt-1 mb-0 ms-5">{{ $danhGia->binhluan }}</p> {{-- Thêm ms-5 để nội dung thẳng hàng tên --}}
                    </div>
                @empty
                    <p class="text-muted">{{ __('No reviews yet') }}</p> 
                @endforelse

                {{ $danhGias->links() }}
            </div>
        </div>
    </div>

    {{-- CỘT PHẢI: Ẩn nếu là Admin --}}
    @if (!$isAdmin)
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 100px;">
                <div class="card-body px-4 py-4">
                    <div class="price-box mb-3">
                        <h3 class="text-danger fw-bold m-0">
                            @if($dichVu->la_gia_dao_dong)
                                {{ number_format($dichVu->dongia) }} - {{ number_format($dichVu->dongia_toida) }} đ / {{ $dichVu->donvitinh }}
                            @else
                                {{ number_format($dichVu->dongia) }} đ / {{ $dichVu->donvitinh }}
                            @endif
                        </h3>
                    </div>

                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="dichvu_id" value="{{ $dichVu->id }}"> 
                        <div class="mb-3">
                            <label for="soluong" class="form-label fw-bold">{{ __('Quantity') }}({{ $dichVu->donvitinh }})</label>
                            <input type="number" step="0.1" min="0.1" class="form-control form-control-lg" id="soluong" name="soluong" value="1">
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <button type="submit" class="btn btn-primary w-100 btn-lg mt-2">
                            {{ __('Add to laundry bag') }} 
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="row {{ $isAdmin ? 'justify-content-center' : '' }}">
    <div class="{{ $isAdmin ? 'col-md-8' : 'col-12' }}">
        
        <hr class="my-5">

        <h3 class="fw-bold mb-3 text-primary">{{ __('Related services') }}</h3>
        
        {{-- Lưu ý: Nếu Admin (col-8) thì hiển thị 3 cột để thẻ không bị quá nhỏ, khách (col-12) thì 4 cột --}}
        <div class="row row-cols-1 {{ $isAdmin ? 'row-cols-md-3' : 'row-cols-md-4' }} g-4">
            @forelse ($dichVuLienQuan as $dvLienQuan)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0 rounded-4 related-card">
                        <img src="{{ $dvLienQuan->hinhanh ? asset('hello/' . $dvLienQuan->hinhanh) : 'https://placehold.co/600x400?text=Giatsay' }}"
                             class="card-img-top" style="height: 150px; object-fit: cover;" alt="{{ $dvLienQuan->tendichvu }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $dvLienQuan->tendichvu }}</h5>
                            <p class="card-text text-danger fw-bold mt-1">
                                {{ number_format($dvLienQuan->dongia) }} đ / {{ $dvLienQuan->donvitinh }} 
                            </p>
                            <a href="{{ route('dichvu.show', $dvLienQuan->tendichvu_slug) }}" class="btn btn-outline-primary mt-auto">{{ __('See details') }}</a>
                        </div>
                    </div>
                </div>
            @empty
                <p>{{ __('No related services') }}</p> 
            @endforelse
        </div>
    </div>
</div>

@endsection