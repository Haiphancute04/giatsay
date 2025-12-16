@extends('layouts.admin')
@section('title', __('Update Status'))

@section('content')
<div class="card-wrapper" style="max-width: 600px; margin: 0 auto;">
    <h3 class="fw-bold mb-4">{{ __('Update Status') }}</h3>

    <form action="{{ route('admin.tinh-trangs.update', $tinhTrang->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">{{ __('Status Name System') }}</label>
            <input type="text" name="ten_trangthai" class="form-control" value="{{ $tinhTrang->ten_trangthai }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Display Name') }}</label>
            <input type="text" name="ten_hienthi" class="form-control" value="{{ $tinhTrang->ten_hienthi }}">
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Color') }}</label>
            <select name="mau_sac" class="form-control">
                @php 
                    $colors = [
                        'secondary' => __('Gray'), 
                        'primary' => __('Blue'), 
                        'info' => __('Light Blue'), 
                        'success' => __('Green'), 
                        'warning' => __('Yellow'), 
                        'danger' => __('Red'), 
                        'dark' => __('Black')
                    ]; 
                @endphp
                @foreach($colors as $value => $label)
                    <option value="{{ $value }}" {{ $tinhTrang->mau_sac == $value ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>

        <a href="{{ route('admin.tinh-trangs.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    </form>
</div>
@endsection