<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Travelloula')</title>






    {{-- @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/style.css'])
    @else
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @endif --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    <header class="client-header">
        <div class="client-container header-inner">

            <a href="{{ url('/') }}" class="brand">
                <img src="{{ asset('images/logotravelloula-removebg-preview(1).png') }}" alt="Travelloula">
            </a>


            <nav class="main-menu">
                <a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Trang chủ</a>
                <a href="{{ route('Client.danh_sach_tour.index') }}" class="{{ request()->is('tour*') ? 'active' : '' }}">Tour</a>
                <a href="{{ route('Client.tour_yeu_thich.index') }}" class="{{ request()->is('tour_yeu_thich*') ? 'active' : '' }}">Tour yêu thích</a>
                <a href="{{ route('Client.dieu_khoan.index') }}" class="{{ request()->is('dieu_khoan*') ? 'active' : '' }}">Điều khoản</a>
                <a href="{{ route('Client.bai_viet.index') }}" class="{{ request()->is('bai_viet*') ? 'active' : '' }}">Bài viết</a>

                <a href="#">Ưu đãi</a>
                <a href="#">Liên hệ</a>
                <a href="{{ route('Client.ve_chung_toi.index') }}" class="{{ request()->is('ve_chung_toi*') ? 'active' : '' }}">Về chúng tôi</a>
            </nav>

            <div class="header-actions">
                @auth
                <div class="user-dropdown">
                    <button type="button" class="user-btn" onclick="toggleUserMenu()">
                        <i class="fa-regular fa-user"></i>
                        <span>{{ auth()->user()->name }}</span>
                        <i class="fa-solid fa-angle-down"></i>
                    </button>

                    <div class="user-menu" id="userMenu">
                        <a href="{{ route('Client.tour_yeu_thich.index') }}">
                            <i class="fa-solid fa-heart"></i>
                            Tour yêu thích
                        </a>

                        <a href="{{ route('Client.danh_sach_tour.index') }}">
                            <i class="fa-solid fa-suitcase-rolling"></i>
                            Danh sách tour
                        </a>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ url('/register') }}" class="register-btn">Đăng ký</a>

                <a href="{{ url('/login') }}" class="login-btn">
                    <i class="fa-regular fa-user"></i>
                    Đăng nhập
                </a>
                @endauth
            </div>

        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="client-footer">
        <div class="footer-bg"></div>

        <div class="client-container footer-grid">

            <div class="footer-about">
                <div class="footer-logo">
                    <img src="{{ asset('images/logotravelloula-removebg-preview(1).png') }}" alt="Travelloula">
                </div>

                <p>
                    Travelloula là hệ thống quản lý tour du lịch chuyên nghiệp,
                    hỗ trợ quản lý khách hàng, booking, thanh toán và vận hành tour.
                </p>

                <h4>Kết nối với chúng tôi</h4>

                <div class="socials">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h3>Hệ Thống</h3>
                <a href="{{ route('Client.trang_chu.index') }}"><i class="fa-solid fa-angle-right"></i> Trang chủ</a>
                <a href="{{ route('Client.danh_sach_tour.index') }}"><i class="fa-solid fa-angle-right"></i> Tours</a>
                <a href="{{ route('Client.tour_yeu_thich.index') }}"><i class="fa-solid fa-angle-right"></i> Tour yêu thích</a>
                <a href="{{ route('Client.dieu_khoan.index') }}"><i class="fa-solid fa-angle-right"></i> Điều khoản</a>
            </div>

            <div class="footer-col">
                <h3>Hỗ Trợ</h3>
                <a href="#"><i class="fa-solid fa-angle-right"></i> Hướng dẫn</a>
                <a href="#"><i class="fa-solid fa-angle-right"></i> Chính sách</a>
                <a href="{{ route('Client.dieu_khoan.index') }}"><i class="fa-solid fa-angle-right"></i> Điều khoản</a>
                <a href="#"><i class="fa-solid fa-angle-right"></i> Liên hệ</a>
            </div>

            <div class="footer-col contact">
                <h3>Liên Hệ</h3>

                <p>
                    <span><i class="fa-solid fa-location-dot"></i></span>
                    Hà Nội, Việt Nam
                </p>

                <p>
                    <span><i class="fa-solid fa-phone"></i></span>
                    1900 1234
                </p>

                <p>
                    <span><i class="fa-solid fa-envelope"></i></span>
                    support@travelloula.com
                </p>
            </div>

        </div>

        <div class="footer-bottom">
            © 2026 Travelloula. All Rights Reserved.
        </div>
    </footer>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #0757d8;
            --primary-2: #0044c7;
            --yellow: #ffd629;
            --text: #0f172a;
            --muted: #64748b;
            --white: #ffffff;
            --bg: #f8fbff;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        a {
            text-decoration: none;
        }

        .client-container {
            width: min(1380px, calc(100% - 56px));
            margin: 0 auto;
        }

        /* HEADER */

        .client-header {
            background: #fff;
            min-height: 88px;
            position: sticky;
            top: 0;
            z-index: 999;
            box-shadow: 0 6px 24px rgba(15, 23, 42, .06);
        }

        .header-inner {
            min-height: 88px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 28px;
        }

        .brand {
            display: flex;
            align-items: center;
            flex-shrink: 0;
        }

        .brand img {
            width: 155px;
            display: block;
        }

        .main-menu {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
            flex: 1;
        }

        .main-menu a {
            color: #020617;
            font-size: 15px;
            font-weight: 800;
            padding: 34px 0 30px;
            position: relative;
            white-space: nowrap;
            transition: .25s;
        }

        .main-menu a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 0;
            height: 4px;
            border-radius: 20px 20px 0 0;
            background: var(--primary);
            transition: .25s;
        }

        .main-menu a:hover,
        .main-menu a.active {
            color: var(--primary);
        }

        .main-menu a:hover::after,
        .main-menu a.active::after {
            width: 100%;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-shrink: 0;
        }

        .register-btn,
        .login-btn {
            height: 52px;
            padding: 0 28px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 15px;
            font-weight: 900;
            white-space: nowrap;
            transition: .25s;
        }

        .register-btn {
            color: var(--primary);
            border: 2px solid var(--primary);
            background: #fff;
        }

        .register-btn:hover {
            color: #fff;
            background: var(--primary);
            transform: translateY(-2px);
        }

        .login-btn {
            color: #fff;
            background: linear-gradient(135deg, #0757d8, #0044c7);
            box-shadow: 0 12px 26px rgba(0, 68, 199, .25);
        }

        .login-btn:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 16px 34px rgba(0, 68, 199, .35);
        }

        /* USER DROPDOWN */

        .user-dropdown {
            position: relative;
        }

        .user-btn {
            height: 52px;
            padding: 0 24px;
            border: 0;
            border-radius: 999px;
            background: linear-gradient(135deg, #0757d8, #0044c7);
            color: #fff;
            font-size: 15px;
            font-weight: 900;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            white-space: nowrap;
            box-shadow: 0 12px 26px rgba(0, 68, 199, .25);
            transition: .25s;
        }

        .user-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 34px rgba(0, 68, 199, .35);
        }

        .user-menu {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            width: 230px;
            padding: 10px;
            border-radius: 18px;
            background: #fff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 22px 50px rgba(15, 23, 42, .16);
            display: none;
            z-index: 99999;
        }

        .user-menu.show {
            display: block;
        }

        .user-menu a,
        .user-menu button {
            width: 100%;
            min-height: 44px;
            padding: 0 14px;
            border: 0;
            border-radius: 12px;
            background: transparent;
            color: #0f172a;
            font-size: 14px;
            font-weight: 850;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            text-align: left;
            text-decoration: none;
            transition: .2s;
        }

        .user-menu a:hover,
        .user-menu button:hover {
            background: #eff6ff;
            color: var(--primary);
        }

        .user-menu form {
            margin: 0;
        }

        /* MAIN */

        main {
            min-height: 60vh;
        }

        /* FOOTER */

        .client-footer {
            position: relative;
            margin-top: 80px;
            background: linear-gradient(135deg, #001b45, #002b68, #001636);
            color: #fff;
            overflow: hidden;
        }

        .footer-bg {
            position: absolute;
            inset: 0;
            opacity: .15;
            background:
                radial-gradient(circle at 35% 35%, rgba(56, 189, 248, .45), transparent 30%),
                radial-gradient(circle at 70% 50%, rgba(37, 99, 235, .5), transparent 28%);
        }

        .footer-grid {
            position: relative;
            z-index: 2;
            padding: 70px 0;
            display: grid;
            grid-template-columns: 2fr 1.2fr 1.2fr 1.5fr;
            gap: 50px;
        }

        .footer-logo img {
            width: 190px;
            filter: brightness(0) invert(1);
            margin-bottom: 24px;
        }

        .footer-about p {
            max-width: 420px;
            color: #dbeafe;
            line-height: 1.8;
            font-size: 16px;
            margin-bottom: 28px;
        }

        .footer-about h4 {
            font-size: 16px;
            margin-bottom: 14px;
        }

        .socials {
            display: flex;
            gap: 14px;
        }

        .socials a {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            color: #fff;
            background: rgba(255, 255, 255, .12);
            font-size: 19px;
            transition: .25s;
        }

        .socials a:hover {
            background: #0f56d9;
            transform: translateY(-4px);
        }

        .footer-col {
            border-left: 1px solid rgba(255, 255, 255, .12);
            padding-left: 34px;
        }

        .footer-col h3 {
            font-size: 24px;
            margin-bottom: 26px;
            color: #fff;
        }

        .footer-col a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #dbeafe;
            font-size: 17px;
            margin-bottom: 20px;
            transition: .25s;
        }

        .footer-col a:hover {
            color: #38bdf8;
            transform: translateX(5px);
        }

        .footer-col a i {
            font-size: 14px;
            color: #dbeafe;
        }

        .contact p {
            display: flex;
            align-items: center;
            gap: 14px;
            color: #fff;
            font-size: 17px;
            margin-bottom: 22px;
        }

        .contact span {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            background: rgba(59, 130, 246, .25);
            color: #fff;
        }

        .footer-bottom {
            position: relative;
            z-index: 2;
            border-top: 1px solid rgba(255, 255, 255, .12);
            text-align: center;
            padding: 22px;
            color: #cbd5e1;
            font-size: 15px;
        }

        /* RESPONSIVE */

        @media(max-width:1300px) {
            .header-inner {
                flex-wrap: wrap;
                padding: 16px 0;
            }

            .brand {
                width: 100%;
                justify-content: center;
            }

            .main-menu {
                order: 2;
                width: 100%;
                flex-wrap: wrap;
                gap: 22px;
            }

            .main-menu a {
                padding: 8px 0;
            }

            .main-menu a::after {
                bottom: -6px;
            }

            .header-actions {
                margin: 0 auto;
            }
        }

        @media(max-width:992px) {
            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media(max-width:640px) {
            .client-container {
                width: min(100% - 28px, 1380px);
            }

            .main-menu {
                gap: 16px;
            }

            .main-menu a {
                font-size: 14px;
            }

            .header-actions {
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
            }

            .register-btn,
            .login-btn,
            .user-btn {
                height: 46px;
                padding: 0 20px;
            }

            .user-menu {
                left: 50%;
                right: auto;
                transform: translateX(-50%);
            }

            .footer-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }

            .footer-col {
                border-left: none;
                padding-left: 0;
            }

            .footer-about p {
                margin-left: auto;
                margin-right: auto;
            }

            .socials {
                justify-content: center;
            }

            .footer-col a,
            .contact p {
                justify-content: center;
            }
        }

    </style>

    <script>
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');

            if (menu) {
                menu.classList.toggle('show');
            }
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.querySelector('.user-dropdown');
            const menu = document.getElementById('userMenu');

            if (!dropdown || !menu) {
                return;
            }

            if (!dropdown.contains(event.target)) {
                menu.classList.remove('show');
            }
        });

    </script>

