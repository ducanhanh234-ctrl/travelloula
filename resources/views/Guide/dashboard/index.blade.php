@extends('layouts.guide')

@section('title', 'Dashboard Hướng dẫn viên - Travelloula')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">
        Dashboard
    </li>
@endsection

@section('styles')
<style>
:root{
    --gd-primary:#2563eb;
    --gd-primary-dark:#1d4ed8;
    --gd-cyan:#38bdf8;
    --gd-navy:#0f172a;
    --gd-slate:#334155;
    --gd-muted:#64748b;
    --gd-line:#e2eaf4;
    --gd-soft:#f7fbff;
    --gd-white:#ffffff;
    --gd-green:#10b981;
    --gd-amber:#f59e0b;
    --gd-red:#ef4444;
    --gd-violet:#8b5cf6;
}

.guide-dashboard{
    width:100%;
    padding-bottom:34px;
    color:var(--gd-navy);
}

/* HERO */
.guide-dashboard-hero{
    position:relative;
    overflow:hidden;
    min-height:248px;
    margin-bottom:18px;
    padding:34px;
    border:1px solid rgba(96,165,250,.22);
    border-radius:28px;
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:28px;
    color:#fff;
    background:
        radial-gradient(circle at 16% 10%,rgba(56,189,248,.34),transparent 28%),
        radial-gradient(circle at 87% 115%,rgba(37,99,235,.33),transparent 36%),
        linear-gradient(135deg,#0f172a 0%,#172554 45%,#1d4ed8 100%);
    box-shadow:
        0 24px 62px rgba(15,23,42,.18),
        inset 0 1px 0 rgba(255,255,255,.10);
}

.guide-dashboard-hero::before,
.guide-dashboard-hero::after{
    content:"";
    position:absolute;
    border-radius:50%;
    pointer-events:none;
}

.guide-dashboard-hero::before{
    width:190px;
    height:190px;
    right:21%;
    top:-120px;
    border:1px solid rgba(255,255,255,.10);
    background:rgba(255,255,255,.035);
}

.guide-dashboard-hero::after{
    width:130px;
    height:130px;
    right:4%;
    bottom:-72px;
    background:rgba(56,189,248,.14);
}

.guide-hero-copy,
.guide-hero-actions{
    position:relative;
    z-index:2;
}

.guide-hero-copy{
    max-width:760px;
}

.guide-eyebrow{
    display:inline-flex;
    align-items:center;
    gap:8px;
    margin-bottom:16px;
    padding:8px 12px;
    border:1px solid rgba(255,255,255,.18);
    border-radius:999px;
    color:#dbeafe;
    background:rgba(255,255,255,.08);
    backdrop-filter:blur(10px);
    font-size:11px;
    font-weight:850;
    letter-spacing:.45px;
}

.guide-dashboard-hero h1{
    margin:0;
    color:#fff;
    font-size:clamp(31px,3.4vw,48px);
    line-height:1.08;
    font-weight:900;
    letter-spacing:-1.5px;
}

.guide-dashboard-hero h1 span{
    color:#93c5fd;
}

.guide-dashboard-hero p{
    max-width:700px;
    margin:14px 0 0;
    color:#cbd5e1;
    font-size:14px;
    line-height:1.72;
}

.guide-hero-meta{
    display:flex;
    gap:16px;
    margin-top:20px;
    flex-wrap:wrap;
}

.guide-hero-meta span{
    display:inline-flex;
    align-items:center;
    gap:7px;
    color:#bfdbfe;
    font-size:10px;
    font-weight:700;
}

.guide-hero-actions{
    display:flex;
    gap:9px;
    flex-wrap:wrap;
}

.guide-hero-button{
    min-height:44px;
    padding:0 15px;
    border-radius:13px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    text-decoration:none;
    font-size:11px;
    font-weight:850;
    transition:.2s ease;
}

.guide-hero-button.primary{
    color:#0f172a;
    background:#fff;
    box-shadow:0 10px 24px rgba(15,23,42,.16);
}

.guide-hero-button.secondary{
    color:#e0f2fe;
    border:1px solid rgba(255,255,255,.20);
    background:rgba(255,255,255,.08);
    backdrop-filter:blur(9px);
}

.guide-hero-button:hover{
    transform:translateY(-2px);
}

/* PROFILE WARNING */
.guide-profile-warning{
    margin-bottom:18px;
    padding:16px 18px;
    border:1px solid #fde68a;
    border-radius:16px;
    display:flex;
    align-items:flex-start;
    gap:12px;
    color:#92400e;
    background:#fffbeb;
}

.guide-profile-warning i{
    margin-top:2px;
}

.guide-profile-warning strong{
    display:block;
    margin-bottom:3px;
    font-size:13px;
}

.guide-profile-warning span{
    font-size:11px;
    line-height:1.6;
}

/* KPI */
.guide-kpi-grid{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:14px;
    margin-bottom:14px;
}

.guide-kpi-card{
    position:relative;
    overflow:hidden;
    min-height:176px;
    padding:19px;
    border:1px solid var(--gd-line);
    border-radius:20px;
    background:#fff;
    box-shadow:0 10px 30px rgba(15,23,42,.055);
    transition:.22s ease;
}

.guide-kpi-card:hover{
    transform:translateY(-3px);
    border-color:#bfdbfe;
    box-shadow:0 17px 38px rgba(37,99,235,.10);
}

.guide-kpi-top{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
}

.guide-kpi-icon{
    width:43px;
    height:43px;
    border-radius:14px;
    display:grid;
    place-items:center;
    font-size:16px;
}

.kpi-assigned .guide-kpi-icon{color:#2563eb;background:#eff6ff}
.kpi-today .guide-kpi-icon{color:#0284c7;background:#f0f9ff}
.kpi-passenger .guide-kpi-icon{color:#047857;background:#ecfdf5}
.kpi-incident .guide-kpi-icon{color:#dc2626;background:#fef2f2}

.guide-kpi-badge{
    min-height:27px;
    padding:0 8px;
    border-radius:999px;
    display:inline-flex;
    align-items:center;
    font-size:9px;
    font-weight:900;
    color:#475569;
    background:#f1f5f9;
}

.guide-kpi-content{
    margin-top:19px;
}

.guide-kpi-content > span{
    display:block;
    margin-bottom:6px;
    color:#64748b;
    font-size:10px;
    font-weight:750;
}

.guide-kpi-content > strong{
    display:block;
    color:#0f172a;
    font-size:27px;
    line-height:1.05;
    font-weight:900;
    letter-spacing:-.8px;
}

.guide-kpi-content small{
    display:block;
    margin-top:9px;
    color:#94a3b8;
    font-size:9px;
    line-height:1.4;
    font-weight:650;
}

.guide-kpi-accent{
    position:absolute;
    left:19px;
    right:19px;
    bottom:0;
    height:3px;
    border-radius:999px 999px 0 0;
}

.kpi-assigned .guide-kpi-accent{background:linear-gradient(90deg,#2563eb,transparent)}
.kpi-today .guide-kpi-accent{background:linear-gradient(90deg,#38bdf8,transparent)}
.kpi-passenger .guide-kpi-accent{background:linear-gradient(90deg,#10b981,transparent)}
.kpi-incident .guide-kpi-accent{background:linear-gradient(90deg,#ef4444,transparent)}

/* MAIN GRID */
.guide-main-grid,
.guide-secondary-grid{
    display:grid;
    gap:14px;
    margin-bottom:14px;
}

.guide-main-grid{
    grid-template-columns:minmax(0,1.5fr) minmax(310px,.7fr);
}

.guide-secondary-grid{
    grid-template-columns:1.15fr .85fr .72fr;
}

.guide-panel{
    min-width:0;
    padding:19px;
    border:1px solid var(--gd-line);
    border-radius:20px;
    background:#fff;
    box-shadow:0 10px 30px rgba(15,23,42,.05);
}

.guide-panel-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;
    margin-bottom:17px;
}

.guide-panel-kicker{
    display:block;
    margin-bottom:4px;
    color:#2563eb;
    font-size:8px;
    font-weight:900;
    text-transform:uppercase;
    letter-spacing:1px;
}

.guide-panel-header h2{
    margin:0;
    color:#0f172a;
    font-size:17px;
    line-height:1.25;
    font-weight:900;
    letter-spacing:-.4px;
}

.guide-panel-link{
    display:inline-flex;
    align-items:center;
    gap:6px;
    color:#64748b;
    text-decoration:none;
    white-space:nowrap;
    font-size:9px;
    font-weight:800;
}

.guide-panel-link:hover{
    color:#2563eb;
}

/* CURRENT TOUR */
.current-tour-card{
    position:relative;
    overflow:hidden;
    min-height:318px;
    border:1px solid #dbeafe;
    border-radius:20px;
    background:
        linear-gradient(135deg,#f8fbff,#ffffff);
}

.current-tour-cover{
    position:absolute;
    inset:0 auto 0 0;
    width:40%;
    min-width:280px;
    overflow:hidden;
    background:#eaf2ff;
}

.current-tour-cover img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.current-tour-cover::after{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(90deg,rgba(15,23,42,.05),rgba(15,23,42,.10));
}

.current-tour-content{
    min-height:318px;
    margin-left:40%;
    padding:24px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.current-tour-state{
    display:inline-flex;
    align-items:center;
    gap:7px;
    width:max-content;
    margin-bottom:11px;
    padding:7px 10px;
    border-radius:999px;
    color:#047857;
    background:#ecfdf5;
    font-size:8px;
    font-weight:900;
    text-transform:uppercase;
    letter-spacing:.55px;
}

.current-tour-state.upcoming{
    color:#1d4ed8;
    background:#eff6ff;
}

.current-tour-content h3{
    margin:0;
    color:#0f172a;
    font-size:24px;
    line-height:1.28;
    font-weight:900;
    letter-spacing:-.7px;
}

.current-tour-route{
    margin-top:7px;
    color:#64748b;
    font-size:10px;
    font-weight:700;
}

.current-tour-route i{
    margin:0 5px;
    color:#93c5fd;
}

.current-tour-info-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:9px;
    margin-top:18px;
}

.current-tour-info{
    min-width:0;
    padding:10px;
    border:1px solid #e7edf5;
    border-radius:12px;
    display:flex;
    align-items:center;
    gap:9px;
    background:#fff;
}

.current-tour-info > i{
    width:29px;
    height:29px;
    flex:0 0 29px;
    border-radius:9px;
    display:grid;
    place-items:center;
    color:#2563eb;
    background:#eff6ff;
    font-size:9px;
}

.current-tour-info span{
    display:block;
    margin-bottom:2px;
    color:#94a3b8;
    font-size:7px;
    font-weight:800;
    text-transform:uppercase;
}

.current-tour-info strong{
    display:block;
    overflow:hidden;
    color:#334155;
    font-size:9px;
    font-weight:850;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.current-tour-actions{
    display:flex;
    gap:8px;
    margin-top:17px;
    flex-wrap:wrap;
}

.current-tour-action{
    min-height:39px;
    padding:0 12px;
    border-radius:11px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:7px;
    text-decoration:none;
    font-size:9px;
    font-weight:850;
}

.current-tour-action.primary{
    color:#fff;
    background:linear-gradient(135deg,#3b82f6,#2563eb);
    box-shadow:0 8px 18px rgba(37,99,235,.16);
}

.current-tour-action.secondary{
    color:#2563eb;
    border:1px solid #bfdbfe;
    background:#fff;
}

.current-tour-empty{
    min-height:300px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-direction:column;
    text-align:center;
}

.current-tour-empty span{
    width:62px;
    height:62px;
    margin-bottom:12px;
    border-radius:19px;
    display:grid;
    place-items:center;
    color:#2563eb;
    background:#eff6ff;
    font-size:22px;
}

.current-tour-empty strong{
    color:#334155;
    font-size:14px;
    font-weight:900;
}

.current-tour-empty small{
    max-width:390px;
    margin-top:5px;
    color:#94a3b8;
    font-size:9px;
    line-height:1.6;
}

/* CHECKIN */
.checkin-overview{
    min-height:318px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-direction:column;
}

.checkin-ring{
    --percent:0;
    width:156px;
    height:156px;
    border-radius:50%;
    display:grid;
    place-items:center;
    background:
        conic-gradient(
            #2563eb calc(var(--percent) * 1%),
            #e8eef6 0
        );
}

.checkin-ring::before{
    content:"";
    width:124px;
    height:124px;
    border-radius:50%;
    background:#fff;
}

.checkin-ring-content{
    position:absolute;
    text-align:center;
}

.checkin-ring-content strong{
    display:block;
    color:#0f172a;
    font-size:25px;
    line-height:1;
    font-weight:900;
}

.checkin-ring-content span{
    display:block;
    margin-top:4px;
    color:#94a3b8;
    font-size:8px;
}

.checkin-ring-wrap{
    position:relative;
}

.checkin-numbers{
    width:100%;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:8px;
    margin-top:18px;
}

.checkin-number{
    padding:10px;
    border:1px solid #edf2f7;
    border-radius:12px;
    text-align:center;
    background:#fbfdff;
}

.checkin-number span{
    display:block;
    color:#94a3b8;
    font-size:7px;
    font-weight:800;
    text-transform:uppercase;
}

.checkin-number strong{
    display:block;
    margin-top:3px;
    color:#334155;
    font-size:13px;
    font-weight:900;
}

/* UPCOMING */
.upcoming-list,
.activity-list,
.incident-list,
.quick-guide-actions{
    display:grid;
    gap:8px;
}

.upcoming-item{
    padding:10px;
    border:1px solid #edf2f7;
    border-radius:13px;
    display:flex;
    align-items:center;
    gap:10px;
    background:#fbfdff;
}

.upcoming-date{
    width:42px;
    height:48px;
    flex:0 0 42px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-direction:column;
    color:#1d4ed8;
    background:#eff6ff;
}

.upcoming-date strong{
    font-size:14px;
    line-height:1;
    font-weight:900;
}

.upcoming-date span{
    margin-top:3px;
    font-size:7px;
    font-weight:800;
}

.upcoming-content{
    min-width:0;
    flex:1;
}

.upcoming-title{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:7px;
}

.upcoming-title strong{
    overflow:hidden;
    color:#334155;
    font-size:9px;
    font-weight:850;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.upcoming-title span{
    color:#2563eb;
    font-size:7px;
    font-weight:800;
    white-space:nowrap;
}

.upcoming-meta{
    margin-top:5px;
    display:flex;
    gap:9px;
    flex-wrap:wrap;
    color:#94a3b8;
    font-size:7px;
}

/* ACTIVITY */
.activity-item{
    padding:10px;
    border:1px solid #edf2f7;
    border-radius:12px;
    display:flex;
    align-items:flex-start;
    gap:9px;
    background:#fbfdff;
}

.activity-icon{
    width:31px;
    height:31px;
    flex:0 0 31px;
    border-radius:10px;
    display:grid;
    place-items:center;
    color:#2563eb;
    background:#eff6ff;
    font-size:9px;
}

.activity-item div{
    min-width:0;
}

.activity-item strong{
    display:block;
    color:#334155;
    font-size:8px;
    font-weight:900;
    text-transform:capitalize;
}

.activity-item p{
    margin:3px 0 0;
    display:-webkit-box;
    overflow:hidden;
    color:#64748b;
    font-size:7px;
    line-height:1.45;
    -webkit-line-clamp:2;
    -webkit-box-orient:vertical;
}

.activity-item small{
    display:block;
    margin-top:4px;
    color:#94a3b8;
    font-size:6px;
}

/* INCIDENT */
.incident-item{
    padding:9px;
    border:1px solid #edf2f7;
    border-radius:12px;
    display:flex;
    align-items:flex-start;
    gap:8px;
    background:#fbfdff;
}

.incident-icon{
    width:30px;
    height:30px;
    flex:0 0 30px;
    border-radius:10px;
    display:grid;
    place-items:center;
    font-size:9px;
}

.incident-icon.cao{color:#dc2626;background:#fef2f2}
.incident-icon.trung_binh{color:#b45309;background:#fff7ed}
.incident-icon.thap{color:#0369a1;background:#f0f9ff}

.incident-item strong{
    display:block;
    overflow:hidden;
    color:#334155;
    font-size:8px;
    font-weight:850;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.incident-item span:not(.incident-icon){
    display:block;
    margin-top:3px;
    color:#94a3b8;
    font-size:7px;
    text-transform:capitalize;
}

.incident-clean{
    min-height:125px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:10px;
}

.incident-clean > span{
    width:42px;
    height:42px;
    border-radius:14px;
    display:grid;
    place-items:center;
    color:#047857;
    background:#ecfdf5;
}

.incident-clean strong{
    display:block;
    color:#334155;
    font-size:9px;
    font-weight:850;
}

.incident-clean small{
    display:block;
    margin-top:4px;
    color:#94a3b8;
    font-size:7px;
}

/* QUICK ACTION */
.quick-guide-action{
    min-height:57px;
    padding:9px;
    border:1px solid #edf2f7;
    border-radius:12px;
    display:grid;
    grid-template-columns:auto 1fr auto;
    align-items:center;
    gap:8px;
    color:inherit;
    text-decoration:none;
    background:#fbfdff;
    transition:.2s ease;
}

.quick-guide-action:hover{
    border-color:#bfdbfe;
    background:#f8fbff;
    transform:translateX(2px);
}

.quick-guide-icon{
    width:34px;
    height:34px;
    border-radius:11px;
    display:grid;
    place-items:center;
    font-size:10px;
}

.quick-guide-icon.blue{color:#2563eb;background:#eff6ff}
.quick-guide-icon.cyan{color:#0284c7;background:#f0f9ff}
.quick-guide-icon.green{color:#047857;background:#ecfdf5}
.quick-guide-icon.red{color:#dc2626;background:#fef2f2}

.quick-guide-action strong{
    display:block;
    color:#334155;
    font-size:8px;
    font-weight:850;
}

.quick-guide-action small{
    display:block;
    margin-top:3px;
    color:#94a3b8;
    font-size:7px;
}

.quick-guide-action > i{
    color:#cbd5e1;
    font-size:7px;
}

.guide-panel-empty{
    padding:25px 12px;
    color:#94a3b8;
    text-align:center;
    font-size:8px;
    font-weight:750;
}

.guide-panel-empty i{
    display:block;
    margin-bottom:8px;
    color:#bfdbfe;
    font-size:19px;
}

@media(max-width:1350px){
    .guide-kpi-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .guide-secondary-grid{
        grid-template-columns:1fr 1fr;
    }

    .guide-quick-panel{
        grid-column:1/-1;
    }

    .quick-guide-actions{
        grid-template-columns:repeat(4,minmax(0,1fr));
    }
}

@media(max-width:1050px){
    .guide-main-grid{
        grid-template-columns:1fr;
    }
}

@media(max-width:850px){
    .guide-dashboard-hero{
        align-items:flex-start;
        flex-direction:column;
    }

    .guide-hero-actions{
        width:100%;
    }

    .guide-hero-button{
        flex:1;
    }

    .guide-secondary-grid{
        grid-template-columns:1fr;
    }

    .guide-quick-panel{
        grid-column:auto;
    }

    .quick-guide-actions{
        grid-template-columns:1fr 1fr;
    }

    .current-tour-cover{
        position:relative;
        width:100%;
        min-width:0;
        height:220px;
    }

    .current-tour-content{
        min-height:0;
        margin-left:0;
    }
}

@media(max-width:620px){
    .guide-dashboard-hero{
        padding:25px 19px;
        border-radius:22px;
    }

    .guide-dashboard-hero h1{
        font-size:30px;
    }

    .guide-kpi-grid{
        grid-template-columns:1fr;
    }

    .guide-panel{
        padding:15px;
        border-radius:17px;
    }

    .guide-panel-header{
        align-items:flex-start;
        flex-direction:column;
        gap:7px;
    }

    .current-tour-info-grid{
        grid-template-columns:1fr;
    }

    .quick-guide-actions{
        grid-template-columns:1fr;
    }
}
</style>
@endsection

@section('content')

@php
    $guideName = $guide->ho_ten ?? (auth()->user()->name ?? 'Hướng dẫn viên');
@endphp

<div class="guide-dashboard">

    @if(!$guide)
        <div class="guide-profile-warning">
            <i class="fa-solid fa-triangle-exclamation"></i>

            <div>
                <strong>Chưa tìm thấy hồ sơ hướng dẫn viên</strong>
                <span>
                    Tài khoản hiện tại chưa liên kết với bản ghi trong bảng
                    huong_dan_viens. Dashboard vẫn hiển thị nhưng chưa thể lấy
                    dữ liệu phân công cá nhân.
                </span>
            </div>
        </div>
    @endif

    {{-- HERO --}}
    <section class="guide-dashboard-hero">
        <div class="guide-hero-copy">
            <span class="guide-eyebrow">
                <i class="fa-solid fa-route"></i>
                Trung tâm vận hành hướng dẫn viên
            </span>

            <h1>
                Chào {{ $guideName }},
                <span>sẵn sàng cho hành trình hôm nay.</span>
            </h1>

            <p>
                Theo dõi tour được phân công, hành khách, tiến độ check-in và
                các công việc vận hành ngay trên một màn hình.
            </p>

            <div class="guide-hero-meta">
                <span>
                    <i class="fa-regular fa-calendar"></i>
                    {{ now()->translatedFormat('l, d/m/Y') }}
                </span>

                @if($guide)
                    <span>
                        <i class="fa-solid fa-circle-check"></i>
                        {{ str_replace('_', ' ', $guide->trang_thai) }}
                    </span>
                @endif
            </div>
        </div>

        <div class="guide-hero-actions">
            <a href="{{ route('Guide.tour-phan-cong.index') }}"
               class="guide-hero-button secondary">
                <i class="fa-solid fa-map"></i>
                Tour của tôi
            </a>

            <a href="{{ route('Guide.checkin.index') }}"
               class="guide-hero-button primary">
                <i class="fa-solid fa-user-check"></i>
                Check-in khách
            </a>
        </div>
    </section>

    {{-- KPI --}}
    <section class="guide-kpi-grid">
        <article class="guide-kpi-card kpi-assigned">
            <div class="guide-kpi-top">
                <span class="guide-kpi-icon">
                    <i class="fa-solid fa-suitcase-rolling"></i>
                </span>

                <span class="guide-kpi-badge">Đã phân công</span>
            </div>

            <div class="guide-kpi-content">
                <span>Tour sắp tới / đang chạy</span>
                <strong>{{ number_format($tongTourDuocPhanCong) }}</strong>
                <small>Lịch thuộc phạm vi phụ trách của bạn</small>
            </div>

            <div class="guide-kpi-accent"></div>
        </article>

        <article class="guide-kpi-card kpi-today">
            <div class="guide-kpi-top">
                <span class="guide-kpi-icon">
                    <i class="fa-solid fa-plane-departure"></i>
                </span>

                <span class="guide-kpi-badge">Hôm nay</span>
            </div>

            <div class="guide-kpi-content">
                <span>Tour đang diễn ra</span>
                <strong>{{ number_format($tourHomNay) }}</strong>
                <small>Tour có lịch bao phủ ngày hiện tại</small>
            </div>

            <div class="guide-kpi-accent"></div>
        </article>

        <article class="guide-kpi-card kpi-passenger">
            <div class="guide-kpi-top">
                <span class="guide-kpi-icon">
                    <i class="fa-solid fa-users"></i>
                </span>

                <span class="guide-kpi-badge">{{ $tyLeCheckInHomNay }}% check-in</span>
            </div>

            <div class="guide-kpi-content">
                <span>Khách sắp phục vụ</span>
                <strong>{{ number_format($tongKhachSapPhucVu) }}</strong>
                <small>
                    {{ number_format($checkInHomNay) }}/{{ number_format($tongCheckInHomNay) }}
                    lượt check-in hôm nay
                </small>
            </div>

            <div class="guide-kpi-accent"></div>
        </article>

        <article class="guide-kpi-card kpi-incident">
            <div class="guide-kpi-top">
                <span class="guide-kpi-icon">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </span>

                <span class="guide-kpi-badge">Cần theo dõi</span>
            </div>

            <div class="guide-kpi-content">
                <span>Sự cố chưa xử lý xong</span>
                <strong>{{ number_format($suCoChuaXuLy) }}</strong>
                <small>Gồm trạng thái chờ xử lý và đang xử lý</small>
            </div>

            <div class="guide-kpi-accent"></div>
        </article>
    </section>

    {{-- TOUR GẦN NHẤT + CHECKIN --}}
    <section class="guide-main-grid">
        <article class="guide-panel">
            <header class="guide-panel-header">
                <div>
                    <span class="guide-panel-kicker">Ưu tiên hiện tại</span>
                    <h2>Tour gần nhất</h2>
                </div>

                <a href="{{ route('Guide.tour-phan-cong.index') }}"
                   class="guide-panel-link">
                    Xem tất cả
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </header>

            @if($tourGanNhat)
                @php
                    $isRunning =
                        \Carbon\Carbon::parse($tourGanNhat->ngay_khoi_hanh)
                            ->startOfDay()
                            ->lte(now()->startOfDay())
                        &&
                        \Carbon\Carbon::parse(
                            $tourGanNhat->ngay_ket_thuc
                            ?? $tourGanNhat->ngay_khoi_hanh
                        )->endOfDay()->gte(now());

                    $image = $tourGanNhat->anh_dai_dien
                        ? asset($tourGanNhat->anh_dai_dien)
                        : 'https://placehold.co/900x600?text=Travelloula';
                @endphp

                <div class="current-tour-card">
                    <div class="current-tour-cover">
                        <img src="{{ $image }}"
                             alt="{{ $tourGanNhat->ten_tour }}">
                    </div>

                    <div class="current-tour-content">
                        <span class="current-tour-state {{ $isRunning ? '' : 'upcoming' }}">
                            <i class="fa-solid {{ $isRunning ? 'fa-circle-play' : 'fa-clock' }}"></i>
                            {{ $isRunning ? 'Đang diễn ra' : 'Sắp khởi hành' }}
                        </span>

                        <h3>{{ $tourGanNhat->ten_tour }}</h3>

                        <div class="current-tour-route">
                            {{ $tourGanNhat->dia_diem_khoi_hanh ?: 'Điểm khởi hành' }}
                            <i class="fa-solid fa-arrow-right"></i>
                            {{ $tourGanNhat->diem_den ?: 'Điểm đến' }}
                        </div>

                        <div class="current-tour-info-grid">
                            <div class="current-tour-info">
                                <i class="fa-regular fa-calendar-days"></i>

                                <div>
                                    <span>Thời gian</span>
                                    <strong>
                                        {{ \Carbon\Carbon::parse($tourGanNhat->ngay_khoi_hanh)->format('d/m/Y') }}
                                        -
                                        {{ \Carbon\Carbon::parse(
                                            $tourGanNhat->ngay_ket_thuc
                                            ?? $tourGanNhat->ngay_khoi_hanh
                                        )->format('d/m/Y') }}
                                    </strong>
                                </div>
                            </div>

                            <div class="current-tour-info">
                                <i class="fa-solid fa-users"></i>

                                <div>
                                    <span>Hành khách</span>
                                    <strong>
                                        {{ number_format($tourGanNhat->so_cho_da_dat) }}
                                        /
                                        {{ number_format($tourGanNhat->so_cho) }}
                                        khách
                                    </strong>
                                </div>
                            </div>

                            <div class="current-tour-info">
                                <i class="fa-solid fa-bus-simple"></i>

                                <div>
                                    <span>Phương tiện</span>
                                    <strong>
                                        {{ $tourGanNhat->loai_phuong_tien ?: 'Chưa cập nhật' }}
                                        @if($tourGanNhat->bien_so_xe)
                                            - {{ $tourGanNhat->bien_so_xe }}
                                        @endif
                                    </strong>
                                </div>
                            </div>

                            <div class="current-tour-info">
                                <i class="fa-solid fa-user-tie"></i>

                                <div>
                                    <span>Tài xế</span>
                                    <strong>
                                        {{ $tourGanNhat->ten_tai_xe ?: 'Chưa cập nhật' }}
                                    </strong>
                                </div>
                            </div>
                        </div>

                        <div class="current-tour-actions">
                            <a href="{{ route('Guide.checkin.index') }}"
                               class="current-tour-action primary">
                                <i class="fa-solid fa-user-check"></i>
                                Điểm danh hành khách
                            </a>

                            <a href="{{ route('Guide.nhatky.index') }}"
                               class="current-tour-action secondary">
                                <i class="fa-solid fa-book-open"></i>
                                Nhật ký tour
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="current-tour-empty">
                    <span>
                        <i class="fa-regular fa-calendar-check"></i>
                    </span>

                    <strong>Chưa có tour sắp tới</strong>

                    <small>
                        Khi admin phân công lịch khởi hành mới, tour sẽ xuất hiện
                        ở khu vực này.
                    </small>
                </div>
            @endif
        </article>

        <article class="guide-panel">
            <header class="guide-panel-header">
                <div>
                    <span class="guide-panel-kicker">Điểm danh hôm nay</span>
                    <h2>Tiến độ check-in</h2>
                </div>
            </header>

            <div class="checkin-overview">
                <div class="checkin-ring-wrap">
                    <div class="checkin-ring"
                         style="--percent: {{ $tyLeCheckInHomNay }}"></div>

                    <div class="checkin-ring-content">
                        <strong>{{ $tyLeCheckInHomNay }}%</strong>
                        <span>đã hoàn tất</span>
                    </div>
                </div>

                <div class="checkin-numbers">
                    <div class="checkin-number">
                        <span>Đã check-in</span>
                        <strong>{{ number_format($checkInHomNay) }}</strong>
                    </div>

                    <div class="checkin-number">
                        <span>Tổng lượt</span>
                        <strong>{{ number_format($tongCheckInHomNay) }}</strong>
                    </div>
                </div>

                <a href="{{ route('Guide.checkin.index') }}"
                   class="current-tour-action primary"
                   style="margin-top:16px;">
                    <i class="fa-solid fa-qrcode"></i>
                    Mở màn hình check-in
                </a>
            </div>
        </article>
    </section>

    {{-- BOTTOM --}}
    <section class="guide-secondary-grid">

        {{-- LỊCH SẮP TỚI --}}
        <article class="guide-panel">
            <header class="guide-panel-header">
                <div>
                    <span class="guide-panel-kicker">Lịch làm việc</span>
                    <h2>Tour sắp tới</h2>
                </div>
            </header>

            <div class="upcoming-list">
                @forelse($lichSapToi as $schedule)
                    @php
                        $daysAway = now()->startOfDay()->diffInDays(
                            \Carbon\Carbon::parse($schedule->ngay_khoi_hanh),
                            false
                        );
                    @endphp

                    <div class="upcoming-item">
                        <div class="upcoming-date">
                            <strong>
                                {{ \Carbon\Carbon::parse($schedule->ngay_khoi_hanh)->format('d') }}
                            </strong>

                            <span>
                                T{{ \Carbon\Carbon::parse($schedule->ngay_khoi_hanh)->format('m') }}
                            </span>
                        </div>

                        <div class="upcoming-content">
                            <div class="upcoming-title">
                                <strong>{{ $schedule->ten_tour }}</strong>

                                <span>
                                    @if($daysAway < 0)
                                        Đang diễn ra
                                    @elseif($daysAway === 0)
                                        Hôm nay
                                    @elseif($daysAway === 1)
                                        Ngày mai
                                    @else
                                        Còn {{ $daysAway }} ngày
                                    @endif
                                </span>
                            </div>

                            <div class="upcoming-meta">
                                <span>
                                    <i class="fa-solid fa-users"></i>
                                    {{ $schedule->so_cho_da_dat }}/{{ $schedule->so_cho }}
                                    khách
                                </span>

                                <span>
                                    <i class="fa-solid fa-bus-simple"></i>
                                    {{ $schedule->bien_so_xe ?: 'Chưa có xe' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="guide-panel-empty">
                        <i class="fa-regular fa-calendar-xmark"></i>
                        Chưa có lịch sắp tới.
                    </div>
                @endforelse
            </div>
        </article>

        {{-- HOẠT ĐỘNG --}}
        <article class="guide-panel">
            <header class="guide-panel-header">
                <div>
                    <span class="guide-panel-kicker">Dòng thời gian</span>
                    <h2>Hoạt động gần đây</h2>
                </div>
            </header>

            <div class="activity-list">
                @forelse($hoatDongGanDay as $activity)
                    <div class="activity-item">
                        <span class="activity-icon">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </span>

                        <div>
                            <strong>
                                {{ str_replace('_', ' ', $activity->hanh_dong) }}
                            </strong>

                            <p>{{ $activity->noi_dung }}</p>

                            <small>
                                {{ $activity->created_at
                                    ? \Carbon\Carbon::parse($activity->created_at)->diffForHumans()
                                    : ''
                                }}
                            </small>
                        </div>
                    </div>
                @empty
                    <div class="guide-panel-empty">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        Chưa có hoạt động gần đây.
                    </div>
                @endforelse
            </div>
        </article>

        {{-- SỰ CỐ + QUICK --}}
        <article class="guide-panel guide-quick-panel">
            <header class="guide-panel-header">
                <div>
                    <span class="guide-panel-kicker">Điều hành nhanh</span>
                    <h2>Công cụ của bạn</h2>
                </div>
            </header>

            <div class="quick-guide-actions">
                <a href="{{ route('Guide.tour-phan-cong.index') }}"
                   class="quick-guide-action">
                    <span class="quick-guide-icon blue">
                        <i class="fa-solid fa-route"></i>
                    </span>

                    <div>
                        <strong>Tour được phân công</strong>
                        <small>Xem lịch làm việc</small>
                    </div>

                    <i class="fa-solid fa-chevron-right"></i>
                </a>

                <a href="{{ route('Guide.checkin.index') }}"
                   class="quick-guide-action">
                    <span class="quick-guide-icon cyan">
                        <i class="fa-solid fa-user-check"></i>
                    </span>

                    <div>
                        <strong>Check-in khách</strong>
                        <small>Điểm danh hành khách</small>
                    </div>

                    <i class="fa-solid fa-chevron-right"></i>
                </a>

                <a href="{{ route('Guide.nhatky.index') }}"
                   class="quick-guide-action">
                    <span class="quick-guide-icon green">
                        <i class="fa-solid fa-book-open"></i>
                    </span>

                    <div>
                        <strong>Nhật ký HDV</strong>
                        <small>Cập nhật diễn biến tour</small>
                    </div>

                    <i class="fa-solid fa-chevron-right"></i>
                </a>

                <a href="{{ route('Guide.baocaosuco.index') }}"
                   class="quick-guide-action">
                    <span class="quick-guide-icon red">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </span>

                    <div>
                        <strong>Báo cáo sự cố</strong>
                        <small>{{ $suCoChuaXuLy }} sự cố đang theo dõi</small>
                    </div>

                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>

            <div style="margin-top:18px;">
                <span class="guide-panel-kicker">Sự cố gần đây</span>
            </div>

            <div class="incident-list" style="margin-top:8px;">
                @forelse($suCoGanDay->take(3) as $incident)
                    <div class="incident-item">
                        <span class="incident-icon {{ $incident->muc_do }}">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </span>

                        <div>
                            <strong>{{ $incident->tieu_de }}</strong>

                            <span>
                                {{ str_replace('_', ' ', $incident->muc_do) }}
                                •
                                {{ str_replace('_', ' ', $incident->trang_thai) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="incident-clean">
                        <span>
                            <i class="fa-solid fa-shield-halved"></i>
                        </span>

                        <div>
                            <strong>Không có sự cố mới</strong>
                            <small>Hành trình đang ổn định.</small>
                        </div>
                    </div>
                @endforelse
            </div>
        </article>
    </section>

</div>
@endsection
