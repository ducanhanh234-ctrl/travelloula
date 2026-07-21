@extends('layouts.app')

@section('title', 'Trang chủ - Travelloula')

@section('content')


@php
    /*
     * Lấy toàn bộ ID tour yêu thích của tài khoản hiện tại chỉ bằng 1 truy vấn.
     * Nhờ vậy trái tim hiển thị đúng ngay cả khi controller chưa truyền
     * biến $favoriteTourIds sang view.
     */
    $favoriteTourIds = [];

    if (auth()->check()) {
        $favoriteTourIds = \Illuminate\Support\Facades\DB::table('danh_sach_tours_yeu_thich')
            ->where('nguoi_dung_id', auth()->id())
            ->pluck('tour_id')
            ->map(fn ($id) => (int) $id)
            ->all();
    }
@endphp


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
    min-height:590px;
    position:relative;
    display:flex;
    align-items:center;
    overflow:hidden;
    background:#0f172a;
}

.hero-slides{
    position:absolute;
    inset:0;
    z-index:0;
}

.hero-slide{
    position:absolute;
    inset:0;
    opacity:0;
    visibility:hidden;
    transform:scale(1.06);
    transition:opacity .9s ease, transform 6s ease, visibility .9s ease;
}

.hero-slide.active{
    opacity:1;
    visibility:visible;
    transform:scale(1);
}

.hero-slide::after{
    content:"";
    position:absolute;
    inset:0;
    background:
        linear-gradient(90deg,rgba(3,28,72,.88) 0%,rgba(3,37,92,.64) 42%,rgba(2,6,23,.18) 72%,rgba(2,6,23,.08) 100%),
        linear-gradient(180deg,rgba(15,23,42,.10),rgba(15,23,42,.28));
}

.hero-slide img{
    width:100%;
    height:100%;
    display:block;
    object-fit:cover;
}

.hero-content{
    width:min(1380px,calc(100% - 56px));
    margin:0 auto;
    color:#fff;
    position:relative;
    z-index:4;
}

.hero-copy{
    max-width:820px;
}

.hero-copy-item{
    display:none;
    animation:heroTextIn .65s ease both;
}

.hero-copy-item.active{
    display:block;
}

