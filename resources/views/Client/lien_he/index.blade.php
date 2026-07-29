@extends('Layouts.app')

@section('title', 'Liên hệ')

@section('content')

    <style>
        :root {
            --primary: #0d6efd;
            --primary-hover: #0b5ed7;
            --border: #e9ecef;
            --shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        /* ================= Banner ================= */

        .contact-banner {
            background: linear-gradient(rgba(13, 110, 253, .65), rgba(13, 110, 253, .65)),
                url('{{ asset('images/banner-contact.jpg') }}') center center/cover no-repeat;

            padding: 120px 0;
            color: #fff;
            text-align: center;
        }

        .contact-banner h1 {
            font-size: 48px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .contact-banner p {
            max-width: 700px;
            margin: auto;
            font-size: 18px;
            opacity: .95;
        }

        /* ================= Breadcrumb ================= */

        .contact-breadcrumb {
            background: #fff;
            border-bottom: 1px solid #ececec;
            padding: 15px 0;
        }

        .contact-breadcrumb .breadcrumb {
            margin-bottom: 0;
        }

        .contact-breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        /* ================= Section ================= */

        .contact-section {
            padding: 80px 0;
            background: #f8fafc;
        }

        .section-title {
            text-align: center;
            margin-bottom: 15px;
            font-size: 38px;
            font-weight: 700;
        }

        .section-subtitle {
            text-align: center;
            color: #6c757d;
            margin-bottom: 50px;
        }

        /* ================= Card ================= */

        .contact-card {

            background: #fff;

            border-radius: 18px;

            padding: 35px 25px;

            text-align: center;

            border: 1px solid var(--border);

            box-shadow: var(--shadow);

            transition: .35s;
        }

        .contact-card:hover {

            transform: translateY(-8px);

        }

        .contact-icon {

            width: 75px;

            height: 75px;

            border-radius: 50%;

            background: #eef5ff;

            display: flex;

            justify-content: center;

            align-items: center;

            margin: 0 auto 20px;

            font-size: 28px;

            color: var(--primary);

        }

        .contact-card h5 {

            font-weight: 700;

            margin-bottom: 15px;

        }

        .contact-card p {

            margin-bottom: 6px;

            color: #666;

        }

        @media(max-width:768px) {

            .contact-banner {

                padding: 90px 0;

            }

            .contact-banner h1 {

                font-size: 34px;

            }

            .section-title {

                font-size: 30px;

            }

        }

        .contact-form-section {
            padding: 80px 0;
            background: #fff;
        }

        .contact-form-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, .08);
            overflow: hidden;
        }

        .contact-form-left {
            padding: 45px;
        }

        .contact-form-left h2 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .contact-form-left p {
            color: #6c757d;
            margin-bottom: 30px;
        }

        .form-control {
            height: 50px;
            border-radius: 12px;
            border: 1px solid #dee2e6;
        }

        textarea.form-control {
            height: 160px;
            resize: none;
        }

        .btn-send {
            background: #0d6efd;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 14px 40px;
            transition: .3s;
            font-weight: 600;
        }

        .btn-send:hover {
            background: #0b5ed7;
            color: #fff;
        }

        .contact-image {
            height: 100%;
            min-height: 650px;
            background: url('{{ asset('images/contact-form.png') }}') center center no-repeat;
            background-size: contain;
            background-color: #f8f9fa;
        }

        @media(max-width:991px) {

            .contact-image {
                min-height: 350px;
            }

            .contact-form-left {
                padding: 30px;
            }

        }
    </style>

    {{-- ================= Banner ================= --}}

    <section class="contact-banner">

        <div class="container">

            <h1>Liên Hệ Với Travelloula</h1>

            <p>

                Nếu bạn có bất kỳ câu hỏi nào về tour du lịch,

                hãy liên hệ với chúng tôi.

                Đội ngũ Travelloula luôn sẵn sàng hỗ trợ bạn.

            </p>

        </div>

    </section>

    {{-- ================= Breadcrumb ================= --}}

    <div class="contact-breadcrumb">

        <div class="container">

            <nav>

                <ol class="breadcrumb">

                    <li class="breadcrumb-item">

                        <a href="{{ route('home') }}">

                            Trang chủ

                        </a>

                    </li>

                    <li class="breadcrumb-item active">

                        Liên hệ

                    </li>

                </ol>

            </nav>

        </div>

    </div>

    {{-- ================= Thông tin liên hệ ================= --}}

    <section class="contact-section">

        <div class="container">

            <h2 class="section-title">

                Thông Tin Liên Hệ

            </h2>

            <p class="section-subtitle">

                Chúng tôi luôn sẵn sàng hỗ trợ và tư vấn cho bạn.

            </p>

            <div class="row g-4">

                <div class="col-lg-3 col-md-6">

                    <div class="contact-card">

                        <div class="contact-icon">

                            <i class="fas fa-map-marker-alt"></i>

                        </div>

                        <h5>Địa chỉ</h5>

                        <p>Travelloula Travel</p>

                        <p>FPT Polytechnic</p>

                        <p>Trịnh Văn Bô</p>

                        <p>Nam Từ Liêm - Hà Nội</p>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6">

                    <div class="contact-card">

                        <div class="contact-icon">

                            <i class="fas fa-phone"></i>

                        </div>

                        <h5>Hotline</h5>

                        <p>1900 9999</p>

                        <p>0988 888 888</p>

                        <p>Hỗ trợ 24/7</p>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6">

                    <div class="contact-card">

                        <div class="contact-icon">

                            <i class="fas fa-envelope"></i>

                        </div>

                        <h5>Email</h5>

                        <p>support@travelloula.vn</p>

                        <p>booking@travelloula.vn</p>

                        <p>Phản hồi trong 24 giờ</p>

                    </div>

                </div>

                <div class="col-lg-3 col-md-6">

                    <div class="contact-card">

                        <div class="contact-icon">

                            <i class="fas fa-clock"></i>

                        </div>

                        <h5>Giờ làm việc</h5>

                        <p>Thứ 2 - Chủ nhật</p>

                        <p>08:00 - 22:00</p>

                        <p>Online 24/7</p>

                    </div>

                </div>

            </div>

        </div>

    </section>
    {{-- ================= FORM LIÊN HỆ ================= --}}
    <section class="contact-form-section">

        <div class="container">

            <div class="contact-form-card">

                <div class="row g-0">

                    {{-- FORM --}}

                    <div class="col-lg-7">

                        <div class="contact-form-left">

                            <h2>Gửi Liên Hệ</h2>

                            <p>
                                Điền thông tin bên dưới, Travelloula sẽ liên hệ với bạn
                                trong thời gian sớm nhất.
                            </p>

                            {{-- Thông báo thành công --}}

                            @if (session('success'))
                                <div class="alert alert-success">

                                    {{ session('success') }}

                                </div>
                            @endif

                            <form method="POST" action="{{ route('Client.lien_he.store') }}">

                                @csrf

                                <div class="mb-3">

                                    <label class="form-label">
                                        Họ và tên
                                    </label>

                                    <input type="text" name="ho_ten"
                                        class="form-control @error('ho_ten') is-invalid @enderror"
                                        value="{{ old('ho_ten') }}">

                                    @error('ho_ten')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <div class="row">

                                    <div class="col-md-6">

                                        <div class="mb-3">

                                            <label class="form-label">

                                                Email

                                            </label>

                                            <input type="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}">

                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="mb-3">

                                            <label class="form-label">

                                                Số điện thoại

                                            </label>

                                            <input type="text" name="so_dien_thoai"
                                                class="form-control @error('so_dien_thoai') is-invalid @enderror"
                                                value="{{ old('so_dien_thoai') }}">

                                            @error('so_dien_thoai')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>

                                    </div>

                                </div>

                                <div class="mb-3">

                                    <label class="form-label">

                                        Tiêu đề

                                    </label>

                                    <input type="text" name="tieu_de"
                                        class="form-control @error('tieu_de') is-invalid @enderror"
                                        value="{{ old('tieu_de') }}">

                                    @error('tieu_de')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <div class="mb-4">

                                    <label class="form-label">

                                        Nội dung

                                    </label>

                                    <textarea name="noi_dung" class="form-control @error('noi_dung') is-invalid @enderror">{{ old('noi_dung') }}</textarea>

                                    @error('noi_dung')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                <button class="btn btn-send">

                                    <i class="fas fa-paper-plane me-2"></i>

                                    Gửi liên hệ

                                </button>

                            </form>

                        </div>

                    </div>

                    {{-- ẢNH --}}

                    <div class="col-lg-5">

                        <div class="contact-image"></div>

                    </div>

                </div>

            </div>

        </div>

    </section>
@endsection
