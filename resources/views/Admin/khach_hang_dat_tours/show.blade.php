@extends('layouts.admin')

@section('title', 'Chi tiết khách hàng')

@section('content')
    @php
        $customerInitial = mb_strtoupper(
            mb_substr($khachHang->ho_ten ?: 'K', 0, 1)
        );

        $totalTours = (int) ($tongSoTour ?? 0);
        $totalSpent = (float) ($tongChiTieu ?? 0);
        $totalCheckIns = (int) ($soLanCheckIn ?? 0);

        if ($totalTours <= 1) {
            $customerStatus = [
                'label' => 'Khách mới',
                'class' => 'customer-new',
                'icon' => 'fa-user-plus',
            ];
        } elseif ($totalTours <= 3) {
            $customerStatus = [
                'label' => 'Đang hoạt động',
                'class' => 'customer-active',
                'icon' => 'fa-circle-check',
            ];
        } else {
            $customerStatus = [
                'label' => 'Khách thân thiết',
                'class' => 'customer-vip',
                'icon' => 'fa-crown',
            ];
        }

        $genderLabel = match ($khachHang->gioi_tinh) {
            'nam', 'male' => 'Nam',
            'nu', 'female' => 'Nữ',
            'khac', 'other' => 'Khác',
            default => $khachHang->gioi_tinh ?: 'Chưa cập nhật',
        };

        $documentTypeLabel = match ($khachHang->loai_giay_to) {
            'cccd' => 'Căn cước công dân',
            'cmnd' => 'Chứng minh nhân dân',
            'passport', 'ho_chieu' => 'Hộ chiếu',
            default => $khachHang->loai_giay_to ?: 'Chưa cập nhật',
        };
    @endphp

    <style>
        :root {
            --customer-primary: #315be8;
            --customer-primary-dark: #244bd2;
            --customer-primary-light: #edf4ff;
            --customer-purple: #5b4dea;
            --customer-cyan: #16c7e8;

            --customer-text-dark: #172b4d;
            --customer-text-main: #344563;
            --customer-text-muted: #6b7895;
            --customer-text-light: #98a2b3;

            --customer-border: #dce6f5;
            --customer-border-light: #e8eef8;

            --customer-white: #ffffff;
            --customer-soft-bg: #f6f9ff;

            --customer-success: #149963;
            --customer-success-light: #eaf9f1;

            --customer-warning: #c98212;
            --customer-warning-light: #fff7e8;

            --customer-danger: #dc4c64;
            --customer-danger-light: #fff0f3;
        }

        .customer-detail-page {
            max-width: 1180px;
            margin: 0 auto;
            padding: 24px 0;
            color: var(--customer-text-dark);
        }

        /* Tiêu đề trang */
        .customer-page-top {
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .customer-page-heading h2 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .customer-page-heading p {
            margin: 6px 0 0;
            color: var(--customer-text-muted);
            font-size: 14px;
        }

        .customer-page-actions {
            display: flex;
            align-items: center;
            gap: 9px;
            flex-wrap: wrap;
        }

        .btn-page-action {
            min-height: 40px;
            padding: 8px 15px;
            border: 1px solid transparent;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.18s ease;
        }

        .btn-page-action:hover {
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-edit-customer {
            color: var(--customer-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #594bea
            );
            border-color: #315be8;
            box-shadow: 0 5px 14px rgba(49, 91, 232, 0.23);
        }

        .btn-edit-customer:hover {
            color: var(--customer-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #4d40d8
            );
            border-color: #264ed4;
            box-shadow: 0 7px 17px rgba(49, 91, 232, 0.3);
        }

        .btn-back-customer {
            color: #53698f;
            background: #f2f6fc;
            border-color: #d4dfef;
        }

        .btn-back-customer:hover {
            color: #304d83;
            background: #e7eef9;
            border-color: #bdcce3;
            box-shadow: 0 5px 13px rgba(41, 73, 132, 0.1);
        }

        /* Card hồ sơ */
        .customer-profile-card {
            position: relative;
            margin-bottom: 18px;
            overflow: hidden;
            background: var(--customer-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 10px 32px rgba(28, 65, 139, 0.11);
        }

        .customer-profile-card::before {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 5;
            height: 4px;
            content: "";
            background: linear-gradient(
                90deg,
                #2458e7,
                #3478ef,
                #18c7e7,
                #5947e9
            );
        }

        .customer-profile-header {
            position: relative;
            min-height: 190px;
            padding: 30px;
            overflow: hidden;
            color: var(--customer-white);
            background: linear-gradient(
                120deg,
                #2856df 0%,
                #316cec 55%,
                #5b49e8 100%
            );
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
        }

        .customer-profile-header::before {
            position: absolute;
            right: -65px;
            bottom: -145px;
            width: 310px;
            height: 310px;
            content: "";
            border: 25px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .customer-profile-header::after {
            position: absolute;
            top: -115px;
            right: 140px;
            width: 220px;
            height: 220px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .customer-profile-main {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .customer-avatar {
            width: 88px;
            height: 88px;
            flex-shrink: 0;
            color: var(--customer-white);
            background: rgba(255, 255, 255, 0.17);
            border: 1px solid rgba(255, 255, 255, 0.32);
            border-radius: 22px;
            box-shadow: 0 10px 25px rgba(20, 43, 128, 0.23);
            font-size: 32px;
            font-weight: 800;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .customer-profile-info {
            min-width: 0;
        }

        .customer-profile-info h3 {
            margin: 0;
            overflow: hidden;
            color: var(--customer-white);
            font-size: 27px;
            font-weight: 800;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .profile-contact {
            margin-top: 8px;
            color: rgba(255, 255, 255, 0.84);
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .profile-contact span {
            max-width: 420px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .customer-status {
            margin-top: 13px;
            padding: 7px 12px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 999px;
            font-size: 11px;
            font-weight: 750;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .customer-status.customer-new {
            color: #f2f5fb;
            background: rgba(95, 107, 133, 0.34);
        }

        .customer-status.customer-active {
            color: #eafff5;
            background: rgba(18, 163, 99, 0.34);
        }

        .customer-status.customer-vip {
            color: #fff8e7;
            background: rgba(219, 145, 28, 0.34);
        }

        .customer-profile-id {
            position: relative;
            z-index: 2;
            min-width: 112px;
            padding: 14px 16px;
            color: var(--customer-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 12px;
            text-align: center;
            backdrop-filter: blur(5px);
        }

        .customer-profile-id strong {
            display: block;
            font-size: 21px;
            line-height: 1;
        }

        .customer-profile-id span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.84;
        }

        /* Thống kê */
        .customer-stats-grid {
            padding: 20px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .customer-stat-card {
            min-height: 95px;
            padding: 16px;
            background: #f8faff;
            border: 1px solid var(--customer-border);
            border-radius: 11px;
            display: flex;
            align-items: center;
            gap: 13px;
            transition:
                background-color 0.18s ease,
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.18s ease;
        }

        .customer-stat-card:hover {
            background: var(--customer-white);
            border-color: #c4d7f6;
            box-shadow: 0 7px 18px rgba(38, 76, 148, 0.08);
            transform: translateY(-1px);
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            color: #315be8;
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 11px;
            font-size: 15px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .stat-content {
            min-width: 0;
        }

        .stat-label {
            margin-bottom: 4px;
            color: #7c899f;
            font-size: 11px;
            font-weight: 650;
        }

        .stat-value {
            overflow: hidden;
            color: #24417d;
            font-size: 21px;
            font-weight: 800;
            line-height: 1.25;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .stat-money .stat-value {
            font-size: 18px;
        }

        /* Lưới nội dung */
        .customer-content-grid {
            margin-bottom: 18px;
            display: grid;
            grid-template-columns: minmax(0, 1fr) 310px;
            gap: 18px;
        }

        .customer-info-card,
        .customer-summary-card,
        .customer-history-card {
            overflow: hidden;
            background: var(--customer-white);
            border: 1px solid #d8e4f6;
            border-radius: 13px;
            box-shadow: 0 7px 24px rgba(28, 65, 139, 0.08);
        }

        .card-header-custom {
            min-height: 57px;
            padding: 15px 18px;
            color: #24417d;
            background: #f1f6ff;
            border-bottom: 1px solid var(--customer-border);
            font-size: 14px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-header-custom i {
            color: #426ce0;
        }

        /* Thông tin cá nhân */
        .customer-info-body {
            padding: 18px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .customer-info-item {
            min-height: 82px;
            padding: 14px;
            background: #f8faff;
            border: 1px solid var(--customer-border);
            border-radius: 10px;
            display: flex;
            align-items: flex-start;
            gap: 11px;
        }

        .info-icon {
            width: 35px;
            height: 35px;
            flex-shrink: 0;
            color: #315be8;
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 9px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .info-content {
            min-width: 0;
            flex: 1;
        }

        .info-content span {
            display: block;
            margin-bottom: 4px;
            color: #7b879f;
            font-size: 10px;
            font-weight: 650;
        }

        .info-content strong {
            display: block;
            overflow-wrap: anywhere;
            color: #40537a;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.6;
            white-space: pre-line;
        }

        .empty-value {
            color: var(--customer-text-light) !important;
            font-style: italic;
            font-weight: 500 !important;
        }

        /* Card tóm tắt */
        .customer-summary-body {
            padding: 22px 18px;
            text-align: center;
        }

        .summary-avatar {
            width: 82px;
            height: 82px;
            margin: 0 auto 14px;
            color: var(--customer-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #5b4dea
            );
            border-radius: 21px;
            box-shadow: 0 8px 20px rgba(49, 91, 232, 0.22);
            font-size: 30px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .summary-name {
            overflow: hidden;
            color: #24417d;
            font-size: 16px;
            font-weight: 800;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .summary-email {
            margin-top: 5px;
            overflow: hidden;
            color: #77849c;
            font-size: 11px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .summary-status {
            margin-top: 14px;
            padding: 6px 11px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .summary-status.customer-new {
            color: #66738b;
            background: #f1f4f8;
            border-color: #dce2ea;
        }

        .summary-status.customer-active {
            color: #08754a;
            background: var(--customer-success-light);
            border-color: #c5ead8;
        }

        .summary-status.customer-vip {
            color: #ae6c0d;
            background: var(--customer-warning-light);
            border-color: #f1dba9;
        }

        .summary-meta {
            margin-top: 20px;
            padding-top: 17px;
            border-top: 1px solid var(--customer-border-light);
            text-align: left;
        }

        .summary-meta-item {
            padding: 9px 0;
            color: #62718d;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .summary-meta-item + .summary-meta-item {
            border-top: 1px solid var(--customer-border-light);
        }

        .summary-meta-item strong {
            color: #344563;
            font-size: 11px;
        }

        /* Lịch sử đặt tour */
        .customer-history-card {
            margin-bottom: 0;
        }

        .history-summary {
            margin-left: auto;
            padding: 4px 9px;
            color: #3158ce;
            background: #ffffff;
            border: 1px solid #ccdcf7;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
        }

        .history-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .history-table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .history-table-wrapper::-webkit-scrollbar-track {
            background: #f2f5fa;
        }

        .history-table-wrapper::-webkit-scrollbar-thumb {
            background: #c5d2e5;
            border-radius: 999px;
        }

        .history-table {
            width: 100%;
            min-width: 1120px;
            margin: 0;
            border-collapse: collapse;
        }

        .history-table thead th {
            padding: 14px;
            color: #24417d;
            background: #f8faff;
            border-bottom: 1px solid #d8e5f8;
            font-size: 10px;
            font-weight: 750;
            letter-spacing: 0.025em;
            text-align: left;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .history-table tbody td {
            padding: 13px 14px;
            color: #53627f;
            border-bottom: 1px solid var(--customer-border-light);
            font-size: 12px;
            line-height: 1.5;
            vertical-align: middle;
        }

        .history-table tbody tr:last-child td {
            border-bottom: none;
        }

        .history-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .history-table tbody tr:hover {
            background: #f3f7ff;
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .booking-code {
            color: #3158ce;
            font-family: Consolas, Monaco, monospace;
            font-size: 11px;
            font-weight: 750;
            white-space: nowrap;
        }

        .tour-name {
            max-width: 210px;
            overflow: hidden;
            color: #29457d;
            font-size: 12px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .history-date {
            color: #536584;
            white-space: nowrap;
        }

        .money-value {
            color: #24417d;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        /* Badge bảng */
        .table-badge {
            padding: 5px 9px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 700;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .table-badge i {
            font-size: 8px;
        }

        .badge-success {
            color: #08754a;
            background: var(--customer-success-light);
            border-color: #c5ead8;
        }

        .badge-warning {
            color: #ae6c0d;
            background: var(--customer-warning-light);
            border-color: #f1dba9;
        }

        .badge-danger {
            color: #c13d55;
            background: var(--customer-danger-light);
            border-color: #f0c9d1;
        }

        .badge-info {
            color: #2855ce;
            background: var(--customer-primary-light);
            border-color: #c9dcff;
        }

        .badge-neutral {
            color: #66738b;
            background: #f1f4f8;
            border-color: #dce2ea;
        }

        /* Không có lịch sử */
        .empty-history {
            padding: 50px 20px !important;
            color: #8793aa !important;
            text-align: center;
        }

        .empty-history-icon {
            width: 50px;
            height: 50px;
            margin: 0 auto 12px;
            color: #3664dd;
            background: #edf3ff;
            border: 1px solid #d3e1ff;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-history-icon i {
            font-size: 19px;
        }

        .empty-history-title {
            color: #506181;
            font-size: 14px;
            font-weight: 700;
        }

        .empty-history-text {
            margin-top: 4px;
            font-size: 12px;
        }

        /* Nút cuối trang */
        .customer-footer-actions {
            margin-top: 22px;
            padding-top: 20px;
            border-top: 1px solid var(--customer-border-light);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-footer-action {
            min-width: 130px;
            min-height: 42px;
            padding: 9px 18px;
            border: 1px solid transparent;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.18s ease;
        }

        .btn-footer-action:hover {
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-footer-back {
            color: #53698f;
            background: #f2f6fc;
            border-color: #d4dfef;
        }

        .btn-footer-back:hover {
            color: #304d83;
            background: #e7eef9;
            border-color: #bdcce3;
        }

        .btn-footer-edit {
            color: var(--customer-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #594bea
            );
            border-color: #315be8;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.24);
        }

        .btn-footer-edit:hover {
            color: var(--customer-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #4d40d8
            );
            box-shadow: 0 8px 19px rgba(49, 91, 232, 0.3);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .customer-profile-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .customer-stats-grid {
                grid-template-columns: 1fr;
            }

            .customer-content-grid {
                grid-template-columns: 1fr;
            }

            .customer-summary-card {
                order: -1;
            }
        }

        @media (max-width: 768px) {
            .customer-detail-page {
                padding: 15px 0;
            }

            .customer-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .customer-page-actions {
                width: 100%;
            }

            .btn-page-action {
                flex: 1;
            }

            .customer-profile-card,
            .customer-info-card,
            .customer-summary-card,
            .customer-history-card {
                border-radius: 11px;
            }

            .customer-profile-header {
                min-height: auto;
                padding: 24px 20px;
            }

            .customer-avatar {
                width: 68px;
                height: 68px;
                border-radius: 17px;
                font-size: 26px;
            }

            .customer-profile-info h3 {
                font-size: 22px;
            }

            .customer-stats-grid {
                padding: 16px;
            }

            .customer-info-body {
                grid-template-columns: 1fr;
            }

            .customer-footer-actions {
                align-items: stretch;
                flex-direction: column-reverse;
            }

            .btn-footer-action {
                width: 100%;
            }
        }

        @media (max-width: 520px) {
            .customer-page-heading h2 {
                font-size: 20px;
            }

            .customer-page-actions {
                flex-direction: column;
            }

            .btn-page-action {
                width: 100%;
            }

            .customer-profile-main {
                align-items: flex-start;
            }

            .customer-profile-id {
                min-width: 100px;
                padding: 11px 13px;
            }

            .profile-contact span {
                max-width: 220px;
            }
        }
    </style>

    <div class="container-fluid customer-detail-page">
        <div class="customer-page-top">
            <div class="customer-page-heading">
                <h2>Chi tiết khách hàng</h2>

                <p>
                    Xem thông tin hồ sơ, thống kê và lịch sử đặt tour.
                </p>
            </div>

            <div class="customer-page-actions">
                <a
                    href="{{ route('Admin.khach-hang.edit', $khachHang->id) }}"
                    class="btn-page-action btn-edit-customer"
                >
                    <i class="fas fa-pen"></i>
                    Chỉnh sửa
                </a>

                <a
                    href="{{ route('Admin.khach-hang.index') }}"
                    class="btn-page-action btn-back-customer"
                >
                    <i class="fas fa-arrow-left"></i>
                    Quay lại
                </a>
            </div>
        </div>

        <div class="customer-profile-card">
            <div class="customer-profile-header">
                <div class="customer-profile-main">
                    <span class="customer-avatar">
                        {{ $customerInitial }}
                    </span>

                    <div class="customer-profile-info">
                        <h3>{{ $khachHang->ho_ten }}</h3>

                        <div class="profile-contact">
                            <i class="fas fa-envelope"></i>

                            <span>
                                {{ $khachHang->email ?: 'Chưa cập nhật email' }}
                            </span>
                        </div>

                        <span class="customer-status {{ $customerStatus['class'] }}">
                            <i class="fas {{ $customerStatus['icon'] }}"></i>
                            {{ $customerStatus['label'] }}
                        </span>
                    </div>
                </div>

                <div class="customer-profile-id">
                    <strong>#{{ $khachHang->id }}</strong>
                    <span>Mã khách hàng</span>
                </div>
            </div>

            <div class="customer-stats-grid">
                <div class="customer-stat-card">
                    <span class="stat-icon">
                        <i class="fas fa-map-location-dot"></i>
                    </span>

                    <div class="stat-content">
                        <div class="stat-label">Tổng số tour</div>
                        <div class="stat-value">{{ $totalTours }}</div>
                    </div>
                </div>

                <div class="customer-stat-card stat-money">
                    <span class="stat-icon">
                        <i class="fas fa-wallet"></i>
                    </span>

                    <div class="stat-content">
                        <div class="stat-label">Tổng chi tiêu</div>

                        <div
                            class="stat-value"
                            title="{{ number_format($totalSpent, 0, ',', '.') }}đ"
                        >
                            {{ number_format($totalSpent, 0, ',', '.') }}đ
                        </div>
                    </div>
                </div>

                <div class="customer-stat-card">
                    <span class="stat-icon">
                        <i class="fas fa-location-check"></i>
                    </span>

                    <div class="stat-content">
                        <div class="stat-label">Số lần check-in</div>
                        <div class="stat-value">{{ $totalCheckIns }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="customer-content-grid">
            <div class="customer-info-card">
                <div class="card-header-custom">
                    <i class="fas fa-address-card"></i>
                    Thông tin khách hàng
                </div>

                <div class="customer-info-body">
                    <div class="customer-info-item">
                        <span class="info-icon">
                            <i class="fas fa-user"></i>
                        </span>

                        <div class="info-content">
                            <span>Họ và tên</span>

                            <strong>
                                {{ $khachHang->ho_ten }}
                            </strong>
                        </div>
                    </div>

                    <div class="customer-info-item">
                        <span class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </span>

                        <div class="info-content">
                            <span>Email</span>

                            <strong class="{{ $khachHang->email ? '' : 'empty-value' }}">
                                {{ $khachHang->email ?: 'Chưa cập nhật' }}
                            </strong>
                        </div>
                    </div>

                    <div class="customer-info-item">
                        <span class="info-icon">
                            <i class="fas fa-phone"></i>
                        </span>

                        <div class="info-content">
                            <span>Số điện thoại</span>

                            <strong class="{{ $khachHang->so_dien_thoai ? '' : 'empty-value' }}">
                                {{ $khachHang->so_dien_thoai ?: 'Chưa cập nhật' }}
                            </strong>
                        </div>
                    </div>

                    <div class="customer-info-item">
                        <span class="info-icon">
                            <i class="fas fa-venus-mars"></i>
                        </span>

                        <div class="info-content">
                            <span>Giới tính</span>
                            <strong>{{ $genderLabel }}</strong>
                        </div>
                    </div>

                    <div class="customer-info-item">
                        <span class="info-icon">
                            <i class="fas fa-cake-candles"></i>
                        </span>

                        <div class="info-content">
                            <span>Năm sinh</span>

                            <strong class="{{ $khachHang->nam_sinh ? '' : 'empty-value' }}">
                                {{ $khachHang->nam_sinh ?: 'Chưa cập nhật' }}
                            </strong>
                        </div>
                    </div>

                    <div class="customer-info-item">
                        <span class="info-icon">
                            <i class="fas fa-id-card"></i>
                        </span>

                        <div class="info-content">
                            <span>Giấy tờ tùy thân</span>

                            <strong>
                                {{ $documentTypeLabel }}

                                @if ($khachHang->so_giay_to)
                                    <br>
                                    {{ $khachHang->so_giay_to }}
                                @endif
                            </strong>
                        </div>
                    </div>

                    <div class="customer-info-item">
                        <span class="info-icon">
                            <i class="fas fa-circle-exclamation"></i>
                        </span>

                        <div class="info-content">
                            <span>Yêu cầu đặc biệt</span>

                            <strong class="{{ $khachHang->yeu_cau_dac_biet ? '' : 'empty-value' }}">
                                {{ $khachHang->yeu_cau_dac_biet ?: 'Không có yêu cầu đặc biệt' }}
                            </strong>
                        </div>
                    </div>

                    <div class="customer-info-item">
                        <span class="info-icon">
                            <i class="fas fa-note-sticky"></i>
                        </span>

                        <div class="info-content">
                            <span>Ghi chú</span>

                            <strong class="{{ $khachHang->ghi_chu ? '' : 'empty-value' }}">
                                {{ $khachHang->ghi_chu ?: 'Chưa có ghi chú' }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="customer-summary-card">
                <div class="card-header-custom">
                    <i class="fas fa-user-tag"></i>
                    Hồ sơ tóm tắt
                </div>

                <div class="customer-summary-body">
                    <div class="summary-avatar">
                        {{ $customerInitial }}
                    </div>

                    <div
                        class="summary-name"
                        title="{{ $khachHang->ho_ten }}"
                    >
                        {{ $khachHang->ho_ten }}
                    </div>

                    <div
                        class="summary-email"
                        title="{{ $khachHang->email }}"
                    >
                        {{ $khachHang->email ?: 'Chưa cập nhật email' }}
                    </div>

                    <span class="summary-status {{ $customerStatus['class'] }}">
                        <i class="fas {{ $customerStatus['icon'] }}"></i>
                        {{ $customerStatus['label'] }}
                    </span>

                    <div class="summary-meta">
                        <div class="summary-meta-item">
                            <span>Tổng số tour</span>
                            <strong>{{ $totalTours }}</strong>
                        </div>

                        <div class="summary-meta-item">
                            <span>Số lần check-in</span>
                            <strong>{{ $totalCheckIns }}</strong>
                        </div>

                        <div class="summary-meta-item">
                            <span>Tổng chi tiêu</span>

                            <strong>
                                {{ number_format($totalSpent, 0, ',', '.') }}đ
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="customer-history-card">
            <div class="card-header-custom">
                <i class="fas fa-clock-rotate-left"></i>
                Lịch sử đặt tour

                <span class="history-summary">
                    {{ $lichSuDatTours->count() }} bản ghi
                </span>
            </div>

            <div class="history-table-wrapper">
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>Mã đặt tour</th>
                            <th>Tour</th>
                            <th>Ngày khởi hành</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Thanh toán</th>
                            <th>Check-in</th>
                            <th>Trạng thái tour</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($lichSuDatTours as $item)
                            @php
                                $paymentStatus = strtolower(
                                    (string) ($item->trang_thai_thanh_toan ?? '')
                                );

                                $paymentConfig = match ($paymentStatus) {
                                    'da_thanh_toan',
                                    'đã thanh toán',
                                    'paid',
                                    'completed' => [
                                        'label' => 'Đã thanh toán',
                                        'class' => 'badge-success',
                                        'icon' => 'fa-circle-check',
                                    ],

                                    'thanh_toan_mot_phan',
                                    'thanh toán một phần',
                                    'partial' => [
                                        'label' => 'Thanh toán một phần',
                                        'class' => 'badge-warning',
                                        'icon' => 'fa-circle-half-stroke',
                                    ],

                                    'that_bai',
                                    'thất bại',
                                    'failed' => [
                                        'label' => 'Thanh toán thất bại',
                                        'class' => 'badge-danger',
                                        'icon' => 'fa-circle-xmark',
                                    ],

                                    default => [
                                        'label' => $item->trang_thai_thanh_toan
                                            ? \Illuminate\Support\Str::headline(
                                                $item->trang_thai_thanh_toan
                                            )
                                            : 'Chưa thanh toán',
                                        'class' => 'badge-neutral',
                                        'icon' => 'fa-clock',
                                    ],
                                };

                                $tourStatus = strtolower(
                                    (string) ($item->datTour?->trang_thai ?? '')
                                );

                                $tourStatusConfig = match ($tourStatus) {
                                    'da_xac_nhan',
                                    'đã xác nhận',
                                    'confirmed' => [
                                        'label' => 'Đã xác nhận',
                                        'class' => 'badge-info',
                                    ],

                                    'hoan_thanh',
                                    'hoàn thành',
                                    'completed' => [
                                        'label' => 'Hoàn thành',
                                        'class' => 'badge-success',
                                    ],

                                    'da_huy',
                                    'đã hủy',
                                    'cancelled',
                                    'canceled' => [
                                        'label' => 'Đã hủy',
                                        'class' => 'badge-danger',
                                    ],

                                    'cho_xac_nhan',
                                    'chờ xác nhận',
                                    'pending' => [
                                        'label' => 'Chờ xác nhận',
                                        'class' => 'badge-warning',
                                    ],

                                    default => [
                                        'label' => $item->datTour?->trang_thai
                                            ? \Illuminate\Support\Str::headline(
                                                $item->datTour->trang_thai
                                            )
                                            : 'Không xác định',
                                        'class' => 'badge-neutral',
                                    ],
                                };

                                $departureDate =
                                    $item->datTour?->lichKhoiHanh?->ngay_khoi_hanh;

                                $bookingDate =
                                    $item->datTour?->ngay_dat
                                    ?? $item->created_at;
                            @endphp

                            <tr>
                                <td>
                                    <span class="booking-code">
                                        {{ $item->datTour?->ma_dat_tour ?: '---' }}
                                    </span>
                                </td>

                                <td>
                                    <div
                                        class="tour-name"
                                        title="{{ $item->datTour?->tour?->ten_tour }}"
                                    >
                                        {{ $item->datTour?->tour?->ten_tour ?: 'Không xác định' }}
                                    </div>
                                </td>

                                <td>
                                    <span class="history-date">
                                        {{ $departureDate
                                            ? \Carbon\Carbon::parse($departureDate)->format('d/m/Y')
                                            : '---'
                                        }}
                                    </span>
                                </td>

                                <td>
                                    <span class="history-date">
                                        {{ $bookingDate
                                            ? \Carbon\Carbon::parse($bookingDate)->format('d/m/Y')
                                            : '---'
                                        }}
                                    </span>
                                </td>

                                <td>
                                    <span class="money-value">
                                        {{ number_format(
                                            (float) ($item->tong_tien ?? 0),
                                            0,
                                            ',',
                                            '.'
                                        ) }}đ
                                    </span>
                                </td>

                                <td>
                                    <span class="table-badge {{ $paymentConfig['class'] }}">
                                        <i class="fas {{ $paymentConfig['icon'] }}"></i>
                                        {{ $paymentConfig['label'] }}
                                    </span>
                                </td>

                                <td>
                                    @if ($item->da_check_in)
                                        <span class="table-badge badge-success">
                                            <i class="fas fa-location-check"></i>
                                            Đã check-in
                                        </span>
                                    @else
                                        <span class="table-badge badge-neutral">
                                            <i class="fas fa-location-dot"></i>
                                            Chưa check-in
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span class="table-badge {{ $tourStatusConfig['class'] }}">
                                        {{ $tourStatusConfig['label'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty-history">
                                    <div class="empty-history-icon">
                                        <i class="fas fa-calendar-xmark"></i>
                                    </div>

                                    <div class="empty-history-title">
                                        Chưa có lịch sử đặt tour
                                    </div>

                                    <div class="empty-history-text">
                                        Khách hàng chưa phát sinh đơn đặt tour nào.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="customer-footer-actions">
            <a
                href="{{ route('Admin.khach-hang.index') }}"
                class="btn-footer-action btn-footer-back"
            >
                <i class="fas fa-arrow-left"></i>
                Quay lại
            </a>

            <a
                href="{{ route('Admin.khach-hang.edit', $khachHang->id) }}"
                class="btn-footer-action btn-footer-edit"
            >
                <i class="fas fa-pen-to-square"></i>
                Chỉnh sửa
            </a>
        </div>
    </div>
@endsection
