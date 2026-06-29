@extends('layouts.app')

@section('title', 'Trang chủ - Travelloula')

@section('content')

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Segoe UI',Arial,sans-serif;
    background:#f8fbff;
    color:#0f172a;
}

a{
    text-decoration:none;
}

.home-container{
    width:min(1380px,calc(100% - 56px));
    margin:0 auto;
}

/* HERO */

.home-hero{
    min-height:560px;
    background:
        linear-gradient(90deg,rgba(0,43,104,.68),rgba(0,0,0,.05)),
        url('https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
    display:flex;
    align-items:center;
    position:relative;
}

.hero-content{
    width:min(1380px,calc(100% - 56px));
    margin:0 auto;
    color:#fff;
}

.hero-content h1{
    font-size:56px;
    font-weight:900;
    line-height:1.1;
}

.hero-content h2{
    font-size:48px;
    color:#ffd629;
    font-weight:900;
    font-style:italic;
    margin:8px 0 16px;
}

.hero-content h2 i{
    color:#fff;
    margin-left:20px;
    font-size:34px;
}

.hero-content p{
    font-size:20px;
    margin-bottom:34px;
    font-weight:500;
}

.search-box{
    background:#fff;
    color:#0f172a;
    border-radius:16px;
    display:grid;
    grid-template-columns:1.2fr 1fr 1fr 1fr 220px;
    align-items:center;
    box-shadow:0 20px 45px rgba(15,23,42,.22);
    overflow:hidden;
}

.search-item{
    padding:24px 30px;
    display:flex;
    align-items:center;
    gap:16px;
    border-right:1px solid #e5e7eb;
}

.search-item i{
    font-size:22px;
    color:#0757d8;
}

.search-item label{
    display:block;
    font-size:15px;
    font-weight:900;
    margin-bottom:7px;
}

.search-item input{
    width:100%;
    border:0;
    outline:none;
    background:transparent;
    color:#64748b;
    font-size:15px;
    font-weight:600;
}

.search-btn{
    height:64px;
    margin:12px;
    border:0;
    border-radius:12px;
    background:linear-gradient(135deg,#0757d8,#0044c7);
    color:#fff;
    font-size:18px;
    font-weight:900;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:12px;
    cursor:pointer;
    transition:.25s;
}

.search-btn:hover{
    transform:translateY(-2px);
    box-shadow:0 12px 28px rgba(37,99,235,.35);
}

/* STATS */

.stats-wrap{
    position:relative;
    z-index:5;
    margin-top:-72px;
}

.stats-box{
    background:#fff;
    border-radius:18px;
    box-shadow:0 18px 45px rgba(15,23,42,.14);
    display:grid;
    grid-template-columns:repeat(4,1fr);
    padding:30px 38px;
}

.stat-item{
    display:flex;
    align-items:center;
    gap:18px;
    padding:0 34px;
    border-right:1px solid #e5e7eb;
}

.stat-item:last-child{
    border-right:0;
}

.stat-icon{
    width:60px;
    height:60px;
    border-radius:18px;
    background:#eff6ff;
    color:#0757d8;
    display:grid;
    place-items:center;
    font-size:26px;
}

.stat-item h3{
    color:#0757d8;
    font-size:30px;
    font-weight:900;
}

.stat-item p{
    color:#334155;
}

/* SECTION */

.home-section{
    padding:70px 0 0;
}

.section-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:24px;
}

.section-head h2{
    font-size:30px;
    font-weight:900;
    padding-left:18px;
    border-left:5px solid #0757d8;
}

.section-head a{
    color:#0f172a;
    font-weight:700;
}

/* TOURS */

.tour-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:28px;
}

.tour-card{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 18px 45px rgba(15,23,42,.10);
    transition:.3s;
}

.tour-card:hover{
    transform:translateY(-8px);
}

.tour-img{
    position:relative;
    height:190px;
    overflow:hidden;
}

.tour-img img{
    width:100%;
    height:100%;
    object-fit:cover;
    transition:.4s;
}

.tour-card:hover .tour-img img{
    transform:scale(1.08);
}

