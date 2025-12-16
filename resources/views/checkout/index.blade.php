@extends('layouts.app')

@section('title', __('Booking & Payment'))

@section('content')
<div class="container py-5">
    <h2 class="fw-bold mb-4 text-center">📅 {{ __('scheduling information') }}</h2> 

    <form id="checkoutForm" action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="row">
            {{-- CỘT TRÁI: THÔNG TIN --}}
            <div class="col-lg-7">
                <div class="card shadow-sm mb-4 border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-person-lines-fill me-2"></i>{{ __('1. Shipping Information') }}</h5>
                    </div>
                    <div class="card-body">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('Full name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="tenkhachhang" class="form-control" 
                                       value="{{ old('tenkhachhang', $user->name ?? '') }}" 
                                       placeholder="{{ __('Enter your full name') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">{{ __('Phone number') }} <span class="text-danger">*</span></label>
                                <input type="text" name="sdt_khachhang" class="form-control" 
                                       value="{{ old('sdt_khachhang', $user->phone ?? '') }}" 
                                       placeholder="{{ __('Ex: 0912345678') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('Pickup/Delivery Address') }} <span class="text-danger">*</span></label>
                            <textarea name="diachigiaonhan" class="form-control" rows="2" 
                                      placeholder="{{ __('Address Placeholder') }}">{{ old('diachigiaonhan', $user->address ?? '') }}</textarea>
                        </div>

                        <hr class="my-4">
                        
                        <h5 class="text-primary mb-3"><i class="bi bi-clock-history me-2"></i>{{ __('2. Shipper Scheduling') }}</h5>
                        <div class="row mb-3">
                            {{-- THỜI GIAN LẤY --}}
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-bold">
                                    {{ __('Pickup Time') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-primary">
                                        <i class="bi bi-calendar-event"></i>
                                    </span>
                                    <input type="text" id="picker_lay_hang" name="thoi_gian_lay_hang" 
                                           class="form-control bg-white border-start-0 ps-0" 
                                           placeholder="{{ __('Select date...') }}"
                                           style="cursor: pointer;" readonly 
                                           value="{{ old('thoi_gian_lay_hang') }}">
                                </div>
                                <div class="form-text text-muted small">
                                    <i class="bi bi-info-circle"></i> {{ __('Shop operation hours') }}
                                </div>
                                @error('thoi_gian_lay_hang')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- THỜI GIAN TRẢ (DỰ KIẾN) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold">
                                    {{ __('Expected Delivery Time') }} <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-success">
                                        <i class="bi bi-calendar-check"></i>
                                    </span>
                                    {{-- Mặc định DISABLED cho đến khi chọn ngày lấy --}}
                                    <input type="text" id="picker_giao_hang" name="thoi_gian_giao_hang_du_kien" 
                                           class="form-control bg-white border-start-0 ps-0" 
                                           placeholder="{{ __('Select pickup date first...') }}"
                                           style="cursor: pointer;" readonly
                                           disabled 
                                           value="{{ old('thoi_gian_giao_hang_du_kien') }}">
                                </div>
                                <div class="form-text text-muted small">
                                    <i class="bi bi-clock-history"></i> {{ __('Minimum processing time') }}
                                </div>
                                @error('thoi_gian_giao_hang_du_kien')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- === SỬA ĐỔI: KHU VỰC MÃ GIẢM GIÁ === --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('Voucher Code') }}</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-ticket-perforated"></i></span>
                                <input type="text" id="coupon_code" name="ma_giam_gia" class="form-control" 
                                       placeholder="{{ __('Enter code or select from wallet') }}"
                                       value="{{ old('ma_giam_gia') }}">
                                <button class="btn btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#voucherModal">
                                    <i class="bi bi-wallet2"></i> {{ __('Select my voucher') }}
                                </button>
                            </div>
                        </div>
                        {{-- =================================== --}}

                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('Special Notes') }}</label>
                            <textarea name="ghichu" class="form-control" rows="3" 
                                      placeholder="{{ __('Notes Placeholder') }}">{{ old('ghichu') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CỘT PHẢI: GIỎ HÀNG --}}
            <div class="col-lg-5">
                <div class="card shadow-sm border-0 sticky-top" style="top: 20px; z-index: 1;">
                    <div class="card-header bg-light">
                        <h5 class="mb-0 text-center">📦 {{ __('Selected Services') }}</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush mb-3">
                            @foreach($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $item->name }}</h6>
                                    <small class="text-muted">{{ __('Quantity') }}: {{ $item->qty }} {{ $item->options['donvitinh'] ?? '' }}</small>
                                </div>
                                <span class="text-primary fw-bold">{{ number_format($item->subtotal) }} đ</span>
                            </li>
                            @endforeach
                        </ul>
                        
                        <div class="d-flex justify-content-between fw-bold fs-4 border-top pt-3 text-dark">
                            <span>{{ __('Total') }}:</span>
                            <span class="text-danger">{{ number_format($total) }} đ</span>
                        </div>

                        <button type="submit" class="btn btn-success w-100 btn-lg mt-4 py-3 fw-bold text-uppercase shadow">
                            {{ __('Confirm Booking Button') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- === SỬA ĐỔI: MODAL DANH SÁCH MÃ GIẢM GIÁ === --}}
