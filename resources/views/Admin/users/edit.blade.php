@extends('layouts.admin')

@section('content')
    @php
        $userInitial = mb_strtoupper(mb_substr($user->name ?: 'U', 0, 1));
        $selectedRoleId = old(
            'vai_tro_id',
            optional($user->vaiTros->first())->id
        );
    @endphp

    <style>
        :root {
            --edit-user-primary: #315be8;
            --edit-user-primary-dark: #244bd2;
            --edit-user-primary-light: #edf4ff;
            --edit-user-purple: #5b4dea;
            --edit-user-cyan: #16c7e8;

            --edit-user-text-dark: #172b4d;
            --edit-user-text-main: #344563;
            --edit-user-text-muted: #6b7895;
            --edit-user-text-light: #98a2b3;

            --edit-user-border: #dce6f5;
            --edit-user-border-light: #e8eef8;

            --edit-user-white: #ffffff;
            --edit-user-soft-bg: #f6f9ff;

            --edit-user-danger: #dc4c64;
            --edit-user-danger-light: #fff0f3;
        }

        .edit-user-page {
            padding: 24px 0;
            color: var(--edit-user-text-dark);
        }

        /* Tiêu đề trên cùng */
        .edit-user-page-top {
            width: 100%;
            max-width: 980px;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .edit-user-page .page-heading h3 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .edit-user-page .page-heading p {
            margin: 6px 0 0;
            color: var(--edit-user-text-muted);
            font-size: 14px;
        }

        .edit-user-page .btn-back-top {
            min-height: 39px;
            padding: 8px 14px;
            color: #2c57d1;
            background: var(--edit-user-primary-light);
            border: 1px solid #cbdcff;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 650;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition:
                background-color 0.18s ease,
                border-color 0.18s ease,
                color 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.18s ease;
        }

        .edit-user-page .btn-back-top:hover {
            color: #1f46bd;
            background: #dfeaff;
            border-color: #a9c5ff;
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(49, 91, 232, 0.12);
        }

        /* Card */
        .edit-user-card {
            position: relative;
            width: 100%;
            max-width: 980px;
            margin: 0 auto;
            overflow: hidden;
            background: var(--edit-user-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 10px 32px rgba(28, 65, 139, 0.11);
        }

        .edit-user-card::before {
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

        /* Header card */
        .edit-user-header {
            position: relative;
            min-height: 150px;
            padding: 30px;
            overflow: hidden;
            color: var(--edit-user-white);
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

        .edit-user-header::before {
            position: absolute;
            right: -55px;
            bottom: -110px;
            width: 255px;
            height: 255px;
            content: "";
            border: 22px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .edit-user-header::after {
            position: absolute;
            top: -90px;
            right: 120px;
            width: 180px;
            height: 180px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .edit-user-header-content {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .edit-user-avatar {
            width: 60px;
            height: 60px;
            flex-shrink: 0;
            color: var(--edit-user-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.32);
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(20, 43, 128, 0.2);
            font-size: 23px;
            font-weight: 800;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .edit-user-header-info {
            min-width: 0;
        }

        .edit-user-header h3 {
            margin: 0;
            overflow: hidden;
            color: var(--edit-user-white);
            font-size: 23px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .edit-user-header p {
            margin: 7px 0 0;
            overflow: hidden;
            color: rgba(255, 255, 255, 0.84);
            font-size: 13px;
            line-height: 1.5;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .edit-user-header p i {
            margin-right: 6px;
        }

        .edit-user-id {
            position: relative;
            z-index: 2;
            min-width: 96px;
            padding: 12px 15px;
            color: var(--edit-user-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.26);
            border-radius: 12px;
            text-align: center;
            backdrop-filter: blur(5px);
        }

        .edit-user-id strong {
            display: block;
            font-size: 21px;
            line-height: 1;
        }

        .edit-user-id span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.84;
        }

        /* Nội dung */
        .edit-user-body {
            padding: 30px;
            background: var(--edit-user-white);
        }

        .edit-user-page .form-section {
            margin-bottom: 30px;
        }

        .edit-user-page .form-section:last-of-type {
            margin-bottom: 0;
        }

        .edit-user-page .section-title {
            margin-bottom: 20px;
            color: #24417d;
            font-size: 14px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .edit-user-page .section-title::before {
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

        .edit-user-page .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .edit-user-page .form-group-custom {
            margin-bottom: 22px;
        }

        .edit-user-page .form-group-custom.full-width {
            grid-column: 1 / -1;
        }

        .edit-user-page .form-label {
            margin-bottom: 8px;
            color: #31456f;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .edit-user-page .required-mark {
            color: var(--edit-user-danger);
            font-size: 14px;
        }

        /* Input */
        .edit-user-page .input-wrapper {
            position: relative;
        }

        .edit-user-page .input-icon {
            position: absolute;
            top: 50%;
            left: 13px;
            z-index: 2;
            color: #7185b5;
            font-size: 12px;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .edit-user-page .form-control,
        .edit-user-page .form-select {
            width: 100%;
            min-height: 44px;
            padding: 10px 13px;
            color: #344563;
            background: var(--edit-user-white);
            border: 1px solid #cfdaec;
            border-radius: 9px;
            font-size: 14px;
            box-shadow: none;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                background-color 0.18s ease;
        }

        .edit-user-page .input-wrapper .form-control {
            padding-left: 38px;
        }

        .edit-user-page .password-wrapper .form-control {
            padding-right: 44px;
        }

        .edit-user-page .form-control::placeholder {
            color: #a4aec1;
        }

        .edit-user-page .form-control:hover,
        .edit-user-page .form-select:hover {
            border-color: #b6c9e8;
        }

        .edit-user-page .form-control:focus,
        .edit-user-page .form-select:focus {
            color: #24375c;
            background: var(--edit-user-white);
            border-color: #4f78eb;
            outline: none;
            box-shadow: 0 0 0 4px rgba(49, 91, 232, 0.11);
        }

        .edit-user-page .form-control.is-invalid,
        .edit-user-page .form-select.is-invalid {
            border-color: var(--edit-user-danger);
            background-image: none;
        }

        .edit-user-page .form-control.is-invalid:focus,
        .edit-user-page .form-select.is-invalid:focus {
            border-color: var(--edit-user-danger);
            box-shadow: 0 0 0 4px rgba(220, 76, 100, 0.1);
        }

        /* Hiện mật khẩu */
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
            transition:
                background-color 0.16s ease,
                color 0.16s ease;
        }

        .password-toggle:hover {
            color: #315be8;
            background: #edf4ff;
        }

        .password-toggle:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.12);
        }

        /* Gợi ý và lỗi */
        .edit-user-page .form-hint {
            margin-top: 7px;
            color: #7b879f;
            font-size: 12px;
            line-height: 1.5;
            display: flex;
            align-items: flex-start;
            gap: 6px;
        }

        .edit-user-page .form-hint i {
            margin-top: 2px;
            color: #5f81de;
            font-size: 11px;
        }

        .edit-user-page .error-text {
            margin-top: 7px;
            color: #cf3f58;
            font-size: 12px;
            font-weight: 550;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Chọn vai trò */
        .role-selection {
            padding: 16px;
            background: #f7f9ff;
            border: 1px solid #d8e4f6;
            border-radius: 11px;
        }

        .role-selection-header {
            margin-bottom: 13px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .role-selection-title {
            color: #29457d;
            font-size: 13px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .role-selection-title i {
            color: #315be8;
        }

        .role-selected-count {
            padding: 4px 9px;
            color: #3158ce;
            background: var(--edit-user-white);
            border: 1px solid #ccdcf7;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
        }

        .role-options {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .role-option {
            position: relative;
            min-height: 68px;
            margin: 0;
            padding: 12px;
            overflow: hidden;
            background: var(--edit-user-white);
            border: 1px solid #dce6f5;
            border-radius: 9px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition:
                background-color 0.18s ease,
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.18s ease;
        }

        .role-option:hover {
            background: #f3f7ff;
            border-color: #c4d7f7;
            transform: translateY(-1px);
            box-shadow: 0 5px 14px rgba(38, 76, 148, 0.07);
        }

        .role-option.is-selected {
            background: #edf4ff;
            border-color: #9dbdff;
            box-shadow: inset 0 0 0 1px rgba(49, 91, 232, 0.08);
        }

        .role-option input[type="radio"] {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
            margin: 0;
            cursor: pointer;
            accent-color: #315be8;
        }

        .role-option-icon {
            width: 32px;
            height: 32px;
            flex-shrink: 0;
            color: #315be8;
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 8px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .role-option.is-selected .role-option-icon {
            color: var(--edit-user-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #5b4dea
            );
            border-color: #315be8;
        }

        .role-option-content {
            min-width: 0;
            flex: 1;
        }

        .role-option-name {
            overflow: hidden;
            color: #344563;
            font-size: 12px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .role-option-note {
            margin-top: 3px;
            color: #8390a8;
            font-size: 10px;
            display: block;
        }

        .empty-roles {
            padding: 24px;
            color: #8793aa;
            background: var(--edit-user-white);
            border: 1px dashed #ccd9ed;
            border-radius: 9px;
            text-align: center;
            grid-column: 1 / -1;
        }

        .empty-roles i {
            margin-bottom: 8px;
            color: #5f81de;
            font-size: 22px;
            display: block;
        }

        /* Nút */
        .btn-group-custom {
            margin-top: 30px;
            padding-top: 23px;
            border-top: 1px solid var(--edit-user-border-light);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
        }

        .btn-form {
            min-width: 135px;
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
            transition:
                background-color 0.18s ease,
                border-color 0.18s ease,
                color 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.18s ease;
        }

        .btn-form:hover {
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-update-user {
            color: var(--edit-user-white);
            background: linear-gradient(
                135deg,
                #315be8 0%,
                #3b6dee 55%,
                #594bea 100%
            );
            border-color: #315be8;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.24);
        }

        .btn-update-user:hover {
            color: var(--edit-user-white);
            background: linear-gradient(
                135deg,
                #264ed4 0%,
                #315edc 55%,
                #4d40d8 100%
            );
            border-color: #264ed4;
            box-shadow: 0 8px 19px rgba(49, 91, 232, 0.3);
        }

        .btn-update-user:focus {
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
            .role-options {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .edit-user-page {
                padding: 15px 0;
            }

            .edit-user-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .edit-user-page .btn-back-top {
                width: 100%;
            }

            .edit-user-card {
                border-radius: 11px;
            }

            .edit-user-header {
                min-height: 130px;
                padding: 23px 20px;
                align-items: flex-start;
                flex-direction: column;
            }

            .edit-user-body {
                padding: 22px 18px;
            }

            .edit-user-page .form-grid {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .edit-user-page .form-group-custom.full-width {
                grid-column: auto;
            }

            .btn-group-custom {
                align-items: stretch;
                flex-direction: column-reverse;
            }

            .btn-form {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .edit-user-page .page-heading h3 {
                font-size: 20px;
            }

            .edit-user-header-content {
                align-items: flex-start;
            }

            .edit-user-avatar {
                width: 50px;
                height: 50px;
                border-radius: 13px;
                font-size: 20px;
            }

            .edit-user-header h3 {
                font-size: 20px;
            }

            .edit-user-header p {
                max-width: 230px;
                font-size: 12px;
            }

            .role-options {
                grid-template-columns: 1fr;
            }

            .role-selection-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <div class="container-fluid edit-user-page">
        <div class="edit-user-page-top">
            <div class="page-heading">
                <h3>Chỉnh sửa tài khoản</h3>

                <p>
                    Cập nhật thông tin cá nhân, mật khẩu và vai trò người dùng.
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

        <div class="card edit-user-card">
            <div class="edit-user-header">
                <div class="edit-user-header-content">
                    <span class="edit-user-avatar">
                        {{ $userInitial }}
                    </span>

                    <div class="edit-user-header-info">
                        <h3>{{ $user->name }}</h3>

                        <p>
                            <i class="fas fa-envelope"></i>
                            {{ $user->email }}
                        </p>
                    </div>
                </div>

                <div class="edit-user-id">
                    <strong>#{{ $user->id }}</strong>
                    <span>Mã tài khoản</span>
                </div>
            </div>

            <div class="edit-user-body">
                <form
                    action="{{ route('Admin.users.update', $user->id) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    <div class="form-section">
                        <div class="section-title">
                            Thông tin tài khoản
                        </div>

                        <div class="form-grid">
                            <div class="form-group-custom">
                                <label for="name" class="form-label">
                                    Tên người dùng
                                    <span class="required-mark">*</span>
                                </label>

                                <div class="input-wrapper">
                                    <i class="fas fa-user input-icon"></i>

                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}"
                                        placeholder="Nhập họ và tên người dùng"
                                        autocomplete="name"
                                        required
                                    >
                                </div>

                                @error('name')
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
                                        value="{{ old('email', $user->email) }}"
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
                                <label for="phone" class="form-label">
                                    Điện thoại
                                </label>

                                <div class="input-wrapper">
                                    <i class="fas fa-phone input-icon"></i>

                                    <input
                                        type="text"
                                        name="phone"
                                        id="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', $user->phone) }}"
                                        placeholder="Nhập số điện thoại"
                                        autocomplete="tel"
                                    >
                                </div>

                                @error('phone')
                                    <div class="error-text">
                                        <i class="fas fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group-custom">
                                <label for="address" class="form-label">
                                    Địa chỉ
                                </label>

                                <div class="input-wrapper">
                                    <i class="fas fa-location-dot input-icon"></i>

                                    <input
                                        type="text"
                                        name="address"
                                        id="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        value="{{ old('address', $user->address) }}"
                                        placeholder="Nhập địa chỉ người dùng"
                                        autocomplete="street-address"
                                    >
                                </div>

                                @error('address')
                                    <div class="error-text">
                                        <i class="fas fa-circle-exclamation"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group-custom full-width">
                                <label for="password" class="form-label">
                                    Mật khẩu mới
                                </label>

                                <div class="input-wrapper password-wrapper">
                                    <i class="fas fa-lock input-icon"></i>

                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="Nhập mật khẩu mới"
                                        autocomplete="new-password"
                                    >

                                    <button
                                        type="button"
                                        class="password-toggle"
                                        id="password_toggle"
                                        title="Hiện mật khẩu"
                                        aria-label="Hiện mật khẩu"
                                    >
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>

                                <div class="form-hint">
                                    <i class="fas fa-circle-info"></i>

                                    <span>
                                        Để trống nếu không muốn thay đổi mật khẩu
                                        hiện tại.
                                    </span>
                                </div>

                                @error('password')
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
                            Vai trò người dùng
                        </div>

                        <div class="role-selection">
                            <div class="role-selection-header">
                                <div class="role-selection-title">
                                    <i class="fas fa-user-shield"></i>
                                    Chọn vai trò cho tài khoản
                                </div>

                                <span
                                    class="role-selected-count"
                                    id="role_selected_text"
                                >
                                    Chưa chọn vai trò
                                </span>
                            </div>

                            <div class="role-options">
                                @forelse ($vaiTros as $v)
                                    @php
                                        $isSelected =
                                            (string) $selectedRoleId
                                            === (string) $v->id;
                                    @endphp

                                    <label
                                        class="role-option {{ $isSelected ? 'is-selected' : '' }}"
                                        for="vai{{ $v->id }}"
                                    >
                                        <input
                                            class="role-radio"
                                            type="radio"
                                            name="vai_tro_id"
                                            value="{{ $v->id }}"
                                            id="vai{{ $v->id }}"
                                            data-role-name="{{ $v->ten_vai_tro }}"
                                            {{ $isSelected ? 'checked' : '' }}
                                        >

                                        <span class="role-option-icon">
                                            <i class="fas fa-user-tag"></i>
                                        </span>

                                        <span class="role-option-content">
                                            <span class="role-option-name">
                                                {{ $v->ten_vai_tro }}
                                            </span>

                                            <span class="role-option-note">
                                                Gán vai trò này cho tài khoản
                                            </span>
                                        </span>
                                    </label>
                                @empty
                                    <div class="empty-roles">
                                        <i class="fas fa-user-lock"></i>
                                        Chưa có vai trò nào để lựa chọn.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        @error('vai_tro_id')
                            <div class="error-text">
                                <i class="fas fa-circle-exclamation"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="btn-group-custom">
                        <a
                            href="{{ route('Admin.users.index') }}"
                            class="btn-form btn-cancel"
                        >
                            <i class="fas fa-xmark"></i>
                            Hủy
                        </a>

                        <button
                            type="submit"
                            class="btn-form btn-update-user"
                        >
                            <i class="fas fa-floppy-disk"></i>
                            Cập nhật tài khoản
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

            const roleRadios = Array.from(
                document.querySelectorAll('.role-radio')
            );

            const selectedRoleText =
                document.getElementById('role_selected_text');

            function updateRoleSelection() {
                let selectedRoleName = '';

                roleRadios.forEach(function (radio) {
                    const roleOption = radio.closest('.role-option');

                    if (roleOption) {
                        roleOption.classList.toggle(
                            'is-selected',
                            radio.checked
                        );
                    }

                    if (radio.checked) {
                        selectedRoleName =
                            radio.dataset.roleName || '';
                    }
                });

                if (selectedRoleText) {
                    selectedRoleText.textContent = selectedRoleName
                        ? 'Đã chọn: ' + selectedRoleName
                        : 'Chưa chọn vai trò';
                }
            }

            roleRadios.forEach(function (radio) {
                radio.addEventListener(
                    'change',
                    updateRoleSelection
                );
            });

            if (passwordToggle && passwordInput) {
                passwordToggle.addEventListener(
                    'click',
                    function () {
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
                    }
                );
            }

            updateRoleSelection();
        });
    </script>
@endsection
