@extends('layouts.admin')

@section('content')
    @php
        $currentUser = auth()->user();

        $moduleNames = [
            'users' => 'Người dùng',
            'roles' => 'Vai trò',
            'permissions' => 'Quyền hạn',
            'tours' => 'Tour',
            'bookings' => 'Đặt tour',
            'guides' => 'Hướng dẫn viên',
            'banners' => 'Banner',
            'danh_mucs' => 'Danh mục',
            'phuong_tiens' => 'Phương tiện',
            'phan_cong' => 'Phân công',
            'lich_khoi_hanh' => 'Lịch khởi hành',
            'gop_doan' => 'Gộp đoàn',
            'payments' => 'Thanh toán',
            'reports' => 'Báo cáo',
            'customers' => 'Khách hàng',
            'lich_trinh_tours' => 'Lịch trình tour',
            'chi_tiet_lich_trinhs' => 'Chi tiết lịch trình',
            'nhat_ky_tours' => 'Nhật ký tour',
            'reviews' => 'Đánh giá',
            'terms' => 'Điều khoản',
            'favorites' => 'Tour yêu thích',
            'system' => 'Hệ thống',
        ];

        $moduleIcons = [
            'users' => 'fa-user',
            'roles' => 'fa-user-tag',
            'permissions' => 'fa-key',
            'tours' => 'fa-map-location-dot',
            'bookings' => 'fa-calendar-check',
            'guides' => 'fa-users',
            'banners' => 'fa-image',
            'danh_mucs' => 'fa-tags',
            'phuong_tiens' => 'fa-bus',
            'phan_cong' => 'fa-user-group',
            'lich_khoi_hanh' => 'fa-plane-departure',
            'gop_doan' => 'fa-object-group',
            'payments' => 'fa-credit-card',
            'reports' => 'fa-chart-column',
            'customers' => 'fa-user-check',
            'lich_trinh_tours' => 'fa-calendar-days',
            'chi_tiet_lich_trinhs' => 'fa-list',
            'nhat_ky_tours' => 'fa-book',
            'reviews' => 'fa-star',
            'terms' => 'fa-file-contract',
            'favorites' => 'fa-heart',
            'system' => 'fa-gear',
        ];
    @endphp

    <style>
        :root {
            --primary: #315be8;
            --primary-dark: #244bd2;
            --primary-light: #edf4ff;
            --primary-border: #c9dcff;

            --purple: #5b4dea;
            --cyan: #16c7e8;

            --text-dark: #172b4d;
            --text-main: #344563;
            --text-muted: #6b7895;
            --text-light: #98a2b3;

            --border: #dce6f5;
            --border-light: #e8eef8;

            --white: #ffffff;
            --soft-bg: #f6f9ff;
        }

        .role-detail-page {
            padding: 24px 0;
            color: var(--text-dark);
        }

        /* Tiêu đề phía trên */
        .detail-page-top {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .page-heading h3 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .page-heading p {
            margin: 6px 0 0;
            color: var(--text-muted);
            font-size: 14px;
        }

        .btn-back-top {
            min-height: 39px;
            padding: 8px 14px;
            color: #2c57d1;
            background: var(--primary-light);
            border: 1px solid #cbdcff;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 650;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.18s ease;
        }

        .btn-back-top:hover {
            color: #1f46bd;
            background: #dfeaff;
            border-color: #a9c5ff;
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(49, 91, 232, 0.12);
        }

        /* Card */
        .role-detail-card {
            position: relative;
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            overflow: hidden;
            background: var(--white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 10px 32px rgba(28, 65, 139, 0.11);
        }

        .role-detail-card::before {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 3;
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

        /* Header */
        .detail-header {
            position: relative;
            min-height: 150px;
            padding: 30px;
            overflow: hidden;
            color: var(--white);
            background: linear-gradient(
                120deg,
                #2856df 0%,
                #316cec 55%,
                #5b49e8 100%
            );
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .detail-header::before {
            position: absolute;
            right: -55px;
            bottom: -105px;
            width: 250px;
            height: 250px;
            content: "";
            border: 22px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .detail-header::after {
            position: absolute;
            top: -90px;
            right: 110px;
            width: 180px;
            height: 180px;
            content: "";
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.045);
        }

        .detail-header-content {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .detail-header-icon {
            width: 56px;
            height: 56px;
            flex-shrink: 0;
            color: var(--white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 15px;
            box-shadow: 0 7px 18px rgba(20, 43, 128, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .detail-header-icon i {
            font-size: 22px;
        }

        .detail-header h3 {
            margin: 0;
            color: var(--white);
            font-size: 24px;
            font-weight: 750;
        }

        .detail-header p {
            margin: 7px 0 0;
            color: rgba(255, 255, 255, 0.84);
            font-size: 13px;
            line-height: 1.5;
        }

        .header-permission-count {
            position: relative;
            z-index: 2;
            min-width: 115px;
            padding: 13px 16px;
            color: var(--white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.26);
            border-radius: 12px;
            text-align: center;
            backdrop-filter: blur(5px);
        }

        .header-permission-count strong {
            display: block;
            font-size: 23px;
            line-height: 1;
        }

        .header-permission-count span {
            display: block;
            margin-top: 5px;
            font-size: 11px;
            opacity: 0.84;
        }

        /* Body */
        .detail-body {
            padding: 30px;
            background: var(--white);
        }

        .detail-section {
            margin-bottom: 30px;
        }

        .detail-section:last-of-type {
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

        /* Thông tin vai trò */
        .role-info-list {
            margin: 0;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 11px;
        }

        .role-info-row {
            min-height: 68px;
            border-bottom: 1px solid var(--border-light);
            display: grid;
            grid-template-columns: 210px minmax(0, 1fr);
        }

        .role-info-row:last-child {
            border-bottom: none;
        }

        .role-info-label {
            margin: 0;
            padding: 18px 20px;
            color: #29457d;
            background: #f3f7ff;
            border-right: 1px solid var(--border);
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .role-info-label i {
            width: 18px;
            color: #426ce0;
            text-align: center;
        }

        .role-info-value {
            margin: 0;
            min-width: 0;
            padding: 18px 20px;
            color: #5d6c87;
            font-size: 14px;
            line-height: 1.6;
            display: flex;
            align-items: center;
        }

        .role-name-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #24417d;
            font-size: 15px;
            font-weight: 750;
        }

        .role-name-icon {
            width: 31px;
            height: 31px;
            color: #315be8;
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 8px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .role-description {
            color: #65738e;
            white-space: pre-line;
        }

        .empty-value {
            color: var(--text-light);
            font-size: 13px;
            font-style: italic;
        }

        /* Danh sách quyền */
        .permissions-summary {
            margin-bottom: 15px;
            padding: 13px 15px;
            color: #48608f;
            background: #f1f6ff;
            border: 1px solid #d5e2f7;
            border-radius: 9px;
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .permissions-summary i {
            color: #315be8;
        }

        .permissions-summary strong {
            color: #24417d;
        }

        .permissions-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .permission-module {
            overflow: hidden;
            background: #ffffff;
            border: 1px solid var(--border);
            border-radius: 11px;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.18s ease;
        }

        .permission-module:hover {
            border-color: #c3d6f6;
            box-shadow: 0 7px 18px rgba(38, 76, 148, 0.08);
            transform: translateY(-1px);
        }

        .module-header {
            min-height: 52px;
            padding: 11px 14px;
            background: linear-gradient(
                135deg,
                #f1f6ff,
                #edf3ff
            );
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .module-heading {
            min-width: 0;
            color: #29457d;
            font-size: 12px;
            font-weight: 750;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .module-icon {
            width: 29px;
            height: 29px;
            flex-shrink: 0;
            color: #315be8;
            background: #ffffff;
            border: 1px solid #cfddf7;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .module-icon i {
            font-size: 11px;
        }

        .module-count {
            padding: 4px 9px;
            color: #526c9d;
            background: rgba(255, 255, 255, 0.85);
            border: 1px solid #d4e0f2;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .module-permission-list {
            padding: 8px;
        }

        .permission-item {
            min-height: 46px;
            padding: 8px 10px;
            border: 1px solid transparent;
            border-radius: 8px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            transition:
                background-color 0.16s ease,
                border-color 0.16s ease;
        }

        .permission-item:hover {
            background: #f3f7ff;
            border-color: #dbe6f8;
        }

        .permission-check-icon {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
            margin-top: 1px;
            color: #315be8;
            background: #eaf2ff;
            border: 1px solid #cfe0ff;
            border-radius: 7px;
            font-size: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .permission-content {
            min-width: 0;
            flex: 1;
        }

        .permission-name {
            overflow: hidden;
            color: #344563;
            font-size: 12px;
            font-weight: 700;
            line-height: 1.4;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .permission-code {
            margin-top: 3px;
            overflow: hidden;
            color: #77849c;
            font-family: Consolas, Monaco, monospace;
            font-size: 10px;
            line-height: 1.4;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        /* Không có quyền */
        .empty-permissions {
            padding: 44px 20px;
            color: #8793aa;
            background: #f8faff;
            border: 1px dashed #cddbf1;
            border-radius: 11px;
            text-align: center;
        }

        .empty-permissions-icon {
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

        .empty-permissions-icon i {
            font-size: 19px;
        }

        .empty-permissions-title {
            color: #506181;
            font-size: 14px;
            font-weight: 700;
        }

        .empty-permissions p {
            margin: 5px 0 0;
            font-size: 12px;
        }

        /* Nút cuối */
        .detail-actions {
            margin-top: 30px;
            padding-top: 23px;
            border-top: 1px solid var(--border-light);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-detail {
            min-width: 130px;
            min-height: 42px;
            padding: 9px 18px;
            border: 1px solid transparent;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.18s ease;
        }

        .btn-detail:hover {
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-edit-role {
            color: var(--white);
            background: linear-gradient(
                135deg,
                #315be8 0%,
                #3b6dee 55%,
                #594bea 100%
            );
            border-color: #315be8;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.24);
        }

        .btn-edit-role:hover {
            color: var(--white);
            background: linear-gradient(
                135deg,
                #264ed4 0%,
                #315edc 55%,
                #4d40d8 100%
            );
            border-color: #264ed4;
            box-shadow: 0 8px 19px rgba(49, 91, 232, 0.3);
        }

        .btn-back {
            color: #53698f;
            background: #f2f6fc;
            border-color: #d4dfef;
        }

        .btn-back:hover {
            color: #304d83;
            background: #e7eef9;
            border-color: #bdcce3;
            box-shadow: 0 5px 13px rgba(41, 73, 132, 0.1);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .permissions-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .role-detail-page {
                padding: 15px 0;
            }

            .detail-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-back-top {
                width: 100%;
            }

            .role-detail-card {
                border-radius: 11px;
            }

            .detail-header {
                min-height: 130px;
                padding: 23px 20px;
                align-items: flex-start;
                flex-direction: column;
            }

            .detail-header h3 {
                font-size: 21px;
            }

            .header-permission-count {
                min-width: 100px;
                padding: 10px 14px;
            }

            .detail-body {
                padding: 22px 18px;
            }

            .role-info-row {
                grid-template-columns: 1fr;
            }

            .role-info-label {
                padding: 12px 15px;
                border-right: none;
                border-bottom: 1px solid var(--border);
            }

            .role-info-value {
                min-height: 52px;
                padding: 14px 15px;
            }

            .detail-actions {
                align-items: stretch;
                flex-direction: column-reverse;
            }

            .btn-detail {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .page-heading h3 {
                font-size: 20px;
            }

            .detail-header-content {
                align-items: flex-start;
            }

            .detail-header-icon {
                width: 47px;
                height: 47px;
            }

            .detail-header p {
                font-size: 12px;
            }

            .module-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <div class="container-fluid role-detail-page">
        <div class="detail-page-top">
            <div class="page-heading">
                <h3>Chi tiết vai trò</h3>

                <p>
                    Xem thông tin và danh sách quyền của vai trò.
                </p>
            </div>

            <a
                href="{{ route('Admin.vai-tros.index') }}"
                class="btn-back-top"
            >
                <i class="fas fa-arrow-left"></i>
                Quay lại danh sách
            </a>
        </div>

        <div class="card role-detail-card">
            <div class="detail-header">
                <div class="detail-header-content">
                    <span class="detail-header-icon">
                        <i class="fas fa-user-shield"></i>
                    </span>

                    <div>
                        <h3>{{ $vaiTro->ten_vai_tro }}</h3>

                        <p>
                            Thông tin chi tiết và phạm vi quyền hạn của vai trò
                            trong hệ thống.
                        </p>
                    </div>
                </div>

                <div class="header-permission-count">
                    <strong>{{ $vaiTro->quyenHans->count() }}</strong>
                    <span>Quyền được cấp</span>
                </div>
            </div>

            <div class="detail-body">
                <div class="detail-section">
                    <div class="section-title">
                        Thông tin vai trò
                    </div>

                    <dl class="role-info-list">
                        <div class="role-info-row">
                            <dt class="role-info-label">
                                <i class="fas fa-user-tag"></i>
                                Tên vai trò
                            </dt>

                            <dd class="role-info-value">
                                <span class="role-name-badge">
                                    <span class="role-name-icon">
                                        <i class="fas fa-shield-halved"></i>
                                    </span>

                                    {{ $vaiTro->ten_vai_tro }}
                                </span>
                            </dd>
                        </div>

                        <div class="role-info-row">
                            <dt class="role-info-label">
                                <i class="fas fa-align-left"></i>
                                Mô tả
                            </dt>

                            <dd class="role-info-value">
                                @if ($vaiTro->mo_ta)
                                    <span class="role-description">
                                        {{ $vaiTro->mo_ta }}
                                    </span>
                                @else
                                    <span class="empty-value">
                                        Chưa có mô tả cho vai trò này
                                    </span>
                                @endif
                            </dd>
                        </div>

                        <div class="role-info-row">
                            <dt class="role-info-label">
                                <i class="fas fa-key"></i>
                                Tổng quyền
                            </dt>

                            <dd class="role-info-value">
                                <strong style="color: #315be8;">
                                    {{ $vaiTro->quyenHans->count() }} quyền
                                </strong>
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="detail-section">
                    <div class="section-title">
                        Danh sách quyền hạn
                    </div>

                    @if ($vaiTro->quyenHans->isEmpty())
                        <div class="empty-permissions">
                            <div class="empty-permissions-icon">
                                <i class="fas fa-lock"></i>
                            </div>

                            <div class="empty-permissions-title">
                                Vai trò chưa được cấp quyền
                            </div>

                            <p>
                                Bạn có thể chỉnh sửa vai trò để thêm các quyền
                                truy cập phù hợp.
                            </p>
                        </div>
                    @else
                        <div class="permissions-summary">
                            <i class="fas fa-circle-info"></i>

                            <span>
                                Vai trò này đang có
                                <strong>{{ $vaiTro->quyenHans->count() }}</strong>
                                quyền thuộc
                                <strong>
                                    {{ $vaiTro->quyenHans->groupBy('mo_dun')->count() }}
                                </strong>
                                mô đun.
                            </span>
                        </div>

                        <div class="permissions-grid">
                            @foreach ($vaiTro->quyenHans->groupBy('mo_dun') as $module => $permissions)
                                @php
                                    $moduleKey = $module ?: 'system';

                                    $moduleLabel =
                                        $moduleNames[$moduleKey]
                                        ?? ucfirst(
                                            str_replace('_', ' ', $moduleKey)
                                        );

                                    $moduleIcon =
                                        $moduleIcons[$moduleKey]
                                        ?? 'fa-folder';
                                @endphp

                                <div class="permission-module">
                                    <div class="module-header">
                                        <div class="module-heading">
                                            <span class="module-icon">
                                                <i class="fas {{ $moduleIcon }}"></i>
                                            </span>

                                            <span>{{ $moduleLabel }}</span>
                                        </div>

                                        <span class="module-count">
                                            {{ $permissions->count() }} quyền
                                        </span>
                                    </div>

                                    <div class="module-permission-list">
                                        @foreach ($permissions as $quyenHan)
                                            <div class="permission-item">
                                                <span class="permission-check-icon">
                                                    <i class="fas fa-check"></i>
                                                </span>

                                                <span class="permission-content">
                                                    <span class="permission-name">
                                                        {{ $quyenHan->ten_hien_thi }}
                                                    </span>

                                                    <span class="permission-code">
                                                        {{ $quyenHan->ten }}
                                                    </span>
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="detail-actions">
                    <a
                        href="{{ route('Admin.vai-tros.index') }}"
                        class="btn-detail btn-back"
                    >
                        <i class="fas fa-arrow-left"></i>
                        Quay lại
                    </a>

                    @if ($currentUser && $currentUser->hasPermission('roles.edit'))
                        <a
                            href="{{ route('Admin.vai-tros.edit', $vaiTro->id) }}"
                            class="btn-detail btn-edit-role"
                        >
                            <i class="fas fa-pen-to-square"></i>
                            Chỉnh sửa
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
