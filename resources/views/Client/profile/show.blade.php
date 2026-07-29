@extends('layouts.app')

@section('title', 'Hồ sơ cá nhân')

@section('content')
    <style>
        .profile-page {
            padding: 45px 0 60px;
            background: #f4f7fc;
        }

        .profile-card {
            overflow: hidden;
            background: #fff;
            border: 1px solid #e1e8f4;
            border-radius: 18px;
            box-shadow: 0 10px 32px rgba(34, 61, 119, 0.09);
        }

        .profile-cover {
            min-height: 170px;
            position: relative;
            padding: 30px;
            color: #fff;
            background:
                linear-gradient(115deg,
                    #075bea 0%,
                    #1688ef 62%,
                    #5841dc 100%);
        }

        .profile-cover::before,
        .profile-cover::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .profile-cover::before {
            width: 210px;
            height: 210px;
            top: -115px;
            right: 80px;
        }

        .profile-cover::after {
            width: 145px;
            height: 145px;
            right: -45px;
            bottom: -65px;
        }

        .profile-cover h3 {
            position: relative;
            z-index: 1;
            font-weight: 800;
        }

        .profile-cover p {
            position: relative;
            z-index: 1;
            color: rgba(255, 255, 255, 0.82);
        }

        .profile-main {
            padding: 0 30px 30px;
        }

        .profile-avatar-wrapper {
            position: relative;
            margin-top: -67px;
            margin-bottom: 20px;
            z-index: 3;
        }

        .profile-avatar {
            width: 135px;
            height: 135px;
            object-fit: cover;
            border: 6px solid #fff;
            border-radius: 50%;
            background: #edf2ff;
            box-shadow: 0 8px 22px rgba(34, 61, 119, 0.18);
        }

        .profile-avatar-default {
            width: 135px;
            height: 135px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #315be8;
            background: #edf2ff;
            border: 6px solid #fff;
            border-radius: 50%;
            box-shadow: 0 8px 22px rgba(34, 61, 119, 0.18);
            font-size: 46px;
        }

        .profile-name {
            color: #173b77;
            font-size: 25px;
            font-weight: 800;
        }

        .profile-email {
            color: #71809c;
        }

        .profile-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 11px;
            color: #087956;
            background: #e9f8f2;
            border: 1px solid #c1e9d8;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .profile-info-card {
            height: 100%;
            padding: 20px;
            background: #fbfcff;
            border: 1px solid #e0e7f4;
            border-radius: 13px;
        }

        .profile-info-label {
            color: #7a89a5;
            margin-bottom: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .profile-info-value {
            color: #243e69;
            font-size: 14px;
            font-weight: 700;
            word-break: break-word;
        }

        .profile-action {
            min-height: 42px;
            padding: 9px 16px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
        }
    </style>

    <section class="profile-page">
        <div class="container">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-circle-check me-2"></i>
                    {{ session('success') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                    </button>
                </div>
            @endif

            <div class="profile-card">

                <div class="profile-cover">
                    <h3>Hồ sơ cá nhân</h3>

                    <p class="mb-0">
                        Quản lý thông tin tài khoản và bảo mật của bạn.
                    </p>
                </div>

                <div class="profile-main">

                    <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">

                        <div>
                            <div class="profile-avatar-wrapper">

                                @if ($user->avatar)
                                    <img src="{{ Storage::disk('public')->url($user->avatar) }}" alt="{{ $user->name }}"
                                        class="profile-avatar"
                                        onerror="this.style.display='none'; document.getElementById('defaultAvatar').style.display='flex';">

                                    <div id="defaultAvatar" class="profile-avatar-default" style="display: none;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @else
                                    <div class="profile-avatar-default">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif

                            </div>

                            <h2 class="profile-name mb-1">
                                {{ $user->name }}
                            </h2>

                            <div class="profile-email mb-2">
                                <i class="fas fa-envelope me-1"></i>
                                {{ $user->email }}
                            </div>

                            @if ((int) $user->is_active === 1)
                                <span class="profile-status">
                                    <i class="fas fa-circle-check"></i>
                                    Tài khoản đang hoạt động
                                </span>
                            @endif
                        </div>

                        <div class="d-flex gap-2 flex-wrap">

                            <a href="{{ route('client.profile.edit') }}" class="btn btn-primary profile-action">

                                <i class="fas fa-pen-to-square me-1"></i>
                                Chỉnh sửa hồ sơ

                            </a>

                            <a href="{{ route('client.profile.password.edit') }}"
                                class="btn btn-outline-primary profile-action">

                                <i class="fas fa-key me-1"></i>
                                Đổi mật khẩu

                            </a>

                        </div>

                    </div>

                    <hr class="my-4">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="profile-info-card">

                                <div class="profile-info-label">
                                    <i class="fas fa-user me-1"></i>
                                    Họ và tên
                                </div>

                                <div class="profile-info-value">
                                    {{ $user->name ?: 'Chưa cập nhật' }}
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="profile-info-card">

                                <div class="profile-info-label">
                                    <i class="fas fa-envelope me-1"></i>
                                    Địa chỉ email
                                </div>

                                <div class="profile-info-value">
                                    {{ $user->email }}
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="profile-info-card">

                                <div class="profile-info-label">
                                    <i class="fas fa-phone me-1"></i>
                                    Số điện thoại
                                </div>

                                <div class="profile-info-value">
                                    {{ $user->phone ?: 'Chưa cập nhật' }}
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="profile-info-card">

                                <div class="profile-info-label">
                                    <i class="fas fa-location-dot me-1"></i>
                                    Địa chỉ
                                </div>

                                <div class="profile-info-value">
                                    {{ $user->address ?: 'Chưa cập nhật' }}
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="profile-info-card">

                                <div class="profile-info-label">
                                    <i class="fas fa-calendar-plus me-1"></i>
                                    Ngày tham gia
                                </div>

                                <div class="profile-info-value">
                                    {{ optional($user->created_at)->format('d/m/Y') }}
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="profile-info-card">

                                <div class="profile-info-label">
                                    <i class="fas fa-shield-halved me-1"></i>
                                    Trạng thái
                                </div>

                                <div class="profile-info-value">
                                    {{ (int) $user->is_active === 1 ? 'Đang hoạt động' : 'Đã bị khóa' }}
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>
@endsection