</body>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', sans-serif;
        background: #f5f7fa;
        color: #333;
    }

    /* ================= HEADER ================= */

    .header {
        background: #fff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, .08);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .header .container {
        max-width: 1300px;
        margin: auto;
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .logo h1 {
        font-size: 28px;
        color: #0f4db8;
        margin-bottom: 2px;
    }

    .logo span {
        font-size: 13px;
        color: #666;
    }

    /* ================= MENU ================= */

    .menu {
        display: flex;
        align-items: center;
        gap: 28px;
    }

    .menu a {
        text-decoration: none;
        color: #333;
        font-weight: 600;
        position: relative;
        transition: .3s;
    }

    .menu a:hover {
        color: #0f4db8;
    }

    .menu a::after {
        content: '';
        position: absolute;
        bottom: -6px;
        left: 0;
        width: 0;
        height: 2px;
        background: #0f4db8;
        transition: .3s;
    }

    .menu a:hover::after {
        width: 100%;
    }

    /* ================= BUTTON ================= */

    .header-right {
        display: flex;
        gap: 12px;
    }

    .btn {
        text-decoration: none;
        padding: 12px 22px;
        border-radius: 50px;
        font-weight: 600;
        transition: .3s;
    }

    .btn-primary {
        background: linear-gradient(135deg, #0f4db8, #2563eb);
        color: #fff;
        box-shadow: 0 5px 15px rgba(37, 99, 235, .25);
    }

    .btn-primary:hover {
        transform: translateY(-3px);
    }

    .btn-secondary {
        border: 2px solid #0f4db8;
        color: #0f4db8;
        background: #fff;
    }

    .btn-secondary:hover {
        background: #0f4db8;
        color: white;
    }

    /* ================= FOOTER ================= */

    .footer {
        background: #0f172a;
        color: white;
        margin-top: 80px;
    }

    .footer-grid {
        max-width: 1300px;
        margin: auto;
        padding: 60px 30px;
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1.5fr;
        gap: 40px;
    }

    .footer-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 20px;
    }

    .footer-logo h2 {
        margin-bottom: 5px;
    }

    .footer-about p {
        line-height: 1.8;
        color: #cbd5e1;
    }

    .footer h3 {
        margin-bottom: 18px;
        color: #fff;
    }

    .footer ul {
        list-style: none;
    }

    .footer ul li {
        margin-bottom: 12px;
        color: #cbd5e1;
    }

    .footer ul li a {
        text-decoration: none;
        color: #cbd5e1;
        transition: .3s;
    }

    .footer ul li a:hover {
        color: #38bdf8;
    }

    .footer ul li i {
        color: #38bdf8;
        margin-right: 8px;
    }

    .copyright {
        border-top: 1px solid rgba(255, 255, 255, .1);
        text-align: center;
        padding: 18px;
        color: #94a3b8;
    }

    /* ================= RESPONSIVE ================= */

    @media(max-width:1100px) {

        .header .container {
            flex-direction: column;
            gap: 20px;
        }

        .menu {
            flex-wrap: wrap;
            justify-content: center;
        }

        .footer-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media(max-width:768px) {

        .footer-grid {
            grid-template-columns: 1fr;
            text-align: center;
        }

        .header-right {
            flex-direction: column;
            width: 100%;
        }

        .btn {
            text-align: center;
        }
    }

</style>



</html>
