@extends('Layouts.admin')

@section('title', 'Sửa lịch trình')

@section('content')
    <style>
        :root {
            --schedule-primary: #315be8;
            --schedule-primary-dark: #244bd2;
            --schedule-primary-light: #edf4ff;
            --schedule-purple: #5b4dea;

            --schedule-text-dark: #172b4d;
            --schedule-text-main: #344563;
            --schedule-text-muted: #6b7895;
            --schedule-text-light: #98a2b3;

            --schedule-border: #dce6f5;
            --schedule-border-light: #e8eef8;

            --schedule-white: #ffffff;
            --schedule-soft-bg: #f6f9ff;

            --schedule-danger: #dc4c64;
        }

        .schedule-edit-page {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 24px 0;
            color: var(--schedule-text-dark);
        }

        /* Header trang */
        .schedule-page-top {
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .schedule-page-heading h3 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .schedule-page-heading p {
            margin: 6px 0 0;
            color: var(--schedule-text-muted);
            font-size: 14px;
        }

        .schedule-tour-name {
            color: var(--schedule-primary);
            font-weight: 750;
        }

        .btn-back-top {
            min-height: 40px;
            padding: 8px 15px;
            color: #2c57d1;
            background: var(--schedule-primary-light);
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
        .schedule-form-card {
            position: relative;
            overflow: hidden;
            background: var(--schedule-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 10px 32px rgba(28, 65, 139, 0.11);
        }

        .schedule-form-card::before {
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
        .schedule-form-header {
            position: relative;
            min-height: 150px;
            padding: 28px 30px;
            overflow: hidden;
            color: var(--schedule-white);
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

        .schedule-form-header::before {
            position: absolute;
            right: -60px;
            bottom: -125px;
            width: 280px;
            height: 280px;
            content: "";
            border: 23px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .schedule-form-header::after {
            position: absolute;
            top: -100px;
            right: 125px;
            width: 195px;
            height: 195px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .schedule-header-content {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .schedule-header-icon {
            width: 58px;
            height: 58px;
            flex-shrink: 0;
            color: var(--schedule-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.32);
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(20, 43, 128, 0.2);
            font-size: 21px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .schedule-header-info {
            min-width: 0;
        }

        .schedule-header-info h4 {
            margin: 0;
            color: var(--schedule-white);
            font-size: 22px;
            font-weight: 750;
        }

        .schedule-header-info p {
            margin: 7px 0 0;
            overflow: hidden;
            color: rgba(255, 255, 255, 0.84);
            font-size: 13px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .schedule-header-info p i {
            margin-right: 6px;
        }

        .schedule-day-box {
            position: relative;
            z-index: 2;
            min-width: 105px;
            padding: 13px 16px;
            color: var(--schedule-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.26);
            border-radius: 12px;
            text-align: center;
            backdrop-filter: blur(5px);
        }

        .schedule-day-box strong {
            display: block;
            font-size: 21px;
            line-height: 1;
        }

        .schedule-day-box span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.84;
        }

        /* Nội dung */
        .schedule-form-body {
            padding: 30px;
        }

        .tour-summary {
            margin-bottom: 26px;
            padding: 14px 16px;
            background: var(--schedule-soft-bg);
            border: 1px solid var(--schedule-border);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .tour-summary-main {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tour-summary-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            color: var(--schedule-primary);
            background: var(--schedule-white);
            border: 1px solid #cfe0ff;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .tour-summary-content {
            min-width: 0;
        }

        .tour-summary-content span {
            display: block;
            color: #7c899f;
            font-size: 10px;
            font-weight: 650;
        }

        .tour-summary-content strong {
            display: block;
            margin-top: 3px;
            overflow: hidden;
            color: #29457d;
            font-size: 13px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .tour-summary-code {
            padding: 5px 9px;
            color: #3158ce;
            background: var(--schedule-white);
            border: 1px solid #ccdcf7;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* Section */
        .form-section-title {
            margin-bottom: 20px;
            color: #24417d;
            font-size: 14px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-section-title::before {
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

        .form-section-title i {
            color: #426ce0;
        }

        .form-description {
            margin: -12px 0 20px;
            color: #7f8ba1;
            font-size: 12px;
            line-height: 1.6;
        }

        /* Grid */
        .schedule-form-grid {
            display: grid;
            grid-template-columns: 180px minmax(0, 1fr);
            gap: 20px;
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
            color: var(--schedule-danger);
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

        .schedule-edit-page .form-control {
            width: 100%;
            min-height: 44px;
            padding: 10px 13px 10px 38px;
            color: var(--schedule-text-main);
            background: var(--schedule-white);
            border: 1px solid #cfdaec;
            border-radius: 9px;
            font-size: 14px;
            box-shadow: none;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                background-color 0.18s ease;
        }

        .schedule-edit-page .form-control::placeholder {
            color: #a4aec1;
        }

        .schedule-edit-page .form-control:hover {
            border-color: #b6c9e8;
        }

        .schedule-edit-page .form-control:focus {
            color: #24375c;
            background: var(--schedule-white);
            border-color: #4f78eb;
            outline: none;
            box-shadow: 0 0 0 4px rgba(49, 91, 232, 0.11);
        }

        .schedule-edit-page .form-control[readonly] {
            color: #596b8e;
            background: #f2f6fc;
            border-color: #d8e2f0;
            cursor: not-allowed;
        }

        .schedule-edit-page textarea.form-control {
            min-height: 145px;
            padding-top: 13px;
            line-height: 1.7;
            resize: vertical;
        }

        .textarea-wrapper .input-icon {
            top: 17px;
            transform: none;
        }

        .schedule-edit-page .form-control.is-invalid {
            border-color: var(--schedule-danger);
            background-image: none;
        }

        .schedule-edit-page .form-control.is-invalid:focus {
            border-color: var(--schedule-danger);
            box-shadow: 0 0 0 4px rgba(220, 76, 100, 0.1);
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

        .error-text {
            margin-top: 7px;
            color: #cf3f58;
            font-size: 12px;
            font-weight: 550;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Thông tin bổ sung */
        .additional-section {
            margin-top: 30px;
            padding-top: 27px;
            border-top: 1px solid var(--schedule-border-light);
        }

        /* Nút */
        .form-actions {
            margin-top: 30px;
            padding-top: 23px;
            border-top: 1px solid var(--schedule-border-light);
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

        .btn-update-schedule {
            color: var(--schedule-white);
            background: linear-gradient(
                135deg,
                #315be8 0%,
                #3b6dee 55%,
                #594bea 100%
            );
            border-color: #315be8;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.24);
        }

        .btn-update-schedule:hover {
            color: var(--schedule-white);
            background: linear-gradient(
                135deg,
                #264ed4 0%,
                #315edc 55%,
                #4d40d8 100%
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
            box-shadow: 0 5px 13px rgba(41, 73, 132, 0.1);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .schedule-edit-page {
                padding: 15px 0;
            }

            .schedule-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-back-top {
                width: 100%;
            }

            .schedule-form-card {
                border-radius: 11px;
            }

            .schedule-form-header {
                min-height: 130px;
                padding: 23px 20px;
                align-items: flex-start;
                flex-direction: column;
            }

            .schedule-form-body {
                padding: 22px 18px;
            }

            .schedule-form-grid {
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
            .schedule-page-heading h3 {
                font-size: 20px;
            }

            .schedule-header-content {
                align-items: flex-start;
            }

            .schedule-header-icon {
                width: 50px;
                height: 50px;
                border-radius: 13px;
            }

            .schedule-header-info h4 {
                font-size: 19px;
            }

            .schedule-header-info p {
                max-width: 230px;
            }

            .tour-summary {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <div class="container-fluid schedule-edit-page">
        <div class="schedule-page-top">
            <div class="schedule-page-heading">
                <h3>Sửa lịch trình Tour</h3>

                <p>
                    Cập nhật lịch trình của Tour:
                    <span class="schedule-tour-name">
                        {{ $lichTrinh->tour->ten_tour }}
                    </span>
                </p>
            </div>

            <a
                href="{{ route('Admin.lich_trinh_tours.index') }}"
                class="btn-back-top"
            >
                <i class="fas fa-arrow-left"></i>
                Quay lại danh sách
            </a>
        </div>

        <div class="schedule-form-card">
            <div class="schedule-form-header">
                <div class="schedule-header-content">
                    <span class="schedule-header-icon">
                        <i class="fas fa-edit"></i>
                    </span>

                    <div class="schedule-header-info">
                        <h4>Chỉnh sửa ngày lịch trình</h4>

                        <p>
                            <i class="fas fa-route"></i>
                            {{ $lichTrinh->tour->ten_tour }}
                        </p>
                    </div>
                </div>

                <div class="schedule-day-box">
                    <strong>{{ $lichTrinh->ngay_thu }}</strong>
                    <span>Ngày lịch trình</span>
                </div>
            </div>

            <div class="schedule-form-body">
                <div class="tour-summary">
                    <div class="tour-summary-main">
                        <span class="tour-summary-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </span>

                        <div class="tour-summary-content">
                            <span>Tour đang chỉnh sửa lịch trình</span>

                            <strong title="{{ $lichTrinh->tour->ten_tour }}">
                                {{ $lichTrinh->tour->ten_tour }}
                            </strong>
                        </div>
                    </div>

                    <span class="tour-summary-code">
                        Tour #{{ $lichTrinh->tour_id }}
                    </span>
                </div>

                <form
                    action="{{ route('Admin.lich_trinh_tours.update', ['lich_trinh_tour' => $lichTrinh->id]) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    <input
                        type="hidden"
                        name="tour_id"
                        value="{{ $lichTrinh->tour_id }}"
                    >

                    <div class="form-section-title">
                        <i class="fas fa-list-alt"></i>
                        Thông tin lịch trình
                    </div>

                    <p class="form-description">
                        Chỉnh sửa thứ tự ngày, tiêu đề, địa điểm và nội dung hoạt
                        động của lịch trình.
                    </p>

                    <div class="schedule-form-grid">
                        <div class="form-group-custom full-width">
                            <label for="tour_name" class="form-label">
                                Tour
                            </label>

                            <div class="input-wrapper">
                                <i class="fas fa-route input-icon"></i>

                                <input
                                    type="text"
                                    id="tour_name"
                                    class="form-control"
                                    value="{{ $lichTrinh->tour->ten_tour }}"
                                    readonly
                                >
                            </div>

                            <div class="form-hint">
                                <i class="fas fa-info-circle"></i>
                                <span>
                                    Không thể thay đổi Tour của lịch trình này.
                                </span>
                            </div>
                        </div>

                        <div class="form-group-custom">
                            <label for="ngay_thu" class="form-label">
                                Ngày thứ
                                <span class="required-mark">*</span>
                            </label>

                            <div class="input-wrapper">
                                <i class="fas fa-calendar-day input-icon"></i>

                                <input
                                    type="number"
                                    name="ngay_thu"
                                    id="ngay_thu"
                                    class="form-control @error('ngay_thu') is-invalid @enderror"
                                    value="{{ old('ngay_thu', $lichTrinh->ngay_thu) }}"
                                    placeholder="Ví dụ: 1"
                                    min="1"
                                    required
                                >
                            </div>

                            @error('ngay_thu')
                                <div class="error-text">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group-custom">
                            <label for="tieu_de" class="form-label">
                                Tiêu đề
                                <span class="required-mark">*</span>
                            </label>

                            <div class="input-wrapper">
                                <i class="fas fa-heading input-icon"></i>

                                <input
                                    type="text"
                                    name="tieu_de"
                                    id="tieu_de"
                                    class="form-control @error('tieu_de') is-invalid @enderror"
                                    value="{{ old('tieu_de', $lichTrinh->tieu_de) }}"
                                    placeholder="Nhập tiêu đề lịch trình"
                                    required
                                >
                            </div>

                            @error('tieu_de')
                                <div class="error-text">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group-custom full-width">
                            <label for="dia_diem" class="form-label">
                                Địa điểm
                                <span class="required-mark">*</span>
                            </label>

                            <div class="input-wrapper">
                                <i class="fas fa-map-marker-alt input-icon"></i>

                                <input
                                    type="text"
                                    name="dia_diem"
                                    id="dia_diem"
                                    class="form-control @error('dia_diem') is-invalid @enderror"
                                    value="{{ old('dia_diem', $lichTrinh->dia_diem) }}"
                                    placeholder="Nhập địa điểm chính trong ngày"
                                    required
                                >
                            </div>

                            @error('dia_diem')
                                <div class="error-text">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group-custom full-width">
                            <label for="hoat_dong" class="form-label">
                                Hoạt động
                                <span class="required-mark">*</span>
                            </label>

                            <div class="input-wrapper textarea-wrapper">
                                <i class="fas fa-list-alt input-icon"></i>

                                <textarea
                                    name="hoat_dong"
                                    id="hoat_dong"
                                    rows="6"
                                    class="form-control @error('hoat_dong') is-invalid @enderror"
                                    placeholder="Mô tả các hoạt động trong ngày..."
                                    required
                                >{{ old('hoat_dong', $lichTrinh->hoat_dong) }}</textarea>
                            </div>

                            @error('hoat_dong')
                                <div class="error-text">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="additional-section">
                        <div class="form-section-title">
                            <i class="fas fa-concierge-bell"></i>
                            Dịch vụ trong ngày
                        </div>

                        <p class="form-description">
                            Cập nhật thông tin bữa ăn và khách sạn trong ngày
                            lịch trình.
                        </p>

                        <div class="schedule-form-grid">
                            <div class="form-group-custom">
                                <label for="bua_an" class="form-label">
                                    Bữa ăn
                                </label>

                                <div class="input-wrapper">
                                    <i class="fas fa-utensils input-icon"></i>

                                    <input
                                        type="text"
                                        name="bua_an"
                                        id="bua_an"
                                        class="form-control @error('bua_an') is-invalid @enderror"
                                        value="{{ old('bua_an', $lichTrinh->bua_an) }}"
                                        placeholder="Ví dụ: Sáng, trưa, tối"
                                    >
                                </div>

                                @error('bua_an')
                                    <div class="error-text">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group-custom">
                                <label
                                    for="thong_tin_khach_san"
                                    class="form-label"
                                >
                                    Thông tin khách sạn
                                </label>

                                <div class="input-wrapper">
                                    <i class="fas fa-hotel input-icon"></i>

                                    <input
                                        type="text"
                                        name="thong_tin_khach_san"
                                        id="thong_tin_khach_san"
                                        class="form-control @error('thong_tin_khach_san') is-invalid @enderror"
                                        value="{{ old('thong_tin_khach_san', $lichTrinh->thong_tin_khach_san) }}"
                                        placeholder="Nhập tên hoặc thông tin khách sạn"
                                    >
                                </div>

                                @error('thong_tin_khach_san')
                                    <div class="error-text">
                                        <i class="fas fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a
                            href="{{ route('Admin.lich_trinh_tours.index') }}"
                            class="btn-form btn-cancel"
                        >
                            <i class="fas fa-times"></i>
                            Quay lại
                        </a>

                        <button
                            type="submit"
                            class="btn-form btn-update-schedule"
                        >
                            <i class="fas fa-save"></i>
                            Cập nhật lịch trình
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
