<footer class="footer-custom pt-5 pb-4">
    <div class="container text-center text-md-start">
        <div class="row">
            <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                <h6 class="footer-title d-flex align-items-center">
                    <span class="material-symbols-outlined me-2">apartment</span>
                    {{ __('LAUNDRY') }} 89
                </h6>
                <p class="footer-text">{{ __('News') }}</p>
            </div>

            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                <h6 class="footer-title d-flex align-items-center"><span class="material-symbols-outlined me-2">local_laundry_service</span>{{ __('Services') }}</h6>
                
                {{-- Đã cập nhật link Giặt sấy khô --}}
                <p class="footer-item">
                    <span class="material-symbols-outlined me-2">check_circle</span>
                    <a href="{{ route('dichvu.show', 'giat-say-kho') }}" class="footer-link">{{ __('Wash & Dry') }}</a>
                </p> 
                
                {{-- Đã cập nhật link Giặt gấu bông --}}
                <p class="footer-item">
                    <span class="material-symbols-outlined me-2">check_circle</span>
                    <a href="{{ route('dichvu.show', 'giat-gau-bong') }}" class="footer-link">{{ __('Teddy Bear Cleaning') }}</a>
                </p>
                
                {{-- Đã cập nhật link Vệ sinh giày --}}
                <p class="footer-item">
                    <span class="material-symbols-outlined me-2">check_circle</span>
                    <a href="{{ route('dichvu.show', 've-sinh-giay') }}" class="footer-link">{{ __('Shoe Cleaning') }}</a>
                </p>
            </div>

            <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                <h6 class="footer-title d-flex align-items-center"><span class="material-symbols-outlined me-2">link</span>{{ __('Link') }}</h6>
                <p class="footer-item"><span class="material-symbols-outlined me-2">arrow_right</span><a href="{{ route('policy') }}" class="footer-link">{{ __('policy') }}</a></p>
                <p class="footer-item"><span class="material-symbols-outlined me-2">arrow_right</span><a href="{{ route('terms') }}" class="footer-link">{{ __('clause') }}</a></p>
                <p class="footer-item"><span class="material-symbols-outlined me-2">arrow_right</span><a href="zalo://conversation?phone=0919998900" class="footer-link">{{ __('support') }}</a></p>
            </div>

            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                <h6 class="footer-title d-flex align-items-center"><span class="material-symbols-outlined me-2">contact_mail</span> {{ __('contact') }}</h6>
                <p class="footer-text d-flex align-items-center mb-1"><span class="material-symbols-outlined me-2">location_on</span>84B4 Cao Thắng, Bình Khánh, Long Xuyên, An Giang</p>
                <p class="footer-text d-flex align-items-center mb-1"><span class="material-symbols-outlined me-2">email</span>skai849@gmail.com</p>
                <p class="footer-text d-flex align-items-center mb-1"><span class="material-symbols-outlined me-2">phone</span>0919998900</p>
            </div>

        </div>

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center footer-border pt-4 mt-3">
            <p class="footer-text mb-2 mb-md-0 d-flex align-items-center"><span class="material-symbols-outlined me-1" style="font-size:16px;">copyright</span>{{ __('copyright') }} © {{ date('Y') }} {{ __('LAUNDRY') }} 89.</p>
            <div class="d-flex gap-2">
                <img src="{{ asset('assets/img/payment-methods/momo-color.svg') }}" onerror="this.src='https://placehold.co/38x24/FF0033/fff?text=MoMo'" alt="MoMo" width="38">
                <img src="{{ asset('assets/img/payment-methods/zalopay-color.svg') }}" onerror="this.src='https://placehold.co/38x24/0066FF/fff?text=ZaloPay'" alt="ZaloPay" width="38">
                <img src="{{ asset('assets/img/payment-methods/vnpay-color.svg') }}" onerror="this.src='https://placehold.co/38x24/00CC66/fff?text=VNPay'" alt="VNPay" width="38">
                <img src="{{ asset('assets/img/payment-methods/techcompay-color.svg') }}" onerror="this.src='https://placehold.co/38x24/FF6600/fff?text=TechcomPay'" alt="TechcomPay" width="38">
            </div>
        </div>
    </div>
</footer>