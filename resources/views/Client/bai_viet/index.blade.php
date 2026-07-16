@extends('layouts.app')

@section('content')
<<<<<<< HEAD
    <div class="container py-5">

        <div class="row">

            <!-- Sidebar trái -->
            <div class="col-lg-3">

                <!-- Danh mục -->
                <div class="card shadow-sm border-0 mb-4 p-2">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="fw-bold mb-0 text-dark">
                            Danh mục
                        </h5>
                    </div>

                    <div class="list-group list-group-flush mt-3">
                        <a href="#" class="list-group-item list-group-item-action active-category">
                            🌍 <span class="ms-2">Điểm đến</span>
                        </a>

                        <a href="#" class="list-group-item list-group-item-action">
                            🎒 <span class="ms-2">Kinh nghiệm</span>
                        </a>

                        <a href="#" class="list-group-item list-group-item-action">
                            🍜 <span class="ms-2">Ẩm thực</span>
                        </a>

                        <a href="#" class="list-group-item list-group-item-action">
                            📷 <span class="ms-2">Check-in</span>
                        </a>
                    </div>
                </div>

                <!-- Bài viết nổi bật -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="fw-bold mb-0 text-dark">
                            Bài nổi bật
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="mb-3 highlight-item pb-2 border-bottom">
                            <a href="#" class="text-decoration-none text-dark fw-semibold small">
                                Top 10 địa điểm đẹp nhất Việt Nam
                            </a>
=======
<div class="client-news-page">

    <section class="news-top">
        <div class="news-wrap">
            <div class="news-top-content">
                <div>
                    <span class="news-label">
                        <i class="fa-regular fa-newspaper"></i>
                        Tin tức & kinh nghiệm
                    </span>

                    <h1>Cẩm nang du lịch Travelloula</h1>

                    <p>
                        Tổng hợp những kinh nghiệm chọn tour, đặt tour, chuẩn bị hành lý,
                        chọn khách sạn và các lưu ý cần thiết trước mỗi chuyến đi.
                    </p>
                </div>

                <div class="news-summary">
                    <strong>{{ $baiViets->total() }}</strong>
                    <span>Bài viết đang hiển thị</span>
                </div>
            </div>
        </div>
    </section>

    <section class="news-wrap news-main">
        @if($baiViets->count())
            @php
                $featured = $baiViets->first();
                $posts = $baiViets->skip(1);
            @endphp

            <div class="featured-row">
                <a href="{{ route('Client.bai_viet.detail', $featured->duong_dan) }}" class="featured-visual">
                    @if($featured->anh_dai_dien)
                        <img src="{{ asset('storage/' . $featured->anh_dai_dien) }}" alt="{{ $featured->tieu_de }}">
                    @else
                        <div class="visual-fallback">
                            <i class="fa-solid fa-earth-asia"></i>
                            <span>Travelloula Blog</span>
>>>>>>> cc44b2b52f455ff96a954607e13f26b5705908f2
                        </div>
                    @endif
                </a>

