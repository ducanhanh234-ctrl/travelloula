@extends('layouts.app')

@section('content')
<div class="article-page">

    <section class="article-header">
        <div class="article-wrap">
            <a href="{{ route('Client.bai_viet.index') }}" class="back-link">
                <i class="fa-solid fa-arrow-left"></i>
                Quay lại bài viết
            </a>

            <span class="article-label">Cẩm nang du lịch</span>

            <h1>{{ $baiViet->tieu_de }}</h1>

            @if($baiViet->mo_ta_ngan)
                <p>{{ $baiViet->mo_ta_ngan }}</p>
            @endif

            <div class="article-meta">
                <div class="author">
                    <div class="avatar">
                        {{ strtoupper(substr($baiViet->tac_gia ?? 'A', 0, 1)) }}
                    </div>

                    <div>
                        <strong>{{ $baiViet->tac_gia ?? 'Admin' }}</strong>
                        <span>{{ $baiViet->created_at?->format('d/m/Y') }}</span>
                    </div>
                </div>

                <div class="views">
                    <i class="fa-regular fa-eye"></i>
                    {{ number_format($baiViet->luot_xem ?? 0) }} lượt xem
                </div>
            </div>
        </div>
    </section>

    <section class="article-wrap article-section">
        <div class="article-layout">

            <main class="article-main">
                @if($baiViet->anh_dai_dien)
                    <div class="article-cover">
                        <img src="{{ asset('storage/' . $baiViet->anh_dai_dien) }}" alt="{{ $baiViet->tieu_de }}">
                    </div>
                @endif

                <div class="article-content">
                    @php
                        $lines = preg_split('/\r\n|\r|\n/', $baiViet->noi_dung ?? '');
                        $introDone = false;
                    @endphp

                    @foreach($lines as $line)
                        @php
                            $line = trim($line);
                        @endphp

                        @if($line === '')
                            <div class="article-space"></div>
                        @elseif(preg_match('/^[0-9]+\.\s/u', $line))
                            <h2 class="article-section-title">
                                {{ $line }}
                            </h2>
                        @else
                            @if(!$introDone)
                                <p class="article-intro">
                                    {{ $line }}
                                </p>

                                @php
                                    $introDone = true;
                                @endphp
                            @else
                                <p>
                                    {{ $line }}
                                </p>
                            @endif
                        @endif
                    @endforeach
                </div>
            </main>

            <aside class="article-sidebar">
                <div class="side-card">
                    <h3>Thông tin bài viết</h3>

                    <div class="info-row">
                        <span>Tác giả</span>
                        <strong>{{ $baiViet->tac_gia ?? 'Admin' }}</strong>
                    </div>

                    <div class="info-row">
                        <span>Ngày đăng</span>
                        <strong>{{ $baiViet->created_at?->format('d/m/Y') }}</strong>
                    </div>

                    <div class="info-row">
                        <span>Lượt xem</span>
                        <strong>{{ number_format($baiViet->luot_xem ?? 0) }}</strong>
                    </div>
                </div>

                @if(isset($baiVietLienQuan) && $baiVietLienQuan->count())
                    <div class="side-card">
                        <h3>Bài viết liên quan</h3>

                        <div class="related-list">
                            @foreach($baiVietLienQuan as $item)
                                <a href="{{ route('Client.bai_viet.detail', $item->duong_dan) }}" class="related-item">
                                    @if($item->anh_dai_dien)
                                        <img src="{{ asset('storage/' . $item->anh_dai_dien) }}" alt="{{ $item->tieu_de }}">
                                    @else
                                        <div class="related-icon">
                                            <i class="fa-regular fa-newspaper"></i>
                                        </div>
                                    @endif

                                    <div>
                                        <strong>{{ \Illuminate\Support\Str::limit($item->tieu_de, 62) }}</strong>
                                        <span>{{ $item->created_at?->format('d/m/Y') }}</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>

        </div>
    </section>

</div>

<style>
.article-page{
    background:#f3f6fb;
    min-height:100vh;
}

