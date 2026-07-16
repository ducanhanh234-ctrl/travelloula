@extends('layouts.admin')

@section('title', 'Chỉnh sửa khách hàng')

@section('content')
    @php
        $customerInitial = mb_strtoupper(
            mb_substr($khachHang->ho_ten ?: 'K', 0, 1)
        );

        $selectedGender = old(
            'gioi_tinh',
            $khachHang->gioi_tinh
        );

        $selectedPassengerType = old(
            'loai_hanh_khach',
            $khachHang->loai_hanh_khach ?: 'adult'
        );

        $selectedPaymentStatus = old(
            'trang_thai_thanh_toan',
            $khachHang->trang_thai_thanh_toan
                ?? 'chua_thanh_toan'
        );

        $selectedCheckInStatus = old(
            'trang_thai_check_in',
            $khachHang->trang_thai_check_in
                ?? 'chua_check_in'
        );
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

            --customer-neutral: #68758c;
            --customer-neutral-light: #f1f4f8;
        }

        .customer-edit-page {
            width: 100%;
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

        .btn-back-top {
            min-height: 40px;
            padding: 8px 15px;
            color: #2c57d1;
            background: var(--customer-primary-light);
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
            box-shadow: 0 5px 14px rgba(49, 91, 232, 0.12);
            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Card chính */
        .customer-form-card {
            position: relative;
            overflow: hidden;
            background: var(--customer-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 10px 32px rgba(28, 65, 139, 0.11);
        }

        .customer-form-card::before {
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
        .customer-form-header {
            position: relative;
            min-height: 165px;
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
            gap: 24px;
        }

        .customer-form-header::before {
            position: absolute;
            right: -60px;
            bottom: -125px;
            width: 280px;
            height: 280px;
            content: "";
            border: 23px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .customer-form-header::after {
            position: absolute;
            top: -100px;
            right: 125px;
            width: 195px;
            height: 195px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .customer-header-content {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .customer-header-avatar {
            width: 66px;
            height: 66px;
            flex-shrink: 0;
            color: var(--customer-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.32);
            border-radius: 17px;
            box-shadow: 0 8px 20px rgba(20, 43, 128, 0.2);
            font-size: 25px;
            font-weight: 800;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .customer-header-info {
            min-width: 0;
        }

        .customer-header-info h3 {
            margin: 0;
            overflow: hidden;
            color: var(--customer-white);
            font-size: 24px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .customer-header-info p {
            margin: 7px 0 0;
            overflow: hidden;
            color: rgba(255, 255, 255, 0.84);
            font-size: 13px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .customer-header-info p i {
            margin-right: 6px;
        }

        .customer-header-id {
            position: relative;
            z-index: 2;
            min-width: 110px;
            padding: 13px 16px;
            color: var(--customer-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.26);
            border-radius: 12px;
            text-align: center;
            backdrop-filter: blur(5px);
        }

        .customer-header-id strong {
            display: block;
            font-size: 21px;
            line-height: 1;
        }

        .customer-header-id span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.84;
        }

        /* Nội dung form */
        .customer-form-body {
            padding: 30px;
        }

        /* Thông báo lỗi */
        .validation-alert {
            margin-bottom: 24px;
            padding: 15px 17px;
            color: #a23449;
            background: var(--customer-danger-light);
            border: 1px solid #f0c9d1;
            border-radius: 10px;
            font-size: 13px;
        }

        .validation-alert-title {
            margin-bottom: 7px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .validation-alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .validation-alert li + li {
            margin-top: 3px;
        }

        /* Section */
        .form-section {
            margin-bottom: 30px;
            overflow: hidden;
            background: #ffffff;
            border: 1px solid var(--customer-border);
            border-radius: 12px;
        }

        .form-section:last-of-type {
            margin-bottom: 0;
        }

        .section-header {
            min-height: 58px;
            padding: 14px 17px;
            background: #f1f6ff;
            border-bottom: 1px solid var(--customer-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .section-title {
            margin: 0;
            color: #24417d;
            font-size: 14px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .section-title-icon {
            width: 31px;
            height: 31px;
            flex-shrink: 0;
            color: #315be8;
            background: #ffffff;
            border: 1px solid #cfe0ff;
            border-radius: 8px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .section-badge {
            padding: 5px 9px;
            color: #3158ce;
            background: #ffffff;
            border: 1px solid #ccdcf7;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 750;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .section-body {
            padding: 20px;
        }

        .section-description {
            margin: -3px 0 18px;
            color: #7f8ba1;
            font-size: 12px;
            line-height: 1.6;
        }

        /* Grid */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .form-grid-two {
            grid-template-columns: repeat(2, minmax(0, 1fr));
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
            color: var(--customer-danger);
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

        .customer-edit-page .form-control,
        .customer-edit-page .form-select {
            width: 100%;
            min-height: 44px;
            padding: 10px 13px;
            color: #344563;
            background: var(--customer-white);
            border: 1px solid #cfdaec;
            border-radius: 9px;
            font-size: 14px;
            box-shadow: none;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                background-color 0.18s ease;
        }

        .customer-edit-page .input-wrapper .form-control,
        .customer-edit-page .input-wrapper .form-select {
            padding-left: 38px;
        }

        .customer-edit-page textarea.form-control {
            min-height: 125px;
            padding-top: 12px;
            line-height: 1.7;
            resize: vertical;
        }

        .customer-edit-page .form-control::placeholder {
            color: #a4aec1;
        }

        .customer-edit-page .form-control:hover,
        .customer-edit-page .form-select:hover {
            border-color: #b6c9e8;
        }

        .customer-edit-page .form-control:focus,
        .customer-edit-page .form-select:focus {
            color: #24375c;
            background: var(--customer-white);
            border-color: #4f78eb;
            outline: none;
            box-shadow: 0 0 0 4px rgba(49, 91, 232, 0.11);
        }

        .customer-edit-page .form-control.is-invalid,
        .customer-edit-page .form-select.is-invalid {
            border-color: var(--customer-danger);
            background-image: none;
        }

        .customer-edit-page .form-control.is-invalid:focus,
        .customer-edit-page .form-select.is-invalid:focus {
            border-color: var(--customer-danger);
            box-shadow: 0 0 0 4px rgba(220, 76, 100, 0.1);
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

        .form-hint {
            margin-top: 7px;
            color: #7b879f;
            font-size: 11px;
            line-height: 1.5;
            display: flex;
            align-items: flex-start;
            gap: 6px;
        }

        .form-hint i {
            margin-top: 2px;
            color: #5f81de;
            font-size: 10px;
        }

        /* Trạng thái */
        .status-preview-grid {
            margin-top: 16px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .status-preview-card {
            min-height: 66px;
            padding: 12px 14px;
            background: #f8faff;
            border: 1px solid var(--customer-border);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .status-preview-label {
            color: #667591;
            font-size: 11px;
            font-weight: 650;
        }

        .status-badge {
            padding: 5px 10px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            flex-shrink: 0;
            border-radius: 50%;
            background: currentColor;
        }

        .payment-unpaid {
            color: #66738b;
            background: var(--customer-neutral-light);
            border-color: #dce2ea;
        }

        .payment-deposit,
        .payment-partial {
            color: #ae6c0d;
            background: var(--customer-warning-light);
            border-color: #f1dba9;
        }

        .payment-paid {
            color: #08754a;
            background: var(--customer-success-light);
            border-color: #c5ead8;
        }

        .payment-refund {
            color: #2855ce;
            background: var(--customer-primary-light);
            border-color: #c9dcff;
        }

        .payment-failed {
            color: #c13d55;
            background: var(--customer-danger-light);
            border-color: #f0c9d1;
        }

        .checkin-pending {
            color: #66738b;
            background: var(--customer-neutral-light);
            border-color: #dce2ea;
        }

        .checkin-completed {
            color: #08754a;
            background: var(--customer-success-light);
            border-color: #c5ead8;
        }

        /* Tiền */
        .money-summary {
            margin-top: 16px;
            padding: 14px;
            background: #f8faff;
            border: 1px solid var(--customer-border);
            border-radius: 9px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .money-summary-item {
            min-width: 0;
            padding: 11px 12px;
            background: #ffffff;
            border: 1px solid #dce6f5;
            border-radius: 8px;
        }

        .money-summary-item span {
            display: block;
            margin-bottom: 4px;
            color: #7b879f;
            font-size: 10px;
            font-weight: 650;
        }

        .money-summary-item strong {
            display: block;
            overflow: hidden;
            color: #29457d;
            font-size: 13px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .money-summary-item.remaining strong {
            color: #c13d55;
        }

        /* Nút cuối */
        .form-actions {
            margin-top: 30px;
            padding-top: 23px;
            border-top: 1px solid var(--customer-border-light);
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

        .btn-update-customer {
            color: var(--customer-white);
            background: linear-gradient(
                135deg,
                #315be8 0%,
                #3b6dee 55%,
                #594bea 100%
            );
            border-color: #315be8;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.24);
        }

        .btn-update-customer:hover {
            color: var(--customer-white);
            background: linear-gradient(
                135deg,
                #264ed4 0%,
                #315edc 55%,
                #4d40d8 100%
            );
            border-color: #264ed4;
            box-shadow: 0 8px 19px rgba(49, 91, 232, 0.3);
        }

        .btn-update-customer:focus {
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
        @media (max-width: 1000px) {
            .form-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .customer-edit-page {
                padding: 15px 0;
            }

            .customer-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-back-top {
                width: 100%;
            }

            .customer-form-card {
                border-radius: 11px;
            }

            .customer-form-header {
                min-height: 135px;
                padding: 23px 20px;
                align-items: flex-start;
                flex-direction: column;
            }

            .customer-form-body {
                padding: 22px 18px;
            }

            .form-grid,
            .form-grid-two,
            .status-preview-grid,
            .money-summary {
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
            .customer-page-heading h2 {
                font-size: 20px;
            }

            .customer-header-content {
                align-items: flex-start;
            }

            .customer-header-avatar {
                width: 52px;
                height: 52px;
                border-radius: 14px;
                font-size: 20px;
            }

            .customer-header-info h3 {
                font-size: 20px;
            }

            .customer-header-info p {
                max-width: 230px;
                font-size: 12px;
            }

            .customer-header-id {
                min-width: 100px;
                padding: 10px 13px;
            }

            .section-header {
                align-items: flex-start;
            }
        }
    </style>

    <div class="container-fluid customer-edit-page">
        <div class="customer-page-top">
            <div class="customer-page-heading">
                <h2>Chỉnh sửa khách hàng</h2>

                <p>
                    Cập nhật thông tin cá nhân, thanh toán và trạng thái
                    check-in.
                </p>
            </div>

            <a
                href="{{ route('Admin.khach-hang.index') }}"
                class="btn-back-top"
            >
                <i class="fas fa-arrow-left"></i>
                Quay lại danh sách
            </a>
        </div>

        <div class="customer-form-card">
            <div class="customer-form-header">
                <div class="customer-header-content">
                    <span class="customer-header-avatar">
                        {{ $customerInitial }}
                    </span>

                    <div class="customer-header-info">
                        <h3>{{ $khachHang->ho_ten }}</h3>

                        <p>
                            <i class="fas fa-envelope"></i>
                            {{ $khachHang->email ?: 'Chưa cập nhật email' }}
                        </p>
                    </div>
                </div>

                <div class="customer-header-id">
                    <strong>#{{ $khachHang->id }}</strong>
                    <span>Mã khách hàng</span>
                </div>
            </div>

            <div class="customer-form-body">
                @if ($errors->any())
                    <div class="validation-alert">
                        <div class="validation-alert-title">
                            <i class="fas fa-exclamation-circle"></i>
                            Vui lòng kiểm tra lại dữ liệu
                        </div>

                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    action="{{ route('Admin.khach-hang.update', $khachHang->id) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    <div class="form-section">
                        <div class="section-header">
                            <h3 class="section-title">
                                <span class="section-title-icon">
                                    <i class="fas fa-user"></i>
                                </span>

                                Thông tin khách hàng
                            </h3>

                            <span class="section-badge">
                                Thông tin cá nhân
                            </span>
                        </div>

                        <div class="section-body">
                            <p class="section-description">
                                Cập nhật thông tin liên hệ, loại hành khách và
                                giấy tờ tùy thân.
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
                                            value="{{ old('ho_ten', $khachHang->ho_ten) }}"
                                            placeholder="Nhập họ và tên khách hàng"
                                            autocomplete="name"
                                            required
                                        >
                                    </div>

                                    @error('ho_ten')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group-custom">
                                    <label for="email" class="form-label">
                                        Email
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-envelope input-icon"></i>

                                        <input
                                            type="email"
                                            name="email"
                                            id="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $khachHang->email) }}"
                                            placeholder="Nhập địa chỉ email"
                                            autocomplete="email"
                                        >
                                    </div>

                                    @error('email')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
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
                                            value="{{ old('so_dien_thoai', $khachHang->so_dien_thoai) }}"
                                            placeholder="Nhập số điện thoại"
                                            autocomplete="tel"
                                        >
                                    </div>

                                    @error('so_dien_thoai')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
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
                                            <option value="">
                                                Chọn giới tính
                                            </option>

                                            <option
                                                value="nam"
                                                @selected($selectedGender === 'nam')
                                            >
                                                Nam
                                            </option>

                                            <option
                                                value="nu"
                                                @selected($selectedGender === 'nu')
                                            >
                                                Nữ
                                            </option>

                                            <option
                                                value="khac"
                                                @selected($selectedGender === 'khac')
                                            >
                                                Khác
                                            </option>
                                        </select>
                                    </div>

                                    @error('gioi_tinh')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group-custom">
                                    <label for="nam_sinh" class="form-label">
                                        Năm sinh
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-calendar-alt input-icon"></i>

                                        <input
                                            type="number"
                                            name="nam_sinh"
                                            id="nam_sinh"
                                            class="form-control @error('nam_sinh') is-invalid @enderror"
                                            value="{{ old('nam_sinh', $khachHang->nam_sinh) }}"
                                            placeholder="Ví dụ: 1998"
                                        >
                                    </div>

                                    @error('nam_sinh')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group-custom">
                                    <label
                                        for="loai_hanh_khach"
                                        class="form-label"
                                    >
                                        Loại hành khách
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-users input-icon"></i>

                                        <select
                                            name="loai_hanh_khach"
                                            id="loai_hanh_khach"
                                            class="form-select @error('loai_hanh_khach') is-invalid @enderror"
                                        >
                                            <option
                                                value="adult"
                                                @selected($selectedPassengerType === 'adult')
                                            >
                                                Người lớn
                                            </option>

                                            <option
                                                value="child"
                                                @selected($selectedPassengerType === 'child')
                                            >
                                                Trẻ em
                                            </option>

                                            <option
                                                value="baby"
                                                @selected($selectedPassengerType === 'baby')
                                            >
                                                Em bé
                                            </option>
                                        </select>
                                    </div>

                                    @error('loai_hanh_khach')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group-custom">
                                    <label for="loai_giay_to" class="form-label">
                                        Loại giấy tờ
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-id-card input-icon"></i>

                                        <input
                                            type="text"
                                            name="loai_giay_to"
                                            id="loai_giay_to"
                                            class="form-control @error('loai_giay_to') is-invalid @enderror"
                                            value="{{ old('loai_giay_to', $khachHang->loai_giay_to) }}"
                                            placeholder="CCCD, CMND hoặc hộ chiếu"
                                        >
                                    </div>

                                    @error('loai_giay_to')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group-custom">
                                    <label for="so_giay_to" class="form-label">
                                        Số giấy tờ
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-address-card input-icon"></i>

                                        <input
                                            type="text"
                                            name="so_giay_to"
                                            id="so_giay_to"
                                            class="form-control @error('so_giay_to') is-invalid @enderror"
                                            value="{{ old('so_giay_to', $khachHang->so_giay_to) }}"
                                            placeholder="Nhập số giấy tờ"
                                        >
                                    </div>

                                    @error('so_giay_to')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-header">
                            <h3 class="section-title">
                                <span class="section-title-icon">
                                    <i class="fas fa-credit-card"></i>
                                </span>

                                Thanh toán và check-in
                            </h3>

                            <span class="section-badge">
                                Trạng thái đơn
                            </span>
                        </div>

                        <div class="section-body">
                            <p class="section-description">
                                Cập nhật tiến độ thanh toán, số tiền, thông tin
                                phòng và trạng thái check-in.
                            </p>

                            <div class="form-grid">
                                <div class="form-group-custom">
                                    <label
                                        for="trang_thai_thanh_toan"
                                        class="form-label"
                                    >
                                        Trạng thái thanh toán
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-wallet input-icon"></i>

                                        <select
                                            name="trang_thai_thanh_toan"
                                            id="trang_thai_thanh_toan"
                                            class="form-select @error('trang_thai_thanh_toan') is-invalid @enderror"
                                        >
                                            <option
                                                value="chua_thanh_toan"
                                                @selected($selectedPaymentStatus === 'chua_thanh_toan')
                                            >
                                                Chưa thanh toán
                                            </option>

                                            <option
                                                value="da_coc"
                                                @selected($selectedPaymentStatus === 'da_coc')
                                            >
                                                Đã đặt cọc
                                            </option>

                                            <option
                                                value="thanh_toan_mot_phan"
                                                @selected($selectedPaymentStatus === 'thanh_toan_mot_phan')
                                            >
                                                Thanh toán một phần
                                            </option>

                                            <option
                                                value="da_thanh_toan"
                                                @selected($selectedPaymentStatus === 'da_thanh_toan')
                                            >
                                                Đã thanh toán
                                            </option>

                                            <option
                                                value="hoan_tien"
                                                @selected($selectedPaymentStatus === 'hoan_tien')
                                            >
                                                Đã hoàn tiền
                                            </option>

                                            <option
                                                value="that_bai"
                                                @selected($selectedPaymentStatus === 'that_bai')
                                            >
                                                Thanh toán thất bại
                                            </option>
                                        </select>
                                    </div>

                                    @error('trang_thai_thanh_toan')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group-custom">
                                    <label
                                        for="trang_thai_check_in"
                                        class="form-label"
                                    >
                                        Trạng thái check-in
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-check-circle input-icon"></i>

                                        <select
                                            name="trang_thai_check_in"
                                            id="trang_thai_check_in"
                                            class="form-select @error('trang_thai_check_in') is-invalid @enderror"
                                        >
                                            <option
                                                value="chua_check_in"
                                                @selected($selectedCheckInStatus === 'chua_check_in')
                                            >
                                                Chưa check-in
                                            </option>

                                            <option
                                                value="da_check_in"
                                                @selected($selectedCheckInStatus === 'da_check_in')
                                            >
                                                Đã check-in
                                            </option>
                                        </select>
                                    </div>

                                    @error('trang_thai_check_in')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group-custom">
                                    <label
                                        for="so_tien_da_thanh_toan"
                                        class="form-label"
                                    >
                                        Số tiền đã thanh toán
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-money-bill-wave input-icon"></i>

                                        <input
                                            type="number"
                                            name="so_tien_da_thanh_toan"
                                            id="so_tien_da_thanh_toan"
                                            class="form-control @error('so_tien_da_thanh_toan') is-invalid @enderror"
                                            value="{{ old(
                                                'so_tien_da_thanh_toan',
                                                $khachHang->so_tien_da_thanh_toan
                                            ) }}"
                                            placeholder="Nhập số tiền đã thanh toán"
                                            min="0"
                                        >
                                    </div>

                                    @error('so_tien_da_thanh_toan')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group-custom">
                                    <label for="tong_tien" class="form-label">
                                        Tổng tiền
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-coins input-icon"></i>

                                        <input
                                            type="number"
                                            name="tong_tien"
                                            id="tong_tien"
                                            class="form-control @error('tong_tien') is-invalid @enderror"
                                            value="{{ old('tong_tien', $khachHang->tong_tien) }}"
                                            placeholder="Nhập tổng tiền"
                                            min="0"
                                        >
                                    </div>

                                    @error('tong_tien')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group-custom">
                                    <label for="so_phong" class="form-label">
                                        Số phòng
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-door-closed input-icon"></i>

                                        <input
                                            type="text"
                                            name="so_phong"
                                            id="so_phong"
                                            class="form-control @error('so_phong') is-invalid @enderror"
                                            value="{{ old('so_phong', $khachHang->so_phong) }}"
                                            placeholder="Ví dụ: P101, P102"
                                        >
                                    </div>

                                    @error('so_phong')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group-custom">
                                    <label for="loai_phong" class="form-label">
                                        Loại phòng
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-bed input-icon"></i>

                                        <input
                                            type="text"
                                            name="loai_phong"
                                            id="loai_phong"
                                            class="form-control @error('loai_phong') is-invalid @enderror"
                                            value="{{ old('loai_phong', $khachHang->loai_phong) }}"
                                            placeholder="Ví dụ: Phòng đôi"
                                        >
                                    </div>

                                    @error('loai_phong')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="status-preview-grid">
                                <div class="status-preview-card">
                                    <span class="status-preview-label">
                                        Thanh toán hiện tại
                                    </span>

                                    <span
                                        class="status-badge"
                                        id="payment_status_badge"
                                    >
                                        <span class="status-dot"></span>

                                        <span id="payment_status_text"></span>
                                    </span>
                                </div>

                                <div class="status-preview-card">
                                    <span class="status-preview-label">
                                        Check-in hiện tại
                                    </span>

                                    <span
                                        class="status-badge"
                                        id="checkin_status_badge"
                                    >
                                        <span class="status-dot"></span>

                                        <span id="checkin_status_text"></span>
                                    </span>
                                </div>
                            </div>

                            <div class="money-summary">
                                <div class="money-summary-item">
                                    <span>Tổng tiền</span>

                                    <strong id="total_money_preview">
                                        0đ
                                    </strong>
                                </div>

                                <div class="money-summary-item">
                                    <span>Đã thanh toán</span>

                                    <strong id="paid_money_preview">
                                        0đ
                                    </strong>
                                </div>

                                <div class="money-summary-item remaining">
                                    <span>Còn lại</span>

                                    <strong id="remaining_money_preview">
                                        0đ
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-header">
                            <h3 class="section-title">
                                <span class="section-title-icon">
                                    <i class="fas fa-sticky-note"></i>
                                </span>

                                Yêu cầu và ghi chú
                            </h3>

                            <span class="section-badge">
                                Thông tin bổ sung
                            </span>
                        </div>

                        <div class="section-body">
                            <p class="section-description">
                                Ghi lại các yêu cầu đặc biệt và nội dung cần lưu
                                ý về khách hàng.
                            </p>

                            <div class="form-grid form-grid-two">
                                <div class="form-group-custom">
                                    <label
                                        for="yeu_cau_dac_biet"
                                        class="form-label"
                                    >
                                        Yêu cầu đặc biệt
                                    </label>

                                    <textarea
                                        name="yeu_cau_dac_biet"
                                        id="yeu_cau_dac_biet"
                                        class="form-control @error('yeu_cau_dac_biet') is-invalid @enderror"
                                        rows="5"
                                        placeholder="Ví dụ: Ăn chay, dị ứng thực phẩm, cần hỗ trợ đặc biệt..."
                                    >{{ old('yeu_cau_dac_biet', $khachHang->yeu_cau_dac_biet) }}</textarea>

                                    @error('yeu_cau_dac_biet')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group-custom">
                                    <label for="ghi_chu" class="form-label">
                                        Ghi chú
                                    </label>

                                    <textarea
                                        name="ghi_chu"
                                        id="ghi_chu"
                                        class="form-control @error('ghi_chu') is-invalid @enderror"
                                        rows="5"
                                        placeholder="Nhập ghi chú nội bộ về khách hàng..."
                                    >{{ old('ghi_chu', $khachHang->ghi_chu) }}</textarea>

                                    @error('ghi_chu')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a
                            href="{{ route('Admin.khach-hang.index') }}"
                            class="btn-form btn-cancel"
                        >
                            <i class="fas fa-times"></i>
                            Hủy
                        </a>

                        <button
                            type="submit"
                            class="btn-form btn-update-customer"
                        >
                            <i class="fas fa-save"></i>
                            Cập nhật khách hàng
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const paymentSelect =
                document.getElementById('trang_thai_thanh_toan');

            const checkInSelect =
                document.getElementById('trang_thai_check_in');

            const paymentBadge =
                document.getElementById('payment_status_badge');

            const paymentText =
                document.getElementById('payment_status_text');

            const checkInBadge =
                document.getElementById('checkin_status_badge');

            const checkInText =
                document.getElementById('checkin_status_text');

            const totalInput =
                document.getElementById('tong_tien');

            const paidInput =
                document.getElementById('so_tien_da_thanh_toan');

            const totalPreview =
                document.getElementById('total_money_preview');

            const paidPreview =
                document.getElementById('paid_money_preview');

            const remainingPreview =
                document.getElementById('remaining_money_preview');

            const paymentConfig = {
                chua_thanh_toan: {
                    text: 'Chưa thanh toán',
                    className: 'payment-unpaid'
                },
                da_coc: {
                    text: 'Đã đặt cọc',
                    className: 'payment-deposit'
                },
                thanh_toan_mot_phan: {
                    text: 'Thanh toán một phần',
                    className: 'payment-partial'
                },
                da_thanh_toan: {
                    text: 'Đã thanh toán',
                    className: 'payment-paid'
                },
                hoan_tien: {
                    text: 'Đã hoàn tiền',
                    className: 'payment-refund'
                },
                that_bai: {
                    text: 'Thanh toán thất bại',
                    className: 'payment-failed'
                }
            };

            const checkInConfig = {
                chua_check_in: {
                    text: 'Chưa check-in',
                    className: 'checkin-pending'
                },
                da_check_in: {
                    text: 'Đã check-in',
                    className: 'checkin-completed'
                }
            };

            function updatePaymentStatus() {
                if (
                    !paymentSelect
                    || !paymentBadge
                    || !paymentText
                ) {
                    return;
                }

                const config =
                    paymentConfig[paymentSelect.value]
                    || paymentConfig.chua_thanh_toan;

                paymentBadge.className =
                    'status-badge ' + config.className;

                paymentText.textContent = config.text;
            }

            function updateCheckInStatus() {
                if (
                    !checkInSelect
                    || !checkInBadge
                    || !checkInText
                ) {
                    return;
                }

                const config =
                    checkInConfig[checkInSelect.value]
                    || checkInConfig.chua_check_in;

                checkInBadge.className =
                    'status-badge ' + config.className;

                checkInText.textContent = config.text;
            }

            function parseMoney(value) {
                const number = Number(value);

                return Number.isFinite(number) && number > 0
                    ? number
                    : 0;
            }

            function formatMoney(value) {
                return new Intl.NumberFormat('vi-VN').format(value) + 'đ';
            }

            function updateMoneySummary() {
                const totalMoney = parseMoney(
                    totalInput ? totalInput.value : 0
                );

                const paidMoney = parseMoney(
                    paidInput ? paidInput.value : 0
                );

                const remainingMoney = Math.max(
                    totalMoney - paidMoney,
                    0
                );

                if (totalPreview) {
                    totalPreview.textContent =
                        formatMoney(totalMoney);
                }

                if (paidPreview) {
                    paidPreview.textContent =
                        formatMoney(paidMoney);
                }

                if (remainingPreview) {
                    remainingPreview.textContent =
                        formatMoney(remainingMoney);
                }
            }

            if (paymentSelect) {
                paymentSelect.addEventListener(
                    'change',
                    updatePaymentStatus
                );
            }

            if (checkInSelect) {
                checkInSelect.addEventListener(
                    'change',
                    updateCheckInStatus
                );
            }

            if (totalInput) {
                totalInput.addEventListener(
                    'input',
                    updateMoneySummary
                );
            }

            if (paidInput) {
                paidInput.addEventListener(
                    'input',
                    updateMoneySummary
                );
            }

            updatePaymentStatus();
            updateCheckInStatus();
            updateMoneySummary();
        });
    </script>
@endsection
