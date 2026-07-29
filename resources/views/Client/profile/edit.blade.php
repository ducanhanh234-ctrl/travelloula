@extends('layouts.app')

@section('title', 'Chỉnh sửa hồ sơ')

@section('content')
    <style>
        :root {
            --edit-primary: #2563eb;
            --edit-primary-dark: #1d4ed8;
            --edit-secondary: #6847e6;
            --edit-success: #0f9f72;
            --edit-danger: #df4560;

            --edit-text: #17345f;
            --edit-text-soft: #64748f;
            --edit-muted: #8b99af;

            --edit-border: #dbe4f2;
            --edit-background: #f3f7fd;
            --edit-white: #ffffff;
        }

        .edit-profile-page {
            min-height: calc(100vh - 100px);
            position: relative;
            overflow: hidden;
            padding: 55px 0 75px;
            background:
                radial-gradient(
                    circle at 8% 12%,
                    rgba(37, 99, 235, 0.13),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 92% 85%,
                    rgba(104, 71, 230, 0.12),
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    #f8faff 0%,
                    #edf4ff 48%,
                    #f8f7ff 100%
                );
        }

        .edit-profile-page::before,
        .edit-profile-page::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .edit-profile-page::before {
            width: 340px;
            height: 340px;
            top: -205px;
            left: -145px;
            background: rgba(37, 99, 235, 0.07);
        }

        .edit-profile-page::after {
            width: 320px;
            height: 320px;
            right: -155px;
            bottom: -185px;
            background: rgba(104, 71, 230, 0.08);
        }

        .edit-profile-container {
            position: relative;
            z-index: 2;
        }

        .edit-profile-card {
            overflow: hidden;
            background: rgba(255, 255, 255, 0.97);
            border: 1px solid rgba(216, 226, 242, 0.96);
            border-radius: 26px;
            box-shadow:
                0 28px 70px rgba(30, 63, 120, 0.14),
                0 5px 18px rgba(30, 63, 120, 0.05);
            backdrop-filter: blur(12px);
        }

        /* Header */
        .edit-profile-header {
            min-height: 210px;
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

        .edit-profile-header::before,
        .edit-profile-header::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .edit-profile-header::before {
            width: 280px;
            height: 280px;
            top: -175px;
            right: 90px;
        }

        .edit-profile-header::after {
            width: 185px;
            height: 185px;
            right: -55px;
            bottom: -100px;
        }

        .edit-header-content {
            position: relative;
            z-index: 2;
        }

        .edit-header-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 12px;
            margin-bottom: 15px;
            color: #fff;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 22px;
            font-size: 11px;
            font-weight: 800;
            backdrop-filter: blur(8px);
        }

        .edit-profile-header h2 {
            color: #fff;
            margin-bottom: 8px;
            font-size: 29px;
            font-weight: 900;
            letter-spacing: -0.4px;
        }

        .edit-profile-header p {
            max-width: 620px;
            color: rgba(255, 255, 255, 0.84);
            margin-bottom: 0;
            font-size: 13px;
            line-height: 1.65;
        }

        /* Body */
        .edit-profile-body {
            position: relative;
            padding: 0 38px 38px;
        }

        /* Avatar */
        .edit-avatar-section {
            position: relative;
            margin-top: -72px;
            margin-bottom: 30px;
            display: flex;
            align-items: flex-end;
            gap: 22px;
            z-index: 3;
        }

        .edit-avatar-wrapper {
            position: relative;
            flex: 0 0 auto;
        }

        .edit-avatar-preview {
            width: 150px;
            height: 150px;
            display: block;
            object-fit: cover;
            background: #eef3ff;
            border: 7px solid #fff;
            border-radius: 50%;
            box-shadow:
                0 14px 34px rgba(28, 58, 115, 0.22),
                0 0 0 1px rgba(208, 220, 239, 0.85);
        }

        .edit-avatar-camera {
            width: 38px;
            height: 38px;
            position: absolute;
            right: 7px;
            bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background:
                linear-gradient(
                    135deg,
                    var(--edit-primary),
                    var(--edit-secondary)
                );
            border: 4px solid #fff;
            border-radius: 50%;
            font-size: 13px;
            box-shadow: 0 7px 16px rgba(37, 99, 235, 0.3);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .edit-avatar-camera:hover {
            transform: scale(1.08);
        }

        .edit-avatar-text {
            padding-bottom: 8px;
        }

        .edit-avatar-text h4 {
            color: var(--edit-text);
            margin-bottom: 6px;
            font-size: 21px;
            font-weight: 900;
        }

        .edit-avatar-text p {
            color: var(--edit-muted);
            margin-bottom: 0;
            font-size: 11px;
            line-height: 1.55;
        }

        /* Sections */
        .edit-section {
            padding: 24px;
            margin-bottom: 22px;
            background:
                linear-gradient(
                    145deg,
                    #ffffff 0%,
                    #fafcff 100%
                );
            border: 1px solid var(--edit-border);
            border-radius: 18px;
            box-shadow: 0 7px 20px rgba(34, 65, 122, 0.05);
        }

        .edit-section-heading {
            margin-bottom: 21px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .edit-section-icon {
            width: 43px;
            height: 43px;
            flex: 0 0 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--edit-primary);
            background: #edf3ff;
            border: 1px solid #d2dfff;
            border-radius: 12px;
            font-size: 16px;
        }

        .edit-section-heading h4 {
            color: var(--edit-text);
            margin-bottom: 3px;
            font-size: 17px;
            font-weight: 900;
        }

        .edit-section-heading p {
            color: var(--edit-muted);
            margin-bottom: 0;
            font-size: 11px;
        }

        /* Form */
        .edit-form-label {
            color: #2a4169;
            margin-bottom: 8px;
            font-size: 12px;
            font-weight: 800;
        }

        .edit-required {
            color: var(--edit-danger);
        }

        .edit-input-wrapper {
            position: relative;
        }

        .edit-input-icon {
            width: 46px;
            position: absolute;
            top: 1px;
            bottom: 1px;
            left: 1px;
            z-index: 4;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #7185a8;
            pointer-events: none;
        }

        .edit-form-control {
            min-height: 50px;
            padding: 11px 15px 11px 45px;
            color: #263e65;
            background: #fbfcff;
            border: 1px solid #d7e0ee;
            border-radius: 12px;
            font-size: 13px;
            box-shadow: none;
            transition: all 0.2s ease;
        }

        textarea.edit-form-control {
            min-height: 115px;
            padding-top: 13px;
            resize: vertical;
        }

        .edit-form-control:focus {
            color: #20375e;
            background: #fff;
            border-color: #3470e8;
            box-shadow: 0 0 0 4px rgba(52, 112, 232, 0.11);
        }

        .edit-input-wrapper:focus-within .edit-input-icon {
            color: var(--edit-primary);
        }

        .edit-form-control::placeholder {
            color: #a0adc1;
        }

        .edit-form-control:disabled {
            color: #74829a;
            background: #f1f4f9;
            border-color: #dce3ed;
            cursor: not-allowed;
        }

        .edit-form-control.is-invalid {
            border-color: var(--edit-danger);
            background-image: none;
        }

        .edit-form-hint {
            margin-top: 7px;
            color: var(--edit-muted);
            font-size: 10px;
            line-height: 1.5;
        }

        .invalid-feedback {
            margin-top: 7px;
            font-size: 10px;
            font-weight: 700;
        }

        /* Upload */
        .edit-upload-area {
            position: relative;
            padding: 21px;
            display: flex;
            align-items: center;
            gap: 16px;
            background: #f7faff;
            border: 1px dashed #afc4ea;
            border-radius: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .edit-upload-area:hover {
            background: #f0f5ff;
            border-color: var(--edit-primary);
            transform: translateY(-1px);
        }

        .edit-upload-area.dragging {
            background: #edf3ff;
            border-color: var(--edit-primary);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.08);
        }

        .edit-upload-icon {
            width: 48px;
            height: 48px;
            flex: 0 0 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--edit-primary);
            background: #e8f0ff;
            border: 1px solid #ccdbfa;
            border-radius: 13px;
            font-size: 18px;
        }

        .edit-upload-content h5 {
            color: var(--edit-text);
            margin-bottom: 4px;
            font-size: 13px;
            font-weight: 900;
        }

        .edit-upload-content p {
            color: var(--edit-muted);
            margin-bottom: 0;
            font-size: 10px;
            line-height: 1.5;
        }

        .edit-upload-input {
            width: 100%;
            height: 100%;
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
        }

        .edit-file-name {
            margin-top: 9px;
            color: var(--edit-primary);
            font-size: 11px;
            font-weight: 700;
        }

        /* Alert */
        .edit-alert {
            margin-bottom: 22px;
            padding: 14px 16px;
            border: 0;
            border-radius: 13px;
            font-size: 12px;
            box-shadow: 0 7px 18px rgba(36, 68, 126, 0.06);
        }

        /* Buttons */
        .edit-form-actions {
            padding-top: 6px;
            display: flex;
            justify-content: flex-end;
            gap: 11px;
            flex-wrap: wrap;
        }

        .edit-btn-cancel,
        .edit-btn-save,
        .edit-btn-delete {
            min-height: 46px;
            padding: 10px 19px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            border-radius: 11px;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .edit-btn-cancel {
            color: #556987;
            background: #fff;
            border: 1px solid #cfdaea;
        }

        .edit-btn-cancel:hover {
            color: var(--edit-primary);
            background: #f4f7ff;
            border-color: #afc4ea;
            transform: translateY(-2px);
        }

        .edit-btn-save {
            min-width: 165px;
            color: #fff;
            background:
                linear-gradient(
                    105deg,
                    #2563eb 0%,
                    #3478ec 60%,
                    #6747e6 100%
                );
            border: 0;
            box-shadow: 0 10px 23px rgba(37, 99, 235, 0.23);
        }

        .edit-btn-save:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 14px 29px rgba(37, 99, 235, 0.3);
        }

        .edit-btn-save:disabled {
            cursor: not-allowed;
            opacity: 0.7;
            transform: none;
            box-shadow: none;
        }

        .edit-btn-delete {
            min-height: 40px;
            padding: 8px 14px;
            color: #cb3c55;
            background: #fff4f5;
            border: 1px solid #efcbd2;
        }

        .edit-btn-delete:hover {
            color: #fff;
            background: var(--edit-danger);
            border-color: var(--edit-danger);
        }

        .edit-bottom-row {
            margin-top: 20px;
            padding-top: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            border-top: 1px solid #e5ebf4;
        }

        .edit-security-note {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: #7989a3;
            font-size: 10px;
        }

        /* Responsive */
        @media (max-width: 767.98px) {
            .edit-profile-page {
                padding: 30px 10px 45px;
            }

            .edit-profile-header {
                min-height: 200px;
                padding: 27px 22px;
            }

            .edit-profile-header h2 {
                font-size: 24px;
            }

            .edit-profile-body {
                padding: 0 20px 25px;
            }

            .edit-avatar-section {
                margin-top: -64px;
                align-items: center;
                flex-direction: column;
                text-align: center;
            }

            .edit-avatar-preview {
                width: 132px;
                height: 132px;
            }

            .edit-section {
                padding: 19px;
            }

            .edit-form-actions {
                flex-direction: column-reverse;
            }

            .edit-btn-cancel,
            .edit-btn-save {
                width: 100%;
            }

            .edit-bottom-row {
                align-items: stretch;
                flex-direction: column;
            }

            .edit-btn-delete {
                width: 100%;
            }
        }

        @media (max-width: 479.98px) {
            .edit-profile-header h2 {
                font-size: 22px;
            }

            .edit-upload-area {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <section class="edit-profile-page">
        <div class="container edit-profile-container">
            <div class="row justify-content-center">
                <div class="col-xl-9 col-lg-10">

                    @if ($errors->any())
                        <div class="alert alert-danger edit-alert">
                            <div class="d-flex align-items-start gap-2">
                                <i class="fas fa-circle-exclamation mt-1"></i>

                                <div>
                                    <strong>Không thể cập nhật hồ sơ</strong>

                                    <div class="mt-1">
                                        Vui lòng kiểm tra lại các thông tin được đánh dấu.
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="edit-profile-card">

                        {{-- Header --}}
                        <div class="edit-profile-header">
                            <div class="edit-header-content">

                                <span class="edit-header-badge">
                                    <i class="fas fa-user-pen"></i>
                                    Quản lý tài khoản
                                </span>

                                <h2>Chỉnh sửa hồ sơ</h2>

                                <p>
                                    Cập nhật ảnh đại diện và thông tin cá nhân để hồ sơ
                                    của bạn luôn đầy đủ, chính xác.
                                </p>

                            </div>
                        </div>

                        <div class="edit-profile-body">

                            {{-- Avatar hiện tại --}}
                            <div class="edit-avatar-section">

                                <div class="edit-avatar-wrapper">

                                    @php
                                        $avatarExists = $user->avatar
                                            && Storage::disk('public')->exists($user->avatar);

                                        $defaultAvatar = 'https://ui-avatars.com/api/?'
                                            . http_build_query([
                                                'name' => $user->name,
                                                'size' => 300,
                                                'background' => '2563eb',
                                                'color' => 'ffffff',
                                                'bold' => 'true',
                                                'format' => 'png',
                                            ]);
                                    @endphp

                                    <img id="avatarPreview"
                                        src="{{ $avatarExists
                                            ? Storage::disk('public')->url($user->avatar)
                                            : $defaultAvatar }}"
                                        alt="Ảnh đại diện của {{ $user->name }}"
                                        class="edit-avatar-preview">

                                    <label for="avatar"
                                        class="edit-avatar-camera"
                                        title="Thay đổi ảnh đại diện">

                                        <i class="fas fa-camera"></i>

                                    </label>

                                </div>

                                <div class="edit-avatar-text">

                                    <h4>{{ $user->name }}</h4>

                                    <p>
                                        Ảnh rõ khuôn mặt sẽ giúp tài khoản của bạn
                                        chuyên nghiệp và dễ nhận diện hơn.
                                    </p>

                                </div>

                            </div>

                            <form action="{{ route('client.profile.update') }}"
                                method="POST"
                                enctype="multipart/form-data"
                                id="editProfileForm">

                                @csrf
                                @method('PUT')

                                {{-- Ảnh đại diện --}}
                                <div class="edit-section">

                                    <div class="edit-section-heading">

                                        <div class="edit-section-icon">
                                            <i class="fas fa-image"></i>
                                        </div>

                                        <div>
                                            <h4>Ảnh đại diện</h4>

                                            <p>
                                                Chọn ảnh mới từ thiết bị của bạn.
                                            </p>
                                        </div>

                                    </div>

                                    <div class="edit-upload-area"
                                        id="avatarDropArea">

                                        <div class="edit-upload-icon">
                                            <i class="fas fa-cloud-arrow-up"></i>
                                        </div>

                                        <div class="edit-upload-content">

                                            <h5>
                                                Nhấn để chọn hoặc kéo thả ảnh vào đây
                                            </h5>

                                            <p>
                                                Hỗ trợ JPG, JPEG, PNG, WEBP.
                                                Dung lượng tối đa 2 MB.
                                            </p>

                                            <div class="edit-file-name"
                                                id="avatarFileName">
                                            </div>

                                        </div>

                                        <input type="file"
                                            name="avatar"
                                            id="avatar"
                                            accept=".jpg,.jpeg,.png,.webp"
                                            class="edit-upload-input">

                                    </div>

                                    @error('avatar')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-circle-exclamation me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>

                                {{-- Thông tin cá nhân --}}
                                <div class="edit-section">

                                    <div class="edit-section-heading">

                                        <div class="edit-section-icon">
                                            <i class="fas fa-address-card"></i>
                                        </div>

                                        <div>
                                            <h4>Thông tin cá nhân</h4>

                                            <p>
                                                Cập nhật các thông tin liên hệ cơ bản.
                                            </p>
                                        </div>

                                    </div>

                                    <div class="row g-3">

                                        {{-- Họ tên --}}
                                        <div class="col-md-6">

                                            <label for="name"
                                                class="edit-form-label">

                                                Họ và tên
                                                <span class="edit-required">*</span>

                                            </label>

                                            <div class="edit-input-wrapper">

                                                <span class="edit-input-icon">
                                                    <i class="fas fa-user"></i>
                                                </span>

                                                <input type="text"
                                                    name="name"
                                                    id="name"
                                                    value="{{ old('name', $user->name) }}"
                                                    class="form-control edit-form-control
                                                        @error('name') is-invalid @enderror"
                                                    placeholder="Nhập họ và tên"
                                                    autocomplete="name"
                                                    required>

                                            </div>

                                            @error('name')
                                                <div class="invalid-feedback d-block">
                                                    <i class="fas fa-circle-exclamation me-1"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>

                                        {{-- Email --}}
                                        <div class="col-md-6">

                                            <label for="email"
                                                class="edit-form-label">

                                                Địa chỉ email

                                            </label>

                                            <div class="edit-input-wrapper">

                                                <span class="edit-input-icon">
                                                    <i class="fas fa-envelope"></i>
                                                </span>

                                                <input type="email"
                                                    id="email"
                                                    value="{{ $user->email }}"
                                                    class="form-control edit-form-control"
                                                    disabled>

                                            </div>

                                            <div class="edit-form-hint">
                                                <i class="fas fa-lock me-1"></i>
                                                Email đăng nhập không thể tự thay đổi.
                                            </div>

                                        </div>

                                        {{-- Số điện thoại --}}
                                        <div class="col-md-6">

                                            <label for="phone"
                                                class="edit-form-label">

                                                Số điện thoại

                                            </label>

                                            <div class="edit-input-wrapper">

                                                <span class="edit-input-icon">
                                                    <i class="fas fa-phone"></i>
                                                </span>

                                                <input type="text"
                                                    name="phone"
                                                    id="phone"
                                                    value="{{ old('phone', $user->phone) }}"
                                                    class="form-control edit-form-control
                                                        @error('phone') is-invalid @enderror"
                                                    placeholder="Ví dụ: 0912345678"
                                                    autocomplete="tel"
                                                    inputmode="tel">

                                            </div>

                                            @error('phone')
                                                <div class="invalid-feedback d-block">
                                                    <i class="fas fa-circle-exclamation me-1"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                            <div class="edit-form-hint">
                                                Số điện thoại được dùng để liên hệ khi đặt tour.
                                            </div>

                                        </div>

                                        {{-- Trạng thái --}}
                                        <div class="col-md-6">

                                            <label class="edit-form-label">
                                                Trạng thái tài khoản
                                            </label>

                                            <div class="edit-input-wrapper">

                                                <span class="edit-input-icon">
                                                    <i class="fas fa-shield-halved"></i>
                                                </span>

                                                <input type="text"
                                                    value="{{ (int) $user->is_active === 1
                                                        ? 'Tài khoản đang hoạt động'
                                                        : 'Tài khoản đã bị khóa' }}"
                                                    class="form-control edit-form-control"
                                                    disabled>

                                            </div>

                                            <div class="edit-form-hint">
                                                Trạng thái tài khoản do hệ thống quản lý.
                                            </div>

                                        </div>

                                        {{-- Địa chỉ --}}
                                        <div class="col-12">

                                            <label for="address"
                                                class="edit-form-label">

                                                Địa chỉ

                                            </label>

                                            <div class="edit-input-wrapper">

                                                <span class="edit-input-icon"
                                                    style="align-items: flex-start; padding-top: 15px;">

                                                    <i class="fas fa-location-dot"></i>

                                                </span>

                                                <textarea name="address"
                                                    id="address"
                                                    rows="4"
                                                    class="form-control edit-form-control
                                                        @error('address') is-invalid @enderror"
                                                    placeholder="Nhập địa chỉ của bạn">{{ old('address', $user->address) }}</textarea>

                                            </div>

                                            @error('address')
                                                <div class="invalid-feedback d-block">
                                                    <i class="fas fa-circle-exclamation me-1"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>

                                    </div>

                                </div>

                                {{-- Nút lưu --}}
                                <div class="edit-form-actions">

                                    <a href="{{ route('client.profile.show') }}"
                                        class="edit-btn-cancel">

                                        <i class="fas fa-arrow-left"></i>
                                        Hủy thay đổi

                                    </a>

                                    <button type="submit"
                                        class="edit-btn-save"
                                        id="saveProfileButton">

                                        <i class="fas fa-floppy-disk"></i>
                                        Lưu thay đổi

                                    </button>

                                </div>

                            </form>

                            <div class="edit-bottom-row">

                                <div class="edit-security-note">
                                    <i class="fas fa-shield-halved text-primary"></i>
                                    Thông tin cá nhân của bạn được bảo mật.
                                </div>

                                @if ($user->avatar)
                                    <form action="{{ route('client.profile.avatar.delete') }}"
                                        method="POST"
                                        onsubmit="return confirm('Bạn có chắc muốn xóa ảnh đại diện hiện tại?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="edit-btn-delete">

                                            <i class="fas fa-trash"></i>
                                            Xóa ảnh đại diện

                                        </button>

                                    </form>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const avatarInput = document.getElementById('avatar');
            const avatarPreview = document.getElementById('avatarPreview');
            const avatarFileName = document.getElementById('avatarFileName');
            const dropArea = document.getElementById('avatarDropArea');
            const profileForm = document.getElementById('editProfileForm');
            const saveButton = document.getElementById('saveProfileButton');

            let previewUrl = null;

            function showAvatarPreview(file) {
                if (!file) {
                    return;
                }

                const allowedTypes = [
                    'image/jpeg',
                    'image/png',
                    'image/webp'
                ];

                if (!allowedTypes.includes(file.type)) {
                    alert('Chỉ hỗ trợ ảnh JPG, JPEG, PNG hoặc WEBP.');
                    avatarInput.value = '';
                    return;
                }

                const maxSize = 2 * 1024 * 1024;

                if (file.size > maxSize) {
                    alert('Ảnh đại diện không được vượt quá 2 MB.');
                    avatarInput.value = '';
                    return;
                }

                if (previewUrl) {
                    URL.revokeObjectURL(previewUrl);
                }

                previewUrl = URL.createObjectURL(file);
                avatarPreview.src = previewUrl;

                avatarFileName.textContent =
                    'Đã chọn: ' + file.name;
            }

            avatarInput?.addEventListener('change', function(event) {
                showAvatarPreview(event.target.files[0]);
            });

            ['dragenter', 'dragover'].forEach(function(eventName) {
                dropArea?.addEventListener(eventName, function(event) {
                    event.preventDefault();
                    event.stopPropagation();

                    dropArea.classList.add('dragging');
                });
            });

            ['dragleave', 'drop'].forEach(function(eventName) {
                dropArea?.addEventListener(eventName, function(event) {
                    event.preventDefault();
                    event.stopPropagation();

                    dropArea.classList.remove('dragging');
                });
            });

            dropArea?.addEventListener('drop', function(event) {
                const files = event.dataTransfer.files;

                if (!files.length) {
                    return;
                }

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(files[0]);

                avatarInput.files = dataTransfer.files;

                showAvatarPreview(files[0]);
            });

            profileForm?.addEventListener('submit', function() {
                saveButton.disabled = true;

                saveButton.innerHTML =
                    '<i class="fas fa-spinner fa-spin"></i>' +
                    ' Đang lưu...';
            });
        });
    </script>
@endsection