.article-wrap{
    width:100%;
    max-width:1500px;
    margin:0 auto;
    padding-left:40px;
    padding-right:40px;
}

/* HEADER */
.article-header{
    position:relative;
    background:
        linear-gradient(90deg, rgba(7,19,49,.88), rgba(21,94,239,.58)),
        url("{{ asset('images/blog-banner.jpg') }}");
    background-size:cover;
    background-position:center;
    border-bottom:1px solid #e2e8f0;
}

.article-header::after{
    content:"";
    position:absolute;
    inset:0;
    background:radial-gradient(circle at 80% 20%, rgba(255,255,255,.18), transparent 35%);
    pointer-events:none;
}

.article-header .article-wrap{
    position:relative;
    z-index:2;
    padding-top:64px;
    padding-bottom:62px;
}

.back-link{
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-bottom:18px;
    color:#ffffff;
    text-decoration:none;
    font-size:14px;
    font-weight:1000;
}

.back-link:hover{
    color:#dbeafe;
}

.article-label{
    display:block;
    width:max-content;
    padding:8px 14px;
    border-radius:999px;
    background:rgba(255,255,255,.16);
    border:1px solid rgba(255,255,255,.35);
    color:#ffffff;
    font-size:13px;
    font-weight:1000;
    margin-bottom:18px;
    backdrop-filter:blur(8px);
}

.article-header h1{
    max-width:1180px;
    margin:0;
    color:#ffffff;
    font-size:48px;
    line-height:1.12;
    letter-spacing:-1.2px;
    font-weight:1000;
    text-shadow:0 12px 30px rgba(0,0,0,.25);
}

.article-header p{
    max-width:1000px;
    margin:18px 0 0;
    color:#eaf2ff;
    font-size:18px;
    line-height:1.8;
    font-weight:650;
}

.article-meta{
    max-width:1180px;
    margin-top:26px;
    padding-top:22px;
    border-top:1px solid rgba(255,255,255,.25);
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    flex-wrap:wrap;
}

.author{
    display:flex;
    align-items:center;
    gap:12px;
}

.avatar{
    width:46px;
    height:46px;
    border-radius:50%;
    background:#155eef;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:1000;
    box-shadow:0 12px 28px rgba(0,0,0,.22);
}

.author strong{
    display:block;
    color:#ffffff;
    font-size:15px;
    font-weight:1000;
}

.author span{
    display:block;
    margin-top:2px;
    color:#dbeafe;
    font-size:13px;
    font-weight:800;
}

.views{
    display:inline-flex;
    align-items:center;
    gap:7px;
    min-height:38px;
    padding:0 14px;
    border-radius:999px;
    background:rgba(255,255,255,.16);
    border:1px solid rgba(255,255,255,.35);
    color:#ffffff;
    font-size:13px;
    font-weight:1000;
    backdrop-filter:blur(8px);
}

/* MAIN LAYOUT */
.article-section{
    padding-top:34px;
    padding-bottom:76px;
}

.article-layout{
    display:grid;
    grid-template-columns:minmax(0,1fr) 360px;
    gap:28px;
    align-items:start;
}

.article-main{
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:28px;
    overflow:hidden;
    box-shadow:0 22px 60px rgba(15,23,42,.08);
}

.article-cover{
    width:100%;
    max-height:420px;
    overflow:hidden;
    background:#e2e8f0;
}

.article-cover img{
    width:100%;
    height:100%;
    max-height:420px;
    object-fit:cover;
    display:block;
}

/* ARTICLE CONTENT - ĐẸP HƠN */
.article-content{
    padding:48px 66px 56px;
    color:#26364d;
    font-size:17px;
    line-height:1.9;
    font-weight:500;
}

.article-content p{
    margin:0 0 18px;
    color:#26364d;
    font-size:17px;
    line-height:1.9;
    font-weight:500;
}

.article-intro{
    position:relative;
    padding:24px 28px 24px 30px;
    margin-bottom:32px !important;
    border-radius:22px;
    background:linear-gradient(135deg,#eff6ff,#f8fbff);
    border:1px solid #bfdbfe;
    color:#102a56 !important;
    font-size:18px !important;
    line-height:1.85 !important;
    font-weight:850 !important;
    box-shadow:0 14px 34px rgba(21,94,239,.08);
}

.article-intro::before{
    content:"";
    position:absolute;
    left:0;
    top:22px;
    bottom:22px;
    width:5px;
    border-radius:999px;
    background:#155eef;
}

.article-section-title{
    position:relative;
    margin:38px 0 18px;
    padding-left:22px;
    color:#071331;
    font-size:25px;
    line-height:1.35;
    font-weight:1000;
    letter-spacing:-.35px;
}

.article-section-title::before{
    content:"";
    position:absolute;
    left:0;
    top:7px;
    width:6px;
    height:28px;
    border-radius:999px;
    background:#155eef;
}

.article-section-title::after{
    content:"";
    display:block;
    width:72px;
    height:3px;
    border-radius:999px;
    background:#dbeafe;
    margin-top:12px;
}

.article-space{
    height:8px;
}

/* SIDEBAR */
.article-sidebar{
    position:sticky;
    top:96px;
    display:flex;
    flex-direction:column;
    gap:18px;
}

.side-card{
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:24px;
    padding:22px;
    box-shadow:0 16px 42px rgba(15,23,42,.07);
}

.side-card h3{
    margin:0 0 16px;
    padding-bottom:14px;
    border-bottom:1px solid #edf1f7;
    color:#071331;
    font-size:20px;
    font-weight:1000;
}

.info-row{
    display:flex;
    justify-content:space-between;
    gap:12px;
    padding:12px 0;
    border-bottom:1px solid #edf1f7;
}

.info-row:last-child{
    border-bottom:0;
    padding-bottom:0;
}

.info-row span{
    color:#64748b;
    font-size:14px;
    font-weight:800;
}

.info-row strong{
    color:#071331;
    font-size:14px;
    font-weight:1000;
    text-align:right;
}

.related-list{
    display:flex;
    flex-direction:column;
    gap:12px;
}

.related-item{
    display:grid;
    grid-template-columns:70px 1fr;
    gap:12px;
    text-decoration:none;
    padding:10px;
    border-radius:16px;
    background:#f8fbff;
    border:1px solid #edf1f7;
    transition:.22s ease;
}

.related-item:hover{
    background:#eaf2ff;
    border-color:#bfdbfe;
}

.related-item img,
.related-icon{
    width:70px;
    height:56px;
    border-radius:13px;
    object-fit:cover;
}

.related-icon{
    display:flex;
    align-items:center;
    justify-content:center;
    background:#eaf2ff;
    color:#155eef;
    font-size:22px;
}

.related-item strong{
    display:block;
    color:#071331;
    font-size:14px;
    line-height:1.4;
    font-weight:1000;
}

.related-item:hover strong{
    color:#155eef;
}

.related-item span{
    display:block;
    margin-top:5px;
    color:#64748b;
    font-size:12px;
    font-weight:800;
}

/* RESPONSIVE */
@media(max-width:1100px){
    .article-layout{
        grid-template-columns:1fr;
    }

    .article-sidebar{
        position:relative;
        top:0;
    }
}

@media(max-width:760px){
    .article-wrap{
        padding-left:18px;
        padding-right:18px;
    }

    .article-header .article-wrap{
        padding-top:44px;
        padding-bottom:44px;
    }

    .article-header h1{
        font-size:32px;
    }

    .article-header p{
        font-size:15px;
    }

    .article-meta{
        align-items:flex-start;
        flex-direction:column;
    }

    .article-content{
        padding:26px;
    }

    .article-content p{
        font-size:15px;
        line-height:1.85;
    }

    .article-intro{
        padding:18px 20px 18px 22px;
        font-size:16px !important;
        line-height:1.8 !important;
    }

    .article-section-title{
        font-size:21px;
        margin-top:30px;
    }
}
</style>
@endsection