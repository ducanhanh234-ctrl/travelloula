@extends('layouts.admin')

@section('title', 'Cập nhật lịch khởi hành')

@section('content')
    @php
        $selectedTourId = old('tour_id', $item->tour_id);
        $selectedStatus = old('trang_thai', $item->trang_thai);

        $ngayKhoiHanh = old(
            'ngay_khoi_hanh',
            $item->ngay_khoi_hanh
                ? \Carbon\Carbon::parse($item->ngay_khoi_hanh)->format('Y-m-d')
                : ''
        );

        $ngayKetThuc = old(
            'ngay_ket_thuc',
            $item->ngay_ket_thuc
                ? \Carbon\Carbon::parse($item->ngay_ket_thuc)->format('Y-m-d')
                : ''
        );

        $selectedTour = $tours->firstWhere('id', $selectedTourId);

        /*
        |--------------------------------------------------------------------------
        | Dữ liệu chỉ hiển thị
        |--------------------------------------------------------------------------
        | Các giá trị này được lấy từ bảng khác thông qua model/accessor/relation.
        | Không gửi lại trong form cập nhật lịch khởi hành.
        */
        $soChoHienThi = $item->so_cho ?? 0;
        $giaNguoiLonHienThi = $item->gia_nguoi_lon ?? 0;
        $giaTreEmHienThi = $item->gia_tre_em ?? 0;
    @endphp

    <style>
        :root {
            --departure-primary: #315be8;
            --departure-primary-dark: #244bd2;
            --departure-primary-light: #edf4ff;
            --departure-purple: #5b4dea;

            --departure-text-dark: #172b4d;
            --departure-text-main: #344563;
            --departure-text-muted: #6b7895;

            --departure-border: #dce6f5;
            --departure-border-light: #e8eef8;

            --departure-white: #ffffff;
            --departure-soft: #f6f9ff;

            --departure-success: #08754a;
            --departure-success-bg: #eaf9f1;

            --departure-danger: #c13d55;
            --departure-danger-bg: #fff0f3;
        }

        .departure-edit-page {
            width: 100%;
            max-width: 1050px;
            margin: 0 auto;
            padding: 24px 0;
            color: var(--departure-text-dark);
        }

        .departure-page-top {
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .departure-page-heading h3 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
        }

        .departure-page-heading p {
            margin: 6px 0 0;
            color: var(--departure-text-muted);
            font-size: 14px;
        }

        .btn-back-top {
            min-height: 40px;
            padding: 8px 15px;
            color: #2c57d1;
            background: var(--departure-primary-light);
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

        .departure-form-card {
            position: relative;
            overflow: hidden;
            background: var(--departure-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 10px 32px rgba(28, 65, 139, 0.11);
        }

        .departure-form-card::before {
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

        .departure-form-header {
            position: relative;
            min-height: 155px;
            padding: 28px 30px;
            overflow: hidden;
            color: var(--departure-white);
            background: linear-gradient(
                120deg,
                #2856df 0%,
                #316cec 55%,
                #5b49e8 100%
            );
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 22px;
        }

        .departure-form-header::before {
            position: absolute;
            right: -60px;
            bottom: -125px;
            width: 280px;
            height: 280px;
            content: "";
            border: 23px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .departure-form-header::after {
            position: absolute;
            top: -100px;
            right: 125px;
            width: 195px;
            height: 195px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .departure-header-content {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .departure-header-icon {
            width: 58px;
            height: 58px;
            flex-shrink: 0;
            color: var(--departure-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.32);
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(20, 43, 128, 0.2);
            font-size: 21px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .departure-header-info {
            min-width: 0;
        }

        .departure-header-info h4 {
            margin: 0;
            color: var(--departure-white);
            font-size: 22px;
            font-weight: 750;
        }

        .departure-header-info p {
            margin: 7px 0 0;
            max-width: 580px;
            overflow: hidden;
            color: rgba(255, 255, 255, 0.84);
            font-size: 13px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .departure-header-info p i {
            margin-right: 6px;
        }

        .departure-id-box {
            position: relative;
            z-index: 2;
            min-width: 112px;
            padding: 13px 16px;
            color: var(--departure-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.26);
            border-radius: 12px;
            text-align: center;
        }

        .departure-id-box strong {
            display: block;
            font-size: 21px;
            line-height: 1;
        }

        .departure-id-box span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.84;
        }

        .departure-form-body {
            padding: 30px;
        }

        .validation-alert {
            margin-bottom: 24px;
            padding: 15px 17px;
            color: #a23449;
            background: var(--departure-danger-bg);
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

        .departure-summary {
            margin-bottom: 26px;
            padding: 14px 16px;
            background: var(--departure-soft);
            border: 1px solid var(--departure-border);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .departure-summary-main {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .departure-summary-icon {
            width: 37px;
            height: 37px;
            flex-shrink: 0;
            color: var(--departure-primary);
            background: var(--departure-white);
            border: 1px solid #cfe0ff;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .departure-summary-content {
            min-width: 0;
        }

        .departure-summary-content span {
            display: block;
            color: #7c899f;
            font-size: 10px;
            font-weight: 650;
        }

        .departure-summary-content strong {
            display: block;
            margin-top: 3px;
            overflow: hidden;
            color: #29457d;
            font-size: 13px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .departure-summary-code {
            padding: 5px 9px;
            color: #3158ce;
            background: var(--departure-white);
            border: 1px solid #ccdcf7;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .form-section {
            margin-bottom: 28px;
            overflow: hidden;
            background: var(--departure-white);
            border: 1px solid var(--departure-border);
            border-radius: 12px;
        }

        .form-section:last-of-type {
            margin-bottom: 0;
        }

        .section-header {
            min-height: 58px;
            padding: 14px 17px;
            background: #f1f6ff;
            border-bottom: 1px solid var(--departure-border);
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
            background: var(--departure-white);
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
            background: var(--departure-white);
            border: 1px solid #ccdcf7;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 750;
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

        .departure-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .form-group-custom {
            min-width: 0;
        }

        .form-group-custom.full-width {
            grid-column: 1 / -1;
        }

        .form-label-custom {
            margin-bottom: 8px;
            color: #31456f;
            font-size: 13px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 5px;
        }

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

        .departure-edit-page .form-control,
        .departure-edit-page .form-select {
            width: 100%;
            min-height: 44px;
            padding: 10px 13px;
            color: var(--departure-text-main);
            background: var(--departure-white);
            border: 1px solid #cfdaec;
            border-radius: 9px;
            font-size: 14px;
            box-shadow: none;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .departure-edit-page .input-wrapper .form-control,
        .departure-edit-page .input-wrapper .form-select {
            padding-left: 38px;
        }

        .departure-edit-page .form-control:hover,
        .departure-edit-page .form-select:hover {
            border-color: #b6c9e8;
        }

        .departure-edit-page .form-control:focus,
        .departure-edit-page .form-select:focus {
            color: #24375c;
            background: var(--departure-white);
            border-color: #4f78eb;
            outline: none;
            box-shadow: 0 0 0 4px rgba(49, 91, 232, 0.11);
        }

        .departure-edit-page .form-control[readonly] {
            color: #536584;
            background: #f2f6fc;
            border-color: #d8e2f0;
            cursor: not-allowed;
        }

        .readonly-field {
            font-weight: 700;
        }

        .error-text {
            margin-top: 7px;
            color: #cf3f58;
            font-size: 12px;
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

        .readonly-notice {
            margin-bottom: 18px;
            padding: 12px 14px;
            color: #40537a;
            background: #f5f8ff;
            border: 1px solid #d8e4f6;
            border-left: 4px solid #315be8;
            border-radius: 9px;
            font-size: 12px;
            line-height: 1.6;
            display: flex;
            align-items: flex-start;
            gap: 9px;
        }

        .readonly-notice i {
            margin-top: 2px;
            color: #315be8;
        }

        .status-preview {
            margin-top: 14px;
            padding: 12px 14px;
            background: #f8faff;
            border: 1px solid var(--departure-border);
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
            border-radius: 50%;
            background: currentColor;
        }

        .status-available {
            color: var(--departure-success);
            background: var(--departure-success-bg);
            border-color: #c5ead8;
        }

        .status-cancelled {
            color: var(--departure-danger);
            background: var(--departure-danger-bg);
            border-color: #f0c9d1;
        }

        .form-actions {
            margin-top: 30px;
            padding-top: 23px;
            border-top: 1px solid var(--departure-border-light);
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

        .btn-update-departure {
            color: var(--departure-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #3b6dee 55%,
                #594bea
            );
            border-color: #315be8;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.24);
        }

        .btn-update-departure:hover {
            color: var(--departure-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #315edc 55%,
                #4d40d8
            );
            border-color: #264ed4;
            box-shadow: 0 8px 19px rgba(49, 91, 232, 0.3);
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
        }

        @media (max-width: 768px) {
            .departure-edit-page {
                padding: 15px 0;
            }

            .departure-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-back-top {
                width: 100%;
            }

            .departure-form-header {
                min-height: 130px;
                padding: 23px 20px;
                align-items: flex-start;
                flex-direction: column;
            }

            .departure-form-body {
                padding: 22px 18px;
            }

            .departure-form-grid {
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
            .departure-page-heading h3 {
                font-size: 20px;
            }

            .departure-header-content {
                align-items: flex-start;
            }

            .departure-header-icon {
                width: 50px;
                height: 50px;
            }

            .departure-header-info h4 {
                font-size: 19px;
            }

            .departure-summary {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <div class="container-fluid departure-edit-page">
        <div class="departure-page-top">
            <div class="departure-page-heading">
                <h3>Cập nhật lịch khởi hành</h3>

                <p>
                    Cập nhật Tour, thời gian và trạng thái lịch khởi hành.
                </p>
            </div>

            <a
                href="{{ route('Admin.lich-khoi-hanh.index') }}"
                class="btn-back-top"
            >
                <i class="fas fa-arrow-left"></i>
                Quay lại danh sách
            </a>
        </div>

        <div class="departure-form-card">
            <div class="departure-form-header">
                <div class="departure-header-content">
                    <span class="departure-header-icon">
                        <i class="fas fa-edit"></i>
                    </span>

                    <div class="departure-header-info">
                        <h4>Chỉnh sửa lịch khởi hành</h4>

                        <p>
                            <i class="fas fa-plane-departure"></i>

                            {{ $selectedTour->ten_tour
                                ?? $item->tour->ten_tour
                                ?? 'Chưa xác định Tour' }}
                        </p>
                    </div>
                </div>

                <div class="departure-id-box">
                    <strong>#{{ $item->id }}</strong>
                    <span>Mã lịch khởi hành</span>
                </div>
            </div>

            <div class="departure-form-body">
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

                <div class="departure-summary">
                    <div class="departure-summary-main">
                        <span class="departure-summary-icon">
                            <i class="fas fa-route"></i>
                        </span>

                        <div class="departure-summary-content">
                            <span>Tour hiện tại</span>

                            <strong id="selected_tour_name">
                                {{ $selectedTour->ten_tour
                                    ?? $item->tour->ten_tour
                                    ?? 'Chưa xác định Tour' }}
                            </strong>
                        </div>
                    </div>

                    <span class="departure-summary-code">
                        Lịch #{{ $item->id }}
                    </span>
                </div>

                <form
                    method="POST"
                    action="{{ route('Admin.lich-khoi-hanh.update', $item->id) }}"
                >
                    @csrf
                    @method('PUT')

                    {{-- TOUR VÀ THỜI GIAN --}}
                    <div class="form-section">
                        <div class="section-header">
                            <h3 class="section-title">
                                <span class="section-title-icon">
                                    <i class="fas fa-route"></i>
                                </span>

                                Tour và thời gian
                            </h3>

                            <span class="section-badge">
                                Thông tin chính
                            </span>
                        </div>

                        <div class="section-body">
                            <p class="section-description">
                                Chọn Tour và cập nhật ngày khởi hành. Ngày kết
                                thúc được tính tự động theo thời lượng Tour.
                            </p>

                            <div class="departure-form-grid">
                                <div class="form-group-custom full-width">
                                    <label
                                        for="tour_id"
                                        class="form-label-custom"
                                    >
                                        Tour
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-map-marked-alt input-icon"></i>

                                        <select
                                            name="tour_id"
                                            id="tour_id"
                                            class="form-select @error('tour_id') is-invalid @enderror"
                                        >
                                            @foreach ($tours as $tour)
                                                <option
                                                    value="{{ $tour->id }}"
                                                    data-thoi-luong="{{ $tour->thoi_luong }}"
                                                    data-tour-name="{{ $tour->ten_tour }}"
                                                    data-so-cho="{{ $tour->so_cho ?? '' }}"
                                                    data-gia-nguoi-lon="{{ $tour->gia_nguoi_lon ?? $tour->gia_tour ?? '' }}"
                                                    data-gia-tre-em="{{ $tour->gia_tre_em ?? '' }}"
                                                    @selected(
                                                        (string) $selectedTourId
                                                        === (string) $tour->id
                                                    )
                                                >
                                                    {{ $tour->ten_tour }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @error('tour_id')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group-custom">
                                    <label
                                        for="ngay_khoi_hanh"
                                        class="form-label-custom"
                                    >
                                        Ngày khởi hành
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-calendar-alt input-icon"></i>

                                        <input
                                            type="date"
                                            id="ngay_khoi_hanh"
                                            name="ngay_khoi_hanh"
                                            class="form-control @error('ngay_khoi_hanh') is-invalid @enderror"
                                            value="{{ $ngayKhoiHanh }}"
                                        >
                                    </div>

                                    @error('ngay_khoi_hanh')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group-custom">
                                    <label
                                        for="ngay_ket_thuc"
                                        class="form-label-custom"
                                    >
                                        Ngày kết thúc
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-calendar-check input-icon"></i>

                                        <input
                                            type="date"
                                            id="ngay_ket_thuc"
                                            name="ngay_ket_thuc"
                                            class="form-control @error('ngay_ket_thuc') is-invalid @enderror"
                                            value="{{ $ngayKetThuc }}"
                                            readonly
                                        >
                                    </div>

                                    <div class="form-hint">
                                        <i class="fas fa-info-circle"></i>

                                        <span>
                                            Được tính tự động theo thời lượng
                                            của Tour.
                                        </span>
                                    </div>

                                    @error('ngay_ket_thuc')
                                        <div class="error-text">
                                            <i class="fas fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SỐ CHỖ VÀ GIÁ CHỈ HIỂN THỊ --}}
                    <div class="form-section">
                        <div class="section-header">
                            <h3 class="section-title">
                                <span class="section-title-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </span>

                                Số chỗ và giá Tour
                            </h3>

                            <span class="section-badge">
                                Chỉ xem
                            </span>
                        </div>

                        <div class="section-body">
                            <div class="readonly-notice">
                                <i class="fas fa-info-circle"></i>

                                <span>
                                    Số chỗ và giá được lấy từ bảng dữ liệu khác.
                                    Trang này chỉ hiển thị và không cập nhật các
                                    giá trị đó.
                                </span>
                            </div>

                            <div class="departure-form-grid">
                                <div class="form-group-custom full-width">
                                    <label
                                        for="so_cho_hien_thi"
                                        class="form-label-custom"
                                    >
                                        Số chỗ
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-chair input-icon"></i>

                                        <input
                                            type="text"
                                            id="so_cho_hien_thi"
                                            class="form-control readonly-field"
                                            value="{{ number_format($soChoHienThi, 0, ',', '.') }}"
                                            readonly
                                        >
                                    </div>

                                    <div class="form-hint">
                                        <i class="fas fa-database"></i>

                                        <span>
                                            Dữ liệu được lấy tự động từ bảng
                                            nguồn.
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group-custom">
                                    <label
                                        for="gia_nguoi_lon_hien_thi"
                                        class="form-label-custom"
                                    >
                                        Giá người lớn
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-money-bill-wave input-icon"></i>

                                        <input
                                            type="text"
                                            id="gia_nguoi_lon_hien_thi"
                                            class="form-control readonly-field"
                                            value="{{ number_format($giaNguoiLonHienThi, 0, ',', '.') }} VNĐ"
                                            readonly
                                        >
                                    </div>
                                </div>

                                <div class="form-group-custom">
                                    <label
                                        for="gia_tre_em_hien_thi"
                                        class="form-label-custom"
                                    >
                                        Giá trẻ em
                                    </label>

                                    <div class="input-wrapper">
                                        <i class="fas fa-coins input-icon"></i>

                                        <input
                                            type="text"
                                            id="gia_tre_em_hien_thi"
                                            class="form-control readonly-field"
                                            value="{{ number_format($giaTreEmHienThi, 0, ',', '.') }} VNĐ"
                                            readonly
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TRẠNG THÁI --}}
                    <div class="form-section">
                        <div class="section-header">
                            <h3 class="section-title">
                                <span class="section-title-icon">
                                    <i class="fas fa-check-circle"></i>
                                </span>

                                Trạng thái lịch khởi hành
                            </h3>

                            <span class="section-badge">
                                Vận hành
                            </span>
                        </div>

                        <div class="section-body">
                            <div class="form-group-custom">
                                <label
                                    for="trang_thai"
                                    class="form-label-custom"
                                >
                                    Trạng thái
                                </label>

                                <div class="input-wrapper">
                                    <i class="fas fa-check-circle input-icon"></i>

                                    <select
                                        name="trang_thai"
                                        id="trang_thai"
                                        class="form-select @error('trang_thai') is-invalid @enderror"
                                    >
                                        <option
                                            value="available"
                                            @selected($selectedStatus === 'available')
                                        >
                                            Mở bán
                                        </option>

                                        <option
                                            value="cancelled"
                                            @selected($selectedStatus === 'cancelled')
                                        >
                                            Đã hủy
                                        </option>
                                    </select>
                                </div>

                                @error('trang_thai')
                                    <div class="error-text">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror

                                <div class="status-preview">
                                    <span class="status-preview-label">
                                        Trạng thái đang chọn
                                    </span>

                                    <span
                                        class="status-badge"
                                        id="status_preview"
                                    >
                                        <span class="status-dot"></span>

                                        <span id="status_preview_text"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a
                            href="{{ route('Admin.lich-khoi-hanh.index') }}"
                            class="btn-form btn-cancel"
                        >
                            <i class="fas fa-times"></i>
                            Hủy
                        </a>

                        <button
                            type="submit"
                            class="btn-form btn-update-departure"
                        >
                            <i class="fas fa-save"></i>
                            Cập nhật lịch khởi hành
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('admin-assets/js/lich-khoi-hanh.js') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tourSelect =
                    document.getElementById('tour_id');

                const selectedTourName =
                    document.getElementById('selected_tour_name');

                const seatInput =
                    document.getElementById('so_cho_hien_thi');

                const adultPriceInput =
                    document.getElementById('gia_nguoi_lon_hien_thi');

                const childPriceInput =
                    document.getElementById('gia_tre_em_hien_thi');

                const statusSelect =
                    document.getElementById('trang_thai');

                const statusPreview =
                    document.getElementById('status_preview');

                const statusPreviewText =
                    document.getElementById('status_preview_text');

                function formatNumber(value) {
                    const numberValue = Number(value);

                    if (!Number.isFinite(numberValue)) {
                        return value || '0';
                    }

                    return new Intl.NumberFormat('vi-VN').format(
                        numberValue
                    );
                }

                function updateTourInformation() {
                    if (!tourSelect) {
                        return;
                    }

                    const selectedOption =
                        tourSelect.options[tourSelect.selectedIndex];

                    if (!selectedOption) {
                        return;
                    }

                    if (selectedTourName) {
                        selectedTourName.textContent =
                            selectedOption.dataset.tourName
                            || selectedOption.textContent.trim();
                    }

                    /*
                    | Chỉ đổi thông tin khi option có dữ liệu.
                    | Các input không có name nên không được gửi về server.
                    */
                    if (
                        seatInput
                        && selectedOption.dataset.soCho !== ''
                    ) {
                        seatInput.value = formatNumber(
                            selectedOption.dataset.soCho
                        );
                    }

                    if (
                        adultPriceInput
                        && selectedOption.dataset.giaNguoiLon !== ''
                    ) {
                        adultPriceInput.value =
                            formatNumber(
                                selectedOption.dataset.giaNguoiLon
                            ) + ' VNĐ';
                    }

                    if (
                        childPriceInput
                        && selectedOption.dataset.giaTreEm !== ''
                    ) {
                        childPriceInput.value =
                            formatNumber(
                                selectedOption.dataset.giaTreEm
                            ) + ' VNĐ';
                    }
                }

                function updateStatusPreview() {
                    if (
                        !statusSelect
                        || !statusPreview
                        || !statusPreviewText
                    ) {
                        return;
                    }

                    if (statusSelect.value === 'cancelled') {
                        statusPreview.className =
                            'status-badge status-cancelled';

                        statusPreviewText.textContent = 'Đã hủy';
                        return;
                    }

                    statusPreview.className =
                        'status-badge status-available';

                    statusPreviewText.textContent = 'Mở bán';
                }

                if (tourSelect) {
                    tourSelect.addEventListener(
                        'change',
                        updateTourInformation
                    );
                }

                if (statusSelect) {
                    statusSelect.addEventListener(
                        'change',
                        updateStatusPreview
                    );
                }

                updateTourInformation();
                updateStatusPreview();
            });
        </script>
    @endpush
@endsection