.discount{
    position:absolute;
    top:14px;
    left:14px;
    background:#ffd629;
    color:#0f172a;
    padding:7px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:900;
}

.heart{
    position:absolute;
    top:13px;
    right:13px;
    width:36px;
    height:36px;
    border-radius:50%;
    border:0;
    background:#fff;
    color:#0757d8;
    cursor:pointer;
}

.tour-body{
    padding:20px;
}

.tour-body h3{
    font-size:18px;
    margin-bottom:8px;
    line-height:1.35;
    min-height:48px;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

.rating{
    color:#475569;
    font-size:13px;
    margin-bottom:12px;
}

.rating i{
    color:#f59e0b;
}

.tour-meta{
    display:flex;
    flex-wrap:wrap;
    gap:12px;
    font-size:12px;
    color:#64748b;
    margin-bottom:18px;
}

.tour-bottom{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
}

.tour-bottom strong{
    color:#ff4d1f;
    font-size:21px;
    font-weight:900;
}

.tour-actions{
    display:flex;
    align-items:center;
    gap:8px;
    flex-wrap:wrap;
}

.tour-actions a{
    border-radius:9px;
    padding:9px 12px;
    font-size:13px;
    font-weight:900;
    transition:.25s;
    white-space:nowrap;
}

.detail-btn{
    border:1.5px solid #0757d8;
    color:#0757d8;
    background:#fff;
}

.detail-btn:hover{
    background:#eff6ff;
    color:#0757d8;
}

.book-now-btn{
    border:1.5px solid #0757d8;
    background:#0757d8;
    color:#fff;
}

.book-now-btn:hover{
    background:#0044c7;
    color:#fff;
}

/* DESTINATIONS */

.destination-grid{
    display:grid;
    grid-template-columns:repeat(6,1fr);
    gap:18px;
}

.destination-card{
    height:82px;
    border-radius:14px;
    overflow:hidden;
    position:relative;
    box-shadow:0 10px 24px rgba(15,23,42,.08);
    display:block;
}

.destination-card img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.destination-card::after{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(90deg,rgba(0,0,0,.45),rgba(0,0,0,.08));
}

.destination-card h3{
    position:absolute;
    left:16px;
    bottom:14px;
    color:#fff;
    z-index:2;
    font-size:17px;
}

/* PROMO */

.promo-section{
    margin-top:45px;
    background:#eef7ff;
    border-radius:20px;
    padding:28px;
    display:grid;
    grid-template-columns:1.2fr 1fr 1fr 1fr;
    gap:22px;
    align-items:center;
}

.promo-title{
    display:flex;
    align-items:center;
    gap:18px;
}

.promo-title i{
    width:58px;
    height:58px;
    border-radius:16px;
    display:grid;
    place-items:center;
    background:#dbeafe;
    color:#0757d8;
    font-size:28px;
}

.promo-title h3{
    font-size:24px;
    margin-bottom:5px;
}

.coupon,
.countdown{
    background:#fff;
    border-radius:14px;
    padding:18px;
    box-shadow:0 10px 24px rgba(15,23,42,.06);
}

.coupon span{
    color:#64748b;
    font-size:13px;
    font-weight:800;
}

.coupon h3{
    color:#0757d8;
    font-size:28px;
    margin:4px 0;
}

.coupon button,
.coupon a{
    border:0;
    background:#0757d8;
    color:#fff;
    padding:8px 12px;
    border-radius:8px;
    font-weight:800;
    margin-left:8px;
    font-size:13px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
}

.coupon button:hover,
.coupon a:hover{
    background:#0044c7;
}

.countdown h4{
    color:#334155;
    margin-bottom:8px;
}

.countdown .time{
    color:#0757d8;
    font-size:24px;
    font-weight:900;
}

/* WHY */

.why-section{
    margin-top:70px;
    background:#fff;
    padding:80px 0;
    text-align:center;
}

.big-title{
    text-align:center;
    font-size:42px;
    font-weight:900;
    margin-bottom:48px;
}

.why-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:28px;
}

