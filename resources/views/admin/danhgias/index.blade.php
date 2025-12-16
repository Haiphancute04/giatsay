@extends('layouts.admin')

@section('title', __('Review Management'))


@section('content')

<div class="card-custom">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold m-0">📊 {{ __('Review Management') }}</h3>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-custom table-bordered align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th class="fw-bold text-center" style="width: 60px;">{{ __('ID') }}</th>
                    <th class="fw-bold text-center">{{ __('User') }}</th>
                    <th class="fw-bold text-center">{{ __('Service Name') }}</th>
                    <th class="fw-bold text-center" style="width: 90px;">{{ __('Rating') }}</th>
                    <th class="fw-bold text-center">{{ __('Comment') }}</th>
                    <th class="fw-bold text-center" style="width: 120px;">{{ __('Statuses') }}</th>
                    <th class="fw-bold text-center" style="width: 140px;">{{ __('Actions') }}</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($danhGias as $danhGia)
                    <tr>
                        <td class="fw-bold text-primary text-center">#{{ $danhGia->id }}</td>

                        <td class="text-center">
                            @if ($danhGia->user)
                                <div class="d-flex flex-column align-items-center">
                                    {{-- Sử dụng avatar_url từ Model User để xử lý ảnh storage, ảnh online hoặc ảnh mặc định --}}
                                    <img src="{{ $danhGia->user->avatar_url }}"
                                         alt="{{ $danhGia->user->name }}"
                                         class="rounded-circle border mb-1"
                                         style="width: 40px; height: 40px; object-fit: cover;">
                                    
                                    <span class="fw-semibold small">{{ $danhGia->user->name }}</span>
                                    
                                    {{-- Hiển thị email nhỏ bên dưới (tùy chọn) --}}
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ $danhGia->user->email }}</small>
                                </div>
                            @else
                                <span class="text-muted fst-italic">{{ __('User deleted') }}</span>
                            @endif
                        </td>

                        <td class="fw-semibold text-center">{{ $danhGia->dichVu->tendichvu ?? 'N/A' }}</td>

                        <td class="rating-star text-center">
                            {{ $danhGia->rating }} ★
                        </td>

                        <td style="max-width: 350px;">
                            {{ $danhGia->binhluan }}
                        </td>

                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                @if ($danhGia->trangthai)
                                    <span class="badge bg-success">{{ __('Approved') }}</span>
                                @else
                                    <span class="badge bg-warning text-dark">{{ __('Pending') }}</span>
                                @endif
                            </div>
                        </td>

                        <td>
                            <div class="d-flex gap-2">
                                <form action="{{ route('admin.danhgias.toggleStatus', $danhGia->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    @if ($danhGia->trangthai)
                                        <button type="submit" class="btn btn-secondary btn-sm btn-action" style="min-width: 60px;">
                                            {{ __('Hide') }}
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-success btn-sm btn-action" style="min-width: 60px;">
                                            {{ __('Approve') }}
                                        </button>
                                    @endif
                                </form>
                                <form action="{{ route('admin.danhgias.destroy', $danhGia->id) }}"
                                  method="POST" 
                                  class="d-inline" 
                                 onsubmit="return confirm('{{ __('Are you sure delete review of') }} {{ $danhGia->user->name ?? 'User' }}?');">
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
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-3">
                            {{ __('No reviews yet') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    <div class="mt-3">
        {{ $danhGias->links() }}
    </div>

</div>

@endsection