<<<<<<< HEAD
                        <div class="mb-3 highlight-item pb-2 border-bottom">
                            <a href="#" class="text-decoration-none text-dark fw-semibold small">
                                Checklist hành lý du lịch cần thiết
                            </a>
                        </div>

                        <div class="highlight-item">
                            <a href="#" class="text-decoration-none text-dark fw-semibold small">
                                Mẹo săn vé máy bay giá rẻ từ A-Z
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Form đăng ký nhận tin (Newsletter) -->
                <div class="card newsletter-card text-white border-0 p-4 mb-4 shadow-sm">
                    <h5 class="fw-bold mb-2">Đăng ký nhận tin ✉️</h5>
                    <p class="small text-white-50 mb-3">Nhận cẩm nang du lịch mới nhất hàng tuần hoàn toàn miễn phí.</p>
                    <div class="input-group">
                        <input type="email" class="form-control border-0 rounded-start-pill ps-3"
                            placeholder="Email của bạn...">
                        <button class="btn btn-dark rounded-end-pill px-3 fw-bold" type="button">Gửi</button>
                    </div>
                </div>

            </div>

            <!-- Khối nội dung chính bên phải -->
            <div class="col-lg-9">

                <div class="row g-4">

                    @for ($i = 1; $i <= 6; $i++)
                        <div class="col-md-6">

                            <!-- Đã thêm class post-card ở đây để kích hoạt CSS của bạn -->
                            <div class="card border-0 shadow-sm h-100 post-card">
                                <div class="overflow-hidden">
                                    <img src="https://picsum.photos/500/300?random={{ $i }}"
                                        class="card-img-top card-img-hover" alt="Travel Image">
                                </div>

                                <div class="card-body d-flex flex-column justify-content-between p-4">
                                    <div>
                                        <h5 class="fw-bold text-dark mb-2 line-clamp-2">
                                            Top địa điểm du lịch không thể bỏ lỡ 2026
                                        </h5>
                                        <p class="text-muted small mb-4 line-clamp-3">
                                            Khám phá những địa điểm tuyệt đẹp, những trải nghiệm văn hóa độc đáo đang chờ
                                            đón bước chân bạn trong năm nay...
                                        </p>
                                    </div>

                                    <a href="{{ route('Client.bai_viet.detail', $i) }}"
                                        class="btn btn-outline-primary rounded-pill fw-semibold w-100 py-2">
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endfor
=======
                <div class="featured-info">
                    <span class="featured-tag">Bài viết nổi bật</span>

                    <h2>
                        <a href="{{ route('Client.bai_viet.detail', $featured->duong_dan) }}">
                            {{ $featured->tieu_de }}
                        </a>
                    </h2>

                    @if($featured->mo_ta_ngan)
                        <p>{{ \Illuminate\Support\Str::limit($featured->mo_ta_ngan, 260) }}</p>
                    @endif

                    <div class="meta-line">
                        <span>
                            <i class="fa-regular fa-user"></i>
                            {{ $featured->tac_gia ?? 'Admin' }}
                        </span>

                        <span>
                            <i class="fa-regular fa-calendar"></i>
                            {{ $featured->created_at?->format('d/m/Y') }}
                        </span>

                        <span>
                            <i class="fa-regular fa-eye"></i>
                            {{ number_format($featured->luot_xem ?? 0) }} lượt xem
                        </span>
                    </div>

                    <a href="{{ route('Client.bai_viet.detail', $featured->duong_dan) }}" class="read-main">
                        Đọc bài viết
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="section-title">
                <h2>Bài viết mới nhất</h2>
                <p>Các nội dung được cập nhật gần đây</p>
            </div>

            <div class="post-grid">
                @foreach($posts as $baiViet)
                    <article class="post-card">
                        <a href="{{ route('Client.bai_viet.detail', $baiViet->duong_dan) }}" class="post-visual">
                            @if($baiViet->anh_dai_dien)
                                <img src="{{ asset('storage/' . $baiViet->anh_dai_dien) }}" alt="{{ $baiViet->tieu_de }}">
                            @else
                                <div class="post-fallback">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                </div>
                            @endif
                        </a>

                        <div class="post-content">
                            <div class="post-date">
                                <span>{{ $baiViet->created_at?->format('d/m/Y') }}</span>
                                <span>{{ number_format($baiViet->luot_xem ?? 0) }} lượt xem</span>
                            </div>

                            <h3>
                                <a href="{{ route('Client.bai_viet.detail', $baiViet->duong_dan) }}">
                                    {{ $baiViet->tieu_de }}
                                </a>
                            </h3>

                            @if($baiViet->mo_ta_ngan)
                                <p>{{ \Illuminate\Support\Str::limit($baiViet->mo_ta_ngan, 150) }}</p>
                            @endif

                            <a href="{{ route('Client.bai_viet.detail', $baiViet->duong_dan) }}" class="read-more">
                                Xem chi tiết
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
>>>>>>> cc44b2b52f455ff96a954607e13f26b5705908f2

            @if($baiViets->hasPages())
                <div class="pagination-wrap">
                    {{ $baiViets->links() }}
                </div>
<<<<<<< HEAD

                <!-- Thanh phân trang (Pagination) hiện đại -->
                <div class="d-flex justify-content-center mt-5">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-custom mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                    <i class="bi bi-chevron-left"></i> Trước
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Sau <i class="bi bi-chevron-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>

            </div>

        </div>

    </div>
=======
            @endif
        @else
            <div class="empty-box">
                <i class="fa-regular fa-newspaper"></i>
                <h3>Chưa có bài viết nào</h3>
                <p>Các bài viết sẽ được cập nhật trong thời gian tới.</p>
            </div>
        @endif
    </section>
