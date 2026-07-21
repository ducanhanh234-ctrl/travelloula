@extends('layouts.app')

@section('title', 'Danh sách tour - Travelloula')

@section('content')

<section class="tour-page">
    <div class="tour-container">

        {{-- HERO SECTION --}}
        <div class="tour-hero-clean">
            <div class="tour-hero-text">
                <span class="hero-pill">
                    <i class="fa-solid fa-location-arrow"></i>
                    Khám phá hành trình
                </span>

                <h1>Danh sách tour</h1>

                <p>
                    Tìm kiếm và lựa chọn những chuyến đi phù hợp với bạn.
                    Cùng Travelloula khám phá các hành trình hấp dẫn, dịch vụ chất lượng và mức giá tốt.
                </p>

                <div class="hero-stats">
                    <div>
                        <strong>{{ $tours->total() }}</strong>
                        <span>Tour đang mở</span>
                    </div>

                    <div>
                        <strong>{{ $danhMucs->count() }}</strong>
                        <span>Danh mục</span>
                    </div>

                    <div>
                        <strong>24/7</strong>
                        <span>Hỗ trợ khách hàng</span>
                    </div>
                </div>
            </div>

            <div class="tour-hero-photo">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1800&q=80"
                     alt="Du lịch Travelloula">

                <div class="hero-floating-card">
                    <span>Ưu đãi mùa hè</span>
                    <strong>Khám phá biển đảo</strong>
                    <small>Tour nghỉ dưỡng, thiên nhiên và văn hóa Việt Nam</small>
                </div>
            </div>
        </div>

        {{-- CATEGORY QUICK FILTER --}}
        <div class="category-section">
            <div class="category-title">
                <h2>Bạn đang muốn du lịch tới đâu?</h2>

                <a href="{{ route('Client.danh_sach_tour.index') }}">
                    Xem tất cả
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <div class="category-scroll">
                <a href="{{ route('Client.danh_sach_tour.index') }}"
                   class="category-pill {{ request('danh_muc_id') ? '' : 'active' }}">
                    <span class="category-icon all">
                        <i class="fa-solid fa-earth-asia"></i>
                    </span>
                    <strong>Tất cả tour</strong>
                </a>

                @foreach($danhMucs as $dm)
                    <a href="{{ route('Client.danh_sach_tour.index', array_merge(request()->except('page'), ['danh_muc_id' => $dm->id])) }}"
                       class="category-pill {{ request('danh_muc_id') == $dm->id ? 'active' : '' }}">
                        <span class="category-icon">
                            @if(!empty($dm->hinh_anh))
                                @if(\Illuminate\Support\Str::startsWith($dm->hinh_anh, ['http://', 'https://']))
                                    <img src="{{ $dm->hinh_anh }}" alt="{{ $dm->ten_danh_muc }}">
                                @else
                                    <img src="{{ asset($dm->hinh_anh) }}" alt="{{ $dm->ten_danh_muc }}">
                                @endif
                            @else
                                <i class="fa-solid fa-map-location-dot"></i>
                            @endif
                        </span>

                        <strong>{{ $dm->ten_danh_muc }}</strong>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- FILTER --}}
        <form action="{{ route('Client.danh_sach_tour.index') }}" method="GET" class="tour-filter">
            <input type="text"
                   name="keyword"
                   value="{{ request('keyword') }}"
                   placeholder="Tìm tour, điểm đến, nơi khởi hành...">

            <select name="danh_muc_id">
                <option value="">Tất cả danh mục</option>
                @foreach($danhMucs as $dm)
                    <option value="{{ $dm->id }}" {{ request('danh_muc_id') == $dm->id ? 'selected' : '' }}>
                        {{ $dm->ten_danh_muc }}
                    </option>
                @endforeach
            </select>

            <input type="number"
                   name="gia_min"
                   value="{{ request('gia_min') }}"
                   placeholder="Giá từ">

            <input type="number"
                   name="gia_max"
                   value="{{ request('gia_max') }}"
                   placeholder="Giá đến">

            <input type="text"
                   name="phuong_tien"
                   value="{{ request('phuong_tien') }}"
                   placeholder="Phương tiện">

            <input type="date"
                   name="ngay_khoi_hanh"
                   value="{{ request('ngay_khoi_hanh') }}">

            <select name="sort">
                <option value="">Sắp xếp mới nhất</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                    Giá tăng dần
                </option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                    Giá giảm dần
                </option>
            </select>

            <button type="submit">
                <i class="fa-solid fa-magnifying-glass"></i>
                Tìm kiếm
            </button>

            <a href="{{ route('Client.danh_sach_tour.index') }}" class="reset-btn">
                Làm mới
            </a>
        </form>

        {{-- RESULT HEADER --}}
        <div class="tour-result-bar">
            <div class="result-left">
                <span>Kết quả tìm kiếm</span>
                <p>
                    Tìm thấy <strong>{{ $tours->total() }}</strong> tour phù hợp
                </p>
            </div>

            @if(request('keyword') || request('danh_muc_id') || request('gia_min') || request('gia_max') || request('phuong_tien') || request('ngay_khoi_hanh') || request('sort'))
                <a href="{{ route('Client.danh_sach_tour.index') }}" class="clear-filter-btn">
                    <i class="fa-solid fa-rotate-left"></i>
                    Xóa bộ lọc
                </a>
            @endif
        </div>

        @if(session('success'))
            <div class="alert-success-custom">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        @if($tours->count())
            <div class="tour-grid">
                @foreach($tours as $tour)
                    @php
                        $lichGanNhat = $tour->lichKhoiHanhTours
                            ->where('trang_thai', 'available')
                            ->sortBy('ngay_khoi_hanh')
                            ->first();

                        $anhTour = $tour->anh_dai_dien;

                        $srcAnh = 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=900&q=80';

                        if (!empty($anhTour)) {
                            if (\Illuminate\Support\Str::startsWith($anhTour, ['http://', 'https://'])) {
                                $srcAnh = $anhTour;
                            } else {
                                $srcAnh = asset($anhTour);
                            }
                        }

                        $isFavorite = auth()->check()
                            ? in_array($tour->id, $favoriteTourIds ?? [])
                            : false;
                    @endphp

                    <article
                        class="tour-card tour-card-clickable"
                        role="link"
                        tabindex="0"
                        data-detail-url="{{ route('Client.danh_sach_tour.show', $tour->id) }}"
                        aria-label="Xem chi tiết tour {{ $tour->ten_tour }}"
                    >
                        <div class="tour-img">
                            <img src="{{ $srcAnh }}"
                                 alt="{{ $tour->ten_tour }}"
                                 onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=900&q=80';">

                            <span class="tour-badge">
                                {{ $tour->danhMuc->ten_danh_muc ?? 'Tour du lịch' }}
                            </span>

                            @auth
                                @if($isFavorite)
                                    <form action="{{ route('Client.tour_yeu_thich.destroy', $tour->id) }}"
                                          method="POST"
                                          class="favorite-form">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="heart-btn active" title="Bỏ yêu thích">
                                            <i class="fa-solid fa-heart"></i>
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('Client.tour_yeu_thich.store', $tour->id) }}"
                                          method="POST"
                                          class="favorite-form">
                                        @csrf

                                        <button type="submit" class="heart-btn" title="Thêm vào yêu thích">
                                            <i class="fa-regular fa-heart"></i>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="heart-btn" title="Đăng nhập để thêm yêu thích">
                                    <i class="fa-regular fa-heart"></i>
                                </a>
                            @endauth
                        </div>

                        <div class="tour-body">
                            <h3>{{ $tour->ten_tour }}</h3>

                            <div class="tour-info">
                                <span>
                                    <i class="fa-solid fa-location-dot"></i>
                                    {{ $tour->diem_den ?? 'Đang cập nhật' }}
                                </span>

                                <span>
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $tour->thoi_luong ?? 'Đang cập nhật' }}
                                </span>
                            </div>

                            @if($lichGanNhat)
                                <div class="start-date">
                                    <i class="fa-regular fa-calendar-days"></i>
                                    <span>
                                        Khởi hành:
                                        {{ \Carbon\Carbon::parse($lichGanNhat->ngay_khoi_hanh)->format('d/m/Y') }}
                                        - còn {{ $lichGanNhat->so_cho_con_lai }} chỗ
                                    </span>
                                </div>
                            @else
                                <div class="start-date muted">
                                    <i class="fa-regular fa-calendar-days"></i>
                                    <span>Lịch khởi hành đang cập nhật</span>
                                </div>
                            @endif

                            <div class="tour-bottom">
                                <div class="price-box">
                                    <span>Chỉ từ</span>
                                    <strong>{{ number_format($tour->gia_tour ?? 0, 0, ',', '.') }}đ</strong>
                                </div>

                                <div class="tour-actions">
                                    <a href="{{ route('Client.danh_sach_tour.show', $tour->id) }}"
                                       class="detail-btn">
                                        Xem chi tiết
                                    </a>

                                    <a href="{{ route('Client.danh_sach_tour.show', $tour->id) }}#dat-tour"
                                       class="booking-btn">
                                        Đặt tour
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="pagination-wrap">
                {{ $tours->onEachSide(1)->links() }}
            </div>
        @else
            <div class="empty-tour">
                <i class="fa-regular fa-face-sad-tear"></i>
                <h3>Không tìm thấy tour phù hợp</h3>
                <p>Vui lòng thử lại với từ khóa hoặc bộ lọc khác.</p>
                <a href="{{ route('Client.danh_sach_tour.index') }}">
                    Xem tất cả tour
                </a>
            </div>
        @endif

    </div>
