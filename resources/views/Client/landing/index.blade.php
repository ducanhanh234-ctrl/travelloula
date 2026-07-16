@extends('layouts.app')

@section('title', 'Travelloula | Du lịch chuyên nghiệp')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<style>
    .landing-page {
        padding-bottom: 20px;
    }

    .landing-hero {
        background:
            linear-gradient(90deg, rgba(2, 24, 65, 0.86), rgba(2, 24, 65, 0.55)),
            url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
        border-radius: 26px;
        overflow: hidden;
        box-shadow: 0 18px 45px rgba(15, 23, 42, .16);
        margin: 36px auto 0;
    }

    .hero-inner {
        min-height: 520px;
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 30px;
        align-items: center;
        padding: 56px 54px;
    }

    .hero-copy h1 {
        color: #fff;
        font-size: 46px;
        font-weight: 900;
        line-height: 1.15;
        margin-bottom: 18px;
    }

    .hero-copy p {
        color: #e2e8f0;
        font-size: 18px;
        max-width: 620px;
        margin-bottom: 28px;
    }

    .hero-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 24px;
    }

    .hero-btn {
        min-height: 48px;
        padding: 0 24px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        font-weight: 800;
        transition: .25s;
        text-decoration: none;
    }

    .hero-btn-primary {
        background: linear-gradient(135deg, #0757d8, #0044c7);
        color: #fff;
    }

    .hero-btn-outline {
        color: #fff;
        border: 1px solid rgba(255,255,255,.3);
        background: rgba(255,255,255,.08);
    }

    .hero-highlights {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        color: #f8fafc;
        font-size: 15px;
        font-weight: 650;
    }

    .hero-search {
        background: rgba(255,255,255,.96);
        border-radius: 18px;
        padding: 18px;
        box-shadow: 0 16px 40px rgba(15, 23, 42, .16);
        margin-top: 24px;
    }

    .hero-search form {
        display: grid;
        grid-template-columns: 1.3fr 1fr 160px;
        gap: 12px;
    }

    .hero-search .form-control, .hero-search .form-select {
        min-height: 46px;
        border-radius: 12px;
        border: 1px solid #dbeafe;
    }

    .hero-search .btn {
        min-height: 46px;
        border-radius: 12px;
    }

    .hero-card {
        background: rgba(255,255,255,.96);
        border-radius: 22px;
        padding: 24px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, .18);
    }

    .hero-card h3 {
        font-size: 22px;
        margin-bottom: 10px;
        color: #0f172a;
    }

    .hero-card p {
        color: #475569;
        margin-bottom: 18px;
    }

    .hero-card .stat {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-top: 1px solid #e2e8f0;
        color: #0f172a;
        font-weight: 700;
    }

    .home-section {
        padding: 72px 0 0;
    }

    .section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 26px;
    }

    .section-head h2 {
        font-size: 30px;
        font-weight: 900;
        padding-left: 16px;
        border-left: 5px solid #0757d8;
    }

    .section-head a {
        color: #0f172a;
        font-weight: 700;
    }

    .about-grid,
    .feature-grid,
    .tour-grid,
    .process-grid,
    .review-grid,
    .stat-grid {
        display: grid;
        gap: 24px;
    }

    .about-grid {
        grid-template-columns: 1.1fr .9fr;
        align-items: center;
    }

    .about-card,
    .feature-card,
    .tour-card,
    .process-card,
    .review-card,
    .stat-card,
    .faq-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 16px 40px rgba(15, 23, 42, .08);
        border: 1px solid #e2e8f0;
    }

    .about-card {
        padding: 28px;
    }

    .about-card p {
        color: #475569;
        margin-bottom: 14px;
        line-height: 1.8;
    }

    .about-list {
        display: grid;
        gap: 12px;
        margin-top: 16px;
    }

    .about-list div {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #0f172a;
        font-weight: 700;
    }

    .feature-grid {
        grid-template-columns: repeat(3, 1fr);
    }

    .feature-card {
        padding: 24px;
    }

    .feature-icon {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        display: grid;
        place-items: center;
        background: #eff6ff;
        color: #0757d8;
        font-size: 22px;
        margin-bottom: 16px;
    }

    .feature-card h3 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .feature-card p {
        color: #64748b;
        margin-bottom: 0;
    }

    .tour-grid {
        grid-template-columns: repeat(4, 1fr);
    }

    .tour-card { overflow: hidden; }

    .tour-card img {
        width: 100%;
        height: 190px;
        object-fit: cover;
    }

    .tour-body {
        padding: 20px;
    }

    .tour-badge {
        display: inline-block;
        background: #fef3c7;
        color: #92400e;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .tour-body h3 {
        font-size: 18px;
        margin-bottom: 8px;
    }

    .tour-meta,
    .tour-price,
    .tour-extra {
        color: #475569;
        font-size: 14px;
    }

    .tour-price {
        color: #0757d8;
        font-weight: 800;
        margin-top: 10px;
    }

    .tour-original {
        text-decoration: line-through;
        color: #94a3b8;
        font-size: 13px;
        display: block;
        margin-top: 4px;
    }

    .process-grid {
        grid-template-columns: repeat(4, 1fr);
    }

    .process-card {
        padding: 24px;
    }

    .process-step {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #eff6ff;
        color: #0757d8;
        display: grid;
        place-items: center;
        font-weight: 900;
        margin-bottom: 16px;
    }

    .process-card p {
        color: #64748b;
        margin-bottom: 0;
    }

    .review-grid {
        grid-template-columns: repeat(3, 1fr);
    }

    .review-card {
        padding: 24px;
    }

    .review-card .stars {
        color: #f59e0b;
        margin-bottom: 12px;
    }

    .review-card p {
        color: #475569;
        margin-bottom: 18px;
    }

    .review-card strong {
        display: block;
        color: #0f172a;
    }

    .review-card span {
        color: #64748b;
        font-size: 14px;
    }

    .stat-grid {
        grid-template-columns: repeat(4, 1fr);
    }

    .stat-card {
        padding: 24px;
        text-align: center;
    }

    .stat-card h3 {
        font-size: 28px;
        color: #0757d8;
        margin-bottom: 8px;
    }

    .faq-list {
        display: grid;
        gap: 14px;
    }

    .faq-card {
        padding: 20px 24px;
    }

    .faq-card h3 {
        font-size: 17px;
        margin-bottom: 8px;
    }

    .faq-card p {
        color: #64748b;
        margin-bottom: 0;
    }

    .cta-box {
        background: linear-gradient(135deg, #0757d8, #0044c7);
        color: #fff;
        border-radius: 24px;
        padding: 42px 36px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        box-shadow: 0 20px 45px rgba(2, 24, 65, .18);
    }

    .cta-box a {
        background: #fff;
        color: #0757d8;
        min-height: 48px;
        padding: 0 22px;
        border-radius: 999px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        white-space: nowrap;
        text-decoration: none;
    }

    .reveal {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity .6s ease, transform .6s ease;
    }

    .reveal.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    @media(max-width:1100px) {
        .hero-inner {
            grid-template-columns: 1fr;
        }

        .hero-search form {
            grid-template-columns: 1fr 1fr;
        }

        .hero-search .btn {
            grid-column: 1 / -1;
        }

        .tour-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .process-grid,
        .stat-grid,
        .feature-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media(max-width:760px) {
        .landing-hero {
            margin-top: 18px;
        }

        .hero-inner {
            padding: 34px 24px;
            min-height: auto;
        }

        .hero-copy h1 {
            font-size: 32px;
        }

        .hero-search form {
            grid-template-columns: 1fr;
        }

        .about-grid,
        .tour-grid,
        .process-grid,
        .review-grid,
        .stat-grid,
        .feature-grid {
            grid-template-columns: 1fr;
        }

        .cta-box {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<div class="landing-page client-container">
    <section class="landing-hero reveal">
        <div class="hero-inner">
            <div class="hero-copy">
                <div class="hero-actions">
                    <a href="{{ route('Client.danh_sach_tour.index') }}" class="hero-btn hero-btn-primary">Khám phá tour</a>
                    <a href="#about" class="hero-btn hero-btn-outline">Tìm hiểu thêm</a>
                </div>
                <h1>Đặt chuyến đi tiếp theo của bạn cùng Travelloula.</h1>
                <p>Chúng tôi mang đến những hành trình du lịch chuyên nghiệp, dễ dàng đặt lịch và luôn giữ chất lượng trải nghiệm ở mức cao nhất.</p>
                <div class="hero-highlights">
                    <span><i class="fa-solid fa-check"></i> Hỗ trợ 24/7</span>
                    <span><i class="fa-solid fa-check"></i> Giá minh bạch</span>
                    <span><i class="fa-solid fa-check"></i> Tour đa dạng</span>
                </div>

                <div class="hero-search">
                    <form action="{{ route('Client.danh_sach_tour.index') }}" method="GET">
                        <div>
                            <label class="form-label small text-muted mb-1">Điểm đến</label>
                            <input type="text" class="form-control" name="keyword" placeholder="Ví dụ: Đà Nẵng, Nhật Bản">
                        </div>
                        <div>
                            <label class="form-label small text-muted mb-1">Ngày khởi hành</label>
                            <input type="date" class="form-control" name="ngay_khoi_hanh">
                        </div>
                        <button class="btn btn-primary" type="submit">Tìm tour</button>
                    </form>
                </div>
            </div>
            {{-- <div class="hero-card">
                <h3>Điểm nổi bật trong tháng</h3>
                <p>Những chuyến đi được khách hàng yêu thích nhất với mức đánh giá cao và dịch vụ tận tâm.</p>
                <div class="stat"><span>Đánh giá khách hàng</span><strong>4.9/5</strong></div>
                <div class="stat"><span>Tour mới</span><strong>24 chương trình</strong></div>
                <div class="stat"><span>Hỗ trợ nhanh</span><strong>Trong 15 phút</strong></div>
            </div> --}}
        </div>
    </section>

    <section id="about" class="home-section reveal">
        <div class="section-head">
            <h2>Về Travelloula</h2>
        </div>
        <div class="about-grid">
            <div class="about-card">
                <p>Travelloula là đơn vị cung cấp dịch vụ du lịch chuyên nghiệp với tư duy hiện đại, quy trình rõ ràng và đội ngũ hỗ trợ tận tâm. Chúng tôi luôn tập trung vào trải nghiệm khách hàng để mỗi chuyến đi trở nên thư giãn, đáng nhớ và an toàn.</p>
                <p>Từ các tour trong nước đến những hành trình quốc tế, tất cả đều được chuẩn bị kỹ lưỡng về lộ trình, điểm đến, phương tiện và dịch vụ đi kèm.</p>
            </div>
            <div class="about-card">
                <div class="about-list">
                    <div><i class="fa-solid fa-circle-check"></i> Chuyên gia tư vấn tận tâm</div>
                    <div><i class="fa-solid fa-circle-check"></i> Lịch trình rõ ràng, minh bạch</div>
                    <div><i class="fa-solid fa-circle-check"></i> Dịch vụ khách hàng chuyên nghiệp</div>
                    <div><i class="fa-solid fa-circle-check"></i> Nhiều lựa chọn tour phù hợp</div>
                </div>
            </div>
        </div>
    </section>

    <section class="home-section reveal">
        <div class="section-head">
            <h2>Điểm nổi bật</h2>
        </div>
        <div class="feature-grid">
            @foreach($highlights as $item)
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa-solid {{ $item['icon'] }}"></i></div>
                    <h3>{{ $item['title'] }}</h3>
                    <p>{{ $item['text'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section id="tours" class="home-section reveal">
        <div class="section-head">
            <h2>Tour nổi bật</h2>
            <a href="{{ route('Client.danh_sach_tour.index') }}">Xem tất cả <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="tour-grid">
            @foreach($tourCards as $tour)
                <div class="tour-card">
                    <img src="{{ $tour['image'] }}" alt="{{ $tour['title'] }}">
                    <div class="tour-body">
                        <span class="tour-badge">{{ $tour['tag'] }}</span>
                        <h3>{{ $tour['title'] }}</h3>
                        <p class="tour-meta"><i class="fa-solid fa-location-dot"></i> {{ $tour['location'] }}</p>
                        <p class="tour-extra"><i class="fa-solid fa-clock"></i> {{ $tour['duration'] }}</p>
                        <p class="tour-extra"><i class="fa-solid fa-calendar-days"></i> Khởi hành: {{ $tour['departure'] }}</p>
                        <p class="tour-price">{{ $tour['price'] }}</p>
                        <span class="tour-original">{{ $tour['original_price'] }}</span>
                        <a href="{{ route('Client.danh_sach_tour.show', ['id' => $tour['id']]) }}" class="btn btn-outline-primary btn-sm mt-3">Xem chi tiết</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="home-section reveal">
        <div class="section-head">
            <h2>Vì sao chọn chúng tôi</h2>
        </div>
        <div class="feature-grid">
            @foreach($reasons as $reason)
                <div class="feature-card">
                    <div class="feature-icon"><i class="fa-solid {{ $reason['icon'] }}"></i></div>
                    <h3>{{ $reason['title'] }}</h3>
                    <p>{{ $reason['text'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="home-section reveal">
        <div class="section-head">
            <h2>Quy trình đặt tour</h2>
        </div>
        <div class="process-grid">
            @foreach($steps as $index => $step)
                <div class="process-card">
                    <div class="process-step">0{{ $index + 1 }}</div>
                    <h3>{{ $step['title'] }}</h3>
                    <p>{{ $step['text'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="home-section reveal">
        <div class="section-head">
            <h2>Đánh giá khách hàng</h2>
        </div>
        <div id="reviewCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($reviewGroups as $index => $group)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <div class="row g-4">
                            @foreach($group as $review)
                                <div class="col-md-4">
                                    <div class="review-card h-100">
                                        <div class="stars">
                                            @for($i = 0; $i < $review['stars']; $i++)
                                                <i class="fa-solid fa-star"></i>
                                            @endfor
                                        </div>
                                        <p>“{{ $review['quote'] }}”</p>
                                        <strong>{{ $review['name'] }}</strong>
                                        <span>{{ $review['role'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#reviewCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#reviewCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section class="home-section reveal">
        <div class="stat-grid">
            @foreach($stats as $stat)
                <div class="stat-card">
                    <h3>{{ $stat['number'] }}</h3>
                    <p>{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="home-section reveal">
        <div class="section-head">
            <h2>FAQ</h2>
        </div>
        <div class="accordion" id="faqAccordion">
            @foreach($faqs as $index => $faq)
                <div class="accordion-item faq-card mb-3">
                    <h2 class="accordion-header" id="faqHeading{{ $index }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $index }}" aria-expanded="false" aria-controls="faqCollapse{{ $index }}">
                            {{ $faq['question'] }}
                        </button>
                    </h2>
                    <div id="faqCollapse{{ $index }}" class="accordion-collapse collapse" aria-labelledby="faqHeading{{ $index }}" data-bs-parent="#faqAccordion">
                        <div class="accordion-body text-muted">
                            {{ $faq['answer'] }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="home-section reveal">
        <div class="cta-box">
            <div>
                <h3 style="font-size: 24px; margin-bottom: 8px;">Sẵn sàng bắt đầu hành trình mới?</h3>
                <p style="margin-bottom: 0; color: #dbeafe;">Để lại thông tin và để Travelloula đồng hành cùng bạn trong chuyến đi sắp tới.</p>
            </div>
            <a href="{{ route('Client.danh_sach_tour.index') }}">Đặt tour ngay</a>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
            }
        });
    }, { threshold: 0.12 });

    document.querySelectorAll('.reveal').forEach((item) => observer.observe(item));
</script>
@endsection