>>>>>>> cc44b2b52f455ff96a954607e13f26b5705908f2

    <style>
        /* Cấu trúc nền tảng */
        body {
            background: #f4f6fa;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

<<<<<<< HEAD
        .card {
            border-radius: 20px;
        }

        /* Tối ưu Sidebar hiệu ứng mượt mà */
        .list-group-item {
            border: none !important;
            border-radius: 12px !important;
            margin-bottom: 6px;
            padding: 12px 16px;
            color: #495057;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .list-group-item-action:hover {
            background-color: #eef2ff !important;
            color: #0d6efd;
            transform: translateX(5px);
        }

        .active-category {
            background-color: #0d6efd !important;
            color: white !important;
        }

        .highlight-item a {
            transition: color 0.2s ease;
        }

        .highlight-item a:hover {
            color: #0d6efd !important;
        }

        /* Sửa và tối ưu Post-Card theo CSS gốc của bạn */
        .post-card {
            border-radius: 20px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .post-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(13, 110, 253, 0.08) !important;
        }

        .post-card img {
            height: 220px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .post-card:hover .card-img-hover {
            transform: scale(1.05);
            /* Hiệu ứng zoom nhẹ ảnh khi di chuột vào card */
        }

        /* Khối nhận bản tin lung linh hơn */
        .newsletter-card {
            border-radius: 20px;
            background: linear-gradient(135deg, #0d6efd 0%, #00c6ff 100%);
        }

        .newsletter-card .form-control:focus {
            box-shadow: none;
        }

        /* Giới hạn số dòng tiêu đề/mô tả tránh vỡ Layout */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Custom Phân trang (Pagination) mềm mại */
        .pagination-custom .page-link {
            color: #495057;
            border: none;
            background: #fff;
            margin: 0 4px;
            border-radius: 10px !important;
            padding: 10px 18px;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }

        .pagination-custom .page-link:hover {
            background: #eef2ff;
            color: #0d6efd;
        }

        .pagination-custom .page-item.active .page-link {
            background: #0d6efd;
            color: #fff;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
        }

        .pagination-custom .page-item.disabled .page-link {
            background: #e9ecef;
            color: #adb5bd;
            box-shadow: none;
        }
    </style>
@endsection
=======
<style>
.client-news-page{
    background:#f3f6fb;
    min-height:100vh;
}

.news-wrap{
    width:100%;
    max-width:1500px;
    margin:0 auto;
    padding-left:40px;
    padding-right:40px;
}

.news-top{
    position:relative;
    background:
        linear-gradient(90deg, rgba(7,19,49,.86), rgba(21,94,239,.56)),
        url("{{ asset('images/blog-banner.jpg') }}");
    background-size:cover;
    background-position:center;
    border-bottom:1px solid #dbe7f5;
}

.news-top::after{
    content:"";
    position:absolute;
    inset:0;
    background:radial-gradient(circle at 80% 20%, rgba(255,255,255,.18), transparent 35%);
    pointer-events:none;
}

.news-top-content{
    position:relative;
    z-index:2;
    min-height:330px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:36px;
}

.news-label{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:9px 15px;
    border-radius:999px;
    background:rgba(255,255,255,.16);
    border:1px solid rgba(255,255,255,.35);
    color:#ffffff;
    font-size:14px;
    font-weight:900;
    margin-bottom:18px;
    backdrop-filter:blur(8px);
}

.news-top h1{
    margin:0;
    color:#ffffff;
    font-size:52px;
    line-height:1.08;
    font-weight:1000;
    letter-spacing:-1.4px;
    text-shadow:0 12px 30px rgba(0,0,0,.25);
}

.news-top p{
    max-width:820px;
    margin:18px 0 0;
    color:#eaf2ff;
    font-size:18px;
    line-height:1.8;
    font-weight:650;
}

.news-summary{
    min-width:210px;
    padding:28px;
    border-radius:28px;
    background:rgba(7,19,49,.86);
    color:#fff;
    box-shadow:0 24px 55px rgba(0,0,0,.22);
    text-align:center;
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,.16);
}

.news-summary strong{
    display:block;
    font-size:52px;
    line-height:1;
    font-weight:1000;
    color:#60a5fa;
}

.news-summary span{
    display:block;
    margin-top:8px;
    font-size:15px;
    line-height:1.5;
    font-weight:800;
}

.news-main{
    padding-top:38px;
    padding-bottom:80px;
}

.featured-row{
    display:grid;
    grid-template-columns:46% 54%;
    overflow:hidden;
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:30px;
    box-shadow:0 24px 70px rgba(15,23,42,.10);
    margin-bottom:36px;
}

.featured-visual{
    display:block;
    min-height:420px;
    background:#dbeafe;
    overflow:hidden;
}

.featured-visual img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}

.visual-fallback{
    width:100%;
    height:100%;
    min-height:420px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:12px;
    background:
        radial-gradient(circle at 20% 20%, rgba(21,94,239,.24), transparent 34%),
        linear-gradient(135deg,#dbeafe,#f8fbff);
    color:#155eef;
}

.visual-fallback i{
    font-size:74px;
}

.visual-fallback span{
    color:#071331;
    font-size:24px;
    font-weight:1000;
}

.featured-info{
    padding:46px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.featured-tag{
    width:max-content;
    padding:8px 14px;
    border-radius:999px;
    background:#fff7ed;
    color:#ea580c;
    font-size:13px;
    font-weight:1000;
    margin-bottom:18px;
}

.featured-info h2{
    margin:0;
    color:#071331;
    font-size:38px;
    line-height:1.2;
    font-weight:1000;
    letter-spacing:-1px;
}

.featured-info h2 a,
.post-content h3 a{
    color:inherit;
    text-decoration:none;
}

.featured-info h2 a:hover,
.post-content h3 a:hover{
    color:#155eef;
}

.featured-info p{
    margin:18px 0 0;
    color:#52637a;
    font-size:16px;
    line-height:1.85;
    font-weight:600;
}

.meta-line{
    display:flex;
    flex-wrap:wrap;
    gap:14px;
    margin-top:22px;
}

.meta-line span{
    display:inline-flex;
    align-items:center;
    gap:7px;
    color:#64748b;
    font-size:14px;
    font-weight:800;
}

.meta-line i{
    color:#155eef;
}

.read-main{
    width:max-content;
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-top:28px;
    min-height:46px;
    padding:0 20px;
    border-radius:999px;
    background:#155eef;
    color:#fff;
    text-decoration:none;
    font-weight:1000;
    box-shadow:0 16px 32px rgba(21,94,239,.24);
}

.read-main:hover{
    color:#fff;
    background:#0f4fd1;
}

.section-title{
    margin:36px 0 22px;
}

.section-title h2{
    margin:0;
    color:#071331;
    font-size:34px;
    font-weight:1000;
    letter-spacing:-.7px;
}

.section-title p{
    margin:6px 0 0;
    color:#64748b;
    font-size:15px;
    font-weight:700;
}

.post-grid{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:22px;
}

.post-card{
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:24px;
    overflow:hidden;
    box-shadow:0 16px 42px rgba(15,23,42,.075);
    transition:.25s ease;
}

.post-card:hover{
    transform:translateY(-5px);
    box-shadow:0 24px 60px rgba(15,23,42,.12);
}

.post-visual{
    display:block;
    height:165px;
    background:#eaf2ff;
    overflow:hidden;
}

.post-visual img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}

.post-fallback{
    width:100%;
    height:100%;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,#eaf2ff,#f8fbff);
    color:#155eef;
    font-size:42px;
}

.post-content{
    padding:20px;
}

.post-date{
    display:flex;
    justify-content:space-between;
    gap:10px;
    color:#64748b;
    font-size:12px;
    font-weight:800;
    margin-bottom:12px;
}

.post-content h3{
    margin:0;
    color:#071331;
    font-size:18px;
    line-height:1.4;
    font-weight:1000;
}

.post-content p{
    margin:10px 0 0;
    color:#64748b;
    font-size:14px;
    line-height:1.65;
    font-weight:600;
}

.read-more{
    display:inline-flex;
    margin-top:15px;
    color:#155eef;
    text-decoration:none;
    font-size:14px;
    font-weight:1000;
}

.pagination-wrap{
    display:flex;
    justify-content:center;
    margin-top:36px;
}

.empty-box{
    padding:70px 24px;
    background:#fff;
    border-radius:26px;
    border:1px solid #e2e8f0;
    text-align:center;
}

.empty-box i{
    font-size:46px;
    color:#155eef;
    margin-bottom:14px;
}

.empty-box h3{
    margin:0 0 8px;
    color:#071331;
    font-size:24px;
    font-weight:1000;
}

.empty-box p{
    margin:0;
    color:#64748b;
}

@media(max-width:1200px){
    .post-grid{
        grid-template-columns:repeat(3,minmax(0,1fr));
    }
}

@media(max-width:980px){
    .news-wrap{
        padding-left:22px;
        padding-right:22px;
    }

    .news-top-content{
        flex-direction:column;
        align-items:flex-start;
        padding-top:45px;
        padding-bottom:45px;
    }

    .featured-row{
        grid-template-columns:1fr;
    }

    .post-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
}

@media(max-width:640px){
    .news-top h1{
        font-size:34px;
    }

    .news-top p{
        font-size:15px;
    }

    .featured-info{
        padding:26px;
    }

    .featured-info h2{
        font-size:27px;
    }

    .post-grid{
        grid-template-columns:1fr;
    }
}
</style>
@endsection
>>>>>>> cc44b2b52f455ff96a954607e13f26b5705908f2
