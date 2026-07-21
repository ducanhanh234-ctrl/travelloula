@extends('layouts.app')

@section('title', 'Trang chủ - Travelloula')

@section('content')


@php
    $favoriteTourIds = $favoriteTourIds ?? [];
    $homeReviews = $homeReviews ?? collect();
    $reviewStatsByTour = $reviewStatsByTour ?? collect();
    $totalReviews = $totalReviews ?? 0;
    $avgRating = (float) ($avgRating ?? 0);
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


/* =========================================================
   TRANG CHỦ RESPONSIVE MỌI THIẾT BỊ
   TV / DESKTOP / LAPTOP / TABLET / MOBILE
   ========================================================= */
html,
body{
    width:100%;
    max-width:100%;
    overflow-x:hidden;
}

.home-container,
.hero-content{
    width:min(1680px,calc(100% - clamp(28px,5vw,120px))) !important;
    max-width:1680px;
    margin-left:auto;
    margin-right:auto;
}

.home-hero-static{
    min-height:clamp(520px,40vw,720px) !important;
    padding:clamp(54px,6vw,92px) 0;
}

.home-hero-static .hero-content{
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.hero-content h1{
    font-size:clamp(40px,4.2vw,70px);
}

.hero-content h2{
    font-size:clamp(31px,3.6vw,58px);
}

.hero-content p{
    font-size:clamp(16px,1.25vw,21px);
}

/* Tìm kiếm */
.search-box{
    width:100%;
    grid-template-columns:
        minmax(220px,1.25fr)
        minmax(170px,1fr)
        minmax(180px,1fr)
        minmax(140px,.8fr)
        minmax(180px,.9fr);
}

.search-item{
    min-width:0;
    padding:
        clamp(17px,1.6vw,25px)
        clamp(18px,1.7vw,30px);
}

.search-item > div{
    min-width:0;
    width:100%;
}

.search-item input{
    min-width:0;
}

/* Thống kê */
.stats-box{
    grid-template-columns:repeat(4,minmax(0,1fr));
    padding:
        clamp(22px,2vw,34px)
        clamp(18px,2.4vw,42px);
}

.stat-item{
    min-width:0;
    padding:0 clamp(15px,2vw,34px);
}

.stat-item h3{
    font-size:clamp(24px,2vw,34px);
}

/* Tour */
.tour-grid{
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:clamp(20px,2vw,32px);
}

.tour-card{
    min-width:0;
}

.tour-img{
    height:auto;
    flex-basis:auto;
    aspect-ratio:16/10;
}

.tour-body h3{
    height:auto;
    min-height:2.7em;
}

.rating span{
    color:#64748b;
}

.tour-bottom{
    margin-top:auto;
}

/* Điểm đến */
.destination-grid{
    grid-template-columns:repeat(6,minmax(0,1fr));
}

/* Review thật */
.review-section{
    padding:clamp(58px,6vw,96px) 0;
}

.review-section-heading{
    display:grid;
    grid-template-columns:minmax(0,1fr) auto;
    align-items:end;
    gap:28px;
    margin-bottom:32px;
}

.review-section-heading > div:first-child > span{
    display:block;
    margin-bottom:8px;
    color:#0757d8;
    font-size:12px;
    font-weight:900;
    letter-spacing:1.1px;
}

.review-section-heading .big-title{
    margin:0;
    text-align:left;
    font-size:clamp(30px,2.7vw,46px);
}

.review-section-heading p{
    max-width:720px;
    margin:10px 0 0;
    color:#64748b;
    line-height:1.7;
}

.review-summary{
    min-width:250px;
    padding:17px 20px;
    border-radius:18px;
    display:flex;
    align-items:center;
    gap:15px;
    background:#fff;
    border:1px solid #bfdbfe;
    box-shadow:0 12px 30px rgba(7,87,216,.08);
}

.review-summary > strong{
    color:#0757d8;
    font-size:42px;
    line-height:1;
}

.review-summary-stars,
.review-stars{
    display:flex;
    gap:4px;
}

.review-summary-stars i,
.review-stars i{
    color:#cbd5e1;
}

.review-summary-stars i.active,
.review-stars i.active{
    color:#f59e0b;
}

.review-summary span{
    display:block;
    margin-top:5px;
    color:#64748b;
    font-size:12px;
    font-weight:800;
}

.review-grid{
    grid-template-columns:repeat(3,minmax(0,1fr));
    align-items:stretch;
    gap:clamp(18px,2vw,28px);
}

.review-card{
    min-width:0;
    height:100%;
    padding:24px;
    display:flex;
    flex-direction:column;
    border:1px solid #dbe5f1;
    background:linear-gradient(180deg,#fff,#fbfdff);
}

.review-card-top{
    display:grid;
    grid-template-columns:auto minmax(0,1fr) auto;
    align-items:center;
    gap:11px;
}

.review-avatar{
    width:44px;
    height:44px;
    border-radius:50%;
    display:grid;
    place-items:center;
    color:#fff;
    background:linear-gradient(135deg,#0757d8,#38bdf8);
    font-weight:900;
}

.review-person{
    min-width:0;
}

.review-person h4{
    margin:0 0 5px;
    color:#0f172a;
    font-size:15px;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.review-card time{
    color:#94a3b8;
    font-size:12px;
    white-space:nowrap;
}

.review-card > h3{
    margin:17px 0 7px;
    color:#0f172a;
    font-size:18px;
}

.review-content{
    margin:14px 0 20px !important;
    color:#475569;
    display:-webkit-box;
    -webkit-line-clamp:4;
    -webkit-box-orient:vertical;
    overflow:hidden;
}

.review-tour-link{
    margin-top:auto;
    display:flex;
    align-items:center;
    gap:7px;
    color:#0757d8;
    font-size:13px;
    font-weight:900;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.review-empty-state{
    padding:50px 24px;
    border:1px dashed #bfdbfe;
    border-radius:20px;
    text-align:center;
    background:#fff;
}

.review-empty-state i{
    color:#0757d8;
    font-size:42px;
}

.review-empty-state h3{
    margin:13px 0 7px;
}

.review-empty-state p{
    color:#64748b;
}

/* TV lớn */
@media(min-width:1920px){
    .home-container,
    .hero-content{
        width:min(1840px,calc(100% - 140px)) !important;
        max-width:1840px;
    }

    .tour-grid{
        grid-template-columns:repeat(5,minmax(0,1fr));
    }

    .destination-grid{
        grid-template-columns:repeat(8,minmax(0,1fr));
    }
}

/* Laptop nhỏ */
@media(max-width:1366px){
    .home-container,
    .hero-content{
        width:calc(100% - 48px) !important;
    }

    .search-box{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .search-btn{
        grid-column:1/-1;
    }

    .stats-box{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .stat-item{
        border-right:0;
        padding:18px 24px;
    }

    .stat-item:nth-child(odd){
        border-right:1px solid #e5e7eb;
    }

    .stat-item:nth-child(-n+2){
        border-bottom:1px solid #e5e7eb;
    }

    .tour-grid{
        grid-template-columns:repeat(3,minmax(0,1fr));
    }

    .destination-grid{
        grid-template-columns:repeat(4,minmax(0,1fr));
    }
}

/* Tablet */
@media(max-width:960px){
    .home-hero-static{
        min-height:auto !important;
        padding:70px 0 115px;
    }

    .stats-wrap{
        margin-top:-76px;
    }

    .tour-grid,
    .why-grid,
    .review-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .destination-grid{
        grid-template-columns:repeat(3,minmax(0,1fr));
    }

    .promo-section{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .review-section-heading{
        grid-template-columns:1fr;
        align-items:start;
    }

    .review-summary{
        width:100%;
        min-width:0;
    }
}

/* Điện thoại */
@media(max-width:640px){
    .home-container,
    .hero-content{
        width:calc(100% - 24px) !important;
    }

    .home-hero-static{
        padding:54px 0 34px;
    }

    .hero-content h1{
        font-size:36px;
    }

    .hero-content h2{
        margin-top:6px;
        font-size:29px;
    }

    .hero-content h2 i{
        margin-left:8px;
        font-size:24px;
    }

    .hero-content p{
        margin-bottom:24px;
        font-size:15px;
    }

    .search-box{
        grid-template-columns:1fr;
        border-radius:14px;
    }

    .search-item{
        border-right:0;
        border-bottom:1px solid #e5e7eb;
        padding:16px 18px;
    }

    .search-btn{
        grid-column:auto;
        width:auto;
        height:54px;
    }

    .stats-wrap{
        margin-top:20px;
    }

    .stats-box{
        grid-template-columns:1fr;
        padding:10px 18px;
    }

    .stat-item,
    .stat-item:nth-child(odd),
    .stat-item:nth-child(-n+2){
        border-right:0;
        border-bottom:1px solid #e5e7eb;
        padding:18px 4px;
    }

    .stat-item:last-child{
        border-bottom:0;
    }

    .home-section{
        padding-top:48px;
    }

    .section-head{
        align-items:flex-start;
        gap:12px;
    }

    .section-head h2{
        font-size:25px;
    }

    .tour-grid,
    .destination-grid,
    .why-grid,
    .review-grid,
    .promo-section{
        grid-template-columns:1fr;
    }

    .destination-card{
        height:105px;
    }

    .tour-actions{
        width:100%;
    }

    .tour-actions a{
        flex:1;
    }

    .review-section-heading .big-title{
        font-size:30px;
    }

    .review-card-top{
        grid-template-columns:auto minmax(0,1fr);
    }

    .review-card time{
        grid-column:2;
    }

    .review-summary{
        align-items:flex-start;
    }

    .favorite-toast{
        left:16px;
        right:16px;
        bottom:16px;
        max-width:none;
    }
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
                    <h3>{{ number_format($avgRating, 1) }}/5</h3>
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

                    $tourReviewStat = $reviewStatsByTour->get($tour->id);
                    $tourAverageRating = (float) ($tourReviewStat->diem_trung_binh ?? 0);
                    $tourReviewCount = (int) ($tourReviewStat->tong_danh_gia ?? 0);
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

                            @if($tourReviewCount > 0)
                                {{ number_format($tourAverageRating, 1) }}/5
                                <span>({{ $tourReviewCount }} đánh giá)</span>
                            @else
                                <span>Chưa có đánh giá</span>
                            @endif
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
        <div class="review-section-heading">
            <div>
                <span>ĐÁNH GIÁ ĐÃ ĐƯỢC DUYỆT</span>
                <h2 class="big-title">Khách Hàng Đánh Giá</h2>
                <p>
                    Dữ liệu được lấy trực tiếp từ những đánh giá tour đã được
                    quản trị viên xét duyệt.
                </p>
            </div>

            <div class="review-summary">
                <strong>{{ number_format($avgRating, 1) }}</strong>

                <div>
                    <div class="review-summary-stars">
                        @for($star = 1; $star <= 5; $star++)
                            <i class="fa-solid fa-star {{ $star <= round($avgRating) ? 'active' : '' }}"></i>
                        @endfor
                    </div>

                    <span>{{ $totalReviews }} đánh giá đã duyệt</span>
                </div>
            </div>
        </div>

        @if($homeReviews->count())
            <div class="review-grid">
                @foreach($homeReviews as $review)
                    <article class="review-card">
                        <div class="review-card-top">
                            <div class="review-avatar">
                                {{ mb_strtoupper(mb_substr($review->ho_ten ?? 'K', 0, 1)) }}
                            </div>

                            <div class="review-person">
                                <h4>{{ $review->ho_ten ?? 'Khách hàng' }}</h4>

                                <div class="review-stars">
                                    @for($star = 1; $star <= 5; $star++)
                                        <i class="fa-solid fa-star {{ $star <= (int) $review->so_sao ? 'active' : '' }}"></i>
                                    @endfor
                                </div>
                            </div>

                            @if($review->thoi_gian_danh_gia)
                                <time>
                                    {{ \Carbon\Carbon::parse($review->thoi_gian_danh_gia)->format('d/m/Y') }}
                                </time>
                            @endif
                        </div>

                        @if(!empty($review->tieu_de))
                            <h3>{{ $review->tieu_de }}</h3>
                        @endif

                        <p class="review-content">
                            “{{ $review->noi_dung_danh_gia ?? 'Khách hàng chưa nhập nội dung đánh giá.' }}”
                        </p>

                        @if(!empty($review->ten_tour))
                            <a
                                href="{{ route('Client.danh_sach_tour.show', $review->tour_id) }}#danh-gia"
                                class="review-tour-link"
                            >
                                <i class="fa-solid fa-location-dot"></i>
                                {{ $review->ten_tour }}
                            </a>
                        @endif
                    </article>
                @endforeach
            </div>
        @else
            <div class="review-empty-state">
                <i class="fa-regular fa-comment-dots"></i>
                <h3>Chưa có đánh giá đã duyệt</h3>
                <p>Các đánh giá thật của khách hàng sẽ được hiển thị tại đây.</p>
            </div>
        @endif
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