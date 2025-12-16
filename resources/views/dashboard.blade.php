@extends('layouts.app')

@section('title', __('Dashboard'))

@section('content')

<style>
    /* ===== CUSTOM LAUNDRY UI ===== */
    .dashboard-title {
        font-size: 26px;
        font-weight: 700;
        color: #0d6efd;
    }

    .dashboard-sub {
        color: #6c757d;
        font-size: 15px;
        margin-bottom: 25px;
    }

    .laundry-card {
        border-radius: 14px;
        border: none;
        overflow: hidden;
    }

    .laundry-card .card-header {
        background: linear-gradient(135deg, #0d6efd, #4ea7ff);
        color: #fff;
        padding: 18px 20px;
        border: none;
    }

    .laundry-table thead {
        background: #f1f5ff;
        border-bottom: 2px solid #e0e7ff;
    }

    .laundry-table tbody tr:hover {
        background: #f9fbff !important;
    }

    .laundry-table td {
        padding: 14px 10px;
        vertical-align: middle;
    }

    .status-badge {
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 13px;
    }

    .btn-action {
        border-radius: 8px;
        font-size: 13px;
    }
</style>

<h2 class="dashboard-title">👋 {{ __('welcome') }}, {{ Auth::user()->name }}!</h2>
<p class="dashboard-sub">{{ __('News1') }}</p>

<div class="card shadow-sm laundry-card">
    {{-- PHẦN 1: THẺ TÍCH LŨY ĐƠN HÀNG (MỚI) --}}
    <div class="card shadow-sm loyalty-card">
        <div class="loyalty-bg-circle"></div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="fw-bold mb-1">
                        <i class="bi bi-award-fill text-warning me-2"></i>{{ __('Loyalty Program') }} 
                    </h4>
                    <p class="mb-2 opacity-75 small"> 
                        {{ __('Your Reward: Free 5kg Wash (worth 40,000đ) after 10 orders.') }}
                    </p>
                    
                    {{-- Thanh Progress Bar --}}
                    <div class="d-flex align-items-center">
                        <span class="fw-bold me-2">{{ $loyaltyPoints }}/10</span>
                        <div class="progress progress-custom flex-grow-1">
                            <div class="progress-bar progress-bar-custom progress-bar-striped progress-bar-animated" 
                                 role="progressbar" 
                                 style="width: {{ $loyaltyPoints * 10 }}%;" 
                                 aria-valuenow="{{ $loyaltyPoints }}" aria-valuemin="0" aria-valuemax="10">
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 text-center mt-3 mt-md-0 border-start border-light border-opacity-25">
                    <div class="display-5 fw-bold">{{ $loyaltyPoints }}</div>
                    <div class="small text-uppercase opacity-75">Đơn tích lũy</div>
                </div>
            </div>

            {{-- Thông báo khi nhận thưởng --}}
            @if($isRewardReached)
            <div class="mt-3 bg-white text-success p-2 rounded shadow-sm d-flex align-items-center">
                <i class="bi bi-gift-fill fs-4 me-2 text-danger"></i>
                <div class="small fw-bold">
                    Chúc mừng! Bạn đã tích đủ 10 đơn. Voucher 40k đã được gửi vào ví ưu đãi của bạn!
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-list-check me-1"></i> {{ __('News2') }}
        </h5>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover laundry-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="fw-bold text-center">{{ __('Booking ID') }}</th> 
                        <th class="fw-bold text-center">{{ __('Booking Date') }}</th> 
                        <th class="fw-bold ">{{ __('Shipping Information') }}</th> 
                        <th class="fw-bold ">{{ __('Appointment') }}</th> 
                        <th class="fw-bold text-center">{{ __('status') }}</th> 
                        <th class="fw-bold text-center">{{ __('Total Amount') }}</th> 
                        <th class="fw-bold text-center">{{ __('Review') }}</th> 
                        <th class="fw-bold text-center"style="width: 130px;">{{ __('Actions') }}</th> 
                    </tr>
                </thead>

                <tbody>
                    @forelse ($donDatLichs as $donDatLich)
                    <tr>
                        <td class="fw-bold text-primary text-center">#{{ $donDatLich->id }}</td>
                        <td class="fw-bold text-center">
                            {{ $donDatLich->created_at->format('d/m/Y') }}
                            <br>
                            <small class="text-muted">
                                {{ $donDatLich->created_at->format('H:i') }}
                            </small>
                        </td>

                        <td class="fw-bold">
                            <div class="fw-bold">
                                <i class="bi bi-person-fill me-1"></i> {{ $donDatLich->tenkhachhang }}
                            </div>
                            <div class="small text-muted">
                                <i class="bi bi-telephone-fill me-1"></i> {{ $donDatLich->sdt_khachhang }}
                            </div>
                            <div class="text-secondary small text-truncate" style="max-width: 200px;" title="{{ $donDatLich->diachigiaonhan }}">
                                <i class="bi bi-geo-alt-fill text-danger"></i> {{ $donDatLich->diachigiaonhan }}
                            </div>
                        </td>
                        <td class="fw-bold">
                            <div class="small">
                                <span class="text-muted">{{ __('Pick up') }}: </span> 
                                @if($donDatLich->thoi_gian_lay_hang)
                                    <span class="text-primary">
                                        <i class="bi bi-basket"></i> 
                                        {{ \Carbon\Carbon::parse($donDatLich->thoi_gian_lay_hang)->format('H:i d/m') }}
                                    </span>
                                @else
                                    ---
                                @endif
                            </div>

                            <div class="small">
                                <span class="text-muted">{{ __('Deliver') }}: </span> 
                                @if($donDatLich->thoi_gian_giao_hang_du_kien)
                                    <span class="text-primary">
                                        <i class="bi bi-truck"></i> 
                                        {{ \Carbon\Carbon::parse($donDatLich->thoi_gian_giao_hang_du_kien)->format('H:i d/m') }}
                                    </span>
                                @else
                                    ---
                                @endif
                            </div>
                        </td>

                        {{-- CẬP NHẬT: Dịch trạng thái ở cột Status --}}
                        <td class="fw-bold text-center">
                            @if($donDatLich->tinhTrang)
                                <span class="badge status-badge bg-{{ $donDatLich->tinhTrang->mau_sac }}">
                                    {{ __($donDatLich->tinhTrang->ten_hienthi) }}
                                </span>
                            @else
                                <span class="badge bg-secondary status-badge">N/A</span>
                            @endif
                        </td>

                        <td class="fw-bold text-primary text-center">
                            {{ number_format($donDatLich->tongtien) }} đ
                        </td>

                        <td class="fw-bold text-center">
                            @if ($donDatLich->tinhtrang_id === 4 && $donDatLich->trangthai_danhgia === 0)
                                <a href="{{ route('danhgia.create', $donDatLich) }}" class="btn btn-outline-primary btn-sm btn-action">
                                    <i class="bi bi-star"></i> {{ __('Review') }}
                                </a>
                            @elseif ($donDatLich->trangthai_danhgia === 1)
                                <span class="badge bg-warning text-dark status-badge">
                                    <i class="bi bi-check-circle"></i> {{ __('Reviewed') }}
                                </span>
                            @else
                                <span class="text-muted small">---</span>
                            @endif
                        </td>

                        <td class="fw-bold text-center">
                            @if ($donDatLich->tinhtrang_id == 1)
                                <form action="{{ route('user.dondatlich.cancel', $donDatLich->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('{{ __('Are you sure delete') }}?');"> 
                                      {{-- Lưu ý: Bạn có thể cần thêm key mới vào JSON cho câu hỏi xác nhận hủy đơn nếu muốn chính xác hơn --}}
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-danger btn-sm btn-action">
                                        {{-- CẬP NHẬT: Dịch nút Hủy --}}
                                        <i class="bi bi-x-circle"></i> {{ __('Cancel') }}
                                    </button>
                                </form>

                            {{-- CẬP NHẬT: Dịch trạng thái ở cột Actions (nếu không phải nút hủy) --}}
                            @elseif ($donDatLich->tinhtrang_id == 4 || $donDatLich->tinhtrang_id == 5)
                                <span class="badge bg-{{ $donDatLich->tinhTrang->mau_sac }} status-badge">
                                    {{ __($donDatLich->tinhTrang->ten_hienthi) }}
                                </span>

                            @else
                                <span class="badge status-badge bg-{{ $donDatLich->tinhTrang->mau_sac }}">
                                    {{ __($donDatLich->tinhTrang->ten_hienthi) }}
                                </span>
                            @endif
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center p-4 text-muted">
                            <i class="bi bi-clipboard-x fs-3"></i><br> 
                            {{ __('News4') }}
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($donDatLichs->hasPages())
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-center">
                {{-- 
                   onEachSide(1): Chỉ hiện 1 trang bên cạnh trang hiện tại (VD: 1 ... 4 5 6 ... 10) 
                   links('pagination::bootstrap-5'): Ép sử dụng giao diện Bootstrap 5 chuẩn
                --}}
                {{ $donDatLichs->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>

@endsection