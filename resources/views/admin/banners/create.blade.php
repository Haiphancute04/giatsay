@extends('layouts.admin')

@section('content')
<div class="card-wrapper">
    <h3 class="mb-4">{{ __('Add New Banner') }}</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
        @csrf
        
        {{-- Phần Hình ảnh (Giữ nguyên) --}}
        <div class="mb-3">
            <label class="form-label">{{ __('Image') }} (*)</label>
            <div class="input-group">
                <label class="input-group-text btn btn-outline-secondary" for="image">{{ __('Choose File') }}</label>
                <input type="text" class="form-control bg-white text-muted" readonly id="file-name-display-banner" 
                       placeholder="{{ __('No file chosen') }}" onclick="document.getElementById('image').click()">
            </div>
            <input type="file" name="image" id="image" class="d-none" required
                   onchange="document.getElementById('file-name-display-banner').value = this.files[0] ? this.files[0].name : ''">
        </div>

        {{-- TABS CHUYỂN ĐỔI NGÔN NGỮ --}}
        <ul class="nav nav-tabs mb-3" id="langTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="vi-tab" data-bs-toggle="tab" data-bs-target="#vi" type="button" role="tab">🇻🇳 Tiếng Việt</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="en-tab" data-bs-toggle="tab" data-bs-target="#en" type="button" role="tab">🇬🇧 English</button>
            </li>
        </ul>

        <div class="tab-content mb-3" id="langTabContent">
            {{-- Tab Tiếng Việt --}}
            <div class="tab-pane fade show active" id="vi" role="tabpanel">
                <div class="mb-3">
                    <label class="form-label">Tiêu đề (VI)</label>
                    <input type="text" name="title_vi" class="form-control" value="{{ old('title_vi') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Mô tả (VI)</label>
                    <textarea name="description_vi" class="form-control" rows="3">{{ old('description_vi') }}</textarea>
                </div>
            </div>

            {{-- Tab Tiếng Anh --}}
            <div class="tab-pane fade" id="en" role="tabpanel">
                <div class="mb-3">
                    <label class="form-label">Title (EN)</label>
                    <input type="text" name="title_en" class="form-control" value="{{ old('title_en') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description (EN)</label>
                    <textarea name="description_en" class="form-control" rows="3">{{ old('description_en') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Các phần chung khác --}}
        <div class="mb-3">
            <label class="form-label">{{ __('Link') }}</label>
            <input type="text" name="link" class="form-control" value="{{ old('link') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Order') }}</label>
            <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" id="active" checked>
            <label class="form-check-label" for="active">{{ __('Show Immediately') }}</label>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
    </form>
</div>
@endsection