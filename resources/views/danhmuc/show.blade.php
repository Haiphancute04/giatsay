@extends('layouts.app')

@section('title', 'Danh mục: ' . $danhMuc->tendanhmuc)

@section('content')
    <div class="row">
        <div class="col-md-3">
            <h4>Tất cả Danh mục</h4>
            <div class="list-group">
                @foreach ($danhMucs as $dm)
                    <a href="{{ route('category.show', $dm->tendanhmuc_slug) }}" 
                       class="list-group-item list-group-item-action {{ $dm->id == $danhMuc->id ? 'active' : '' }}">
                        {{ $dm->tendanhmuc }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="col-md-9">
            <h2>{{ $danhMuc->tendanhmuc }}</h2>
            <hr>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @forelse ($dichVus as $dichVu)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ $dichVu->hinhanh ? asset('storage/' . $dichVu->hinhanh) : 'https://placehold.co/600x400?text=Giatsay' }}" class="card-img-top" alt="{{ $dichVu->tendichvu }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $dichVu->tendichvu }}</h5>
                                <p class="card-text text-danger fw-bold">
                                    {{ number_format($dichVu->dongia) }} đ / {{ $dichVu->donvitinh }}
                                </p>
                                <p class="card-text">
                                    {{ $dichVu->rating_trungbinh }} ★ ({{ $dichVu->soluong_danhgia }} đánh giá)
                                </p>
                                <a href="{{ route('dichvu.show', $dichVu->tendichvu_slug) }}" class="btn btn-primary mt-auto">Thêm vào giỏ</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Chưa có dịch vụ nào trong danh mục này.</p>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $dichVus->links() }}
            </div>
        </div>
    </div>
@endsection