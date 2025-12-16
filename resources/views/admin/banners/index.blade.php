@extends('layouts.admin')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3 class="fw-bold m-0">🖼️{{ __('Banner Management') }}</h3>
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary btn-add">
        <span class="material-symbols-outlined">add</span>
        {{ __('Add New Banner') }}
    </a>
</div>

<table class="table table-custom table-bordered align-middle table-hover">
    <thead class="table-light">
        <tr>
            <th class="fw-bold text-center">{{ __('Image') }}</th>
            <th class="fw-bold text-center">{{ __('Title') }}</th>
            <th class="fw-bold text-center">{{ __('Order') }}</th>
            <th class="fw-bold text-center">{{ __('status') }}</th>
            <th class="fw-bold text-center">{{ __('Actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($banners as $banner)
        <tr>
            <td>
                <div class="d-flex justify-content-center gap-1">
                    <img src="{{ asset('hello/' . $banner->image) }}" width="150" style="object-fit: cover; border-radius: 5px;">
                </div>
            </td>
            <td>{{ $banner->title }}</td>
            <td class="text-center">{{ $banner->order }}</td>
            
            <td>
                <form action="{{ route('admin.banners.update', $banner) }}" method="POST">
                    @csrf 
                    @method('PUT')
                    
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" 
                               name="is_active" 
                               onchange="this.form.submit()"
                               style="cursor: pointer;"
                               {{ $banner->is_active ? 'checked' : '' }}>
                               
                        <label class="form-check-label small text-muted">
                            {{ $banner->is_active ? __('Active') : __('Locked') }}
                        </label>
                    </div>
                </form>
            </td>

            <td>
                <div class="d-flex justify-content-center gap-1">
                    <a href="{{ route('admin.banners.edit', $banner) }}"
                        class="btn btn-warning btn-action text-white">
                        <span class="material-symbols-outlined" style="font-size:18px;">edit</span>
                        {{ __('Edit') }}
                    </a>
                    <form action="{{ route('admin.banners.destroy', $banner) }}"
                        method="POST"
                        class="d-inline"
                        onsubmit="return confirm('{{ __('Are you sure delete') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-action">
                            <span class="material-symbols-outlined" style="font-size:18px;">delete</span>
                            {{ __('Delete') }}
                        </button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection