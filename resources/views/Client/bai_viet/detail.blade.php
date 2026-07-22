@extends('layouts.app')

@section('title', ($baiViet->tieu_de ?? 'Chi tiết bài viết') . ' - Travelloula')

@section('content')
@php
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Str;

    /*
    |--------------------------------------------------------------------------
    | Chuẩn hóa dữ liệu
    |--------------------------------------------------------------------------
    */

    $relatedPosts = $baiVietLienQuans
        ?? $baiVietLienQuan
        ?? $baiVietsLienQuan
        ?? collect();

    if ($relatedPosts instanceof \Illuminate\Database\Eloquent\Model) {
        $relatedPosts = collect([$relatedPosts]);
    }

    if (!($relatedPosts instanceof \Illuminate\Support\Collection)) {
        $relatedPosts = collect($relatedPosts ?? []);
    }

    $resolveImage = function (?string $path): ?string {
        if (blank($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    };

    /*
     * Tạo URL bài viết liên quan theo đúng route của dự án.
     * Route hiện tại: Client.bai_viet.detail
     * Tham số: {duongDan}
     */
    $articleUrl = function ($article): string {
        if (Route::has('Client.bai_viet.detail')) {
            return route('Client.bai_viet.detail', [
                'duongDan' => $article->duong_dan,
            ]);
        }

        if (Route::has('Client.bai_viet.show')) {
            return route('Client.bai_viet.show', [
                'duongDan' => $article->duong_dan,
            ]);
        }

        return url('/bai_viet/' . $article->duong_dan);
    };

    $indexUrl = Route::has('Client.bai_viet.index')
        ? route('Client.bai_viet.index')
        : (Route::has('Client.bai_viets.index')
            ? route('Client.bai_viets.index')
            : url('/bai-viet'));

    /*
     * html_entity_decode xử lý cả trường hợp nội dung trong database đang là:
     * &lt;h2&gt;Tiêu đề&lt;/h2&gt;
     *
     * {!! !!} giúp trình duyệt dựng đúng thẻ HTML thay vì hiện nguyên <h2>, <p>.
     */
    $articleHtml = html_entity_decode(
        (string) ($baiViet->noi_dung ?? ''),
        ENT_QUOTES | ENT_HTML5,
        'UTF-8'
    );

    $mainImage = $resolveImage($baiViet->anh_dai_dien ?? null);
    $publishedAt = $baiViet->created_at
        ? \Carbon\Carbon::parse($baiViet->created_at)
        : null;

    $readingText = trim(strip_tags($articleHtml));
    $wordCount = str_word_count($readingText);
    $readingMinutes = max(1, (int) ceil($wordCount / 220));
@endphp

<section class="article-page">
    <div class="article-shell">

        <nav class="article-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">
                <i class="fa-solid fa-house"></i>
                Trang chủ
            </a>

            <span>/</span>

            <a href="{{ $indexUrl }}">Bài viết</a>

            <span>/</span>

            <strong>{{ Str::limit($baiViet->tieu_de ?? 'Chi tiết bài viết', 60) }}</strong>
        </nav>

        <header class="article-hero">
            <div class="article-hero-content">
                <span class="article-label">
                    <i class="fa-regular fa-newspaper"></i>
                    Cẩm nang du lịch
                </span>

                <h1>{{ $baiViet->tieu_de }}</h1>

                @if(!blank($baiViet->mo_ta_ngan))
                    <p class="article-summary">
                        {{ $baiViet->mo_ta_ngan }}
                    </p>
                @endif

                <div class="article-meta">
                    <span>
                        <i class="fa-solid fa-user-pen"></i>
                        {{ $baiViet->tac_gia ?: 'Travelloula' }}
                    </span>

                    <span>
                        <i class="fa-regular fa-calendar"></i>
                        {{ $publishedAt?->format('d/m/Y') ?? 'Đang cập nhật' }}
                    </span>

                    <span>
                        <i class="fa-regular fa-clock"></i>
                        {{ $readingMinutes }} phút đọc
                    </span>

                    <span>
                        <i class="fa-regular fa-eye"></i>
                        {{ number_format((int) ($baiViet->luot_xem ?? 0), 0, ',', '.') }} lượt xem
                    </span>
                </div>
            </div>

            @if($mainImage)
                <div class="article-cover">
                    <img
                        src="{{ $mainImage }}"
                        alt="{{ $baiViet->tieu_de }}"
                        loading="eager"
                        decoding="async"
                        onerror="this.closest('.article-cover').classList.add('is-error');this.remove();"
                    >

                    <div class="article-cover-placeholder">
                        <i class="fa-regular fa-image"></i>
                        <span>Ảnh bài viết đang được cập nhật</span>
                    </div>
                </div>
            @else
                <div class="article-cover is-error">
                    <div class="article-cover-placeholder">
                        <i class="fa-regular fa-image"></i>
                        <span>Ảnh bài viết đang được cập nhật</span>
                    </div>
                </div>
            @endif
        </header>

        <div class="article-layout">
            <main class="article-main">
                <article class="article-card">
                    @if(blank($articleHtml))
                        <div class="article-empty">
                            <i class="fa-regular fa-file-lines"></i>
                            <strong>Nội dung đang được cập nhật</strong>
                            <p>Vui lòng quay lại sau để xem bài viết đầy đủ.</p>
                        </div>
                    @else
                        <div class="article-content">
                            {!! $articleHtml !!}
                        </div>
                    @endif

                    <footer class="article-footer">
                        <div>
                            <span>Chia sẻ bài viết</span>

                            <div
                                class="article-share"
                                id="articleShare"
                                data-url="{{ request()->fullUrl() }}"
                                data-title="{{ $baiViet->tieu_de }}"
                                data-text="{{ $baiViet->mo_ta_ngan ?: $baiViet->tieu_de }}"
                            >
                                <button
                                    type="button"
                                    class="share-button facebook"
                                    data-platform="facebook"
                                    aria-label="Chia sẻ Facebook"
                                    title="Chia sẻ Facebook"
                                >
                                    <i class="fa-brands fa-facebook-f"></i>
                                    <span>Facebook</span>
                                </button>

                                <button
                                    type="button"
                                    class="share-button zalo"
                                    data-platform="zalo"
                                    aria-label="Chia sẻ Zalo"
                                    title="Chia sẻ Zalo"
                                >
                                    <strong>Z</strong>
                                    <span>Zalo</span>
                                </button>

                                <button
                                    type="button"
                                    class="share-button tiktok"
                                    data-platform="tiktok"
                                    aria-label="Chia sẻ TikTok"
                                    title="Chia sẻ TikTok"
                                >
                                    <i class="fa-brands fa-tiktok"></i>
                                    <span>TikTok</span>
                                </button>

                                <button
                                    type="button"
                                    class="share-button instagram"
                                    data-platform="instagram"
                                    aria-label="Chia sẻ Instagram"
                                    title="Chia sẻ Instagram"
                                >
                                    <i class="fa-brands fa-instagram"></i>
                                    <span>Instagram</span>
                                </button>

                                <button
                                    type="button"
                                    class="share-button copy"
                                    data-platform="copy"
                                    aria-label="Sao chép liên kết"
                                    title="Sao chép liên kết"
                                >
                                    <i class="fa-solid fa-link"></i>
                                    <span>Sao chép</span>
                                </button>
                            </div>
                        </div>

                        <a href="{{ $indexUrl }}" class="article-back">
                            <i class="fa-solid fa-arrow-left"></i>
                            Xem tất cả bài viết
                        </a>
                    </footer>
                </article>
            </main>

            <aside class="article-sidebar">
                <section class="sidebar-card article-info-card">
                    <h2>Thông tin bài viết</h2>

                    <dl>
                        <div>
                            <dt>Tác giả</dt>
                            <dd>{{ $baiViet->tac_gia ?: 'Travelloula' }}</dd>
                        </div>

                        <div>
                            <dt>Ngày đăng</dt>
                            <dd>{{ $publishedAt?->format('d/m/Y') ?? 'Đang cập nhật' }}</dd>
                        </div>

                        <div>
                            <dt>Thời gian đọc</dt>
                            <dd>{{ $readingMinutes }} phút</dd>
                        </div>

                        <div>
                            <dt>Lượt xem</dt>
                            <dd>{{ number_format((int) ($baiViet->luot_xem ?? 0), 0, ',', '.') }}</dd>
                        </div>
                    </dl>
                </section>

                <section class="sidebar-card related-card">
                    <div class="sidebar-title">
                        <div>
                            <span>Gợi ý cho bạn</span>
                            <h2>Bài viết liên quan</h2>
                        </div>

                        <i class="fa-regular fa-compass"></i>
                    </div>

                    <div class="related-list">
                        @forelse($relatedPosts->take(5) as $item)
                            @php
                                $relatedImage = $resolveImage($item->anh_dai_dien ?? null);
                                $relatedDate = $item->created_at
                                    ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y')
                                    : null;
                            @endphp

                            <a href="{{ $articleUrl($item) }}" class="related-item">
                                <div class="related-image {{ $relatedImage ? '' : 'is-error' }}">
                                    @if($relatedImage)
                                        <img
                                            src="{{ $relatedImage }}"
                                            alt="{{ $item->tieu_de }}"
                                            loading="lazy"
                                            decoding="async"
                                            onerror="this.closest('.related-image').classList.add('is-error');this.remove();"
                                        >
                                    @endif

                                    <span class="related-placeholder">
                                        <i class="fa-regular fa-image"></i>
                                    </span>
                                </div>

                                <div class="related-content">
                                    <h3>{{ $item->tieu_de }}</h3>

                                    <div>
                                        @if($relatedDate)
                                            <span>
                                                <i class="fa-regular fa-calendar"></i>
                                                {{ $relatedDate }}
                                            </span>
                                        @endif

                                        <span>
                                            <i class="fa-regular fa-eye"></i>
                                            {{ number_format((int) ($item->luot_xem ?? 0), 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="related-empty">
                                <i class="fa-regular fa-newspaper"></i>
                                <p>Chưa có bài viết liên quan.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </aside>
        </div>
    </div>
</section>

<div class="copy-toast" id="copyToast">
    <i class="fa-solid fa-circle-check"></i>
    <span id="copyToastText">Đã sao chép liên kết bài viết</span>
</div>

<style>
:root{
    --article-primary:#0757d8;
    --article-primary-dark:#0043b8;
    --article-primary-soft:#eff6ff;
    --article-text:#0f172a;
    --article-body:#334155;
    --article-muted:#64748b;
    --article-line:#e2e8f0;
    --article-bg:#f5f8fd;
    --article-white:#ffffff;
    --article-shadow:0 18px 50px rgba(15,23,42,.08);
}

*{
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

.article-page{
    min-height:100vh;
    padding:38px 0 80px;
    color:var(--article-text);
    background:
        radial-gradient(circle at top left,rgba(59,130,246,.08),transparent 28%),
        var(--article-bg);
}

.article-shell{
    width:min(1500px,calc(100% - 40px));
    margin:0 auto;
}

.article-breadcrumb{
    display:flex;
    align-items:center;
    gap:9px;
    margin-bottom:20px;
    color:var(--article-muted);
    font-size:14px;
    flex-wrap:wrap;
}

.article-breadcrumb a{
    display:inline-flex;
    align-items:center;
    gap:7px;
    color:var(--article-primary);
    font-weight:800;
    text-decoration:none;
}

.article-breadcrumb strong{
    max-width:600px;
    color:var(--article-text);
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.article-hero{
    position:relative;
    overflow:hidden;
    display:grid;
    grid-template-columns:minmax(0,1.04fr) minmax(420px,.96fr);
    min-height:470px;
    border:1px solid #dbe7f6;
    border-radius:28px;
    background:var(--article-white);
    box-shadow:var(--article-shadow);
}

.article-hero::before{
    content:"";
    position:absolute;
    top:-130px;
    left:-120px;
    width:360px;
    height:360px;
    border-radius:50%;
    background:rgba(59,130,246,.09);
    pointer-events:none;
}

.article-hero-content{
    position:relative;
    z-index:2;
    display:flex;
    flex-direction:column;
    justify-content:center;
    padding:clamp(34px,4vw,68px);
}

.article-label{
    width:max-content;
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-bottom:18px;
    padding:9px 14px;
    border-radius:999px;
    color:var(--article-primary);
    background:var(--article-primary-soft);
    border:1px solid #bfdbfe;
    font-size:12px;
    font-weight:900;
    letter-spacing:.5px;
    text-transform:uppercase;
}

.article-hero h1{
    margin:0;
    max-width:820px;
    color:var(--article-text);
    font-size:clamp(34px,3.4vw,62px);
    line-height:1.08;
    letter-spacing:-1.5px;
    font-weight:1000;
}

.article-summary{
    max-width:800px;
    margin:22px 0 0;
    color:var(--article-body);
    font-size:clamp(16px,1.15vw,20px);
    line-height:1.75;
}

.article-meta{
    display:flex;
    align-items:center;
    flex-wrap:wrap;
    gap:10px;
    margin-top:28px;
}

.article-meta span{
    display:inline-flex;
    align-items:center;
    gap:7px;
    padding:9px 12px;
    border:1px solid var(--article-line);
    border-radius:999px;
    color:var(--article-muted);
    background:#fff;
    font-size:13px;
    font-weight:800;
}

.article-meta i{
    color:var(--article-primary);
}

.article-cover{
    position:relative;
    min-height:470px;
    overflow:hidden;
    background:linear-gradient(135deg,#dbeafe,#eff6ff);
}

.article-cover img{
    position:absolute;
    inset:0;
    z-index:2;
    width:100%;
    height:100%;
    display:block;
    object-fit:cover;
}

.article-cover::after{
    content:"";
    position:absolute;
    inset:0;
    z-index:3;
    background:linear-gradient(90deg,rgba(255,255,255,.20),transparent 30%);
    pointer-events:none;
}

.article-cover-placeholder{
    position:absolute;
    inset:0;
    z-index:1;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:12px;
    color:#5b7cad;
}

.article-cover-placeholder i{
    font-size:54px;
}

.article-cover-placeholder span{
    font-weight:900;
}

.article-cover.is-error img{
    display:none;
}

.article-layout{
    display:grid;
    grid-template-columns:minmax(0,1fr) 360px;
    gap:28px;
    align-items:start;
    margin-top:30px;
}

.article-main,
.article-sidebar{
    min-width:0;
}

.article-card,
.sidebar-card{
    border:1px solid #e2e8f0;
    border-radius:22px;
    background:#fff;
    box-shadow:0 12px 36px rgba(15,23,42,.06);
}

.article-card{
    padding:clamp(24px,3vw,48px);
}

/* =========================================================
   NỘI DUNG BÀI VIẾT
   ========================================================= */

.article-content{
    color:var(--article-body);
    font-size:17px;
    line-height:1.9;
    overflow-wrap:anywhere;
}

.article-content > *:first-child{
    margin-top:0 !important;
}

.article-content > *:last-child{
    margin-bottom:0 !important;
}

.article-content h1,
.article-content h2,
.article-content h3,
.article-content h4{
    color:var(--article-text);
    line-height:1.35;
    font-weight:950;
}

.article-content h1{
    margin:38px 0 18px;
    font-size:32px;
}

.article-content h2{
    position:relative;
    margin:38px 0 18px;
    padding:18px 22px 18px 28px;
    border:1px solid #bfdbfe;
    border-radius:16px;
    color:#0f2b5d;
    background:linear-gradient(135deg,#eff6ff,#f8fbff);
    font-size:25px;
    box-shadow:0 8px 24px rgba(7,87,216,.05);
}

.article-content h2::before{
    content:"";
    position:absolute;
    top:16px;
    bottom:16px;
    left:0;
    width:5px;
    border-radius:0 999px 999px 0;
    background:linear-gradient(180deg,var(--article-primary),#38bdf8);
}

.article-content h3{
    margin:30px 0 14px;
    color:var(--article-primary);
    font-size:21px;
}

.article-content h4{
    margin:24px 0 12px;
    font-size:18px;
}

.article-content p{
    margin:0 0 20px;
    color:var(--article-body);
    font-size:17px;
    line-height:1.9;
}

.article-content ul,
.article-content ol{
    margin:14px 0 24px;
    padding:18px 22px 18px 46px;
    border:1px solid #e2e8f0;
    border-radius:14px;
    background:#f8fafc;
}

.article-content li{
    margin-bottom:10px;
    padding-left:4px;
    color:var(--article-body);
    line-height:1.75;
}

.article-content li:last-child{
    margin-bottom:0;
}

.article-content li::marker{
    color:var(--article-primary);
    font-weight:900;
}

.article-content strong,
.article-content b{
    color:var(--article-text);
    font-weight:900;
}

.article-content a{
    color:var(--article-primary);
    font-weight:800;
    text-decoration-thickness:1px;
    text-underline-offset:3px;
}

.article-content blockquote{
    position:relative;
    margin:28px 0;
    padding:22px 24px 22px 58px;
    border:1px solid #bfdbfe;
    border-radius:16px;
    color:#1e3a5f;
    background:#eff6ff;
    font-style:italic;
}

.article-content blockquote::before{
    content:"“";
    position:absolute;
    top:3px;
    left:19px;
    color:var(--article-primary);
    font-size:58px;
    line-height:1;
    font-weight:1000;
}

.article-content img{
    display:block;
    width:100%;
    max-height:650px;
    margin:28px auto;
    border-radius:18px;
    object-fit:cover;
    box-shadow:0 18px 42px rgba(15,23,42,.12);
}

.article-content figure{
    margin:28px 0;
}

.article-content figure img{
    margin:0;
}

.article-content figcaption{
    margin-top:10px;
    color:var(--article-muted);
    text-align:center;
    font-size:13px;
    font-style:italic;
}

.article-content table{
    width:100%;
    margin:24px 0;
    border-collapse:collapse;
    overflow:hidden;
    border-radius:14px;
}

.article-content th,
.article-content td{
    padding:14px 16px;
    border:1px solid var(--article-line);
    text-align:left;
    vertical-align:top;
}

.article-content th{
    color:var(--article-text);
    background:#eff6ff;
    font-weight:900;
}

.article-empty{
    min-height:360px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:8px;
    text-align:center;
    color:var(--article-muted);
}

.article-empty i{
    margin-bottom:8px;
    color:#93c5fd;
    font-size:52px;
}

.article-empty strong{
    color:var(--article-text);
    font-size:20px;
}

.article-empty p{
    margin:0;
}

.article-footer{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    margin-top:38px;
    padding-top:24px;
    border-top:1px solid var(--article-line);
}

.article-footer > div > span{
    display:block;
    margin-bottom:10px;
    color:var(--article-muted);
    font-size:12px;
    font-weight:900;
    text-transform:uppercase;
    letter-spacing:.7px;
}

.article-share{
    display:flex;
    flex-wrap:wrap;
    gap:9px;
}

.share-button{
    min-height:42px;
    padding:0 13px;
    border:1px solid #dbeafe;
    border-radius:11px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:7px;
    color:var(--article-primary);
    background:#eff6ff;
    font-family:inherit;
    font-size:12px;
    font-weight:900;
    cursor:pointer;
    transition:.2s ease;
}

.share-button:hover{
    color:#fff;
    transform:translateY(-2px);
    box-shadow:0 9px 20px rgba(15,23,42,.12);
}

.share-button.facebook:hover{
    border-color:#1877f2;
    background:#1877f2;
}

.share-button.zalo strong{
    width:20px;
    height:20px;
    border-radius:6px;
    display:grid;
    place-items:center;
    color:#fff;
    background:#0068ff;
    font-size:12px;
    line-height:1;
}

.share-button.zalo:hover{
    border-color:#0068ff;
    background:#0068ff;
}

.share-button.zalo:hover strong{
    color:#0068ff;
    background:#fff;
}

.share-button.tiktok:hover{
    border-color:#111827;
    background:#111827;
}

.share-button.instagram:hover{
    border-color:#c13584;
    background:linear-gradient(135deg,#f58529,#dd2a7b,#8134af);
}

.share-button.copy:hover{
    border-color:var(--article-primary);
    background:var(--article-primary);
}

.article-back{
    min-height:44px;
    padding:0 17px;
    border-radius:11px;
    display:inline-flex;
    align-items:center;
    gap:8px;
    color:#fff;
    background:linear-gradient(135deg,var(--article-primary),var(--article-primary-dark));
    font-size:13px;
    font-weight:900;
    text-decoration:none;
}

.article-sidebar{
    position:sticky;
    top:96px;
    display:grid;
    gap:20px;
}

.sidebar-card{
    padding:22px;
}

.sidebar-card h2{
    margin:0;
    color:var(--article-text);
    font-size:21px;
    font-weight:950;
}

.article-info-card dl{
    margin:18px 0 0;
}

.article-info-card dl > div{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;
    padding:15px 0;
    border-bottom:1px solid var(--article-line);
}

.article-info-card dl > div:first-child{
    padding-top:0;
}

.article-info-card dl > div:last-child{
    padding-bottom:0;
    border-bottom:0;
}

.article-info-card dt{
    color:var(--article-muted);
    font-size:13px;
    font-weight:850;
}

.article-info-card dd{
    margin:0;
    color:var(--article-text);
    text-align:right;
    font-size:13px;
    font-weight:950;
}

.sidebar-title{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    padding-bottom:16px;
    border-bottom:1px solid var(--article-line);
}

.sidebar-title span{
    display:block;
    margin-bottom:4px;
    color:var(--article-primary);
    font-size:10px;
    font-weight:900;
    letter-spacing:.8px;
    text-transform:uppercase;
}

.sidebar-title > i{
    color:#93c5fd;
    font-size:30px;
}

.related-card,
.related-list{
    position:relative;
    z-index:10;
}

.related-list{
    display:grid;
    gap:11px;
    margin-top:16px;
}

.related-item{
    position:relative;
    z-index:11;
    pointer-events:auto;
    cursor:pointer;
    display:grid;
    grid-template-columns:92px minmax(0,1fr);
    gap:12px;
    padding:10px;
    border:1px solid #e2e8f0;
    border-radius:14px;
    color:inherit;
    background:#fbfdff;
    text-decoration:none;
    transition:.2s ease;
}

.related-item:hover{
    border-color:#93c5fd;
    background:#f5f9ff;
    transform:translateY(-2px);
    box-shadow:0 10px 24px rgba(7,87,216,.07);
}

.related-image{
    position:relative;
    width:92px;
    height:74px;
    overflow:hidden;
    border-radius:11px;
    background:linear-gradient(135deg,#dbeafe,#eff6ff);
}

.related-image img{
    position:relative;
    z-index:2;
    pointer-events:none;
    width:100%;
    height:100%;
    display:block;
    object-fit:cover;
}

.related-placeholder{
    position:absolute;
    inset:0;
    z-index:1;
    display:grid;
    place-items:center;
    color:#6f91c0;
    font-size:24px;
}

.related-image.is-error img{
    display:none;
}

.related-content{
    min-width:0;
    pointer-events:none;
}

.related-content h3{
    display:-webkit-box;
    margin:2px 0 10px;
    overflow:hidden;
    color:var(--article-text);
    font-size:13px;
    line-height:1.45;
    font-weight:900;
    -webkit-line-clamp:3;
    -webkit-box-orient:vertical;
}

.related-content > div{
    display:flex;
    flex-wrap:wrap;
    gap:7px 10px;
}

.related-content span{
    display:inline-flex;
    align-items:center;
    gap:4px;
    color:var(--article-muted);
    font-size:10px;
    font-weight:800;
}

.related-content i{
    color:var(--article-primary);
}

.related-empty{
    min-height:150px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:8px;
    color:var(--article-muted);
    text-align:center;
}

.related-empty i{
    color:#93c5fd;
    font-size:34px;
}

.related-empty p{
    margin:0;
    font-size:13px;
}

.copy-toast{
    position:fixed;
    right:22px;
    bottom:22px;
    z-index:9999;
    display:flex;
    align-items:center;
    gap:9px;
    padding:13px 16px;
    border-radius:12px;
    color:#fff;
    background:#0f172a;
    box-shadow:0 14px 34px rgba(15,23,42,.25);
    font-size:13px;
    font-weight:850;
    opacity:0;
    visibility:hidden;
    transform:translateY(16px);
    transition:.25s ease;
}

.copy-toast.show{
    opacity:1;
    visibility:visible;
    transform:translateY(0);
}

.copy-toast i{
    color:#4ade80;
}

@media(max-width:1100px){
    .article-hero{
        grid-template-columns:1fr;
    }

    .article-cover{
        min-height:430px;
    }

    .article-layout{
        grid-template-columns:1fr;
    }

    .article-sidebar{
        position:static;
        grid-template-columns:minmax(0,.75fr) minmax(0,1.25fr);
    }
}

@media(max-width:768px){
    .article-page{
        padding-top:24px;
    }

    .article-shell{
        width:calc(100% - 24px);
    }

    .article-breadcrumb strong{
        display:none;
    }

    .article-hero{
        min-height:0;
        border-radius:20px;
    }

    .article-hero-content{
        padding:28px 22px;
    }

    .article-hero h1{
        font-size:32px;
        letter-spacing:-.7px;
    }

    .article-summary{
        font-size:15px;
    }

    .article-meta{
        align-items:stretch;
        flex-direction:column;
    }

    .article-meta span{
        width:100%;
        border-radius:11px;
    }

    .article-cover{
        min-height:0;
        aspect-ratio:16/10;
    }

    .article-layout{
        margin-top:20px;
    }

    .article-card{
        padding:22px 17px;
        border-radius:18px;
    }

    .article-content{
        font-size:15px;
    }

    .article-content h1{
        font-size:26px;
    }

    .article-content h2{
        margin-top:30px;
        padding:15px 16px 15px 23px;
        font-size:21px;
    }

    .article-content h3{
        font-size:18px;
    }

    .article-content p{
        font-size:15px;
        line-height:1.8;
    }

    .article-content ul,
    .article-content ol{
        padding:15px 15px 15px 36px;
    }

    .article-footer{
        align-items:stretch;
        flex-direction:column;
    }

    .article-back{
        width:100%;
        justify-content:center;
    }

    .article-share{
        width:100%;
    }

    .share-button{
        flex:1 1 calc(50% - 9px);
    }

    .article-sidebar{
        grid-template-columns:1fr;
    }
}

@media(max-width:480px){
    .article-shell{
        width:calc(100% - 16px);
    }

    .article-hero-content{
        padding:24px 16px;
    }

    .article-hero h1{
        font-size:27px;
    }

    .article-cover{
        aspect-ratio:4/3;
    }

    .sidebar-card{
        padding:17px;
    }

    .related-item{
        grid-template-columns:80px minmax(0,1fr);
    }

    .related-image{
        width:80px;
        height:68px;
    }

    .copy-toast{
        right:12px;
        bottom:12px;
        left:12px;
        justify-content:center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const shareBox = document.getElementById('articleShare');
    const copyToast = document.getElementById('copyToast');
    const copyToastText = document.getElementById('copyToastText');

    if (!shareBox) {
        return;
    }

    const shareUrl = shareBox.dataset.url || window.location.href;
    const shareTitle = shareBox.dataset.title || document.title;
    const shareText = shareBox.dataset.text || shareTitle;

    function showToast(message) {
        if (copyToastText) {
            copyToastText.textContent = message;
        }

        if (!copyToast) {
            return;
        }

        copyToast.classList.add('show');

        window.setTimeout(function () {
            copyToast.classList.remove('show');
        }, 2400);
    }

    async function copyLink(message) {
        try {
            await navigator.clipboard.writeText(shareUrl);
        } catch (error) {
            const temporaryInput = document.createElement('textarea');
            temporaryInput.value = shareUrl;
            temporaryInput.style.position = 'fixed';
            temporaryInput.style.opacity = '0';
            document.body.appendChild(temporaryInput);
            temporaryInput.select();
            document.execCommand('copy');
            temporaryInput.remove();
        }

        showToast(message || 'Đã sao chép liên kết bài viết');
    }

    async function shareToApp(platformName) {
        /*
         * TikTok và Instagram không cung cấp URL chia sẻ bài viết web
         * ổn định như Facebook. Trên thiết bị hỗ trợ Web Share API,
         * hệ thống sẽ mở bảng chia sẻ của điện thoại.
         */
        if (navigator.share) {
            try {
                await navigator.share({
                    title: shareTitle,
                    text: shareText,
                    url: shareUrl
                });

                return;
            } catch (error) {
                if (error && error.name === 'AbortError') {
                    return;
                }
            }
        }

        await copyLink(
            'Đã sao chép liên kết. Hãy dán vào ' + platformName
        );
    }

    shareBox.querySelectorAll('[data-platform]').forEach(function (button) {
        button.addEventListener('click', async function () {
            const platform = button.dataset.platform;

            if (platform === 'facebook') {
                const facebookUrl =
                    'https://www.facebook.com/sharer/sharer.php?u='
                    + encodeURIComponent(shareUrl);

                window.open(
                    facebookUrl,
                    'shareFacebook',
                    'width=720,height=620,noopener,noreferrer'
                );

                return;
            }

            if (platform === 'zalo') {
                const zaloUrl =
                    'https://zalo.me/share?url='
                    + encodeURIComponent(shareUrl);

                const zaloWindow = window.open(
                    zaloUrl,
                    'shareZalo',
                    'width=720,height=620,noopener,noreferrer'
                );

                if (!zaloWindow) {
                    await shareToApp('Zalo');
                }

                return;
            }

            if (platform === 'tiktok') {
                await shareToApp('TikTok');
                return;
            }

            if (platform === 'instagram') {
                await shareToApp('Instagram');
                return;
            }

            await copyLink();
        });
    });
});
</script>
@endsection