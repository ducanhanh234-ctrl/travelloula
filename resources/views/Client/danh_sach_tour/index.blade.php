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
                        /*
                         * Tour chỉ được chuyển sang form đặt tour khi có lịch:
                         * - Từ hôm nay trở đi.
                         * - Trạng thái available.
                         * - Số chỗ còn lại lớn hơn 0.
                         */
                        $homNay = now()->startOfDay();

                        $tatCaLichKhoiHanhs = collect(
                            $tour->lichKhoiHanhTours ?? []
                        )
                            ->filter(function ($lich) {
                                return in_array($lich->trang_thai, [
                                    'available',
                                    'running',
                                    'full',
                                    'closed',
                                ], true);
                            })
                            ->sortBy('ngay_khoi_hanh')
                            ->values();

                        $lichKhoiHanhsSapToi = $tatCaLichKhoiHanhs
                            ->filter(function ($lich) use ($homNay) {
                                if (empty($lich->ngay_khoi_hanh)) {
                                    return false;
                                }

                                return \Carbon\Carbon::parse(
                                    $lich->ngay_khoi_hanh
                                )->startOfDay()->gte($homNay);
                            })
                            ->values();

                        $lichCoTheDat = $lichKhoiHanhsSapToi
                            ->filter(function ($lich) {
                                return $lich->trang_thai === 'available'
                                    && (int) $lich->so_cho_con_lai > 0;
                            })
                            ->sortBy('ngay_khoi_hanh')
                            ->values();

                        $lichGanNhat = $lichCoTheDat->first();
                        $coTheDatTour = $lichGanNhat !== null;

                        /*
                         * Xác định lý do để chỉ hiển thị khi khách bấm
                         * nút "Đặt tour".
                         */
                        $lyDoKhongDat = 'Tour hiện chưa có lịch khởi hành có thể đặt.';

                        if ($tatCaLichKhoiHanhs->isEmpty()) {
                            $lyDoKhongDat = 'Tour này chưa được tạo lịch khởi hành. Vui lòng quay lại sau hoặc liên hệ tư vấn để được thông báo khi có lịch mới.';
                        } elseif ($lichKhoiHanhsSapToi->isEmpty()) {
                            $lyDoKhongDat = 'Tour hiện không còn lịch khởi hành sắp tới. Các lịch đã tạo đều đã qua ngày khởi hành.';
                        } elseif ($lichKhoiHanhsSapToi->every(
                            fn ($lich) => $lich->trang_thai === 'closed'
                        )) {
                            $lyDoKhongDat = 'Tất cả lịch khởi hành sắp tới của tour đã đóng đăng ký.';
                        } elseif ($lichKhoiHanhsSapToi->every(function ($lich) {
                            return $lich->trang_thai === 'full'
                                || (int) $lich->so_cho_con_lai <= 0;
                        })) {
                            $lyDoKhongDat = 'Tất cả lịch khởi hành sắp tới của tour đã hết chỗ.';
                        } elseif ($lichKhoiHanhsSapToi->every(
                            fn ($lich) => $lich->trang_thai === 'running'
                        )) {
                            $lyDoKhongDat = 'Các lịch khởi hành của tour hiện đang diễn ra nên hệ thống không thể nhận thêm khách.';
                        } elseif (!$coTheDatTour) {
                            $lyDoKhongDat = 'Tour có lịch khởi hành nhưng hiện chưa có lịch nào đang mở bán và còn chỗ.';
                        }

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

                            @if($coTheDatTour)
                                <div class="start-date">
                                    <i class="fa-solid fa-calendar-check"></i>
                                    <span>
                                        Khởi hành:
                                        <strong>
                                            {{ \Carbon\Carbon::parse($lichGanNhat->ngay_khoi_hanh)->format('d/m/Y') }}
                                        </strong>
                                        - còn
                                        <strong>{{ (int) $lichGanNhat->so_cho_con_lai }}</strong>
                                        chỗ
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

                                    @if($coTheDatTour)
                                        <a
                                            href="{{ route('Client.danh_sach_tour.show', $tour->id) }}#dat-tour"
                                            class="booking-btn"
                                        >
                                            Đặt tour
                                        </a>
                                    @else
                                        <button
                                            type="button"
                                            class="booking-btn js-booking-unavailable"
                                            data-tour-name="{{ $tour->ten_tour }}"
                                            data-reason="{{ $lyDoKhongDat }}"
                                            aria-label="Đặt tour {{ $tour->ten_tour }}"
                                        >
                                            Đặt tour
                                        </button>
                                    @endif
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

