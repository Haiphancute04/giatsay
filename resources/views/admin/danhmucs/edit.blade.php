@extends('layouts.admin')

@section('title', __('Update Category'))

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0">{{ __('Update Category') }}</h3>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <form action="{{ route('admin.danh-mucs.update', $danhMuc->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="tendanhmuc" class="form-label fw-semibold">{{ __('Category Name') }}</label>
                        <input type="text" 
                               class="form-control form-control-lg @error('tendanhmuc') is-invalid @enderror" 
                               id="tendanhmuc" 
                               name="tendanhmuc" 
                               placeholder="{{ __('Category Name') }}"
                               value="{{ old('tendanhmuc', $danhMuc->tendanhmuc) }}">
                        
                        @error('tendanhmuc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> {{ __('Update') }}
                        </button>

                        <a href="{{ route('admin.danh-mucs.index') }}" class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i> {{ __('Cancel') }}
                        </a>
                    </div>
                </form>

            </div>
        </div>

    </div>
@endsection