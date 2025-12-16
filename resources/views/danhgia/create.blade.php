@extends('layouts.app')
@section('title', __('Service Review'))

@section('content')
    {{-- Header Content --}}
    <div class="container py-4">
        <h2>{{ __('Service Review') }}</h2>
        <p class="text-muted">{{ __('Share your experience about the completed booking.') }}</p>
    </div>

    <div class="container mt-3">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    {{ __('Review for Booking') }} #{{ $donDatLich->id }}
                </h5>
            </div>
            <div class="card-body p-4">
                
                <h3 class="h6 font-weight-bold text-indigo-600 mb-4 border-bottom pb-2">
                    {{ __('Service') }}: {{ $chiTiet->dichVu->ten_dich_vu }}
                </h3>

                <form method="POST" action="{{ route('danhgia.store') }}">
                    @csrf
                    
                    <input type="hidden" name="don_dat_lich_id" value="{{ $donDatLich->id }}">
                    
                    {{-- 1. PHẦN CHỌN SỐ SAO --}}
                    <div class="mb-4">
                        <label for="so_sao" class="form-label font-weight-bold">{{ __('1. Select Rating (1-5 Stars)') }}</label>
                        
                        {{-- Giao diện Tương tác Sao (Sử dụng JS cơ bản) --}}
                        <div id="star-rating" class="d-flex align-items-center mb-2" style="font-size: 1.5rem; color: #ccc;">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="star-icon cursor-pointer" 
                                      data-rating="{{ $i }}" 
                                      style="cursor: pointer; margin-right: 5px;">&#9733;</span>
                            @endfor
                            <span id="rating-text" class="ms-3 text-sm text-muted">
                                {{ __('5 Stars - Very Satisfied') }}
                            </span>
                        </div>

                        {{-- Input ẩn để gửi giá trị thực tế --}}
                        <input type="hidden" id="so_sao_input" name="so_sao" value="5">

                        @error('so_sao')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- 2. PHẦN NỘI DUNG ĐÁNH GIÁ --}}
                    <div class="mb-4">
                        <label for="noi_dung" class="form-label font-weight-bold">{{ __('2. Review Content (Optional)') }}</label>
                        <textarea id="noi_dung" name="noi_dung" rows="6" 
                                  placeholder="{{ __('Share details about your experience...') }}" 
                                  class="form-control">{{ old('noi_dung') }}</textarea>
                        @error('noi_dung')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- NÚT GỬI --}}
                    <div class="d-flex justify-content-end pt-3 border-top">
                        <button type="submit" class="btn btn-success btn-lg">
                            {{ __('Submit Review Now') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script JavaScript để xử lý giao diện sao --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-icon');
            const ratingInput = document.getElementById('so_sao_input');
            const ratingText = document.getElementById('rating-text');
            const defaultColor = '#ccc';
            const activeColor = '#ffc107'; // Màu vàng của Bootstrap

            // Sử dụng Blade để render object ngôn ngữ vào JS
            const feedbackMap = {
                1: "{{ __('1 Star - Very Poor') }}",
                2: "{{ __('2 Stars - Poor') }}",
                3: "{{ __('3 Stars - Average') }}",
                4: "{{ __('4 Stars - Satisfied') }}",
                5: "{{ __('5 Stars - Very Satisfied') }}"
            };

            function updateStars(rating) {
                stars.forEach(star => {
                    if (parseInt(star.dataset.rating) <= rating) {
                        star.style.color = activeColor;
                    } else {
                        star.style.color = defaultColor;
                    }
                });
                ratingInput.value = rating;
                ratingText.textContent = feedbackMap[rating] || '';
            }

            // Gán sự kiện click cho các sao
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    updateStars(rating);
                });

                // Xử lý hover để xem trước
                star.addEventListener('mouseover', function() {
                    const hoverRating = parseInt(this.dataset.rating);
                    stars.forEach(s => {
                         if (parseInt(s.dataset.rating) <= hoverRating) {
                            s.style.color = activeColor;
                         } else {
                            s.style.color = defaultColor;
                         }
                    });
                    ratingText.textContent = feedbackMap[hoverRating] || '';
                });

                // Khôi phục trạng thái khi hết hover
                star.addEventListener('mouseout', function() {
                    updateStars(parseInt(ratingInput.value));
                });
            });

            // Thiết lập giá trị mặc định là 5 sao khi tải trang
            updateStars(5); 
        });
    </script>
@endsection