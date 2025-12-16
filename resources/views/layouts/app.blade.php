<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'GiatSay'))</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400;700&display=swap">
    <link rel="stylesheet" href="{{ asset('css/partials.css') }}">

    <style>
        /* CSS cho nút Zalo (Cũ - giữ nguyên) */
        .zalo-floating-btn {
            position: fixed; bottom: 25px; right: 25px; z-index: 9999;
            display: flex; align-items: center; justify-content: center;
            width: 60px; height: 60px; background: none;
            border-radius: 50%; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease; cursor: pointer; text-decoration: none;
        }
        .zalo-floating-btn:hover { transform: scale(1.1); box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); }
        .zalo-floating-btn img { width: 100%; height: 100%; object-fit: cover; border-radius: 50%; }
        .zalo-floating-btn::before {
            content: ''; position: absolute; width: 100%; height: 100%;
            background: rgba(0, 104, 255, 0.5); border-radius: 50%;
            z-index: -1; animation: zalo-pulse 2s infinite;
        }
        @keyframes zalo-pulse {
            0% { transform: scale(1); opacity: 0.7; }
            70% { transform: scale(1.5); opacity: 0; }
            100% { transform: scale(1.5); opacity: 0; }
        }

        /* --- MỚI THÊM: CSS cho nút Back to Top --- */
        #btn-back-to-top {
            position: fixed;
            bottom: 100px; /* Nằm phía trên nút Zalo (25px + 60px + khoảng cách) */
            right: 30px; /* Canh lề phải gần giống nút Zalo */
            display: none; /* Mặc định ẩn */
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: #0d6efd; /* Màu xanh Bootstrap primary, bạn có thể đổi màu khác */
            color: white;
            border: none;
            z-index: 9998; /* Thấp hơn Zalo 1 chút */
            box-shadow: 0 2px 5px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        #btn-back-to-top:hover {
            background-color: #0b5ed7;
            transform: translateY(-3px); /* Hiệu ứng bay lên nhẹ khi di chuột */
        }
    </style>
</head>
<body class="bg-light">

    @include('partials.header')

    <main class="container py-4 main-content">
        @yield('content')
    </main>

    @include('partials.footer')
    
    <a href="zalo://conversation?phone=0919998900" class="zalo-floating-btn" title="Chat qua Zalo">
        <img src="{{ asset('images/zalo-icon.png') }}" alt="Zalo Chat">
    </a>

    <button type="button" id="btn-back-to-top" title="Lên đầu trang">
        <span class="material-symbols-outlined">arrow_upward</span>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @yield('javascript')

    <script>
        // Lấy nút button
        let mybutton = document.getElementById("btn-back-to-top");

        // Khi người dùng cuộn xuống 200px thì hiện nút
        window.onscroll = function() {
            scrollFunction();
        };

        function scrollFunction() {
            if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                mybutton.style.display = "flex"; // Hiện nút
            } else {
                mybutton.style.display = "none"; // Ẩn nút
            }
        }

        // Khi bấm vào nút thì cuộn mượt lên đầu trang
        mybutton.addEventListener("click", function() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    </script>
</body>
</html>