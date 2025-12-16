@extends('layouts.app')

@section('title', 'Chính sách & Quy định - Tiệm giặt sấy 89')

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
                        <nav id="policy-nav" class="nav flex-column gap-2">
                            <a class="nav-link text-muted py-1 px-0 active-link" href="#policy-1">1. Đảm bảo chất lượng</a>
                            <a class="nav-link text-muted py-1 px-0" href="#policy-2">2. Bồi thường & Khiếu nại</a>
                            <a class="nav-link text-muted py-1 px-0" href="#policy-3">3. Giao - Nhận tận nơi</a>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5">
                    
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h2 class="h3 fw-bold mb-0">Chính sách & Quy định</h2>
                        <span class="badge bg-info bg-opacity-10 text-info">Cập nhật lần cuối: 12/2025</span>
                    </div>

                    <p class="text-muted mb-5">
                        Chào mừng quý khách đến với <strong>Tiệm giặt sấy 89</strong>. Sự hài lòng của khách hàng là ưu tiên hàng đầu. Chúng tôi hoạt động dựa trên sự minh bạch và trách nhiệm.
                    </p>

                    <hr class="my-4">

                    <div id="policy-1" class="mb-5">
                        <h4 class="fw-bold text-primary mb-3"><i class="ci-shield-check me-2"></i>1. Chính sách đảm bảo chất lượng</h4>
                        <p>Tiệm giặt sấy 89 cam kết sử dụng các loại nước giặt, nước xả có nguồn gốc rõ ràng, an toàn cho da và thân thiện với môi trường.</p>
                        <ul class="list-unstyled text-muted ps-2">
                            <li class="mb-2 d-flex">
                                <i class="ci-check-circle text-success me-2 mt-1"></i>
                                <span>Phân loại quần áo kỹ càng trước khi giặt (đồ trắng, đồ màu).</span>
                            </li>
                            <li class="mb-2 d-flex">
                                <i class="ci-check-circle text-success me-2 mt-1"></i>
                                <span>Giặt riêng biệt cho từng khách hàng, tuyệt đối không giặt chung.</span>
                            </li>
                            <li class="mb-2 d-flex">
                                <i class="ci-check-circle text-success me-2 mt-1"></i>
                                <span>Sấy khô hoàn toàn, gấp gọn gàng trước khi giao.</span>
                            </li>
                        </ul>
                    </div>

                    <div id="policy-2" class="mb-5">
                        <h4 class="fw-bold text-primary mb-3"><i class="ci-security-announcement me-2"></i>2. Chính sách bồi thường & Khiếu nại</h4>
                        <p>Chúng tôi hiểu quần áo là tài sản quý giá của khách hàng. Trong trường hợp rủi ro hy hữu:</p>
                        
                        <div class="d-flex flex-column gap-3">
                            <div class="p-3 bg-light rounded-3 border-start border-4 border-danger">
                                <strong class="d-block text-dark mb-1">Mất thất lạc đồ:</strong>
                                <span class="text-muted">Bồi thường gấp <span class="text-danger fw-bold">10 lần</span> phí dịch vụ của món đồ đó (hoặc thỏa thuận theo giá trị thực tế khấu hao).</span>
                            </div>
                            
                            <div class="p-3 bg-light rounded-3 border-start border-4 border-warning">
                                <strong class="d-block text-dark mb-1">Hư hỏng/Lem màu:</strong>
                                <span class="text-muted">Nếu lỗi do quy trình của tiệm, chúng tôi chịu trách nhiệm xử lý lại miễn phí hoặc bồi thường thỏa đáng.</span>
                            </div>

                            <div class="alert alert-warning border-0 d-flex mb-0">
                                <i class="ci-announcement me-3 mt-1 fs-5"></i>
                                <span class="small">Lưu ý: Khách hàng vui lòng kiểm tra đồ ngay khi nhận hàng. Khiếu nại chỉ được giải quyết trong vòng 24h kể từ khi giao hàng.</span>
                            </div>
                        </div>
                    </div>

                    <div id="policy-3" class="mb-0">
                        <h4 class="fw-bold text-primary mb-3"><i class="ci-delivery me-2"></i>3. Chính sách Giao - Nhận tận nơi</h4>
                        <p>Đội ngũ shipper của Tiệm giặt sấy 89 hoạt động từ <strong>7:00 - 21:00</strong> mỗi ngày.</p>
                        
                        <div class="alert alert-info bg-opacity-10 border-0 d-flex align-items-center mb-3">
                            <i class="ci-discount fs-4 me-3 text-info"></i>
                            <div>
                                <strong>Ưu đãi vận chuyển:</strong> Miễn phí giao nhận cho đơn hàng trong bán kính <strong>2km</strong>.
                            </div>
                        </div>
                        
                        <p class="text-muted mb-0">
                            Với các đơn hàng ở xa hơn hoặc giá trị thấp hơn, phí ship sẽ được tính theo giá hiển thị trên ứng dụng Grab/Ahamove tại thời điểm đó để đảm bảo minh bạch.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const links = document.querySelectorAll('#policy-nav .nav-link');

        // 1. Logic cho nút Quay lại đầu trang (Click vào chữ Mục lục)
        const backToTopBtn = document.getElementById('back-to-top');
        if (backToTopBtn) {
            backToTopBtn.addEventListener('click', function() {
                // Scroll lên đầu
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
                
                // Reset trạng thái active về link đầu tiên
                links.forEach(l => {
                    l.classList.remove('active-link');
                    l.classList.add('text-muted');
                });
                if(links.length > 0) {
                    links[0].classList.add('active-link');
                    links[0].classList.remove('text-muted');
                }
            });
        }

        // 2. Logic click vào từng mục con
        links.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault(); 

                // Xử lý Scroll mượt tới section
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

                // Xử lý đổi màu (Highlight)
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