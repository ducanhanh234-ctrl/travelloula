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
                <a href="{{ url('/login') }}" class="btn btn-primary">
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
<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI',sans-serif;
    background:#f5f7fa;
    color:#333;
}

/* ================= HEADER ================= */

.header{
    background:#fff;
    box-shadow:0 4px 20px rgba(0,0,0,.08);
    position:sticky;
    top:0;
    z-index:1000;
}

.header .container{
    max-width:1300px;
    margin:auto;
    padding:15px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.logo{
    display:flex;
    align-items:center;
    gap:12px;
}

.logo h1{
    font-size:28px;
    color:#0f4db8;
    margin-bottom:2px;
}

.logo span{
    font-size:13px;
    color:#666;
}

/* ================= MENU ================= */

.menu{
    display:flex;
    align-items:center;
    gap:28px;
}

.menu a{
    text-decoration:none;
    color:#333;
    font-weight:600;
    position:relative;
    transition:.3s;
}

.menu a:hover{
    color:#0f4db8;
}

.menu a::after{
    content:'';
    position:absolute;
    bottom:-6px;
    left:0;
    width:0;
    height:2px;
    background:#0f4db8;
    transition:.3s;
}

.menu a:hover::after{
    width:100%;
}

/* ================= BUTTON ================= */

.header-right{
    display:flex;
    gap:12px;
}

.btn{
    text-decoration:none;
    padding:12px 22px;
    border-radius:50px;
    font-weight:600;
    transition:.3s;
}

.btn-primary{
    background:linear-gradient(135deg,#0f4db8,#2563eb);
    color:#fff;
    box-shadow:0 5px 15px rgba(37,99,235,.25);
}

.btn-primary:hover{
    transform:translateY(-3px);
}

.btn-secondary{
    border:2px solid #0f4db8;
    color:#0f4db8;
    background:#fff;
}

.btn-secondary:hover{
    background:#0f4db8;
    color:white;
}

/* ================= FOOTER ================= */

.footer{
    background:#0f172a;
    color:white;
    margin-top:80px;
}

.footer-grid{
    max-width:1300px;
    margin:auto;
    padding:60px 30px;
    display:grid;
    grid-template-columns:2fr 1fr 1fr 1.5fr;
    gap:40px;
}

.footer-logo{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:20px;
}

.footer-logo h2{
    margin-bottom:5px;
}

.footer-about p{
    line-height:1.8;
    color:#cbd5e1;
}

.footer h3{
    margin-bottom:18px;
    color:#fff;
}

.footer ul{
    list-style:none;
}

.footer ul li{
    margin-bottom:12px;
    color:#cbd5e1;
}

.footer ul li a{
    text-decoration:none;
    color:#cbd5e1;
    transition:.3s;
}

.footer ul li a:hover{
    color:#38bdf8;
}

.footer ul li i{
    color:#38bdf8;
    margin-right:8px;
}

.copyright{
    border-top:1px solid rgba(255,255,255,.1);
    text-align:center;
    padding:18px;
    color:#94a3b8;
}

/* ================= RESPONSIVE ================= */

@media(max-width:1100px){

    .header .container{
        flex-direction:column;
        gap:20px;
    }

    .menu{
        flex-wrap:wrap;
        justify-content:center;
    }

    .footer-grid{
        grid-template-columns:1fr 1fr;
    }
}

@media(max-width:768px){

    .footer-grid{
        grid-template-columns:1fr;
        text-align:center;
    }

    .header-right{
        flex-direction:column;
        width:100%;
    }

    .btn{
        text-align:center;
    }
}


</style>


</html>
