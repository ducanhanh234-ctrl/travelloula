@extends('Layouts.app')

@section('title', 'Liên hệ - Travelloula')

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

    /* ================= Sections & Headings ================= */
    .contact-section, .map-section, .faq-section {
        padding: 80px 0;
        background: #f8fafc;
    }

    .contact-form-section {
        padding: 80px 0;
        background: #fff;
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

    /* ================= Contact Cards ================= */
    .contact-card {
        background: #fff;
        border-radius: 18px;
        padding: 35px 25px;
        text-align: center;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        transition: .35s;
        height: 100%;
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

    /* ================= Map Section ================= */
    .map-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .map-title h2 {
        font-size: 38px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .map-card {
        overflow: hidden;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, .08);
        border: 1px solid #eee;
    }

    .map-card iframe {
        width: 100%;
        height: 500px;
        border: 0;
        display: block;
    }

    .quick-contact {
        margin-top: 40px;
    }

    .quick-item {
        background: #fff;
        border-radius: 18px;
        padding: 25px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, .06);
        text-align: center;
        transition: .3s;
        height: 100%;
        border: 1px solid #eee;
    }

    .quick-item:hover {
        transform: translateY(-8px);
    }

    .quick-item i {
        font-size: 42px;
        color: var(--primary);
        margin-bottom: 15px;
    }

    .quick-item h5 {
        font-weight: 700;
        margin-bottom: 10px;
    }

    .quick-item p {
        margin-bottom: 0;
        color: #666;
    }

    /* ================= Contact Form ================= */
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
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: 12px;
        padding: 14px 40px;
        transition: .3s;
        font-weight: 600;
    }

    .btn-send:hover {
        background: var(--primary-hover);
        color: #fff;
    }

    .contact-image {
        height: 100%;
        min-height: 650px;
        background: url('{{ asset('images/contact-form.png') }}') center center no-repeat;
        background-size: cover;
        background-color: #f8f9fa;
    }

    /* ================= FAQ ================= */
    .faq-title {
        text-align: center;
        margin-bottom: 60px;
    }

    .faq-title span {
        color: var(--primary);
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .faq-title h2 {
        font-size: 42px;
        font-weight: 700;
        margin-top: 10px;
        margin-bottom: 15px;
    }

    .faq-title p {
        color: #6c757d;
        max-width: 700px;
        margin: auto;
    }

    .faq-list {
        max-width: 900px;
        margin: auto;
    }

    .faq-item {
        background: #fff;
        border-radius: 18px;
        margin-bottom: 18px;
        overflow: hidden;
        box-shadow: 0 12px 25px rgba(0, 0, 0, .06);
        transition: .3s;
    }

    .faq-item.active {
        box-shadow: 0 15px 35px rgba(13, 110, 253, .18);
    }

    .faq-question {
        padding: 24px 30px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 18px;
        font-weight: 600;
        user-select: none;
    }

    .faq-question:hover {
        color: var(--primary);
    }

    .faq-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #eef5ff;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        color: var(--primary);
        transition: transform .3s ease, background .3s ease, color .3s ease;
        flex-shrink: 0;
    }

    .faq-item.active .faq-icon {
        background: var(--primary);
        color: #fff;
        transform: rotate(45deg);
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height .35s ease;
        padding: 0 30px;
    }

    .faq-answer p {
        color: #6c757d;
        line-height: 1.8;
        padding-bottom: 25px;
        margin: 0;
    }

    /* Validation & Alerts */
    .invalid-feedback {
        display: block;
        font-size: 14px;
    }

    .is-invalid {
        border-color: #dc3545;
    }

    .is-invalid:focus {
        box-shadow: 0 0 0 .2rem rgba(220, 53, 69, .15);
    }

    /* Responsive */
    @media(max-width:991px) {
        .contact-image {
            min-height: 350px;
        }
        .contact-form-left {
            padding: 30px;
        }
    }

    @media(max-width:768px) {
        .contact-banner {
            padding: 90px 0;
        }
        .contact-banner h1 {
            font-size: 34px;
        }
        .section-title, .map-title h2, .faq-title h2 {
            font-size: 30px;
        }
        .faq-question {
            font-size: 16px;
            padding: 20px;
        }
        .faq-answer {
            padding: 0 20px;
        }
    }
</style>

{{-- Banner --}}
<section class="contact-banner">
    <div class="container">
        <h1>Liên Hệ Với Travelloula</h1>
        <p>
            Nếu bạn có bất kỳ câu hỏi nào về tour du lịch, hãy liên hệ với chúng tôi.
            Đội ngũ Travelloula luôn sẵn sàng hỗ trợ bạn.
        </p>
    </div>
</section>

{{-- Breadcrumb --}}
<div class="contact-breadcrumb">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Trang chủ</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
            </ol>
        </nav>
    </div>
</div>

