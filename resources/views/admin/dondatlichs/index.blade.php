@extends('layouts.admin')
@section('title', __('Order Management'))

@section('content')
<div class="card-wrapper">
    <h3 class="fw-bold mb-4">📦 {{ __('Order Management') }}</h3>

    {{-- [GIỮ NGUYÊN] Form tìm kiếm --}}
    <div class="mb-4">
        <form method="GET" action="{{ route('admin.dondatlichs.index') }}" class="d-flex gap-2">
            <div class="input-group" style="max-width: 400px;">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="text" 
                       name="search" 
                       class="form-control" 
                       placeholder="{{ __('Nhập tên khách hàng...') }}" 
                       value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">{{ __('Tìm kiếm') }}</button>
            </div>
            
            @if(request('search'))
                <a href="{{ route('admin.dondatlichs.index') }}" class="btn btn-outline-secondary">
                    {{ __('Xóa lọc') }}
                </a>
            @endif
        </form>
    </div>

    

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th class="fw-bold text-center">ID</th>
                    <th class="fw-bold text-center">{{ __('Customer') }}</th>
                    <th class="fw-bold text-center">{{ __('Time') }}</th>
                    <th class="fw-bold text-center">{{ __('Total Amount') }}</th>
                    <th class="fw-bold text-center">{{ __('status') }}</th>
                    <th class="fw-bold text-center">{{ __('Note') }}</th>
                    <th class="fw-bold text-center">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donDatLichs as $item)
                <tr>
                    <td class="fw-bold text-primary text-center">#{{ $item->id }}</td>
                    
                    <td>
                        <div class="fw-bold">
                            <i class="bi bi-person-fill me-1"></i> {{ $item->tenkhachhang }}
                        </div>
                        <div class="small text-muted">
                            <i class="bi bi-telephone-fill me-1"></i> {{ $item->sdt_khachhang }}
                        </div>
                    </td>
                    
                    <td>
                        <div class="small">{{ __('Pick up') }}: {{ $item->thoi_gian_lay_hang ? \Carbon\Carbon::parse($item->thoi_gian_lay_hang)->format('d/m/Y H:i') : '---' }}</div>
                        <div class="small text-muted">{{ __('Booking Date') }}: {{ $item->created_at->format('d/m/Y') }}</div>
                    </td>

                    <td class="fw-bold text-primary text-center">
                        {{ number_format($item->tongtien) }} đ
                    </td>

                    <td>
                        <div class="d-flex justify-content-center gap-1">
                            @if($item->tinhTrang)
                                <span class="badge bg-{{ $item->tinhTrang->mau_sac }}">
                                    {{ $item->tinhTrang->ten_hienthi }}
                                </span>
                            @else
                                <span class="badge bg-secondary">N/A</span>
                            @endif
                        </div>
                    </td>

                     <td>
                        <span class="text-truncate d-inline-block" style="max-width: 150px;" title="{{ $item->ghichu }}">
                            {{ $item->ghichu ?? __('Không có') }}
                        </span>
                    </td>

                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2"> 
                            <a href="{{ route('admin.dondatlichs.show', $item->id) }}" class="btn btn-sm btn-primary">
                                {{ __('Details') }}
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">{{ __('Không tìm thấy đơn đặt lịch nào phù hợp.') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    @if ($donDatLichs->hasPages())
        <div class="mb-3 bg-white py-2">
            <div class="d-flex justify-content-center">
                {{-- 
                   QUAN TRỌNG: Thêm ->appends(request()->all()) 
                   để giữ lại từ khóa tìm kiếm khi bấm chuyển trang 
                --}}
                {{ $donDatLichs->appends(request()->all())->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif

    
</div>
@endsection