@extends('layouts.app')

@section('title', 'Tour yêu thích - Travelloula')

@section('content')

    <section class="wishlist-page">
        <div class="wishlist-container">

            <div class="wishlist-hero">
                <div>
                    <span class="hero-pill">
                        <i class="fa-solid fa-heart"></i>
                        Bộ sưu tập của bạn
                    </span>

                    <h1>Tour yêu thích</h1>

                    <p>
                        Lưu lại những hành trình bạn quan tâm để dễ dàng xem lại, so sánh giá và đặt tour khi sẵn sàng.
                    </p>
                </div>

                <div class="hero-summary">
                    <div class="summary-icon">
                        <i class="fa-solid fa-suitcase-rolling"></i>
                    </div>

                    <div>
                        <strong>{{ $favorites->total() }}</strong>
                        <span>Tour đã lưu</span>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert-success-custom">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            <div class="wishlist-toolbar">
                <div>
                    <span>Danh sách yêu thích</span>
                    <p>
                        Tìm thấy <strong>{{ $favorites->total() }}</strong> tour trong danh sách của bạn
                    </p>
                </div>

                <a href="{{ route('Client.danh_sach_tour.index') }}" class="explore-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Khám phá thêm tour
                </a>
            </div>

            @if ($favorites->count())
                <div class="wishlist-grid">
                    @foreach ($favorites as $favorite)
                        @php
                            $tour = $favorite->tour;

                            $fallbackImage =
                                'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=900&q=80';
                            $tourImage = $fallbackImage;

                            if ($tour && !empty($tour->anh_dai_dien)) {
                                if (\Illuminate\Support\Str::startsWith($tour->anh_dai_dien, ['http://', 'https://'])) {
                                    $tourImage = $tour->anh_dai_dien;
                                } else {
                                    $tourImage = asset($tour->anh_dai_dien);
                                }
                            }

                            $lichGanNhat = $tour
                                ? $tour->lichKhoiHanhTours
                                    ->where('trang_thai', 'available')
                                    ->sortBy('ngay_khoi_hanh')
                                    ->first()
                                : null;
                        @endphp

                        @if ($tour)
                            <article class="wishlist-card">
                                <div class="tour-image-box">
                                    <img src="{{ $tourImage }}" alt="{{ $tour->ten_tour }}"
                                        onerror="this.onerror=null;this.src='{{ $fallbackImage }}';">

                                    <span class="favorite-badge">
                                        <i class="fa-solid fa-heart"></i>
                                        Yêu thích
                                    </span>

                                    <form action="{{ route('Client.tour_yeu_thich.destroy', $tour->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn muốn xóa tour này khỏi danh sách yêu thích?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="delete-btn" title="Xóa khỏi yêu thích">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="tour-content">
                                    <div class="tour-category">
                                        {{ $tour->danhMuc->ten_danh_muc ?? 'Tour du lịch' }}
                                    </div>

                                    <h3>{{ $tour->ten_tour }}</h3>

                                    <div class="tour-meta">
                                        <span>
                                            <i class="fa-solid fa-location-dot"></i>
                                            {{ $tour->diem_den ?? 'Đang cập nhật' }}
                                        </span>

                                        <span>
                                            <i class="fa-regular fa-clock"></i>
                                            {{ $tour->thoi_luong ?? 'Đang cập nhật' }}
                                        </span>

                                        <span>
                                            <i class="fa-solid fa-users"></i>
                                            {{ $tour->so_khach_toi_da ?? 0 }} khách
                                        </span>

                                        <span>
                                            <i class="fa-solid fa-car"></i>
                                            {{ $tour->phuong_tien ?? 'Đang cập nhật' }}
                                        </span>
                                    </div>

                                    @if ($lichGanNhat)
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
                                        <div>
                                            <small>Chỉ từ</small>
                                            <strong>{{ number_format($tour->gia_tour ?? 0, 0, ',', '.') }}đ</strong>
                                        </div>

                                        <div class="tour-actions">
                                            <a href="{{ route('Client.danh_sach_tour.show', $tour->id) }}"
                                                class="detail-btn">
                                                Xem chi tiết
                                            </a>

                                            <a href="{{ route('Client.danh_sach_tour.show', $tour->id) }}#dat-tour"
                                                class="book-btn">
                                                Đặt tour
                                            </a>
                                        </div>
                                    </div>

                                    <div class="saved-date">
                                        <i class="fa-regular fa-clock"></i>
                                        Đã lưu ngày
                                        {{ $favorite->created_at ? $favorite->created_at->format('d/m/Y') : 'đang cập nhật' }}
                                    </div>
                                </div>
                            </article>
                        @endif
                    @endforeach
                </div>

                <div class="pagination-wrap">
                    {{ $favorites->onEachSide(1)->links() }}
                </div>
            @else
                <div class="empty-wishlist">
                    <div class="empty-icon">
                        <i class="fa-regular fa-heart"></i>
                    </div>

                    <h2>Bạn chưa có tour yêu thích</h2>

                    <p>
                        Hãy khám phá các hành trình hấp dẫn và bấm biểu tượng trái tim
                        để lưu tour vào danh sách yêu thích.
                    </p>

                    <a href="{{ route('Client.danh_sach_tour.index') }}">
                        <i class="fa-solid fa-map-location-dot"></i>
                        Khám phá tour ngay
                    </a>
                </div>
            @endif

        </div>
    </section>

    <style>
        :root {
            --primary: #0757d8;
            --primary-dark: #0043b8;
            --primary-soft: #eaf2ff;
            --orange: #ff5a1f;
            --pink: #ff2f6d;
            --text: #0b1226;
            --muted: #64748b;
            --line: #e2e8f0;
            --white: #ffffff;
        }

        * {
            box-sizing: border-box;
        }

        .wishlist-page {
            min-height: 100vh;
            padding: 86px 0 90px;
            background:
                radial-gradient(circle at 7% 7%, rgba(7, 87, 216, .16), transparent 30%),
                radial-gradient(circle at 94% 8%, rgba(255, 214, 41, .22), transparent 32%),
                linear-gradient(180deg, #f8fbff 0%, #edf5ff 55%, #f8fbff 100%);
        }

        .wishlist-container {
            width: min(1660px, calc(100% - 40px));
            margin: 0 auto;
        }

        .wishlist-hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
            padding: 46px 52px;
            border-radius: 34px;
            background:
                linear-gradient(135deg, rgba(255, 255, 255, .96), rgba(255, 255, 255, .86)),
                url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
            border: 1px solid rgba(226, 232, 240, .92);
            box-shadow: 0 28px 80px rgba(15, 23, 42, .12);
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
        }

        .wishlist-hero::after {
            content: "";
            position: absolute;
            right: -80px;
            top: -80px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            background: rgba(7, 87, 216, .10);
        }

        .hero-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            height: 38px;
            padding: 0 16px;
            border-radius: 999px;
            background: rgba(255, 47, 109, .10);
            border: 1px solid rgba(255, 47, 109, .22);
            color: var(--pink);
            font-weight: 1000;
            margin-bottom: 16px;
        }

        .wishlist-hero h1 {
            margin: 0;
            color: var(--text);
            font-size: clamp(42px, 4.6vw, 64px);
            line-height: 1.05;
            font-weight: 1000;
            letter-spacing: -2px;
        }

        .wishlist-hero p {
            max-width: 720px;
            margin: 16px 0 0;
            color: #53627a;
            font-size: 17px;
            line-height: 1.7;
        }

        .hero-summary {
            min-width: 260px;
            padding: 22px;
            border-radius: 26px;
            background: #fff;
            border: 1px solid #e5eef9;
            box-shadow: 0 20px 48px rgba(15, 23, 42, .12);
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            z-index: 2;
        }

        .summary-icon {
            width: 62px;
            height: 62px;
            border-radius: 20px;
            display: grid;
            place-items: center;
            background: #eff6ff;
            color: var(--primary);
            font-size: 28px;
        }

        .hero-summary strong {
            display: block;
            color: var(--primary);
            font-size: 34px;
            font-weight: 1000;
            line-height: 1;
        }

        .hero-summary span {
            display: block;
            color: #64748b;
            font-weight: 850;
            margin-top: 6px;
        }

        .alert-success-custom {
            margin: 0 auto 22px;
            padding: 15px 18px;
            border-radius: 18px;
            background: #ecfdf5;
            border: 1px solid #bbf7d0;
            color: #047857;
            font-weight: 900;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .wishlist-toolbar {
            margin: 0 0 26px;
            padding: 18px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            background: rgba(255, 255, 255, .88);
            border: 1px solid rgba(226, 232, 240, .95);
            border-radius: 22px;
            box-shadow: 0 14px 34px rgba(15, 23, 42, .07);
        }

        .wishlist-toolbar span {
            display: inline-flex;
            align-items: center;
            height: 34px;
            padding: 0 14px;
            border-radius: 999px;
            background: #eff6ff;
            color: var(--primary);
            font-size: 13px;
            font-weight: 1000;
        }

        .wishlist-toolbar p {
            margin: 8px 0 0;
            color: #475569;
            font-size: 15px;
            font-weight: 850;
        }

        .wishlist-toolbar strong {
            color: var(--primary);
            font-size: 22px;
            font-weight: 1000;
        }

        .explore-btn {
            height: 46px;
            padding: 0 18px;
            border-radius: 999px;
            background: linear-gradient(135deg, #0867ff, #0047c6);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 1000;
            white-space: nowrap;
            box-shadow: 0 14px 28px rgba(7, 87, 216, .24);
            transition: .25s ease;
            text-decoration: none;
        }

        .explore-btn:hover {
            color: #fff;
            transform: translateY(-2px);
        }

        .wishlist-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 34px;
        }

        .wishlist-card {
            background: #fff;
            border-radius: 30px;
            overflow: hidden;
            border: 1px solid rgba(226, 232, 240, .9);
            box-shadow: 0 26px 60px rgba(15, 23, 42, .10);
            transition: .32s ease;
        }

        .wishlist-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 34px 82px rgba(15, 23, 42, .16);
        }

        .tour-image-box {
            height: 285px;
            position: relative;
            overflow: hidden;
            background: #eaf2ff;
        }

        .tour-image-box::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            background: linear-gradient(180deg, rgba(15, 23, 42, .02), rgba(15, 23, 42, .35));
        }

        .tour-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: .45s ease;
        }

        .wishlist-card:hover .tour-image-box img {
            transform: scale(1.08);
        }

        .favorite-badge {
            position: absolute;
            z-index: 2;
            top: 18px;
            left: 18px;
            height: 36px;
            padding: 0 15px;
            border-radius: 999px;
            background: linear-gradient(135deg, #ff2f6d, #e11d48);
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            font-size: 13px;
            font-weight: 1000;
            box-shadow: 0 12px 26px rgba(225, 29, 72, .25);
        }

        .delete-btn {
            position: absolute;
            z-index: 3;
            top: 18px;
            right: 18px;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .8);
            background: rgba(255, 255, 255, .96);
            color: #e11d48;
            display: grid;
            place-items: center;
            cursor: pointer;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .16);
            transition: .25s ease;
        }

        .delete-btn:hover {
            background: #e11d48;
            color: #fff;
            transform: scale(1.08);
        }

        .tour-content {
            padding: 26px 28px 24px;
        }

        .tour-category {
            width: max-content;
            max-width: 100%;
            padding: 7px 13px;
            border-radius: 999px;
            background: #eff6ff;
            color: var(--primary);
            font-size: 12px;
            font-weight: 1000;
            margin-bottom: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .tour-content h3 {
            margin: 0 0 16px;
            min-height: 64px;
            color: #071126;
            font-size: 24px;
            line-height: 1.32;
            font-weight: 1000;
            letter-spacing: -.5px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .tour-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 11px;
            margin: 0 0 18px;
        }

        .tour-meta span {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(180deg, #f8fbff, #f3f7fc);
            border: 1px solid #e6edf7;
            border-radius: 16px;
            color: #253858;
            font-size: 13px;
            font-weight: 850;
            padding: 11px 12px;
        }

        .tour-meta i {
            color: var(--primary);
        }

        .start-date {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px 16px;
            border-radius: 18px;
            background: linear-gradient(135deg, rgba(7, 87, 216, .09), rgba(255, 255, 255, .9));
            border: 1px solid rgba(7, 87, 216, .16);
            color: #071126;
            font-size: 14px;
            font-weight: 900;
            margin-bottom: 18px;
        }

        .start-date i {
            color: var(--primary);
        }

        .start-date.muted {
            background: #f8fafc;
            color: #64748b;
            border-color: #e2e8f0;
        }

        .tour-bottom {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 14px;
            padding-top: 18px;
            border-top: 1px dashed #d7e3f3;
        }

        .tour-bottom small {
            display: block;
            color: #64748b;
            font-size: 13px;
            font-weight: 900;
            margin-bottom: 4px;
        }

        .tour-bottom strong {
            display: block;
            color: var(--orange);
            font-size: 28px;
            line-height: 1.1;
            font-weight: 1000;
        }

        .tour-actions {
            display: flex;
            gap: 9px;
            flex: 0 0 auto;
        }

        .tour-actions a {
            height: 44px;
            padding: 0 15px;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 1000;
            white-space: nowrap;
            transition: .25s ease;
            text-decoration: none;
        }

        .detail-btn {
            color: var(--primary);
            background: #fff;
            border: 1.6px solid var(--primary);
        }

        .detail-btn:hover {
            background: #eff6ff;
        }

        .book-btn {
            color: #fff;
            background: linear-gradient(135deg, #0867ff, #0047c6);
            border: 1.6px solid var(--primary);
            box-shadow: 0 12px 24px rgba(7, 87, 216, .22);
        }

        .book-btn:hover {
            color: #fff;
            transform: translateY(-2px);
        }

        .saved-date {
            margin-top: 16px;
            color: #64748b;
            font-size: 13px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .empty-wishlist {
            margin: 0 auto;
            padding: 72px 28px;
            border-radius: 30px;
            background: rgba(255, 255, 255, .92);
            border: 1px solid rgba(226, 232, 240, .95);
            box-shadow: 0 24px 70px rgba(15, 23, 42, .10);
            text-align: center;
        }

        .empty-icon {
            width: 88px;
            height: 88px;
            margin: 0 auto 22px;
            border-radius: 50%;
            display: grid;
            place-items: center;
            background: #fff1f2;
            color: #e11d48;
            font-size: 42px;
        }

        .empty-wishlist h2 {
            margin: 0 0 12px;
            color: var(--text);
            font-size: 34px;
            font-weight: 1000;
        }

        .empty-wishlist p {
            max-width: 620px;
            margin: 0 auto 26px;
            color: #64748b;
            font-size: 16px;
            line-height: 1.7;
        }

        .empty-wishlist a {
            height: 50px;
            padding: 0 22px;
            border-radius: 999px;
            background: linear-gradient(135deg, #0867ff, #0047c6);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            font-weight: 1000;
            box-shadow: 0 14px 28px rgba(7, 87, 216, .24);
            text-decoration: none;
        }

        .pagination-wrap {
            margin-top: 44px;
            display: flex;
            justify-content: center;
        }

        .pagination-wrap nav {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .pagination-wrap p,
        .pagination-wrap .text-sm,
        .pagination-wrap nav>div:first-child {
            display: none !important;
        }

        .pagination-wrap .pagination {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            margin: 0;
            padding: 0;
        }

        .pagination-wrap .page-item {
            list-style: none;
        }

        .pagination-wrap .page-link {
            min-width: 46px;
            height: 46px;
            padding: 0 14px;
            border-radius: 15px !important;
            border: 1px solid #dce7f5 !important;
            background: #fff !important;
            color: #0f172a !important;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 1000;
            text-decoration: none;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .08);
        }

        .pagination-wrap .page-item.active .page-link {
            background: linear-gradient(135deg, #0867ff, #0047c6) !important;
            border-color: var(--primary) !important;
            color: #fff !important;
        }

        @media(max-width:1300px) {
            .wishlist-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media(max-width:900px) {

            .wishlist-hero,
            .wishlist-toolbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .hero-summary {
                width: 100%;
            }

            .wishlist-grid {
                grid-template-columns: 1fr;
            }

            .tour-image-box {
                height: 250px;
            }
        }

        @media(max-width:560px) {
            .wishlist-page {
                padding: 62px 0 72px;
            }

            .wishlist-container {
                width: calc(100% - 24px);
            }

            .wishlist-hero {
                padding: 32px 22px;
                border-radius: 24px;
            }

            .wishlist-hero h1 {
                letter-spacing: -1px;
            }

            .wishlist-toolbar {
                border-radius: 18px;
            }

            .explore-btn {
                width: 100%;
            }

            .tour-content {
                padding: 22px 20px;
            }

            .tour-content h3 {
                min-height: auto;
                font-size: 21px;
            }

            .tour-meta {
                grid-template-columns: 1fr;
            }

            .tour-bottom {
                flex-direction: column;
                align-items: flex-start;
            }

            .tour-actions {
                width: 100%;
                flex-direction: column;
            }

            .tour-actions a {
                width: 100%;
            }

            .empty-wishlist h2 {
                font-size: 28px;
            }
        }
    </style>

@endsection
