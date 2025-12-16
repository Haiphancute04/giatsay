@extends('layouts.admin')
@section('title', __('Add New Status'))

@section('content')
<div class="card-wrapper" style="max-width: 600px; margin: 0 auto;">
    <h3 class="fw-bold mb-4">{{ __('Add New Status') }}</h3>

    <form action="{{ route('admin.tinh-trangs.store') }}" method="POST">
        @csrf
        
        <div class="mb-3">
            <label class="form-label">{{ __('Status Name System') }}</label>
            <input type="text" name="ten_trangthai" class="form-control" placeholder="{{ __('Ex: DaGiaoHang') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Display Name') }} ({{ __('Short') }})</label>
            <input type="text" name="ten_hienthi" class="form-control" placeholder="{{ __('Ex: Delivered') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('Color') }}</label>
            <select name="mau_sac" class="form-control">
                <option value="secondary">{{ __('Gray') }}</option>
                <option value="primary">{{ __('Blue') }}</option>
                <option value="info">{{ __('Light Blue') }}</option>
                <option value="success">{{ __('Green') }}</option>
                <option value="warning">{{ __('Yellow') }}</option>
                <option value="danger">{{ __('Red') }}</option>
                <option value="dark">{{ __('Black') }}</option>
            </select>
        </div>

        <a href="{{ route('admin.tinh-trangs.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
    </form>
</div>
@endsection