@keyframes heroTextIn{
    from{
        opacity:0;
        transform:translateY(18px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

.hero-slide-nav{
    position:absolute;
    top:50%;
    z-index:6;
    width:48px;
    height:48px;
    border:1px solid rgba(255,255,255,.55);
    border-radius:50%;
    display:grid;
    place-items:center;
    color:#fff;
    background:rgba(15,23,42,.28);
    backdrop-filter:blur(8px);
    cursor:pointer;
    transform:translateY(-50%);
    transition:.25s ease;
}

.hero-slide-nav:hover{
    background:#0757d8;
    border-color:#0757d8;
}

.hero-slide-prev{
    left:22px;
}

.hero-slide-next{
    right:22px;
}

.hero-dots{
    position:absolute;
    left:50%;
    bottom:24px;
    z-index:6;
    display:flex;
    align-items:center;
    gap:9px;
    transform:translateX(-50%);
}

.hero-dot{
    width:9px;
    height:9px;
    padding:0;
    border:0;
    border-radius:999px;
    background:rgba(255,255,255,.56);
    cursor:pointer;
    transition:.25s ease;
}

.hero-dot.active{
    width:30px;
    background:#ffd629;
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
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:28px;
    align-items:stretch;
}

.tour-card{
    display:flex;
    flex-direction:column;
    height:100%;
    min-width:0;
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 18px 45px rgba(15,23,42,.10);
    border:1px solid #e8eef7;
    transition:.3s;
}

.tour-card:hover{
    transform:translateY(-8px);
}

.tour-img{
    position:relative;
    width:100%;
    height:182px;
    flex:0 0 182px;
    overflow:hidden;
    background:#eef2f7;
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

.home-favorite-form{
    position:absolute;
    top:13px;
    right:13px;
    z-index:5;
    margin:0;
}

.home-favorite-form .heart{
    position:static;
}

.heart{
    position:absolute;
    top:13px;
    right:13px;
    z-index:5;
    width:36px;
    height:36px;
    border-radius:50%;
    border:0;
    background:#fff;
    color:#0757d8;
    cursor:pointer;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 8px 20px rgba(15,23,42,.16);
    transition:.25s;
    text-decoration:none;
}

.heart:hover{
    color:#e11d48;
    transform:scale(1.08);
}

.heart.active{
    color:#e11d48;
    background:#fff1f2;
}

.heart.active:hover{
    color:#fff;
    background:#e11d48;
}


.heart.is-loading{
    pointer-events:none;
    opacity:.68;
}

.heart.is-loading i{
    animation:favoritePulse .7s ease infinite alternate;
}

@keyframes favoritePulse{
    from{ transform:scale(.84); }
    to{ transform:scale(1.12); }
}

.favorite-toast{
    position:fixed;
    right:24px;
    bottom:24px;
    z-index:10050;
    max-width:min(360px,calc(100vw - 32px));
    padding:13px 16px;
    border-radius:12px;
    display:flex;
    align-items:center;
    gap:9px;
    color:#fff;
    background:#0757d8;
    font-size:14px;
    font-weight:800;
    box-shadow:0 16px 38px rgba(15,23,42,.24);
    opacity:0;
    visibility:hidden;
    transform:translateY(12px);
    transition:.22s ease;
}

.favorite-toast.show{
    opacity:1;
    visibility:visible;
    transform:translateY(0);
}

.favorite-toast.error{
    background:#dc2626;
}

.tour-body{
    display:flex;
    flex-direction:column;
    flex:1;
    min-width:0;
    padding:18px 20px 20px;
}

.tour-body h3{
    font-size:18px;
    margin-bottom:8px;
    line-height:1.35;
    height:46px;
    min-height:46px;
    display:-webkit-box;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

.rating{
    display:flex;
    align-items:center;
    gap:5px;
    min-height:20px;
    color:#475569;
    font-size:13px;
    margin-bottom:12px;
}

.rating i{
    color:#f59e0b;
}

.tour-meta{
    display:flex;
    align-content:flex-start;
    flex-wrap:wrap;
    gap:8px 12px;
    min-height:34px;
    font-size:12px;
    line-height:1.45;
    color:#64748b;
    margin-bottom:8px;
}

.tour-bottom{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
    margin-top:0;
    padding-top:0;
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
    flex-wrap:nowrap;
}

.tour-actions a{
    min-width:92px;
    height:40px;
    border-radius:10px;
    padding:0 14px;
    font-size:13px;
    font-weight:900;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    transition:.25s;
    white-space:nowrap;
    text-align:center;
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
    cursor:pointer;
}

.book-now-btn:hover{
    background:#0044c7;
    color:#fff;
}


/* THÔNG BÁO KHI TOUR CHƯA THỂ ĐẶT */
.tour-message-modal{
    display:none;
    position:fixed;
    inset:0;
    z-index:9999;
    align-items:center;
    justify-content:center;
    padding:20px;
    background:rgba(15,23,42,.58);
    backdrop-filter:blur(4px);
}

.tour-message-modal.show{
    display:flex;
}

.tour-message-dialog{
    width:min(440px,100%);
    border-radius:20px;
    background:#fff;
    padding:26px;
    box-shadow:0 30px 80px rgba(15,23,42,.28);
}

.tour-message-icon{
    width:54px;
    height:54px;
    margin-bottom:16px;
    display:grid;
    place-items:center;
    border-radius:16px;
    color:#0757d8;
    background:#eff6ff;
    font-size:24px;
}

.tour-message-dialog h3{
    margin-bottom:10px;
    font-size:22px;
    font-weight:900;
}

.tour-message-dialog p{
    margin-bottom:20px;
    color:#475569;
    line-height:1.65;
}

.tour-message-actions{
    display:flex;
    justify-content:flex-end;
    gap:10px;
}

.tour-message-actions button{
    border:0;
    border-radius:10px;
    padding:10px 17px;
    background:#0757d8;
    color:#fff;
    font-weight:900;
    cursor:pointer;
}

@media(max-width:640px){

    .departure-nearest{
        align-items:flex-start;
        flex-direction:column;
    }

    .departure-status{
        min-width:0;
    }

    .tour-actions button{
        flex:1;
    }
}


.tour-bottom > div:first-child{
    display:flex;
    align-items:center;
    min-height:38px;
}

.tour-bottom strong{
    line-height:1;
    margin:0;
}

@media(min-width:1181px){
    .tour-card{
        min-height:0;
    }
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
    .tour-card{
        min-height:0;
    }

    .tour-body h3,
    .tour-meta{
        height:auto;
        min-height:0;
    }

    .tour-bottom{
        align-items:stretch;
        flex-direction:column;
    }

    .tour-actions{
        width:100%;
    }

    .tour-actions a{
        flex:1;
    }

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

/* TOÀN BỘ CARD TOUR CÓ THỂ BẤM */
.tour-card-clickable{
    cursor:pointer;
}

.tour-card-clickable:focus-visible{
    outline:3px solid rgba(7,87,216,.25);
    outline-offset:4px;
}

.tour-card-clickable .tour-img,
.tour-card-clickable .tour-body h3,
.tour-card-clickable .rating,
.tour-card-clickable .tour-meta{
    cursor:pointer;
}

/* Những nút riêng vẫn hoạt động độc lập */
.tour-card-clickable a,
.tour-card-clickable button,
.tour-card-clickable form{
    position:relative;
    z-index:3;
}


@media(max-width:900px){
    .home-hero{
        min-height:680px;
    }

    .hero-slide-nav{
        width:42px;
        height:42px;
    }

    .hero-slide-prev{
        left:10px;
    }

    .hero-slide-next{
        right:10px;
    }
}

@media(max-width:640px){
    .home-hero{
        min-height:760px;
    }

    .hero-slide-nav{
        top:36%;
    }

    .hero-content{
        width:calc(100% - 28px);
    }

    .hero-dots{
        bottom:14px;
    }
}


/* BANNER TĨNH - ĐÃ BỎ SLIDESHOW */
.home-hero-static{
    min-height:590px;
    position:relative;
    display:flex;
    align-items:center;
    overflow:hidden;
    background:#0f172a;
}

.hero-static-image{
    position:absolute;
    inset:0;
    z-index:0;
}

.hero-static-image::after{
    content:"";
    position:absolute;
    inset:0;
    background:
        linear-gradient(90deg,rgba(3,28,72,.88) 0%,rgba(3,37,92,.64) 42%,rgba(2,6,23,.18) 72%,rgba(2,6,23,.08) 100%),
        linear-gradient(180deg,rgba(15,23,42,.10),rgba(15,23,42,.28));
}

.hero-static-image img{
    width:100%;
    height:100%;
    display:block;
    object-fit:cover;
}

.home-hero-static .hero-content{
    position:relative;
    z-index:2;
}

.home-hero-static .hero-copy{
    max-width:820px;
}

/* Ẩn hoàn toàn thành phần slideshow cũ nếu trình duyệt còn cache */
.hero-slides,
.hero-slide-nav,
.hero-dots,
.hero-copy-item{
    display:none !important;
}

@media(max-width:900px){
    .home-hero-static{
        min-height:680px;
    }
}

@media(max-width:640px){
    .home-hero-static{
        min-height:760px;
    }
}


/* =========================================================
   SỬA NÚT TRÁI TIM BỊ ẨN DO RULE .tour-card-clickable
   ========================================================= */
.tour-card-clickable .tour-img{
    position:relative !important;
}

.tour-card-clickable .home-favorite-form{
    position:absolute !important;
    top:13px !important;
    right:13px !important;
    z-index:20 !important;
    width:38px;
    height:38px;
    margin:0 !important;
    padding:0 !important;
    display:block !important;
}

.tour-card-clickable .home-favorite-form .heart,
.tour-card-clickable .tour-img > .heart{
    position:absolute !important;
    top:0 !important;
    right:0 !important;
    z-index:21 !important;
    width:38px !important;
    height:38px !important;
    min-width:38px !important;
    min-height:38px !important;
    padding:0 !important;
    margin:0 !important;
    border:0 !important;
    border-radius:50% !important;
    display:flex !important;
    align-items:center !important;
    justify-content:center !important;
    color:#0757d8 !important;
    background:#ffffff !important;
    box-shadow:0 8px 22px rgba(15,23,42,.22) !important;
    font-size:17px !important;
    line-height:1 !important;
    cursor:pointer;
    text-decoration:none !important;
    opacity:1 !important;
    visibility:visible !important;
    transform:none;
}

.tour-card-clickable .home-favorite-form .heart:hover,
.tour-card-clickable .tour-img > .heart:hover{
    color:#e11d48 !important;
    transform:scale(1.08) !important;
}

.tour-card-clickable .home-favorite-form .heart.active{
    color:#ffffff !important;
    background:#e11d48 !important;
}

.tour-card-clickable .home-favorite-form .heart.active:hover{
    color:#ffffff !important;
    background:#be123c !important;
}

/* Link đăng nhập cũng phải nằm đúng góc ảnh */
.tour-card-clickable .tour-img > a.heart{
    top:13px !important;
    right:13px !important;
}

.tour-card-clickable .heart i{
    pointer-events:none;
}

</style>

<main>

<section class="home-hero home-hero-static">
    <div class="hero-static-image">
        <img
            src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1920&q=88"
            alt="Du lịch biển cùng Travelloula"
        >
    </div>

    <div class="hero-content">
        <div class="hero-copy">
            <h1>Khám phá thế giới</h1>
            <h2>Cùng Travelloula <i class="fa-solid fa-plane"></i></h2>
            <p>Những hành trình tuyệt vời đang chờ bạn trải nghiệm!</p>
        </div>

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

        @if(session('success'))
            <div style="margin-bottom:18px;padding:14px 16px;border-radius:12px;background:#ecfdf5;border:1px solid #bbf7d0;color:#047857;font-weight:800;">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

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

                    $isFavorite = auth()->check()
                        ? in_array((int) $tour->id, $favoriteTourIds, true)
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
                        <img src="{{ $tourImage }}"
                             alt="{{ $tour->ten_tour }}"
                             onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80';">

                        <span class="discount">
                            {{ $tour->danhMuc->ten_danh_muc ?? 'Tour nổi bật' }}
                        </span>

                        @auth
                            <form
                                action="{{ $isFavorite
                                    ? route('Client.tour_yeu_thich.destroy', $tour->id)
                                    : route('Client.tour_yeu_thich.store', $tour->id) }}"
                                method="POST"
                                class="home-favorite-form js-home-favorite-form"
                                data-store-url="{{ route('Client.tour_yeu_thich.store', $tour->id) }}"
                                data-destroy-url="{{ route('Client.tour_yeu_thich.destroy', $tour->id) }}"
                                data-favorite="{{ $isFavorite ? '1' : '0' }}"
                            >
                                @csrf

                                @if($isFavorite)
                                    <input type="hidden" name="_method" value="DELETE" class="favorite-method-input">
                                @endif

                                <button
                                    class="heart {{ $isFavorite ? 'active' : '' }}"
                                    type="submit"
                                    title="{{ $isFavorite ? 'Bỏ yêu thích' : 'Thêm vào yêu thích' }}"
                                    aria-label="{{ $isFavorite ? 'Bỏ yêu thích' : 'Thêm vào yêu thích' }}"
                                    aria-pressed="{{ $isFavorite ? 'true' : 'false' }}"
                                >
                                    <i class="{{ $isFavorite ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                </button>
                            </form>
                        @else
                            <a
                                href="{{ route('login') }}"
                                class="heart"
                                title="Đăng nhập để thêm yêu thích"
                                aria-label="Đăng nhập để thêm yêu thích"
                            >
                                <i class="fa-regular fa-heart"></i>
                            </a>
                        @endauth
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

                        @php
                            /*
                             * Database lich_khoi_hanh_tours dùng đúng 4 mã:
                             * available, running, full, closed.
                             */
                            $lichKhoiHanhs = collect($tour->lichKhoiHanhTours ?? [])
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

                            /*
                             * Ưu tiên hiển thị lịch mở bán gần nhất.
                             * Nếu không có thì lấy lịch gần nhất bất kỳ.
                             */
                            $lichGanNhat = $lichKhoiHanhs
                                ->firstWhere('trang_thai', 'available')
                                ?? $lichKhoiHanhs->first();

                            $coLichMoBan = $lichKhoiHanhs->contains(function ($lich) {
                                return $lich->trang_thai === 'available'
                                    && (int) $lich->so_cho_con_lai > 0;
                            });

                            $lyDoKhongDat = 'Tour hiện chưa có lịch khởi hành có thể đặt.';

                            if ($lichKhoiHanhs->isEmpty()) {
                                $lyDoKhongDat = 'Tour hiện chưa có lịch khởi hành.';
                            } elseif ($lichKhoiHanhs->every(fn($lich) => $lich->trang_thai === 'closed')) {
                                $lyDoKhongDat = 'Tất cả lịch khởi hành của tour đã đóng.';
                            } elseif ($lichKhoiHanhs->every(fn($lich) => $lich->trang_thai === 'full')) {
                                $lyDoKhongDat = 'Tất cả lịch khởi hành của tour đã hết chỗ.';
                            } elseif ($lichKhoiHanhs->contains(fn($lich) => $lich->trang_thai === 'running')) {
                                $lyDoKhongDat = 'Tour đang diễn ra nên không thể nhận thêm khách ở lịch này.';
                            } elseif (!$coLichMoBan) {
                                $lyDoKhongDat = 'Hiện chưa có lịch mở bán và còn chỗ.';
                            }

                            $statusMap = [
                                'available' => [
                                    'label' => 'Đã mở',
                                    'class' => 'status-available',
                                ],
                                'running' => [
                                    'label' => 'Đang diễn ra',
                                    'class' => 'status-running',
                                ],
                                'full' => [
                                    'label' => 'Hết chỗ',
                                    'class' => 'status-full',
                                ],
                                'closed' => [
                                    'label' => 'Đã đóng',
                                    'class' => 'status-closed',
                                ],
                            ];

                            $statusConfig = $lichGanNhat
                                ? ($statusMap[$lichGanNhat->trang_thai] ?? [
                                    'label' => 'Chưa cập nhật',
                                    'class' => 'status-unknown',
                                ])
                                : [
                                    'label' => 'Chưa có lịch',
                                    'class' => 'status-unknown',
                                ];
                        @endphp

                        <div class="tour-bottom">
                            <div>
                                <strong>
                                    {{ number_format(
                                        $lichGanNhat && (int) $lichGanNhat->gia_nguoi_lon > 0
                                            ? $lichGanNhat->gia_nguoi_lon
                                            : ($tour->gia_nguoi_lon > 0 ? $tour->gia_nguoi_lon : $tour->gia_tour),
                                        0,
                                        ',',
                                        '.'
                                    ) }}đ
                                </strong>
                            </div>

                            <div class="tour-actions">
                                <a href="{{ route('Client.danh_sach_tour.show', $tour->id) }}" class="detail-btn">
                                    Xem chi tiết
                                </a>

                                <a
                                    href="{{ route('Client.danh_sach_tour.show', $tour->id) }}#dat-tour"
                                    class="book-now-btn{{ $coLichMoBan ? '' : ' js-tour-message' }}"
                                    @unless($coLichMoBan)
                                        data-message="{{ $lyDoKhongDat }}"
                                        data-block-booking="1"
                                    @endunless
                                >
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
                    <span>{{ $km->ten_khuyen_mai ?? $km->mo_ta ?? 'KHUYẾN MÃI' }}</span>

                    <h3>
                        @php
                            $phanTramGiam = $km->phan_tram_giam ?? null;
                            $soTienGiam = $km->so_tien_giam ?? null;
                        @endphp

                        @if(!empty($phanTramGiam))
                            {{ number_format($phanTramGiam, 0, ',', '.') }}%
                        @elseif(!empty($soTienGiam))
                            {{ number_format($soTienGiam, 0, ',', '.') }}đ
                        @else
                            Ưu đãi
                        @endif
                    </h3>

                    <p>
                        Mã:
                        <b>{{ $km->ma_khuyen_mai ?? 'ĐANG CẬP NHẬT' }}</b>
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


<div class="tour-message-modal" id="tourMessageModal" aria-hidden="true">
    <div class="tour-message-dialog" role="dialog" aria-modal="true" aria-labelledby="tourMessageTitle">
        <div class="tour-message-icon">
            <i class="fa-solid fa-circle-info"></i>
        </div>

        <h3 id="tourMessageTitle">Chưa thể đặt tour</h3>
        <p id="tourMessageText">Tour hiện chưa thể đặt.</p>

        <div class="tour-message-actions">
            <button type="button" id="closeTourMessageModal">Đã hiểu</button>
        </div>
    </div>
</div>


<div class="favorite-toast" id="favoriteToast" role="status" aria-live="polite">
    <i class="fa-solid fa-circle-check"></i>
    <span id="favoriteToastText">Đã cập nhật tour yêu thích.</span>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('tourMessageModal');
    const messageText = document.getElementById('tourMessageText');
    const closeButton = document.getElementById('closeTourMessageModal');

    document.querySelectorAll('.js-tour-message').forEach(function (button) {
        button.addEventListener('click', function (event) {
            if (button.dataset.blockBooking === '1') {
                event.preventDefault();

                messageText.textContent =
                    button.dataset.message || 'Tour hiện chưa thể đặt.';

                modal.classList.add('show');
                modal.setAttribute('aria-hidden', 'false');
            }
        });
    });

    function closeModal() {
        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');
    }

    closeButton.addEventListener('click', closeModal);

    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            closeModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.tour-card-clickable').forEach(function (card) {
        const detailUrl = card.dataset.detailUrl;

        function goToDetail() {
            if (detailUrl) {
                window.location.href = detailUrl;
            }
        }

        card.addEventListener('click', function (event) {
            /*
             * Không chuyển trang khi khách bấm vào:
             * - nút yêu thích
             * - nút xem chi tiết
             * - nút đặt tour
             * - form hoặc nút riêng trong card
             */
            if (event.target.closest('a, button, form, input, select, textarea, label')) {
                return;
            }

            goToDetail();
        });

        card.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                if (event.target.closest('a, button, form, input, select, textarea, label')) {
                    return;
                }

                event.preventDefault();
                goToDetail();
            }
        });
    });
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const toast = document.getElementById('favoriteToast');
    const toastText = document.getElementById('favoriteToastText');
    let toastTimer = null;

    function showFavoriteToast(message, isError = false) {
        if (!toast || !toastText) {
            return;
        }

        toastText.textContent = message;
        toast.classList.toggle('error', isError);
        toast.querySelector('i').className = isError
            ? 'fa-solid fa-circle-exclamation'
            : 'fa-solid fa-circle-check';

        toast.classList.add('show');

        window.clearTimeout(toastTimer);
        toastTimer = window.setTimeout(function () {
            toast.classList.remove('show');
        }, 2200);
    }

    document.querySelectorAll('.js-home-favorite-form').forEach(function (form) {
        form.addEventListener('submit', async function (event) {
            event.preventDefault();
            event.stopPropagation();

            const button = form.querySelector('.heart');
            const icon = button?.querySelector('i');

            if (!button || !icon || button.classList.contains('is-loading')) {
                return;
            }

            const isFavorite = form.dataset.favorite === '1';
            button.classList.add('is-loading');
            button.disabled = true;

            try {
                const formData = new FormData(form);

                const response = await fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json, text/html'
                    }
                });

                if (!response.ok) {
                    throw new Error('Không thể cập nhật tour yêu thích.');
                }

                const nextFavoriteState = !isFavorite;
                form.dataset.favorite = nextFavoriteState ? '1' : '0';
                form.action = nextFavoriteState
                    ? form.dataset.destroyUrl
                    : form.dataset.storeUrl;

                let methodInput = form.querySelector('.favorite-method-input');

                if (nextFavoriteState) {
                    if (!methodInput) {
                        methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';
                        methodInput.className = 'favorite-method-input';
                        form.appendChild(methodInput);
                    }
                } else {
                    methodInput?.remove();
                }

                button.classList.toggle('active', nextFavoriteState);
                button.setAttribute('aria-pressed', nextFavoriteState ? 'true' : 'false');
                button.title = nextFavoriteState
                    ? 'Bỏ yêu thích'
                    : 'Thêm vào yêu thích';
                button.setAttribute(
                    'aria-label',
                    nextFavoriteState ? 'Bỏ yêu thích' : 'Thêm vào yêu thích'
                );

                icon.classList.toggle('fa-solid', nextFavoriteState);
                icon.classList.toggle('fa-regular', !nextFavoriteState);

                showFavoriteToast(
                    nextFavoriteState
                        ? 'Đã lưu tour vào danh sách yêu thích.'
                        : 'Đã xóa tour khỏi danh sách yêu thích.'
                );
            } catch (error) {
                showFavoriteToast(
                    'Cập nhật yêu thích thất bại. Hãy tải lại trang rồi thử lại.',
                    true
                );
            } finally {
                button.classList.remove('is-loading');
                button.disabled = false;
            }
        });
    });
});
</script>


</main>




@endsection