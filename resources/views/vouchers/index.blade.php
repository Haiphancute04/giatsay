@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center"><i class="bi bi-gift-fill me-1"></i>  {{ __('Hunt for Vouchers') }}</h2>
    <div class="row">
        @foreach($vouchers as $voucher)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm {{ $voucher->isCollectedByUser(Auth::id()) ? 'border-success' : '' }}">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ $voucher->ma_code }}</h5>
                        <p class="card-text">
                            @if($voucher->loai_giamgia == 'percent')
                                Giảm {{ number_format($voucher->giatri) }}%
                            @else
                                Giảm {{ number_format($voucher->giatri) }} VNĐ
                            @endif
                        </p>
                        <p class="small text-muted">
                            Đơn tối thiểu: {{ number_format($voucher->dieukien_toithieu) }} đ <br>
                            HSD: {{ $voucher->ngay_ketthuc ? \Carbon\Carbon::parse($voucher->ngay_ketthuc)->format('d/m/Y') : 'Vô thời hạn' }}
                        </p>
                        @if(Auth::check())
                            @if($voucher->isCollectedByUser(Auth::id()))
                                <button class="btn btn-success btn-sm w-100" disabled>Đã lưu trong ví</button>
                            @else
                                <button onclick="collectVoucher({{ $voucher->id }})" class="btn btn-outline-primary btn-sm w-100" id="btn-collect-{{ $voucher->id }}">Lưu Mã</button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm w-100">Đăng nhập để lưu</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
function collectVoucher(id) {
    // 1. Tạo URL chính xác bằng route của Laravel để tránh lỗi đường dẫn
    var url = "{{ route('vouchers.collect', ':id') }}";
    url = url.replace(':id', id);

    // 2. Lấy nút bấm để tạo hiệu ứng loading
    let btn = document.getElementById(`btn-collect-${id}`);
    let originalText = btn.innerText;
    btn.innerText = 'Đang xử lý...';
    btn.disabled = true;

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json', // QUAN TRỌNG: Báo cho Laravel trả về JSON nếu có lỗi
            'X-Requested-With': 'XMLHttpRequest' // QUAN TRỌNG: Xác định đây là Ajax request
        }
    })
    .then(response => {
        // Kiểm tra nếu server trả về lỗi (401, 403, 500...)
        if (!response.ok) {
            throw response; 
        }
        return response.json();
    })
    .then(data => {
        if(data.success) {
            // Thông báo thành công (Dùng alert hoặc SweetAlert nếu bạn đã cài)
            alert(data.message);
            
            // Cập nhật giao diện nút bấm
            btn.className = 'btn btn-success btn-sm w-100';
            btn.innerText = 'Đã lưu trong ví';
            // Không mở lại nút disabled
        } else {
            // Thông báo lỗi logic (ví dụ: đã hết lượt)
            alert(data.message);
            // Khôi phục nút bấm
            btn.innerText = originalText;
            btn.disabled = false;
        }
    })
    .catch(error => {
        // Xử lý các lỗi HTTP hoặc lỗi mạng
        console.error('Error:', error);
        
        // Nếu lỗi là do chưa đăng nhập (401 Unauthorized)
        if (error.status === 401) {
            alert('Vui lòng đăng nhập để thực hiện chức năng này!');
            window.location.href = "{{ route('login') }}";
        } else {
            alert('Đã xảy ra lỗi, vui lòng thử lại sau.');
        }

        // Khôi phục nút bấm
        btn.innerText = originalText;
        btn.disabled = false;
    });
}
</script>
@endsection