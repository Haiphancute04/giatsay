@extends('layouts.admin')

@section('title', __('Coupon Management'))

@section('content')

<div class="card-wrapper">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold m-0">🎟️ {{ __('Coupon Management') }}</h3>
        <a href="{{ route('admin.ma-giam-gias.create') }}" class="btn btn-primary btn-add">
            <span class="material-symbols-outlined">add</span>
            {{ __('Add New Coupon') }}
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-custom table-bordered align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th class="fw-bold text-center">{{ __('ID') }}</th>
                    <th class="fw-bold text-center">{{ __('Code') }}</th>
                    <th class="fw-bold text-center">{{ __('Discount Type') }}</th>
                    <th class="fw-bold text-center">{{ __('Value') }}</th>
                    <th class="fw-bold text-center">{{ __('Issue Quantity') }}</th>
                    <th class="fw-bold text-center">{{ __('Used') }}</th>
                    <th class="fw-bold text-center">{{ __('Statuses') }}</th>
                    <th class="fw-bold text-center" style="width: 190px;">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($maGiamGias as $maGiamGia)
                    <tr>
                        <td class="fw-bold text-primary text-center">#{{ $maGiamGia->id }}</td>
                        <td class="fw-semibold text-center">{{ $maGiamGia->ma_code }}</td>
                        <td class="text-center">
                            @if ($maGiamGia->loai_giamgia == 'percent')
                                <span class="badge-status" style="background-color: #a79628ff;">{{ __('Percent') }}</span>
                            @else
                                <span class="badge-status" style="background-color: #7d6c76ff;">{{ __('Fixed Amount') }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if ($maGiamGia->loai_giamgia == 'percent')
                                <span class="badge-status" style="background-color: #a79628ff;">{{ $maGiamGia->giatri }}%</span>
                            @else
                                <span class="badge-status" style="background-color: #7d6c76ff;">{{ number_format($maGiamGia->giatri) }} đ</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $maGiamGia->soluong_phathanh }}</td>
                        <td class="text-center">{{ $maGiamGia->soluong_dasudung }}</td>
                        <td class="text-center">
                            @if ($maGiamGia->trangthai)
                                <span class="badge-status" style="background-color: #28a745;">{{ __('Active') }}</span>
                            @else
                                <span class="badge-status" style="background-color: #6c757d;">{{ __('Locked') }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.ma-giam-gias.edit', $maGiamGia->id) }}" class="btn btn-warning btn-action text-white">
                                <span class="material-symbols-outlined" style="font-size:18px;">edit</span>
                                {{ __('Edit') }}
                            </a>
                            <form action="{{ route('admin.ma-giam-gias.destroy', $maGiamGia->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure delete') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-action">
                                    <span class="material-symbols-outlined" style="font-size:18px;">delete</span>
                                    {{ __('Delete') }}
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-3">
                            {{ __('No coupons found') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $maGiamGias->links() }}
    </div>

</div>

@endsection