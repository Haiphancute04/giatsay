@extends('layouts.admin')

@section('title', __('Update Coupon'))

@section('content')

<div class="card-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold m-0">✏️ {{ __('Update Coupon') }}</h3>
        <a href="{{ route('admin.ma-giam-gias.index') }}" class="btn btn-secondary btn-action">{{ __('Back') }}</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.ma-giam-gias.update', $maGiamGia->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="ma_code" class="form-label fw-bold">{{ __('Code') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('ma_code') is-invalid @enderror" id="ma_code" name="ma_code" value="{{ old('ma_code', $maGiamGia->ma_code) }}">
                    @error('ma_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="soluong_phathanh" class="form-label fw-bold">{{ __('Issue Quantity') }} <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('soluong_phathanh') is-invalid @enderror" id="soluong_phathanh" name="soluong_phathanh" value="{{ old('soluong_phathanh', $maGiamGia->soluong_phathanh) }}">
                    @error('soluong_phathanh')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="loai_giamgia" class="form-label fw-bold">{{ __('Discount Type') }}</label>
                    <select class="form-select @error('loai_giamgia') is-invalid @enderror" id="loai_giamgia" name="loai_giamgia">
                        <option value="fixed" {{ old('loai_giamgia', $maGiamGia->loai_giamgia) == 'fixed' ? 'selected' : '' }}>{{ __('Fixed Amount') }} (VNĐ)</option>
                        <option value="percent" {{ old('loai_giamgia', $maGiamGia->loai_giamgia) == 'percent' ? 'selected' : '' }}>{{ __('Percent') }} (%)</option>
                    </select>
                    @error('loai_giamgia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="giatri" class="form-label fw-bold">{{ __('Value') }} (VNĐ {{ __('Or') }} %) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('giatri') is-invalid @enderror" id="giatri" name="giatri" value="{{ old('giatri', $maGiamGia->giatri) }}">
                    @error('giatri')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="dieukien_toithieu" class="form-label fw-bold">{{ __('Min Condition') }} (VNĐ)</label>
            <input type="number" class="form-control @error('dieukien_toithieu') is-invalid @enderror" id="dieukien_toithieu" name="dieukien_toithieu" value="{{ old('dieukien_toithieu', $maGiamGia->dieukien_toithieu) }}">
            @error('dieukien_toithieu')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- UPDATE: FLATPICKR CHO TRANG EDIT --}}
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="picker_ngay_batdau" class="form-label fw-bold">{{ __('Start Date') }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-calendar-event"></i></span>
                        {{-- QUAN TRỌNG: Format value cũ để Flatpickr hiểu --}}
                        <input type="text" class="form-control bg-white" id="picker_ngay_batdau" name="ngay_batdau" 
                               value="{{ old('ngay_batdau', $maGiamGia->ngay_batdau ? \Carbon\Carbon::parse($maGiamGia->ngay_batdau)->format('Y-m-d H:i:00') : '') }}" 
                               placeholder="{{ __('Select start date and time...') }}" readonly style="cursor: pointer;">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="picker_ngay_ketthuc" class="form-label fw-bold">{{ __('End Date') }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-calendar-x"></i></span>
                        <input type="text" class="form-control bg-white" id="picker_ngay_ketthuc" name="ngay_ketthuc" 
                               value="{{ old('ngay_ketthuc', $maGiamGia->ngay_ketthuc ? \Carbon\Carbon::parse($maGiamGia->ngay_ketthuc)->format('Y-m-d H:i:00') : '') }}" 
                               placeholder="{{ __('Select end date and time...') }}" readonly style="cursor: pointer;">
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">{{ __('Status') }}</label>
            <select class="form-select" name="trangthai">
                <option value="1" {{ old('trangthai', $maGiamGia->trangthai) == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                <option value="0" {{ old('trangthai', $maGiamGia->trangthai) == 0 ? 'selected' : '' }}>{{ __('Locked') }}</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-action">{{ __('Update') }}</button>
            <a href="{{ route('admin.ma-giam-gias.index') }}" class="btn btn-secondary btn-action">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>

{{-- SCRIPT CẤU HÌNH LỊCH --}}
<link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/airbnb.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/vn.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const configCommon = {
            enableTime: true,
            dateFormat: "Y-m-d H:i:00", // Format chuẩn Database
            altInput: true,
            altFormat: "l, d/m/Y \\l\\ú\\c H:i", // Format hiển thị đẹp
            time_24hr: true,
            locale: "vn",
            disableMobile: "true"
        };

        // 1. Cấu hình Ngày bắt đầu
        const fpBatDau = flatpickr("#picker_ngay_batdau", {
            ...configCommon,
            // Với trang Edit, có thể muốn sửa lại ngày cũ nên không để minDate: "today" mặc định
            // Nếu muốn chặn chọn quá khứ, có thể bỏ comment dòng dưới:
            // minDate: "today", 
            onChange: function(selectedDates, dateStr, instance) {
                if (selectedDates.length > 0) {
                    fpKetThuc.set('minDate', selectedDates[0]);
                }
            }
        });

        // 2. Cấu hình Ngày kết thúc
        const fpKetThuc = flatpickr("#picker_ngay_ketthuc", {
            ...configCommon,
            // Khi load trang edit, set minDate của ngày kết thúc bằng ngày bắt đầu hiện tại (nếu có)
            minDate: document.getElementById('picker_ngay_batdau').value || null
        });
    });
</script>

@endsection