{{-- Vị trí & Bản đồ --}}
<section class="map-section">
    <div class="container">
        <div class="map-title">
            <h2>Vị Trí Của Chúng Tôi</h2>
            <p>Ghé thăm văn phòng Travelloula hoặc liên hệ trực tiếp để được tư vấn nhanh nhất.</p>
        </div>

        <div class="map-card">
            <iframe src="https://www.google.com/maps?q=FPT+Polytechnic+Trịnh+Văn+Bô&output=embed" loading="lazy" allowfullscreen></iframe>
        </div>

        <div class="row g-4 quick-contact">
            <div class="col-lg-4">
                <div class="quick-item">
                    <i class="fas fa-headset"></i>
                    <h5>Hỗ trợ 24/7</h5>
                    <p>Đội ngũ chăm sóc khách hàng luôn sẵn sàng hỗ trợ bạn mọi lúc.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="quick-item">
                    <i class="fas fa-credit-card"></i>
                    <h5>Thanh toán an toàn</h5>
                    <p>Hỗ trợ nhiều phương thức thanh toán bảo mật và nhanh chóng.</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="quick-item">
                    <i class="fas fa-plane-departure"></i>
                    <h5>Hơn 1000+ Tour</h5>
                    <p>Khám phá hàng nghìn tour du lịch trong và ngoài nước với mức giá hấp dẫn.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Thông tin liên hệ --}}
<section class="contact-section">
    <div class="container">
        <h2 class="section-title">Thông Tin Liên Hệ</h2>
        <p class="section-subtitle">Chúng tôi luôn sẵn sàng hỗ trợ và tư vấn cho bạn.</p>

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

{{-- Form liên hệ --}}
<section class="contact-form-section">
    <div class="container">
        <div class="contact-form-card">
            <div class="row g-0">
                <div class="col-lg-7">
                    <div class="contact-form-left">
                        <h2>Gửi Liên Hệ</h2>
                        <p>Điền thông tin bên dưới, Travelloula sẽ liên hệ với bạn trong thời gian sớm nhất.</p>

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Vui lòng kiểm tra lại thông tin:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('Client.lien_he.store') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input type="text" name="ho_ten" class="form-control @error('ho_ten') is-invalid @enderror" value="{{ old('ho_ten') }}">
                                @error('ho_ten')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Số điện thoại</label>
                                        <input type="text" name="so_dien_thoai" class="form-control @error('so_dien_thoai') is-invalid @enderror" value="{{ old('so_dien_thoai') }}">
                                        @error('so_dien_thoai')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tiêu đề</label>
                                <input type="text" name="tieu_de" class="form-control @error('tieu_de') is-invalid @enderror" value="{{ old('tieu_de') }}">
                                @error('tieu_de')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Nội dung</label>
                                <textarea name="noi_dung" class="form-control @error('noi_dung') is-invalid @enderror">{{ old('noi_dung') }}</textarea>
                                @error('noi_dung')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-send">
                                <i class="fas fa-paper-plane me-2"></i> Gửi liên hệ
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="contact-image"></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="faq-section">
    <div class="container">
        <div class="faq-title">
            <span>FAQ</span>
            <h2>Câu hỏi thường gặp</h2>
            <p>Một số câu hỏi phổ biến của khách hàng khi đặt tour tại Travelloula.</p>
        </div>

        <div class="faq-list">
            <div class="faq-item">
                <div class="faq-question">
                    Làm thế nào để đặt tour?
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>Chọn tour yêu thích, nhấn "Đặt tour", điền thông tin và thanh toán trực tuyến. Sau khi thanh toán thành công, hệ thống sẽ gửi xác nhận qua email.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    Tôi có thể đổi ngày khởi hành không?
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>Có. Bạn có thể đổi ngày khởi hành nếu tour còn chỗ và đáp ứng chính sách đổi tour của Travelloula.</p>
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question">
                    Chính sách hoàn tiền như thế nào?
                    <div class="faq-icon">+</div>
                </div>
                <div class="faq-answer">
                    <p>Mức hoàn tiền phụ thuộc vào thời điểm hủy tour. Vui lòng xem mục Điều khoản hoặc liên hệ nhân viên để được hỗ trợ.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Script điều khiển đóng mở Accordion FAQ --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const faqItems = document.querySelectorAll('.faq-item');

        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');

            question.addEventListener('click', () => {
                const isActive = item.classList.contains('active');

                // Đóng tất cả các tab khác
                faqItems.forEach(otherItem => {
                    otherItem.classList.remove('active');
                    otherItem.querySelector('.faq-answer').style.maxHeight = null;
                });

                // Mở tab hiện tại nếu chưa active
                if (!isActive) {
                    item.classList.add('active');
                    answer.style.maxHeight = answer.scrollHeight + "px";
                }
            });
        });
    });
</script>
@endsection