@extends('layouts.admin')

@section('title', __('Service Management'))

@section('content')

<div class="card-wrapper">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold m-0">🛎️ {{ __('Service Management') }}</h3>

        <div class="d-flex gap-2">
            {{-- 1. Nút Thêm mới --}}
            <a href="{{ route('admin.dich-vus.create') }}" class="btn btn-primary btn-add">
                <span class="material-symbols-outlined align-middle fs-5">add</span>
                {{ __('Add New Service') }}
            </a>

            {{-- 2. Nút Xuất Excel --}}
            <a href="{{ route('admin.dich-vus.export') }}" class="btn btn-success text-white">
                <span class="material-symbols-outlined align-middle fs-5">download</span>
                {{ __('Export Excel') }}
            </a>

            {{-- 3. Nút Nhập Excel (Mở Modal) --}}
            <button type="button" class="btn btn-warning text-dark" data-bs-toggle="modal" data-bs-target="#importModal">
                <span class="material-symbols-outlined align-middle fs-5">upload</span>
                {{ __('Import Excel') }}
            </button>
        </div>
    </div>

    @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if (session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <div class="table-responsive">
        <table class="table table-custom table-bordered align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th class="fw-bold text-center" style="width: 50px;">ID</th>
                    <th class="fw-bold text-center" style="width: 100px;">{{ __('Image') }}</th>
                    <th class="fw-bold text-center">{{ __('Service Name') }}</th>
                    <th class="fw-bold text-center">{{ __('Categories') }}</th>
                    <th class="fw-bold text-center">{{ __('Unit price') }}</th>
                    <th class="fw-bold text-center" style="width: 190px;">{{ __('Actions') }}</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($dichVus as $dichVu)
                    <tr>
                        <td class="fw-bold text-primary text-center">#{{ $dichVu->id }}</td>

                        <td class="text-center">
                            @if ($dichVu->hinhanh)
                                {{-- Code hiển thị ảnh --}}
                                <img src="{{ asset('storage/' . $dichVu->hinhanh) }}"
                                    alt="Service Image" 
                                    class="img-thumbnail"
                                    style="width: 70px; height: 70px; object-fit: cover;">
                            @else
                                <span class="badge bg-secondary">{{ __('No image') }}</span>
                            @endif
                        </td>

                        <td class=" text-center">{{ $dichVu->tendichvu }}</td>
                        
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <span class="badge bg-light text-dark border">
                                    {{ $dichVu->danhMuc->tendanhmuc ?? 'Uncategorized' }}
                                </span>
                            </div>
                        </td>
                        
                        <td>
                            @if($dichVu->la_gia_dao_dong)
                               <div class="d-flex justify-content-center gap-1">
                                    <span class="badge bg-info text-dark mb-1" style="width: fit-content;">{{ __('Is variable price') }}</span>
                                    <span class="fw-bold text-danger">
                                        {{ number_format($dichVu->dongia) }} - {{ number_format($dichVu->dongia_toida) }} đ
                                    </span>
                                </div>
                            @else
                                <div class="d-flex justify-content-center gap-1">
                                    <span class="fw-bold text-primary">
                                        {{ number_format($dichVu->dongia) }} đ
                                    </span>
                                </div>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.dich-vus.edit', $dichVu->id) }}" 
                               class="btn btn-warning btn-action text-white">
                                <span class="material-symbols-outlined" style="font-size:18px;">edit</span>
                                {{ __('Edit') }}
                            </a>

                            <form action="{{ route('admin.dich-vus.destroy', $dichVu->id) }}"
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
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <p class="mb-0">{{ __('No service description available.') }}</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $dichVus->links() }}</div>
</div>

{{-- MODAL NHẬP EXCEL --}}
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> {{-- Dùng modal-lg để rộng hơn chút --}}
        <form action="{{ route('admin.dich-vus.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="importModalLabel">
                        <span class="material-symbols-outlined align-middle me-1">upload_file</span>
                        {{ __('Import Services from Excel') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file" class="form-label">{{ __('Choose Excel File') }} (.xlsx, .xls)</label>
                        <input type="file" class="form-control" id="file" name="file" required accept=".xlsx, .xls, .csv">
                    </div>
                    
                    {{-- PHẦN NOTE ĐƯỢC CẬP NHẬT ĐỂ KHỚP VỚI CODE CỦA BẠN --}}
                    <div class="alert alert-info border-0 bg-light" role="alert">
                        <strong>{{ __('Lưu ý:') }}</strong> {{ __('File Excel cần có dòng tiêu đề (row 1) với các tên cột chính xác như sau:') }}
                        <div class="row mt-2">
                            <div class="col-md-6">
                                <ul class="mb-0 ps-3 small">
                                    <li><code>ten_dich_vu</code>: Tên dịch vụ <span class="text-danger">(*)</span></li>
                                    <li><code>id_danh_muc</code>: ID số của danh mục <span class="text-danger">(*)</span></li>
                                    <li><code>don_gia</code>: Giá tiền (Số)</li>
                                    <li><code>don_vi_tinh</code>: Đơn vị (kg, cái, bộ...)</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="mb-0 ps-3 small">
                                    <li><code>mo_ta</code>: Mô tả chi tiết dịch vụ</li>
                                    <li><code>don_gia_toi_da</code>: Giá tối đa (Nếu có dao động)</li>
                                    <li><code>la_gia_dao_dong</code>: Nhập 1 (Có) hoặc 0 (Không)</li>
                                    <li><code>hinhanh</code>: Tên file ảnh (VD: <code>giat.png</code>)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Upload') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection