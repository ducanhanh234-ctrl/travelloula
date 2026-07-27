@extends('layouts.guide')

@section('title', 'Chi tiết báo cáo sự cố')

@section('guide', 'Chi tiết báo cáo sự cố')

@section('page-title', 'Chi tiết báo cáo sự cố')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('Guide.baocaosuco.index') }}">
            Báo cáo sự cố
        </a>
    </li>

    <li class="breadcrumb-item active">
        Báo cáo #{{ $baoCaoSuCo->id }}
    </li>
@endsection

@section('content')

    @php
        $trangThaiText = match ($baoCaoSuCo->trang_thai) {
            'moi' => 'Mới gửi',
            'da_tiep_nhan' => 'Đã tiếp nhận',
            'dang_xu_ly' => 'Đang xử lý',
            'da_xu_ly' => 'Đã xử lý',
            'tu_choi' => 'Từ chối',
            default => ucfirst(str_replace('_', ' ', $baoCaoSuCo->trang_thai)),
        };

        $trangThaiStyle = match ($baoCaoSuCo->trang_thai) {
            'moi' => 'incident-status-new',
            'da_tiep_nhan' => 'incident-status-received',
            'dang_xu_ly' => 'incident-status-processing',
            'da_xu_ly' => 'incident-status-completed',
            'tu_choi' => 'incident-status-rejected',
            default => 'incident-status-default',
        };

        $trangThaiIcon = match ($baoCaoSuCo->trang_thai) {
            'moi' => 'fa-paper-plane',
            'da_tiep_nhan' => 'fa-hand',
            'dang_xu_ly' => 'fa-spinner',
            'da_xu_ly' => 'fa-circle-check',
            'tu_choi' => 'fa-circle-xmark',
            default => 'fa-circle-info',
        };

        $mucDoText = match ($baoCaoSuCo->muc_do) {
            'thap' => 'Thấp',
            'trung_binh' => 'Trung bình',
            'cao' => 'Cao',
            'khan_cap' => 'Khẩn cấp',
            default => ucfirst(str_replace('_', ' ', $baoCaoSuCo->muc_do)),
        };

        $mucDoStyle = match ($baoCaoSuCo->muc_do) {
            'thap' => 'incident-level-low',
            'trung_binh' => 'incident-level-medium',
            'cao' => 'incident-level-high',
            'khan_cap' => 'incident-level-emergency',
            default => 'incident-level-default',
        };

        $mucDoIcon = match ($baoCaoSuCo->muc_do) {
            'thap' => 'fa-circle-check',
            'trung_binh' => 'fa-triangle-exclamation',
            'cao' => 'fa-circle-exclamation',
            'khan_cap' => 'fa-bell',
            default => 'fa-circle-info',
        };

        $loaiSuCoText = match ($baoCaoSuCo->loai_su_co) {
            'phuong_tien' => 'Phương tiện',
            'lich_trinh' => 'Lịch trình',
            'khach_hang' => 'Khách hàng',
            'dich_vu' => 'Dịch vụ',
            'an_ninh' => 'An ninh',
            'suc_khoe' => 'Sức khỏe',
            'khac' => 'Khác',
            default => ucfirst(str_replace('_', ' ', $baoCaoSuCo->loai_su_co)),
        };

        $loaiSuCoIcon = match ($baoCaoSuCo->loai_su_co) {
            'phuong_tien' => 'fa-bus',
            'lich_trinh' => 'fa-route',
            'khach_hang' => 'fa-users',
            'dich_vu' => 'fa-concierge-bell',
            'an_ninh' => 'fa-shield-halved',
            'suc_khoe' => 'fa-kit-medical',
            'khac' => 'fa-circle-exclamation',
            default => 'fa-circle-info',
        };

        $daTiepNhan = !empty($baoCaoSuCo->thoi_gian_tiep_nhan);

        $daXuLy = !empty($baoCaoSuCo->thoi_gian_xu_ly);

        $adminXuLy =
            $baoCaoSuCo->adminXuLy?->name
            ?? $baoCaoSuCo->adminXuLy?->ho_ten
            ?? 'Chưa tiếp nhận';

        $tourName =
            $baoCaoSuCo->lichKhoiHanh?->tour?->ten_tour
            ?? $baoCaoSuCo->lichKhoiHanh?->tour?->ten
            ?? (
                $baoCaoSuCo->lich_khoi_hanh_id
                    ? 'Tour #' . $baoCaoSuCo->lich_khoi_hanh_id
                    : 'Không xác định'
            );
    @endphp

    <style>
        :root {
            --incident-primary: #315be8;
            --incident-primary-dark: #254dd3;
            --incident-purple: #6351e8;
            --incident-cyan: #16add1;

            --incident-text-dark: #173576;
            --incident-text: #41516f;
            --incident-muted: #77839a;
            --incident-light: #9aa5b7;

            --incident-white: #ffffff;
            --incident-page-bg: #f5f8fd;
            --incident-soft: #f5f8ff;
            --incident-border: #dce6f5;
            --incident-border-light: #e9eef7;

            --incident-success: #08754a;
            --incident-success-bg: #e9f9f1;

            --incident-warning: #a96708;
            --incident-warning-bg: #fff7e8;

            --incident-danger: #c13d55;
            --incident-danger-bg: #fff0f3;

            --incident-info: #1975a8;
            --incident-info-bg: #eaf7ff;

            --incident-shadow:
                0 10px 32px rgba(28, 65, 139, 0.09);

            --incident-shadow-hover:
                0 16px 44px rgba(28, 65, 139, 0.14);
        }

        .incident-page {
            position: relative;
            padding: 4px 0 30px;
            color: var(--incident-text);
        }

        .incident-page::before {
            position: fixed;
            top: 70px;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: -1;

            content: "";

            background:
                radial-gradient(
                    circle at 10% 10%,
                    rgba(49, 91, 232, 0.07),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 90% 20%,
                    rgba(99, 81, 232, 0.06),
                    transparent 26%
                );
        }

        /* Header */
        .incident-page-header {
            margin-bottom: 22px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            flex-wrap: wrap;
        }

        .incident-heading {
            min-width: 0;

            display: flex;
            align-items: center;
            gap: 14px;
        }

        .incident-heading-icon {
            width: 52px;
            height: 52px;
            flex-shrink: 0;

            color: var(--incident-white);

            background:
                linear-gradient(
                    135deg,
                    var(--incident-primary),
                    var(--incident-purple)
                );

            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 15px;

            box-shadow:
                0 10px 23px rgba(49, 91, 232, 0.25);

            font-size: 20px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .incident-heading h2 {
            margin: 0;

            color: var(--incident-text-dark);
            font-size: 24px;
            font-weight: 800;
            line-height: 1.3;
            letter-spacing: -0.35px;
        }

        .incident-heading p {
            margin: 4px 0 0;

            color: var(--incident-muted);
            font-size: 12px;
            font-weight: 550;
        }

        .incident-back-button {
            min-height: 42px;
            padding: 9px 16px;

            color: #53698f;
            background: rgba(255, 255, 255, 0.92);

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
            gap: 8px;

            transition:
                color 0.18s ease,
                background-color 0.18s ease,
                border-color 0.18s ease,
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .incident-back-button:hover {
            color: var(--incident-primary);
            background: var(--incident-white);
            border-color: #b9ccef;

            box-shadow:
                0 8px 18px rgba(28, 65, 139, 0.09);

            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Alert */
        .incident-alert {
            margin-bottom: 18px;
            padding: 14px 15px;

            border: 1px solid transparent;
            border-radius: 11px;

            font-size: 12px;
            font-weight: 650;

            display: flex;
            align-items: center;
            gap: 9px;
        }

        .incident-alert-success {
            color: var(--incident-success);
            background: var(--incident-success-bg);
            border-color: #bde7d1;
        }

        .incident-alert-danger {
            color: var(--incident-danger);
            background: var(--incident-danger-bg);
            border-color: #f0c6cf;
        }

        .incident-alert-close {
            margin-left: auto;
            padding: 0;

            color: currentColor;
            background: transparent;
            border: none;

            cursor: pointer;
            opacity: 0.75;
        }

        .incident-alert-close:hover {
            opacity: 1;
        }

        /* Layout */
        .incident-layout {
            display: grid;
            grid-template-columns:
                minmax(0, 1.85fr)
                minmax(310px, 0.85fr);
            gap: 22px;
            align-items: start;
        }

        .incident-main,
        .incident-sidebar {
            min-width: 0;
        }

        /* Card chung */
        .incident-card {
            position: relative;

            margin-bottom: 20px;
            overflow: hidden;

            background: rgba(255, 255, 255, 0.98);

            border: 1px solid var(--incident-border);
            border-radius: 17px;

            box-shadow: var(--incident-shadow);

            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                transform 0.2s ease;
        }

        .incident-card:hover {
            border-color: #c6d6ef;
            box-shadow: var(--incident-shadow-hover);
        }

        .incident-card:last-child {
            margin-bottom: 0;
        }

        .incident-card-header {
            min-height: 67px;
            padding: 16px 19px;

            color: #24417d;

            background:
                linear-gradient(
                    135deg,
                    #f5f8ff,
                    #f1f4ff
                );

            border-bottom: 1px solid var(--incident-border);

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .incident-card-heading {
            min-width: 0;

            display: flex;
            align-items: center;
            gap: 11px;
        }

        .incident-card-icon {
            width: 39px;
            height: 39px;
            flex-shrink: 0;

            color: var(--incident-primary);
            background: #e8f0ff;

            border: 1px solid #cfdeff;
            border-radius: 10px;

            font-size: 13px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .incident-card-heading h3,
        .incident-card-heading h4 {
            margin: 0;

            color: #24417d;
            font-size: 15px;
            font-weight: 780;
            line-height: 1.45;
        }

        .incident-card-heading p {
            margin: 3px 0 0;

            color: var(--incident-muted);
            font-size: 10px;
        }

        .incident-card-body {
            padding: 21px;
        }

        /* Hero báo cáo */
        .incident-hero {
            position: relative;
            padding: 24px;

            overflow: hidden;

            background:
                linear-gradient(
                    135deg,
                    #ffffff 0%,
                    #f8faff 100%
                );
        }

        .incident-hero::before {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;

            height: 5px;
            content: "";

            background:
                linear-gradient(
                    90deg,
                    var(--incident-primary),
                    var(--incident-cyan),
                    var(--incident-purple)
                );
        }

        .incident-hero::after {
            position: absolute;
            top: -70px;
            right: -70px;

            width: 210px;
            height: 210px;

            content: "";

            background:
                radial-gradient(
                    circle,
                    rgba(49, 91, 232, 0.09),
                    transparent 70%
                );

            border-radius: 50%;
        }

        .incident-hero-top {
            position: relative;
            z-index: 2;

            margin-bottom: 22px;

            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
        }

        .incident-title-box {
            min-width: 0;
        }

        .incident-report-code {
            margin-bottom: 7px;

            color: var(--incident-primary);
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .incident-title {
            margin: 0;

            color: #1d3972;
            font-size: 21px;
            font-weight: 800;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .incident-created-at {
            margin-top: 7px;

            color: var(--incident-muted);
            font-size: 11px;
            font-weight: 550;

            display: flex;
            align-items: center;
            gap: 6px;
        }

        .incident-created-at i {
            color: var(--incident-primary);
        }

        .incident-badges {
            flex-shrink: 0;

            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            flex-wrap: wrap;
        }

        .incident-badge {
            min-height: 31px;
            padding: 6px 11px;

            border: 1px solid transparent;
            border-radius: 999px;

            font-size: 9px;
            font-weight: 800;
            white-space: nowrap;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        /* Trạng thái */
        .incident-status-new {
            color: var(--incident-danger);
            background: var(--incident-danger-bg);
            border-color: #f2c8d1;
        }

        .incident-status-received {
            color: var(--incident-info);
            background: var(--incident-info-bg);
            border-color: #c7e7f4;
        }

        .incident-status-processing {
            color: var(--incident-warning);
            background: var(--incident-warning-bg);
            border-color: #f1d9a5;
        }

        .incident-status-completed {
            color: var(--incident-success);
            background: var(--incident-success-bg);
            border-color: #bee8d2;
        }

        .incident-status-rejected,
        .incident-status-default {
            color: #596a86;
            background: #f1f4f8;
            border-color: #d8e0ec;
        }

        /* Mức độ */
        .incident-level-low {
            color: var(--incident-success);
            background: var(--incident-success-bg);
            border-color: #bee8d2;
        }

        .incident-level-medium {
            color: var(--incident-warning);
            background: var(--incident-warning-bg);
            border-color: #f1d9a5;
        }

        .incident-level-high {
            color: var(--incident-danger);
            background: var(--incident-danger-bg);
            border-color: #f2c8d1;
        }

        .incident-level-emergency {
            color: #ffffff;

            background:
                linear-gradient(
                    135deg,
                    #c52e4d,
                    #7d1f38
                );

            border-color: #a62541;

            box-shadow:
                0 5px 14px rgba(193, 61, 85, 0.22);
        }

        .incident-level-default {
            color: #596a86;
            background: #f1f4f8;
            border-color: #d8e0ec;
        }

        /* Nội dung báo cáo */
        .incident-content-section {
            position: relative;
            z-index: 2;
        }

        .incident-content-label {
            margin-bottom: 11px;

            color: #29457d;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;

            display: flex;
            align-items: center;
            gap: 7px;
        }

        .incident-content-label i {
            color: var(--incident-primary);
        }

        .incident-content-box {
            min-height: 160px;
            padding: 18px;

            color: #465777;
            background: #fafcff;

            border: 1px solid var(--incident-border);
            border-radius: 12px;

            font-size: 13px;
            line-height: 1.9;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        /* Phản hồi admin */
        .incident-admin-response {
            position: relative;
            padding: 18px 18px 18px 20px;

            color: #405170;
            background:
                linear-gradient(
                    135deg,
                    #f7f9ff,
                    #f4f7fd
                );

            border: 1px solid var(--incident-border);
            border-radius: 12px;

            font-size: 12px;
            line-height: 1.85;
            white-space: pre-line;
        }

        .incident-admin-response::before {
            position: absolute;
            top: 13px;
            bottom: 13px;
            left: 0;

            width: 4px;
            content: "";

            background:
                linear-gradient(
                    180deg,
                    var(--incident-primary),
                    var(--incident-purple)
                );

            border-radius: 0 6px 6px 0;
        }

        .incident-empty-response {
            padding: 26px 20px;

            color: var(--incident-muted);
            background: #fafcff;

            border: 1px dashed #cfd9e8;
            border-radius: 12px;

            text-align: center;
        }

        .incident-empty-response-icon {
            width: 45px;
            height: 45px;
            margin: 0 auto 10px;

            color: var(--incident-primary);
            background: #edf3ff;

            border: 1px solid #d4e2ff;
            border-radius: 12px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .incident-empty-response-title {
            color: #52617c;
            font-size: 12px;
            font-weight: 750;
        }

        .incident-empty-response-text {
            margin-top: 3px;
            font-size: 10px;
        }

        /* Timeline */
        .incident-timeline {
            position: relative;
        }

        .incident-timeline::before {
            position: absolute;
            top: 25px;
            bottom: 25px;
            left: 21px;

            width: 2px;
            content: "";

            background:
                linear-gradient(
                    180deg,
                    #b9ccf6,
                    #d6deec
                );
        }

        .incident-timeline-item {
            position: relative;

            min-height: 75px;
            padding: 0 0 22px 59px;
        }

        .incident-timeline-item:last-child {
            min-height: 50px;
            padding-bottom: 0;
        }

        .incident-timeline-icon {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 2;

            width: 44px;
            height: 44px;

            border: 4px solid var(--incident-white);
            border-radius: 50%;

            box-shadow:
                0 4px 14px rgba(28, 65, 139, 0.12);

            font-size: 12px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .incident-timeline-icon.active {
            color: var(--incident-white);

            background:
                linear-gradient(
                    135deg,
                    var(--incident-primary),
                    var(--incident-purple)
                );
        }

        .incident-timeline-icon.received {
            color: var(--incident-info);
            background: var(--incident-info-bg);
            border-color: #ffffff;
        }

        .incident-timeline-icon.completed {
            color: var(--incident-success);
            background: var(--incident-success-bg);
            border-color: #ffffff;
        }

        .incident-timeline-icon.pending {
            color: #8793a8;
            background: #eef2f7;
            border-color: #ffffff;
        }

        .incident-timeline-content {
            padding-top: 2px;
        }

        .incident-timeline-title {
            color: #29457d;
            font-size: 12px;
            font-weight: 780;
        }

        .incident-timeline-time {
            margin-top: 4px;

            color: var(--incident-muted);
            font-size: 10px;
            font-weight: 550;
        }

        .incident-timeline-note {
            margin-top: 5px;

            color: #8793a8;
            font-size: 9px;
        }

        /* Sidebar thông tin */
        .incident-info-list {
            display: flex;
            flex-direction: column;
        }

        .incident-info-row {
            padding: 13px 0;

            border-bottom: 1px solid var(--incident-border-light);

            display: grid;
            grid-template-columns: 120px minmax(0, 1fr);
            gap: 12px;
            align-items: start;
        }

        .incident-info-row:first-child {
            padding-top: 0;
        }

        .incident-info-row:last-child {
            padding-bottom: 0;
            border-bottom: none;
        }

        .incident-info-label {
            color: var(--incident-muted);
            font-size: 10px;
            font-weight: 700;

            display: flex;
            align-items: center;
            gap: 6px;
        }

        .incident-info-label i {
            width: 14px;
            color: var(--incident-primary);
            text-align: center;
        }

        .incident-info-value {
            color: #29457d;
            font-size: 11px;
            font-weight: 750;
            line-height: 1.6;
            text-align: right;
            overflow-wrap: anywhere;
        }

        .incident-code {
            padding: 5px 9px;

            color: var(--incident-primary);
            background: #edf3ff;

            border: 1px solid #d4e2ff;
            border-radius: 7px;

            font-size: 10px;
            font-weight: 800;

            display: inline-flex;
            align-items: center;
        }

        /* Tour card */
        .incident-tour-hero {
            margin-bottom: 14px;
            padding: 14px;

            background:
                linear-gradient(
                    135deg,
                    #f4f7ff,
                    #f7f5ff
                );

            border: 1px solid var(--incident-border);
            border-radius: 11px;

            display: flex;
            align-items: center;
            gap: 11px;
        }

        .incident-tour-icon {
            width: 41px;
            height: 41px;
            flex-shrink: 0;

            color: var(--incident-purple);
            background: #eeebff;

            border: 1px solid #dcd6ff;
            border-radius: 11px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .incident-tour-name {
            color: #29457d;
            font-size: 12px;
            font-weight: 780;
            line-height: 1.55;
            overflow-wrap: anywhere;
        }

        .incident-tour-code {
            margin-top: 2px;

            color: var(--incident-muted);
            font-size: 9px;
        }

        .incident-no-tour {
            padding: 28px 18px;

            color: var(--incident-muted);
            background: #fafcff;

            border: 1px dashed #cfd9e8;
            border-radius: 11px;

            font-size: 11px;
            text-align: center;
        }

        @media (max-width: 1100px) {
            .incident-layout {
                grid-template-columns: 1fr;
            }

            .incident-sidebar {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 20px;
            }

            .incident-sidebar .incident-card {
                margin-bottom: 0;
            }
        }

        @media (max-width: 768px) {
            .incident-page-header {
                align-items: stretch;
                flex-direction: column;
            }

            .incident-heading h2 {
                font-size: 20px;
            }

            .incident-back-button {
                width: 100%;
            }

            .incident-hero-top {
                flex-direction: column;
            }

            .incident-badges {
                justify-content: flex-start;
            }

            .incident-sidebar {
                grid-template-columns: 1fr;
            }

            .incident-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .incident-info-row {
                grid-template-columns: 105px minmax(0, 1fr);
            }
        }

        @media (max-width: 480px) {
            .incident-heading {
                align-items: flex-start;
            }

            .incident-heading-icon {
                width: 46px;
                height: 46px;
            }

            .incident-title {
                font-size: 18px;
            }

            .incident-card-body,
            .incident-hero {
                padding: 16px;
            }

            .incident-info-row {
                grid-template-columns: 1fr;
                gap: 5px;
            }

            .incident-info-value {
                text-align: left;
            }
        }
    </style>

    <div class="incident-page fade-in">
        {{-- Header --}}
        <div class="incident-page-header">
            <div class="incident-heading">
                <span class="incident-heading-icon">
                    <i class="fas fa-triangle-exclamation"></i>
                </span>

                <div>
                    <h2>Chi tiết báo cáo sự cố</h2>

                    <p>
                        Theo dõi nội dung, trạng thái và tiến trình xử lý báo cáo.
                    </p>
                </div>
            </div>

            <a
                href="{{ route('Guide.baocaosuco.index') }}"
                class="incident-back-button"
            >
                <i class="fas fa-arrow-left"></i>
                Quay lại danh sách
            </a>
        </div>

        {{-- Thông báo --}}
        @if (session('success'))
            <div
                class="incident-alert incident-alert-success"
                role="alert"
            >
                <i class="fas fa-circle-check"></i>

                <span>{{ session('success') }}</span>

                <button
                    type="button"
                    class="incident-alert-close"
                    onclick="this.parentElement.remove();"
                    aria-label="Đóng"
                >
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div
                class="incident-alert incident-alert-danger"
                role="alert"
            >
                <i class="fas fa-circle-exclamation"></i>

                <span>{{ session('error') }}</span>

                <button
                    type="button"
                    class="incident-alert-close"
                    onclick="this.parentElement.remove();"
                    aria-label="Đóng"
                >
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
        @endif

        <div class="incident-layout">
            {{-- Nội dung chính --}}
            <div class="incident-main">
                {{-- Nội dung báo cáo --}}
                <section class="incident-card">
                    <div class="incident-hero">
                        <div class="incident-hero-top">
                            <div class="incident-title-box">
                                <div class="incident-report-code">
                                    Báo cáo #{{ $baoCaoSuCo->id }}
                                </div>

                                <h1 class="incident-title">
                                    {{ $baoCaoSuCo->tieu_de }}
                                </h1>

                                <div class="incident-created-at">
                                    <i class="fas fa-clock"></i>

                                    Gửi lúc
                                    {{
                                        $baoCaoSuCo->created_at?->format(
                                            'd/m/Y H:i'
                                        )
                                        ?? '—'
                                    }}
                                </div>
                            </div>

                            <div class="incident-badges">
                                <span class="incident-badge {{ $mucDoStyle }}">
                                    <i class="fas {{ $mucDoIcon }}"></i>
                                    {{ $mucDoText }}
                                </span>

                                <span class="incident-badge {{ $trangThaiStyle }}">
                                    <i class="fas {{ $trangThaiIcon }}"></i>
                                    {{ $trangThaiText }}
                                </span>
                            </div>
                        </div>

                        <div class="incident-content-section">
                            <div class="incident-content-label">
                                <i class="fas fa-align-left"></i>
                                Nội dung sự cố
                            </div>

                            <div class="incident-content-box">
                                {{ $baoCaoSuCo->noi_dung }}
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Phản hồi Admin --}}
                <section class="incident-card">
                    <div class="incident-card-header">
                        <div class="incident-card-heading">
                            <span class="incident-card-icon">
                                <i class="fas fa-comments"></i>
                            </span>

                            <div>
                                <h3>Phản hồi từ Admin</h3>

                                <p>
                                    Nội dung hướng dẫn hoặc kết quả xử lý sự cố
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="incident-card-body">
                        @if (!empty($baoCaoSuCo->ghi_chu_xu_ly))
                            <div class="incident-admin-response">
                                {{ $baoCaoSuCo->ghi_chu_xu_ly }}
                            </div>
                        @else
                            <div class="incident-empty-response">
                                <div class="incident-empty-response-icon">
                                    <i class="fas fa-comment-slash"></i>
                                </div>

                                <div class="incident-empty-response-title">
                                    Chưa có phản hồi
                                </div>

                                <div class="incident-empty-response-text">
                                    Admin chưa gửi phản hồi cho báo cáo này.
                                </div>
                            </div>
                        @endif
                    </div>
                </section>

                {{-- Timeline --}}
                <section class="incident-card">
                    <div class="incident-card-header">
                        <div class="incident-card-heading">
                            <span class="incident-card-icon">
                                <i class="fas fa-timeline"></i>
                            </span>

                            <div>
                                <h3>Tiến trình xử lý</h3>

                                <p>
                                    Các mốc thời gian của báo cáo sự cố
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="incident-card-body">
                        <div class="incident-timeline">
                            <div class="incident-timeline-item">
                                <div class="incident-timeline-icon active">
                                    <i class="fas fa-paper-plane"></i>
                                </div>

                                <div class="incident-timeline-content">
                                    <div class="incident-timeline-title">
                                        Đã gửi báo cáo
                                    </div>

                                    <div class="incident-timeline-time">
                                        {{
                                            $baoCaoSuCo->created_at?->format(
                                                'd/m/Y H:i'
                                            )
                                            ?? '—'
                                        }}
                                    </div>

                                    <div class="incident-timeline-note">
                                        Báo cáo đã được gửi thành công đến hệ thống.
                                    </div>
                                </div>
                            </div>

                            <div class="incident-timeline-item">
                                <div
                                    class="incident-timeline-icon
                                        {{ $daTiepNhan ? 'received' : 'pending' }}"
                                >
                                    <i class="fas fa-hand"></i>
                                </div>

                                <div class="incident-timeline-content">
                                    <div class="incident-timeline-title">
                                        Admin tiếp nhận
                                    </div>

                                    <div class="incident-timeline-time">
                                        @if ($daTiepNhan)
                                            {{
                                                $baoCaoSuCo
                                                    ->thoi_gian_tiep_nhan
                                                    ->format('d/m/Y H:i')
                                            }}
                                        @else
                                            Chưa tiếp nhận
                                        @endif
                                    </div>

                                    <div class="incident-timeline-note">
                                        @if ($daTiepNhan)
                                            Báo cáo đang được kiểm tra và xử lý.
                                        @else
                                            Đang chờ Admin tiếp nhận báo cáo.
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="incident-timeline-item">
                                <div
                                    class="incident-timeline-icon
                                        {{ $daXuLy ? 'completed' : 'pending' }}"
                                >
                                    <i class="fas fa-check"></i>
                                </div>

                                <div class="incident-timeline-content">
                                    <div class="incident-timeline-title">
                                        Hoàn thành xử lý
                                    </div>

                                    <div class="incident-timeline-time">
                                        @if ($daXuLy)
                                            {{
                                                $baoCaoSuCo
                                                    ->thoi_gian_xu_ly
                                                    ->format('d/m/Y H:i')
                                            }}
                                        @else
                                            Chưa hoàn thành
                                        @endif
                                    </div>

                                    <div class="incident-timeline-note">
                                        @if ($daXuLy)
                                            Sự cố đã được Admin hoàn tất xử lý.
                                        @else
                                            Chưa có thời gian hoàn tất xử lý.
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Sidebar --}}
            <aside class="incident-sidebar">
                {{-- Thông tin báo cáo --}}
                <section class="incident-card">
                    <div class="incident-card-header">
                        <div class="incident-card-heading">
                            <span class="incident-card-icon">
                                <i class="fas fa-file-lines"></i>
                            </span>

                            <div>
                                <h4>Thông tin báo cáo</h4>

                                <p>
                                    Thông tin tổng quan của sự cố
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="incident-card-body">
                        <div class="incident-info-list">
                            <div class="incident-info-row">
                                <div class="incident-info-label">
                                    <i class="fas fa-hashtag"></i>
                                    Mã báo cáo
                                </div>

                                <div class="incident-info-value">
                                    <span class="incident-code">
                                        #{{ $baoCaoSuCo->id }}
                                    </span>
                                </div>
                            </div>

                            <div class="incident-info-row">
                                <div class="incident-info-label">
                                    <i class="fas {{ $loaiSuCoIcon }}"></i>
                                    Loại sự cố
                                </div>

                                <div class="incident-info-value">
                                    {{ $loaiSuCoText }}
                                </div>
                            </div>

                            <div class="incident-info-row">
                                <div class="incident-info-label">
                                    <i class="fas fa-gauge-high"></i>
                                    Mức độ
                                </div>

                                <div class="incident-info-value">
                                    <span class="incident-badge {{ $mucDoStyle }}">
                                        <i class="fas {{ $mucDoIcon }}"></i>
                                        {{ $mucDoText }}
                                    </span>
                                </div>
                            </div>

                            <div class="incident-info-row">
                                <div class="incident-info-label">
                                    <i class="fas fa-chart-simple"></i>
                                    Trạng thái
                                </div>

                                <div class="incident-info-value">
                                    <span class="incident-badge {{ $trangThaiStyle }}">
                                        <i class="fas {{ $trangThaiIcon }}"></i>
                                        {{ $trangThaiText }}
                                    </span>
                                </div>
                            </div>

                            <div class="incident-info-row">
                                <div class="incident-info-label">
                                    <i class="fas fa-calendar"></i>
                                    Ngày gửi
                                </div>

                                <div class="incident-info-value">
                                    {{
                                        $baoCaoSuCo->created_at?->format(
                                            'd/m/Y H:i'
                                        )
                                        ?? '—'
                                    }}
                                </div>
                            </div>

                            <div class="incident-info-row">
                                <div class="incident-info-label">
                                    <i class="fas fa-user-shield"></i>
                                    Admin xử lý
                                </div>

                                <div class="incident-info-value">
                                    {{ $adminXuLy }}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Thông tin Tour --}}
                <section class="incident-card">
                    <div class="incident-card-header">
                        <div class="incident-card-heading">
                            <span class="incident-card-icon">
                                <i class="fas fa-route"></i>
                            </span>

                            <div>
                                <h4>Thông tin Tour</h4>

                                <p>
                                    Lịch khởi hành liên quan đến sự cố
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="incident-card-body">
                        @if ($baoCaoSuCo->lichKhoiHanh)
                            <div class="incident-tour-hero">
                                <div class="incident-tour-icon">
                                    <i class="fas fa-map-location-dot"></i>
                                </div>

                                <div>
                                    <div class="incident-tour-name">
                                        {{ $tourName }}
                                    </div>

                                    <div class="incident-tour-code">
                                        Lịch khởi hành
                                        #{{ $baoCaoSuCo->lich_khoi_hanh_id }}
                                    </div>
                                </div>
                            </div>

                            <div class="incident-info-list">
                                <div class="incident-info-row">
                                    <div class="incident-info-label">
                                        <i class="fas fa-plane-departure"></i>
                                        Khởi hành
                                    </div>

                                    <div class="incident-info-value">
                                        {{
                                            $baoCaoSuCo
                                                ->lichKhoiHanh
                                                ->ngay_khoi_hanh
                                                ?->format('d/m/Y')
                                            ?? '—'
                                        }}
                                    </div>
                                </div>

                                <div class="incident-info-row">
                                    <div class="incident-info-label">
                                        <i class="fas fa-flag-checkered"></i>
                                        Kết thúc
                                    </div>

                                    <div class="incident-info-value">
                                        {{
                                            $baoCaoSuCo
                                                ->lichKhoiHanh
                                                ->ngay_ket_thuc
                                                ?->format('d/m/Y')
                                            ?? '—'
                                        }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="incident-no-tour">
                                <i class="fas fa-route mb-2"></i>

                                <div>
                                    Không tìm thấy thông tin lịch khởi hành.
                                </div>
                            </div>
                        @endif
                    </div>
                </section>
            </aside>

        </div>
    </div>
@endsection