<div
    class="booking-message-modal"
    id="bookingMessageModal"
    role="dialog"
    aria-modal="true"
    aria-hidden="true"
    aria-labelledby="bookingMessageTitle"
>
    <div
        class="booking-message-backdrop"
        data-close-booking-message
    ></div>

    <div class="booking-message-dialog">
        <button
            type="button"
            class="booking-message-close"
            data-close-booking-message
            aria-label="Đóng thông báo"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="booking-message-icon">
            <i class="fa-solid fa-calendar-xmark"></i>
        </div>

        <span class="booking-message-kicker">
            Thông tin đặt tour
        </span>

        <h3 id="bookingMessageTitle">
            Tour hiện chưa thể đặt
        </h3>

        <p id="bookingMessageText">
            Tour chưa có lịch khởi hành phù hợp.
        </p>

        <div class="booking-message-actions">
            <button
                type="button"
                class="booking-message-confirm"
                data-close-booking-message
            >
                Đã hiểu
            </button>

            <a href="{{ route('Client.danh_sach_tour.index') }}">
                Xem tour khác
            </a>
        </div>
    </div>
</div>

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
    font-family:inherit;
    cursor:pointer;
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

.tour-actions a,
.tour-actions button{
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

    .tour-actions a,
    .tour-actions button{
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

    .tour-actions a,
    .tour-actions button{
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


/* =========================================================
   SỬA TRÁI TIM YÊU THÍCH TRÊN TRANG DANH SÁCH TOUR
   Rule cuối trang đang ép form/button thành position:relative,
   nên cần ghi đè lại vị trí tuyệt đối trong khung ảnh.
   ========================================================= */
.tour-card-clickable .tour-img{
    position:relative !important;
}

.tour-card-clickable .favorite-form{
    position:absolute !important;
    top:18px !important;
    right:18px !important;
    z-index:20 !important;
    width:46px;
    height:46px;
    margin:0 !important;
    padding:0 !important;
    display:block !important;
}

.tour-card-clickable .favorite-form .heart-btn{
    position:absolute !important;
    inset:0 !important;
    z-index:21 !important;
    width:46px !important;
    height:46px !important;
    min-width:46px !important;
    min-height:46px !important;
    padding:0 !important;
    margin:0 !important;
    border-radius:50% !important;
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    opacity:1 !important;
    visibility:visible !important;
}

.tour-card-clickable .tour-img > a.heart-btn{
    position:absolute !important;
    top:18px !important;
    right:18px !important;
    z-index:21 !important;
    width:46px !important;
    height:46px !important;
    min-width:46px !important;
    min-height:46px !important;
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    opacity:1 !important;
    visibility:visible !important;
}

.tour-card-clickable .heart-btn i{
    pointer-events:none;
}

@media(max-width:760px){
    .tour-card-clickable .favorite-form{
        top:14px !important;
        right:14px !important;
        width:42px;
        height:42px;
    }

    .tour-card-clickable .favorite-form .heart-btn,
    .tour-card-clickable .tour-img > a.heart-btn{
        width:42px !important;
        height:42px !important;
        min-width:42px !important;
        min-height:42px !important;
    }

    .tour-card-clickable .tour-img > a.heart-btn{
        top:14px !important;
        right:14px !important;
    }
}


/* =========================================================
   RESPONSIVE TOÀN DIỆN CHO TRANG DANH SÁCH TOUR
   TV / DESKTOP / LAPTOP / TABLET / MOBILE
   ========================================================= */

html,
body{
    width:100%;
    max-width:100%;
    overflow-x:hidden;
}

.tour-page{
    width:100%;
    padding:
        clamp(48px,5vw,92px)
        0
        clamp(56px,6vw,110px);
}

.tour-container{
    width:100% !important;
    max-width:none !important;
    margin:0 auto;
    padding-left:clamp(14px,3vw,72px);
    padding-right:clamp(14px,3vw,72px);
}

/* Các khối chính luôn dùng toàn bộ chiều rộng khả dụng */
.tour-hero-clean,
.category-section,
.tour-filter,
.tour-result-bar,
.tour-grid,
.pagination-wrap,
.empty-tour,
.alert-success-custom{
    width:100%;
    max-width:none !important;
}

/* HERO */
.tour-hero-clean{
    min-height:clamp(330px,26vw,520px);
    grid-template-columns:minmax(0,.95fr) minmax(0,1.05fr);
    border-radius:clamp(22px,2vw,40px);
}

.tour-hero-text{
    min-width:0;
    padding:
        clamp(30px,4vw,72px)
        clamp(24px,4vw,76px);
}

.tour-hero-text h1{
    font-size:clamp(38px,4.2vw,76px);
    line-height:1.02;
    overflow-wrap:anywhere;
}

.tour-hero-text p{
    max-width:760px;
    font-size:clamp(15px,1.15vw,20px);
}

.hero-stats{
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:clamp(10px,1vw,18px);
}

.hero-stats div{
    min-width:0;
    padding:clamp(13px,1.2vw,20px);
}

.hero-stats strong{
    font-size:clamp(22px,1.8vw,32px);
}

.hero-stats span{
    font-size:clamp(11px,.9vw,15px);
}

.tour-hero-photo{
    min-height:clamp(330px,26vw,520px);
}

.hero-floating-card{
    left:clamp(18px,2vw,38px);
    bottom:clamp(18px,2vw,38px);
    width:min(430px,calc(100% - 36px));
    padding:clamp(16px,1.4vw,24px);
}

/* CATEGORY */
.category-section{
    margin-top:clamp(20px,2vw,32px);
}

.category-title h2{
    font-size:clamp(23px,2vw,34px);
}

.category-scroll{
    gap:clamp(10px,1vw,16px);
    overscroll-behavior-inline:contain;
    scroll-snap-type:x proximity;
}

.category-pill{
    scroll-snap-align:start;
    height:clamp(56px,4vw,70px);
}

.category-icon{
    width:clamp(42px,3vw,52px);
    height:clamp(42px,3vw,52px);
}

/* FILTER */
.tour-filter{
    grid-template-columns:
        minmax(240px,2fr)
        minmax(150px,1fr)
        minmax(110px,.8fr)
        minmax(110px,.8fr)
        minmax(130px,.9fr)
        minmax(145px,1fr)
        minmax(170px,1.1fr)
        minmax(135px,.85fr)
        minmax(110px,.75fr);
    gap:clamp(8px,.8vw,14px);
    padding:clamp(14px,1.4vw,22px);
}

.tour-filter input,
.tour-filter select,
.tour-filter button,
.reset-btn{
    min-width:0;
    height:clamp(48px,3.4vw,56px);
    font-size:clamp(12px,.9vw,15px);
}

/* RESULT BAR */
.tour-result-bar{
    padding:
        clamp(13px,1.2vw,18px)
        clamp(15px,1.4vw,24px);
}

.result-left{
    min-width:0;
}

.result-left p{
    overflow-wrap:anywhere;
}

/* GRID TOUR */
.tour-grid{
    display:grid;
    grid-template-columns:repeat(3,minmax(0,1fr));
    gap:clamp(22px,2.4vw,44px);
    align-items:stretch;
}

.tour-card{
    min-width:0;
    height:100%;
    display:flex;
    flex-direction:column;
    border-radius:clamp(22px,1.8vw,34px);
}

.tour-img{
    width:100%;
    height:auto !important;
    aspect-ratio:16/9;
    min-height:210px;
}

.tour-body{
    flex:1;
    display:flex;
    flex-direction:column;
    min-width:0;
    padding:clamp(20px,1.8vw,32px);
}

.tour-body h3{
    min-height:2.6em;
    font-size:clamp(20px,1.55vw,29px);
    overflow-wrap:anywhere;
}

.tour-info{
    grid-template-columns:repeat(2,minmax(0,1fr));
}

.tour-info span{
    min-width:0;
    overflow-wrap:anywhere;
}

.start-date{
    min-width:0;
    overflow-wrap:anywhere;
}

.tour-bottom{
    margin-top:auto;
    align-items:flex-end;
}

.price-box{
    min-width:0;
}

.price-box strong{
    font-size:clamp(23px,1.8vw,34px);
    overflow-wrap:anywhere;
}

.tour-actions{
    min-width:0;
}

.tour-actions a{
    min-width:0;
}

/* Phân trang */
.pagination-wrap{
    overflow-x:auto;
    padding-bottom:6px;
}

.pagination-wrap .pagination{
    min-width:max-content;
}

/* Màn hình TV và màn hình rất lớn */
@media(min-width:1920px){
    .tour-container{
        padding-left:clamp(80px,4vw,140px);
        padding-right:clamp(80px,4vw,140px);
    }

    .tour-grid{
        grid-template-columns:repeat(4,minmax(0,1fr));
    }

    .tour-filter{
        grid-template-columns:
            minmax(300px,2.2fr)
            minmax(180px,1.1fr)
            minmax(135px,.8fr)
            minmax(135px,.8fr)
            minmax(150px,.9fr)
            minmax(165px,1fr)
            minmax(190px,1.1fr)
            minmax(155px,.9fr)
            minmax(125px,.75fr);
    }

    .tour-body h3{
        font-size:28px;
    }

    .tour-actions a,
    .tour-actions button{
        min-height:50px;
        font-size:15px;
    }
}

/* Desktop lớn */
@media(min-width:1500px) and (max-width:1919px){
    .tour-grid{
        grid-template-columns:repeat(3,minmax(0,1fr));
    }
}

/* Laptop và desktop vừa */
@media(max-width:1499px){
    .tour-container{
        padding-left:28px;
        padding-right:28px;
    }

    .tour-grid{
        grid-template-columns:repeat(3,minmax(0,1fr));
        gap:26px;
    }

    .tour-filter{
        grid-template-columns:repeat(4,minmax(0,1fr));
    }

    .tour-filter input[name="keyword"]{
        grid-column:span 2;
    }

    .tour-filter button,
    .reset-btn{
        width:100%;
    }

    .tour-bottom{
        flex-direction:column;
        align-items:stretch;
    }

    .tour-actions{
        width:100%;
    }

    .tour-actions a,
    .tour-actions button{
        flex:1;
    }
}

/* Tablet ngang / laptop nhỏ */
@media(max-width:1100px){
    .tour-container{
        padding-left:22px;
        padding-right:22px;
    }

    .tour-hero-clean{
        grid-template-columns:1fr;
    }

    .tour-hero-text{
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
        min-height:320px;
    }

    .tour-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .tour-filter{
        grid-template-columns:repeat(3,minmax(0,1fr));
    }

    .tour-filter input[name="keyword"]{
        grid-column:span 3;
    }
}

/* Tablet dọc */
@media(max-width:820px){
    .tour-page{
        padding-top:54px;
    }

    .tour-container{
        padding-left:16px;
        padding-right:16px;
    }

    .tour-hero-clean{
        border-radius:24px;
    }

    .tour-hero-text{
        padding:34px 22px;
    }

    .hero-stats{
        grid-template-columns:1fr;
    }

    .tour-filter{
        grid-template-columns:repeat(2,minmax(0,1fr));
        border-radius:22px;
    }

    .tour-filter input[name="keyword"]{
        grid-column:1/-1;
    }

    .tour-result-bar{
        align-items:flex-start;
        flex-direction:column;
    }

    .clear-filter-btn{
        width:100%;
    }

    .tour-info{
        grid-template-columns:1fr;
    }
}

/* Điện thoại */
@media(max-width:640px){
    .tour-page{
        padding:
            38px
            0
            64px;
    }

    .tour-container{
        padding-left:10px;
        padding-right:10px;
    }

    .tour-hero-clean{
        border-radius:20px;
        margin-bottom:20px;
    }

    .tour-hero-text{
        padding:28px 18px;
    }

    .tour-hero-text h1{
        font-size:36px;
        letter-spacing:-1.2px;
    }

    .tour-hero-photo{
        min-height:245px;
    }

    .hero-floating-card{
        left:12px;
        right:12px;
        bottom:12px;
        width:auto;
        border-radius:16px;
    }

    .category-title{
        align-items:flex-start;
        flex-direction:column;
    }

    .category-title h2{
        font-size:23px;
    }

    .category-scroll{
        padding-bottom:10px;
    }

    .category-pill{
        height:56px;
        padding-right:14px;
    }

    .category-pill strong{
        font-size:13px;
    }

    .tour-filter{
        grid-template-columns:1fr;
        padding:14px;
        gap:10px;
    }

    .tour-filter input[name="keyword"]{
        grid-column:auto;
    }

    .tour-filter button,
    .reset-btn{
        width:100%;
    }

    .tour-result-bar{
        border-radius:16px;
        padding:14px;
    }

    .result-left{
        align-items:flex-start;
        flex-direction:column;
        gap:8px;
    }

    .tour-grid{
        grid-template-columns:1fr;
        gap:20px;
    }

    .tour-card{
        border-radius:22px;
    }

    .tour-img{
        min-height:205px;
        aspect-ratio:16/10;
    }

    .tour-body{
        padding:20px 17px;
    }

    .tour-body h3{
        min-height:auto;
        font-size:21px;
    }

    .tour-bottom{
        gap:15px;
    }

    .tour-actions{
        flex-direction:column;
    }

    .tour-actions a{
        width:100%;
        min-height:46px;
    }

    .favorite-form,
    .tour-card-clickable .favorite-form{
        top:12px !important;
        right:12px !important;
        width:40px !important;
        height:40px !important;
    }

    .heart-btn,
    .tour-card-clickable .favorite-form .heart-btn,
    .tour-card-clickable .tour-img > a.heart-btn{
        width:40px !important;
        height:40px !important;
        min-width:40px !important;
        min-height:40px !important;
    }

    .tour-card-clickable .tour-img > a.heart-btn{
        top:12px !important;
        right:12px !important;
    }

    .tour-badge{
        top:12px;
        left:12px;
        max-width:calc(100% - 74px);
        padding:7px 12px;
        font-size:11px;
    }
}

/* Điện thoại rất nhỏ */
@media(max-width:390px){
    .tour-container{
        padding-left:8px;
        padding-right:8px;
    }

    .tour-hero-text h1{
        font-size:31px;
    }

    .hero-floating-card strong{
        font-size:18px;
    }

    .result-left strong{
        font-size:19px;
    }

    .price-box strong{
        font-size:22px;
    }

    .pagination-wrap .page-link{
        min-width:40px;
        height:40px;
        padding:0 11px;
    }
}


/* =========================================================
   TINH CHỈNH RESPONSIVE SAU KHI KIỂM TRA THỰC TẾ
   - Hero không quá cao
   - Danh mục không còn thanh cuộn xấu trên desktop
   - Bộ lọc gọn và vừa màn hình
   - Nội dung không kéo sát hai cạnh màn hình
   ========================================================= */

.tour-container{
    width:min(1680px, calc(100% - clamp(28px,4vw,88px))) !important;
    max-width:1680px !important;
    padding-left:0 !important;
    padding-right:0 !important;
}

/* HERO GỌN HƠN TRÊN DESKTOP */
.tour-hero-clean{
    min-height:340px !important;
    grid-template-columns:minmax(0,.9fr) minmax(0,1.1fr);
}

.tour-hero-text{
    padding:38px clamp(32px,3vw,56px) !important;
}

.tour-hero-text h1{
    font-size:clamp(42px,3.7vw,66px) !important;
    line-height:1.04;
}

.tour-hero-text p{
    margin-top:14px;
    max-width:660px;
    font-size:clamp(15px,1vw,18px);
    line-height:1.65;
}

.hero-stats{
    margin-top:24px;
    gap:12px;
}

.hero-stats div{
    padding:14px 16px;
    border-radius:17px;
}

.hero-stats strong{
    font-size:24px;
}

.tour-hero-photo{
    min-height:340px !important;
}

.hero-floating-card{
    max-width:390px;
    padding:18px 20px;
    border-radius:20px;
}

/* DANH MỤC: DESKTOP TỰ XUỐNG DÒNG, KHÔNG HIỆN THANH CUỘN */
.category-scroll{
    display:flex;
    flex-wrap:wrap;
    overflow:visible;
    gap:12px;
    padding:4px 0 8px;
    scrollbar-width:none;
}

.category-scroll::-webkit-scrollbar{
    display:none;
}

.category-pill{
    height:58px;
    padding:7px 16px 7px 7px;
}

.category-icon{
    width:44px;
    height:44px;
}

.category-pill strong{
    font-size:14px;
}

/* BỘ LỌC GỌN, KHÔNG PHÓNG QUÁ TO */
.tour-filter{
    grid-template-columns:
        minmax(230px,2fr)
        minmax(150px,1.25fr)
        minmax(105px,.8fr)
        minmax(105px,.8fr)
        minmax(130px,1fr)
        minmax(145px,1.1fr)
        minmax(170px,1.25fr)
        minmax(130px,.95fr)
        minmax(105px,.8fr) !important;
    gap:10px !important;
    padding:16px !important;
    border-radius:22px;
}

.tour-filter input,
.tour-filter select,
.tour-filter button,
.reset-btn{
    height:50px !important;
    border-radius:13px;
    font-size:13px;
}

/* RESULT BAR */
.tour-result-bar{
    margin-top:2px;
    border-radius:18px;
}

/* CARD TOUR GỌN HƠN TRÊN DESKTOP */
.tour-grid{
    gap:28px !important;
}

.tour-card{
    border-radius:24px;
}

.tour-img{
    min-height:220px;
    aspect-ratio:16/9;
}

.tour-body{
    padding:22px 22px 24px;
}

.tour-body h3{
    font-size:22px;
    min-height:56px;
    margin-bottom:14px;
}

.tour-info{
    margin:14px 0;
    gap:9px;
}

.tour-info span{
    padding:11px 12px;
    border-radius:13px;
    font-size:13px;
}

.start-date{
    margin:15px 0;
    padding:13px 14px;
    border-radius:14px;
    font-size:13px;
}

.tour-bottom{
    padding-top:16px;
}

/* TV / MÀN HÌNH RẤT LỚN */
@media(min-width:1920px){
    .tour-container{
        width:min(1840px, calc(100% - 120px)) !important;
        max-width:1840px !important;
    }

    .tour-hero-clean{
        min-height:400px !important;
    }

    .tour-hero-photo{
        min-height:400px !important;
    }

    .tour-grid{
        grid-template-columns:repeat(4,minmax(0,1fr)) !important;
        gap:30px !important;
    }
}

/* LAPTOP NHỎ */
@media(max-width:1366px){
    .tour-container{
        width:calc(100% - 36px) !important;
    }

    .tour-filter{
        grid-template-columns:repeat(4,minmax(0,1fr)) !important;
    }

    .tour-filter input[name="keyword"]{
        grid-column:span 2;
    }

    .tour-grid{
        grid-template-columns:repeat(3,minmax(0,1fr)) !important;
    }

    .tour-bottom{
        flex-direction:column;
        align-items:stretch;
    }

    .tour-actions{
        width:100%;
    }

    .tour-actions a,
    .tour-actions button{
        flex:1;
    }
}

/* TABLET */
@media(max-width:1024px){
    .tour-container{
        width:calc(100% - 28px) !important;
    }

    .tour-hero-clean{
        grid-template-columns:1fr;
    }

    .tour-hero-photo{
        min-height:280px !important;
    }

    .category-scroll{
        flex-wrap:nowrap;
        overflow-x:auto;
        scroll-snap-type:x proximity;
        padding-bottom:8px;
    }

    .category-pill{
        flex:0 0 auto;
        scroll-snap-align:start;
    }

    .tour-filter{
        grid-template-columns:repeat(3,minmax(0,1fr)) !important;
    }

    .tour-filter input[name="keyword"]{
        grid-column:1/-1;
    }

    .tour-grid{
        grid-template-columns:repeat(2,minmax(0,1fr)) !important;
    }
}

/* ĐIỆN THOẠI */
@media(max-width:640px){
    .tour-container{
        width:calc(100% - 20px) !important;
    }

    .tour-page{
        padding-top:32px !important;
    }

    .tour-hero-clean{
        border-radius:18px;
    }

    .tour-hero-text{
        padding:26px 18px !important;
    }

    .tour-hero-text h1{
        font-size:34px !important;
    }

    .tour-hero-photo{
        min-height:220px !important;
    }

    .hero-floating-card{
        left:12px;
        right:12px;
        bottom:12px;
        width:auto;
        padding:15px 16px;
    }

    .category-title{
        gap:8px;
    }

    .category-title h2{
        font-size:22px;
    }

    .tour-filter{
        grid-template-columns:1fr !important;
        padding:13px !important;
    }

    .tour-filter input[name="keyword"]{
        grid-column:auto;
    }

    .tour-grid{
        grid-template-columns:1fr !important;
    }

    .tour-card{
        border-radius:20px;
    }

    .tour-img{
        min-height:200px;
        aspect-ratio:16/10;
    }

    .tour-body{
        padding:18px 16px 20px;
    }

    .tour-body h3{
        min-height:auto;
        font-size:20px;
    }

    .tour-actions{
        flex-direction:column;
    }

    .tour-actions a,
    .tour-actions button{
        width:100%;
    }
}


/* =========================================================
   DANH MỤC TOUR MỘT HÀNG + THANH CUỘN NGANG
   ========================================================= */
.category-scroll{
    display:flex !important;
    flex-wrap:nowrap !important;
    align-items:center;
    gap:12px;
    width:100%;
    overflow-x:auto !important;
    overflow-y:hidden !important;
    padding:5px 2px 14px !important;
    scroll-behavior:smooth;
    scroll-snap-type:x proximity;
    overscroll-behavior-inline:contain;
    scrollbar-width:thin;
    scrollbar-color:#94a3b8 #e2e8f0;
}

.category-scroll::-webkit-scrollbar{
    display:block !important;
    height:8px;
}

.category-scroll::-webkit-scrollbar-track{
    background:#e2e8f0;
    border-radius:999px;
}

.category-scroll::-webkit-scrollbar-thumb{
    background:#94a3b8;
    border-radius:999px;
}

.category-scroll::-webkit-scrollbar-thumb:hover{
    background:#64748b;
}

.category-pill{
    flex:0 0 auto !important;
    scroll-snap-align:start;
    white-space:nowrap;
}

/* Giữ thanh cuộn ngang ở mọi kích thước màn hình */
@media(min-width:1025px){
    .category-scroll{
        flex-wrap:nowrap !important;
        overflow-x:auto !important;
    }
}

@media(max-width:1024px){
    .category-scroll{
        flex-wrap:nowrap !important;
        overflow-x:auto !important;
        padding-bottom:12px !important;
    }
}

@media(max-width:640px){
    .category-scroll{
        gap:9px;
        padding-bottom:10px !important;
    }

    .category-pill{
        height:54px;
        padding:7px 13px 7px 7px;
    }

    .category-scroll::-webkit-scrollbar{
        height:6px;
    }
}


/* =========================================================
   MODAL THÔNG BÁO KHI TOUR CHƯA CÓ LỊCH KHỞI HÀNH
   ========================================================= */
.booking-message-modal{
    position:fixed;
    inset:0;
    z-index:99999;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
    opacity:0;
    visibility:hidden;
    pointer-events:none;
    transition:opacity .22s ease,visibility .22s ease;
}

.booking-message-modal.show{
    opacity:1;
    visibility:visible;
    pointer-events:auto;
}

.booking-message-backdrop{
    position:absolute;
    inset:0;
    background:rgba(15,23,42,.58);
    backdrop-filter:blur(5px);
}

.booking-message-dialog{
    position:relative;
    z-index:1;
    width:min(480px,100%);
    padding:34px 32px 28px;
    border:1px solid rgba(255,255,255,.7);
    border-radius:28px;
    background:#ffffff;
    box-shadow:0 30px 90px rgba(15,23,42,.28);
    text-align:center;
    transform:translateY(18px) scale(.97);
    transition:transform .24s ease;
}

.booking-message-modal.show .booking-message-dialog{
    transform:translateY(0) scale(1);
}

.booking-message-close{
    position:absolute;
    top:14px;
    right:14px;
    width:38px;
    height:38px;
    border:0;
    border-radius:50%;
    display:grid;
    place-items:center;
    color:#64748b;
    background:#f1f5f9;
    cursor:pointer;
    transition:.2s ease;
}

.booking-message-close:hover{
    color:#ffffff;
    background:#2563eb;
    transform:rotate(5deg);
}

.booking-message-icon{
    width:76px;
    height:76px;
    margin:0 auto 18px;
    border-radius:24px;
    display:grid;
    place-items:center;
    color:#2563eb;
    background:linear-gradient(135deg,#eff6ff,#dbeafe);
    font-size:32px;
    box-shadow:0 15px 32px rgba(37,99,235,.14);
}

.booking-message-kicker{
    display:inline-flex;
    margin-bottom:10px;
    padding:7px 13px;
    border-radius:999px;
    color:#1d4ed8;
    background:#eff6ff;
    border:1px solid #bfdbfe;
    font-size:12px;
    font-weight:1000;
    text-transform:uppercase;
    letter-spacing:.45px;
}

.booking-message-dialog h3{
    margin:0 0 12px;
    color:#0f172a;
    font-size:25px;
    line-height:1.3;
    font-weight:1000;
}

.booking-message-dialog p{
    margin:0;
    color:#475569;
    font-size:15px;
    line-height:1.75;
}

.booking-message-actions{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
    margin-top:25px;
}

.booking-message-actions button,
.booking-message-actions a{
    min-height:48px;
    border-radius:14px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-family:inherit;
    font-size:14px;
    font-weight:1000;
    text-decoration:none;
    cursor:pointer;
    transition:.22s ease;
}

.booking-message-confirm{
    border:0;
    color:#ffffff;
    background:linear-gradient(135deg,#3b82f6,#1d4ed8);
    box-shadow:0 12px 24px rgba(37,99,235,.23);
}

.booking-message-actions a{
    color:#2563eb;
    background:#ffffff;
    border:1px solid #93c5fd;
}

.booking-message-actions button:hover,
.booking-message-actions a:hover{
    transform:translateY(-2px);
}

body.booking-message-open{
    overflow:hidden;
}

@media(max-width:520px){
    .booking-message-dialog{
        padding:30px 20px 22px;
        border-radius:22px;
    }

    .booking-message-dialog h3{
        font-size:22px;
    }

    .booking-message-actions{
        grid-template-columns:1fr;
    }
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


<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.favorite-form, .heart-btn').forEach(function (element) {
        element.addEventListener('click', function (event) {
            event.stopPropagation();
        });
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('bookingMessageModal');
    const title = document.getElementById('bookingMessageTitle');
    const message = document.getElementById('bookingMessageText');
    const closeButtons = modal
        ? modal.querySelectorAll('[data-close-booking-message]')
        : [];

    function openBookingMessage(button) {
        if (!modal) {
            return;
        }

        const tourName = button.dataset.tourName || 'Tour';
        const reason = button.dataset.reason
            || 'Tour hiện chưa có lịch khởi hành phù hợp.';

        title.textContent = tourName;
        message.textContent = reason;

        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('booking-message-open');

        const closeButton = modal.querySelector(
            '.booking-message-close'
        );

        if (closeButton) {
            closeButton.focus();
        }
    }

    function closeBookingMessage() {
        if (!modal) {
            return;
        }

        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('booking-message-open');
    }

    document.querySelectorAll(
        '.js-booking-unavailable'
    ).forEach(function (button) {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            openBookingMessage(button);
        });
    });

    closeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            closeBookingMessage();
        });
    });

    document.addEventListener('keydown', function (event) {
        if (
            event.key === 'Escape'
            && modal
            && modal.classList.contains('show')
        ) {
            closeBookingMessage();
        }
    });
});
</script>

@endsection