</section>

<style>
:root{
    --primary:#0757d8;
    --primary-dark:#0043b8;
    --primary-soft:#eaf2ff;
    --yellow:#ffd629;
    --orange:#ff5a1f;
    --text:#0b1226;
    --muted:#64748b;
    --line:#e2e8f0;
    --white:#ffffff;
    --shadow:0 24px 70px rgba(15,23,42,.10);
    --shadow-hover:0 34px 90px rgba(15,23,42,.16);
}

*{
    box-sizing:border-box;
}

.tour-page{
    min-height:100vh;
    padding:82px 0 90px;
    background:
        radial-gradient(circle at 7% 7%, rgba(7,87,216,.17), transparent 30%),
        radial-gradient(circle at 94% 6%, rgba(255,214,41,.26), transparent 32%),
        linear-gradient(180deg,#f8fbff 0%,#edf5ff 55%,#f8fbff 100%);
}

.tour-container{
    width:min(1760px, calc(100% - 32px));
    margin:0 auto;
}

/* HERO */
.tour-hero-clean{
    max-width:1660px;
    margin:0 auto 34px;
    min-height:390px;
    display:grid;
    grid-template-columns:0.95fr 1.05fr;
    align-items:stretch;
    border-radius:38px;
    overflow:hidden;
    background:rgba(255,255,255,.9);
    border:1px solid rgba(226,232,240,.92);
    box-shadow:0 28px 90px rgba(15,23,42,.12);
}

.tour-hero-text{
    padding:58px 64px;
    display:flex;
    flex-direction:column;
    justify-content:center;
    background:
        radial-gradient(circle at 10% 15%, rgba(7,87,216,.12), transparent 32%),
        linear-gradient(135deg,#ffffff 0%,#f8fbff 100%);
}

.hero-pill{
    width:max-content;
    display:inline-flex;
    align-items:center;
    gap:8px;
    color:var(--primary);
    background:rgba(7,87,216,.10);
    border:1px solid rgba(7,87,216,.22);
    box-shadow:0 8px 22px rgba(7,87,216,.08);
    padding:9px 18px;
    border-radius:999px;
    font-size:14px;
    font-weight:1000;
    margin-bottom:18px;
}

.tour-hero-text h1{
    margin:0;
    color:var(--text);
    font-size:clamp(46px,4.8vw,68px);
    line-height:1.03;
    font-weight:1000;
    letter-spacing:-2.4px;
}

.tour-hero-text p{
    max-width:700px;
    margin:18px 0 0;
    color:#53627a;
    font-size:18px;
    line-height:1.75;
}

.hero-stats{
    display:grid;
    grid-template-columns:repeat(3, minmax(0, 1fr));
    gap:14px;
    margin-top:32px;
}

.hero-stats div{
    padding:16px 18px;
    border-radius:20px;
    background:#fff;
    border:1px solid #e4edf8;
    box-shadow:0 14px 32px rgba(15,23,42,.07);
}

.hero-stats strong{
    display:block;
    color:var(--primary);
    font-size:25px;
    font-weight:1000;
    line-height:1;
    margin-bottom:7px;
}

.hero-stats span{
    color:#64748b;
    font-size:13px;
    font-weight:850;
}

.tour-hero-photo{
    position:relative;
    min-height:390px;
    overflow:hidden;
}

.tour-hero-photo::before{
    content:"";
    position:absolute;
    inset:0;
    z-index:1;
    background:
        linear-gradient(90deg, rgba(255,255,255,.86), rgba(255,255,255,.12) 38%, rgba(7,18,38,.05)),
        linear-gradient(180deg, rgba(7,87,216,.05), rgba(15,23,42,.18));
}

.tour-hero-photo img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
    transform:scale(1.03);
}

.hero-floating-card{
    position:absolute;
    z-index:2;
    left:34px;
    bottom:34px;
    width:min(390px, calc(100% - 68px));
    padding:20px 22px;
    border-radius:24px;
    background:rgba(255,255,255,.92);
    backdrop-filter:blur(12px);
    border:1px solid rgba(255,255,255,.72);
    box-shadow:0 22px 45px rgba(15,23,42,.18);
}

.hero-floating-card span{
    display:inline-flex;
    margin-bottom:8px;
    padding:7px 13px;
    border-radius:999px;
    background:linear-gradient(135deg,#ffe45c,#ffc400);
    color:#0f172a;
    font-size:12px;
    font-weight:1000;
}

.hero-floating-card strong{
    display:block;
    color:#071126;
    font-size:22px;
    font-weight:1000;
    margin-bottom:4px;
}

.hero-floating-card small{
    color:#64748b;
    font-size:13px;
    font-weight:750;
}

/* CATEGORY QUICK FILTER */
.category-section{
    max-width:1660px;
    margin:0 auto 24px;
    padding:4px 0;
}

.category-title{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    margin-bottom:16px;
}

.category-title h2{
    margin:0;
    color:#0f172a;
    font-size:28px;
    font-weight:1000;
    letter-spacing:-.6px;
}

.category-title a{
    color:var(--primary);
    text-decoration:none;
    font-weight:900;
    display:inline-flex;
    align-items:center;
    gap:8px;
}

.category-scroll{
    display:flex;
    align-items:center;
    gap:14px;
    overflow-x:auto;
    padding:4px 2px 12px;
    scrollbar-width:thin;
}

.category-pill{
    flex:0 0 auto;
    height:64px;
    padding:8px 18px 8px 8px;
    border-radius:999px;
    background:#fff;
    border:1px solid #e5eef9;
    box-shadow:0 14px 34px rgba(15,23,42,.08);
    display:flex;
    align-items:center;
    gap:12px;
    color:#0f172a;
    text-decoration:none;
    transition:.25s ease;
}

.category-pill:hover,
.category-pill.active{
    transform:translateY(-2px);
    border-color:rgba(7,87,216,.35);
    box-shadow:0 18px 42px rgba(7,87,216,.13);
}

.category-pill.active{
    background:linear-gradient(135deg,#eff6ff,#ffffff);
}

.category-icon{
    width:48px;
    height:48px;
    border-radius:50%;
    overflow:hidden;
    background:#eff6ff;
    color:var(--primary);
    display:grid;
    place-items:center;
    flex:0 0 auto;
}

.category-icon img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
}

.category-icon.all{
    background:linear-gradient(135deg,#0757d8,#0043b8);
    color:#fff;
}

.category-pill strong{
    font-size:15px;
    font-weight:950;
    white-space:nowrap;
}

/* FILTER */
.tour-filter{
    max-width:1660px;
    margin:0 auto 26px;
    padding:18px;
    border-radius:28px;
    background:rgba(255,255,255,.94);
    backdrop-filter:blur(14px);
    border:1px solid rgba(226,232,240,.95);
    box-shadow:
        0 24px 70px rgba(15,23,42,.10),
        inset 0 1px 0 rgba(255,255,255,.9);
    display:grid;
    grid-template-columns:
        minmax(270px, 2.2fr)
        minmax(160px, 1.15fr)
        minmax(120px, .85fr)
        minmax(120px, .85fr)
        minmax(135px, .95fr)
        minmax(155px, 1fr)
        minmax(190px, 1.15fr)
        minmax(145px, .9fr)
        minmax(120px, .75fr);
    gap:12px;
}

.tour-filter input,
.tour-filter select{
    width:100%;
    min-width:0;
    height:52px;
    border-radius:16px;
    border:1px solid #dbe5f3;
    background:#fff;
    color:var(--text);
    padding:0 15px;
    outline:none;
    font-size:14px;
    font-weight:800;
    transition:.22s ease;
}

.tour-filter select{
    padding-right:34px;
}

.tour-filter input::placeholder{
    color:#94a3b8;
    font-weight:750;
}

.tour-filter input:hover,
.tour-filter select:hover{
    border-color:#bfd1eb;
}

.tour-filter input:focus,
.tour-filter select:focus{
    border-color:var(--primary);
    box-shadow:0 0 0 4px rgba(7,87,216,.10);
}

.tour-filter button,
.reset-btn{
    height:52px;
    border:0;
    border-radius:16px;
    font-size:14px;
    font-weight:1000;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    text-decoration:none;
    white-space:nowrap;
    transition:.25s ease;
}

.tour-filter button{
    color:#fff;
    background:linear-gradient(135deg,#0867ff,#0047c6);
    box-shadow:0 14px 28px rgba(7,87,216,.24);
}

.tour-filter button:hover{
    transform:translateY(-2px);
    box-shadow:0 18px 36px rgba(7,87,216,.32);
}

.reset-btn{
    background:#f1f5f9;
    color:#334155;
    border:1px solid #e2e8f0;
}

.reset-btn:hover{
    background:#e2e8f0;
    color:#0f172a;
}

/* RESULT BAR */
.tour-result-bar{
    max-width:1660px;
    margin:0 auto 26px;
    padding:16px 20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:16px;
    background:rgba(255,255,255,.88);
    border:1px solid rgba(226,232,240,.95);
    border-radius:22px;
    box-shadow:0 14px 34px rgba(15,23,42,.07);
}

.result-left{
    display:flex;
    align-items:center;
    gap:14px;
    min-width:0;
}

.result-left span{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    height:34px;
    padding:0 14px;
    border-radius:999px;
    background:#eff6ff;
    color:var(--primary);
    font-size:13px;
    font-weight:1000;
    white-space:nowrap;
}

.result-left p{
    margin:0;
    color:#475569;
    font-size:15px;
    font-weight:850;
}

.result-left strong{
    color:var(--primary);
    font-size:22px;
    font-weight:1000;
}

.clear-filter-btn{
    height:40px;
    padding:0 16px;
    border-radius:999px;
    background:#fff1f2;
    border:1px solid #fecdd3;
    color:#e11d48;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    font-size:14px;
    font-weight:1000;
    white-space:nowrap;
    transition:.25s ease;
}

.clear-filter-btn:hover{
    background:#e11d48;
    color:#fff;
    border-color:#e11d48;
    transform:translateY(-2px);
    box-shadow:0 12px 24px rgba(225,29,72,.18);
}

.alert-success-custom{
    max-width:1660px;
    margin:0 auto 22px;
    padding:15px 18px;
    border-radius:18px;
    background:#ecfdf5;
    border:1px solid #bbf7d0;
    color:#047857;
    font-weight:900;
    display:flex;
    align-items:center;
    gap:10px;
}

/* GRID */
.tour-grid{
    max-width:1660px;
    margin:0 auto;
    display:grid;
    grid-template-columns:repeat(3, minmax(0, 1fr));
    gap:42px;
}

/* CARD */
.tour-card{
    position:relative;
    background:#fff;
    border-radius:32px;
    overflow:hidden;
    border:1px solid rgba(226,232,240,.88);
    box-shadow:
        0 26px 60px rgba(15,23,42,.10),
        0 2px 8px rgba(15,23,42,.04);
    transition:.32s ease;
}

.tour-card::before{
    content:"";
    position:absolute;
    inset:0;
    z-index:2;
    pointer-events:none;
    border-radius:32px;
    background:linear-gradient(135deg,rgba(7,87,216,.10),transparent 36%,rgba(255,214,41,.12));
    opacity:0;
    transition:.32s ease;
}

.tour-card:hover{
    transform:translateY(-10px);
    box-shadow:
        0 34px 80px rgba(15,23,42,.16),
        0 12px 30px rgba(7,87,216,.08);
}

.tour-card:hover::before{
    opacity:1;
}

.tour-img{
    height:310px;
    position:relative;
    overflow:hidden;
    background:linear-gradient(135deg,#dbeafe,#f8fafc);
}

.tour-img::before{
    content:"";
    position:absolute;
    inset:0;
    z-index:1;
    background:linear-gradient(180deg,rgba(15,23,42,.04),rgba(15,23,42,.34));
    pointer-events:none;
}

.tour-img img{
    width:100%;
    height:100%;
    object-fit:cover;
    display:block;
    transition:.45s ease;
}

.tour-card:hover .tour-img img{
    transform:scale(1.08);
}

.tour-badge{
    position:absolute;
    z-index:3;
    top:18px;
    left:18px;
    max-width:calc(100% - 90px);
    padding:9px 16px;
    background:linear-gradient(135deg,#ffe45c,#ffc400);
    color:#0f172a;
    border-radius:999px;
    font-size:13px;
    font-weight:1000;
    box-shadow:0 12px 26px rgba(15,23,42,.18);
    border:1px solid rgba(255,255,255,.45);
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.favorite-form{
    position:absolute;
    z-index:3;
    top:18px;
    right:18px;
    margin:0;
}

.favorite-form .heart-btn{
    position:static;
}

.tour-img > .heart-btn{
    display:flex;
    align-items:center;
    justify-content:center;
    text-decoration:none;
}

.heart-btn{
    position:absolute;
    z-index:3;
    top:18px;
    right:18px;
    width:46px;
    height:46px;
    border-radius:50%;
    border:1px solid rgba(255,255,255,.8);
    color:var(--primary);
    background:rgba(255,255,255,.95);
    backdrop-filter:blur(10px);
    cursor:pointer;
    box-shadow:0 12px 28px rgba(15,23,42,.16);
    transition:.25s ease;
    display:flex;
    align-items:center;
    justify-content:center;
}

.heart-btn:hover{
    color:#ef4444;
    transform:scale(1.08);
}

.heart-btn.active{
    color:#e11d48;
    background:#fff1f2;
    border-color:#fecdd3;
}

.heart-btn.active:hover{
    color:#fff;
    background:#e11d48;
    border-color:#e11d48;
}

.tour-body{
    position:relative;
    z-index:4;
    padding:28px 30px 28px;
}

.tour-body h3{
    margin:0 0 18px;
    min-height:64px;
    color:#071126;
    font-size:26px;
    line-height:1.28;
    font-weight:1000;
    letter-spacing:-.7px;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

.tour-info{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:12px;
    margin:18px 0;
}

.tour-info span{
    min-width:0;
    display:flex;
    align-items:center;
    gap:8px;
    background:linear-gradient(180deg,#f8fbff,#f3f7fc);
    border:1px solid #e6edf7;
    border-radius:17px;
    color:#253858;
    font-size:14px;
    font-weight:850;
    padding:13px 15px;
    line-height:1.25;
    box-shadow:inset 0 1px 0 rgba(255,255,255,.7);
}

.tour-info i{
    width:18px;
    height:18px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    color:var(--primary);
    flex:0 0 auto;
}

.start-date{
    display:flex;
    align-items:center;
    gap:10px;
    margin:20px 0;
    padding:16px 17px;
    border-radius:18px;
    background:linear-gradient(135deg,rgba(7,87,216,.09),rgba(255,255,255,.9));
    border:1px solid rgba(7,87,216,.16);
    color:#071126;
    font-size:14px;
    font-weight:900;
}

.start-date i{
    color:var(--primary);
}

.start-date.muted{
    background:#f8fafc;
    color:#64748b;
    border-color:#e2e8f0;
}

/* PRICE + BUTTONS */
.tour-bottom{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:16px;
    margin-top:8px;
    padding-top:20px;
    border-top:1px dashed #d7e3f3;
}

.price-box span{
    display:block;
    color:#64748b;
    font-size:13px;
    font-weight:900;
    margin-bottom:4px;
}

.price-box strong{
    display:block;
    color:var(--orange);
    font-size:30px;
    line-height:1.1;
    font-weight:1000;
    letter-spacing:-.8px;
}

.tour-actions{
    display:flex;
    align-items:center;
    gap:10px;
    flex:0 0 auto;
}

.tour-actions a{
    height:46px;
    padding:0 17px;
    border-radius:15px;
    font-size:14px;
    font-weight:1000;
    text-decoration:none;
    white-space:nowrap;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    transition:.25s ease;
}

.detail-btn{
    border:1.7px solid var(--primary);
    background:#fff;
    color:var(--primary);
}

.detail-btn:hover{
    background:#eff6ff;
    transform:translateY(-2px);
}

.booking-btn{
    border:1.7px solid var(--primary);
    background:linear-gradient(135deg,#0867ff,#0047c6);
    color:#fff;
    box-shadow:0 12px 24px rgba(7,87,216,.24);
}

.booking-btn:hover{
    color:#fff;
    transform:translateY(-2px);
    box-shadow:0 16px 32px rgba(7,87,216,.32);
}

/* PAGINATION */
.pagination-wrap{
    max-width:1660px;
    margin:46px auto 0;
    display:flex;
    justify-content:center;
    align-items:center;
}

.pagination-wrap nav{
    width:100%;
    display:flex;
    justify-content:center;
}

.pagination-wrap p,
.pagination-wrap .text-sm,
.pagination-wrap nav > div:first-child{
    display:none !important;
}

.pagination-wrap nav > div:last-child{
    display:flex !important;
    justify-content:center !important;
    width:100%;
}

.pagination-wrap .pagination{
    display:flex;
    gap:10px;
    justify-content:center;
    align-items:center;
    flex-wrap:wrap;
    margin:0;
    padding:0;
}

.pagination-wrap .page-item{
    list-style:none;
}

.pagination-wrap .page-link{
    min-width:46px;
    height:46px;
    padding:0 14px;
    border-radius:15px !important;
    border:1px solid #dce7f5 !important;
    background:#fff !important;
    color:#0f172a !important;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:1000;
    text-decoration:none;
    box-shadow:0 10px 24px rgba(15,23,42,.08);
}

.pagination-wrap .page-item.active .page-link{
    background:linear-gradient(135deg,#0867ff,#0047c6) !important;
    border-color:var(--primary) !important;
    color:#fff !important;
    box-shadow:0 14px 28px rgba(7,87,216,.28);
}

.pagination-wrap .page-item.disabled .page-link{
    opacity:.45;
}

/* EMPTY */
.empty-tour{
    max-width:1660px;
    margin:0 auto;
    background:rgba(255,255,255,.92);
    text-align:center;
    padding:70px 30px;
    border-radius:30px;
    border:1px solid #e2e8f0;
    box-shadow:var(--shadow);
}

.empty-tour i{
    width:78px;
    height:78px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    background:var(--primary-soft);
    font-size:38px;
    color:var(--primary);
    margin-bottom:18px;
}

.empty-tour h3{
    margin:0 0 10px;
    color:var(--text);
    font-size:28px;
    font-weight:1000;
}

.empty-tour p{
    margin:0 0 24px;
    color:#64748b;
    font-size:16px;
}

.empty-tour a{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:13px 24px;
    border-radius:999px;
    background:linear-gradient(135deg,#0867ff,#0047c6);
    color:#fff;
    font-weight:1000;
    text-decoration:none;
    box-shadow:0 14px 28px rgba(7,87,216,.24);
}

/* RESPONSIVE */
@media(max-width:1450px){
    .tour-container{
        width:min(1240px, calc(100% - 40px));
    }

    .tour-hero-clean,
    .category-section,
    .tour-filter,
    .tour-result-bar,
    .tour-grid,
    .pagination-wrap,
    .empty-tour,
    .alert-success-custom{
        max-width:1240px;
    }

    .tour-grid{
        gap:28px;
    }

    .tour-img{
        height:250px;
    }

    .tour-body{
        padding:24px 24px 22px;
    }

    .tour-body h3{
        font-size:22px;
        min-height:58px;
    }

    .price-box strong{
        font-size:25px;
    }

    .tour-bottom{
        flex-direction:column;
        align-items:flex-start;
    }

    .tour-actions{
        width:100%;
    }

    .tour-actions a{
        flex:1;
    }

    .tour-filter{
        grid-template-columns:repeat(4,1fr);
    }

    .tour-filter input[name="keyword"]{
        grid-column:span 2;
    }
}

@media(max-width:1050px){
    .tour-hero-clean{
        grid-template-columns:1fr;
    }

    .tour-hero-text{
        padding:44px 34px;
        text-align:center;
    }

    .hero-pill{
        margin-left:auto;
        margin-right:auto;
    }

    .tour-hero-text p{
        margin-left:auto;
        margin-right:auto;
    }

    .tour-hero-photo{
        min-height:250px;
    }

    .hero-floating-card{
        left:24px;
        bottom:24px;
    }

    .tour-grid{
        grid-template-columns:repeat(2, minmax(0, 1fr));
    }

    .tour-filter{
        grid-template-columns:repeat(3,1fr);
    }

    .tour-filter input[name="keyword"]{
        grid-column:span 3;
    }
}

@media(max-width:760px){
    .tour-page{
        padding:62px 0 72px;
    }

    .tour-container{
        width:calc(100% - 24px);
    }

    .tour-hero-clean{
        border-radius:26px;
        margin-bottom:24px;
    }

    .tour-hero-text{
        padding:34px 22px;
    }

    .tour-hero-text h1{
        letter-spacing:-1px;
    }

    .hero-stats{
        grid-template-columns:1fr;
    }

    .hero-floating-card{
        width:auto;
        left:18px;
        right:18px;
        bottom:18px;
    }

    .category-title{
        align-items:flex-start;
        flex-direction:column;
    }

    .category-title h2{
        font-size:24px;
    }

    .tour-filter{
        grid-template-columns:1fr;
        padding:16px;
        border-radius:22px;
    }

    .tour-filter input[name="keyword"]{
        grid-column:auto;
    }

    .tour-result-bar{
        align-items:flex-start;
        flex-direction:column;
        border-radius:18px;
    }

    .result-left{
        align-items:flex-start;
        flex-direction:column;
        gap:8px;
    }

    .clear-filter-btn{
        width:100%;
    }

    .tour-grid{
        grid-template-columns:1fr;
        gap:22px;
    }

    .tour-img{
        height:220px;
    }

    .tour-body{
        padding:22px 20px;
    }

    .tour-body h3{
        min-height:auto;
        font-size:21px;
    }

    .tour-info{
        grid-template-columns:1fr;
    }

    .tour-actions{
        flex-direction:column;
    }

    .tour-actions a{
        width:100%;
    }
}

@media(max-width:420px){
    .tour-img{
        height:200px;
    }

    .price-box strong{
        font-size:23px;
    }

    .tour-filter button,
    .reset-btn{
        width:100%;
    }
}

/* TOÀN BỘ CARD TOUR CÓ THỂ BẤM */
.tour-card-clickable{
    cursor:pointer;
}

.tour-card-clickable:focus-visible{
    outline:3px solid rgba(7,87,216,.25);
    outline-offset:5px;
}

.tour-card-clickable a,
.tour-card-clickable button,
.tour-card-clickable form,
.tour-card-clickable input,
.tour-card-clickable select,
.tour-card-clickable textarea,
.tour-card-clickable label{
    position:relative;
    z-index:6;
}

</style>


<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.tour-card-clickable').forEach(function (card) {
        const detailUrl = card.dataset.detailUrl;

        function openDetail() {
            if (detailUrl) {
                window.location.href = detailUrl;
            }
        }

        card.addEventListener('click', function (event) {
            /*
             * Không chuyển sang trang chi tiết khi người dùng bấm:
             * - nút yêu thích
             * - nút Xem chi tiết
             * - nút Đặt tour
             * - bất kỳ form/nút nhập liệu nào trong card
             */
            if (event.target.closest(
                'a, button, form, input, select, textarea, label'
            )) {
                return;
            }

            openDetail();
        });

        card.addEventListener('keydown', function (event) {
            if (event.key !== 'Enter' && event.key !== ' ') {
                return;
            }

            if (event.target.closest(
                'a, button, form, input, select, textarea, label'
            )) {
                return;
            }

            event.preventDefault();
            openDetail();
        });
    });
});
</script>

@endsection