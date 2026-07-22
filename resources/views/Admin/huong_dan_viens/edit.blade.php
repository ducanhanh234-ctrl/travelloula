@extends('layouts.admin')

@section('title', 'Chỉnh sửa hướng dẫn viên')

@section('content')
    @php
        $guideInitial = mb_strtoupper(
            mb_substr($huongDanVien->ho_ten ?: 'H', 0, 1)
        );

        $selectedStatus = old(
            'trang_thai',
            $huongDanVien->trang_thai
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

            --guide-danger: #dc4c64;
            --guide-danger-light: #fff0f3;

            --guide-success: #149963;
            --guide-success-light: #eaf9f1;
        }

        .guide-edit-page {
            max-width: 1120px;
            margin: 0 auto;
            padding: 24px 0;
            color: var(--guide-text-dark);
        }

        /* Tiêu đề trang */
        .guide-page-top {
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .page-heading h2 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .page-heading p {
            margin: 6px 0 0;
            color: var(--guide-text-muted);
            font-size: 14px;
        }

        .btn-back-top {
            min-height: 40px;
            padding: 8px 15px;
            color: #2c57d1;
            background: var(--guide-primary-light);
            border: 1px solid #cbdcff;
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

        .btn-back-top:hover {
            color: #1f46bd;
            background: #dfeaff;
            border-color: #a9c5ff;
            text-decoration: none;
            box-shadow: 0 5px 14px rgba(49, 91, 232, 0.12);
            transform: translateY(-1px);
        }

        /* Card */
        .guide-form-card {
            position: relative;
            overflow: hidden;
            background: var(--guide-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 10px 32px rgba(28, 65, 139, 0.11);
        }

        .guide-form-card::before {
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

        /* Header card */
        .guide-form-header {
            position: relative;
            min-height: 165px;
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
            gap: 24px;
        }

        .guide-form-header::before {
            position: absolute;
            right: -60px;
            bottom: -125px;
            width: 280px;
            height: 280px;
            content: "";
            border: 23px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .guide-form-header::after {
            position: absolute;
            top: -100px;
            right: 125px;
            width: 195px;
            height: 195px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .header-guide-content {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .header-avatar {
            width: 66px;
            height: 66px;
            flex-shrink: 0;
            overflow: hidden;
            color: var(--guide-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.32);
            border-radius: 17px;
            box-shadow: 0 8px 20px rgba(20, 43, 128, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .header-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .header-avatar-placeholder {
            font-size: 25px;
            font-weight: 800;
        }

        .header-guide-info {
            min-width: 0;
        }

        .header-guide-info h3 {
            margin: 0;
            overflow: hidden;
            color: var(--guide-white);
            font-size: 24px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .header-guide-info p {
            margin: 7px 0 0;
            color: rgba(255, 255, 255, 0.84);
            font-size: 13px;
            line-height: 1.5;
        }

        .header-guide-info p i {
            margin-right: 6px;
        }

        .header-guide-id {
            position: relative;
            z-index: 2;
            min-width: 110px;
            padding: 13px 16px;
            color: var(--guide-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.26);
            border-radius: 12px;
            text-align: center;
            backdrop-filter: blur(5px);
        }

        .header-guide-id strong {
            display: block;
            font-size: 21px;
            line-height: 1;
        }

        .header-guide-id span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.84;
        }

        /* Body */
        .guide-form-body {
            padding: 30px;
        }

        .form-section {
            margin-bottom: 32px;
        }

        .form-section:last-of-type {
            margin-bottom: 0;
        }

        .section-title {
            margin-bottom: 20px;
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

        .section-description {
            margin: -12px 0 18px;
            color: #7f8ba1;
            font-size: 12px;
        }

        /* Form grid */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .form-grid-three {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .form-group-custom {
            min-width: 0;
        }

        .form-group-custom.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            margin-bottom: 8px;
            color: #31456f;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .required-mark {
            color: var(--guide-danger);
            font-size: 14px;
        }

        /* Input */
        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 13px;
            z-index: 2;
            color: #7185b5;
            font-size: 12px;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .guide-edit-page .form-control,
        .guide-edit-page .form-select {
            width: 100%;
            min-height: 44px;
            padding: 10px 13px;
            color: #344563;
            background: #ffffff;
            border: 1px solid #cfdaec;
            border-radius: 9px;
            font-size: 14px;
            box-shadow: none;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                background-color 0.18s ease;
        }

        .guide-edit-page .input-wrapper .form-control,
        .guide-edit-page .input-wrapper .form-select {
            padding-left: 38px;
        }

        .guide-edit-page textarea.form-control {
            min-height: 125px;
            padding-top: 12px;
            line-height: 1.6;
            resize: vertical;
        }

        .guide-edit-page .form-control::placeholder {
            color: #a4aec1;
        }

        .guide-edit-page .form-control:hover,
        .guide-edit-page .form-select:hover {
            border-color: #b6c9e8;
        }

        .guide-edit-page .form-control:focus,
        .guide-edit-page .form-select:focus {
            color: #24375c;
            background: #ffffff;
            border-color: #4f78eb;
            outline: none;
            box-shadow: 0 0 0 4px rgba(49, 91, 232, 0.11);
        }

        .guide-edit-page .form-control.is-invalid,
        .guide-edit-page .form-select.is-invalid {
            border-color: var(--guide-danger);
            background-image: none;
        }

        .guide-edit-page .form-control.is-invalid:focus,
        .guide-edit-page .form-select.is-invalid:focus {
            border-color: var(--guide-danger);
            box-shadow: 0 0 0 4px rgba(220, 76, 100, 0.1);
        }

        /* Password */
        .password-input {
            padding-right: 45px !important;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 7px;
            width: 32px;
            height: 32px;
            padding: 0;
            color: #7082a8;
            background: transparent;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transform: translateY(-50%);
        }

        .password-toggle:hover {
            color: #315be8;
            background: #edf4ff;
        }

        .password-toggle:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.12);
        }

        /* Hint và lỗi */
        .form-hint {
            margin-top: 7px;
            color: #7b879f;
            font-size: 12px;
            line-height: 1.5;
            display: flex;
            align-items: flex-start;
            gap: 6px;
        }

        .form-hint i {
            margin-top: 2px;
            color: #5f81de;
            font-size: 11px;
        }

        .error-text {
            margin-top: 7px;
            color: #cf3f58;
            font-size: 12px;
            font-weight: 550;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Upload ảnh */
        .upload-card {
            overflow: hidden;
            background: #f8faff;
            border: 1px solid var(--guide-border);
            border-radius: 11px;
        }

        .upload-card-header {
            padding: 12px 14px;
            color: #29457d;
            background: #f1f6ff;
            border-bottom: 1px solid var(--guide-border);
            font-size: 12px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .upload-card-header i {
            color: #426ce0;
        }

        .upload-card-body {
            padding: 14px;
        }

        .file-input-wrapper {
            position: relative;
        }

        .file-input-wrapper .form-control {
            min-height: 44px;
            padding: 7px;
            background: #ffffff;
        }

        .file-input-wrapper .form-control::file-selector-button {
            height: 30px;
            margin-right: 10px;
            padding: 5px 11px;
            color: #3158ce;
            background: #edf4ff;
            border: none;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
        }

        .file-input-wrapper .form-control:hover::file-selector-button {
            color: #ffffff;
            background: #315be8;
        }

        /* Preview ảnh */
        .image-preview-box {
            position: relative;
            margin-top: 12px;
            min-height: 155px;
            overflow: hidden;
            background: #ffffff;
            border: 1px dashed #cbd8ec;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-preview-box img {
            width: 100%;
            height: 190px;
            object-fit: contain;
            background: #f7f9fd;
        }

        .image-preview-box.avatar-preview img {
            width: 125px;
            height: 125px;
            margin: 15px;
            object-fit: cover;
            border: 3px solid #ffffff;
            border-radius: 18px;
            box-shadow: 0 7px 18px rgba(39, 74, 143, 0.15);
        }

        .preview-placeholder {
            padding: 25px;
            color: #8b97aa;
            font-size: 12px;
            text-align: center;
        }

        .preview-placeholder i {
            margin-bottom: 8px;
            color: #6984c7;
            font-size: 25px;
            display: block;
        }

        .preview-label {
            position: absolute;
            right: 8px;
            bottom: 8px;
            padding: 4px 8px;
            color: #3158ce;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid #d0def5;
            border-radius: 6px;
            font-size: 9px;
            font-weight: 700;
        }

        .remove-preview {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 28px;
            height: 28px;
            padding: 0;
            color: #c53e56;
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid #f1cbd3;
            border-radius: 7px;
            cursor: pointer;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .remove-preview.is-visible {
            display: inline-flex;
        }

        /* Trạng thái */
        .status-preview {
            margin-top: 10px;
            padding: 12px 14px;
            background: #f8faff;
            border: 1px solid var(--guide-border);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .status-preview-label {
            color: #667591;
            font-size: 12px;
        }

        .status-badge {
            padding: 5px 10px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
        }

        .status-hoat-dong,
        .status-san-sang {
            color: #08754a;
            background: var(--guide-success-light);
            border-color: #c5ead8;
        }

        .status-dang-dan-tour {
            color: #2855ce;
            background: #edf4ff;
            border-color: #c9dcff;
        }

        .status-khong-hoat-dong {
            color: #b87511;
            background: #fff7e8;
            border-color: #f1dba9;
        }

        .status-bi-khoa {
            color: #c13d55;
            background: var(--guide-danger-light);
            border-color: #f0c9d1;
        }

        .status-nghi-viec {
            color: #66738b;
            background: #f1f4f8;
            border-color: #dce2ea;
        }

        /* Nút cuối */
        .form-actions {
            margin-top: 32px;
            padding-top: 23px;
            border-top: 1px solid var(--guide-border-light);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-form {
            min-width: 145px;
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

        .btn-form:hover {
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-update-guide {
            color: var(--guide-white);
            background: linear-gradient(
                135deg,
                #315be8 0%,
                #3b6dee 55%,
                #594bea 100%
            );
            border-color: #315be8;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.24);
        }

        .btn-update-guide:hover {
            color: var(--guide-white);
            background: linear-gradient(
                135deg,
                #264ed4 0%,
                #315edc 55%,
                #4d40d8 100%
            );
            border-color: #264ed4;
            box-shadow: 0 8px 19px rgba(49, 91, 232, 0.3);
        }

        .btn-update-guide:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(49, 91, 232, 0.15);
        }

        .btn-cancel {
            color: #53698f;
            background: #f2f6fc;
            border-color: #d4dfef;
        }

        .btn-cancel:hover {
            color: #304d83;
            background: #e7eef9;
            border-color: #bdcce3;
            box-shadow: 0 5px 13px rgba(41, 73, 132, 0.1);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .form-grid-three {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .guide-edit-page {
                padding: 15px 0;
            }

            .guide-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-back-top {
                width: 100%;
            }

            .guide-form-card {
                border-radius: 11px;
            }

            .guide-form-header {
                min-height: 135px;
                padding: 23px 20px;
                align-items: flex-start;
                flex-direction: column;
            }

            .guide-form-body {
                padding: 22px 18px;
            }

            .form-grid,
            .form-grid-three {
                grid-template-columns: 1fr;
            }

            .form-group-custom.full-width {
                grid-column: auto;
            }

            .form-actions {
                align-items: stretch;
                flex-direction: column-reverse;
            }

            .btn-form {
                width: 100%;
            }
        }

        @media (max-width: 520px) {
            .page-heading h2 {
                font-size: 20px;
            }

            .header-guide-content {
                align-items: flex-start;
            }

            .header-avatar {
                width: 52px;
                height: 52px;
                border-radius: 14px;
            }

            .header-avatar-placeholder {
                font-size: 20px;
            }

            .header-guide-info h3 {
                font-size: 20px;
            }

            .header-guide-info p {
                font-size: 12px;
            }

            .header-guide-id {
                min-width: 100px;
                padding: 10px 13px;
            }
        }
    </style>

    <div class="container-fluid guide-edit-page">
        <div class="guide-page-top">
            <div class="page-heading">
                <h2>Chỉnh sửa hướng dẫn viên</h2>

                <p>
                    Cập nhật thông tin cá nhân, giấy tờ và trạng thái làm việc.
                </p>
            </div>

            <a
                href="{{ route('Admin.huong-dan-viens.index') }}"
                class="btn-back-top"
            >
                <i class="fas fa-arrow-left"></i>
                Quay lại danh sách
            </a>
        </div>

        <div class="guide-form-card">
            <div class="guide-form-header">
                <div class="header-guide-content">
                    <div class="header-avatar">
                        @if ($huongDanVien->anh_dai_dien)
                            <img
                                src="{{ asset('storage/' . $huongDanVien->anh_dai_dien) }}"
                                alt="{{ $huongDanVien->ho_ten }}"
                            >
                        @else
                            <span class="header-avatar-placeholder">
                                {{ $guideInitial }}
                            </span>
                        @endif
                    </div>

                    <div class="header-guide-info">
                        <h3>{{ $huongDanVien->ho_ten }}</h3>

                        <p>
                            <i class="fas fa-envelope"></i>
                            {{ $huongDanVien->email ?: 'Chưa cập nhật email' }}
                        </p>
                    </div>
                </div>

                <div class="header-guide-id">
                    <strong>#{{ $huongDanVien->id }}</strong>
                    <span>Mã hướng dẫn viên</span>
                </div>
            </div>

            <div class="guide-form-body">
                <form
                    action="{{ route('Admin.huong-dan-viens.update', $huongDanVien->id) }}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf
                    @method('PUT')

                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-user"></i>
                            Thông tin cá nhân
                        </div>

                        <p class="section-description">
                            Cập nhật thông tin liên hệ và thông tin cá nhân của
                            hướng dẫn viên.
                        </p>

                        <div class="form-grid">
                            <div class="form-group-custom">
                                <label for="ho_ten" class="form-label">
                                    Họ và tên
                                    <span class="required-mark">*</span>
                                </label>

                                <div class="input-wrapper">
                                    <i class="fas fa-user input-icon"></i>

                                    <input
                                        type="text"
                                        name="ho_ten"
                                        id="ho_ten"
                                        class="form-control @error('ho_ten') is-invalid @enderror"
                                        value="{{ old('ho_ten', $huongDanVien->ho_ten) }}"
                                        placeholder="Nhập họ và tên"
                                        autocomplete="name"
                                        required
                                    >
                                </div>

                                @error('ho_ten')
                                    <div class="error-text">
                                        <i class="fas fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group-custom">
                                <label for="email" class="form-label">
                                    Email
                                    <span class="required-mark">*</span>
                                </label>

                                <div class="input-wrapper">
                                    <i class="fas fa-envelope input-icon"></i>

                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $huongDanVien->email) }}"
                                        placeholder="Nhập địa chỉ email"
                                        autocomplete="email"
                                        required
                                    >
                                </div>

                                @error('email')
                                    <div class="error-text">
                                        <i class="fas fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group-custom">
                                <label for="password" class="form-label">
                                    Mật khẩu mới
                                </label>

                                <div class="input-wrapper">
                                    <i class="fas fa-lock input-icon"></i>

                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        class="form-control password-input @error('password') is-invalid @enderror"
                                        placeholder="Nhập mật khẩu mới"
                                        autocomplete="new-password"
                                    >

                                    <button
                                        type="button"
                                        class="password-toggle"
                                        id="password_toggle"
                                        aria-label="Hiện mật khẩu"
                                        title="Hiện mật khẩu"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                                <div class="form-hint">
                                    <i class="fas fa-circle-info"></i>

                                    <span>
                                        Để trống nếu không muốn thay đổi mật khẩu.
                                    </span>
                                </div>

                                @error('password')
                                    <div class="error-text">
                                        <i class="fas fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group-custom">
                                <label for="so_dien_thoai" class="form-label">
                                    Số điện thoại
                                </label>

                                <div class="input-wrapper">
                                    <i class="fas fa-phone input-icon"></i>

                                    <input
                                        type="text"
                                        name="so_dien_thoai"
                                        id="so_dien_thoai"
                                        class="form-control @error('so_dien_thoai') is-invalid @enderror"
                                        value="{{ old('so_dien_thoai', $huongDanVien->so_dien_thoai) }}"
                                        placeholder="Nhập số điện thoại"
                                        autocomplete="tel"
                                    >
                                </div>

                                @error('so_dien_thoai')
                                    <div class="error-text">
                                        <i class="fas fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group-custom">
                                <label for="ngay_sinh" class="form-label">
                                    Ngày sinh
                                </label>

                                <div class="input-wrapper">
                                    <i class="fas fa-calendar-day input-icon"></i>

                                    <input
                                        type="date"
                                        name="ngay_sinh"
                                        id="ngay_sinh"
                                        class="form-control @error('ngay_sinh') is-invalid @enderror"
                                        value="{{ old(
                                            'ngay_sinh',
                                            $huongDanVien->ngay_sinh
                                                ? $huongDanVien->ngay_sinh->format('Y-m-d')
                                                : ''
                                        ) }}"
                                    >
                                </div>

                                @error('ngay_sinh')
                                    <div class="error-text">
                                        <i class="fas fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group-custom">
                                <label for="gioi_tinh" class="form-label">
                                    Giới tính
                                </label>

                                <div class="input-wrapper">
                                    <i class="fas fa-venus-mars input-icon"></i>

                                    <select
                                        name="gioi_tinh"
                                        id="gioi_tinh"
                                        class="form-select @error('gioi_tinh') is-invalid @enderror"
                                    >
                                        <option value="">Chọn giới tính</option>

                                        <option
                                            value="nam"
                                            @selected(old('gioi_tinh', $huongDanVien->gioi_tinh) === 'nam')
                                        >
                                            Nam
                                        </option>

                                        <option
                                            value="nu"
                                            @selected(old('gioi_tinh', $huongDanVien->gioi_tinh) === 'nu')
                                        >
                                            Nữ
                                        </option>

                                        <option
                                            value="khac"
                                            @selected(old('gioi_tinh', $huongDanVien->gioi_tinh) === 'khac')
                                        >
                                            Khác
                                        </option>
                                    </select>
                                </div>

                                @error('gioi_tinh')
                                    <div class="error-text">
                                        <i class="fas fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group-custom full-width">
                                <label for="dia_chi" class="form-label">
                                    Địa chỉ
                                </label>

                                <div class="input-wrapper">
                                    <i class="fas fa-location-dot input-icon"></i>

                                    <input
                                        type="text"
                                        name="dia_chi"
                                        id="dia_chi"
                                        class="form-control @error('dia_chi') is-invalid @enderror"
                                        value="{{ old('dia_chi', $huongDanVien->dia_chi) }}"
                                        placeholder="Nhập địa chỉ"
                                        autocomplete="street-address"
                                    >
                                </div>

                                @error('dia_chi')
                                    <div class="error-text">
                                        <i class="fas fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-id-card"></i>
                            Thông tin CCCD/CMND
                        </div>

                        <p class="section-description">
                            Cập nhật số giấy tờ, nơi cấp và hình ảnh hai mặt
                            CCCD/CMND.
                        </p>

                        <div class="form-grid form-grid-three">
                            <div class="form-group-custom">
                                <label for="so_cccd" class="form-label">
                                    Số CCCD/CMND
                                </label>

                                <div class="input-wrapper">
                                    <i class="fas fa-address-card input-icon"></i>

                                    <input
                                        type="text"
                                        name="so_cccd"
                                        id="so_cccd"
                                        class="form-control @error('so_cccd') is-invalid @enderror"
                                        value="{{ old('so_cccd', $huongDanVien->so_cccd) }}"
                                        placeholder="Nhập số CCCD/CMND"
                                    >
                                </div>

                                @error('so_cccd')
                                    <div class="error-text">
                                        <i class="fas fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group-custom">
                                <label for="ngay_cap_cccd" class="form-label">
                                    Ngày cấp CCCD
                                </label>

                                <div class="input-wrapper">
                                    <i class="fas fa-calendar-check input-icon"></i>

                                    <input
                                        type="date"
                                        name="ngay_cap_cccd"
                                        id="ngay_cap_cccd"
                                        class="form-control @error('ngay_cap_cccd') is-invalid @enderror"
                                        value="{{ old(
                                            'ngay_cap_cccd',
                                            $huongDanVien->ngay_cap_cccd
                                                ? $huongDanVien->ngay_cap_cccd->format('Y-m-d')
                                                : ''
                                        ) }}"
                                    >
                                </div>

                                @error('ngay_cap_cccd')
                                    <div class="error-text">
                                        <i class="fas fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group-custom">
                                <label for="noi_cap_cccd" class="form-label">
                                    Nơi cấp CCCD
                                </label>

                                <div class="input-wrapper">
                                    <i class="fas fa-building-columns input-icon"></i>

                                    <input
                                        type="text"
                                        name="noi_cap_cccd"
                                        id="noi_cap_cccd"
                                        class="form-control @error('noi_cap_cccd') is-invalid @enderror"
                                        value="{{ old('noi_cap_cccd', $huongDanVien->noi_cap_cccd) }}"
                                        placeholder="Ví dụ: Cục CSQLHC về TTXH"
                                    >
                                </div>

                                @error('noi_cap_cccd')
                                    <div class="error-text">
                                        <i class="fas fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-grid" style="margin-top: 20px;">
                            <div class="upload-card">
                                <div class="upload-card-header">
                                    <i class="fas fa-id-card"></i>
                                    Ảnh CCCD mặt trước
                                </div>

                                <div class="upload-card-body">
                                    <div class="file-input-wrapper">
                                        <input
                                            type="file"
                                            name="anh_cccd_truoc"
                                            id="anh_cccd_truoc"
                                            class="form-control @error('anh_cccd_truoc') is-invalid @enderror"
                                            accept="image/*"
                                            data-preview-input="preview_cccd_truoc"
                                        >
                                    </div>

                                    @error('anh_cccd_truoc')
                                        <div class="error-text">
                                            <i class="fas fa-circle-exclamation"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div
                                        class="image-preview-box"
                                        id="preview_cccd_truoc"
                                        data-current-image="{{ $huongDanVien->anh_cccd_truoc
                                            ? asset('storage/' . $huongDanVien->anh_cccd_truoc)
                                            : ''
                                        }}"
                                    >
                                        @if ($huongDanVien->anh_cccd_truoc)
                                            <img
                                                src="{{ asset('storage/' . $huongDanVien->anh_cccd_truoc) }}"
                                                alt="CCCD mặt trước"
                                            >

                                            <span class="preview-label">
                                                Ảnh hiện tại
                                            </span>
                                        @else
                                            <div class="preview-placeholder">
                                                <i class="fas fa-image"></i>
                                                Chưa có ảnh CCCD mặt trước
                                            </div>
                                        @endif

                                        <button
                                            type="button"
                                            class="remove-preview"
                                            data-remove-preview="anh_cccd_truoc"
                                            title="Bỏ ảnh vừa chọn"
                                        >
                                            <i class="fas fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="upload-card">
                                <div class="upload-card-header">
                                    <i class="fas fa-id-card"></i>
                                    Ảnh CCCD mặt sau
                                </div>

                                <div class="upload-card-body">
                                    <div class="file-input-wrapper">
                                        <input
                                            type="file"
                                            name="anh_cccd_sau"
                                            id="anh_cccd_sau"
                                            class="form-control @error('anh_cccd_sau') is-invalid @enderror"
                                            accept="image/*"
                                            data-preview-input="preview_cccd_sau"
                                        >
                                    </div>

                                    @error('anh_cccd_sau')
                                        <div class="error-text">
                                            <i class="fas fa-circle-exclamation"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div
                                        class="image-preview-box"
                                        id="preview_cccd_sau"
                                        data-current-image="{{ $huongDanVien->anh_cccd_sau
                                            ? asset('storage/' . $huongDanVien->anh_cccd_sau)
                                            : ''
                                        }}"
                                    >
                                        @if ($huongDanVien->anh_cccd_sau)
                                            <img
                                                src="{{ asset('storage/' . $huongDanVien->anh_cccd_sau) }}"
                                                alt="CCCD mặt sau"
                                            >

                                            <span class="preview-label">
                                                Ảnh hiện tại
                                            </span>
                                        @else
                                            <div class="preview-placeholder">
                                                <i class="fas fa-image"></i>
                                                Chưa có ảnh CCCD mặt sau
                                            </div>
                                        @endif

                                        <button
                                            type="button"
                                            class="remove-preview"
                                            data-remove-preview="anh_cccd_sau"
                                            title="Bỏ ảnh vừa chọn"
                                        >
                                            <i class="fas fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-briefcase"></i>
                            Thông tin công việc
                        </div>

                        <p class="section-description">
                            Cập nhật ảnh đại diện, kinh nghiệm, ngôn ngữ và trạng
                            thái làm việc.
                        </p>

                        <div class="form-grid">
                            <div class="upload-card">
                                <div class="upload-card-header">
                                    <i class="fas fa-camera"></i>
                                    Ảnh đại diện
                                </div>

                                <div class="upload-card-body">
                                    <div class="file-input-wrapper">
                                        <input
                                            type="file"
                                            name="anh_dai_dien"
                                            id="anh_dai_dien"
                                            class="form-control @error('anh_dai_dien') is-invalid @enderror"
                                            accept="image/*"
                                            data-preview-input="preview_avatar"
                                        >
                                    </div>

                                    @error('anh_dai_dien')
                                        <div class="error-text">
                                            <i class="fas fa-circle-exclamation"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror

                                    <div
                                        class="image-preview-box avatar-preview"
                                        id="preview_avatar"
                                        data-current-image="{{ $huongDanVien->anh_dai_dien
                                            ? asset('storage/' . $huongDanVien->anh_dai_dien)
                                            : ''
                                        }}"
                                    >
                                        @if ($huongDanVien->anh_dai_dien)
                                            <img
                                                src="{{ asset('storage/' . $huongDanVien->anh_dai_dien) }}"
                                                alt="Ảnh đại diện"
                                            >

                                            <span class="preview-label">
                                                Ảnh hiện tại
                                            </span>
                                        @else
                                            <div class="preview-placeholder">
                                                <i class="fas fa-user-circle"></i>
                                                Chưa có ảnh đại diện
                                            </div>
                                        @endif

                                        <button
                                            type="button"
                                            class="remove-preview"
                                            data-remove-preview="anh_dai_dien"
                                            title="Bỏ ảnh vừa chọn"
                                        >
                                            <i class="fas fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="form-group-custom">
                                    <label
                                        for="so_nam_kinh_nghiem"
                                        class="form-label"
                                    >
                                        Số năm kinh nghiệm
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-briefcase input-icon"></i>

                                        <input
                                            type="number"
                                            name="so_nam_kinh_nghiem"
                                            id="so_nam_kinh_nghiem"
                                            class="form-control @error('so_nam_kinh_nghiem') is-invalid @enderror"
                                            value="{{ old(
                                                'so_nam_kinh_nghiem',
                                                $huongDanVien->so_nam_kinh_nghiem
                                            ) }}"
                                            min="0"
                                            placeholder="Nhập số năm kinh nghiệm"
                                        >
                                    </div>

                                    @error('so_nam_kinh_nghiem')
                                        <div class="error-text">
                                            <i class="fas fa-circle-exclamation"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div
                                    class="form-group-custom"
                                    style="margin-top: 20px;"
                                >
                                    <label
                                        for="ngon_ngu_thanh_thao"
                                        class="form-label"
                                    >
                                        Ngôn ngữ thành thạo
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-language input-icon"></i>

                                        <input
                                            type="text"
                                            name="ngon_ngu_thanh_thao"
                                            id="ngon_ngu_thanh_thao"
                                            class="form-control @error('ngon_ngu_thanh_thao') is-invalid @enderror"
                                            value="{{ old(
                                                'ngon_ngu_thanh_thao',
                                                $huongDanVien->ngon_ngu_thanh_thao
                                            ) }}"
                                            placeholder="Ví dụ: Tiếng Anh, Tiếng Trung..."
                                        >
                                    </div>

                                    @error('ngon_ngu_thanh_thao')
                                        <div class="error-text">
                                            <i class="fas fa-circle-exclamation"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div
                                    class="form-group-custom"
                                    style="margin-top: 20px;"
                                >
                                    <label for="trang_thai" class="form-label">
                                        Trạng thái
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-toggle-on input-icon"></i>

                                        <select
                                            name="trang_thai"
                                            id="trang_thai"
                                            class="form-select @error('trang_thai') is-invalid @enderror"
                                        >
                                            <option
                                                value="hoat_dong"
                                                @selected($selectedStatus === 'hoat_dong')
                                            >
                                                Đang hoạt động
                                            </option>

                                            <option
                                                value="san_sang"
                                                @selected($selectedStatus === 'san_sang')
                                            >
                                                Sẵn sàng
                                            </option>

                                            <option
                                                value="dang_dan_tour"
                                                @selected($selectedStatus === 'dang_dan_tour')
                                            >
                                                Đang dẫn tour
                                            </option>

                                            <option
                                                value="khong_hoat_dong"
                                                @selected($selectedStatus === 'khong_hoat_dong')
                                            >
                                                Tạm nghỉ
                                            </option>

                                            <option
                                                value="bi_khoa"
                                                @selected($selectedStatus === 'bi_khoa')
                                            >
                                                Bị khóa
                                            </option>

                                            <option
                                                value="nghi_viec"
                                                @selected($selectedStatus === 'nghi_viec')
                                            >
                                                Nghỉ việc
                                            </option>
                                        </select>
                                    </div>

                                    <div class="status-preview">
                                        <span class="status-preview-label">
                                            Trạng thái được chọn:
                                        </span>

                                        <span
                                            class="status-badge"
                                            id="status_preview_badge"
                                        >
                                            <span class="status-dot"></span>
                                            <span id="status_preview_text"></span>
                                        </span>
                                    </div>

                                    @error('trang_thai')
                                        <div class="error-text">
                                            <i class="fas fa-circle-exclamation"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group-custom full-width">
                                <label for="mo_ta" class="form-label">
                                    Mô tả
                                </label>

                                <textarea
                                    name="mo_ta"
                                    id="mo_ta"
                                    class="form-control @error('mo_ta') is-invalid @enderror"
                                    rows="5"
                                    placeholder="Nhập mô tả về kinh nghiệm, kỹ năng hoặc ghi chú..."
                                >{{ old('mo_ta', $huongDanVien->mo_ta) }}</textarea>

                                @error('mo_ta')
                                    <div class="error-text">
                                        <i class="fas fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a
                            href="{{ route('Admin.huong-dan-viens.index') }}"
                            class="btn-form btn-cancel"
                        >
                            <i class="fas fa-xmark"></i>
                            Hủy
                        </a>

                        <button
                            type="submit"
                            class="btn-form btn-update-guide"
                        >
                            <i class="fas fa-floppy-disk"></i>
                            Cập nhật hướng dẫn viên
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput =
                document.getElementById('password');

            const passwordToggle =
                document.getElementById('password_toggle');

            const statusSelect =
                document.getElementById('trang_thai');

            const statusBadge =
                document.getElementById('status_preview_badge');

            const statusText =
                document.getElementById('status_preview_text');

            const statusConfig = {
                hoat_dong: {
                    text: 'Đang hoạt động',
                    className: 'status-hoat-dong'
                },
                san_sang: {
                    text: 'Sẵn sàng',
                    className: 'status-san-sang'
                },
                dang_dan_tour: {
                    text: 'Đang dẫn tour',
                    className: 'status-dang-dan-tour'
                },
                khong_hoat_dong: {
                    text: 'Tạm nghỉ',
                    className: 'status-khong-hoat-dong'
                },
                bi_khoa: {
                    text: 'Bị khóa',
                    className: 'status-bi-khoa'
                },
                nghi_viec: {
                    text: 'Nghỉ việc',
                    className: 'status-nghi-viec'
                }
            };

            function updateStatusPreview() {
                if (!statusSelect || !statusBadge || !statusText) {
                    return;
                }

                const config =
                    statusConfig[statusSelect.value]
                    || statusConfig.khong_hoat_dong;

                statusBadge.className =
                    'status-badge ' + config.className;

                statusText.textContent = config.text;
            }

            if (statusSelect) {
                statusSelect.addEventListener(
                    'change',
                    updateStatusPreview
                );
            }

            if (passwordToggle && passwordInput) {
                passwordToggle.addEventListener('click', function () {
                    const isPassword =
                        passwordInput.type === 'password';

                    passwordInput.type = isPassword
                        ? 'text'
                        : 'password';

                    const icon =
                        passwordToggle.querySelector('i');

                    if (icon) {
                        icon.classList.toggle(
                            'fa-eye',
                            !isPassword
                        );

                        icon.classList.toggle(
                            'fa-eye-slash',
                            isPassword
                        );
                    }

                    passwordToggle.title = isPassword
                        ? 'Ẩn mật khẩu'
                        : 'Hiện mật khẩu';

                    passwordToggle.setAttribute(
                        'aria-label',
                        passwordToggle.title
                    );
                });
            }

            function renderPreview(input) {
                const previewId =
                    input.dataset.previewInput;

                const previewBox =
                    document.getElementById(previewId);

                if (
                    !previewBox
                    || !input.files
                    || !input.files[0]
                ) {
                    return;
                }

                const file = input.files[0];

                if (!file.type.startsWith('image/')) {
                    input.value = '';
                    alert('Vui lòng chọn một tệp hình ảnh.');
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (event) {
                    const removeButton =
                        previewBox.querySelector('.remove-preview');

                    previewBox
                        .querySelectorAll(
                            'img, .preview-placeholder, .preview-label'
                        )
                        .forEach(function (element) {
                            element.remove();
                        });

                    const image =
                        document.createElement('img');

                    image.src = event.target.result;
                    image.alt = 'Ảnh mới được chọn';

                    const label =
                        document.createElement('span');

                    label.className = 'preview-label';
                    label.textContent = 'Ảnh mới';

                    previewBox.prepend(image);
                    previewBox.appendChild(label);

                    if (removeButton) {
                        removeButton.classList.add('is-visible');
                    }
                };

                reader.readAsDataURL(file);
            }

            function restoreCurrentPreview(input, previewBox) {
                const currentImage =
                    previewBox.dataset.currentImage;

                previewBox
                    .querySelectorAll(
                        'img, .preview-placeholder, .preview-label'
                    )
                    .forEach(function (element) {
                        element.remove();
                    });

                if (currentImage) {
                    const image =
                        document.createElement('img');

                    image.src = currentImage;
                    image.alt = 'Ảnh hiện tại';

                    const label =
                        document.createElement('span');

                    label.className = 'preview-label';
                    label.textContent = 'Ảnh hiện tại';

                    previewBox.prepend(image);
                    previewBox.appendChild(label);
                } else {
                    const placeholder =
                        document.createElement('div');

                    placeholder.className =
                        'preview-placeholder';

                    placeholder.innerHTML =
                        '<i class="fas fa-image"></i>' +
                        'Chưa có ảnh';

                    previewBox.prepend(placeholder);
                }

                input.value = '';
            }

            document
                .querySelectorAll('[data-preview-input]')
                .forEach(function (input) {
                    input.addEventListener('change', function () {
                        renderPreview(this);
                    });
                });

            document
                .querySelectorAll('[data-remove-preview]')
                .forEach(function (button) {
                    button.addEventListener('click', function () {
                        const inputId =
                            this.dataset.removePreview;

                        const input =
                            document.getElementById(inputId);

                        if (!input) {
                            return;
                        }

                        const previewBox =
                            document.getElementById(
                                input.dataset.previewInput
                            );

                        if (!previewBox) {
                            return;
                        }

                        restoreCurrentPreview(
                            input,
                            previewBox
                        );

                        this.classList.remove('is-visible');
                    });
                });

            updateStatusPreview();
        });
    </script>
@endsection