.why-card{
    background:#fff;
    padding:36px 24px;
    border-radius:18px;
    box-shadow:0 16px 38px rgba(15,23,42,.08);
}

.why-card i{
    color:#06b6d4;
    font-size:25px;
    margin-bottom:16px;
}

.why-card h3{
    color:#06b6d4;
    margin-bottom:12px;
}

/* REVIEW */

.review-section{
    padding:90px 0;
    background:#eef9ff;
}

.review-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:28px;
}

.review-card{
    background:#fff;
    padding:34px;
    border-radius:18px;
    box-shadow:0 16px 38px rgba(15,23,42,.08);
}

.review-card p{
    line-height:1.7;
    margin-bottom:18px;
}

.review-card h4{
    color:#06b6d4;
}

/* RESPONSIVE */

@media(max-width:1180px){
    .search-box,
    .stats-box,
    .tour-grid,
    .why-grid{
        grid-template-columns:1fr 1fr;
    }

    .search-btn{
        grid-column:1/-1;
    }

    .destination-grid{
        grid-template-columns:repeat(3,1fr);
    }

    .promo-section{
        grid-template-columns:1fr 1fr;
    }
}

@media(max-width:640px){
    .home-container,
    .hero-content{
        width:calc(100% - 28px);
    }

    .hero-content h1{
        font-size:38px;
    }

    .hero-content h2{
        font-size:32px;
    }

    .search-box,
    .stats-box,
    .tour-grid,
    .destination-grid,
    .promo-section,
    .why-grid,
    .review-grid{
        grid-template-columns:1fr;
    }

    .search-item,
    .stat-item{
        border-right:0;
        border-bottom:1px solid #e5e7eb;
    }

    .tour-actions{
        width:100%;
    }

    .tour-actions a{
        flex:1;
        text-align:center;
    }
}
</style>

<main>

<section class="home-hero">
    <div class="hero-content">
        <h1>Khám phá thế giới</h1>
        <h2>Cùng Travelloula <i class="fa-solid fa-plane"></i></h2>
        <p>Những hành trình tuyệt vời đang chờ bạn trải nghiệm!</p>

        <form action="{{ route('Client.danh_sach_tour.index') }}" method="GET" class="search-box">
            <div class="search-item">
                <i class="fa-solid fa-location-dot"></i>
                <div>
                    <label>Điểm đến</label>
                    <input type="text" name="keyword" placeholder="Bạn muốn đi đâu?">
                </div>
            </div>

            <div class="search-item">
                <i class="fa-regular fa-calendar-days"></i>
                <div>
                    <label>Ngày đi</label>
                    <input type="date" name="ngay_khoi_hanh">
                </div>
            </div>

            <div class="search-item">
                <i class="fa-solid fa-car"></i>
                <div>
                    <label>Phương tiện</label>
                    <input type="text" name="phuong_tien" placeholder="Máy bay, ô tô...">
                </div>
            </div>

            <div class="search-item">
                <i class="fa-regular fa-user"></i>
                <div>
                    <label>Số người</label>
                    <input type="number" name="so_nguoi" min="1" value="1">
                </div>
            </div>

            <button type="submit" class="search-btn">
                <i class="fa-solid fa-magnifying-glass"></i>
                Tìm kiếm
            </button>
        </form>
    </div>
</section>

