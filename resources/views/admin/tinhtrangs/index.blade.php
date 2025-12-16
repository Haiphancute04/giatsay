@extends('layouts.admin')

@section('title', __('Status Management'))

@section('content')
<div class="card-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold m-0">🏷️ {{ __('Status Management') }}</h3>
        <a href="{{ route('admin.tinh-trangs.create') }}" class="btn btn-primary btn-add">
            <span class="material-symbols-outlined">add</span> {{ __('Add New Status') }}
        </a>
    </div>

    @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if (session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <div class="table-responsive">
        <table class="table table-custom table-bordered align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th class="fw-bold text-center" style="width: 50px;">{{ __('ID') }}</th>
                    <th class="fw-bold text-center">{{ __('Status Name System') }}</th>
                    <th class="fw-bold text-center">{{ __('Display Name') }}</th>
                    <th class="fw-bold text-center">{{ __('Color') }} (Badge)</th>
                    <th class="fw-bold text-center" style="width: 180px;">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tinhTrangs as $item)
                    <tr>
                        <td class="fw-bold text-primary text-center">#{{ $item->id }}</td>
                        
                        {{-- SỬA Ở ĐÂY: Thêm hàm __() để dịch --}}
                        <td class="text-center">{{ __($item->ten_trangthai) }}</td>
                        <td class="text-center">{{ __($item->ten_hienthi) }}</td>
                        
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                {{-- SỬA Ở CẢ ĐÂY: Để Badge cũng được dịch --}}
                                <span class="badge bg-{{ $item->mau_sac }}">
                                    {{ __($item->ten_hienthi ?? $item->ten_trangthai) }}
                                </span>
                            </div>
                        </td>
                        
                        {{-- Phần nút hành động giữ nguyên --}}
                        <td class="text-center">
                            <a href="{{ route('admin.tinh-trangs.edit', $item->id) }}" class="btn btn-warning btn-action text-white">
                                <span class="material-symbols-outlined" style="font-size:18px;">edit</span>
                                {{ __('Edit') }}
                            </a>
                            {{-- ...Form xóa giữ nguyên... --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-3">
        {{ $tinhTrangs->links() }}
    </div>
</div>
@endsection