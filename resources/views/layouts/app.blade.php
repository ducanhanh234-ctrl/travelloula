<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travelloula</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/style.css'])
    @else
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @endif

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <!-- HEADER -->
    <header class="header">
        <div class="container">

            <div class="logo">
                <img src="{{ asset('images/logotravelloula-removebg-preview(1).png') }}" width="100" alt="Travelloula">
                <div>
                    {{-- <h1>Travelloula</h1> --}}

                </div>
            </div>

            <nav class="menu">
                <a href="#">Trang chủ</a>
                <a href="#">Tour</a>
                <a href="#">Tour yêu thích</a>
                <a href="#">Điều khoản</a>
                <a href="#">Bài viết</a>
                <a href="#">Ưu đãi</a>
                <a href="#">Liên hệ</a>
                <a href="#">Về chúng tôi</a>
            </nav>

            <div class="header-right">
                <a href="{{ url('/register') }}" class="btn btn-primary">
                    Đăng ký
                </a>
                <a href="{{ url('/login') }}" class="btn btn-secondary">
                    Đăng nhập
                </a>
            </div>

        </div>
    </header>

    @yield('content')

    <!-- FOOTER -->
    <footer class="footer">

        <div class="container footer-grid">

            <div class="footer-about">
                <div class="footer-logo">
                    <i class="fas fa-compass" style="font-size: 36px; color: #fff;"></i>
                    <div>
                        <h2>Travelloula</h2>
                        <span>Quản Lý Tour Du Lịch</span>
                    </div>
                </div>

                <p>
                    Travelloula là hệ thống quản lý tour du lịch chuyên nghiệp,
                    hỗ trợ quản lý khách hàng, booking, thanh toán và vận hành tour.
                </p>
            </div>

            <div>
                <h3>Hệ Thống</h3>
                <ul>
                    <li><a href="#">Trang chủ</a></li>
                    <li><a href="#">Tours</a></li>
                    <li><a href="#">Đặt tour</a></li>
                    <li><a href="#">Khách hàng</a></li>
                </ul>
            </div>

            <div>
                <h3>Hỗ Trợ</h3>
                <ul>
                    <li><a href="#">Hướng dẫn</a></li>
                    <li><a href="#">Chính sách</a></li>
                    <li><a href="#">Liên hệ</a></li>
                </ul>
            </div>

            <div>
                <h3>Liên Hệ</h3>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> Hà Nội, Việt Nam</li>
                    <li><i class="fas fa-phone"></i> 1900 1234</li>
                    <li><i class="fas fa-envelope"></i> support@travelloula.com</li>
                </ul>
            </div>

        </div>

        <div class="copyright">
            © 2026 Travelloula. All Rights Reserved.
        </div>

    </footer>

</body>
</html>