<section class="stats-wrap">
    <div class="home-container">
        <div class="stats-box">
            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-suitcase-rolling"></i></div>
                <div>
                    <h3>{{ number_format($totalTours ?? $tours->count(), 0, ',', '.') }}+</h3>
                    <p>Tour hấp dẫn</p>
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-location-dot"></i></div>
                <div>
                    <h3>{{ number_format($totalDiemDen ?? $diemDens->count(), 0, ',', '.') }}+</h3>
                    <p>Điểm đến nổi bật</p>
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-users"></i></div>
                <div>
                    <h3>{{ number_format($totalKhachHang ?? 0, 0, ',', '.') }}+</h3>
                    <p>Khách hàng đã đặt tour</p>
                </div>
            </div>

            <div class="stat-item">
                <div class="stat-icon"><i class="fa-solid fa-star"></i></div>
                <div>
                    <h3>{{ number_format($avgRating ?? 4.9, 1) }}/5</h3>
                    <p>Đánh giá trung bình</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="home-section">
    <div class="home-container">
        <div class="section-head">
            <h2>Tour nổi bật</h2>
            <a href="{{ route('Client.danh_sach_tour.index') }}">
                Xem tất cả <i class="fa-solid fa-angle-right"></i>
            </a>
        </div>

        <div class="tour-grid">
            @forelse($tours as $tour)
                @php
                    $tourImage = 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80';

                    if (!empty($tour->anh_dai_dien)) {
                        if (\Illuminate\Support\Str::startsWith($tour->anh_dai_dien, ['http://', 'https://'])) {
                            $tourImage = $tour->anh_dai_dien;
                        } else {
                            $tourImage = asset($tour->anh_dai_dien);
                        }
                    }
                @endphp

                <article class="tour-card">
                    <div class="tour-img">
                        <img src="{{ $tourImage }}"
                             alt="{{ $tour->ten_tour }}"
                             onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80';">

                        <span class="discount">
                            {{ $tour->danhMuc->ten_danh_muc ?? 'Tour nổi bật' }}
                        </span>

                        <button class="heart" type="button">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    </div>

                    <div class="tour-body">
                        <h3>{{ $tour->ten_tour }}</h3>

                        <p class="rating">
                            <i class="fa-solid fa-star"></i>
                            {{ number_format($avgRating ?? 4.8, 1) }} đánh giá
                        </p>

                        <div class="tour-meta">
                            <span><i class="fa-regular fa-clock"></i> {{ $tour->thoi_luong ?? 'Đang cập nhật' }}</span>
                            <span><i class="fa-solid fa-location-dot"></i> {{ $tour->diem_den ?? 'Đang cập nhật' }}</span>
                            <span><i class="fa-solid fa-users"></i> {{ $tour->so_khach_toi_da ?? 0 }} chỗ</span>
                        </div>

                        <div class="tour-bottom">
                            <div>
                                <strong>{{ number_format($tour->gia_tour ?? 0, 0, ',', '.') }}đ</strong>
                            </div>

                            <div class="tour-actions">
                                <a href="{{ route('Client.danh_sach_tour.show', $tour->id) }}" class="detail-btn">
                                    Xem chi tiết
                                </a>

                                <a href="{{ route('Client.danh_sach_tour.show', $tour->id) }}#dat-tour" class="book-now-btn">
                                    Đặt tour
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <p>Chưa có tour nào được hiển thị.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="home-section">
    <div class="home-container">
        <div class="section-head">
            <h2>Điểm đến nổi bật</h2>
            <a href="{{ route('Client.danh_sach_tour.index') }}">
                Xem tất cả <i class="fa-solid fa-angle-right"></i>
            </a>
        </div>

        <div class="destination-grid">
            @forelse($diemDens as $item)
                @php
                    $destinationImage = 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80';

                    if (!empty($item->anh_dai_dien)) {
                        if (\Illuminate\Support\Str::startsWith($item->anh_dai_dien, ['http://', 'https://'])) {
                            $destinationImage = $item->anh_dai_dien;
                        } else {
                            $destinationImage = asset($item->anh_dai_dien);
                        }
                    }
                @endphp

                <a href="{{ route('Client.danh_sach_tour.index', ['keyword' => $item->diem_den]) }}" class="destination-card">
                    <img src="{{ $destinationImage }}"
                         alt="{{ $item->diem_den }}"
                         onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80';">

                    <h3>{{ $item->diem_den }}</h3>
                </a>
            @empty
                <p>Chưa có điểm đến nổi bật.</p>
            @endforelse
        </div>

        <div class="promo-section">
            <div class="promo-title">
                <i class="fa-solid fa-gift"></i>
                <div>
                    <h3>Ưu đãi hấp dẫn</h3>
                    <p>
                        @if(isset($khuyenMais) && $khuyenMais->count())
                            {{ $khuyenMais->count() }} chương trình khuyến mãi đang áp dụng.
                        @else
                            Ưu đãi sẽ được cập nhật trong thời gian tới.
                        @endif
                    </p>
                </div>
            </div>

            @forelse(($khuyenMais ?? collect())->take(2) as $km)
                <div class="coupon">
                    <span>{{ $km->ten_khuyen_mai ?? $km->ten_khuyen_mai ?? 'KHUYẾN MÃI' }}</span>

                    <h3>
                        @php
                            $loaiGiamGia = $km->loai_giam_gia ?? $km->loai ?? '';
                            $giaTriGiam = $km->gia_tri_giam ?? $km->gia_tri ?? 0;
                        @endphp

                        @if($loaiGiamGia === 'percent' || $loaiGiamGia === 'phan_tram')
                            {{ number_format($giaTriGiam, 0, ',', '.') }}%
                        @else
                            {{ number_format($giaTriGiam, 0, ',', '.') }}đ
                        @endif
                    </h3>

                    <p>
                        Mã:
                        <b>{{ $km->ma_khuyen_mai ?? $km->ma_code ?? $km->code ?? 'ĐANG CẬP NHẬT' }}</b>
                        <button type="button">Sao chép</button>
                    </p>
                </div>
            @empty
                <div class="coupon">
                    <span>TOUR GIÁ TỐT</span>
                    <h3>{{ number_format(($tours->min('gia_tour') ?? 0), 0, ',', '.') }}đ</h3>
                    <p>
                        Tour giá tốt nhất hiện có
                        <a href="{{ route('Client.danh_sach_tour.index') }}">Xem ngay</a>
                    </p>
                </div>

                <div class="coupon">
                    <span>TOUR MỚI</span>
                    <h3>{{ $tours->count() }}+</h3>
                    <p>
                        Tour đang mở bán
                        <a href="{{ route('Client.danh_sach_tour.index') }}">Khám phá</a>
                    </p>
                </div>
            @endforelse

            <div class="countdown">
                <h4>Tour đang mở bán</h4>
                <div class="time">{{ $tours->count() }} tour</div>
            </div>
        </div>
    </div>
