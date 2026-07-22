@extends('layouts.admin')

@section('title', 'Chi tiết hướng dẫn viên')

@section('content')
    @php
        $currentUser = auth()->user();

        $trangThaiMap = [
            'hoat_dong' => [
                'text' => 'Đang hoạt động',
                'class' => 'status-active',
                'avatar' => 'online',
                'icon' => 'fa-circle-check',
            ],
            'san_sang' => [
                'text' => 'Sẵn sàng',
                'class' => 'status-ready',
                'avatar' => 'online',
                'icon' => 'fa-circle-check',
            ],
            'dang_dan_tour' => [
                'text' => 'Đang dẫn tour',
                'class' => 'status-assigned',
                'avatar' => 'busy',
                'icon' => 'fa-route',
            ],
            'khong_hoat_dong' => [
                'text' => 'Tạm nghỉ',
                'class' => 'status-inactive',
                'avatar' => 'offline',
                'icon' => 'fa-circle-pause',
            ],
            'bi_khoa' => [
                'text' => 'Bị khóa',
                'class' => 'status-locked',
                'avatar' => 'offline',
                'icon' => 'fa-lock',
            ],
            'nghi_viec' => [
                'text' => 'Nghỉ việc',
                'class' => 'status-quit',
                'avatar' => 'offline',
                'icon' => 'fa-user-slash',
            ],
        ];

        $trangThai = $trangThaiMap[$huongDanVien->trang_thai] ?? [
            'text' => 'Không xác định',
            'class' => 'status-unknown',
            'avatar' => 'offline',
            'icon' => 'fa-circle-question',
        ];

        $gioiTinh = match ($huongDanVien->gioi_tinh) {
            'nam' => 'Nam',
            'nu' => 'Nữ',
            'khac' => 'Khác',
            default => 'Chưa cập nhật',
        };

        $guideInitial = mb_strtoupper(
            mb_substr($huongDanVien->ho_ten ?: 'H', 0, 1)
        );
    @endphp

    <style>
        :root {
            --guide-primary: #315be8;
            --guide-primary-dark: #244bd2;
            --guide-primary-light: #edf4ff;
            --guide-purple: #5b4dea;
            --guide-cyan: #16c7e8;

            --guide-text-dark: #172b4d;
            --guide-text-main: #344563;
            --guide-text-muted: #6b7895;
            --guide-text-light: #98a2b3;

            --guide-border: #dce6f5;
            --guide-border-light: #e8eef8;

            --guide-white: #ffffff;
            --guide-soft-bg: #f6f9ff;

            --guide-success: #149963;
            --guide-success-light: #eaf9f1;

            --guide-warning: #c77a12;
            --guide-warning-light: #fff7e8;

            --guide-danger: #d9475f;
            --guide-danger-light: #fff0f3;
        }

        .guide-detail-page {
            max-width: 1120px;
            margin: 0 auto;
            padding: 24px 0;
            color: var(--guide-text-dark);
        }

        /* Thanh tiêu đề */
        .guide-page-top {
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .guide-page-heading h2 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .guide-page-heading p {
            margin: 6px 0 0;
            color: var(--guide-text-muted);
            font-size: 14px;
        }

        .guide-page-actions {
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

        .btn-edit-guide {
            color: var(--guide-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #594bea
            );
            border-color: #315be8;
            box-shadow: 0 5px 14px rgba(49, 91, 232, 0.23);
        }

        .btn-edit-guide:hover {
            color: var(--guide-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #4d40d8
            );
            border-color: #264ed4;
            box-shadow: 0 7px 17px rgba(49, 91, 232, 0.3);
        }

        .btn-back-guide {
            color: #53698f;
            background: #f2f6fc;
            border-color: #d4dfef;
        }

        .btn-back-guide:hover {
            color: #304d83;
            background: #e7eef9;
            border-color: #bdcce3;
            box-shadow: 0 5px 13px rgba(41, 73, 132, 0.1);
        }

        /* Card chính */
        .guide-detail-card {
            position: relative;
            overflow: hidden;
            background: var(--guide-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 10px 32px rgba(28, 65, 139, 0.11);
        }

        .guide-detail-card::before {
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

        /* Header hồ sơ */
        .guide-profile-header {
            position: relative;
            min-height: 210px;
            padding: 30px;
            overflow: hidden;
            color: var(--guide-white);
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

        .guide-profile-header::before {
            position: absolute;
            right: -70px;
            bottom: -150px;
            width: 320px;
            height: 320px;
            content: "";
            border: 26px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .guide-profile-header::after {
            position: absolute;
            top: -125px;
            right: 140px;
            width: 230px;
            height: 230px;
            content: "";
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.045);
        }

        .guide-profile-main {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 22px;
        }

        /* Ảnh đại diện */
        .guide-avatar-wrap {
            position: relative;
            width: 120px;
            height: 120px;
            flex-shrink: 0;
        }

        .guide-avatar {
            width: 120px;
            height: 120px;
            padding: 4px;
            overflow: hidden;
            color: var(--guide-white);
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 24px;
            box-shadow: 0 12px 28px rgba(20, 43, 128, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .guide-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.85);
            border-radius: 20px;
            background: #ffffff;
        }

        .guide-avatar-placeholder {
            width: 100%;
            height: 100%;
            color: #315be8;
            background: #ffffff;
            border: 3px solid rgba(255, 255, 255, 0.85);
            border-radius: 20px;
            font-size: 41px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-status {
            position: absolute;
            right: -3px;
            bottom: -3px;
            width: 24px;
            height: 24px;
            border: 4px solid #ffffff;
            border-radius: 50%;
            box-shadow: 0 4px 9px rgba(16, 24, 40, 0.18);
        }

        .avatar-status.online {
            background: #20bd77;
        }

        .avatar-status.busy {
            background: #18c7e8;
        }

        .avatar-status.offline {
            background: #ef6578;
        }

        /* Thông tin trong header */
        .guide-main-info {
            min-width: 0;
        }

        .guide-main-info h3 {
            margin: 0;
            overflow: hidden;
            color: var(--guide-white);
            font-size: 28px;
            font-weight: 800;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .guide-position {
            margin-top: 8px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 13px;
            font-weight: 650;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .guide-email {
            margin: 8px 0 13px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .guide-email span {
            max-width: 400px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Trạng thái */
        .guide-status {
            padding: 7px 12px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 999px;
            font-size: 11px;
            font-weight: 750;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .guide-status.status-active,
        .guide-status.status-ready {
            color: #eafff5;
            background: rgba(18, 163, 99, 0.35);
        }

        .guide-status.status-assigned {
            color: #effbff;
            background: rgba(22, 199, 232, 0.28);
        }

        .guide-status.status-inactive {
            color: #fff8e7;
            background: rgba(211, 143, 37, 0.3);
        }

        .guide-status.status-locked {
            color: #fff0f3;
            background: rgba(220, 76, 100, 0.34);
        }

        .guide-status.status-quit,
        .guide-status.status-unknown {
            color: #f2f5fb;
            background: rgba(95, 107, 133, 0.34);
        }

        /* Thống kê header */
        .guide-header-summary {
            position: relative;
            z-index: 2;
            display: grid;
            grid-template-columns: repeat(2, minmax(95px, 1fr));
            gap: 10px;
        }

        .summary-box {
            min-width: 105px;
            padding: 14px 15px;
            color: var(--guide-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.24);
            border-radius: 12px;
            text-align: center;
            backdrop-filter: blur(5px);
        }

        .summary-box strong {
            display: block;
            font-size: 20px;
            line-height: 1;
        }

        .summary-box span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.84;
        }

        /* Nội dung */
        .guide-detail-body {
            padding: 30px;
        }

        .guide-section {
            margin-bottom: 30px;
        }

        .guide-section:last-child {
            margin-bottom: 0;
        }

        .section-title {
            margin-bottom: 18px;
            color: #24417d;
            font-size: 14px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title::before {
            width: 4px;
            height: 18px;
            content: "";
            border-radius: 999px;
            background: linear-gradient(
                180deg,
                #315be8,
                #5b4dea
            );
        }

        .section-title i {
            color: #426ce0;
        }

        /* Thông tin cá nhân */
        .guide-info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .guide-info-item {
            min-height: 78px;
            padding: 15px;
            background: #f8faff;
            border: 1px solid var(--guide-border);
            border-radius: 11px;
            display: flex;
            align-items: center;
            gap: 13px;
            transition:
                border-color 0.18s ease,
                background-color 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.18s ease;
        }

        .guide-info-item:hover {
            background: #ffffff;
            border-color: #c5d8f6;
            box-shadow: 0 6px 16px rgba(38, 76, 148, 0.07);
            transform: translateY(-1px);
        }

        .info-icon {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            color: #315be8;
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 10px;
            font-size: 14px;
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
            color: #7c899f;
            font-size: 11px;
            font-weight: 650;
        }

        .info-content strong {
            display: block;
            overflow-wrap: anywhere;
            color: #344563;
            font-size: 13px;
            font-weight: 750;
            line-height: 1.5;
        }

        .info-content .empty-value {
            color: var(--guide-text-light);
            font-style: italic;
            font-weight: 500;
        }

        /* CCCD */
        .identity-card {
            overflow: hidden;
            background: #f8faff;
            border: 1px solid var(--guide-border);
            border-radius: 12px;
        }

        .identity-info-grid {
            padding: 16px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .identity-info-item {
            min-height: 80px;
            padding: 14px;
            background: #ffffff;
            border: 1px solid #dce6f5;
            border-radius: 9px;
        }

        .identity-info-item span {
            display: block;
            margin-bottom: 6px;
            color: #7b879f;
            font-size: 11px;
            font-weight: 650;
        }

        .identity-info-item strong {
            display: block;
            overflow-wrap: anywhere;
            color: #344563;
            font-size: 13px;
            font-weight: 750;
            line-height: 1.5;
        }

        /* Ảnh CCCD */
        .identity-image-grid {
            padding: 0 16px 16px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .identity-image-box {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid #dce6f5;
            border-radius: 10px;
        }

        .identity-image-title {
            padding: 11px 13px;
            color: #29457d;
            background: #f1f6ff;
            border-bottom: 1px solid #dce6f5;
            font-size: 12px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .identity-image-title i {
            color: #426ce0;
        }

        .identity-image-content {
            padding: 12px;
        }

        .identity-image-content img {
            width: 100%;
            height: 235px;
            object-fit: contain;
            background: #f7f9fd;
            border: 1px solid #e2e8f2;
            border-radius: 8px;
            cursor: pointer;
            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease;
        }

        .identity-image-content img:hover {
            transform: scale(1.01);
            box-shadow: 0 7px 18px rgba(33, 62, 120, 0.11);
        }

        .identity-empty {
            width: 100%;
            height: 190px;
            color: #8995aa;
            background: #f5f7fb;
            border: 1px dashed #ccd7e8;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 650;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            gap: 8px;
        }

        .identity-empty i {
            color: #7790cd;
            font-size: 24px;
        }

        /* Mô tả */
        .description-box {
            padding: 18px;
            color: #5e6e8a;
            background: #f8faff;
            border: 1px solid var(--guide-border);
            border-radius: 11px;
            font-size: 13px;
            line-height: 1.8;
            white-space: pre-line;
        }

        .description-empty {
            color: var(--guide-text-light);
            font-style: italic;
        }

        /* Thời gian hệ thống */
        .system-info {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .system-info-item {
            padding: 15px;
            background: #f8faff;
            border: 1px solid var(--guide-border);
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .system-info-icon {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            color: #315be8;
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .system-info-content span {
            display: block;
            margin-bottom: 3px;
            color: #8190a9;
            font-size: 10px;
            font-weight: 650;
        }

        .system-info-content strong {
            display: block;
            color: #40537a;
            font-size: 12px;
            font-weight: 750;
        }

        .system-info-relative {
            margin-top: 2px;
            color: #929eb2;
            font-size: 10px;
        }

        /* Nút cuối trang */
        .guide-footer-actions {
            margin-top: 30px;
            padding-top: 22px;
            border-top: 1px solid var(--guide-border-light);
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
            color: var(--guide-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #594bea
            );
            border-color: #315be8;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.24);
        }

        .btn-footer-edit:hover {
            color: var(--guide-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #4d40d8
            );
            box-shadow: 0 8px 19px rgba(49, 91, 232, 0.3);
        }

        /* Modal xem ảnh */
        .image-preview-modal {
            position: fixed;
            inset: 0;
            z-index: 9999;
            padding: 25px;
            background: rgba(10, 20, 43, 0.82);
            backdrop-filter: blur(5px);
            display: none;
            align-items: center;
            justify-content: center;
        }

        .image-preview-modal.is-open {
            display: flex;
        }

        .image-preview-content {
            position: relative;
            width: 100%;
            max-width: 1000px;
            max-height: 92vh;
            padding: 15px;
            background: #ffffff;
            border-radius: 13px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.28);
        }

        .image-preview-content img {
            width: 100%;
            max-height: calc(92vh - 30px);
            object-fit: contain;
            border-radius: 8px;
        }

        .image-preview-close {
            position: absolute;
            top: -14px;
            right: -14px;
            width: 36px;
            height: 36px;
            padding: 0;
            color: #ffffff;
            background: #df5067;
            border: 3px solid #ffffff;
            border-radius: 50%;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.18);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .guide-profile-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .guide-header-summary {
                grid-template-columns: repeat(2, minmax(120px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .guide-detail-page {
                padding: 15px 0;
            }

            .guide-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .guide-page-actions {
                width: 100%;
            }

            .btn-page-action {
                flex: 1;
            }

            .guide-detail-card {
                border-radius: 11px;
            }

            .guide-profile-header {
                min-height: auto;
                padding: 24px 20px;
            }

            .guide-profile-main {
                align-items: flex-start;
            }

            .guide-avatar-wrap,
            .guide-avatar {
                width: 95px;
                height: 95px;
            }

            .guide-avatar-placeholder {
                font-size: 32px;
            }

            .guide-main-info h3 {
                font-size: 22px;
            }

            .guide-detail-body {
                padding: 22px 18px;
            }

            .guide-info-grid,
            .identity-info-grid,
            .identity-image-grid,
            .system-info {
                grid-template-columns: 1fr;
            }

            .identity-image-content img {
                height: auto;
                max-height: 320px;
            }

            .guide-footer-actions {
                align-items: stretch;
                flex-direction: column-reverse;
            }

            .btn-footer-action {
                width: 100%;
            }
        }

        @media (max-width: 520px) {
            .guide-page-heading h2 {
                font-size: 20px;
            }

            .guide-page-actions {
                flex-direction: column;
            }

            .btn-page-action {
                width: 100%;
            }

            .guide-profile-main {
                flex-direction: column;
            }

            .guide-avatar-wrap,
            .guide-avatar {
                width: 90px;
                height: 90px;
            }

            .guide-main-info h3 {
                white-space: normal;
            }

            .guide-email span {
                max-width: 250px;
            }

            .guide-header-summary {
                width: 100%;
                grid-template-columns: 1fr 1fr;
            }

            .summary-box {
                min-width: 0;
            }
        }
    </style>

    <div class="container-fluid guide-detail-page">
        <div class="guide-page-top">
            <div class="guide-page-heading">
                <h2>Chi tiết hướng dẫn viên</h2>

                <p>
                    Xem thông tin hồ sơ, giấy tờ và trạng thái hoạt động.
                </p>
            </div>

            <div class="guide-page-actions">
                @if (
                    $currentUser
                    && $currentUser->hasPermission('guides.edit')
                )
                    <a
                        href="{{ route('Admin.huong-dan-viens.edit', $huongDanVien->id) }}"
                        class="btn-page-action btn-edit-guide"
                    >
                        <i class="fas fa-pen"></i>
                        Chỉnh sửa
                    </a>
                @endif

                <a
                    href="{{ route('Admin.huong-dan-viens.index') }}"
                    class="btn-page-action btn-back-guide"
                >
                    <i class="fas fa-arrow-left"></i>
                    Quay lại
                </a>
            </div>
        </div>

        <div class="guide-detail-card">
            <div class="guide-profile-header">
                <div class="guide-profile-main">
                    <div class="guide-avatar-wrap">
                        <div class="guide-avatar">
                            @if ($huongDanVien->anh_dai_dien)
                                <img
                                    src="{{ asset('storage/' . $huongDanVien->anh_dai_dien) }}"
                                    alt="{{ $huongDanVien->ho_ten }}"
                                >
                            @else
                                <div class="guide-avatar-placeholder">
                                    {{ $guideInitial }}
                                </div>
                            @endif
                        </div>

                        <span
                            class="avatar-status {{ $trangThai['avatar'] }}"
                            title="{{ $trangThai['text'] }}"
                        ></span>
                    </div>

                    <div class="guide-main-info">
                        <h3>{{ $huongDanVien->ho_ten }}</h3>

                        <div class="guide-position">
                            <i class="fas fa-person-walking-luggage"></i>
                            Hướng dẫn viên du lịch
                        </div>

                        <div class="guide-email">
                            <i class="fas fa-envelope"></i>

                            <span>
                                {{ $huongDanVien->email ?: 'Chưa cập nhật email' }}
                            </span>
                        </div>

                        <span class="guide-status {{ $trangThai['class'] }}">
                            <i class="fas {{ $trangThai['icon'] }}"></i>
                            {{ $trangThai['text'] }}
                        </span>
                    </div>
                </div>

                <div class="guide-header-summary">
                    <div class="summary-box">
                        <strong>
                            {{ $huongDanVien->so_nam_kinh_nghiem ?? 0 }}
                        </strong>

                        <span>Năm kinh nghiệm</span>
                    </div>

                    <div class="summary-box">
                        <strong>#{{ $huongDanVien->id }}</strong>
                        <span>Mã hướng dẫn viên</span>
                    </div>
                </div>
            </div>

            <div class="guide-detail-body">
                <div class="guide-section">
                    <div class="section-title">
                        <i class="fas fa-address-card"></i>
                        Thông tin cá nhân
                    </div>

                    <div class="guide-info-grid">
                        <div class="guide-info-item">
                            <span class="info-icon">
                                <i class="fas fa-phone"></i>
                            </span>

                            <div class="info-content">
                                <span>Số điện thoại</span>

                                <strong class="{{ $huongDanVien->so_dien_thoai ? '' : 'empty-value' }}">
                                    {{ $huongDanVien->so_dien_thoai ?: 'Chưa cập nhật' }}
                                </strong>
                            </div>
                        </div>

                        <div class="guide-info-item">
                            <span class="info-icon">
                                <i class="fas fa-calendar-day"></i>
                            </span>

                            <div class="info-content">
                                <span>Ngày sinh</span>

                                <strong class="{{ $huongDanVien->ngay_sinh ? '' : 'empty-value' }}">
                                    {{ $huongDanVien->ngay_sinh
                                        ? $huongDanVien->ngay_sinh->format('d/m/Y')
                                        : 'Chưa cập nhật'
                                    }}
                                </strong>
                            </div>
                        </div>

                        <div class="guide-info-item">
                            <span class="info-icon">
                                <i class="fas fa-venus-mars"></i>
                            </span>

                            <div class="info-content">
                                <span>Giới tính</span>
                                <strong>{{ $gioiTinh }}</strong>
                            </div>
                        </div>

                        <div class="guide-info-item">
                            <span class="info-icon">
                                <i class="fas fa-location-dot"></i>
                            </span>

                            <div class="info-content">
                                <span>Địa chỉ</span>

                                <strong class="{{ $huongDanVien->dia_chi ? '' : 'empty-value' }}">
                                    {{ $huongDanVien->dia_chi ?: 'Chưa cập nhật' }}
                                </strong>
                            </div>
                        </div>

                        <div class="guide-info-item">
                            <span class="info-icon">
                                <i class="fas fa-briefcase"></i>
                            </span>

                            <div class="info-content">
                                <span>Kinh nghiệm</span>

                                <strong>
                                    {{ $huongDanVien->so_nam_kinh_nghiem ?? 0 }}
                                    năm
                                </strong>
                            </div>
                        </div>

                        <div class="guide-info-item">
                            <span class="info-icon">
                                <i class="fas fa-language"></i>
                            </span>

                            <div class="info-content">
                                <span>Ngôn ngữ thành thạo</span>

                                <strong class="{{ $huongDanVien->ngon_ngu_thanh_thao ? '' : 'empty-value' }}">
                                    {{ $huongDanVien->ngon_ngu_thanh_thao ?: 'Chưa cập nhật' }}
                                </strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="guide-section">
                    <div class="section-title">
                        <i class="fas fa-id-card"></i>
                        Thông tin CCCD/CMND
                    </div>

                    <div class="identity-card">
                        <div class="identity-info-grid">
                            <div class="identity-info-item">
                                <span>Số CCCD/CMND</span>

                                <strong>
                                    {{ $huongDanVien->so_cccd ?: 'Chưa cập nhật' }}
                                </strong>
                            </div>

                            <div class="identity-info-item">
                                <span>Ngày cấp CCCD</span>

                                <strong>
                                    {{ $huongDanVien->ngay_cap_cccd
                                        ? $huongDanVien->ngay_cap_cccd->format('d/m/Y')
                                        : 'Chưa cập nhật'
                                    }}
                                </strong>
                            </div>

                            <div class="identity-info-item">
                                <span>Nơi cấp CCCD</span>

                                <strong>
                                    {{ $huongDanVien->noi_cap_cccd ?: 'Chưa cập nhật' }}
                                </strong>
                            </div>
                        </div>

                        <div class="identity-image-grid">
                            <div class="identity-image-box">
                                <div class="identity-image-title">
                                    <i class="fas fa-address-card"></i>
                                    Ảnh CCCD mặt trước
                                </div>

                                <div class="identity-image-content">
                                    @if ($huongDanVien->anh_cccd_truoc)
                                        <img
                                            src="{{ asset('storage/' . $huongDanVien->anh_cccd_truoc) }}"
                                            alt="Ảnh CCCD mặt trước"
                                            class="previewable-image"
                                        >
                                    @else
                                        <div class="identity-empty">
                                            <i class="fas fa-image"></i>
                                            Chưa có ảnh mặt trước
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="identity-image-box">
                                <div class="identity-image-title">
                                    <i class="fas fa-address-card"></i>
                                    Ảnh CCCD mặt sau
                                </div>

                                <div class="identity-image-content">
                                    @if ($huongDanVien->anh_cccd_sau)
                                        <img
                                            src="{{ asset('storage/' . $huongDanVien->anh_cccd_sau) }}"
                                            alt="Ảnh CCCD mặt sau"
                                            class="previewable-image"
                                        >
                                    @else
                                        <div class="identity-empty">
                                            <i class="fas fa-image"></i>
                                            Chưa có ảnh mặt sau
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="guide-section">
                    <div class="section-title">
                        <i class="fas fa-align-left"></i>
                        Mô tả hướng dẫn viên
                    </div>

                    <div class="description-box">
                        @if ($huongDanVien->mo_ta)
                            {{ $huongDanVien->mo_ta }}
                        @else
                            <span class="description-empty">
                                Chưa có mô tả cho hướng dẫn viên này.
                            </span>
                        @endif
                    </div>
                </div>

                <div class="guide-section">
                    <div class="section-title">
                        <i class="fas fa-clock-rotate-left"></i>
                        Thông tin hệ thống
                    </div>

                    <div class="system-info">
                        <div class="system-info-item">
                            <span class="system-info-icon">
                                <i class="fas fa-calendar-plus"></i>
                            </span>

                            <div class="system-info-content">
                                <span>Ngày tạo hồ sơ</span>

                                <strong>
                                    {{ $huongDanVien->created_at
                                        ? $huongDanVien->created_at->format('d/m/Y H:i')
                                        : 'Không xác định'
                                    }}
                                </strong>

                                @if ($huongDanVien->created_at)
                                    <div class="system-info-relative">
                                        {{ $huongDanVien->created_at->diffForHumans() }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="system-info-item">
                            <span class="system-info-icon">
                                <i class="fas fa-rotate"></i>
                            </span>

                            <div class="system-info-content">
                                <span>Cập nhật gần nhất</span>

                                <strong>
                                    {{ $huongDanVien->updated_at
                                        ? $huongDanVien->updated_at->format('d/m/Y H:i')
                                        : 'Không xác định'
                                    }}
                                </strong>

                                @if ($huongDanVien->updated_at)
                                    <div class="system-info-relative">
                                        {{ $huongDanVien->updated_at->diffForHumans() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="guide-footer-actions">
                    <a
                        href="{{ route('Admin.huong-dan-viens.index') }}"
                        class="btn-footer-action btn-footer-back"
                    >
                        <i class="fas fa-arrow-left"></i>
                        Quay lại
                    </a>

                    @if (
                        $currentUser
                        && $currentUser->hasPermission('guides.edit')
                    )
                        <a
                            href="{{ route('Admin.huong-dan-viens.edit', $huongDanVien->id) }}"
                            class="btn-footer-action btn-footer-edit"
                        >
                            <i class="fas fa-pen-to-square"></i>
                            Chỉnh sửa
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div
        class="image-preview-modal"
        id="image_preview_modal"
        aria-hidden="true"
    >
        <div class="image-preview-content">
            <button
                type="button"
                class="image-preview-close"
                id="image_preview_close"
                aria-label="Đóng ảnh"
            >
                <i class="fas fa-xmark"></i>
            </button>

            <img
                src=""
                alt="Xem ảnh CCCD"
                id="image_preview_target"
            >
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal =
                document.getElementById('image_preview_modal');

            const targetImage =
                document.getElementById('image_preview_target');

            const closeButton =
                document.getElementById('image_preview_close');

            const previewImages = document.querySelectorAll(
                '.previewable-image'
            );

            function openPreview(imageSource, imageAlt) {
                if (!modal || !targetImage) {
                    return;
                }

                targetImage.src = imageSource;
                targetImage.alt = imageAlt || 'Xem ảnh';

                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');

                document.body.style.overflow = 'hidden';
            }

            function closePreview() {
                if (!modal || !targetImage) {
                    return;
                }

                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');

                targetImage.src = '';
                document.body.style.overflow = '';
            }

            previewImages.forEach(function (image) {
                image.addEventListener('click', function () {
                    openPreview(this.src, this.alt);
                });
            });

            if (closeButton) {
                closeButton.addEventListener(
                    'click',
                    closePreview
                );
            }

            if (modal) {
                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        closePreview();
                    }
                });
            }

            document.addEventListener('keydown', function (event) {
                if (
                    event.key === 'Escape'
                    && modal
                    && modal.classList.contains('is-open')
                ) {
                    closePreview();
                }
            });
        });
    </script>
@endsection
