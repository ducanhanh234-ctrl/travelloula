@extends('layouts.admin')

@section('content')
<div class="post-show-page">

    <div class="show-hero">
        <div class="hero-left">
            <a href="{{ route('Admin.bai_viets.index') }}" class="back-link">
                <i class="fa-solid fa-arrow-left"></i>
                Quay lại danh sách
            </a>

            <span class="hero-badge">
                <i class="fa-regular fa-newspaper"></i>
                Chi tiết bài viết
            </span>

            <h2>{{ $baiViet->tieu_de }}</h2>

            <div class="show-meta">
                <span>
                    <i class="fa-regular fa-user"></i>
                    {{ $baiViet->tac_gia ?? 'Admin' }}
                </span>

                <span>
                    <i class="fa-regular fa-calendar"></i>
                    {{ $baiViet->created_at?->format('d/m/Y H:i') }}
                </span>

                <span>
                    <i class="fa-regular fa-eye"></i>
                    {{ number_format($baiViet->luot_xem ?? 0) }} lượt xem
                </span>

                @if($baiViet->trang_thai == 1)
                    <span class="status active">
                        <i class="fa-solid fa-circle-check"></i>
                        Hiển thị
                    </span>
                @else
                    <span class="status inactive">
                        <i class="fa-solid fa-circle-minus"></i>
                        Ẩn
                    </span>
                @endif
            </div>
        </div>

        <div class="hero-actions">
            <a href="{{ route('Admin.bai_viets.edit', $baiViet) }}" class="btn-edit-top">
                <i class="fa-solid fa-pen-to-square"></i>
                Sửa bài viết
            </a>

            <div class="hero-icon">
                <i class="fa-solid fa-file-lines"></i>
            </div>
        </div>
    </div>

    <div class="show-layout">

        <div class="main-show-card">
            @if($baiViet->anh_dai_dien)
                <div class="image-wrap">
                    <img class="show-image"
                         src="{{ asset('storage/' . $baiViet->anh_dai_dien) }}"
                         alt="{{ $baiViet->tieu_de }}">

                    <div class="image-label">
                        <i class="fa-regular fa-image"></i>
                        Ảnh đại diện
                    </div>
                </div>
            @else
                <div class="no-image-box">
                    <i class="fa-regular fa-image"></i>
                    <strong>Chưa có ảnh đại diện</strong>
                    <span>Bài viết này chưa được thêm ảnh đại diện.</span>
                </div>
            @endif

            <div class="article-body">
                @if($baiViet->mo_ta_ngan)
                    <div class="desc-box">
                        <div class="desc-icon">
                            <i class="fa-solid fa-quote-left"></i>
                        </div>

                        <div>
                            {{ $baiViet->mo_ta_ngan }}
                        </div>
                    </div>
                @endif

                <div class="content-heading">
                    <h3>Nội dung bài viết</h3>
                    <p>Nội dung chi tiết đang hiển thị ngoài trang Client</p>
                </div>

                <div class="content-box">
                    {!! nl2br(e($baiViet->noi_dung)) !!}
                </div>
            </div>
        </div>

        <aside class="side-info">

            <div class="info-card">
                <div class="card-title">
                    <div>
                        <h3>Thông tin bài viết</h3>
                        <p>Thông tin quản trị cơ bản</p>
                    </div>

                    <i class="fa-solid fa-circle-info"></i>
                </div>

                <div class="info-list">
                    <div class="info-item">
                        <span>Trạng thái</span>

                        @if($baiViet->trang_thai == 1)
                            <strong class="text-green">Hiển thị</strong>
                        @else
                            <strong class="text-gray">Ẩn</strong>
                        @endif
                    </div>

                    <div class="info-item">
                        <span>Tác giả</span>
                        <strong>{{ $baiViet->tac_gia ?? 'Admin' }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Lượt xem</span>
                        <strong>{{ number_format($baiViet->luot_xem ?? 0) }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Ngày tạo</span>
                        <strong>{{ $baiViet->created_at?->format('d/m/Y H:i') }}</strong>
                    </div>

                    <div class="info-item">
                        <span>Cập nhật</span>
                        <strong>{{ $baiViet->updated_at?->format('d/m/Y H:i') }}</strong>
                    </div>
                </div>
            </div>

            <div class="info-card">
                <div class="card-title">
                    <div>
                        <h3>Đường dẫn</h3>
                        <p>Slug bài viết</p>
                    </div>

                    <i class="fa-solid fa-link"></i>
                </div>

                <div class="slug-box">
                    {{ $baiViet->duong_dan }}
                </div>
            </div>

            <div class="action-card">
                <a href="{{ route('Admin.bai_viets.edit', $baiViet) }}" class="btn-edit-side">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Sửa bài viết
                </a>

                <a href="{{ route('Admin.bai_viets.index') }}" class="btn-back-side">
                    <i class="fa-solid fa-list"></i>
                    Danh sách bài viết
                </a>
            </div>

        </aside>

    </div>
</div>

<style>
.post-show-page{
    min-height:100vh;
    padding:28px;
    background:
        radial-gradient(circle at 0% 0%, rgba(37,99,235,.09), transparent 30%),
        radial-gradient(circle at 100% 0%, rgba(14,165,233,.10), transparent 30%),
        #f8fafc;
}

.show-hero{
    position:relative;
    overflow:hidden;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:24px;
    padding:34px;
    margin-bottom:26px;
    border-radius:30px;
    background:
        linear-gradient(135deg, rgba(255,255,255,.98), rgba(255,255,255,.90)),
        linear-gradient(135deg,#eff6ff,#f8fafc);
    border:1px solid #e2e8f0;
    box-shadow:0 24px 70px rgba(15,23,42,.09);
}

.show-hero::after{
    content:"";
    position:absolute;
    right:-90px;
    top:-100px;
    width:300px;
    height:300px;
    border-radius:999px;
    background:linear-gradient(135deg, rgba(37,99,235,.14), rgba(14,165,233,.16));
}

.show-hero > *{
    position:relative;
    z-index:2;
}

.back-link{
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-bottom:14px;
    color:#64748b;
    text-decoration:none;
    font-weight:900;
    font-size:14px;
}

.back-link:hover{
    color:#2563eb;
}

.hero-badge{
    display:inline-flex;
    align-items:center;
    gap:9px;
    min-height:36px;
    padding:0 15px;
    border-radius:999px;
    background:#eff6ff;
    color:#2563eb;
    border:1px solid #bfdbfe;
    font-size:13px;
    font-weight:1000;
    margin-bottom:14px;
}

.show-hero h2{
    max-width:850px;
    margin:0;
    color:#0f172a;
    font-size:34px;
    line-height:1.22;
    font-weight:1000;
    letter-spacing:-.8px;
}

.show-meta{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    margin-top:16px;
}

.show-meta span{
    display:inline-flex;
    align-items:center;
    gap:7px;
    min-height:34px;
    padding:0 13px;
    border-radius:999px;
    background:#fff;
    border:1px solid #e2e8f0;
    color:#64748b;
    font-size:13px;
    font-weight:900;
    box-shadow:0 6px 16px rgba(15,23,42,.04);
}

.status.active{
    background:#dcfce7 !important;
    color:#166534 !important;
    border-color:#bbf7d0 !important;
}

.status.inactive{
    background:#f1f5f9 !important;
    color:#475569 !important;
    border-color:#e2e8f0 !important;
}

.hero-actions{
    display:flex;
    align-items:center;
    gap:14px;
}

.hero-icon{
    width:88px;
    height:88px;
    border-radius:30px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,#2563eb,#0ea5e9);
    color:#fff;
    font-size:36px;
    box-shadow:0 20px 40px rgba(37,99,235,.25);
}

.btn-edit-top{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:9px;
    min-height:46px;
    padding:0 18px;
    border-radius:15px;
    background:#f59e0b;
    color:#fff;
    text-decoration:none;
    font-weight:1000;
    box-shadow:0 14px 28px rgba(245,158,11,.24);
    transition:.22s ease;
    white-space:nowrap;
}

.btn-edit-top:hover{
    color:#fff;
    background:#d97706;
    transform:translateY(-1px);
}

.show-layout{
    display:grid;
    grid-template-columns:minmax(0,1fr) 360px;
    gap:24px;
    align-items:start;
}

.main-show-card,
.info-card,
.action-card{
    background:#fff;
    border:1px solid #e2e8f0;
    border-radius:28px;
    box-shadow:0 20px 55px rgba(15,23,42,.08);
}

.main-show-card{
    overflow:hidden;
}

.image-wrap{
    position:relative;
    overflow:hidden;
    background:#f1f5f9;
}

.show-image{
    display:block;
    width:100%;
    height:430px;
    object-fit:cover;
}

.image-label{
    position:absolute;
    left:22px;
    bottom:22px;
    display:inline-flex;
    align-items:center;
    gap:8px;
    min-height:36px;
    padding:0 14px;
    border-radius:999px;
    background:rgba(15,23,42,.78);
    color:#fff;
    font-size:13px;
    font-weight:1000;
    backdrop-filter:blur(7px);
}

.no-image-box{
    min-height:320px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:8px;
    background:linear-gradient(135deg,#eff6ff,#f8fafc);
    color:#64748b;
    border-bottom:1px solid #e2e8f0;
    text-align:center;
}

.no-image-box i{
    font-size:52px;
    color:#2563eb;
    margin-bottom:6px;
}

.no-image-box strong{
    color:#0f172a;
    font-size:22px;
    font-weight:1000;
}

.no-image-box span{
    font-weight:700;
}

.article-body{
    padding:34px;
}

.desc-box{
    display:flex;
    align-items:flex-start;
    gap:16px;
    padding:22px;
    border-radius:22px;
    background:#eff6ff;
    border:1px solid #bfdbfe;
    color:#1e3a8a;
    line-height:1.8;
    font-size:16px;
    font-weight:800;
    margin-bottom:26px;
}

.desc-icon{
    width:42px;
    height:42px;
    border-radius:15px;
    background:#2563eb;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-shrink:0;
}

.content-heading{
    padding-bottom:16px;
    margin-bottom:22px;
    border-bottom:1px solid #e2e8f0;
}

.content-heading h3{
    margin:0;
    color:#0f172a;
    font-size:24px;
    font-weight:1000;
}

.content-heading p{
    margin:5px 0 0;
    color:#64748b;
    font-size:14px;
    font-weight:700;
}

.content-box{
    color:#334155;
    font-size:16px;
    line-height:2;
    font-weight:600;
    white-space:normal;
}

.content-box br{
    content:"";
}

.side-info{
    position:sticky;
    top:92px;
    display:flex;
    flex-direction:column;
    gap:18px;
}

.info-card{
    padding:22px;
}

.card-title{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:14px;
    padding-bottom:16px;
    margin-bottom:18px;
    border-bottom:1px solid #e2e8f0;
}

.card-title h3{
    margin:0;
    color:#0f172a;
    font-size:18px;
    font-weight:1000;
}

.card-title p{
    margin:4px 0 0;
    color:#64748b;
    font-size:13px;
    font-weight:700;
}

.card-title > i{
    width:42px;
    height:42px;
    border-radius:15px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#eff6ff;
    color:#2563eb;
    font-size:17px;
}

.info-list{
    display:flex;
    flex-direction:column;
}

.info-item{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    padding:13px 0;
    border-bottom:1px solid #e2e8f0;
}

.info-item:first-child{
    padding-top:0;
}

.info-item:last-child{
    padding-bottom:0;
    border-bottom:0;
}

.info-item span{
    color:#64748b;
    font-size:13px;
    font-weight:850;
}

.info-item strong{
    color:#0f172a;
    font-size:13px;
    font-weight:1000;
    text-align:right;
}

.text-green{
    color:#16a34a !important;
}

.text-gray{
    color:#475569 !important;
}

.slug-box{
    padding:15px;
    border-radius:16px;
    background:#f8fafc;
    border:1px solid #e2e8f0;
    color:#2563eb;
    font-size:13px;
    line-height:1.6;
    font-weight:900;
    word-break:break-all;
}

.action-card{
    padding:18px;
    display:grid;
    grid-template-columns:1fr;
    gap:12px;
}

.btn-edit-side,
.btn-back-side{
    min-height:46px;
    border-radius:15px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:9px;
    text-decoration:none;
    font-size:14px;
    font-weight:1000;
    transition:.22s ease;
}

.btn-edit-side{
    background:linear-gradient(135deg,#f59e0b,#f97316);
    color:#fff;
    box-shadow:0 14px 28px rgba(245,158,11,.22);
}

.btn-edit-side:hover{
    color:#fff;
    transform:translateY(-1px);
}

.btn-back-side{
    background:#f1f5f9;
    color:#334155;
    border:1px solid #e2e8f0;
}

.btn-back-side:hover{
    background:#e2e8f0;
    color:#0f172a;
}

@media(max-width:1100px){
    .show-layout{
        grid-template-columns:1fr;
    }

    .side-info{
        position:relative;
        top:0;
    }

    .show-hero{
        align-items:flex-start;
        flex-direction:column;
    }

    .hero-actions{
        width:100%;
        justify-content:space-between;
    }
}

@media(max-width:720px){
    .post-show-page{
        padding:18px;
    }

    .show-hero{
        padding:24px;
        border-radius:24px;
    }

    .show-hero h2{
        font-size:27px;
    }

    .hero-actions{
        flex-direction:column;
        align-items:flex-start;
    }

    .hero-icon{
        width:70px;
        height:70px;
        border-radius:24px;
        font-size:28px;
    }

    .show-image{
        height:260px;
    }

    .article-body{
        padding:22px;
    }

    .desc-box{
        flex-direction:column;
        padding:18px;
    }

    .info-card,
    .action-card{
        padding:20px;
        border-radius:22px;
    }
}
</style>
@endsection