@extends('layouts.guide')

@section('title', 'Chi tiết Tour')

@section('guide', 'Chi tiết Tour')

@section('page-title', 'Chi tiết Tour')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('Guide.tour-phan-cong.index') }}">
            Tour được phân công
        </a>
    </li>

    <li class="breadcrumb-item active">
        Chi tiết Tour
    </li>
@endsection

@section('content')
    <style>
        :root {
            --tour-detail-primary: #315be8;
            --tour-detail-primary-dark: #264ed4;
            --tour-detail-purple: #5b4dea;

            --tour-detail-dark: #173576;
            --tour-detail-text: #344563;
            --tour-detail-muted: #6b7895;
            --tour-detail-light: #98a2b3;

            --tour-detail-white: #ffffff;
            --tour-detail-soft: #f5f8ff;
            --tour-detail-hover: #f3f7ff;
            --tour-detail-surface: #fbfdff;

            --tour-detail-border: #dce6f5;
            --tour-detail-border-light: #e8eef8;

            --tour-detail-success: #08754a;
            --tour-detail-success-bg: #eaf9f1;

            --tour-detail-warning: #ae6c0d;
            --tour-detail-warning-bg: #fff7e8;

            --tour-detail-danger: #c13d55;
            --tour-detail-danger-bg: #fff0f3;

            --tour-detail-info: #1975a8;
            --tour-detail-info-bg: #ebf8ff;

            --tour-detail-radius-sm: 10px;
            --tour-detail-radius-md: 14px;
            --tour-detail-radius-lg: 18px;

            --tour-detail-shadow-sm: 0 5px 16px rgba(28, 65, 139, 0.07);
            --tour-detail-shadow-md: 0 12px 34px rgba(28, 65, 139, 0.10);
            --tour-detail-shadow-primary: 0 10px 24px rgba(49, 91, 232, 0.22);
        }

        .tour-detail-page,
        .tour-detail-page *,
        .tour-detail-page *::before,
        .tour-detail-page *::after {
            box-sizing: border-box;
        }

        .tour-detail-page {
            position: relative;
            padding: 6px 0 30px;
            color: var(--tour-detail-text);
            font-family: inherit;
        }

        .tour-detail-page::before {
            position: absolute;
            top: -80px;
            right: -70px;
            z-index: -1;
            width: 280px;
            height: 280px;
            content: "";
            pointer-events: none;
            background: radial-gradient(
                circle,
                rgba(91, 77, 234, 0.10) 0%,
                rgba(49, 91, 232, 0.04) 45%,
                transparent 72%
            );
            border-radius: 50%;
        }

        .tour-detail-page a:focus-visible {
            outline: 3px solid rgba(49, 91, 232, 0.22);
            outline-offset: 3px;
        }

        /* Header */
        .tour-detail-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 22px;
        }

        .tour-detail-heading {
            display: flex;
            align-items: center;
            min-width: 0;
            gap: 14px;
        }

        .tour-detail-heading-icon {
            display: inline-flex;
            flex: 0 0 54px;
            align-items: center;
            justify-content: center;
            width: 54px;
            height: 54px;
            color: var(--tour-detail-white);
            background: linear-gradient(
                135deg,
                var(--tour-detail-primary),
                var(--tour-detail-purple)
            );
            border: 1px solid rgba(255, 255, 255, 0.34);
            border-radius: 15px;
            box-shadow: var(--tour-detail-shadow-primary);
            font-size: 20px;
        }

        .tour-detail-heading-content {
            min-width: 0;
        }

        .tour-detail-heading h2 {
            margin: 0;
            color: var(--tour-detail-dark);
            font-size: clamp(21px, 2vw, 26px);
            font-weight: 800;
            line-height: 1.25;
            letter-spacing: -0.35px;
        }

        .tour-detail-heading p {
            max-width: 720px;
            margin: 5px 0 0;
            overflow: hidden;
            color: var(--tour-detail-muted);
            font-size: 13px;
            line-height: 1.5;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .btn-tour-detail-back {
            display: inline-flex;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            min-height: 43px;
            padding: 10px 16px;
            color: #53698f;
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid #ccd9ed;
            border-radius: 11px;
            box-shadow: 0 4px 12px rgba(28, 65, 139, 0.05);
            font-size: 12px;
            font-weight: 750;
            text-decoration: none;
            gap: 8px;
            transition:
                color 0.2s ease,
                background-color 0.2s ease,
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                transform 0.2s ease;
        }

        .btn-tour-detail-back:hover {
            color: var(--tour-detail-primary);
            background: var(--tour-detail-white);
            border-color: #b9cbed;
            box-shadow: 0 8px 20px rgba(49, 91, 232, 0.10);
            text-decoration: none;
            transform: translateY(-2px);
        }

        /* Layout */
        .tour-detail-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(310px, 360px);
            align-items: start;
            gap: 22px;
        }

        .tour-detail-main,
        .tour-detail-sidebar {
            min-width: 0;
        }

        .tour-detail-main,
        .tour-detail-sidebar {
            display: flex;
            flex-direction: column;
            gap: 22px;
        }

        .tour-detail-sidebar {
            position: sticky;
            top: 20px;
        }

        /* Card */
        .tour-detail-card {
            position: relative;
            overflow: hidden;
            margin: 0;
            background: var(--tour-detail-white);
            border: 1px solid var(--tour-detail-border);
            border-radius: var(--tour-detail-radius-lg);
            box-shadow: var(--tour-detail-shadow-md);
        }

        .tour-detail-card::after {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            content: "";
            pointer-events: none;
            background: linear-gradient(
                90deg,
                var(--tour-detail-primary),
                var(--tour-detail-purple)
            );
            opacity: 0.88;
        }

        .tour-detail-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 72px;
            padding: 17px 20px;
            color: #24417d;
            background: linear-gradient(135deg, #f4f8ff 0%, #eef4ff 100%);
            border-bottom: 1px solid var(--tour-detail-border);
            gap: 14px;
        }

        .tour-detail-card-title {
            display: flex;
            align-items: center;
            min-width: 0;
            gap: 11px;
        }

        .tour-detail-card-title-icon {
            display: inline-flex;
            flex: 0 0 40px;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            color: var(--tour-detail-primary);
            background: linear-gradient(135deg, #edf3ff, #e6eeff);
            border: 1px solid #ccdbfb;
            border-radius: 11px;
            box-shadow: 0 4px 12px rgba(49, 91, 232, 0.08);
            font-size: 14px;
        }

        .tour-detail-card-title > div {
            min-width: 0;
        }

        .tour-detail-card-title h3,
        .tour-detail-card-title h4 {
            margin: 0;
            overflow-wrap: anywhere;
            color: #24417d;
            font-size: 15px;
            font-weight: 800;
            line-height: 1.4;
        }

        .tour-detail-card-title p {
            margin: 3px 0 0;
            color: var(--tour-detail-muted);
            font-size: 11px;
            line-height: 1.45;
        }

        .tour-detail-card-body {
            padding: 20px;
        }

        /* Badge trạng thái */
        .tour-detail-status,
        .tour-detail-inline-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            max-width: 100%;
            border: 1px solid transparent;
            border-radius: 999px;
            font-weight: 800;
            line-height: 1.2;
            white-space: nowrap;
            gap: 6px;
        }

        .tour-detail-status {
            flex-shrink: 0;
            min-height: 29px;
            padding: 6px 11px;
            font-size: 10px;
        }

        .tour-detail-inline-status {
            min-height: 27px;
            padding: 5px 10px;
            font-size: 10px;
        }

        .tour-detail-status-dot {
            width: 7px;
            height: 7px;
            flex-shrink: 0;
            background: currentColor;
            border-radius: 50%;
            box-shadow: 0 0 0 3px rgba(8, 117, 74, 0.09);
        }

        .tour-status-success {
            color: var(--tour-detail-success);
            background: var(--tour-detail-success-bg);
            border-color: #c5ead8;
        }

        .tour-status-warning {
            color: var(--tour-detail-warning);
            background: var(--tour-detail-warning-bg);
            border-color: #f1dba9;
        }

        .tour-status-danger {
            color: var(--tour-detail-danger);
            background: var(--tour-detail-danger-bg);
            border-color: #f0c9d1;
        }

        .tour-status-info {
            color: var(--tour-detail-info);
            background: var(--tour-detail-info-bg);
            border-color: #c9e8f7;
        }

        /* Lưới thông tin */
        .tour-detail-info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .tour-detail-info-item {
            position: relative;
            display: flex;
            align-items: flex-start;
            min-width: 0;
            min-height: 88px;
            padding: 15px;
            overflow: hidden;
            background: linear-gradient(145deg, #ffffff 0%, #f9fbff 100%);
            border: 1px solid var(--tour-detail-border);
            border-radius: var(--tour-detail-radius-md);
            gap: 11px;
            transition:
                background-color 0.2s ease,
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                transform 0.2s ease;
        }

        .tour-detail-info-item::before {
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            content: "";
            background: linear-gradient(
                180deg,
                var(--tour-detail-primary),
                var(--tour-detail-purple)
            );
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .tour-detail-info-item:hover {
            background: var(--tour-detail-hover);
            border-color: #bfd0ec;
            box-shadow: var(--tour-detail-shadow-sm);
            transform: translateY(-2px);
        }

        .tour-detail-info-item:hover::before {
            opacity: 1;
        }

        .tour-detail-info-item--wide {
            grid-column: 1 / -1;
            min-height: 96px;
        }

        .tour-detail-info-icon {
            display: inline-flex;
            flex: 0 0 39px;
            align-items: center;
            justify-content: center;
            width: 39px;
            height: 39px;
            color: var(--tour-detail-primary);
            background: #edf3ff;
            border: 1px solid #d4e2ff;
            border-radius: 11px;
            font-size: 13px;
        }

        .tour-detail-info-content {
            flex: 1 1 auto;
            min-width: 0;
        }

        .tour-detail-info-label {
            margin-bottom: 5px;
            color: var(--tour-detail-muted);
            font-size: 10px;
            font-weight: 800;
            line-height: 1.35;
            letter-spacing: 0.045em;
            text-transform: uppercase;
        }

        .tour-detail-info-value {
            color: #29457d;
            font-size: 13px;
            font-weight: 750;
            line-height: 1.55;
            overflow-wrap: anywhere;
        }

        .tour-detail-info-subtext {
            margin-top: 3px;
            color: var(--tour-detail-muted);
            font-size: 10px;
            line-height: 1.45;
        }

        /* Sức chứa */
        .tour-detail-capacity {
            margin-top: 10px;
        }

        .tour-detail-capacity-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 7px;
            color: var(--tour-detail-muted);
            font-size: 10px;
            font-weight: 700;
            gap: 12px;
        }

        .tour-detail-capacity-percent {
            color: var(--tour-detail-primary);
            font-weight: 850;
        }

        .tour-detail-capacity-track {
            width: 100%;
            height: 8px;
            overflow: hidden;
            background: #e5eaf3;
            border: 1px solid #dce3ee;
            border-radius: 999px;
        }

        .tour-detail-capacity-bar {
            min-width: 0;
            height: 100%;
            background: linear-gradient(
                90deg,
                var(--tour-detail-primary),
                var(--tour-detail-purple)
            );
            border-radius: inherit;
            box-shadow: 0 0 12px rgba(49, 91, 232, 0.22);
            transition: width 0.45s ease;
        }

        /* Mô tả */
        .tour-detail-description {
            color: #4d5d7d;
            font-size: 13px;
            line-height: 1.85;
            overflow-wrap: anywhere;
        }

        .tour-detail-description h1,
        .tour-detail-description h2,
        .tour-detail-description h3,
        .tour-detail-description h4,
        .tour-detail-description h5,
        .tour-detail-description h6 {
            margin-top: 1.25em;
            margin-bottom: 0.55em;
            color: var(--tour-detail-dark);
            font-weight: 800;
            line-height: 1.4;
        }

        .tour-detail-description h1:first-child,
        .tour-detail-description h2:first-child,
        .tour-detail-description h3:first-child,
        .tour-detail-description p:first-child {
            margin-top: 0;
        }

        .tour-detail-description p {
            margin-bottom: 1em;
        }

        .tour-detail-description p:last-child {
            margin-bottom: 0;
        }

        .tour-detail-description ul,
        .tour-detail-description ol {
            padding-left: 22px;
        }

        .tour-detail-description a {
            color: var(--tour-detail-primary);
            font-weight: 700;
            text-decoration: underline;
            text-decoration-thickness: 1px;
            text-underline-offset: 3px;
        }

        .tour-detail-description blockquote {
            margin: 16px 0;
            padding: 12px 15px;
            color: #41567e;
            background: var(--tour-detail-soft);
            border-left: 4px solid var(--tour-detail-primary);
            border-radius: 0 10px 10px 0;
        }

        .tour-detail-description img {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 14px auto;
            border: 1px solid var(--tour-detail-border);
            border-radius: 12px;
            box-shadow: var(--tour-detail-shadow-sm);
        }

        .tour-detail-description table {
            width: 100%;
            margin: 15px 0;
            overflow: hidden;
            border-collapse: collapse;
            border: 1px solid var(--tour-detail-border);
            border-radius: 10px;
        }

        .tour-detail-description th,
        .tour-detail-description td {
            padding: 10px 12px;
            border: 1px solid var(--tour-detail-border);
            text-align: left;
        }

        .tour-detail-description th {
            color: #24417d;
            background: var(--tour-detail-soft);
            font-weight: 800;
        }

        /* Thao tác */
        .tour-detail-actions {
            display: grid;
            gap: 10px;
        }

        .tour-detail-action {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            min-height: 48px;
            padding: 10px 13px;
            border: 1px solid transparent;
            border-radius: 11px;
            font-size: 12px;
            font-weight: 800;
            line-height: 1.35;
            text-decoration: none;
            gap: 10px;
            transition:
                color 0.2s ease,
                background-color 0.2s ease,
                border-color 0.2s ease,
                box-shadow 0.2s ease,
                transform 0.2s ease;
        }

        .tour-detail-action:hover {
            text-decoration: none;
            transform: translateY(-2px);
        }

        .tour-detail-action-icon {
            display: inline-flex;
            flex: 0 0 31px;
            align-items: center;
            justify-content: center;
            width: 31px;
            height: 31px;
            border-radius: 8px;
            font-size: 12px;
            transition: transform 0.2s ease;
        }

        .tour-detail-action:hover .tour-detail-action-icon {
            transform: scale(1.05);
        }

        .tour-action-primary {
            color: var(--tour-detail-white);
            background: linear-gradient(
                135deg,
                var(--tour-detail-primary),
                var(--tour-detail-purple)
            );
            border-color: var(--tour-detail-primary);
            box-shadow: 0 7px 18px rgba(49, 91, 232, 0.20);
        }

        .tour-action-primary:hover {
            color: var(--tour-detail-white);
            background: linear-gradient(
                135deg,
                var(--tour-detail-primary-dark),
                #4c40d7
            );
            box-shadow: 0 10px 22px rgba(49, 91, 232, 0.26);
        }

        .tour-action-primary .tour-detail-action-icon {
            background: rgba(255, 255, 255, 0.16);
        }

        .tour-action-success {
            color: var(--tour-detail-success);
            background: var(--tour-detail-success-bg);
            border-color: #c5ead8;
        }

        .tour-action-success:hover {
            color: var(--tour-detail-white);
            background: #12935f;
            border-color: #12935f;
            box-shadow: 0 8px 18px rgba(18, 147, 95, 0.18);
        }

        .tour-action-success .tour-detail-action-icon {
            background: rgba(8, 117, 74, 0.09);
        }

        .tour-action-warning {
            color: var(--tour-detail-warning);
            background: var(--tour-detail-warning-bg);
            border-color: #f1dba9;
        }

        .tour-action-warning:hover {
            color: var(--tour-detail-white);
            background: #dc941e;
            border-color: #dc941e;
            box-shadow: 0 8px 18px rgba(220, 148, 30, 0.18);
        }

        .tour-action-warning .tour-detail-action-icon {
            background: rgba(174, 108, 13, 0.09);
        }

        .tour-action-danger {
            color: var(--tour-detail-danger);
            background: var(--tour-detail-danger-bg);
            border-color: #f0c9d1;
        }

        .tour-action-danger:hover {
            color: var(--tour-detail-white);
            background: var(--tour-detail-danger);
            border-color: var(--tour-detail-danger);
            box-shadow: 0 8px 18px rgba(193, 61, 85, 0.18);
        }

        .tour-action-danger .tour-detail-action-icon {
            background: rgba(193, 61, 85, 0.09);
        }

        .tour-action-secondary {
            color: #53698f;
            background: var(--tour-detail-white);
            border-color: #ccd9ed;
        }

        .tour-action-secondary:hover {
            color: #304d83;
            background: #edf3fb;
            border-color: #b9c9e0;
            box-shadow: 0 8px 18px rgba(28, 65, 139, 0.10);
        }

        .tour-action-secondary .tour-detail-action-icon {
            background: #eef2f8;
        }

        .tour-action-disabled {
            cursor: not-allowed;
            pointer-events: none;
            opacity: 0.55;
        }

        /* Thông tin nhanh */
        .tour-quick-list {
            display: flex;
            flex-direction: column;
        }

        .tour-quick-item {
            display: grid;
            grid-template-columns: minmax(90px, 0.8fr) minmax(0, 1.2fr);
            align-items: start;
            padding: 13px 0;
            border-bottom: 1px dashed var(--tour-detail-border);
            gap: 12px;
        }

        .tour-quick-item:first-child {
            padding-top: 0;
        }

        .tour-quick-item:last-child {
            padding-bottom: 0;
            border-bottom: none;
        }

        .tour-quick-label {
            color: var(--tour-detail-muted);
            font-size: 10px;
            font-weight: 750;
            line-height: 1.5;
        }

        .tour-quick-value {
            min-width: 0;
            color: #29457d;
            font-size: 11px;
            font-weight: 800;
            line-height: 1.55;
            text-align: right;
            overflow-wrap: anywhere;
        }

        /* Hiệu ứng xuất hiện */
        .tour-detail-page.fade-in {
            animation: tourDetailFadeIn 0.38s ease both;
        }

        @keyframes tourDetailFadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 1199.98px) {
            .tour-detail-layout {
                grid-template-columns: minmax(0, 1fr) minmax(290px, 330px);
                gap: 18px;
            }
        }

        @media (max-width: 991.98px) {
            .tour-detail-layout {
                grid-template-columns: 1fr;
            }

            .tour-detail-sidebar {
                position: static;
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
                align-items: start;
            }
        }

        @media (max-width: 767.98px) {
            .tour-detail-page {
                padding-top: 2px;
            }

            .tour-detail-header {
                align-items: stretch;
                flex-direction: column;
                gap: 14px;
            }

            .tour-detail-heading {
                align-items: flex-start;
            }

            .tour-detail-heading-icon {
                flex-basis: 48px;
                width: 48px;
                height: 48px;
                border-radius: 13px;
                font-size: 18px;
            }

            .tour-detail-heading p {
                white-space: normal;
            }

            .btn-tour-detail-back {
                width: 100%;
            }

            .tour-detail-sidebar,
            .tour-detail-info-grid {
                grid-template-columns: 1fr;
            }

            .tour-detail-info-item--wide {
                grid-column: auto;
            }

            .tour-detail-card-header {
                min-height: auto;
                padding: 15px 16px;
            }

            .tour-detail-card-body {
                padding: 16px;
            }
        }

        @media (max-width: 575.98px) {
            .tour-detail-card {
                border-radius: 14px;
            }

            .tour-detail-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .tour-detail-card-title-icon {
                flex-basis: 36px;
                width: 36px;
                height: 36px;
            }

            .tour-detail-status {
                align-self: flex-start;
            }

            .tour-detail-info-item {
                min-height: auto;
                padding: 13px;
            }

            .tour-quick-item {
                grid-template-columns: 88px minmax(0, 1fr);
                gap: 8px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .tour-detail-page.fade-in,
            .tour-detail-page *,
            .tour-detail-page *::before,
            .tour-detail-page *::after {
                scroll-behavior: auto !important;
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>

    @php
        $lichKhoiHanh = $tour->lichKhoiHanh;
        $tourInfo = $lichKhoiHanh->tour ?? null;
        $phuongTien = $tour->phuongTien;
        $huongDanVien = $tour->hdv;

        $soChoDaDat = (int) ($lichKhoiHanh->so_cho_da_dat ?? 0);
        $tongSoCho = (int) ($lichKhoiHanh->so_cho ?? 0);

        $phanTramCho = $tongSoCho > 0
            ? round(($soChoDaDat / $tongSoCho) * 100)
            : 0;

        $phanTramCho = min(max($phanTramCho, 0), 100);

        $trangThaiRaw = strtolower(trim((string) ($lichKhoiHanh->trang_thai ?? '')));

        $trangThaiMap = [
            'sap_khoi_hanh' => ['Sắp khởi hành', 'warning', 'fa-hourglass-start'],
            'cho_khoi_hanh' => ['Chờ khởi hành', 'warning', 'fa-clock'],
            'dang_dien_ra' => ['Đang diễn ra', 'success', 'fa-route'],
            'dang_khoi_hanh' => ['Đang diễn ra', 'success', 'fa-route'],
            'da_ket_thuc' => ['Đã kết thúc', 'info', 'fa-flag-checkered'],
            'hoan_thanh' => ['Đã hoàn thành', 'info', 'fa-circle-check'],
            'tam_hoan' => ['Tạm hoãn', 'warning', 'fa-pause'],
            'da_huy' => ['Đã hủy', 'danger', 'fa-ban'],
            'huy' => ['Đã hủy', 'danger', 'fa-ban'],
            'active' => ['Đang hoạt động', 'success', 'fa-circle-check'],
            'inactive' => ['Tạm ngưng', 'warning', 'fa-pause'],
        ];

        $trangThaiData = $trangThaiMap[$trangThaiRaw] ?? [
            !empty($lichKhoiHanh->trang_thai)
                ? $lichKhoiHanh->trang_thai
                : 'Chưa cập nhật',
            'info',
            'fa-circle-info',
        ];

        [$trangThaiText, $trangThaiClass, $trangThaiIcon] = $trangThaiData;
    @endphp

    <div class="tour-detail-page fade-in">
        {{-- Header --}}
        <div class="tour-detail-header">
            <div class="tour-detail-heading">
                <span class="tour-detail-heading-icon">
                    <i class="fas fa-route"></i>
                </span>

                <div class="tour-detail-heading-content">
                    <h2>Chi tiết Tour</h2>

                    <p>
                        {{ $tourInfo->ten_tour ?? 'Tour không xác định' }}
                    </p>
                </div>
            </div>

            <a
                href="{{ route('Guide.tour-phan-cong.index') }}"
                class="btn-tour-detail-back"
            >
                <i class="fas fa-arrow-left"></i>
                Quay lại danh sách
            </a>
        </div>

        <div class="tour-detail-layout">
            {{-- Nội dung chính --}}
            <main class="tour-detail-main">
                <section class="tour-detail-card">
                    <div class="tour-detail-card-header">
                        <div class="tour-detail-card-title">
                            <span class="tour-detail-card-title-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </span>

                            <div>
                                <h3>
                                    {{ $tourInfo->ten_tour ?? 'Tour không xác định' }}
                                </h3>

                                <p>Mã phân công #{{ $tour->id }}</p>
                            </div>
                        </div>

                        <span class="tour-detail-status tour-status-success">
                            <span class="tour-detail-status-dot"></span>
                            Đã phân công
                        </span>
                    </div>

                    <div class="tour-detail-card-body">
                        <div class="tour-detail-info-grid">
                            <div class="tour-detail-info-item">
                                <span class="tour-detail-info-icon">
                                    <i class="fas fa-plane-departure"></i>
                                </span>

                                <div class="tour-detail-info-content">
                                    <div class="tour-detail-info-label">
                                        Ngày khởi hành
                                    </div>

                                    <div class="tour-detail-info-value">
                                        @if ($lichKhoiHanh->ngay_khoi_hanh)
                                            {{
                                                \Carbon\Carbon::parse(
                                                    $lichKhoiHanh->ngay_khoi_hanh
                                                )->format('d/m/Y')
                                            }}
                                        @else
                                            Chưa cập nhật
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="tour-detail-info-item">
                                <span class="tour-detail-info-icon">
                                    <i class="fas fa-flag-checkered"></i>
                                </span>

                                <div class="tour-detail-info-content">
                                    <div class="tour-detail-info-label">
                                        Ngày kết thúc
                                    </div>

                                    <div class="tour-detail-info-value">
                                        @if ($lichKhoiHanh->ngay_ket_thuc)
                                            {{
                                                \Carbon\Carbon::parse(
                                                    $lichKhoiHanh->ngay_ket_thuc
                                                )->format('d/m/Y')
                                            }}
                                        @else
                                            Chưa cập nhật
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="tour-detail-info-item">
                                <span class="tour-detail-info-icon">
                                    <i class="fas {{ $trangThaiIcon }}"></i>
                                </span>

                                <div class="tour-detail-info-content">
                                    <div class="tour-detail-info-label">
                                        Trạng thái khởi hành
                                    </div>

                                    <div class="tour-detail-info-value">
                                        <span class="tour-detail-inline-status tour-status-{{ $trangThaiClass }}">
                                            {{ $trangThaiText }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="tour-detail-info-item">
                                <span class="tour-detail-info-icon">
                                    <i class="fas fa-user-tie"></i>
                                </span>

                                <div class="tour-detail-info-content">
                                    <div class="tour-detail-info-label">
                                        Hướng dẫn viên
                                    </div>

                                    <div class="tour-detail-info-value">
                                        {{ $huongDanVien->ho_ten ?? 'Chưa phân công' }}
                                    </div>
                                </div>
                            </div>

                            <div class="tour-detail-info-item">
                                <span class="tour-detail-info-icon">
                                    <i class="fas fa-bus"></i>
                                </span>

                                <div class="tour-detail-info-content">
                                    <div class="tour-detail-info-label">
                                        Phương tiện
                                    </div>

                                    <div class="tour-detail-info-value">
                                        {{ $phuongTien->ten_phuong_tien ?? 'Chưa cập nhật' }}
                                    </div>
                                </div>
                            </div>

                            <div class="tour-detail-info-item">
                                <span class="tour-detail-info-icon">
                                    <i class="fas fa-id-card"></i>
                                </span>

                                <div class="tour-detail-info-content">
                                    <div class="tour-detail-info-label">
                                        Biển số xe
                                    </div>

                                    <div class="tour-detail-info-value">
                                        {{ $phuongTien->bien_so_xe ?? 'Chưa cập nhật' }}
                                    </div>
                                </div>
                            </div>

                            <div class="tour-detail-info-item tour-detail-info-item--wide">
                                <span class="tour-detail-info-icon">
                                    <i class="fas fa-users"></i>
                                </span>

                                <div class="tour-detail-info-content">
                                    <div class="tour-detail-info-label">
                                        Số lượng khách
                                    </div>

                                    <div class="tour-detail-info-value">
                                        {{ $soChoDaDat }}/{{ $tongSoCho }} khách
                                    </div>

                                    <div class="tour-detail-capacity">
                                        <div class="tour-detail-capacity-head">
                                            <span>Mức sử dụng sức chứa</span>
                                            <span class="tour-detail-capacity-percent">
                                                {{ $phanTramCho }}%
                                            </span>
                                        </div>

                                        <div class="tour-detail-capacity-track">
                                            <div
                                                class="tour-detail-capacity-bar"
                                                style="width: {{ $phanTramCho }}%;"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Mô tả --}}
                <section class="tour-detail-card">
                    <div class="tour-detail-card-header">
                        <div class="tour-detail-card-title">
                            <span class="tour-detail-card-title-icon">
                                <i class="fas fa-align-left"></i>
                            </span>

                            <div>
                                <h4>Mô tả Tour</h4>
                                <p>Thông tin giới thiệu và nội dung Tour</p>
                            </div>
                        </div>
                    </div>

                    <div class="tour-detail-card-body">
                        <div class="tour-detail-description">
                            @if (!empty($tourInfo->mo_ta))
                                {!! $tourInfo->mo_ta !!}
                            @else
                                <p class="text-muted fst-italic mb-0">
                                    Tour chưa có nội dung mô tả.
                                </p>
                            @endif
                        </div>
                    </div>
                </section>
            </main>

            {{-- Sidebar bên phải --}}
            <aside class="tour-detail-sidebar">
                {{-- Thao tác --}}
                <section class="tour-detail-card">
                    <div class="tour-detail-card-header">
                        <div class="tour-detail-card-title">
                            <span class="tour-detail-card-title-icon">
                                <i class="fas fa-bolt"></i>
                            </span>

                            <div>
                                <h4>Thao tác</h4>
                                <p>Truy cập nhanh nghiệp vụ Tour</p>
                            </div>
                        </div>
                    </div>

                    <div class="tour-detail-card-body">
                        <div class="tour-detail-actions">
                            <a
                                href="{{ route('Guide.danh-sach-khach', $tour->id) }}"
                                class="tour-detail-action tour-action-primary"
                            >
                                <span class="tour-detail-action-icon">
                                    <i class="fas fa-users"></i>
                                </span>
                                Danh sách khách
                            </a>

                            <a
                                href="{{ route('Guide.checkin.dia-diem', $lichKhoiHanh->id) }}"
                                class="tour-detail-action tour-action-success"
                            >
                                <span class="tour-detail-action-icon">
                                    <i class="fas fa-user-check"></i>
                                </span>
                                Check-in khách
                            </a>

                            <a
                                href="{{ route('Guide.lich-trinh', $tour->id) }}"
                                class="tour-detail-action tour-action-warning"
                            >
                                <span class="tour-detail-action-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </span>
                                Lịch trình Tour
                            </a>

                            <a
                                href="{{ route('Guide.baocaosuco.index') }}"
                                class="tour-detail-action tour-action-danger"
                            >
                                <span class="tour-detail-action-icon">
                                    <i class="fas fa-triangle-exclamation"></i>
                                </span>
                                Báo cáo sự cố
                            </a>

                            <a
                                href="{{ route('Guide.tour-phan-cong.index') }}"
                                class="tour-detail-action tour-action-secondary"
                            >
                                <span class="tour-detail-action-icon">
                                    <i class="fas fa-arrow-left"></i>
                                </span>
                                Quay lại
                            </a>
                        </div>
                    </div>
                </section>

                {{-- Thông tin nhanh --}}
                <section class="tour-detail-card">
                    <div class="tour-detail-card-header">
                        <div class="tour-detail-card-title">
                            <span class="tour-detail-card-title-icon">
                                <i class="fas fa-circle-info"></i>
                            </span>

                            <div>
                                <h4>Thông tin nhanh</h4>
                                <p>Tóm tắt Tour được phân công</p>
                            </div>
                        </div>
                    </div>

                    <div class="tour-detail-card-body">
                        <div class="tour-quick-list">
                            <div class="tour-quick-item">
                                <div class="tour-quick-label">Tour</div>
                                <div class="tour-quick-value">
                                    {{ $tourInfo->ten_tour ?? 'Không xác định' }}
                                </div>
                            </div>

                            <div class="tour-quick-item">
                                <div class="tour-quick-label">Hướng dẫn viên</div>
                                <div class="tour-quick-value">
                                    {{ $huongDanVien->ho_ten ?? 'Chưa phân công' }}
                                </div>
                            </div>


                            <div class="tour-quick-item">
                                <div class="tour-quick-label">Biển số</div>
                                <div class="tour-quick-value">
                                    {{ $phuongTien->bien_so_xe ?? 'Chưa cập nhật' }}
                                </div>
                            </div>

                            <div class="tour-quick-item">
                                <div class="tour-quick-label">Số khách</div>
                                <div class="tour-quick-value">
                                    {{ $soChoDaDat }}/{{ $tongSoCho }}
                                </div>
                            </div>

                            <div class="tour-quick-item">
                                <div class="tour-quick-label">Khởi hành</div>
                                <div class="tour-quick-value">
                                    <span class="tour-detail-inline-status tour-status-{{ $trangThaiClass }}">
                                        {{ $trangThaiText }}
                                    </span>
                                </div>
                            </div>

                            <div class="tour-quick-item">
                                <div class="tour-quick-label">Phân công</div>
                                <div class="tour-quick-value">
                                    <span class="tour-detail-status tour-status-success">
                                        <span class="tour-detail-status-dot"></span>
                                        Đã phân công
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </aside>
        </div>
    </div>
@endsection
