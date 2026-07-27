@extends('layouts.guide')

@section('title', 'Tour được phân công')

@section('guide', 'Tour được phân công')

@section('page-title', 'Tour được phân công')

@section('breadcrumb')
    <li class="breadcrumb-item active">
        Tour được phân công
    </li>
@endsection

@section('content')
    <style>
        :root {
            --assigned-primary: #315be8;
            --assigned-primary-dark: #264ed4;
            --assigned-purple: #5b4dea;

            --assigned-dark: #173576;
            --assigned-text: #344563;
            --assigned-muted: #6b7895;

            --assigned-white: #ffffff;
            --assigned-soft: #f5f8ff;
            --assigned-hover: #f3f7ff;

            --assigned-border: #dce6f5;
            --assigned-border-light: #e8eef8;

            --assigned-success: #08754a;
            --assigned-success-bg: #eaf9f1;

            --assigned-warning: #9a650d;
            --assigned-warning-bg: #fff7e8;

            --assigned-danger: #c13d55;
            --assigned-danger-bg: #fff0f3;

            --assigned-info: #1975a8;
            --assigned-info-bg: #ebf8ff;

            --assigned-secondary: #65738b;
            --assigned-secondary-bg: #f0f3f7;
        }

        .assigned-page {
            padding: 4px 0 28px;
            color: var(--assigned-text);
        }

        /*
        |--------------------------------------------------------------------------
        | Header
        |--------------------------------------------------------------------------
        */
        .assigned-page-header {
            margin-bottom: 22px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .assigned-page-heading {
            min-width: 0;

            display: flex;
            align-items: center;
            gap: 13px;
        }

        .assigned-page-icon {
            width: 50px;
            height: 50px;
            flex-shrink: 0;

            color: var(--assigned-white);

            background:
                linear-gradient(
                    135deg,
                    var(--assigned-primary),
                    var(--assigned-purple)
                );

            border-radius: 14px;

            box-shadow:
                0 9px 21px rgba(49, 91, 232, 0.24);

            font-size: 19px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .assigned-page-heading h2 {
            margin: 0;

            color: var(--assigned-dark);
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -0.2px;
        }

        .assigned-page-heading p {
            margin: 5px 0 0;

            color: var(--assigned-muted);
            font-size: 13px;
        }

        .btn-assigned-refresh {
            min-height: 42px;
            padding: 9px 16px;

            color: #53698f;
            background: var(--assigned-white);

            border: 1px solid #ccd9ed;
            border-radius: 10px;

            box-shadow:
                0 4px 13px rgba(28, 65, 139, 0.05);

            font-size: 12px;
            font-weight: 700;
            text-decoration: none;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            transition:
                color 0.18s ease,
                background-color 0.18s ease,
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.18s ease;
        }

        .btn-assigned-refresh:hover {
            color: var(--assigned-primary);
            background: var(--assigned-soft);
            border-color: #bfcff0;

            box-shadow:
                0 7px 17px rgba(28, 65, 139, 0.1);

            text-decoration: none;
            transform: translateY(-1px);
        }

        /*
        |--------------------------------------------------------------------------
        | Thống kê
        |--------------------------------------------------------------------------
        */
        .assigned-stats-grid {
            margin-bottom: 23px;

            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 15px;
        }

        .assigned-stat-card {
            position: relative;

            min-height: 124px;
            padding: 19px;

            overflow: hidden;

            background:
                linear-gradient(
                    145deg,
                    #ffffff,
                    #fbfcff
                );

            border: 1px solid var(--assigned-border);
            border-radius: 15px;

            box-shadow:
                0 8px 26px rgba(28, 65, 139, 0.08);

            display: flex;
            align-items: center;
            gap: 14px;

            transition:
                transform 0.18s ease,
                border-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .assigned-stat-card:hover {
            border-color: #bfd0ec;

            box-shadow:
                0 12px 32px rgba(28, 65, 139, 0.13);

            transform: translateY(-2px);
        }

        .assigned-stat-card::after {
            position: absolute;
            right: -35px;
            bottom: -48px;

            width: 130px;
            height: 130px;

            content: "";

            background:
                radial-gradient(
                    circle,
                    rgba(49, 91, 232, 0.08),
                    transparent 70%
                );

            border-radius: 50%;
        }

        .assigned-stat-icon {
            position: relative;
            z-index: 2;

            width: 52px;
            height: 52px;
            flex-shrink: 0;

            border: 1px solid transparent;
            border-radius: 14px;

            font-size: 18px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .assigned-stat-total {
            color: var(--assigned-primary);
            background: #edf3ff;
            border-color: #d2e0ff;
        }

        .assigned-stat-upcoming {
            color: var(--assigned-warning);
            background: var(--assigned-warning-bg);
            border-color: #f1dba9;
        }

        .assigned-stat-running {
            color: var(--assigned-info);
            background: var(--assigned-info-bg);
            border-color: #c8e8f5;
        }

        .assigned-stat-completed {
            color: var(--assigned-success);
            background: var(--assigned-success-bg);
            border-color: #c5ead8;
        }

        .assigned-stat-content {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .assigned-stat-value {
            color: #203e78;
            font-size: 27px;
            font-weight: 800;
            line-height: 1.1;
        }

        .assigned-stat-label {
            margin-top: 6px;

            color: var(--assigned-muted);
            font-size: 11px;
            font-weight: 650;
            line-height: 1.45;
        }

        /*
        |--------------------------------------------------------------------------
        | Tiêu đề danh sách
        |--------------------------------------------------------------------------
        */
        .assigned-section-header {
            margin-bottom: 15px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .assigned-section-title {
            color: #24417d;
            font-size: 15px;
            font-weight: 780;

            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .assigned-section-title i {
            color: var(--assigned-primary);
        }

        .assigned-section-count {
            padding: 6px 11px;

            color: #3158ce;
            background: #e9f1ff;

            border: 1px solid #cfdeff;
            border-radius: 999px;

            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        /*
        |--------------------------------------------------------------------------
        | Danh sách Tour
        |--------------------------------------------------------------------------
        */
        .assigned-tour-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .assigned-tour-card {
            position: relative;

            min-width: 0;
            overflow: hidden;

            background:
                linear-gradient(
                    145deg,
                    #ffffff,
                    #fbfcff
                );

            border: 1px solid var(--assigned-border);
            border-radius: 16px;

            box-shadow:
                0 9px 30px rgba(28, 65, 139, 0.09);

            display: flex;
            flex-direction: column;

            transition:
                transform 0.2s ease,
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }

        .assigned-tour-card:hover {
            border-color: #b9ccec;

            box-shadow:
                0 14px 38px rgba(28, 65, 139, 0.15);

            transform: translateY(-3px);
        }

        .assigned-tour-card::before {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 2;

            height: 4px;
            content: "";

            background:
                linear-gradient(
                    90deg,
                    var(--assigned-primary),
                    #3b79ee,
                    var(--assigned-purple)
                );
        }

        .assigned-tour-card-body {
            flex: 1;
            padding: 23px 20px 19px;
        }

        .assigned-tour-top {
            margin-bottom: 17px;

            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 15px;
        }

        .assigned-tour-heading {
            min-width: 0;
        }

        .assigned-tour-name {
            margin: 0;

            color: #233f7a;
            font-size: 16px;
            font-weight: 800;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .assigned-tour-code {
            margin-top: 7px;

            color: #8b97aa;
            font-size: 9px;
            font-weight: 600;
        }

        .assigned-tour-large-icon {
            width: 49px;
            height: 49px;
            flex-shrink: 0;

            color: var(--assigned-primary);

            background:
                linear-gradient(
                    135deg,
                    #edf3ff,
                    #f1efff
                );

            border: 1px solid #d3e1ff;
            border-radius: 13px;

            font-size: 18px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /*
        |--------------------------------------------------------------------------
        | Trạng thái
        |--------------------------------------------------------------------------
        */
        .assigned-status-group {
            margin-top: 10px;

            display: flex;
            align-items: center;
            gap: 7px;
            flex-wrap: wrap;
        }

        .assigned-status {
            min-height: 28px;
            padding: 5px 9px;

            border: 1px solid transparent;
            border-radius: 999px;

            font-size: 9px;
            font-weight: 750;
            white-space: nowrap;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .assigned-status-assigned {
            color: var(--assigned-success);
            background: var(--assigned-success-bg);
            border-color: #c5ead8;
        }

        .assigned-status-not-started {
            color: var(--assigned-warning);
            background: var(--assigned-warning-bg);
            border-color: #f1dba9;
        }

        .assigned-status-running {
            color: var(--assigned-info);
            background: var(--assigned-info-bg);
            border-color: #c8e8f5;
        }

        .assigned-status-finished {
            color: var(--assigned-secondary);
            background: var(--assigned-secondary-bg);
            border-color: #d7dee9;
        }

        .assigned-status-no-schedule {
            color: var(--assigned-danger);
            background: var(--assigned-danger-bg);
            border-color: #f1cbd3;
        }

        /*
        |--------------------------------------------------------------------------
        | Thông tin Tour
        |--------------------------------------------------------------------------
        */
        .assigned-tour-divider {
            height: 1px;
            margin: 0 0 17px;

            background: var(--assigned-border-light);
        }

        .assigned-tour-info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 13px;
        }

        .assigned-tour-info-item {
            min-width: 0;
            padding: 12px;

            background: #fafcff;
            border: 1px solid var(--assigned-border);
            border-radius: 11px;

            display: flex;
            align-items: flex-start;
            gap: 9px;

            transition:
                background-color 0.18s ease,
                border-color 0.18s ease,
                transform 0.18s ease;
        }

        .assigned-tour-info-item:hover {
            background: var(--assigned-hover);
            border-color: #c5d5ef;
            transform: translateY(-1px);
        }

        .assigned-tour-info-icon {
            width: 33px;
            height: 33px;
            flex-shrink: 0;

            color: var(--assigned-primary);
            background: #edf3ff;

            border: 1px solid #d4e2ff;
            border-radius: 9px;

            font-size: 10px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .assigned-tour-info-content {
            min-width: 0;
            flex: 1;
        }

        .assigned-tour-info-label {
            margin-bottom: 4px;

            color: var(--assigned-muted);
            font-size: 8px;
            font-weight: 750;
            letter-spacing: 0.035em;
            text-transform: uppercase;
        }

        .assigned-tour-info-value {
            color: #425474;
            font-size: 11px;
            font-weight: 700;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        /*
        |--------------------------------------------------------------------------
        | Thanh sức chứa
        |--------------------------------------------------------------------------
        */
        .assigned-capacity {
            margin-top: 7px;
        }

        .assigned-capacity-header {
            margin-bottom: 5px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .assigned-capacity-percent {
            color: var(--assigned-primary);
            font-size: 8px;
            font-weight: 800;
        }

        .assigned-capacity-track {
            width: 100%;
            height: 6px;

            overflow: hidden;

            background: #e5eaf3;
            border-radius: 999px;
        }

        .assigned-capacity-bar {
            height: 100%;

            background:
                linear-gradient(
                    90deg,
                    var(--assigned-primary),
                    var(--assigned-purple)
                );

            border-radius: inherit;
        }

        /*
        |--------------------------------------------------------------------------
        | Footer card
        |--------------------------------------------------------------------------
        */
        .assigned-tour-card-footer {
            padding: 14px 20px;

            background:
                linear-gradient(
                    135deg,
                    #fafcff,
                    #f7f9ff
                );

            border-top: 1px solid var(--assigned-border);

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .assigned-footer-status {
            color: var(--assigned-muted);
            font-size: 9px;
            font-weight: 650;

            display: flex;
            align-items: center;
            gap: 5px;
        }

        .assigned-footer-status i {
            color: var(--assigned-primary);
        }

        .btn-assigned-detail {
            min-height: 38px;
            padding: 8px 14px;

            color: var(--assigned-white);

            background:
                linear-gradient(
                    135deg,
                    var(--assigned-primary),
                    var(--assigned-purple)
                );

            border: 1px solid var(--assigned-primary);
            border-radius: 9px;

            box-shadow:
                0 5px 14px rgba(49, 91, 232, 0.21);

            font-size: 10px;
            font-weight: 750;
            white-space: nowrap;
            text-decoration: none;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;

            transition:
                color 0.18s ease,
                background-color 0.18s ease,
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.18s ease;
        }

        .btn-assigned-detail:hover {
            color: var(--assigned-white);

            background:
                linear-gradient(
                    135deg,
                    var(--assigned-primary-dark),
                    #4c40d7
                );

            border-color: var(--assigned-primary-dark);

            box-shadow:
                0 8px 18px rgba(49, 91, 232, 0.28);

            text-decoration: none;
            transform: translateY(-1px);
        }

        /*
        |--------------------------------------------------------------------------
        | Empty state
        |--------------------------------------------------------------------------
        */
        .assigned-empty {
            padding: 65px 20px;

            background: var(--assigned-white);
            border: 1px solid var(--assigned-border);
            border-radius: 16px;

            box-shadow:
                0 9px 30px rgba(28, 65, 139, 0.09);

            text-align: center;
        }

        .assigned-empty-icon {
            width: 66px;
            height: 66px;
            margin: 0 auto 15px;

            color: var(--assigned-primary);

            background:
                linear-gradient(
                    135deg,
                    #edf3ff,
                    #f0edff
                );

            border: 1px solid #d3e1ff;
            border-radius: 18px;

            font-size: 24px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .assigned-empty-title {
            color: #425474;
            font-size: 15px;
            font-weight: 750;
        }

        .assigned-empty-text {
            max-width: 450px;
            margin: 6px auto 0;

            color: #8793aa;
            font-size: 12px;
            line-height: 1.7;
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */
        .assigned-pagination {
            margin-top: 22px;

            display: flex;
            justify-content: center;
        }

        .assigned-pagination .pagination {
            margin: 0;
            gap: 4px;
        }

        .assigned-pagination .page-link {
            min-width: 35px;
            height: 35px;
            padding: 6px 10px;

            color: #3158ce;
            background: var(--assigned-white);

            border: 1px solid #d6e1f2;
            border-radius: 8px !important;

            font-size: 12px;
            box-shadow: none;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .assigned-pagination .page-link:hover {
            color: var(--assigned-white);
            background: var(--assigned-primary);
            border-color: var(--assigned-primary);
        }

        .assigned-pagination .page-item.active .page-link {
            color: var(--assigned-white);

            background:
                linear-gradient(
                    135deg,
                    var(--assigned-primary),
                    var(--assigned-purple)
                );

            border-color: var(--assigned-primary);
        }

        .assigned-pagination .page-item.disabled .page-link {
            color: #aab3c5;
            background: #f8f9fc;
        }

        /*
        |--------------------------------------------------------------------------
        | Responsive
        |--------------------------------------------------------------------------
        */
        @media (max-width: 1200px) {
            .assigned-stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 1100px) {
            .assigned-tour-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .assigned-page-header {
                align-items: stretch;
                flex-direction: column;
            }

            .assigned-page-heading {
                align-items: flex-start;
            }

            .assigned-page-heading h2 {
                font-size: 20px;
            }

            .btn-assigned-refresh {
                width: 100%;
            }

            .assigned-stats-grid,
            .assigned-tour-info-grid {
                grid-template-columns: 1fr;
            }

            .assigned-section-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .assigned-tour-card-footer {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-assigned-detail {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .assigned-tour-top {
                align-items: flex-start;
            }

            .assigned-tour-large-icon {
                width: 43px;
                height: 43px;
            }

            .assigned-tour-card-body {
                padding: 21px 16px 17px;
            }

            .assigned-tour-card-footer {
                padding: 14px 16px;
            }
        }
    </style>

    @php
        /*
        |--------------------------------------------------------------------------
        | Chuẩn hóa Collection hoặc Paginator
        |--------------------------------------------------------------------------
        */
        $tourCollection = method_exists($tours, 'getCollection')
            ? $tours->getCollection()
            : collect($tours);

        $tongTour = method_exists($tours, 'total')
            ? $tours->total()
            : $tourCollection->count();

        $homNay = now()->startOfDay();

        /*
        |--------------------------------------------------------------------------
        | Tour chưa khởi hành
        |--------------------------------------------------------------------------
        */
        $chuaKhoiHanh = $tourCollection
            ->filter(function ($tour) use ($homNay) {
                $ngayKhoiHanh = $tour->lichKhoiHanh?->ngay_khoi_hanh;

                if (!$ngayKhoiHanh) {
                    return false;
                }

                return \Carbon\Carbon::parse($ngayKhoiHanh)
                    ->startOfDay()
                    ->gt($homNay);
            })
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Tour đang diễn ra
        |--------------------------------------------------------------------------
        */
        $dangThucHien = $tourCollection
            ->filter(function ($tour) use ($homNay) {
                $lichKhoiHanh = $tour->lichKhoiHanh;

                if (!$lichKhoiHanh?->ngay_khoi_hanh) {
                    return false;
                }

                $ngayKhoiHanh = \Carbon\Carbon::parse(
                    $lichKhoiHanh->ngay_khoi_hanh
                )->startOfDay();

                $ngayKetThuc = $lichKhoiHanh->ngay_ket_thuc
                    ? \Carbon\Carbon::parse(
                        $lichKhoiHanh->ngay_ket_thuc
                    )->endOfDay()
                    : null;

                return $homNay->gte($ngayKhoiHanh)
                    && (!$ngayKetThuc || now()->lte($ngayKetThuc));
            })
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Tour đã kết thúc
        |--------------------------------------------------------------------------
        */
        $hoanThanh = $tourCollection
            ->filter(function ($tour) {
                $ngayKetThuc = $tour->lichKhoiHanh?->ngay_ket_thuc;

                if (!$ngayKetThuc) {
                    return false;
                }

                return now()->gt(
                    \Carbon\Carbon::parse($ngayKetThuc)->endOfDay()
                );
            })
            ->count();
    @endphp

    <div class="assigned-page fade-in">
        {{-- Header --}}
        <div class="assigned-page-header">
            <div class="assigned-page-heading">
                <span class="assigned-page-icon">
                    <i class="fas fa-route"></i>
                </span>

                <div>
                    <h2>Tour được phân công</h2>

                    <p>
                        Theo dõi Tour, trạng thái phân công và tiến trình khởi hành.
                    </p>
                </div>
            </div>

            <a
                href="{{ route('Guide.tour-phan-cong.index') }}"
                class="btn-assigned-refresh"
            >
                <i class="fas fa-rotate-right"></i>
                Làm mới
            </a>
        </div>

        {{-- Thống kê --}}
        <div class="assigned-stats-grid">
            <div class="assigned-stat-card">
                <span class="assigned-stat-icon assigned-stat-total">
                    <i class="fas fa-map-marked-alt"></i>
                </span>

                <div class="assigned-stat-content">
                    <div class="assigned-stat-value">
                        {{ $tongTour }}
                    </div>

                    <div class="assigned-stat-label">
                        Tổng Tour được phân công
                    </div>
                </div>
            </div>

            <div class="assigned-stat-card">
                <span class="assigned-stat-icon assigned-stat-upcoming">
                    <i class="fas fa-hourglass-start"></i>
                </span>

                <div class="assigned-stat-content">
                    <div class="assigned-stat-value">
                        {{ $chuaKhoiHanh }}
                    </div>

                    <div class="assigned-stat-label">
                        Chưa khởi hành
                    </div>
                </div>
            </div>

            <div class="assigned-stat-card">
                <span class="assigned-stat-icon assigned-stat-running">
                    <i class="fas fa-route"></i>
                </span>

                <div class="assigned-stat-content">
                    <div class="assigned-stat-value">
                        {{ $dangThucHien }}
                    </div>

                    <div class="assigned-stat-label">
                        Đang diễn ra
                    </div>
                </div>
            </div>

            <div class="assigned-stat-card">
                <span class="assigned-stat-icon assigned-stat-completed">
                    <i class="fas fa-flag-checkered"></i>
                </span>

                <div class="assigned-stat-content">
                    <div class="assigned-stat-value">
                        {{ $hoanThanh }}
                    </div>

                    <div class="assigned-stat-label">
                        Đã kết thúc
                    </div>
                </div>
            </div>
        </div>

        {{-- Tiêu đề danh sách --}}
        <div class="assigned-section-header">
            <div class="assigned-section-title">
                <i class="fas fa-list-alt"></i>
                Danh sách Tour
            </div>

            <span class="assigned-section-count">
                {{ $tongTour }} Tour
            </span>
        </div>

        @forelse ($tours as $tour)
            @php
                $lichKhoiHanh = $tour->lichKhoiHanh;
                $tourInfo = $lichKhoiHanh?->tour;
                $phuongTien = $tour->phuongTien;

                /*
                |--------------------------------------------------------------------------
                | Số lượng khách
                |--------------------------------------------------------------------------
                */
                $soChoDaDat = (int) (
                    $lichKhoiHanh?->so_cho_da_dat ?? 0
                );

                $tongSoCho = (int) (
                    $lichKhoiHanh?->so_cho ?? 0
                );

                $phanTramCho = $tongSoCho > 0
                    ? round(($soChoDaDat / $tongSoCho) * 100)
                    : 0;

                $phanTramCho = min(
                    max($phanTramCho, 0),
                    100
                );

                /*
                |--------------------------------------------------------------------------
                | Trạng thái phân công
                |--------------------------------------------------------------------------
                */
                $trangThaiPhanCongText = 'Đã phân công';
                $trangThaiPhanCongClass = 'assigned-status-assigned';
                $trangThaiPhanCongIcon = 'fa-user-check';

                /*
                |--------------------------------------------------------------------------
                | Ngày khởi hành và kết thúc
                |--------------------------------------------------------------------------
                */
                $ngayKhoiHanh = $lichKhoiHanh?->ngay_khoi_hanh
                    ? \Carbon\Carbon::parse(
                        $lichKhoiHanh->ngay_khoi_hanh
                    )->startOfDay()
                    : null;

                $ngayKetThuc = $lichKhoiHanh?->ngay_ket_thuc
                    ? \Carbon\Carbon::parse(
                        $lichKhoiHanh->ngay_ket_thuc
                    )->endOfDay()
                    : null;

                /*
                |--------------------------------------------------------------------------
                | Trạng thái khởi hành
                |--------------------------------------------------------------------------
                */
                if (!$ngayKhoiHanh) {
                    $trangThaiKhoiHanhText = 'Chưa có lịch';
                    $trangThaiKhoiHanhClass = 'assigned-status-no-schedule';
                    $trangThaiKhoiHanhIcon = 'fa-calendar-xmark';
                } elseif (now()->startOfDay()->lt($ngayKhoiHanh)) {
                    $trangThaiKhoiHanhText = 'Chưa khởi hành';
                    $trangThaiKhoiHanhClass = 'assigned-status-not-started';
                    $trangThaiKhoiHanhIcon = 'fa-hourglass-start';
                } elseif ($ngayKetThuc && now()->gt($ngayKetThuc)) {
                    $trangThaiKhoiHanhText = 'Đã kết thúc';
                    $trangThaiKhoiHanhClass = 'assigned-status-finished';
                    $trangThaiKhoiHanhIcon = 'fa-flag-checkered';
                } else {
                    $trangThaiKhoiHanhText = 'Đang diễn ra';
                    $trangThaiKhoiHanhClass = 'assigned-status-running';
                    $trangThaiKhoiHanhIcon = 'fa-route';
                }
            @endphp

            @if ($loop->first)
                <div class="assigned-tour-grid">
            @endif

            <article class="assigned-tour-card">
                <div class="assigned-tour-card-body">
                    <div class="assigned-tour-top">
                        <div class="assigned-tour-heading">
                            <h3 class="assigned-tour-name">
                                {{ $tourInfo?->ten_tour ?? 'Tour không xác định' }}
                            </h3>

                            <div class="assigned-status-group">
                                {{-- Trạng thái phân công --}}
                                <span
                                    class="assigned-status {{ $trangThaiPhanCongClass }}"
                                    title="Trạng thái phân công"
                                >
                                    <i class="fas {{ $trangThaiPhanCongIcon }}"></i>
                                    {{ $trangThaiPhanCongText }}
                                </span>

                                {{-- Trạng thái khởi hành --}}
                                <span
                                    class="assigned-status {{ $trangThaiKhoiHanhClass }}"
                                    title="Trạng thái khởi hành"
                                >
                                    <i class="fas {{ $trangThaiKhoiHanhIcon }}"></i>
                                    {{ $trangThaiKhoiHanhText }}
                                </span>
                            </div>

                            <div class="assigned-tour-code">
                                Mã phân công #{{ $tour->id }}
                            </div>
                        </div>

                        <span class="assigned-tour-large-icon">
                            <i class="fas fa-route"></i>
                        </span>
                    </div>

                    <div class="assigned-tour-divider"></div>

                    <div class="assigned-tour-info-grid">
                        {{-- Ngày khởi hành --}}
                        <div class="assigned-tour-info-item">
                            <span class="assigned-tour-info-icon">
                                <i class="fas fa-plane-departure"></i>
                            </span>

                            <div class="assigned-tour-info-content">
                                <div class="assigned-tour-info-label">
                                    Ngày khởi hành
                                </div>

                                <div class="assigned-tour-info-value">
                                    @if ($ngayKhoiHanh)
                                        {{ $ngayKhoiHanh->format('d/m/Y') }}
                                    @else
                                        Chưa cập nhật
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Phương tiện --}}
                        <div class="assigned-tour-info-item">
                            <span class="assigned-tour-info-icon">
                                <i class="fas fa-bus"></i>
                            </span>

                            <div class="assigned-tour-info-content">
                                <div class="assigned-tour-info-label">
                                    Phương tiện
                                </div>

                                <div class="assigned-tour-info-value">
                                    {{
                                        $phuongTien?->ten_phuong_tien
                                        ?? 'Chưa phân công'
                                    }}

                                    @if ($phuongTien?->bien_so_xe)
                                        <div>
                                            Biển số:
                                            {{ $phuongTien->bien_so_xe }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Ngày kết thúc --}}
                        <div class="assigned-tour-info-item">
                            <span class="assigned-tour-info-icon">
                                <i class="fas fa-flag-checkered"></i>
                            </span>

                            <div class="assigned-tour-info-content">
                                <div class="assigned-tour-info-label">
                                    Ngày kết thúc
                                </div>

                                <div class="assigned-tour-info-value">
                                    @if ($ngayKetThuc)
                                        {{ $ngayKetThuc->format('d/m/Y') }}
                                    @else
                                        Chưa cập nhật
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Số chỗ --}}
                        <div class="assigned-tour-info-item">
                            <span class="assigned-tour-info-icon">
                                <i class="fas fa-users"></i>
                            </span>

                            <div class="assigned-tour-info-content">
                                <div class="assigned-tour-info-label">
                                    Số khách
                                </div>

                                <div class="assigned-capacity-header">
                                    <div class="assigned-tour-info-value">
                                        {{ $soChoDaDat }}/{{ $tongSoCho }} khách
                                    </div>

                                    <span class="assigned-capacity-percent">
                                        {{ $phanTramCho }}%
                                    </span>
                                </div>

                                <div class="assigned-capacity">
                                    <div class="assigned-capacity-track">
                                        <div
                                            class="assigned-capacity-bar"
                                            style="width: {{ $phanTramCho }}%;"
                                        ></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="assigned-tour-card-footer">
                    <div class="assigned-footer-status">
                        <i class="fas {{ $trangThaiKhoiHanhIcon }}"></i>
                        {{ $trangThaiKhoiHanhText }}
                    </div>

                    <a
                        href="{{ route(
                            'Guide.tour-phan-cong.show',
                            $tour->id
                        ) }}"
                        class="btn-assigned-detail"
                    >
                        <i class="fas fa-eye"></i>
                        Xem chi tiết
                    </a>
                </footer>
            </article>

            @if ($loop->last)
                </div>
            @endif
        @empty
            <div class="assigned-empty">
                <div class="assigned-empty-icon">
                    <i class="fas fa-map-location-dot"></i>
                </div>

                <div class="assigned-empty-title">
                    Chưa có Tour nào được phân công
                </div>

                <div class="assigned-empty-text">
                    Khi quản trị viên phân công Tour, thông tin Tour và lịch khởi hành sẽ hiển thị tại đây.
                </div>
            </div>
        @endforelse

        {{-- Phân trang, chỉ hiển thị khi $tours là Paginator --}}
        @if (
            method_exists($tours, 'hasPages')
            && $tours->hasPages()
        )
            <div class="assigned-pagination">
                {{ $tours->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
