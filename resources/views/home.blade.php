@extends('layouts.app') 
@section('title', 'Trang chủ')

@section('content')

<style>
    /* 1. CẤU HÌNH BANNER RESPONSIVE */
    .banner-frame {
        width: 100%;
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        background-color: #f0f0f0;
        
        /* Mobile: Cao 250px để dễ nhìn */
        height: 250px; 
    }

    /* Tablet: Cao 400px */
    @media (min-width: 768px) {
        .banner-frame {
            height: 400px;
        }
    }

    /* Desktop: Cao 600px (Chuẩn kích thước ảnh 1400x600) */
    @media (min-width: 992px) {
        .banner-frame {
            height: 600px;
            /* Nếu muốn banner không full màn hình quá mức thì bỏ comment dòng dưới */
            /* max-width: 1400px; margin: 0 auto; */
        }
    }

    /* 2. CẤU HÌNH ẢNH & HIỆU ỨNG ZOOM */
    .banner-img {
        width: 100%;
        height: 100%;
        object-fit: cover;      /* Quan trọng: lấp đầy khung mà không méo */
        object-position: center;
        transition: transform 0.8s ease; /* Tăng thời gian lên 0.8s cho mượt hơn */
    }
    
    .banner-frame:hover .banner-img {
        transform: scale(1.05); /* Zoom nhẹ 5% */
    }

    /* 3. CẤU HÌNH NÚT BẤM (NAVIGATION) */
    .carousel-control-prev, .carousel-control-next {
        width: 50px;
        height: 50px;
        top: 50%;
        transform: translateY(-50%);
        border-radius: 50%;
        margin: 0 15px;
        transition: all 0.3s ease;
        background-color: rgba(0, 0, 0, 0.3); /* Nền tối nhẹ */
        backdrop-filter: blur(2px); /* Làm mờ nền sau nút cho đẹp */
        
        /* Mặc định ẩn */
        opacity: 0; 
        visibility: hidden;
    }

    /* Hiện nút khi di chuột vào Banner */
    #heroCarousel:hover .carousel-control-prev,
    #heroCarousel:hover .carousel-control-next {
        opacity: 1;
        visibility: visible;
    }

    /* Hiệu ứng khi di chuột vào nút */
    .carousel-control-prev:hover, .carousel-control-next:hover {
        background-color: #0d6efd; /* Màu xanh Bootstrap */
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.5);
        transform: translateY(-50%) scale(1.1);
    }

    /* 4. HIỆU ỨNG CARD DỊCH VỤ (Thêm cho đẹp) */
    .service-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
</style>

    {{-- PHẦN BANNER --}}
    @if($banners->count() > 0)
        <div id="heroCarousel" class="carousel slide mb-5 shadow-sm rounded-3 overflow-hidden" data-bs-ride="carousel">
            
            {{-- Chỉ số slide (Indicators) --}}
            <div class="carousel-indicators">
                @foreach($banners as $key => $banner)
                    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $key }}" 
                        class="{{ $key == 0 ? 'active' : '' }}" aria-current="true"></button>
                @endforeach
            </div>

            {{-- Nội dung Slide --}}
            <div class="carousel-inner">
                @foreach($banners as $key => $banner)
                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <div class="banner-frame position-relative">
                            <a href="{{ $banner->link ?? '#' }}" class="d-block h-100">
                                <img src="{{ asset('hello/' . $banner->image) }}" 
                                     class="banner-img d-block w-100" 
                                     alt="{{ $banner->title }}">
                                
                                {{-- Caption --}}
                                @if($banner->title || $banner->description)
                                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-3 start-50 translate-middle-x" style="bottom: 30px; max-width: 80%;">
                                        <h3 class="text-white fw-bold text-uppercase">{{ $banner->title }}</h3>
                                        <p class="text-white mb-0 fs-5">{{ $banner->description }}</p>
                                    </div>
                                @endif
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Nút chuyển --}}
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
            </button>
        </div>
    @endif

    {{-- PHẦN DỊCH VỤ --}}
    <h3 id="dichvu" class="mb-4 fw-bold border-start border-4 border-primary ps-3">{{ __('Services') }}</h3>
    
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
        @forelse ($dichVuNoiBat as $dichVu)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 service-card">
                    <div class="overflow-hidden rounded-top" style="height: 200px;">
                        <img src="{{ $dichVu->hinhanh ? asset('hello/' . $dichVu->hinhanh) : 'https://placehold.co/600x400?text=Giatsay' }}" 
                             class="card-img-top w-100 h-100 object-fit-cover" 
                             alt="{{ $dichVu->tendichvu }}">
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark">{{ $dichVu->tendichvu }}</h5>
                        
                        <p class="card-text text-primary fw-bold fs-5 mb-2">
                            @if($dichVu->la_gia_dao_dong)
                                {{ number_format($dichVu->dongia) }} - {{ number_format($dichVu->dongia_toida) }} đ
                            @else
                                {{ number_format($dichVu->dongia) }} đ
                            @endif
                            <span class="text-muted fs-6 fw-normal">/ {{ $dichVu->donvitinh }}</span>
                        </p>
                        
                        <p class="card-text">
                            {{-- number_format(giá_trị, số_thập_phân, 'dấu_phẩy', 'dấu_chấm') --}}
                            {{ number_format($dichVu->danh_gias_avg_rating ?? 0, 2, ',', '.') }} ⭐ ({{ $dichVu->danh_gias_count ?? 0 }} đánh giá)
                        </p>

                        <a href="{{ route('dichvu.show', $dichVu->tendichvu_slug) }}" class="btn btn-outline-primary mt-auto w-100 stretched-link">
                            {{ __('See details') }}
                        </a> 
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <p class="text-muted">{{ __('News3') }}</p>
            </div>
        @endforelse
    </div>

    {{-- PHẦN BẢN ĐỒ --}}
    <h3 class="mb-3 fw-bold border-start border-4 border-primary ps-3">{{ __('Laundry Shop Location') }}</h3>
    <div class="mt-3 map-container rounded-3 overflow-hidden shadow mb-5">
        {{-- Đã thay link placeholder bị lỗi bằng link embed mẫu. Bạn cần vào Google Maps > Chia sẻ > Nhúng bản đồ để lấy link thật --}}
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3924.369271797509!2d105.42082637451276!3d10.392217166164052!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x310a72c41c43cfa9%3A0x60472aa854e06d39!2zODRCNCBDYW8gVGjhuq9uZywgcC4gQsOsbmggS2jDoW5oLCBUaMOgbmggcGjhu5EgTG9uZyBYdXnDqm4sIEFuIEdpYW5nLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2sus!4v1765702958357!5m2!1svi!2sus"
                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>

@endsection