<div class="modal fade" id="voucherModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold"><i class="bi bi-wallet2 text-primary"></i> {{ __('Your Voucher Wallet') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                @if($user->vouchers->isEmpty())
                    <div class="text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/4076/4076549.png" width="64" alt="Empty" class="mb-3 opacity-50">
                        <p class="text-muted">{{ __('No vouchers saved') }}</p>
                        <a href="{{ route('vouchers.index') }}" class="btn btn-sm btn-outline-primary">{{ __('Hunt now') }}</a>
                    </div>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($user->vouchers as $voucher)
                            @php
                                // Logic kiểm tra điều kiện tối thiểu
                                $currentTotal = (float)$total; // $total truyền từ Controller là số
                                $isValid = true;
                                if($voucher->dieukien_toithieu && $currentTotal < $voucher->dieukien_toithieu) {
                                    $isValid = false;
                                }
                                // Kiểm tra đã dùng chưa
                                if($voucher->pivot->is_used) {
                                     continue; // Bỏ qua mã đã dùng
                                }
                            @endphp
                            
                            <button type="button" 
                                class="list-group-item list-group-item-action p-3 {{ !$isValid ? 'bg-light text-muted' : '' }}" 
                                onclick="applyCoupon('{{ $voucher->ma_code }}')"
                                {{ !$isValid ? 'disabled' : '' }}>
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 fw-bold {{ $isValid ? 'text-primary' : '' }}">
                                            {{ $voucher->ma_code }}
                                        </h6>
                                        <p class="mb-1 small">
                                            {{ $voucher->loai_giamgia == 'percent' ? __('Discount') . " {$voucher->giatri}%" : __('Discount') . " " . number_format($voucher->giatri)."đ" }}
                                        </p>
                                        <small class="text-muted">
                                            {{ __('Min order') }}: {{ number_format($voucher->dieukien_toithieu) }}đ
                                        </small>
                                    </div>
                                    @if(!$isValid)
                                        <span class="badge bg-secondary">{{ __('Not eligible') }}</span>
                                    @else
                                        <span class="badge bg-success rounded-pill">{{ __('Use now') }}</span>
                                    @endif
                                </div>
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>
</div>
{{-- ============================================ --}}

{{-- STYLES & SCRIPTS --}}
<link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
{{-- Tự động chọn ngôn ngữ cho Flatpickr dựa trên Locale hiện tại --}}
@if(app()->getLocale() == 'vi')
<script src="https://npmcdn.com/flatpickr/dist/l10n/vn.js"></script>
@endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // === HÀM CHỌN COUPON TỪ MODAL ===
    function applyCoupon(code) {
        document.getElementById('coupon_code').value = code;
        // Đóng modal bằng Bootstrap 5 API
        var myModalEl = document.getElementById('voucherModal');
        var modal = bootstrap.Modal.getInstance(myModalEl);
        modal.hide();
    }

    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. CẤU HÌNH LỊCH THÔNG MINH ---
        const configCommon = {
            enableTime: true,
            dateFormat: "Y-m-d H:i", 
            altInput: true,
            altFormat: "l, d/m/Y \\l\\ú\\c H:i", // Giữ nguyên format này hoặc đổi tùy nhu cầu
            minDate: "today",
            time_24hr: true,
            locale: "{{ app()->getLocale() == 'vi' ? 'vn' : 'en' }}", // Tự động đổi ngôn ngữ lịch
            disableMobile: "true"
        };

        // Khởi tạo Lịch Lấy Hàng
        const fpLayHang = flatpickr("#picker_lay_hang", {
            ...configCommon,
            minDate: "today",
            minTime: "07:00",
            maxTime: "21:00",
            // LOGIC THÔNG MINH TẠI ĐÂY
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length > 0) {
                    const ngayLay = selectedDates[0];
                    
                    // Tính ngày trả tối thiểu (Ngày lấy + 24 tiếng)
                    const ngayGiaoToiThieu = new Date(ngayLay.getTime() + (24 * 60 * 60 * 1000));

                    // Cập nhật cấu hình cho lịch Giao Hàng
                    fpGiaoHang.set('minDate', ngayGiaoToiThieu); 
                    fpGiaoHang.setDate(ngayGiaoToiThieu); // Tự động điền ngày giao gợi ý
                    
                    // Mở khóa input giao hàng
                    const pickerGiao = document.getElementById('picker_giao_hang');
                    pickerGiao.disabled = false;
                    pickerGiao.placeholder = "{{ __('Click to change time...') }}"; // Đã dịch
                }
            }
        });

        // Khởi tạo Lịch Giao Hàng (Ban đầu khóa)
        const fpGiaoHang = flatpickr("#picker_giao_hang", {
            ...configCommon,
            minTime: "07:00",
            maxTime: "21:00",
        });

        // Fix lỗi UX: Nếu form reload (do validate sai), và đã có giá trị cũ -> Mở khóa ô Giao Hàng ngay
        if(document.getElementById('picker_lay_hang').value !== "") {
             document.getElementById('picker_giao_hang').disabled = false;
        }

        // --- 2. BẮT LỖI FORM TRƯỚC KHI GỬI ---
        const form = document.getElementById('checkoutForm');
        
        form.addEventListener('submit', function(e) {
            const name = form.querySelector('[name="tenkhachhang"]').value.trim();
            const phone = form.querySelector('[name="sdt_khachhang"]').value.trim();
            const address = form.querySelector('[name="diachigiaonhan"]').value.trim();
            const timePickup = document.getElementById('picker_lay_hang').value;
            const timeDelivery = document.getElementById('picker_giao_hang').value;

            let errorMsg = '';

            // Dùng Blade echo để inject chuỗi dịch vào JS
            if (!name) errorMsg += '<li>{{ __("Missing full name") }}</li>';
            if (!phone) errorMsg += '<li>{{ __("Missing phone number") }}</li>';
            if (!address) errorMsg += '<li>{{ __("Missing address") }}</li>';
            if (!timePickup) errorMsg += '<li>{{ __("Missing pickup time") }}</li>';
            if (!timeDelivery) errorMsg += '<li>{{ __("Missing delivery time") }}</li>';

            if (errorMsg) {
                e.preventDefault(); 
                Swal.fire({
                    icon: 'warning',
                    title: '{{ __("Incomplete information") }}',
                    html: `<ul class="text-start fs-6 mb-0">${errorMsg}</ul>`,
                    confirmButtonColor: '#ffc107',
                    confirmButtonText: '{{ __("Understood") }}'
                });
            }
        });

        // --- 3. HIỂN THỊ THÔNG BÁO TỪ SERVER (SESSION) ---
        const sessionError = @json(session('error'));
        const sessionSuccess = @json(session('success'));

        if (sessionError) {
            Swal.fire({
                icon: 'error',
                title: '{{ __("An error occurred") }}',
                text: sessionError,
                confirmButtonColor: '#dc3545'
            });
        } 
        else if (sessionSuccess) {
            Swal.fire({
                icon: 'success',
                title: '{{ __("Booking successful!") }}',
                text: sessionSuccess,
                confirmButtonColor: '#198754',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = "{{ route('dashboard') }}"; 
            });
        }
    });
</script>

<style>
    /* CSS Tùy chỉnh */
    .flatpickr-input {
        background-color: white !important; /* Đảm bảo nền trắng dù là readonly */
    }
    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
    }
    /* Tăng kích thước lịch cho dễ bấm trên điện thoại */
    .flatpickr-calendar {
        font-family: system-ui, -apple-system, sans-serif !important;
    }
    .flatpickr-day {
        font-size: 110%;
    }
    /* Style cho voucher list */
    .list-group-item.disabled {
        opacity: 0.6;
        background-color: #e9ecef;
    }
</style>
@endsection