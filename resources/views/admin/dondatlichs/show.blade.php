@extends('layouts.admin')
@section('title', __('Order Details') . ' #' . $donDatLich->id)

@section('content')
<div class="card-wrapper">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">📄 {{ __('Order Details') }} #{{ $donDatLich->id }}</h3>
        <a href="{{ route('admin.dondatlichs.index') }}" class="btn btn-secondary">← {{ __('Back') }}</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        
        <div class="col-lg-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light fw-bold">🛒 {{ __('service information') }}</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>{{ __('Service Name') }}</th>
                                <th class="text-center">{{ __('Quantity') }}</th>
                                <th class="text-end">{{ __('Unit price') }}</th>
                                <th class="text-end">{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($donDatLich->chiTietDonDatLichs as $chitiet)
                            <tr>
                                <td>{{ $chitiet->dichVu->tendichvu ?? __('Service deleted') }}</td>
                                <td class="text-center">{{ $chitiet->soluong }}</td>
                                <td class="text-end">{{ number_format($chitiet->dongia) }} đ</td>
                                <td class="text-end">{{ number_format($chitiet->thanhtien) }} đ</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="fw-bold">
                            <tr>
                                <td colspan="3" class="text-end">{{ __('Subtotal') }}:</td>
                                <td class="text-end">{{ number_format($donDatLich->tamtinh) }} đ</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end text-danger">
                                    {{ __('Discount') }}
                                    @if($donDatLich->maGiamGia)
                                        (Code: {{ $donDatLich->maGiamGia->ma_code }})
                                    @endif
                                    :
                                </td>
                                <td class="text-end text-danger">
                                    - {{ number_format($donDatLich->tien_giamgia) }} đ
                                </td>
                            </tr>
                            <tr class="fs-5 text-primary">
                                <td colspan="3" class="text-end">{{ __('Total Amount') }}:</td>
                                <td class="text-end">{{ number_format($donDatLich->tongtien) }} đ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light fw-bold">🚚 {{ __('Shipping & Time Information') }}</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="small text-muted">{{ __('Pickup Time') }}:</label>
                            <p class="fw-bold">{{ $donDatLich->thoi_gian_lay_hang ? \Carbon\Carbon::parse($donDatLich->thoi_gian_lay_hang)->format('d/m/Y H:i') : '---' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="small text-muted">{{ __('Expected Delivery Time') }}:</label>
                            <p class="fw-bold">{{ $donDatLich->thoi_gian_giao_hang_du_kien ? \Carbon\Carbon::parse($donDatLich->thoi_gian_giao_hang_du_kien)->format('d/m/Y H:i') : '---' }}</p>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="small text-muted">{{ __('Pickup/Delivery Address') }}:</label>
                        <p class="border p-2 rounded bg-light">{{ $donDatLich->diachigiaonhan }}</p>
                    </div>
                     <div class="mb-0">
                        <label class="small text-muted">{{ __('Customer Note') }}:</label>
                        <p class="border p-2 rounded bg-light text-break fst-italic">
                            {{ $donDatLich->ghichu ?? __('No notes') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            
            <div class="card mb-4 shadow-sm border-primary">
                <div class="card-header bg-primary text-white fw-bold">⚡ {{ __('Order Processing') }}</div>
                <div class="card-body">
                    <form action="{{ route('admin.dondatlichs.updateStatus', $donDatLich->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label fw-bold">{{ __('status') }}:</label>
                            <select name="tinhtrang_id" class="form-select form-select-lg">
                                @foreach($tinhTrangs as $tt)
                                    <option value="{{ $tt->id }}" {{ $donDatLich->tinhtrang_id == $tt->id ? 'selected' : '' }}>
                                        {{ $tt->ten_hienthi }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">{{ __('Update Status') }}</button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-light fw-bold">👤 {{ __('Customer Information') }}</div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <span class="text-muted">{{ __('Full name') }}:</span> <br>
                            <span class="fw-bold fs-5">{{ $donDatLich->tenkhachhang }}</span>
                        </li>
                        <li class="mb-2">
                            <span class="text-muted">{{ __('Phone number') }}:</span> <br>
                            <a href="tel:{{ $donDatLich->sdt_khachhang }}" class="fw-bold">{{ $donDatLich->sdt_khachhang }}</a>
                        </li>
                        <li class="mb-2">
                            <span class="text-muted">{{ __('Account Type') }}:</span> <br>
                            @if($donDatLich->user_id)
                                <span class="badge bg-info">{{ __('Member') }} (ID: {{ $donDatLich->user_id }})</span>
                            @else
                                <span class="badge bg-secondary">{{ __('Guest') }}</span>
                            @endif
                        </li>
                        <li>
                            <span class="text-muted">{{ __('Review') }}:</span> <br>
                            @if($donDatLich->trangthai_danhgia)
                                <span class="text-success fw-bold">✓ {{ __('Rated') }}</span>
                            @else
                                <span class="text-secondary">{{ __('Not Rated') }}</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection