<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Travelloula')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    @stack('styles')
    @yield('styles')
</head>

<body>
    <header class="client-header">
        <div class="client-container header-inner">
            <a href="{{ route('Client.trang_chu.index') }}" class="brand">
                <img src="{{ asset('images/logo_ngang.png') }}" alt="Travelloula">
            </a>

            <nav class="main-menu">
                <a href="{{ route('Client.trang_chu.index') }}" class="{{ request()->is('/') || request()->is('trang_chu') ? 'active' : '' }}">
                    Trang chủ
                </a>

                <a href="{{ route('Client.danh_sach_tour.index') }}" class="{{ request()->is('tour*') ? 'active' : '' }}">
                    Tour
                </a>

                @auth
                <a href="{{ route('Client.tour_yeu_thich.index') }}" class="{{ request()->is('tour_yeu_thich*') ? 'active' : '' }}">
                    Tour yêu thích
                </a>
                @endauth

                <a href="{{ route('Client.dieu_khoan.index') }}" class="{{ request()->is('dieu_khoan*') ? 'active' : '' }}">
                    Điều khoản
                </a>

                <a href="{{ route('Client.bai_viet.index') }}" class="{{ request()->is('bai_viet*') ? 'active' : '' }}">
                    Bài viết
                </a>

                <a href="#">
                    Ưu đãi
                </a>

                <a href="#">
                    Liên hệ
                </a>

                <a href="{{ route('Client.ve_chung_toi.index') }}" class="{{ request()->is('ve_chung_toi*') ? 'active' : '' }}">
                    Về chúng tôi
                </a>
            </nav>

            <div class="header-actions">
                @auth
                <div class="user-dropdown">
                    <button type="button" class="user-btn" id="userMenuButton" aria-expanded="false" aria-controls="userMenu">
                        <i class="fa-regular fa-user"></i>
                        <span>{{ auth()->user()->name }}</span>
                        <i class="fa-solid fa-angle-down"></i>
                    </button>

                    <div class="user-menu" id="userMenu">
                        <a href="{{ route('profile') }}">
                            <i class="fa-regular fa-id-card"></i>
                            Hồ sơ cá nhân
                        </a>

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
                <a href="{{ route('register') }}" class="register-btn">
                    Đăng ký
                </a>

                <a href="{{ route('login') }}" class="login-btn">
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
        <div class="footer-top-line"></div>

        <div class="footer-plane">
            <i class="fa-solid fa-plane"></i>
        </div>

        <div class="footer-bag">
            <i class="fa-solid fa-suitcase-rolling"></i>
        </div>

        <div class="client-container footer-content">
            <div class="footer-brand">
                <a href="{{ route('Client.trang_chu.index') }}" class="footer-logo">
                    <img src="{{ asset('images/travelloula_logo_only_clean_v2.png') }}" alt="Travelloula">
                </a>

                <p>
                    Travelloula giúp khách hàng dễ dàng tìm kiếm, đặt tour và quản lý
                    hành trình du lịch một cách nhanh chóng, an toàn và thuận tiện.
                </p>

                <div class="footer-socials">
                    <a href="#" class="facebook" aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>

                    <a href="#" class="tiktok" aria-label="TikTok">
                        <i class="fa-brands fa-tiktok"></i>
                    </a>

                    <a href="#" class="youtube" aria-label="YouTube">
                        <i class="fa-brands fa-youtube"></i>
                    </a>

                    <a href="#" class="instagram" aria-label="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>

            <div class="footer-col footer-discover">
                <h3>Khám phá</h3>

                <a href="{{ route('Client.trang_chu.index') }}">
                    <i class="fa-solid fa-angle-right"></i>
                    Trang chủ
                </a>

                <a href="{{ route('Client.danh_sach_tour.index') }}">
                    <i class="fa-solid fa-angle-right"></i>
                    Tour
                </a>

                @auth
                <a href="{{ route('Client.tour_yeu_thich.index') }}">
                    <i class="fa-solid fa-angle-right"></i>
                    Tour yêu thích
                </a>
                @endauth

                <a href="{{ route('Client.bai_viet.index') }}">
                    <i class="fa-solid fa-angle-right"></i>
                    Bài viết
                </a>

                <a href="{{ route('Client.ve_chung_toi.index') }}">
                    <i class="fa-solid fa-angle-right"></i>
                    Về chúng tôi
                </a>
            </div>

            <div class="footer-col footer-contact">
                <h3>Liên hệ</h3>

                <div class="contact-item">
                    <span>
                        <i class="fa-solid fa-location-dot"></i>
                    </span>
                    <p>Hà Nội, Việt Nam</p>
                </div>

                <div class="contact-item">
                    <span>
                        <i class="fa-solid fa-phone"></i>
                    </span>
                    <p>1900 1234</p>
                </div>

                <div class="contact-item">
                    <span>
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <p>support@travelloula.com</p>
                </div>

                <div class="contact-item">
                    <span>
                        <i class="fa-regular fa-clock"></i>
                    </span>
                    <p>Thứ 2 - Chủ nhật: 08:00 - 22:00</p>
                </div>
            </div>

            <div class="footer-col footer-news">
                <h3>Nhận thông tin mới nhất</h3>

                <p>
                    Đăng ký để nhận ưu đãi hấp dẫn, kinh nghiệm du lịch và các
                    hành trình nổi bật từ Travelloula.
                </p>

                <form action="#" method="GET" class="footer-form">
                    <input type="email" name="email" placeholder="Nhập email của bạn" aria-label="Email đăng ký nhận tin">

                    <button type="submit">
                        Đăng ký
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="footer-wave">
            <div class="footer-sun"></div>

            <div class="footer-island">
                <div class="palm palm-one"></div>
                <div class="palm palm-two"></div>
                <div class="bird bird-one"></div>
                <div class="bird bird-two"></div>
                <div class="bird bird-three"></div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="client-container footer-bottom-inner">
                <p>© 2026 Travelloula. All Rights Reserved.</p>

                <div>
                    <a href="{{ route('Client.dieu_khoan.index') }}">Điều khoản</a>
                    <a href="#">Chính sách bảo mật</a>
                    <a href="#">Câu hỏi thường gặp</a>
                    <a href="#">Liên hệ</a>
                </div>
            </div>
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

        .client-header {
            position: sticky;
            top: 0;
            z-index: 999;
            min-height: 88px;
            background: #fff;
            box-shadow: 0 6px 24px rgba(15, 23, 42, .06);
        }

        .header-inner {
            display: flex;
            min-height: 88px;
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
            display: block;
            width: 155px;
        }

        .main-menu {
            display: flex;
            flex: 1;
            align-items: center;
            justify-content: center;
            gap: 30px;
        }

        .main-menu a {
            position: relative;
            padding: 34px 0 30px;
            color: #020617;
            font-size: 15px;
            font-weight: 800;
            white-space: nowrap;
            transition: .25s;
        }

        .main-menu a::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
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
        .login-btn,
        .user-btn {
            display: flex;
            height: 52px;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 0 28px;
            border-radius: 999px;
            font-size: 15px;
            font-weight: 900;
            white-space: nowrap;
            transition: .25s;
        }

        .register-btn {
            border: 2px solid var(--primary);
            background: #fff;
            color: var(--primary);
        }

        .register-btn:hover {
            background: var(--primary);
            color: #fff;
            transform: translateY(-2px);
        }

        .login-btn,
        .user-btn {
            border: 0;
            background: linear-gradient(135deg, #0757d8, #0044c7);
            color: #fff;
            box-shadow: 0 12px 26px rgba(0, 68, 199, .25);
        }

        .login-btn:hover,
        .user-btn:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 16px 34px rgba(0, 68, 199, .35);
        }

        .user-dropdown {
            position: relative;
        }

        .user-btn {
            cursor: pointer;
        }

        .user-menu {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            z-index: 99999;
            display: none;
            width: 230px;
            padding: 10px;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 22px 50px rgba(15, 23, 42, .16);
        }

        .user-menu.show {
            display: block;
        }

        .user-menu a,
        .user-menu button {
            display: flex;
            width: 100%;
            min-height: 44px;
            align-items: center;
            gap: 10px;
            padding: 0 14px;
            border: 0;
            border-radius: 12px;
            background: transparent;
            color: #0f172a;
            font-size: 14px;
            font-weight: 850;
            text-align: left;
            text-decoration: none;
            cursor: pointer;
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

        main {
            min-height: 60vh;
        }

        .client-footer {
            position: relative;
            margin-top: 90px;
            overflow: hidden;
            color: #fff;
            background:
                radial-gradient(circle at 18% 38%, rgba(0, 180, 216, .20), transparent 26%),
                radial-gradient(circle at 86% 23%, rgba(0, 119, 182, .38), transparent 31%),
                linear-gradient(135deg, #031b40 0%, #063f7a 52%, #012e56 100%);
        }

        .footer-top-line {
            width: 100%;
            height: 7px;
            background: linear-gradient(90deg,
                    #0757d8 0%,
                    #00b4d8 45%,
                    #6ee7b7 68%,
                    #facc15 84%,
                    #f59e0b 100%);
        }

        .client-footer::before {
            content: "";
            position: absolute;
            inset: 7px 0 0;
            background:
                linear-gradient(90deg, rgba(255, 255, 255, .035) 1px, transparent 1px),
                linear-gradient(180deg, rgba(255, 255, 255, .03) 1px, transparent 1px);
            background-size: 58px 58px;
            opacity: .32;
            pointer-events: none;
        }

        .client-footer::after {
            content: "";
            position: absolute;
            bottom: 105px;
            left: 16%;
            width: 540px;
            height: 260px;
            background: radial-gradient(circle, rgba(255, 255, 255, .75) 2px, transparent 3px);
            background-size: 18px 18px;
            opacity: .09;
            pointer-events: none;
        }

        .footer-content {
            position: relative;
            z-index: 5;
            display: grid;
            grid-template-columns: 1.38fr .9fr 1.15fr 1.45fr;
            gap: 54px;
            align-items: start;
            padding: 84px 0 148px;
        }

        .footer-logo {
            display: inline-flex;
            align-items: center;
            justify-content: flex-start;
            margin-bottom: 28px;
            padding: 0;
            border: none;
            background: transparent;
            box-shadow: none;
            text-decoration: none;
        }

        .footer-logo img {
            display: block;
            width: 250px;
            height: auto;
            border: none;
            background: transparent;
            box-shadow: none;
            object-fit: contain;
            filter:
                drop-shadow(0 8px 16px rgba(0, 0, 0, .28)) drop-shadow(0 0 10px rgba(0, 180, 216, .18));
        }

        .footer-brand p,
        .footer-news p {
            margin: 0;
            color: #e6f4ff;
            font-size: 17px;
            line-height: 1.85;
            font-weight: 650;
        }

        .footer-brand p {
            max-width: 410px;
        }

        .footer-socials {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-top: 34px;
        }

        .footer-socials a {
            display: grid;
            width: 55px;
            height: 55px;
            place-items: center;
            border-radius: 50%;
            color: #fff;
            font-size: 23px;
            text-decoration: none;
            box-shadow: 0 14px 30px rgba(0, 0, 0, .22);
            transition: .25s ease;
        }

        .footer-socials a:hover {
            transform: translateY(-5px) scale(1.04);
        }

        .footer-socials .facebook {
            background: #1877f2;
        }

        .footer-socials .tiktok {
            background: #111827;
        }

        .footer-socials .youtube {
            background: #ff1f2d;
        }

        .footer-socials .instagram {
            background: linear-gradient(135deg, #7c3aed, #ec4899, #f97316);
        }

        .footer-col h3 {
            position: relative;
            margin: 0 0 38px;
            color: #fff;
            font-size: 30px;
            line-height: 1.2;
            font-weight: 1000;
        }

        .footer-col h3::after {
            content: "";
            position: absolute;
            bottom: -17px;
            left: 0;
            width: 58px;
            height: 5px;
            border-radius: 999px;
            background: #facc15;
        }

        .footer-col a {
            display: flex;
            width: max-content;
            max-width: 100%;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
            color: #f1f7ff;
            font-size: 18px;
            line-height: 1.4;
            font-weight: 700;
            text-decoration: none;
            transition: .22s ease;
        }

        .footer-col a i {
            color: #00b4d8;
            font-size: 17px;
        }

        .footer-col a:hover {
            color: #facc15;
            transform: translateX(6px);
        }

        .footer-contact .contact-item {
            display: grid;
            grid-template-columns: 58px 1fr;
            gap: 18px;
            align-items: center;
            margin-bottom: 22px;
        }

        .footer-contact .contact-item span {
            display: grid;
            width: 58px;
            height: 58px;
            place-items: center;
            border-radius: 50%;
            background: #08aeea;
            color: #fff;
            font-size: 22px;
            box-shadow: 0 12px 28px rgba(8, 174, 234, .30);
        }

        .footer-contact .contact-item p {
            margin: 0;
            color: #fff;
            font-size: 18px;
            line-height: 1.45;
            font-weight: 800;
        }

        .footer-news p {
            max-width: 500px;
            margin-bottom: 34px;
        }

        .footer-form {
            display: flex;
            width: 100%;
            max-width: 530px;
            height: 69px;
            align-items: center;
            padding: 7px;
            border-radius: 999px;
            background: #fff;
            box-shadow: 0 18px 45px rgba(0, 0, 0, .24);
        }

        .footer-form input {
            flex: 1;
            min-width: 0;
            height: 100%;
            padding: 0 25px;
            border: 0;
            outline: 0;
            background: transparent;
            color: #0f172a;
            font-size: 17px;
            font-weight: 650;
        }

        .footer-form input::placeholder {
            color: #94a3b8;
        }

        .footer-form button {
            display: inline-flex;
            height: 55px;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 0 24px;
            border: 0;
            border-radius: 999px;
            background: linear-gradient(135deg, #facc15, #f59e0b);
            color: #fff;
            font-size: 17px;
            font-weight: 1000;
            white-space: nowrap;
            cursor: pointer;
            transition: .22s ease;
        }

        .footer-form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 26px rgba(245, 158, 11, .34);
        }

        .footer-plane {
            position: absolute;
            top: 125px;
            right: 45px;
            z-index: 1;
            color: rgba(255, 255, 255, .12);
            font-size: 66px;
            transform: rotate(-14deg);
        }

        .footer-bag {
            position: absolute;
            right: 70px;
            bottom: 205px;
            z-index: 1;
            color: rgba(255, 255, 255, .08);
            font-size: 80px;
        }

        .footer-wave {
            position: absolute;
            right: 0;
            bottom: 88px;
            left: 0;
            z-index: 3;
            height: 198px;
            overflow: hidden;
            pointer-events: none;
        }

        .footer-wave::before,
        .footer-wave::after {
            content: "";
            position: absolute;
            height: 220px;
            border-radius: 50% 50% 0 0 / 58% 58% 0 0;
        }

        .footer-wave::before {
            right: -6%;
            bottom: -82px;
            left: -6%;
            background: linear-gradient(135deg, #0ea5e9, #0757d8);
            transform: rotate(-3deg);
        }

        .footer-wave::after {
            right: -10%;
            bottom: -98px;
            left: 42%;
            background: linear-gradient(135deg, #0757d8, #052c8c);
            transform: rotate(4deg);
            opacity: .96;
        }

        .footer-sun {
            position: absolute;
            bottom: 40px;
            left: 95px;
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #facc15, #f97316);
            box-shadow: 0 0 34px rgba(250, 204, 21, .38);
        }

        .footer-island {
            position: absolute;
            bottom: 32px;
            left: 0;
            width: 250px;
            height: 110px;
        }

        .footer-island::before {
            content: "";
            position: absolute;
            bottom: -18px;
            left: -20px;
            width: 270px;
            height: 58px;
            border-radius: 55% 55% 0 0;
            background: #031b40;
        }

        .palm {
            position: absolute;
            bottom: 24px;
            z-index: 2;
            width: 14px;
            height: 96px;
            border-radius: 999px;
            background: #031b40;
            transform-origin: bottom;
        }

        .palm::before {
            content: "";
            position: absolute;
            top: -28px;
            left: -42px;
            width: 96px;
            height: 70px;
            background: #031b40;
            clip-path: polygon(50% 50%,
                    0 25%,
                    42% 42%,
                    18% 0,
                    55% 34%,
                    72% 0,
                    68% 40%,
                    100% 20%,
                    72% 52%,
                    100% 70%,
                    60% 62%,
                    40% 100%,
                    38% 62%,
                    0 80%);
        }

        .palm-one {
            left: 45px;
            transform: rotate(-14deg);
        }

        .palm-two {
            left: 92px;
            height: 72px;
            transform: rotate(8deg);
        }

        .bird {
            position: absolute;
            z-index: 4;
            width: 22px;
            height: 10px;
            border-top: 3px solid #031b40;
            border-radius: 50%;
        }

        .bird::after {
            content: "";
            position: absolute;
            top: -3px;
            left: 11px;
            width: 22px;
            height: 10px;
            border-top: 3px solid #031b40;
            border-radius: 50%;
        }

        .bird-one {
            bottom: 62px;
            left: 185px;
            transform: rotate(8deg) scale(.8);
        }

        .bird-two {
            bottom: 74px;
            left: 220px;
            transform: rotate(-4deg) scale(.65);
        }

        .bird-three {
            bottom: 90px;
            left: 155px;
            transform: rotate(-6deg) scale(.55);
        }

        .footer-bottom {
            position: relative;
            z-index: 5;
            border-top: 1px solid rgba(255, 255, 255, .14);
            background: rgba(2, 20, 49, .78);
        }

        .footer-bottom-inner {
            display: flex;
            min-height: 88px;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .footer-bottom p {
            margin: 0;
            color: #fff;
            font-size: 16px;
            font-weight: 650;
        }

        .footer-bottom-inner div {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .footer-bottom a {
            position: relative;
            color: #fff;
            font-size: 16px;
            font-weight: 650;
            text-decoration: none;
            transition: .22s ease;
        }

        .footer-bottom a:not(:last-child)::after {
            content: "";
            position: absolute;
            top: 50%;
            right: -15px;
            width: 1px;
            height: 18px;
            background: rgba(255, 255, 255, .45);
            transform: translateY(-50%);
        }

        .footer-bottom a:hover {
            color: #facc15;
        }

        @media (max-width: 1300px) {
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

        @media (max-width: 1200px) {
            .footer-content {
                grid-template-columns: 1fr 1fr;
                gap: 44px;
            }

            .footer-news {
                grid-column: span 2;
            }

            .footer-form {
                max-width: 100%;
            }
        }

        @media (max-width: 760px) {
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
                right: auto;
                left: 50%;
                transform: translateX(-50%);
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 34px;
                padding: 58px 0 135px;
                text-align: center;
            }

            .footer-logo {
                justify-content: center;
                margin-right: auto;
                margin-left: auto;
            }

            .footer-logo img {
                width: 210px;
            }

            .footer-brand p,
            .footer-news p {
                max-width: 100%;
            }

            .footer-socials {
                justify-content: center;
            }

            .footer-col h3::after {
                left: 50%;
                transform: translateX(-50%);
            }

            .footer-col a {
                justify-content: center;
                margin-right: auto;
                margin-left: auto;
            }

            .footer-contact .contact-item {
                grid-template-columns: 1fr;
                justify-items: center;
                gap: 10px;
            }

            .footer-news {
                grid-column: auto;
            }

            .footer-form {
                height: auto;
                flex-direction: column;
                padding: 8px;
                border-radius: 22px;
            }

            .footer-form input {
                width: 100%;
                height: 46px;
                text-align: center;
            }

            .footer-form button {
                width: 100%;
                height: 48px;
            }

            .footer-wave {
                bottom: 112px;
                height: 140px;
            }

            .footer-sun,
            .footer-island,
            .footer-plane,
            .footer-bag {
                display: none;
            }

            .footer-bottom-inner {
                min-height: auto;
                flex-direction: column;
                padding: 22px 0;
                text-align: center;
            }

            .footer-bottom-inner div {
                flex-wrap: wrap;
                justify-content: center;
                gap: 18px;
            }

            .footer-bottom a:not(:last-child)::after {
                display: none;
            }
        }

    </style>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const button = document.getElementById('userMenuButton');
            const menu = document.getElementById('userMenu');

            if (!button || !menu) {
                return;
            }

            button.addEventListener('click', function(event) {
                event.stopPropagation();

                const isOpen = menu.classList.toggle('show');
                button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            });

            menu.addEventListener('click', function(event) {
                event.stopPropagation();
            });

            document.addEventListener('click', function() {
                menu.classList.remove('show');
                button.setAttribute('aria-expanded', 'false');
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    menu.classList.remove('show');
                    button.setAttribute('aria-expanded', 'false');
                }
            });
        });

    </script>

    @yield('scripts')
    @stack('scripts')
</body>
</html>
