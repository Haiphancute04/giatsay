@extends('layouts.app')

@section('title', 'Điều khoản sử dụng - Tiệm giặt sấy 89')

@section('content')

<section class="container py-5">
    <div class="row">
        
        <div class="col-lg-3 mb-4 mb-lg-0">
            <div class="sticky-top" style="top: 100px; z-index: 1;">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 id="back-to-top" class="fw-bold text-center user-select-none" title="Về đầu trang">
                            Mục lục
                        </h5>
                        <nav id="terms-nav" class="nav flex-column gap-2">
                            <a class="nav-link text-muted py-1 px-0 active-link" href="#term-1">1. Giới thiệu chung</a>
                            <a class="nav-link text-muted py-1 px-0" href="#term-2">2. Trách nhiệm của khách hàng</a>
                            <a class="nav-link text-muted py-1 px-0" href="#term-3">3. Trách nhiệm của cửa hàng</a>
                            <a class="nav-link text-muted py-1 px-0" href="#term-4">4. Chính sách giá & Thanh toán</a>
                            <a class="nav-link text-muted py-1 px-0" href="#term-5">5. Lưu kho & Bỏ quên</a>
                            <a class="nav-link text-muted py-1 px-0" href="#term-6">6. Miễn trừ trách nhiệm</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h2 class="h3 fw-bold mb-0">Điều khoản & Quy định sử dụng</h2>
                        <span class="badge bg-info bg-opacity-10 text-info">Cập nhật lần cuối: 12/2025</span>
                    </div>

                    <p class="text-muted mb-5">
                        Chào mừng quý khách đến với <strong>Tiệm giặt sấy 89</strong>. Khi sử dụng dịch vụ của chúng tôi, quý khách đồng ý tuân thủ các điều khoản và điều kiện dưới đây. Vui lòng đọc kỹ để đảm bảo quyền lợi của mình.
                    </p>

                    <hr class="my-4">

                    <div id="term-1" class="mb-5">
                        <h4 class="fw-bold text-primary mb-3">1. Giới thiệu chung</h4>
                        <p>Tiệm giặt sấy 89 cung cấp dịch vụ giặt ủi, sấy khô, gấp ủi và vệ sinh giày. Chúng tôi cam kết nỗ lực hết mình để chăm sóc trang phục của quý khách bằng quy trình chuyên nghiệp và các sản phẩm giặt tẩy an toàn.</p>
                    </div>

                    <div id="term-2" class="mb-5">
                        <h4 class="fw-bold text-primary mb-3">2. Trách nhiệm của khách hàng</h4>
                        <p>Để đảm bảo an toàn cho quần áo và máy móc, quý khách vui lòng:</p>
                        <ul class="list-unstyled">
                            <li class="d-flex mb-2">
                                <i class="ci-check-circle text-success mt-1 me-2"></i>
                                <span><strong>Kiểm tra tư trang:</strong> Vui lòng lấy sạch mọi vật dụng trong túi áo/quần (tiền, bật lửa, bút bi, khăn giấy...) trước khi giao đồ. Cửa hàng không chịu trách nhiệm về tài sản để quên.</span>
                            </li>
                            <li class="d-flex mb-2">
                                <i class="ci-check-circle text-success mt-1 me-2"></i>
                                <span><strong>Thông báo lưu ý đặc biệt:</strong> Nếu quần áo dễ phai màu, co rút hoặc cần chế độ giặt riêng, quý khách phải thông báo trước cho nhân viên.</span>
                            </li>
                            <li class="d-flex">
                                <i class="ci-check-circle text-success mt-1 me-2"></i>
                                <span><strong>Kiểm tra số lượng:</strong> Quý khách vui lòng đếm kỹ số lượng và xác nhận với nhân viên khi giao và nhận hàng.</span>
                            </li>
                        </ul>
                    </div>

                    <div id="term-3" class="mb-5">
                        <h4 class="fw-bold text-primary mb-3">3. Trách nhiệm của cửa hàng</h4>
                        <p>Chúng tôi cam kết:</p>
                        <ul class="list-disc ps-3 text-muted">
                            <li class="mb-2">Giặt riêng đồ của từng khách hàng, không giặt chung để đảm bảo vệ sinh.</li>
                            <li class="mb-2">Sử dụng nước giặt/xả chính hãng, an toàn cho da.</li>
                            <li class="mb-2">Bồi thường theo <a href="{{ route('policy') }}" class="text-decoration-underline">Chính sách</a> nếu xảy ra mất mát hoặc hư hỏng do lỗi của nhân viên cửa hàng.</li>
                        </ul>
                    </div>

                    <div id="term-4" class="mb-5">
                        <h4 class="fw-bold text-primary mb-3">4. Chính sách giá & Thanh toán</h4>
                        <p>
                            Giá dịch vụ được niêm yết công khai trên website và tại cửa hàng. Phí vận chuyển (nếu có) sẽ được tính dựa trên khoảng cách thực tế.
                            <br>
                            Quý khách vui lòng thanh toán <strong>100%</strong> ngay khi nhận lại đồ đã giặt xong (đối với khách hàng cá nhân).
                        </p>
                    </div>

                    <div id="term-5" class="mb-5">
                        <h4 class="fw-bold text-primary mb-3">5. Quy định Lưu kho & Đồ bỏ quên</h4>
                        <p>
                            Quần áo đã giặt xong sẽ được lưu kho miễn phí trong vòng <strong>07 ngày</strong>.
                            Sau thời gian này, chúng tôi xin phép:
                        </p>
                        <ul>
                            <li>Tính phí lưu kho: <strong>5.000đ/ngày</strong>.</li>
                            <li>Sau <strong>30 ngày</strong> nếu không có người nhận, chúng tôi có quyền thanh lý hoặc quyên góp từ thiện để giải phóng kho bãi và không chịu trách nhiệm bồi thường.</li>
                        </ul>
                    </div>

                    <div id="term-6" class="mb-0">
                        <h4 class="fw-bold text-primary mb-3">6. Miễn trừ trách nhiệm</h4>
                        <div class="alert alert-warning border-0 d-flex mb-0">
                            <i class="ci-announcement fs-4 me-3 mt-1"></i>
                            <div>
                                Chúng tôi <strong>không chịu trách nhiệm</strong> đối với:
                                <ul class="mb-0 mt-2">
                                    <li>Độ bền của cúc áo, khóa kéo, phụ kiện đính kèm đã cũ hoặc lỏng lẻo.</li>
                                    <li>Sự co rút hoặc phai màu tự nhiên của vải do chất lượng quần áo không đảm bảo.</li>
                                    <li>Hư hỏng do các vật dụng khách hàng bỏ quên trong túi (ví dụ: bút bi loang mực, khăn giấy vụn bám vào đồ).</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const links = document.querySelectorAll('#terms-nav .nav-link');
        
        // 1. Logic cho nút Quay lại đầu trang
        const backToTopBtn = document.getElementById('back-to-top');
        if (backToTopBtn) {
            backToTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
                
                // Reset active links (Optional: làm cho đẹp hơn)
                links.forEach(l => {
                    l.classList.remove('active-link');
                    l.classList.add('text-muted');
                });
                links[0].classList.add('active-link'); // Highlight mục đầu tiên
                links[0].classList.remove('text-muted');
            });
        }

        // 2. Logic cho việc click vào các mục lục
        links.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault(); 

                const targetId = this.getAttribute('href');
                const targetSection = document.querySelector(targetId);
                
                if (targetSection) {
                    const headerOffset = 120; 
                    const elementPosition = targetSection.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: "smooth"
                    });
                }

                links.forEach(l => {
                    l.classList.remove('active-link');
                    l.classList.add('text-muted'); 
                });

                this.classList.add('active-link');
                this.classList.remove('text-muted'); 
            });
        });
    });
</script>
<style>
    /* CSS cho nút Mục lục (Back to top) */
    #back-to-top {
        cursor: pointer;
        transition: color 0.2s ease;
    }
    #back-to-top:hover {
        color: #0d6efd; /* Màu xanh Primary */
    }

    /* CSS cho trạng thái Active */
    .active-link {
        color: #0d6efd !important; 
        font-weight: bold;
        padding-left: 10px !important; 
        border-left: 3px solid #0d6efd; 
        transition: all 0.3s ease;
    }

    /* CSS cho trạng thái bình thường */
    .nav-link {
        transition: all 0.2s ease;
        border-left: 3px solid transparent; 
    }
    
    .nav-link:hover {
        color: #0d6efd !important;
    }
</style>
@endsection