</section>

<section class="why-section">
    <div class="home-container">
        <h2 class="big-title">Vì Sao Chọn Travelloula?</h2>

        <div class="why-grid">
            <div class="why-card">
                <i class="fa-solid fa-plane"></i>
                <h3>Tour Chất Lượng</h3>
                <p>Lịch trình hấp dẫn và dịch vụ chuyên nghiệp.</p>
            </div>

            <div class="why-card">
                <i class="fa-solid fa-sack-dollar"></i>
                <h3>Giá Tốt</h3>
                <p>Chi phí hợp lý cùng nhiều ưu đãi hấp dẫn.</p>
            </div>

            <div class="why-card">
                <i class="fa-solid fa-shield-heart"></i>
                <h3>An Toàn</h3>
                <p>Đội ngũ hướng dẫn viên giàu kinh nghiệm.</p>
            </div>

            <div class="why-card">
                <i class="fa-solid fa-phone"></i>
                <h3>Hỗ Trợ 24/7</h3>
                <p>Luôn sẵn sàng hỗ trợ khách hàng mọi lúc.</p>
            </div>
        </div>
    </div>
</section>

<section class="review-section">
    <div class="home-container">
        <h2 class="big-title">Khách Hàng Đánh Giá</h2>

        <div class="review-grid">
            <div class="review-card">
                <p>"Tour rất tuyệt vời, dịch vụ chuyên nghiệp."</p>
                <h4>Nguyễn Văn A</h4>
            </div>

            <div class="review-card">
                <p>"Giá tốt, lịch trình hợp lý và hướng dẫn viên nhiệt tình."</p>
                <h4>Trần Thị B</h4>
            </div>

            <div class="review-card">
                <p>"Tôi sẽ tiếp tục đặt tour tại Travelloula."</p>
                <h4>Lê Văn C</h4>
            </div>
        </div>
    </div>
</section>

</main>

@endsection