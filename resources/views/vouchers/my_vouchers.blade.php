@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center"><i class="bi bi-wallet2 me-1"></i> {{ __('My Voucher Wallet') }}</h2>

    @if($vouchers->isEmpty())
        <div class="alert alert-info text-center shadow-sm">
            Bạn chưa lưu mã giảm giá nào. <br>
            <a href="{{ route('vouchers.index') }}" class="btn btn-primary mt-2 btn-sm">Săn mã ngay!</a>
        </div>
    @else
        <div class="row">
            @foreach($vouchers as $voucher)
                <div class="col-md-4 mb-4">
                    @php
                        $isExpired = $voucher->ngay_ketthuc && \Carbon\Carbon::parse($voucher->ngay_ketthuc)->isPast();
                        $isUsed = $voucher->pivot->is_used;
                        $isInactive = $isExpired || $isUsed;

                        $color = $isInactive ? 'secondary' : 'primary';
                    @endphp

                    {{-- Áp dụng màu vào Viền (Border) --}}
                    <div class="card h-100 shadow-sm border-{{ $color }} {{ $isInactive ? 'bg-light' : '' }}">
                        <div class="card-body">
                            
                            {{-- Áp dụng màu vào Tiêu đề (Mã Code) --}}
                            <h5 class="card-title text-{{ $color }} fw-bold">{{ $voucher->ma_code }}</h5>

                            <p class="card-text">
                                @if($voucher->loai_giamgia == 'percent')
                                    Giảm <span class="fw-bold">{{ number_format($voucher->giatri) }}%</span>
                                @else
                                    Giảm <span class="fw-bold">{{ number_format($voucher->giatri) }} VNĐ</span>
                                @endif
                            </p>

                            <p class="small text-muted">
                                Đơn tối thiểu: {{ number_format($voucher->dieukien_toithieu) }} đ <br>
                                HSD: {{ $voucher->ngay_ketthuc ? \Carbon\Carbon::parse($voucher->ngay_ketthuc)->format('d/m/Y') : 'Vô thời hạn' }}
                                <br>
                                <span class="fst-italic text-secondary" style="font-size: 0.9em;">
                                    <i class="bi bi-clock-history"></i> Lưu lúc: {{ \Carbon\Carbon::parse($voucher->pivot->ngay_luu)->format('H:i d/m/Y') }}
                                </span>
                            </p>

                            @if($isUsed)
                                <button class="btn btn-success btn-sm w-100" disabled>Đã sử dụng</button>
                            @elseif($isExpired)
                                <button class="btn btn-secondary btn-sm w-100" disabled>Đã hết hạn</button>
                            @else
                                {{-- Nút dùng ngay: Dùng outline-primary để khớp với viền và chữ --}}
                                <a href="{{ route('home') }}" class="btn btn-outline-{{ $color }} btn-sm w-100">
                                    Dùng ngay
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection