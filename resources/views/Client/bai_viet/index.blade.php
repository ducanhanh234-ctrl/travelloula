@extends('layouts.app')

@section('content')
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
                </div>
                @endif
            </a>

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

        @if($baiViets->hasPages())
        <nav class="pagination-wrap" aria-label="Phân trang bài viết">
            <div class="modern-pagination">
                {{-- Trang trước --}}
                @if($baiViets->onFirstPage())
                    <span class="page-control is-disabled" aria-disabled="true">
                        <i class="fa-solid fa-chevron-left"></i>
                        <span>Trước</span>
                    </span>
                @else
                    <a
                        class="page-control"
                        href="{{ $baiViets->previousPageUrl() }}"
                        rel="prev"
                        aria-label="Trang trước"
                    >
                        <i class="fa-solid fa-chevron-left"></i>
                        <span>Trước</span>
                    </a>
                @endif

                {{-- Danh sách số trang --}}
                @php
                    $currentPage = $baiViets->currentPage();
                    $lastPage = $baiViets->lastPage();

                    /*
                     * Hiển thị tối đa 5 số trang quanh trang hiện tại.
                     * Không gọi elements() vì đây không phải method public
                     * của paginator trong Laravel 12.
                     */
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($lastPage, $currentPage + 2);

                    if (($endPage - $startPage) < 4) {
                        if ($startPage === 1) {
                            $endPage = min($lastPage, 5);
                        } elseif ($endPage === $lastPage) {
                            $startPage = max(1, $lastPage - 4);
                        }
                    }
                @endphp

                <div class="page-numbers">
                    {{-- Luôn hiện trang đầu khi cửa sổ trang bắt đầu sau trang 1 --}}
                    @if($startPage > 1)
                        <a
                            class="page-number"
                            href="{{ $baiViets->url(1) }}"
                            aria-label="Đến trang 1"
                        >
                            1
                        </a>

                        @if($startPage > 2)
                            <span class="page-dots" aria-hidden="true">
                                <i class="fa-solid fa-ellipsis"></i>
                            </span>
                        @endif
                    @endif

                    @for($page = $startPage; $page <= $endPage; $page++)
                        @if($page === $currentPage)
                            <span
                                class="page-number is-active"
                                aria-current="page"
                            >
                                {{ $page }}
                            </span>
                        @else
                            <a
                                class="page-number"
                                href="{{ $baiViets->url($page) }}"
                                aria-label="Đến trang {{ $page }}"
                            >
                                {{ $page }}
                            </a>
                        @endif
                    @endfor

                    {{-- Luôn hiện trang cuối khi cửa sổ trang kết thúc trước trang cuối --}}
                    @if($endPage < $lastPage)
                        @if($endPage < ($lastPage - 1))
                            <span class="page-dots" aria-hidden="true">
                                <i class="fa-solid fa-ellipsis"></i>
                            </span>
                        @endif

                        <a
                            class="page-number"
                            href="{{ $baiViets->url($lastPage) }}"
                            aria-label="Đến trang {{ $lastPage }}"
                        >
                            {{ $lastPage }}
                        </a>
                    @endif
                </div>

                {{-- Trang sau --}}
                @if($baiViets->hasMorePages())
                    <a
                        class="page-control"
                        href="{{ $baiViets->nextPageUrl() }}"
                        rel="next"
                        aria-label="Trang sau"
                    >
                        <span>Sau</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                @else
                    <span class="page-control is-disabled" aria-disabled="true">
                        <span>Sau</span>
                        <i class="fa-solid fa-chevron-right"></i>
                    </span>
                @endif
            </div>

            <div class="pagination-info">
                Trang
                <strong>{{ $baiViets->currentPage() }}</strong>
                /
                <strong>{{ $baiViets->lastPage() }}</strong>
                <span>•</span>
                Tổng
                <strong>{{ number_format($baiViets->total(), 0, ',', '.') }}</strong>
                bài viết
            </div>
        </nav>
        @endif
        @else
        <div class="empty-box">
            <i class="fa-regular fa-newspaper"></i>
            <h3>Chưa có bài viết nào</h3>
            <p>Các bài viết sẽ được cập nhật trong thời gian tới.</p>
        </div>
        @endif
    </section>

</div>

<style>
    .client-news-page {
        background: #f3f6fb;
        min-height: 100vh;
    }

    .news-wrap {
        width: 100%;
        max-width: 1500px;
        margin: 0 auto;
        padding-left: 40px;
        padding-right: 40px;
    }

    .news-top {
        position: relative;
        background: linear-gradient(90deg, rgba(7, 19, 49, .86), rgba(21, 94, 239, .56)),
        url("{{ asset('images/blog-banner.jpg') }}");
        background-size: cover;
        background-position: center;
        border-bottom: 1px solid #dbe7f5;
    }

    .news-top::after {
        content: "";
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at 80% 20%, rgba(255, 255, 255, .18), transparent 35%);
        pointer-events: none;
    }

    .news-top-content {
        position: relative;
        z-index: 2;
        min-height: 330px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 36px;
    }

    .news-label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 15px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .16);
        border: 1px solid rgba(255, 255, 255, .35);
        color: #ffffff;
        font-size: 14px;
        font-weight: 900;
        margin-bottom: 18px;
        backdrop-filter: blur(8px);
    }

    .news-top h1 {
        margin: 0;
        color: #ffffff;
        font-size: 52px;
        line-height: 1.08;
        font-weight: 1000;
        letter-spacing: -1.4px;
        text-shadow: 0 12px 30px rgba(0, 0, 0, .25);
    }

    .news-top p {
        max-width: 820px;
        margin: 18px 0 0;
        color: #eaf2ff;
        font-size: 18px;
        line-height: 1.8;
        font-weight: 650;
    }

    .news-summary {
        min-width: 210px;
        padding: 28px;
        border-radius: 28px;
        background: rgba(7, 19, 49, .86);
        color: #fff;
        box-shadow: 0 24px 55px rgba(0, 0, 0, .22);
        text-align: center;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, .16);
    }

    .news-summary strong {
        display: block;
        font-size: 52px;
        line-height: 1;
        font-weight: 1000;
        color: #60a5fa;
    }

    .news-summary span {
        display: block;
        margin-top: 8px;
        font-size: 15px;
        line-height: 1.5;
        font-weight: 800;
    }

    .news-main {
        padding-top: 38px;
        padding-bottom: 80px;
    }

    .featured-row {
        display: grid;
        grid-template-columns: 46% 54%;
        overflow: hidden;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 30px;
        box-shadow: 0 24px 70px rgba(15, 23, 42, .10);
        margin-bottom: 36px;
    }

    .featured-visual {
        display: block;
        min-height: 420px;
        background: #dbeafe;
        overflow: hidden;
    }

    .featured-visual img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .visual-fallback {
        width: 100%;
        height: 100%;
        min-height: 420px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        background:
            radial-gradient(circle at 20% 20%, rgba(21, 94, 239, .24), transparent 34%),
            linear-gradient(135deg, #dbeafe, #f8fbff);
        color: #155eef;
    }

    .visual-fallback i {
        font-size: 74px;
    }

    .visual-fallback span {
        color: #071331;
        font-size: 24px;
        font-weight: 1000;
    }

    .featured-info {
        padding: 46px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .featured-tag {
        width: max-content;
        padding: 8px 14px;
        border-radius: 999px;
        background: #fff7ed;
        color: #ea580c;
        font-size: 13px;
        font-weight: 1000;
        margin-bottom: 18px;
    }

    .featured-info h2 {
        margin: 0;
        color: #071331;
        font-size: 38px;
        line-height: 1.2;
        font-weight: 1000;
        letter-spacing: -1px;
    }

    .featured-info h2 a,
    .post-content h3 a {
        color: inherit;
        text-decoration: none;
    }

    .featured-info h2 a:hover,
    .post-content h3 a:hover {
        color: #155eef;
    }

    .featured-info p {
        margin: 18px 0 0;
        color: #52637a;
        font-size: 16px;
        line-height: 1.85;
        font-weight: 600;
    }

    .meta-line {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 22px;
    }

    .meta-line span {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #64748b;
        font-size: 14px;
        font-weight: 800;
    }

    .meta-line i {
        color: #155eef;
    }

    .read-main {
        width: max-content;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 28px;
        min-height: 46px;
        padding: 0 20px;
        border-radius: 999px;
        background: #155eef;
        color: #fff;
        text-decoration: none;
        font-weight: 1000;
        box-shadow: 0 16px 32px rgba(21, 94, 239, .24);
    }

    .read-main:hover {
        color: #fff;
        background: #0f4fd1;
    }

    .section-title {
        margin: 36px 0 22px;
    }

    .section-title h2 {
        margin: 0;
        color: #071331;
        font-size: 34px;
        font-weight: 1000;
        letter-spacing: -.7px;
    }

    .section-title p {
        margin: 6px 0 0;
        color: #64748b;
        font-size: 15px;
        font-weight: 700;
    }

    .post-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 22px;
    }

    .post-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 16px 42px rgba(15, 23, 42, .075);
        transition: .25s ease;
    }

    .post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 24px 60px rgba(15, 23, 42, .12);
    }

    .post-visual {
        display: block;
        height: 165px;
        background: #eaf2ff;
        overflow: hidden;
    }

    .post-visual img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .post-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #eaf2ff, #f8fbff);
        color: #155eef;
        font-size: 42px;
    }

    .post-content {
        padding: 20px;
    }

    .post-date {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        color: #64748b;
        font-size: 12px;
        font-weight: 800;
        margin-bottom: 12px;
    }

    .post-content h3 {
        margin: 0;
        color: #071331;
        font-size: 18px;
        line-height: 1.4;
        font-weight: 1000;
    }

    .post-content p {
        margin: 10px 0 0;
        color: #64748b;
        font-size: 14px;
        line-height: 1.65;
        font-weight: 600;
    }

    .read-more {
        display: inline-flex;
        margin-top: 15px;
        color: #155eef;
        text-decoration: none;
        font-size: 14px;
        font-weight: 1000;
    }

    /* =========================================================
       PHÂN TRANG XANH - TRẮNG HIỆN ĐẠI
       ========================================================= */
    .pagination-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 14px;
        margin-top: 42px;
    }

    .modern-pagination {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        max-width: 100%;
        padding: 10px;
        border: 1px solid #dbeafe;
        border-radius: 18px;
        background: rgba(255, 255, 255, .96);
        box-shadow: 0 14px 38px rgba(37, 99, 235, .10);
        backdrop-filter: blur(12px);
    }

    .page-numbers {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
    }

    .page-number,
    .page-control,
    .page-dots {
        height: 44px;
        min-width: 44px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        font-size: 14px;
        font-weight: 900;
        text-decoration: none;
        transition:
            transform .2s ease,
            border-color .2s ease,
            background .2s ease,
            color .2s ease,
            box-shadow .2s ease;
    }

    .page-number:hover,
    .page-control:hover {
        color: #155eef;
        background: #eff6ff;
        border-color: #93c5fd;
        box-shadow: 0 8px 20px rgba(21, 94, 239, .12);
        transform: translateY(-2px);
    }

    .page-number.is-active {
        color: #ffffff;
        border-color: transparent;
        background: linear-gradient(135deg, #3b82f6, #155eef);
        box-shadow: 0 10px 24px rgba(21, 94, 239, .28);
        cursor: default;
    }

    .page-control {
        min-width: 102px;
        padding: 0 15px;
        gap: 8px;
        color: #155eef;
        border-color: #bfdbfe;
        background: #eff6ff;
    }

    .page-control i {
        font-size: 12px;
    }

    .page-control.is-disabled {
        color: #94a3b8;
        border-color: #e2e8f0;
        background: #f8fafc;
        box-shadow: none;
        cursor: not-allowed;
        opacity: .7;
    }

    .page-dots {
        min-width: 34px;
        border-color: transparent;
        color: #94a3b8;
        background: transparent;
    }

    .pagination-info {
        color: #64748b;
        font-size: 13px;
        font-weight: 750;
        text-align: center;
    }

    .pagination-info strong {
        color: #155eef;
        font-weight: 1000;
    }

    .pagination-info span {
        margin: 0 6px;
        color: #cbd5e1;
    }

    .empty-box {
        padding: 70px 24px;
        background: #fff;
        border-radius: 26px;
        border: 1px solid #e2e8f0;
        text-align: center;
    }

    .empty-box i {
        font-size: 46px;
        color: #155eef;
        margin-bottom: 14px;
    }

    .empty-box h3 {
        margin: 0 0 8px;
        color: #071331;
        font-size: 24px;
        font-weight: 1000;
    }

    .empty-box p {
        margin: 0;
        color: #64748b;
    }

    @media(max-width:1200px) {
        .post-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media(max-width:980px) {
        .news-wrap {
            padding-left: 22px;
            padding-right: 22px;
        }

        .news-top-content {
            flex-direction: column;
            align-items: flex-start;
            padding-top: 45px;
            padding-bottom: 45px;
        }

        .featured-row {
            grid-template-columns: 1fr;
        }

        .post-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media(max-width:640px) {
        .news-top h1 {
            font-size: 34px;
        }

        .modern-pagination {
            width: 100%;
            justify-content: space-between;
            gap: 6px;
            padding: 8px;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .modern-pagination::-webkit-scrollbar {
            display: none;
        }

        .page-control {
            min-width: 44px;
            width: 44px;
            padding: 0;
            flex: 0 0 44px;
        }

        .page-control span {
            display: none;
        }

        .page-numbers {
            gap: 5px;
        }

        .page-number {
            min-width: 40px;
            width: 40px;
            height: 40px;
            flex: 0 0 40px;
        }

        .page-dots {
            min-width: 28px;
            width: 28px;
            height: 40px;
            flex: 0 0 28px;
        }

        .news-top p {
            font-size: 15px;
        }

        .featured-info {
            padding: 26px;
        }

        .featured-info h2 {
            font-size: 27px;
        }

        .post-grid {
            grid-template-columns: 1fr;
        }
    }

</style>
@endsection