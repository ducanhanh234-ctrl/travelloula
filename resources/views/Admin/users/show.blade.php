@extends('layouts.admin')

@section('content')
    @php
        $currentUser = auth()->user();
        $userInitial = mb_strtoupper(mb_substr($user->name ?: 'U', 0, 1));
    @endphp

    <style>
        :root {
            --user-primary: #315be8;
            --user-primary-dark: #244bd2;
            --user-primary-light: #edf4ff;
            --user-purple: #5b4dea;
            --user-cyan: #16c7e8;

            --user-text-dark: #172b4d;
            --user-text-main: #344563;
            --user-text-muted: #6b7895;
            --user-text-light: #98a2b3;

            --user-border: #dce6f5;
            --user-border-light: #e8eef8;

            --user-white: #ffffff;
            --user-soft-bg: #f6f9ff;
        }

        .user-detail-page {
            padding: 24px 0;
            color: var(--user-text-dark);
        }

        /* Tiêu đề phía trên */
        .detail-page-top {
            width: 100%;
            max-width: 980px;
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
            color: var(--user-text-muted);
            font-size: 14px;
        }

        .btn-back-top {
            min-height: 39px;
            padding: 8px 14px;
            color: #2c57d1;
            background: var(--user-primary-light);
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

        /* Card chính */
        .user-detail-card {
            position: relative;
            width: 100%;
            max-width: 980px;
            margin: 0 auto;
            overflow: hidden;
            background: var(--user-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 10px 32px rgba(28, 65, 139, 0.11);
        }

        .user-detail-card::before {
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
        .user-detail-header {
            position: relative;
            min-height: 155px;
            padding: 30px;
            overflow: hidden;
            color: var(--user-white);
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

        .user-detail-header::before {
            position: absolute;
            right: -55px;
            bottom: -110px;
            width: 255px;
            height: 255px;
            content: "";
            border: 22px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .user-detail-header::after {
            position: absolute;
            top: -90px;
            right: 120px;
            width: 180px;
            height: 180px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .header-user-content {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-avatar-large {
            width: 62px;
            height: 62px;
            flex-shrink: 0;
            color: var(--user-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.32);
            border-radius: 17px;
            box-shadow: 0 8px 20px rgba(20, 43, 128, 0.2);
            font-size: 24px;
            font-weight: 800;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .header-user-info {
            min-width: 0;
        }

        .header-user-info h3 {
            margin: 0;
            overflow: hidden;
            color: var(--user-white);
            font-size: 24px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .header-user-info p {
            margin: 7px 0 0;
            overflow: hidden;
            color: rgba(255, 255, 255, 0.84);
            font-size: 13px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .header-user-info p i {
            margin-right: 6px;
        }

        .header-role-count {
            position: relative;
            z-index: 2;
            min-width: 112px;
            padding: 13px 16px;
            color: var(--user-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.26);
            border-radius: 12px;
            text-align: center;
            backdrop-filter: blur(5px);
        }

        .header-role-count strong {
            display: block;
            font-size: 23px;
            line-height: 1;
        }

        .header-role-count span {
            display: block;
            margin-top: 5px;
            font-size: 11px;
            opacity: 0.84;
        }

        /* Nội dung */
        .user-detail-body {
            padding: 30px;
            background: var(--user-white);
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

        /* Danh sách thông tin */
        .detail-list {
            margin: 0;
            overflow: hidden;
            background: var(--user-white);
            border: 1px solid var(--user-border);
            border-radius: 11px;
        }

        .detail-row {
            min-height: 68px;
            border-bottom: 1px solid var(--user-border-light);
            display: grid;
            grid-template-columns: 210px minmax(0, 1fr);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            margin: 0;
            padding: 18px 20px;
            color: #29457d;
            background: #f3f7ff;
            border-right: 1px solid var(--user-border);
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .detail-label i {
            width: 18px;
            color: #426ce0;
            font-size: 13px;
            text-align: center;
        }

        .detail-value {
            margin: 0;
            min-width: 0;
            padding: 18px 20px;
            color: #5d6c87;
            font-size: 14px;
            line-height: 1.6;
            word-break: break-word;
            display: flex;
            align-items: center;
        }

        .user-main-value {
            color: #233f7a;
            font-size: 15px;
            font-weight: 750;
        }

        .contact-value {
            color: #536584;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .contact-value i {
            color: #5b7bd6;
            font-size: 12px;
        }

        .address-value {
            color: #65738e;
            white-space: pre-line;
        }

        .empty-value {
            color: var(--user-text-light);
            font-size: 13px;
            font-style: italic;
        }

        /* Danh sách vai trò */
        .role-list {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
        }

        .role-badge {
            max-width: 190px;
            padding: 6px 11px;
            overflow: hidden;
            color: #2855ce;
            background: #eaf2ff;
            border: 1px solid #bed5ff;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .role-badge i {
            font-size: 9px;
        }

        .no-role {
            padding: 6px 11px;
            color: #8590a5;
            background: #f4f6f9;
            border: 1px solid #e2e7ef;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 650;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* Ngày giờ */
        .date-value {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .date-icon {
            width: 31px;
            height: 31px;
            flex-shrink: 0;
            color: #315be8;
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 8px;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .date-info {
            line-height: 1.4;
        }

        .date-main {
            color: #3e537a;
            font-size: 13px;
            font-weight: 700;
        }

        .date-relative {
            margin-top: 2px;
            color: #8894a9;
            font-size: 11px;
        }

        /* Nút hành động */
        .detail-actions {
            margin-top: 30px;
            padding-top: 23px;
            border-top: 1px solid var(--user-border-light);
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

        .btn-edit-user {
            color: var(--user-white);
            background: linear-gradient(
                135deg,
                #315be8 0%,
                #3b6dee 55%,
                #594bea 100%
            );
            border-color: #315be8;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.24);
        }

        .btn-edit-user:hover {
            color: var(--user-white);
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
        @media (max-width: 768px) {
            .user-detail-page {
                padding: 15px 0;
            }

            .detail-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-back-top {
                width: 100%;
            }

            .user-detail-card {
                border-radius: 11px;
            }

            .user-detail-header {
                min-height: 135px;
                padding: 23px 20px;
                align-items: flex-start;
                flex-direction: column;
            }

            .user-detail-body {
                padding: 22px 18px;
            }

            .detail-row {
                grid-template-columns: 1fr;
            }

            .detail-label {
                padding: 12px 15px;
                border-right: none;
                border-bottom: 1px solid var(--user-border);
            }

            .detail-value {
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

            .header-user-content {
                align-items: flex-start;
            }

            .user-avatar-large {
                width: 50px;
                height: 50px;
                border-radius: 13px;
                font-size: 20px;
            }

            .header-user-info h3 {
                font-size: 20px;
            }

            .header-user-info p {
                max-width: 230px;
                font-size: 12px;
            }

            .header-role-count {
                min-width: 100px;
                padding: 10px 13px;
            }
        }
    </style>

    <div class="container-fluid user-detail-page">
        <div class="detail-page-top">
            <div class="page-heading">
                <h3>Chi tiết người dùng</h3>

                <p>
                    Xem thông tin tài khoản và vai trò của người dùng.
                </p>
            </div>

            <a
                href="{{ route('Admin.users.index') }}"
                class="btn-back-top"
            >
                <i class="fas fa-arrow-left"></i>
                Quay lại danh sách
            </a>
        </div>

        <div class="card user-detail-card">
            <div class="user-detail-header">
                <div class="header-user-content">
                    <span class="user-avatar-large">
                        {{ $userInitial }}
                    </span>

                    <div class="header-user-info">
                        <h3>{{ $user->name }}</h3>

                        <p>
                            <i class="fas fa-envelope"></i>
                            {{ $user->email }}
                        </p>
                    </div>
                </div>

                <div class="header-role-count">
                    <strong>{{ $user->vaiTros->count() }}</strong>
                    <span>Vai trò</span>
                </div>
            </div>

            <div class="user-detail-body">
                <div class="detail-section">
                    <div class="section-title">
                        Thông tin tài khoản
                    </div>

                    <dl class="detail-list">
                        <div class="detail-row">
                            <dt class="detail-label">
                                <i class="fas fa-user"></i>
                                Họ và tên
                            </dt>

                            <dd class="detail-value">
                                <span class="user-main-value">
                                    {{ $user->name }}
                                </span>
                            </dd>
                        </div>

                        <div class="detail-row">
                            <dt class="detail-label">
                                <i class="fas fa-envelope"></i>
                                Email
                            </dt>

                            <dd class="detail-value">
                                <span class="contact-value">
                                    <i class="fas fa-at"></i>
                                    {{ $user->email }}
                                </span>
                            </dd>
                        </div>

                        <div class="detail-row">
                            <dt class="detail-label">
                                <i class="fas fa-phone"></i>
                                Điện thoại
                            </dt>

                            <dd class="detail-value">
                                @if ($user->phone)
                                    <span class="contact-value">
                                        <i class="fas fa-phone-volume"></i>
                                        {{ $user->phone }}
                                    </span>
                                @else
                                    <span class="empty-value">
                                        Chưa cập nhật số điện thoại
                                    </span>
                                @endif
                            </dd>
                        </div>

                        <div class="detail-row">
                            <dt class="detail-label">
                                <i class="fas fa-location-dot"></i>
                                Địa chỉ
                            </dt>

                            <dd class="detail-value">
                                @if ($user->address)
                                    <span class="address-value">
                                        {{ $user->address }}
                                    </span>
                                @else
                                    <span class="empty-value">
                                        Chưa cập nhật địa chỉ
                                    </span>
                                @endif
                            </dd>
                        </div>

                        <div class="detail-row">
                            <dt class="detail-label">
                                <i class="fas fa-user-shield"></i>
                                Vai trò
                            </dt>

                            <dd class="detail-value">
                                @if ($user->vaiTros->isEmpty())
                                    <span class="no-role">
                                        <i class="fas fa-user-lock"></i>
                                        Chưa có vai trò
                                    </span>
                                @else
                                    <div class="role-list">
                                        @foreach ($user->vaiTros as $vaiTro)
                                            <span
                                                class="role-badge"
                                                title="{{ $vaiTro->ten_vai_tro }}"
                                            >
                                                <i class="fas fa-user-tag"></i>
                                                {{ $vaiTro->ten_vai_tro }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="detail-section">
                    <div class="section-title">
                        Thông tin hệ thống
                    </div>

                    <dl class="detail-list">
                        <div class="detail-row">
                            <dt class="detail-label">
                                <i class="fas fa-calendar-plus"></i>
                                Ngày tạo
                            </dt>

                            <dd class="detail-value">
                                <div class="date-value">
                                    <span class="date-icon">
                                        <i class="fas fa-calendar-plus"></i>
                                    </span>

                                    <div class="date-info">
                                        <div class="date-main">
                                            {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'Không xác định' }}
                                        </div>

                                        @if ($user->created_at)
                                            <div class="date-relative">
                                                {{ $user->created_at->diffForHumans() }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </dd>
                        </div>

                        <div class="detail-row">
                            <dt class="detail-label">
                                <i class="fas fa-clock-rotate-left"></i>
                                Cập nhật gần nhất
                            </dt>

                            <dd class="detail-value">
                                <div class="date-value">
                                    <span class="date-icon">
                                        <i class="fas fa-rotate"></i>
                                    </span>

                                    <div class="date-info">
                                        <div class="date-main">
                                            {{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i') : 'Không xác định' }}
                                        </div>

                                        @if ($user->updated_at)
                                            <div class="date-relative">
                                                {{ $user->updated_at->diffForHumans() }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>

                <div class="detail-actions">
                    <a
                        href="{{ route('Admin.users.index') }}"
                        class="btn-detail btn-back"
                    >
                        <i class="fas fa-arrow-left"></i>
                        Quay lại
                    </a>

                    @if (
                        $currentUser
                        && $currentUser->hasPermission('users.edit')
                    )
                        <a
                            href="{{ route('Admin.users.edit', $user->id) }}"
                            class="btn-detail btn-edit-user"
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
