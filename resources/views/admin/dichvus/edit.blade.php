@extends('layouts.admin')

@section('title', __('Update Service'))

@section('content')

<div class="card-wrapper">

    <h3 class="fw-bold mb-4">🛠️ {{ __('Update Service') }}: {{ $dichVu->tendichvu }}</h3>

    <form action="{{ route('admin.dich-vus.update', $dichVu->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="tendichvu" class="form-label">{{ __('Service Name') }}</label>
                    <input type="text" class="form-control @error('tendichvu') is-invalid @enderror" 
                           id="tendichvu" name="tendichvu" value="{{ old('tendichvu', $dichVu->tendichvu) }}">
                    @error('tendichvu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label for="motadichvu" class="form-label">{{ __('Description') }}</label>
                    <textarea class="form-control @error('motadichvu') is-invalid @enderror" 
                              id="motadichvu" name="motadichvu" rows="6">{{ old('motadichvu', $dichVu->motadichvu) }}</textarea>
                    @error('motadichvu')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="col-md-4">
                <div class="mb-3">
                    <label for="danhmuc_id" class="form-label">{{ __('Categories') }}</label>
                    <select class="form-select @error('danhmuc_id') is-invalid @enderror" id="danhmuc_id" name="danhmuc_id">
                        <option value="">-- {{ __('Categories') }} --</option>
                        @foreach ($danhMucs as $danhMuc)
                            <option value="{{ $danhMuc->id }}" 
                                {{ old('danhmuc_id', $dichVu->danhmuc_id) == $danhMuc->id ? 'selected' : '' }}>
                                {{ $danhMuc->tendanhmuc }}
                            </option>
                        @endforeach
                    </select>
                    @error('danhmuc_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3 border p-3 rounded bg-light">
                    <label class="form-label fw-bold">{{ __('Price Settings') }}</label>
                    
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" value="1" id="la_gia_dao_dong" name="la_gia_dao_dong" 
                            {{ old('la_gia_dao_dong', $dichVu->la_gia_dao_dong) ? 'checked' : '' }}>
                        <label class="form-check-label" for="la_gia_dao_dong">
                            {{ __('Is variable price') }}
                        </label>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-2">
                            <label for="dongia" class="form-label" id="label_dongia">{{ __('Unit price') }} (VNĐ)</label>
                            <input type="number" class="form-control @error('dongia') is-invalid @enderror" 
                                   id="dongia" name="dongia" value="{{ old('dongia', $dichVu->dongia) }}">
                            @error('dongia')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-12" id="box_dongia_toida" style="display: none;">
                            <label for="dongia_toida" class="form-label">{{ __('To price') }} (VNĐ)</label>
                            <input type="number" class="form-control @error('dongia_toida') is-invalid @enderror" 
                                   id="dongia_toida" name="dongia_toida" value="{{ old('dongia_toida', $dichVu->dongia_toida) }}">
                            @error('dongia_toida')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="donvitinh" class="form-label">Đơn vị tính</label>
                    <input type="text" class="form-control @error('donvitinh') is-invalid @enderror" 
                           id="donvitinh" name="donvitinh" value="{{ old('donvitinh', $dichVu->donvitinh) }}">
                    @error('donvitinh')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">{{ __('Image') }}</label>
                    
                    @if($dichVu->hinhanh)
                        <div class="mb-3 p-2 border rounded bg-white text-center">
                            <div class="text-muted small mb-1">{{ __('Current Image') }}:</div>
                            <img src="{{ asset('hello/' . $dichVu->hinhanh) }}" 
                                 alt="Image" 
                                 class="img-thumbnail shadow-sm"
                                 style="max-width: 100%; max-height: 200px; object-fit: contain;">
                        </div>
                    @else
                        <div class="alert alert-warning py-2 small">{{ __('No image') }}</div>
                    @endif

                    <label class="form-label mt-2">{{ __('Change image') }}</label>
                    
                    {{-- Custom File Input --}}
                    <div class="input-group">
                        <label class="input-group-text btn btn-outline-secondary" for="hinhanh" style="cursor: pointer;">
                            {{ __('Choose File') }}
                        </label>
                        <input type="text" class="form-control bg-white text-muted" readonly id="file-name-display-service-edit" 
                               placeholder="{{ __('No file chosen') }}" 
                               onclick="document.getElementById('hinhanh').click()" style="cursor: pointer;">
                    </div>
                    <input class="d-none @error('hinhanh') is-invalid @enderror" type="file" id="hinhanh" name="hinhanh"
                           onchange="document.getElementById('file-name-display-service-edit').value = this.files[0] ? this.files[0].name : ''">
                    @error('hinhanh')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>

        <div class="mt-4 d-flex gap-2 border-top pt-3">
            <button type="submit" class="btn btn-primary btn-submit">
                <i class="material-symbols-outlined align-middle" style="font-size: 18px;">save</i> {{ __('Update') }}
            </button>
            <a href="{{ route('admin.dich-vus.index') }}" class="btn btn-secondary btn-cancel">
                <i class="material-symbols-outlined align-middle" style="font-size: 18px;">arrow_back</i> {{ __('Back') }}
            </a>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkbox = document.getElementById('la_gia_dao_dong');
        const boxMaxPrice = document.getElementById('box_dongia_toida');
        const labelMinPrice = document.getElementById('label_dongia');

        function togglePriceInputs() {
            if (checkbox.checked) {
                boxMaxPrice.style.display = 'block';
                if(labelMinPrice) labelMinPrice.textContent = '{{ __("Minimum Price") }} (VNĐ)';
            } else {
                boxMaxPrice.style.display = 'none';
                if(labelMinPrice) labelMinPrice.textContent = '{{ __("Unit price") }} (VNĐ)';
            }
        }
        togglePriceInputs();
        checkbox.addEventListener('change', togglePriceInputs);
    });
</script>

@endsection