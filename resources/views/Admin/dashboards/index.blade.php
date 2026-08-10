@extends('layouts.admin')

@section('title', 'Dashboard - Travelloula Admin')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
@endsection

@section('styles')
<style>
:root{
    --db-blue:#2563eb;
    --db-blue-dark:#1d4ed8;
    --db-cyan:#38bdf8;
    --db-navy:#0f172a;
    --db-slate:#334155;
    --db-muted:#64748b;
    --db-line:#e3ebf5;
    --db-soft:#f7faff;
    --db-white:#fff;
    --db-green:#10b981;
    --db-amber:#f59e0b;
    --db-red:#ef4444;
    --db-violet:#8b5cf6;
}

.premium-dashboard{
    width:100%;
    padding-bottom:32px;
    color:var(--db-navy);
}

/* HERO */
.dashboard-hero{
    position:relative;
    overflow:hidden;
    min-height:235px;
    margin-bottom:18px;
    padding:32px 34px;
    border:1px solid rgba(96,165,250,.22);
    border-radius:26px;
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:28px;
    color:#fff;
    background:
        radial-gradient(circle at 18% 8%,rgba(56,189,248,.32),transparent 28%),
        radial-gradient(circle at 90% 110%,rgba(59,130,246,.30),transparent 34%),
        linear-gradient(135deg,#0f172a 0%,#172554 44%,#1d4ed8 100%);
    box-shadow:
        0 24px 60px rgba(15,23,42,.18),
        inset 0 1px 0 rgba(255,255,255,.10);
}

.dashboard-hero::before,
.dashboard-hero::after{
    content:"";
    position:absolute;
    border-radius:50%;
    pointer-events:none;
}

.dashboard-hero::before{
    width:190px;
    height:190px;
    right:22%;
    top:-118px;
    border:1px solid rgba(255,255,255,.10);
    background:rgba(255,255,255,.035);
}

.dashboard-hero::after{
    width:120px;
    height:120px;
    right:4%;
    bottom:-65px;
    background:rgba(56,189,248,.13);
}

.hero-copy,
.hero-actions{
    position:relative;
    z-index:2;
}

.dashboard-eyebrow{
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
    font-weight:800;
    letter-spacing:.4px;
}

.dashboard-hero h1{
    max-width:760px;
    margin:0;
    color:#fff;
    font-size:clamp(30px,3.2vw,47px);
    line-height:1.08;
    font-weight:850;
    letter-spacing:-1.5px;
}

.dashboard-hero h1 span{
    color:#93c5fd;
}

.dashboard-hero p{
    max-width:700px;
    margin:13px 0 0;
    color:#cbd5e1;
    font-size:14px;
    line-height:1.72;
}

.hero-meta{
    display:flex;
    gap:16px;
    margin-top:20px;
    flex-wrap:wrap;
}

.hero-meta span{
    display:inline-flex;
    align-items:center;
    gap:7px;
    color:#bfdbfe;
    font-size:10px;
    font-weight:700;
}

.hero-actions{
    display:flex;
    gap:9px;
    flex-wrap:wrap;
}

.hero-action{
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

.hero-action.primary{
    color:#0f172a;
    background:#fff;
    box-shadow:0 10px 24px rgba(15,23,42,.16);
}

.hero-action.secondary{
    color:#e0f2fe;
    border:1px solid rgba(255,255,255,.20);
    background:rgba(255,255,255,.08);
    backdrop-filter:blur(9px);
}

.hero-action:hover{
    transform:translateY(-2px);
}

/* KPI */
.dashboard-kpis{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:14px;
    margin-bottom:14px;
}

.kpi-card{
    position:relative;
    overflow:hidden;
    min-height:176px;
    padding:19px;
    border:1px solid var(--db-line);
    border-radius:20px;
    background:#fff;
    box-shadow:0 10px 30px rgba(15,23,42,.055);
    transition:.22s ease;
}

.kpi-card:hover{
    transform:translateY(-3px);
    border-color:#bfdbfe;
    box-shadow:0 17px 38px rgba(37,99,235,.10);
}

.kpi-top{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
}

.kpi-icon{
    width:43px;
    height:43px;
    border-radius:14px;
    display:grid;
    place-items:center;
    font-size:16px;
}

.kpi-revenue .kpi-icon{color:#047857;background:#ecfdf5}
.kpi-booking .kpi-icon{color:#2563eb;background:#eff6ff}
.kpi-tour .kpi-icon{color:#0369a1;background:#f0f9ff}
.kpi-customer .kpi-icon{color:#7c3aed;background:#f5f3ff}

.kpi-growth,
.kpi-badge{
    min-height:27px;
    padding:0 8px;
    border-radius:999px;
    display:inline-flex;
    align-items:center;
    gap:5px;
    font-size:9px;
    font-weight:900;
}

.kpi-growth.positive{color:#047857;background:#ecfdf5}
.kpi-growth.negative{color:#b91c1c;background:#fef2f2}
.kpi-badge{color:#475569;background:#f1f5f9}

.kpi-content{
    margin-top:19px;
}

.kpi-content > span{
    display:block;
    margin-bottom:6px;
    color:#64748b;
    font-size:10px;
    font-weight:750;
}

.kpi-content > strong{
    display:block;
    color:#0f172a;
    font-size:27px;
    line-height:1.05;
    font-weight:850;
    letter-spacing:-.8px;
}

.kpi-content small{
    display:block;
    margin-top:9px;
    color:#94a3b8;
    font-size:9px;
    line-height:1.4;
    font-weight:650;
}

.kpi-accent{
    position:absolute;
    left:19px;
    right:19px;
    bottom:0;
    height:3px;
    border-radius:999px 999px 0 0;
}

.kpi-revenue .kpi-accent{background:linear-gradient(90deg,#10b981,transparent)}
.kpi-booking .kpi-accent{background:linear-gradient(90deg,#2563eb,transparent)}
.kpi-tour .kpi-accent{background:linear-gradient(90deg,#38bdf8,transparent)}
.kpi-customer .kpi-accent{background:linear-gradient(90deg,#8b5cf6,transparent)}

/* STRIP */
.executive-strip{
    margin-bottom:14px;
    padding:13px 16px;
    border:1px solid var(--db-line);
    border-radius:18px;
    display:grid;
    grid-template-columns:1fr auto 1fr auto 1fr auto 1fr;
    align-items:center;
    background:#fff;
    box-shadow:0 8px 24px rgba(15,23,42,.045);
}

.executive-item{
    min-width:0;
    padding:4px 10px;
    display:flex;
    align-items:center;
    gap:10px;
}

.executive-icon{
    width:37px;
    height:37px;
    flex:0 0 37px;
    border-radius:12px;
    display:grid;
    place-items:center;
    font-size:13px;
}

.executive-icon.blue{color:#2563eb;background:#eff6ff}
.executive-icon.amber{color:#b45309;background:#fff7ed}
.executive-icon.green{color:#047857;background:#ecfdf5}
.executive-icon.red{color:#dc2626;background:#fef2f2}

.executive-label{
    display:block;
    color:#94a3b8;
    font-size:8px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.45px;
}

.executive-item strong{
    display:block;
    margin-top:3px;
    overflow:hidden;
    color:#334155;
    font-size:12px;
    font-weight:850;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.executive-divider{
    width:1px;
    height:31px;
    background:#e2e8f0;
}

/* PANELS */
.dashboard-chart-grid,
.dashboard-operation-grid,
.dashboard-bottom-grid{
    display:grid;
    gap:14px;
    margin-bottom:14px;
}

.dashboard-chart-grid{
    grid-template-columns:minmax(0,1.65fr) minmax(310px,.75fr);
}

.dashboard-operation-grid{
    grid-template-columns:minmax(0,1.55fr) minmax(310px,.65fr);
}

.dashboard-bottom-grid{
    grid-template-columns:1.05fr .85fr .75fr;
}

.dashboard-panel{
    min-width:0;
    padding:19px;
    border:1px solid var(--db-line);
    border-radius:20px;
    background:#fff;
    box-shadow:0 10px 30px rgba(15,23,42,.05);
}

.panel-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;
    margin-bottom:17px;
}

.panel-kicker{
    display:block;
    margin-bottom:4px;
    color:#2563eb;
    font-size:8px;
    font-weight:900;
    text-transform:uppercase;
    letter-spacing:1px;
}

.panel-header h2{
    margin:0;
    color:#0f172a;
    font-size:17px;
    line-height:1.25;
    font-weight:850;
    letter-spacing:-.4px;
}

.panel-link{
    display:inline-flex;
    align-items:center;
    gap:6px;
    color:#64748b;
    text-decoration:none;
    white-space:nowrap;
    font-size:9px;
    font-weight:800;
}

.panel-link:hover{color:#2563eb}

.chart-summary{
    display:flex;
    gap:27px;
    margin-bottom:10px;
}

.chart-summary span{
    display:block;
    margin-bottom:3px;
    color:#94a3b8;
    font-size:8px;
    font-weight:750;
}

.chart-summary strong{
    display:block;
    color:#334155;
    font-size:12px;
    font-weight:850;
}

.chart-shell{
    position:relative;
}

.main-chart-shell{
    height:285px;
}

.status-chart-wrap{
    min-height:325px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
}

.status-chart-shell{
    position:relative;
    width:188px;
    height:188px;
}

.status-chart-center{
    position:absolute;
    inset:0;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-direction:column;
    pointer-events:none;
}

.status-chart-center strong{
    color:#0f172a;
    font-size:24px;
    line-height:1;
    font-weight:850;
}

.status-chart-center span{
    margin-top:4px;
    color:#94a3b8;
    font-size:8px;
}

.status-legend{
    width:100%;
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:7px;
    margin-top:18px;
}

.status-legend-item{
    padding:8px;
    border:1px solid #edf2f7;
    border-radius:11px;
    display:flex;
    align-items:center;
    gap:7px;
    background:#fbfdff;
}

.legend-dot{
    width:8px;
    height:8px;
    flex:0 0 8px;
    border-radius:50%;
}

.legend-dot.warning{background:#f59e0b}
.legend-dot.info{background:#38bdf8}
.legend-dot.success{background:#10b981}
.legend-dot.primary{background:#2563eb}
.legend-dot.danger{background:#ef4444}

.status-legend-item div{
    min-width:0;
    flex:1;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:6px;
}

.status-legend-item span:not(.legend-dot){
    overflow:hidden;
    color:#64748b;
    font-size:7px;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.status-legend-item strong{
    color:#334155;
    font-size:9px;
    font-weight:900;
}

/* TABLE */
.premium-table-wrap{
    overflow-x:auto;
}

.premium-table{
    width:100%;
    border-collapse:collapse;
}

.premium-table th{
    padding:10px;
    border-bottom:1px solid #e2e8f0;
    color:#94a3b8;
    font-size:7px;
    font-weight:850;
    text-transform:uppercase;
    letter-spacing:.55px;
    text-align:left;
    white-space:nowrap;
}

.premium-table td{
    padding:11px 10px;
    border-bottom:1px solid #edf2f7;
    color:#475569;
    font-size:9px;
    vertical-align:middle;
}

.premium-table tbody tr:last-child td{
    border-bottom:0;
}

.premium-table tbody tr:hover{
    background:#fbfdff;
}

.order-code-cell strong,
.tour-cell strong{
    display:block;
    color:#334155;
    font-size:9px;
    font-weight:850;
}

.order-code-cell small,
.tour-cell small{
    display:block;
    margin-top:3px;
    color:#94a3b8;
    font-size:7px;
}

.table-main-text{
    color:#334155;
    font-size:9px;
    font-weight:800;
}

.money-cell{
    color:#1d4ed8;
    font-size:9px;
    font-weight:900;
    white-space:nowrap;
}

.table-status{
    min-height:24px;
    padding:0 7px;
    border-radius:999px;
    display:inline-flex;
    align-items:center;
    white-space:nowrap;
    font-size:7px;
    font-weight:850;
}

.table-status.warning{color:#a16207;background:#fefce8}
.table-status.info{color:#0369a1;background:#f0f9ff}
.table-status.success{color:#047857;background:#ecfdf5}
.table-status.primary{color:#1d4ed8;background:#eff6ff}
.table-status.danger{color:#b91c1c;background:#fef2f2}
.table-status.secondary{color:#475569;background:#f1f5f9}

/* TOP TOUR */
.top-tour-list,
.upcoming-list,
.incident-list,
.quick-actions{
    display:grid;
    gap:8px;
}

.top-tour-item{
    padding:10px;
    border:1px solid #edf2f7;
    border-radius:13px;
    display:flex;
    align-items:flex-start;
    gap:9px;
    background:#fbfdff;
}

.top-rank{
    width:30px;
    height:30px;
    flex:0 0 30px;
    border-radius:10px;
    display:grid;
    place-items:center;
    color:#2563eb;
    background:#eff6ff;
    font-size:8px;
    font-weight:900;
}

.top-tour-content{
    min-width:0;
    flex:1;
}

.top-tour-title{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:7px;
}

.top-tour-title strong{
    overflow:hidden;
    color:#334155;
    font-size:9px;
    font-weight:850;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.top-tour-title span{
    color:#94a3b8;
    font-size:7px;
    white-space:nowrap;
}

.progress-line{
    height:5px;
    margin:7px 0 5px;
    overflow:hidden;
    border-radius:999px;
    background:#eaf0f7;
}

.progress-line span{
    display:block;
    height:100%;
    border-radius:inherit;
    background:linear-gradient(90deg,#38bdf8,#2563eb);
}

.top-tour-content small{
    color:#2563eb;
    font-size:7px;
    font-weight:850;
}

/* UPCOMING */
.upcoming-item{
    padding:10px;
    border:1px solid #edf2f7;
    border-radius:13px;
    display:flex;
    align-items:center;
    gap:10px;
    background:#fbfdff;
}

.departure-date{
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

.departure-date strong{
    font-size:14px;
    line-height:1;
    font-weight:900;
}

.departure-date span{
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

.occupancy-row{
    display:flex;
    align-items:center;
    gap:7px;
    margin-top:7px;
}

.occupancy-row .progress-line{
    flex:1;
    margin:0;
}

.occupancy-row small{
    color:#94a3b8;
    font-size:7px;
    white-space:nowrap;
}

/* INCIDENT */
.incident-count{
    width:29px;
    height:29px;
    border-radius:10px;
    display:grid;
    place-items:center;
    color:#64748b;
    background:#f1f5f9;
    font-size:9px;
    font-weight:900;
}

.incident-count.has-alert{
    color:#dc2626;
    background:#fef2f2;
}

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
    min-height:128px;
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

.alert-footer-link{
    min-height:34px;
    margin-top:10px;
    border-top:1px solid #edf2f7;
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    color:#64748b;
    text-decoration:none;
    font-size:7px;
    font-weight:800;
}

.alert-footer-link:hover{
    color:#2563eb;
}

/* QUICK */
.quick-action{
    min-height:56px;
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

.quick-action:hover{
    border-color:#bfdbfe;
    background:#f8fbff;
    transform:translateX(2px);
}

.quick-icon{
    width:34px;
    height:34px;
    border-radius:11px;
    display:grid;
    place-items:center;
    font-size:10px;
}

.quick-icon.q-blue{color:#2563eb;background:#eff6ff}
.quick-icon.q-cyan{color:#0284c7;background:#f0f9ff}
.quick-icon.q-green{color:#047857;background:#ecfdf5}
.quick-icon.q-violet{color:#7c3aed;background:#f5f3ff}

.quick-action strong{
    display:block;
    color:#334155;
    font-size:8px;
    font-weight:850;
}

.quick-action small{
    display:block;
    margin-top:3px;
    color:#94a3b8;
    font-size:7px;
}

.quick-action > i{
    color:#cbd5e1;
    font-size:7px;
}

.panel-empty,
.table-empty{
    padding:24px 11px;
    color:#94a3b8;
    text-align:center;
    font-size:8px;
    font-weight:750;
}

.panel-empty i{
    display:block;
    margin-bottom:8px;
    color:#bfdbfe;
    font-size:19px;
}

@media(max-width:1350px){
    .dashboard-kpis{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .dashboard-bottom-grid{
        grid-template-columns:1fr 1fr;
    }

    .quick-panel{
        grid-column:1/-1;
    }

    .quick-actions{
        grid-template-columns:repeat(4,minmax(0,1fr));
    }
}

@media(max-width:1050px){
    .dashboard-chart-grid,
    .dashboard-operation-grid{
        grid-template-columns:1fr;
    }

    .executive-strip{
        grid-template-columns:1fr 1fr;
        gap:8px;
    }

    .executive-divider{
        display:none;
    }

    .executive-item{
        border:1px solid #edf2f7;
        border-radius:12px;
        background:#fbfdff;
    }
}

@media(max-width:850px){
    .dashboard-hero{
        align-items:flex-start;
        flex-direction:column;
    }

    .hero-actions{
        width:100%;
    }

    .hero-action{
        flex:1;
    }

    .dashboard-bottom-grid{
        grid-template-columns:1fr;
    }

    .quick-panel{
        grid-column:auto;
    }

    .quick-actions{
        grid-template-columns:1fr 1fr;
    }
}

@media(max-width:620px){
    .dashboard-hero{
        padding:25px 19px;
        border-radius:22px;
    }

    .dashboard-hero h1{
        font-size:30px;
    }

    .dashboard-kpis{
        grid-template-columns:1fr;
    }

    .executive-strip{
        grid-template-columns:1fr;
    }

    .dashboard-panel{
        padding:15px;
        border-radius:17px;
    }

    .main-chart-shell{
        height:240px;
    }

    .quick-actions,
    .status-legend{
        grid-template-columns:1fr;
    }

    .panel-header{
        align-items:flex-start;
        flex-direction:column;
        gap:7px;
    }
}
</style>
@endsection

@section('content')

@php
    $adminName = auth()->user()->name ?? 'Quản trị viên';

    $moneyShort = function ($value) {
        $value = (float) $value;

        if ($value >= 1000000000) {
            return number_format($value / 1000000000, 1, ',', '.') . ' tỷ';
        }

        if ($value >= 1000000) {
            return number_format($value / 1000000, 1, ',', '.') . ' triệu';
        }

        return number_format($value, 0, ',', '.') . 'đ';
    };

    $statusLabels = [
        'cho_xac_nhan' => ['Chờ xác nhận', 'warning'],
        'da_xac_nhan' => ['Đã xác nhận', 'info'],
        'da_thanh_toan' => ['Đã thanh toán', 'success'],
        'hoan_thanh' => ['Hoàn thành', 'primary'],
        'da_huy' => ['Đã hủy', 'danger'],
    ];
@endphp

<div class="premium-dashboard">

    {{-- HERO --}}
    <section class="dashboard-hero">
        <div class="hero-copy">
            <span class="dashboard-eyebrow">
                <i class="fa-solid fa-chart-line"></i>
                Trung tâm điều hành Travelloula
            </span>

            <h1>
                Chào {{ $adminName }},
                <span>mọi thứ đang trong tầm kiểm soát.</span>
            </h1>

            <p>
                Theo dõi doanh thu, đơn đặt tour, lịch khởi hành và tình trạng
                vận hành trên một màn hình duy nhất.
            </p>

            <div class="hero-meta">
                <span>
                    <i class="fa-regular fa-calendar"></i>
                    {{ now()->translatedFormat('l, d/m/Y') }}
                </span>

                <span>
                    <i class="fa-regular fa-clock"></i>
                    Cập nhật {{ now()->format('H:i') }}
                </span>
            </div>
        </div>

        <div class="hero-actions">
            <a href="{{ route('Admin.thong_ke.index') }}" class="hero-action secondary">
                <i class="fa-solid fa-chart-column"></i>
                Báo cáo chi tiết
            </a>

            <a href="{{ route('Admin.quan_ly_dat_tour.index') }}" class="hero-action primary">
                <i class="fa-solid fa-ticket"></i>
                Quản lý đơn
            </a>
        </div>
    </section>

    {{-- KPI --}}
    <section class="dashboard-kpis">
        <article class="kpi-card kpi-revenue">
            <div class="kpi-top">
                <span class="kpi-icon">
                    <i class="fa-solid fa-sack-dollar"></i>
                </span>

                <span class="kpi-growth {{ $tangTruongDoanhThu >= 0 ? 'positive' : 'negative' }}">
                    <i class="fa-solid {{ $tangTruongDoanhThu >= 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>
                    {{ abs($tangTruongDoanhThu) }}%
                </span>
            </div>

            <div class="kpi-content">
                <span>Doanh thu đã thu</span>
                <strong>{{ $moneyShort($tongDoanhThu) }}</strong>
                <small>
                    Tháng này {{ number_format($doanhThuThangNay, 0, ',', '.') }}đ
                </small>
            </div>

            <div class="kpi-accent"></div>
        </article>

        <article class="kpi-card kpi-booking">
            <div class="kpi-top">
                <span class="kpi-icon">
                    <i class="fa-solid fa-ticket"></i>
                </span>

                <span class="kpi-growth {{ $tangTruongDon >= 0 ? 'positive' : 'negative' }}">
                    <i class="fa-solid {{ $tangTruongDon >= 0 ? 'fa-arrow-trend-up' : 'fa-arrow-trend-down' }}"></i>
                    {{ abs($tangTruongDon) }}%
                </span>
            </div>

            <div class="kpi-content">
                <span>Tổng đơn đặt tour</span>
                <strong>{{ number_format($tongDonDat) }}</strong>
                <small>{{ number_format($donChoXacNhan) }} đơn đang chờ xác nhận</small>
            </div>

            <div class="kpi-accent"></div>
        </article>

        <article class="kpi-card kpi-tour">
            <div class="kpi-top">
                <span class="kpi-icon">
                    <i class="fa-solid fa-map-location-dot"></i>
                </span>

                <span class="kpi-badge">Đang hoạt động</span>
            </div>

            <div class="kpi-content">
                <span>Tour đang kinh doanh</span>
                <strong>{{ number_format($tongTourDangHoatDong) }}</strong>
                <small>{{ number_format($lichSapKhoiHanh) }} lịch sắp khởi hành</small>
            </div>

            <div class="kpi-accent"></div>
        </article>

        <article class="kpi-card kpi-customer">
            <div class="kpi-top">
                <span class="kpi-icon">
                    <i class="fa-solid fa-users"></i>
                </span>

                <span class="kpi-badge">{{ $tyLeLapDay }}% lấp đầy</span>
            </div>

            <div class="kpi-content">
                <span>Khách đã đặt tour</span>
                <strong>{{ number_format($tongKhachDat) }}</strong>
                <small>{{ number_format($donDaThanhToan) }} đơn đã thanh toán</small>
            </div>

            <div class="kpi-accent"></div>
        </article>
    </section>

    {{-- EXECUTIVE STRIP --}}
    <section class="executive-strip">
        <div class="executive-item">
            <span class="executive-icon blue">
                <i class="fa-solid fa-coins"></i>
            </span>

            <div>
                <span class="executive-label">Giá trị đơn hàng</span>
                <strong>{{ number_format($tongGiaTriDon, 0, ',', '.') }}đ</strong>
            </div>
        </div>

        <div class="executive-divider"></div>

        <div class="executive-item">
            <span class="executive-icon amber">
                <i class="fa-solid fa-hourglass-half"></i>
            </span>

            <div>
                <span class="executive-label">Công nợ còn lại</span>
                <strong>{{ number_format($congNoConLai, 0, ',', '.') }}đ</strong>
            </div>
        </div>

        <div class="executive-divider"></div>

        <div class="executive-item">
            <span class="executive-icon green">
                <i class="fa-solid fa-percent"></i>
            </span>

            <div>
                <span class="executive-label">Tỷ lệ lấp đầy</span>
                <strong>{{ $tyLeLapDay }}%</strong>
            </div>
        </div>

        <div class="executive-divider"></div>

        <div class="executive-item">
            <span class="executive-icon red">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </span>

            <div>
                <span class="executive-label">Sự cố cần xử lý</span>
                <strong>{{ number_format($suCoChuaXuLy) }}</strong>
            </div>
        </div>
    </section>

    {{-- CHARTS --}}
    <section class="dashboard-chart-grid">
        <article class="dashboard-panel">
            <header class="panel-header">
                <div>
                    <span class="panel-kicker">Hiệu suất kinh doanh</span>
                    <h2>Doanh thu & đơn đặt tour</h2>
                </div>

                <a href="{{ route('Admin.thong_ke.index') }}" class="panel-link">
                    Xem báo cáo
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
            </header>

            <div class="chart-summary">
                <div>
                    <span>Doanh thu tháng này</span>
                    <strong>{{ number_format($doanhThuThangNay, 0, ',', '.') }}đ</strong>
                </div>

                <div>
                    <span>Đơn tháng này</span>
                    <strong>{{ number_format($donThangNay) }}</strong>
                </div>
            </div>

            <div class="chart-shell main-chart-shell">
                <canvas id="revenueChart"></canvas>
            </div>
        </article>

        <article class="dashboard-panel">
            <header class="panel-header">
                <div>
                    <span class="panel-kicker">Cơ cấu đơn hàng</span>
                    <h2>Trạng thái đặt tour</h2>
                </div>
            </header>

            <div class="status-chart-wrap">
                <div class="status-chart-shell">
                    <canvas id="bookingStatusChart"></canvas>

                    <div class="status-chart-center">
                        <strong>{{ number_format($tongDonDat) }}</strong>
                        <span>tổng đơn</span>
                    </div>
                </div>

                <div class="status-legend">
                    @foreach($bookingStatus as $status => $count)
                        @php
                            $label = $statusLabels[$status][0] ?? $status;
                            $class = $statusLabels[$status][1] ?? 'secondary';
                        @endphp

                        <div class="status-legend-item">
                            <span class="legend-dot {{ $class }}"></span>

                            <div>
                                <span>{{ $label }}</span>
                                <strong>{{ number_format($count) }}</strong>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </article>
    </section>

    {{-- ORDERS + TOP TOUR --}}
    <section class="dashboard-operation-grid">
        <article class="dashboard-panel">
            <header class="panel-header">
                <div>
                    <span class="panel-kicker">Hoạt động mới nhất</span>
                    <h2>Đơn đặt tour gần đây</h2>
                </div>

                <a href="{{ route('Admin.quan_ly_dat_tour.index') }}" class="panel-link">
                    Tất cả đơn
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </header>

            <div class="premium-table-wrap">
                <table class="premium-table">
                    <thead>
                        <tr>
                            <th>Đơn</th>
                            <th>Khách hàng</th>
                            <th>Tour</th>
                            <th>Giá trị</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($donGanDay as $booking)
                            @php
                                $status = $statusLabels[$booking->trang_thai]
                                    ?? [$booking->trang_thai, 'secondary'];
                            @endphp

                            <tr>
                                <td>
                                    <div class="order-code-cell">
                                        <strong>{{ $booking->ma_dat_tour }}</strong>

                                        <small>
                                            {{ $booking->ngay_dat
                                                ? \Carbon\Carbon::parse($booking->ngay_dat)->format('d/m H:i')
                                                : '—'
                                            }}
                                        </small>
                                    </div>
                                </td>

                                <td>
                                    <strong class="table-main-text">
                                        {{ $booking->ten_khach_hang ?: 'Khách hàng' }}
                                    </strong>
                                </td>

                                <td>
                                    <div class="tour-cell">
                                        <strong>{{ $booking->ten_tour ?: 'Tour' }}</strong>

                                        <small>
                                            @if($booking->ngay_khoi_hanh)
                                                Khởi hành
                                                {{ \Carbon\Carbon::parse($booking->ngay_khoi_hanh)->format('d/m/Y') }}
                                            @else
                                                Chưa có lịch
                                            @endif
                                        </small>
                                    </div>
                                </td>

                                <td>
                                    <strong class="money-cell">
                                        {{ number_format($booking->tong_tien, 0, ',', '.') }}đ
                                    </strong>
                                </td>

                                <td>
                                    <span class="table-status {{ $status[1] }}">
                                        {{ $status[0] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="table-empty">
                                        Chưa có đơn đặt tour.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>

        <article class="dashboard-panel">
            <header class="panel-header">
                <div>
                    <span class="panel-kicker">Top performance</span>
                    <h2>Tour hiệu quả nhất</h2>
                </div>
            </header>

            <div class="top-tour-list">
                @forelse($topTours as $index => $tour)
                    @php
                        $maxRevenue = max(
                            1,
                            (float) ($topTours->max('doanh_thu') ?? 1)
                        );

                        $percent = min(
                            100,
                            round(((float) $tour->doanh_thu / $maxRevenue) * 100)
                        );
                    @endphp

                    <div class="top-tour-item">
                        <span class="top-rank">
                            {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        </span>

                        <div class="top-tour-content">
                            <div class="top-tour-title">
                                <strong>{{ $tour->ten_tour }}</strong>

                                <span>{{ number_format($tour->tong_don) }} đơn</span>
                            </div>

                            <div class="progress-line">
                                <span style="width: {{ $percent }}%"></span>
                            </div>

                            <small>
                                {{ number_format($tour->doanh_thu, 0, ',', '.') }}đ
                            </small>
                        </div>
                    </div>
                @empty
                    <div class="panel-empty">
                        <i class="fa-solid fa-chart-simple"></i>
                        Chưa đủ dữ liệu để xếp hạng tour.
                    </div>
                @endforelse
            </div>
        </article>
    </section>

    {{-- BOTTOM --}}
    <section class="dashboard-bottom-grid">
        <article class="dashboard-panel">
            <header class="panel-header">
                <div>
                    <span class="panel-kicker">Lịch vận hành</span>
                    <h2>Sắp khởi hành</h2>
                </div>

                <a href="{{ route('Admin.lich-khoi-hanh.index') }}" class="panel-link">
                    Quản lý lịch
                    <i class="fa-solid fa-calendar-days"></i>
                </a>
            </header>

            <div class="upcoming-list">
                @forelse($lichGanNhat as $schedule)
                    @php
                        $capacity = max(1, (int) $schedule->so_cho);
                        $booked = (int) $schedule->so_cho_da_dat;

                        $fill = min(
                            100,
                            round(($booked / $capacity) * 100)
                        );

                        $daysAway = now()
                            ->startOfDay()
                            ->diffInDays(
                                \Carbon\Carbon::parse($schedule->ngay_khoi_hanh),
                                false
                            );
                    @endphp

                    <div class="upcoming-item">
                        <div class="departure-date">
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
                                    @if($daysAway === 0)
                                        Hôm nay
                                    @elseif($daysAway === 1)
                                        Ngày mai
                                    @else
                                        Còn {{ $daysAway }} ngày
                                    @endif
                                </span>
                            </div>

                            <div class="occupancy-row">
                                <div class="progress-line">
                                    <span style="width: {{ $fill }}%"></span>
                                </div>

                                <small>{{ $booked }}/{{ $capacity }} khách</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="panel-empty">
                        <i class="fa-regular fa-calendar-xmark"></i>
                        Chưa có lịch khởi hành sắp tới.
                    </div>
                @endforelse
            </div>
        </article>

        <article class="dashboard-panel">
            <header class="panel-header">
                <div>
                    <span class="panel-kicker">Giám sát vận hành</span>
                    <h2>Cảnh báo & sự cố</h2>
                </div>

                <span class="incident-count {{ $suCoChuaXuLy > 0 ? 'has-alert' : '' }}">
                    {{ number_format($suCoChuaXuLy) }}
                </span>
            </header>

            <div class="incident-list">
                @forelse($suCoGanDay as $incident)
                    <div class="incident-item">
                        <span class="incident-icon {{ $incident->muc_do }}">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </span>

                        <div>
                            <strong>{{ $incident->tieu_de }}</strong>

                            <span>
                                {{ str_replace('_', ' ', $incident->loai_su_co) }}
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
                            <strong>Hệ thống vận hành ổn định</strong>
                            <small>Chưa ghi nhận sự cố cần xử lý.</small>
                        </div>
                    </div>
                @endforelse
            </div>

            <a href="{{ route('Admin.baocaosuco.index') }}" class="alert-footer-link">
                Trung tâm xử lý sự cố
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </article>

        <article class="dashboard-panel quick-panel">
            <header class="panel-header">
                <div>
                    <span class="panel-kicker">Truy cập nhanh</span>
                    <h2>Điều hành hệ thống</h2>
                </div>
            </header>

            <div class="quick-actions">
                <a href="{{ route('Admin.tours.index') }}" class="quick-action">
                    <span class="quick-icon q-blue">
                        <i class="fa-solid fa-map-location-dot"></i>
                    </span>

                    <div>
                        <strong>Quản lý tour</strong>
                        <small>Cập nhật sản phẩm</small>
                    </div>

                    <i class="fa-solid fa-chevron-right"></i>
                </a>

                <a href="{{ route('Admin.quan_ly_dat_tour.index') }}" class="quick-action">
                    <span class="quick-icon q-cyan">
                        <i class="fa-solid fa-ticket"></i>
                    </span>

                    <div>
                        <strong>Đơn đặt tour</strong>
                        <small>Xử lý đơn mới</small>
                    </div>

                    <i class="fa-solid fa-chevron-right"></i>
                </a>

                <a href="{{ route('Admin.thanh_toans.index') }}" class="quick-action">
                    <span class="quick-icon q-green">
                        <i class="fa-solid fa-credit-card"></i>
                    </span>

                    <div>
                        <strong>Thanh toán</strong>
                        <small>Kiểm tra giao dịch</small>
                    </div>

                    <i class="fa-solid fa-chevron-right"></i>
                </a>

                <a href="{{ route('Admin.users.index') }}" class="quick-action">
                    <span class="quick-icon q-violet">
                        <i class="fa-solid fa-user-shield"></i>
                    </span>

                    <div>
                        <strong>Người dùng</strong>
                        <small>Tài khoản & phân quyền</small>
                    </div>

                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>
        </article>
    </section>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const labels = @json($chartLabels);
    const revenueData = @json($chartRevenue);
    const bookingData = @json($chartBookings);

    const revenueCanvas = document.getElementById('revenueChart');

    if (revenueCanvas && typeof Chart !== 'undefined') {
        new Chart(revenueCanvas, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        type: 'line',
                        label: 'Đơn đặt tour',
                        data: bookingData,
                        borderColor: '#38bdf8',
                        backgroundColor: 'rgba(56,189,248,.12)',
                        borderWidth: 2,
                        pointRadius: 3,
                        pointHoverRadius: 4,
                        tension: .35,
                        yAxisID: 'y1'
                    },
                    {
                        label: 'Doanh thu',
                        data: revenueData,
                        borderRadius: 8,
                        borderSkipped: false,
                        backgroundColor: 'rgba(37,99,235,.82)',
                        hoverBackgroundColor: '#2563eb',
                        maxBarThickness: 34,
                        yAxisID: 'y'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                        labels: {
                            usePointStyle: true,
                            boxWidth: 7,
                            boxHeight: 7,
                            color: '#64748b',
                            font: {
                                size: 10,
                                weight: '600'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleColor: '#ffffff',
                        bodyColor: '#cbd5e1',
                        padding: 11,
                        cornerRadius: 10,
                        callbacks: {
                            label: function (context) {
                                if (context.dataset.label === 'Doanh thu') {
                                    return ' Doanh thu: '
                                        + new Intl.NumberFormat('vi-VN').format(context.raw)
                                        + 'đ';
                                }

                                return ' Đơn đặt tour: ' + context.raw;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: {
                                size: 9,
                                weight: '600'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(226,232,240,.7)'
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            font: {
                                size: 8
                            },
                            callback: function (value) {
                                if (value >= 1000000000) {
                                    return (value / 1000000000) + ' tỷ';
                                }

                                if (value >= 1000000) {
                                    return (value / 1000000) + 'tr';
                                }

                                return value;
                            }
                        }
                    },
                    y1: {
                        beginAtZero: true,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            color: '#94a3b8',
                            precision: 0,
                            font: {
                                size: 8
                            }
                        }
                    }
                }
            }
        });
    }

    const statusCanvas = document.getElementById('bookingStatusChart');

    if (statusCanvas && typeof Chart !== 'undefined') {
        new Chart(statusCanvas, {
            type: 'doughnut',
            data: {
                labels: [
                    'Chờ xác nhận',
                    'Đã xác nhận',
                    'Đã thanh toán',
                    'Hoàn thành',
                    'Đã hủy'
                ],
                datasets: [{
                    data: @json(array_values($bookingStatus)),
                    backgroundColor: [
                        '#f59e0b',
                        '#38bdf8',
                        '#10b981',
                        '#2563eb',
                        '#ef4444'
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '74%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 10,
                        cornerRadius: 9
                    }
                }
            }
        });
    }
});
</script>
@endsection
