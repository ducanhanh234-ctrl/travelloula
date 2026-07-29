@extends('layouts.app')

@section('title', 'Hồ sơ cá nhân')

@section('content')
    <style>
        :root {
            --profile-primary: #2563eb;
            --profile-primary-dark: #1d4ed8;
            --profile-secondary: #6d4aff;
            --profile-success: #10b981;
            --profile-danger: #ef476f;
            --profile-warning: #f59e0b;

            --profile-text: #17345f;
            --profile-text-soft: #60708e;
            --profile-muted: #8a99b2;

            --profile-border: #dce5f4;
            --profile-background: #f2f6fd;
            --profile-card: rgba(255, 255, 255, 0.95);
        }

        .vip-profile-page {
            min-height: calc(100vh - 100px);
            position: relative;
            overflow: hidden;
            padding: 55px 0 75px;
            background:
                radial-gradient(
                    circle at 7% 10%,
                    rgba(37, 99, 235, 0.13),
                    transparent 27%
                ),
                radial-gradient(
                    circle at 92% 85%,
                    rgba(109, 74, 255, 0.12),
                    transparent 28%
                ),
                linear-gradient(
                    135deg,
                    #f7faff 0%,
                    #eef4ff 45%,
                    #f8f7ff 100%
                );
        }

        .vip-profile-page::before,
        .vip-profile-page::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(1px);
        }

        .vip-profile-page::before {
            width: 350px;
            height: 350px;
            top: -210px;
            left: -145px;
            background: rgba(37, 99, 235, 0.08);
        }

        .vip-profile-page::after {
            width: 320px;
            height: 320px;
            right: -150px;
            bottom: -185px;
            background: rgba(109, 74, 255, 0.08);
        }

        .vip-profile-container {
            position: relative;
            z-index: 2;
        }

        /* =========================
           ALERT
        ========================= */
        .vip-alert {
            padding: 14px 17px;
            border: 0;
            border-radius: 13px;
            box-shadow: 0 8px 22px rgba(38, 72, 130, 0.08);
            font-size: 13px;
        }

        /* =========================
           CARD CHÍNH
        ========================= */
        .vip-profile-card {
            overflow: hidden;
            background: var(--profile-card);
            border: 1px solid rgba(216, 226, 242, 0.94);
            border-radius: 26px;
            box-shadow:
                0 28px 70px rgba(30, 63, 120, 0.14),
                0 5px 18px rgba(30, 63, 120, 0.05);
            backdrop-filter: blur(13px);
        }

        /* =========================
           COVER
        ========================= */
        .vip-profile-cover {
            min-height: 250px;
            position: relative;
            overflow: hidden;
            padding: 34px 38px;
            color: #fff;
            background:
                linear-gradient(
                    115deg,
                    #095bea 0%,
                    #1679ee 48%,
                    #6244e6 100%
                );
        }

        .vip-profile-cover::before,
        .vip-profile-cover::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .vip-profile-cover::before {
            width: 285px;
            height: 285px;
            top: -175px;
            right: 85px;
        }

        .vip-profile-cover::after {
            width: 190px;
            height: 190px;
            right: -58px;
            bottom: -100px;
        }

        .vip-cover-content {
            position: relative;
            z-index: 2;
        }

        .vip-cover-label {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 12px;
            margin-bottom: 16px;
            color: #fff;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 22px;
            font-size: 11px;
            font-weight: 700;
            backdrop-filter: blur(8px);
        }

        .vip-profile-cover h2 {
            color: #fff;
            margin-bottom: 8px;
            font-size: 30px;
            font-weight: 900;
            letter-spacing: -0.4px;
        }

        .vip-profile-cover p {
            max-width: 610px;
            color: rgba(255, 255, 255, 0.84);
            margin-bottom: 0;
            font-size: 14px;
            line-height: 1.65;
        }

        /* =========================
           BODY
        ========================= */
        .vip-profile-body {
            position: relative;
            padding: 0 34px 34px;
        }

        .vip-profile-summary {
            position: relative;
            margin-top: -72px;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 25px;
            flex-wrap: wrap;
            z-index: 4;
        }

        .vip-user-main {
            display: flex;
            align-items: flex-end;
            gap: 20px;
        }

        /* =========================
           AVATAR
        ========================= */
        .vip-avatar-wrap {
            position: relative;
            flex: 0 0 auto;
        }

        .vip-avatar,
        .vip-avatar-default {
            width: 148px;
            height: 148px;
            border: 7px solid #fff;
            border-radius: 50%;
            box-shadow:
                0 13px 32px rgba(28, 58, 115, 0.22),
                0 0 0 1px rgba(208, 220, 239, 0.9);
        }

        .vip-avatar {
            object-fit: cover;
            background: #eef3ff;
        }

        .vip-avatar-default {
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--profile-primary);
            background:
                linear-gradient(
                    145deg,
                    #eef4ff,
                    #f5f1ff
                );
            font-size: 52px;
        }

        .vip-avatar-status {
            width: 30px;
            height: 30px;
            position: absolute;
            right: 9px;
            bottom: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background: var(--profile-success);
            border: 4px solid #fff;
            border-radius: 50%;
            font-size: 9px;
            box-shadow: 0 5px 12px rgba(16, 185, 129, 0.25);
        }

        /* =========================
           THÔNG TIN NGƯỜI DÙNG
        ========================= */
        .vip-user-heading {
            padding-bottom: 8px;
        }

        .vip-user-name {
            color: var(--profile-text);
            margin-bottom: 5px;
            font-size: 27px;
            font-weight: 900;
            letter-spacing: -0.35px;
        }

        .vip-user-email {
            display: flex;
            align-items: center;
            gap: 7px;
            color: var(--profile-text-soft);
            margin-bottom: 10px;
            font-size: 13px;
        }

        .vip-user-status {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 12px;
            color: #087956;
            background: #e9f9f2;
            border: 1px solid #c3ead9;
            border-radius: 22px;
            font-size: 11px;
            font-weight: 800;
        }

        .vip-user-status.locked {
            color: #bd3b51;
            background: #fff0f2;
            border-color: #efcbd1;
        }

        /* =========================
           ACTION
        ========================= */
        .vip-profile-actions {
            display: flex;
            gap: 10px;
            padding-bottom: 9px;
            flex-wrap: wrap;
        }

        .vip-action-primary,
        .vip-action-outline {
            min-height: 44px;
            padding: 10px 17px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            border-radius: 11px;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            transition: all 0.22s ease;
        }

        .vip-action-primary {
            color: #fff;
            background:
                linear-gradient(
                    105deg,
                    #2563eb 0%,
                    #3478ec 58%,
                    #6747e6 100%
                );
            border: 0;
            box-shadow: 0 9px 22px rgba(37, 99, 235, 0.22);
        }

        .vip-action-primary:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 13px 28px rgba(37, 99, 235, 0.3);
        }

        .vip-action-outline {
            color: var(--profile-primary);
            background: #fff;
            border: 1px solid #cad8f3;
        }

        .vip-action-outline:hover {
            color: #fff;
            background: var(--profile-primary);
            border-color: var(--profile-primary);
            transform: translateY(-2px);
            box-shadow: 0 9px 20px rgba(37, 99, 235, 0.18);
        }

        /* =========================
           DIVIDER
        ========================= */
        .vip-profile-divider {
            height: 1px;
            margin: 28px 0;
            background:
                linear-gradient(
                    90deg,
                    transparent,
                    #dce5f3 14%,
                    #dce5f3 86%,
                    transparent
                );
        }

        /* =========================
           THỐNG KÊ NHANH
        ========================= */
        .vip-mini-stat {
            height: 100%;
            position: relative;
            overflow: hidden;
            padding: 18px;
            background: #fff;
            border: 1px solid var(--profile-border);
            border-radius: 15px;
            box-shadow: 0 5px 16px rgba(39, 71, 129, 0.05);
            transition: all 0.22s ease;
        }

        .vip-mini-stat:hover {
            transform: translateY(-3px);
            border-color: #c4d4f0;
            box-shadow: 0 11px 24px rgba(39, 71, 129, 0.1);
        }

        .vip-mini-stat::after {
            content: "";
            width: 72px;
            height: 72px;
            position: absolute;
            right: -29px;
            bottom: -32px;
            border-radius: 50%;
            background: #f2f6ff;
        }

        .vip-mini-stat-icon {
            width: 39px;
            height: 39px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 13px;
            color: var(--profile-primary);
            background: #edf3ff;
            border: 1px solid #d3dfff;
            border-radius: 10px;
            font-size: 15px;
        }

        .vip-mini-stat-value {
            position: relative;
            z-index: 2;
            color: var(--profile-text);
            margin-bottom: 4px;
            font-size: 15px;
            font-weight: 900;
        }

        .vip-mini-stat-label {
            position: relative;
            z-index: 2;
            color: var(--profile-muted);
            font-size: 10px;
            font-weight: 700;
        }

        /* =========================
           TIÊU ĐỀ SECTION
        ========================= */
        .vip-section-heading {
            margin-bottom: 17px;
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .vip-section-icon {
            width: 41px;
            height: 41px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--profile-primary);
            background: #edf3ff;
            border: 1px solid #d2deff;
            border-radius: 11px;
        }

        .vip-section-heading h4 {
            color: var(--profile-text);
            margin-bottom: 2px;
            font-size: 17px;
            font-weight: 900;
        }

        .vip-section-heading p {
            color: var(--profile-muted);
            margin-bottom: 0;
            font-size: 11px;
        }

        /* =========================
           THẺ THÔNG TIN
        ========================= */
        .vip-info-card {
            height: 100%;
            position: relative;
            overflow: hidden;
            padding: 19px;
            background:
                linear-gradient(
                    145deg,
                    #ffffff 0%,
                    #f9fbff 100%
                );
            border: 1px solid var(--profile-border);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(35, 67, 125, 0.045);
            transition: all 0.22s ease;
        }

        .vip-info-card:hover {
            transform: translateY(-3px);
            border-color: #bed0f0;
            box-shadow: 0 12px 25px rgba(35, 67, 125, 0.09);
        }

        .vip-info-top {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .vip-info-icon {
            width: 41px;
            height: 41px;
            flex: 0 0 41px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--profile-primary);
            background: #edf3ff;
            border: 1px solid #d2deff;
            border-radius: 11px;
            font-size: 15px;
        }

        .vip-info-card.phone .vip-info-icon {
            color: #0b8d69;
            background: #eaf9f3;
            border-color: #c5ebdc;
        }

        .vip-info-card.address .vip-info-icon {
            color: #cc7609;
            background: #fff7e6;
            border-color: #f0ddac;
        }

        .vip-info-card.calendar .vip-info-icon {
            color: #7c4ee5;
            background: #f2edff;
            border-color: #ded2fb;
        }

        .vip-info-card.status .vip-info-icon {
            color: #0c8c68;
            background: #eaf9f3;
            border-color: #c5ebdc;
        }

        .vip-info-label {
            color: var(--profile-muted);
            margin-bottom: 4px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.45px;
        }

        .vip-info-value {
            color: #263f68;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.5;
            word-break: break-word;
        }

        .vip-info-empty {
            color: #9ba8bc;
            font-style: italic;
            font-weight: 600;
        }

        /* =========================
           FOOTER HỒ SƠ
        ========================= */
        .vip-profile-footer {
            margin-top: 25px;
            padding: 17px 19px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            color: #6e7f9c;
            background: #f6f9ff;
            border: 1px solid #dce5f4;
            border-radius: 14px;
            font-size: 11px;
        }

        .vip-profile-footer span {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        /* =========================
           RESPONSIVE
        ========================= */
        @media (max-width: 991.98px) {
            .vip-profile-summary {
                align-items: flex-start;
            }

            .vip-profile-actions {
                width: 100%;
                padding-left: 168px;
            }
        }

        @media (max-width: 767.98px) {
            .vip-profile-page {
                padding: 30px 10px 45px;
            }

            .vip-profile-cover {
                min-height: 220px;
                padding: 27px 22px;
            }

            .vip-profile-cover h2 {
                font-size: 25px;
            }

            .vip-profile-body {
                padding: 0 20px 25px;
            }

            .vip-profile-summary {
                margin-top: -62px;
                align-items: center;
                flex-direction: column;
            }

            .vip-user-main {
                width: 100%;
                align-items: center;
                flex-direction: column;
                text-align: center;
            }

            .vip-avatar,
            .vip-avatar-default {
                width: 130px;
                height: 130px;
            }

            .vip-user-email {
                justify-content: center;
            }

            .vip-profile-actions {
                width: 100%;
                padding-left: 0;
                justify-content: center;
            }

            .vip-action-primary,
            .vip-action-outline {
                flex: 1;
            }

            .vip-profile-footer {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        @media (max-width: 479.98px) {
            .vip-profile-cover h2 {
                font-size: 22px;
            }

            .vip-user-name {
                font-size: 23px;
            }

            .vip-action-primary,
            .vip-action-outline {
                width: 100%;
                flex: auto;
            }
        }
    </style>

    <section class="vip-profile-page">
        <div class="container vip-profile-container">

            {{-- Thông báo --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show vip-alert">
                    <i class="fas fa-circle-check me-2"></i>

                    {{ session('success') }}

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>
                </div>
            @endif

            <div class="vip-profile-card">

                {{-- Cover --}}
                <div class="vip-profile-cover">

                    <div class="vip-cover-content">

                        <span class="vip-cover-label">
                            <i class="fas fa-crown"></i>
                            Trung tâm tài khoản
                        </span>

                        <h2>Hồ sơ cá nhân</h2>

                        <p>
                            Quản lý thông tin cá nhân, hình ảnh đại diện và bảo mật
                            tài khoản của bạn tại Travelloula.
                        </p>

                    </div>

                </div>

                <div class="vip-profile-body">

                    {{-- Thông tin tổng quan --}}
                    <div class="vip-profile-summary">

                        <div class="vip-user-main">

                            {{-- Avatar --}}
                            <div class="vip-avatar-wrap">

                                @php
                                    $avatarExists = $user->avatar
                                        && Storage::disk('public')->exists($user->avatar);
                                @endphp

                                @if ($avatarExists)

                                    <img src="{{ Storage::disk('public')->url($user->avatar) }}"
                                        alt="{{ $user->name }}"
                                        class="vip-avatar">

                                @else

                                    <div class="vip-avatar-default">
                                        <i class="fas fa-user"></i>
                                    </div>

                                @endif

                                @if ((int) $user->is_active === 1)
                                    <span class="vip-avatar-status"
                                        title="Đang hoạt động">

                                        <i class="fas fa-check"></i>

                                    </span>
                                @endif

                            </div>

                            {{-- Tên và email --}}
                            <div class="vip-user-heading">

                                <h1 class="vip-user-name">
                                    {{ $user->name }}
                                </h1>

                                <div class="vip-user-email">

                                    <i class="fas fa-envelope"></i>

                                    {{ $user->email }}

                                </div>

                                @if ((int) $user->is_active === 1)

                                    <span class="vip-user-status">

                                        <i class="fas fa-circle-check"></i>
                                        Tài khoản đang hoạt động

                                    </span>

                                @else

                                    <span class="vip-user-status locked">

                                        <i class="fas fa-lock"></i>
                                        Tài khoản đã bị khóa

                                    </span>

                                @endif

                            </div>

                        </div>

                        {{-- Nút chức năng --}}
                        <div class="vip-profile-actions">

                            <a href="{{ route('client.profile.edit') }}"
                                class="vip-action-primary">

                                <i class="fas fa-user-pen"></i>
                                Chỉnh sửa hồ sơ

                            </a>

                            <a href="{{ route('client.profile.password.edit') }}"
                                class="vip-action-outline">

                                <i class="fas fa-key"></i>
                                Đổi mật khẩu

                            </a>

                        </div>

                    </div>

                    <div class="vip-profile-divider"></div>

                    {{-- Thống kê nhanh --}}
                    <div class="row g-3 mb-4">

                        <div class="col-xl-3 col-md-6">

                            <div class="vip-mini-stat">

                                <div class="vip-mini-stat-icon">
                                    <i class="fas fa-user-check"></i>
                                </div>

                                <div class="vip-mini-stat-value">
                                    Hồ sơ cá nhân
                                </div>

                                <div class="vip-mini-stat-label">
                                    Thông tin tài khoản
                                </div>

                            </div>

                        </div>

                        <div class="col-xl-3 col-md-6">

                            <div class="vip-mini-stat">

                                <div class="vip-mini-stat-icon">
                                    <i class="fas fa-calendar-days"></i>
                                </div>

                                <div class="vip-mini-stat-value">
                                    {{ optional($user->created_at)->format('d/m/Y') }}
                                </div>

                                <div class="vip-mini-stat-label">
                                    Ngày tham gia
                                </div>

                            </div>

                        </div>

                        <div class="col-xl-3 col-md-6">

                            <div class="vip-mini-stat">

                                <div class="vip-mini-stat-icon">
                                    <i class="fas fa-shield-halved"></i>
                                </div>

                                <div class="vip-mini-stat-value">
                                    {{ (int) $user->is_active === 1
                                        ? 'An toàn'
                                        : 'Bị hạn chế' }}
                                </div>

                                <div class="vip-mini-stat-label">
                                    Trạng thái bảo mật
                                </div>

                            </div>

                        </div>

                        <div class="col-xl-3 col-md-6">

                            <div class="vip-mini-stat">

                                <div class="vip-mini-stat-icon">
                                    <i class="fas fa-camera"></i>
                                </div>

                                <div class="vip-mini-stat-value">
                                    {{ $avatarExists
                                        ? 'Đã cập nhật'
                                        : 'Chưa cập nhật' }}
                                </div>

                                <div class="vip-mini-stat-label">
                                    Ảnh đại diện
                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Tiêu đề thông tin --}}
                    <div class="vip-section-heading">

                        <div class="vip-section-icon">
                            <i class="fas fa-address-card"></i>
                        </div>

                        <div>
                            <h4>Thông tin tài khoản</h4>

                            <p>
                                Các thông tin đang được lưu trong hồ sơ của bạn.
                            </p>
                        </div>

                    </div>

                    {{-- Thông tin chi tiết --}}
                    <div class="row g-3">

                        <div class="col-lg-6">

                            <div class="vip-info-card">

                                <div class="vip-info-top">

                                    <div class="vip-info-icon">
                                        <i class="fas fa-user"></i>
                                    </div>

                                    <div>

                                        <div class="vip-info-label">
                                            Họ và tên
                                        </div>

                                        <div class="vip-info-value">
                                            {{ $user->name ?: 'Chưa cập nhật' }}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="vip-info-card">

                                <div class="vip-info-top">

                                    <div class="vip-info-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>

                                    <div>

                                        <div class="vip-info-label">
                                            Địa chỉ email
                                        </div>

                                        <div class="vip-info-value">
                                            {{ $user->email }}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="vip-info-card phone">

                                <div class="vip-info-top">

                                    <div class="vip-info-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>

                                    <div>

                                        <div class="vip-info-label">
                                            Số điện thoại
                                        </div>

                                        <div class="vip-info-value
                                            {{ !$user->phone ? 'vip-info-empty' : '' }}">

                                            {{ $user->phone ?: 'Chưa cập nhật' }}

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="vip-info-card address">

                                <div class="vip-info-top">

                                    <div class="vip-info-icon">
                                        <i class="fas fa-location-dot"></i>
                                    </div>

                                    <div>

                                        <div class="vip-info-label">
                                            Địa chỉ
                                        </div>

                                        <div class="vip-info-value
                                            {{ !$user->address ? 'vip-info-empty' : '' }}">

                                            {{ $user->address ?: 'Chưa cập nhật' }}

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="vip-info-card calendar">

                                <div class="vip-info-top">

                                    <div class="vip-info-icon">
                                        <i class="fas fa-calendar-plus"></i>
                                    </div>

                                    <div>

                                        <div class="vip-info-label">
                                            Ngày tham gia
                                        </div>

                                        <div class="vip-info-value">

                                            {{ optional($user->created_at)->format('d/m/Y H:i') }}

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="col-lg-6">

                            <div class="vip-info-card status">

                                <div class="vip-info-top">

                                    <div class="vip-info-icon">
                                        <i class="fas fa-shield-halved"></i>
                                    </div>

                                    <div>

                                        <div class="vip-info-label">
                                            Trạng thái tài khoản
                                        </div>

                                        <div class="vip-info-value">

                                            {{ (int) $user->is_active === 1
                                                ? 'Đang hoạt động'
                                                : 'Đã bị khóa' }}

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- Footer --}}
                    <div class="vip-profile-footer">

                        <span>
                            <i class="fas fa-lock text-primary"></i>
                            Thông tin tài khoản được bảo mật.
                        </span>

                        <span>
                            <i class="fas fa-clock-rotate-left text-primary"></i>
                            Cập nhật gần nhất:
                            {{ optional($user->updated_at)->format('d/m/Y H:i') }}
                        </span>

                    </div>

                </div>

            </div>

        </div>
    </section>
@endsection
