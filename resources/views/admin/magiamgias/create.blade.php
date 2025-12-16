@extends('layouts.admin')

@section('title', __('Add New Coupon'))

@section('content')

<div class="card-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold m-0">➕ {{ __('Add New Coupon') }}</h3>
        <a href="{{ route('admin.ma-giam-gias.index') }}" class="btn btn-secondary btn-action">{{ __('Back') }}</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('admin.ma-giam-gias.store') }}" method="POST">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="ma_code" class="form-label fw-bold">{{ __('Code') }} <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('ma_code') is-invalid @enderror" id="ma_code" name="ma_code" value="{{ old('ma_code') }}" placeholder="{{ __('Ex: SALE2025') }}">
                    @error('ma_code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="soluong_phathanh" class="form-label fw-bold">{{ __('Issue Quantity') }} <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('soluong_phathanh') is-invalid @enderror" id="soluong_phathanh" name="soluong_phathanh" value="{{ old('soluong_phathanh') }}" placeholder="{{ __('Ex: 100') }}">
                    @error('soluong_phathanh')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="loai_giamgia" class="form-label fw-bold">{{ __('Discount Type') }}</label>
                    <select class="form-select @error('loai_giamgia') is-invalid @enderror" id="loai_giamgia" name="loai_giamgia">
                        <option value="fixed" {{ old('loai_giamgia') == 'fixed' ? 'selected' : '' }}>{{ __('Fixed Amount') }} (VNĐ)</option>
                        <option value="percent" {{ old('loai_giamgia') == 'percent' ? 'selected' : '' }}>{{ __('Percent') }} (%)</option>
                    </select>
                    @error('loai_giamgia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="giatri" class="form-label fw-bold">{{ __('Value') }} (VNĐ {{ __('Or') }} %) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('giatri') is-invalid @enderror" id="giatri" name="giatri" value="{{ old('giatri') }}" placeholder="{{ __('Ex: 20000 or 15') }}">
                    @error('giatri')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="dieukien_toithieu" class="form-label fw-bold">{{ __('Min Condition') }} (VNĐ)</label>
            <input type="number" class="form-control @error('dieukien_toithieu') is-invalid @enderror" id="dieukien_toithieu" name="dieukien_toithieu" value="{{ old('dieukien_toithieu') }}" placeholder="{{ __('Leave blank if none') }}">
            @error('dieukien_toithieu')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- UPDATE: DÙNG FLATPICKR --}}
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="picker_ngay_batdau" class="form-label fw-bold">{{ __('Start Date') }}</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-calendar-event"></i></span>
                        <input type="text" class="form-control bg-white" id="picker_ngay_batdau" name="ngay_batdau" 
                               value="{{ old('ngay_batdau') }}" 
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
                               value="{{ old('ngay_ketthuc') }}" 
                               placeholder="{{ __('Select end date and time...') }}" readonly style="cursor: pointer;">
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">{{ __('Status') }}</label>
            <select class="form-select" name="trangthai">
                <option value="1" {{ old('trangthai', 1) == 1 ? 'selected' : '' }}>{{ __('Active') }}</option>
                <option value="0" {{ old('trangthai') == 0 ? 'selected' : '' }}>{{ __('Locked') }}</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-action">{{ __('Save') }}</button>
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
            locale: "vn", // Nếu muốn đa ngôn ngữ ở lịch, có thể dùng: "{{ app()->getLocale() }}" và load file js tương ứng
            disableMobile: "true"
        };

        // 1. Cấu hình Ngày bắt đầu
        const fpBatDau = flatpickr("#picker_ngay_batdau", {
            ...configCommon,
            minDate: "today", // Không cho chọn ngày quá khứ khi tạo mới
            onChange: function(selectedDates, dateStr, instance) {
                // Khi chọn ngày bắt đầu xong, cập nhật giới hạn cho ngày kết thúc
                if (selectedDates.length > 0) {
                    fpKetThuc.set('minDate', selectedDates[0]);
                }
            }
        });

        // 2. Cấu hình Ngày kết thúc
        const fpKetThuc = flatpickr("#picker_ngay_ketthuc", {
            ...configCommon,
            minDate: "today"
        });
    });
</script>

@endsection