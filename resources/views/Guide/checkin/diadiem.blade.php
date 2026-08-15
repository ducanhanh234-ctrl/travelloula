@extends('Layouts.guide')
@section('title', 'Chọn địa điểm Check-in')
@section('guide', 'Chọn địa điểm Check-in')
@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('Guide.checkin.index') }}">Check-in</a>
    </li>

    <li class="breadcrumb-item active">Chọn địa điểm</li>
@endsection

@section('content')

    {{-- Thông báo lưu / lỗi validate --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-1"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="fw-bold mb-1">
                <i class="fas fa-exclamation-triangle me-1"></i>
                Không thể lưu thay đổi:
            </div>

            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <style>
        :root {
            --location-primary: #315be8;
            --location-primary-dark: #264ed4;
            --location-purple: #5b4dea;

            --location-dark: #173576;
            --location-text: #344563;
            --location-muted: #6b7895;
            --location-light: #98a2b3;

            --location-white: #ffffff;
            --location-soft: #f5f8ff;
            --location-hover: #f3f7ff;

            --location-border: #dce6f5;
            --location-border-light: #e8eef8;

            --location-success: #08754a;
            --location-success-bg: #eaf9f1;

            --location-warning: #ae6c0d;
            --location-warning-bg: #fff7e8;

            --location-danger: #c13d55;
            --location-danger-bg: #fff0f3;

            --location-info: #1975a8;
            --location-info-bg: #ebf8ff;
        }

        .location-page {
            padding: 4px 0 24px;
            color: var(--location-text);
        }

        /* Header */
        .location-page-header {
            margin-bottom: 20px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .location-page-heading {
            min-width: 0;

            display: flex;
            align-items: center;
            gap: 13px;
        }

        .location-page-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;

            color: var(--location-white);

            background: linear-gradient(135deg,
                    var(--location-primary),
                    var(--location-purple));

            border-radius: 12px;

            box-shadow:
                0 7px 18px rgba(49, 91, 232, 0.22);

            font-size: 18px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .location-page-heading h2 {
            margin: 0;

            color: var(--location-dark);
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -0.2px;
        }

        .location-page-heading p {
            margin: 5px 0 0;

            color: var(--location-muted);
            font-size: 13px;
        }

        .btn-location-back {
            min-height: 41px;
            padding: 9px 15px;

            color: #53698f;
            background: var(--location-white);

            border: 1px solid #ccd9ed;
            border-radius: 9px;

            font-size: 12px;
            font-weight: 700;
            text-decoration: none;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;

            transition:
                color 0.18s ease,
                background-color 0.18s ease,
                border-color 0.18s ease,
                transform 0.18s ease;
        }

        .btn-location-back:hover {
            color: var(--location-primary);
            background: var(--location-soft);
            border-color: #bfcff0;

            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Thông tin lịch */
        .location-info-card {
            position: relative;

            margin-bottom: 20px;

            overflow: hidden;

            background: var(--location-white);

            border: 1px solid var(--location-border);
            border-radius: 14px;

            box-shadow:
                0 7px 24px rgba(28, 65, 139, 0.08);
        }

        .location-info-card::before {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;

            height: 4px;
            content: "";

            background: linear-gradient(90deg,
                    var(--location-primary),
                    #3b79ee,
                    var(--location-purple));
        }

        .location-info-grid {
            padding: 23px 21px 19px;

            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .location-info-item {
            min-width: 0;
            padding: 14px;

            background: #fafcff;

            border: 1px solid var(--location-border);
            border-radius: 10px;

            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .location-info-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;

            color: var(--location-primary);
            background: #edf3ff;

            border: 1px solid #d4e2ff;
            border-radius: 9px;

            font-size: 12px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .location-info-content {
            min-width: 0;
        }

        .location-info-label {
            margin-bottom: 4px;

            color: var(--location-muted);
            font-size: 9px;
            font-weight: 750;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .location-info-value {
            color: #29457d;
            font-size: 12px;
            font-weight: 750;
            line-height: 1.55;
            overflow-wrap: anywhere;
        }

        /* Thống kê */
        .location-stats-grid {
            margin-bottom: 20px;

            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px;
        }

        .location-stat-card {
            position: relative;

            min-height: 120px;
            padding: 19px;

            overflow: hidden;

            background: var(--location-white);

            border: 1px solid var(--location-border);
            border-radius: 14px;

            box-shadow:
                0 7px 24px rgba(28, 65, 139, 0.08);

            display: flex;
            align-items: center;
            gap: 14px;

            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .location-stat-card:hover {
            box-shadow:
                0 10px 29px rgba(28, 65, 139, 0.13);

            transform: translateY(-2px);
        }

        .location-stat-card::after {
            position: absolute;
            right: -28px;
            bottom: -42px;

            width: 115px;
            height: 115px;

            content: "";

            background: rgba(49, 91, 232, 0.04);
            border-radius: 50%;
        }

        .location-stat-icon {
            position: relative;
            z-index: 2;

            width: 50px;
            height: 50px;
            flex-shrink: 0;

            border: 1px solid transparent;
            border-radius: 13px;

            font-size: 18px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .location-stat-day {
            color: var(--location-primary);
            background: #edf3ff;
            border-color: #d2e0ff;
        }

        .location-stat-place {
            color: var(--location-purple);
            background: #f1efff;
            border-color: #ded9ff;
        }

        .location-stat-content {
            position: relative;
            z-index: 2;
        }

        .location-stat-value {
            color: #203e78;
            font-size: 25px;
            font-weight: 800;
            line-height: 1.15;
        }

        .location-stat-label {
            margin-top: 5px;

            color: var(--location-muted);
            font-size: 11px;
            font-weight: 650;
        }

        /* Danh sách ngày */
        .location-day-card {
            margin-bottom: 18px;

            overflow: hidden;

            background: var(--location-white);

            border: 1px solid var(--location-border);
            border-radius: 14px;

            box-shadow:
                0 8px 26px rgba(28, 65, 139, 0.08);
        }

        .location-day-header {
            min-height: 61px;
            padding: 14px 18px;

            color: var(--location-white);

            background: linear-gradient(135deg,
                    var(--location-primary),
                    var(--location-purple));

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 13px;
        }

        .location-day-header-disabled {
            background: linear-gradient(135deg, #adb5bd, #6c757d) !important;
        }

        .location-day-title {
            font-size: 14px;
            font-weight: 750;

            display: inline-flex;
            align-items: center;
            gap: 9px;
        }

        .location-day-title-icon {
            width: 34px;
            height: 34px;
            flex-shrink: 0;

            color: var(--location-white);
            background: rgba(255, 255, 255, 0.14);

            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 9px;

            font-size: 12px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .location-day-count {
            padding: 5px 10px;

            color: var(--location-white);
            background: rgba(255, 255, 255, 0.15);

            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 999px;

            font-size: 9px;
            font-weight: 750;
            white-space: nowrap;
        }

        .location-day-body {
            padding: 17px;
        }

        /* Địa điểm */
        .location-place-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .location-place-card {
            position: relative;

            padding: 16px;

            overflow: hidden;

            background: #fafcff;

            border: 1px solid var(--location-border);
            border-radius: 11px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;

            transition:
                background-color 0.18s ease,
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.18s ease;
        }

        .location-place-card-disabled {
            background: #f8f9fa;
            border-color: #ced4da;
            opacity: .8;
        }

        .location-place-card-disabled::before {
            background: #6c757d;
        }

        .location-place-card-disabled .location-place-icon {
            background: #e9ecef;
            color: #6c757d;
            border-color: #ced4da;
        }

        .location-place-card-disabled .location-place-title {
            color: #6c757d;
        }

        .location-place-card:hover {
            background: var(--location-hover);
            border-color: #bdcff0;

            box-shadow:
                0 7px 19px rgba(28, 65, 139, 0.08);

            transform: translateY(-1px);
        }

        .location-place-card::before {
            position: absolute;
            top: 11px;
            bottom: 11px;
            left: 0;

            width: 3px;
            content: "";

            background: linear-gradient(180deg,
                    var(--location-primary),
                    var(--location-purple));

            border-radius: 0 5px 5px 0;
        }

        .location-place-main {
            min-width: 0;

            display: flex;
            align-items: center;
            gap: 12px;
        }

        .location-place-icon {
            width: 43px;
            height: 43px;
            flex-shrink: 0;

            color: var(--location-primary);
            background: #edf3ff;

            border: 1px solid #d3e1ff;
            border-radius: 11px;

            font-size: 14px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .location-place-content {
            min-width: 0;
        }

        .location-place-title {
            margin: 0 0 5px;

            color: #233f7a;
            font-size: 13px;
            font-weight: 750;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .location-place-time {
            color: var(--location-muted);
            font-size: 10px;
            font-weight: 650;

            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .location-place-time i {
            color: var(--location-primary);
        }

        .location-place-action {
            flex-shrink: 0;
        }

        .btn-location-checkin {
            min-height: 37px;
            padding: 8px 13px;

            color: var(--location-white);

            background: linear-gradient(135deg,
                    var(--location-primary),
                    var(--location-purple));

            border: 1px solid var(--location-primary);
            border-radius: 8px;

            box-shadow:
                0 5px 13px rgba(49, 91, 232, 0.2);

            font-size: 10px;
            font-weight: 750;
            white-space: nowrap;
            text-decoration: none;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;

            transition:
                color 0.18s ease,
                background-color 0.18s ease,
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.18s ease;
        }

        .btn-location-checkin:hover {
            color: var(--location-white);

            background: linear-gradient(135deg,
                    var(--location-primary-dark),
                    #4c40d7);

            border-color: var(--location-primary-dark);

            box-shadow:
                0 7px 16px rgba(49, 91, 232, 0.27);

            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-location-checkin.disabled,
        .btn-location-checkin:disabled {
            background: #adb5bd !important;
            border-color: #adb5bd !important;
            cursor: not-allowed;
            opacity: .7;
            pointer-events: none;
        }

        .btn-closed {
            background: #dc3545 !important;
            color: #fff;
        }

        .btn-location-checkin-bu {
            color: #8a5a00;
            background: var(--location-warning-bg);
            border-color: #efd79f;
            box-shadow: 0 5px 13px rgba(174, 108, 13, 0.14);
        }

        .btn-location-checkin-bu:hover {
            color: var(--location-white);
            background: #dc941e;
            border-color: #dc941e;
            box-shadow: 0 7px 16px rgba(174, 108, 13, 0.22);
        }

        .btn-location-checkin.btn-success {
            color: #ffffff;
            background: #198754;
            border-color: #198754;
            box-shadow: 0 5px 13px rgba(25, 135, 84, 0.18);
        }

        .btn-location-checkin.btn-success:hover {
            color: #ffffff;
            background: #157347;
            border-color: #146c43;
            box-shadow: 0 7px 16px rgba(25, 135, 84, 0.24);
        }

        .btn-location-change {
            color: #6b4ca5;
            background: #f5f0ff;
            border-color: #ded2f5;
            box-shadow: none;
        }

        .btn-location-change:hover {
            color: #ffffff;
            background: #6f42c1;
            border-color: #6f42c1;
        }

        .location-change-badge {
            margin-top: 7px;
            padding: 5px 8px;
            color: #6b4ca5;
            background: #f5f0ff;
            border: 1px solid #ded2f5;
            border-radius: 7px;
            font-size: 9px;
            font-weight: 750;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .location-cancelled-badge {
            color: #9b2c3f;
            background: #fff0f3;
            border-color: #f0c9d1;
        }

        .schedule-change-modal .modal-content {
            border: 1px solid var(--location-border);
            border-radius: 14px;
            overflow: hidden;
        }

        .schedule-change-modal .modal-header {
            color: #ffffff;
            background: linear-gradient(135deg, var(--location-primary), var(--location-purple));
            border-bottom: none;
        }

        /* Empty */
        .location-empty {
            padding: 35px 20px;

            color: var(--location-muted);
            text-align: center;
        }

        .location-empty-icon {
            width: 50px;
            height: 50px;
            margin: 0 auto 11px;

            color: var(--location-warning);
            background: var(--location-warning-bg);

            border: 1px solid #f1dba9;
            border-radius: 13px;

            font-size: 18px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .location-empty-title {
            color: #506181;
            font-size: 13px;
            font-weight: 750;
        }

        .location-empty-text {
            margin-top: 3px;

            color: #8b97aa;
            font-size: 11px;
        }

        @media (max-width: 992px) {
            .location-info-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .location-page-header {
                align-items: stretch;
                flex-direction: column;
            }

            .location-page-heading h2 {
                font-size: 20px;
            }

            .btn-location-back {
                width: 100%;
            }

            .location-stats-grid {
                grid-template-columns: 1fr;
            }

            .location-day-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .location-place-card {
                align-items: stretch;
                flex-direction: column;
            }

            .location-place-action,
            .btn-location-checkin {
                width: 100%;
            }
        }
    </style>

    @php
        $lichTrinhTours = $lichKhoiHanh->tour->lichTrinhTours ?? collect();
        $tongNgayThamQuan = $lichTrinhTours->count();
        $tongDiaDiem = $lichTrinhTours->sum(function ($ngay) {
            return $ngay->chiTiets->count(); });
    @endphp

    <div class="location-page fade-in">
        {{-- Header --}}
        <div class="location-page-header">
            <div class="location-page-heading">
                <span class="location-page-icon">
                    <i class="fas fa-route"></i>
                </span>

                <div>
                    <h2>Chọn địa điểm Check-in</h2>
                    <p>{{$lichKhoiHanh->tour->ten_tour ?? 'Không xác định'}}</p>
                </div>
            </div>

            <a href="{{ route('Guide.checkin.index') }}" class="btn-location-back">
                <i class="fas fa-arrow-left"></i>
                Quay lại
            </a>
        </div>

        {{-- Thông tin lịch khởi hành --}}
        <div class="location-info-card">
            <div class="location-info-grid">
                <div class="location-info-item">
                    <span class="location-info-icon">
                        <i class="fas fa-plane-departure"></i>
                    </span>

                    <div class="location-info-content">
                        <div class="location-info-label">Ngày khởi hành</div>

                        <div class="location-info-value">
                            @if ($lichKhoiHanh->ngay_khoi_hanh)
                                {{\Carbon\Carbon::parse($lichKhoiHanh->ngay_khoi_hanh)->format('d/m/Y')}}
                            @else
                                Chưa cập nhật
                            @endif
                        </div>
                    </div>
                </div>

                <div class="location-info-item">
                    <span class="location-info-icon">
                        <i class="fas fa-flag-checkered"></i>
                    </span>

                    <div class="location-info-content">
                        <div class="location-info-label">Ngày kết thúc</div>
                        <div class="location-info-value">
                            @if ($lichKhoiHanh->ngay_ket_thuc)
                                {{\Carbon\Carbon::parse($lichKhoiHanh->ngay_ket_thuc)->format('d/m/Y')}}
                            @else
                                Chưa cập nhật
                            @endif
                        </div>
                    </div>
                </div>

                <div class="location-info-item">
                    <span class="location-info-icon"><i class="fas fa-user-tie"></i></span>

                    <div class="location-info-content">
                        <div class="location-info-label">Hướng dẫn viên</div>

                        <div class="location-info-value">
                            {{$lichKhoiHanh->huongDanVien->ho_ten ?? 'Chưa phân công'}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Thống kê --}}
        <div class="location-stats-grid">
            <div class="location-stat-card">
                <span class="location-stat-icon location-stat-day">
                    <i class="fas fa-calendar-day"></i>
                </span>

                <div class="location-stat-content">
                    <div class="location-stat-value">
                        {{ $tongNgayThamQuan }}
                    </div>

                    <div class="location-stat-label">Ngày tham quan</div>
                </div>
            </div>

            <div class="location-stat-card">
                <span class="location-stat-icon location-stat-place">
                    <i class="fas fa-map-marker-alt"></i>
                </span>

                <div class="location-stat-content">
                    <div class="location-stat-value">
                        {{ $tongDiaDiem }}
                    </div>

                    <div class="location-stat-label">Tổng địa điểm</div>
                </div>
            </div>
        </div>
        <div class="location-day-card">
            <div class="location-day-header {{ $departureCanCheckIn ? '' : 'location-day-header-disabled' }}">
                <div class="location-day-title">
                    <span class="location-day-title-icon">
                        <i class="fas fa-calendar-day"></i>
                    </span>
                    Checkin Khởi Hành
                </div>

                <span class="location-day-count">1 địa điểm</span>
            </div>

            <div class="location-day-body">
                <div class="location-place-list">
                    <div class="location-place-card {{ $departureCanCheckIn ? '' : 'location-place-card-disabled' }}">
                        <div class="location-place-main">
                            <span class="location-place-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>

                            <div class="location-place-content">
                                <h5 class="location-place-title">Lúc khởi hành</h5>
                            </div>
                        </div>

                        <div class="location-place-action">
                            @if($departureDone)
                                <a href="{{ route('Guide.checkin.xuatPhat', $lichKhoiHanh->id) }}"
                                    class="btn-location-checkin btn-success">
                                    <i class="fas fa-check-circle"></i>
                                    Đã check-in
                                </a>

                            @elseif($departureExpired)
                                <a href="{{ route('Guide.checkin.xuatPhat', $lichKhoiHanh->id) }}"
                                    class="btn-location-checkin btn-closed">
                                    <i class="fas fa-lock"></i>
                                    Đã đóng
                                </a>

                            @elseif($departureCanCheckIn)
                                <a href="{{ route('Guide.checkin.xuatPhat', $lichKhoiHanh->id) }}" class="btn-location-checkin">
                                    <i class="fas fa-user-check"></i>
                                    Check-in
                                </a>

                            @else
                                <button class="btn-location-checkin disabled" disabled>
                                    <i class="fas fa-clock"></i>
                                    Chưa đến giờ
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Danh sách lịch trình --}}
        @forelse ($lichTrinhTours as $ngay)
            <div class="location-day-card">
                <div class="location-day-header">
                    <div class="location-day-title">
                        <span class="location-day-title-icon">
                            <i class="fas fa-calendar-day"></i>
                        </span>

                        Ngày {{ $ngay->ngay_thu }}
                    </div>

                    <span class="location-day-count">{{ $ngay->chiTiets->count() }} địa điểm</span>
                </div>

                <div class="location-day-body">
                    @if ($ngay->chiTiets->isNotEmpty())
                        <div class="location-place-list">
                            @php
                                $status = $dayStatus[$ngay->ngay_thu] ?? [
                                    'done' => false,
                                    'locked' => false,
                                ];
                            @endphp

                            @foreach ($ngay->chiTiets as $chiTiet)
                                @php
                                    $windowPreview = $activityWindows[$chiTiet->id] ?? [];
                                    $previewChange = $windowPreview['schedule_change'] ?? null;
                                    $previewCancelled = $windowPreview['cancelled'] ?? false;

                                    $previewTitle = $windowPreview['display_title']
                                        ?? ($chiTiet->tieu_de ?? 'Địa điểm chưa có tên');

                                    $previewStart = $windowPreview['display_start_time']
                                        ?? $chiTiet->gio_bat_dau;

                                    $previewEnd = $windowPreview['display_end_time']
                                        ?? $chiTiet->gio_ket_thuc;
                                @endphp

                                <div class="location-place-card {{ $previewCancelled ? 'location-place-card-disabled' : '' }}">
                                    <div class="location-place-main">
                                        <span class="location-place-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span>

                                        <div class="location-place-content">
                                            <h5 class="location-place-title">
                                                {{ $previewTitle }}
                                            </h5>

                                            <div class="location-place-time">
                                                <i class="fas fa-clock"></i>
                                                <span>
                                                    {{ $previewStart ?? '--:--' }}
                                                    -
                                                    {{ $previewEnd ?? '--:--' }}
                                                </span>
                                            </div>

                                            @if ($previewChange)
                                                <div class="location-change-badge {{ $previewCancelled ? 'location-cancelled-badge' : '' }}">
                                                    <i class="fas {{ $previewCancelled ? 'fa-ban' : 'fa-pen' }}"></i>

                                                    @if ($previewCancelled)
                                                        Đã hủy hoạt động
                                                    @elseif ($previewChange->loai_thay_doi === 'doi_gio')
                                                        Đã đổi giờ
                                                    @else
                                                        Lịch đã thay đổi
                                                    @endif
                                                </div>

                                                <div class="location-empty-text">
                                                    Lý do: {{ $previewChange->ly_do }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="location-place-action">
                                        @php
                                            $window = $activityWindows[$chiTiet->id] ?? [];

                                            $canCheckIn = $window['can_checkin'] ?? false;
                                            $canCheckInBu = $window['can_checkin_bu'] ?? false;
                                            $expired = $window['expired'] ?? false;

                                            $activityStatus = $window['status'] ?? 'pending';
                                            $hasCheckedIn = $window['has_checked_in'] ?? false;
                                            $completed = $window['completed'] ?? false;

                                            $checkedInCount = $window['checked_in_count'] ?? 0;
                                            $checkedOutCount = $window['checked_out_count'] ?? 0;
                                            $totalGuests = $window['total_guests'] ?? 0;

                                            $scheduleChange = $window['schedule_change'] ?? null;
                                            $cancelled = $window['cancelled'] ?? false;
                                        @endphp

                                        @if($cancelled || $activityStatus === 'cancelled')
                                            <button type="button"
                                                class="btn-location-checkin btn-closed"
                                                disabled>
                                                <i class="fas fa-ban"></i>
                                                Đã hủy
                                            </button>

                                        @elseif($completed || $activityStatus === 'completed')
                                            {{-- Tất cả khách đã Check-out --}}
                                            <a href="{{ route('Guide.checkin.show', [
                                                'lichKhoiHanh' => $lichKhoiHanh->id,
                                                'chiTiet' => $chiTiet->id,
                                            ]) }}"
                                                class="btn-location-checkin btn-success"
                                                title="Tất cả khách đã Check-out">
                                                <i class="fas fa-check-double"></i>
                                                Hoàn thành
                                            </a>

                                        @elseif($hasCheckedIn || $activityStatus === 'checked_in')
                                            {{-- Đã có khách Check-in: không hiện lại nút Check-in --}}
                                            <a href="{{ route('Guide.checkin.show', [
                                                'lichKhoiHanh' => $lichKhoiHanh->id,
                                                'chiTiet' => $chiTiet->id,
                                            ]) }}"
                                                class="btn-location-checkin btn-success"
                                                title="Đã Check-in {{ $checkedInCount }}/{{ $totalGuests }} khách">
                                                <i class="fas fa-user-check"></i>
                                                Đã Check-in
                                            </a>

                                        @elseif($canCheckIn)
                                            {{-- Đang trong khung giờ và chưa có Check-in --}}
                                            <a href="{{ route('Guide.checkin.show', [
                                                'lichKhoiHanh' => $lichKhoiHanh->id,
                                                'chiTiet' => $chiTiet->id,
                                            ]) }}"
                                                class="btn-location-checkin">
                                                <i class="fas fa-user-check"></i>
                                                Check-in
                                            </a>

                                        @elseif($canCheckInBu || $expired)
                                            {{-- Hết giờ nhưng chưa hoàn thành: cho phép Check-in bù --}}
                                            <a href="{{ route('Guide.checkin.show', [
                                                'lichKhoiHanh' => $lichKhoiHanh->id,
                                                'chiTiet' => $chiTiet->id,
                                            ]) }}"
                                                class="btn-location-checkin btn-location-checkin-bu"
                                                title="Hoạt động đã kết thúc - mở danh sách để Check-in bù">
                                                <i class="fas fa-history"></i>
                                                Check-in bù
                                            </a>

                                        @else
                                            {{-- Chưa tới khung giờ --}}
                                            <button type="button"
                                                class="btn-location-checkin disabled"
                                                disabled
                                                title="Chưa đến giờ check-in">
                                                <i class="fas fa-clock"></i>
                                                Chưa đến giờ
                                            </button>
                                        @endif

                                        <button type="button"
                                            class="btn-location-checkin btn-location-change mt-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#thayDoiLichModal{{ $chiTiet->id }}">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ $scheduleChange ? 'Sửa thay đổi' : 'Thay đổi lịch' }}
                                        </button>

                                        @if ($scheduleChange)
                                            <form action="{{ route('Guide.checkin.khoiPhucLichTrinh', [
                                                'lichKhoiHanh' => $lichKhoiHanh->id,
                                                'chiTiet' => $chiTiet->id,
                                            ]) }}" method="POST" class="mt-2"
                                                onsubmit="return confirm('Khôi phục hoạt động này về lịch tour gốc?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="btn-location-checkin"
                                                    style="background:#64748b;border-color:#64748b;">
                                                    <i class="fas fa-rotate-left"></i>
                                                    Khôi phục lịch gốc
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>

                                <div class="modal fade schedule-change-modal"
                                    id="thayDoiLichModal{{ $chiTiet->id }}"
                                    tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('Guide.checkin.thayDoiLichTrinh', [
                                                'lichKhoiHanh' => $lichKhoiHanh->id,
                                                'chiTiet' => $chiTiet->id,
                                            ]) }}" method="POST">
                                                @csrf

                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-calendar-alt me-2"></i>
                                                        Thay đổi lịch hoạt động
                                                    </h5>
                                                    <button type="button"
                                                        class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="alert alert-info">
                                                        Thay đổi này chỉ áp dụng cho chuyến hiện tại.
                                                        Lịch tour gốc không bị sửa.
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">
                                                            Hoạt động gốc
                                                        </label>
                                                        <div class="form-control bg-light">
                                                            {{ $chiTiet->tieu_de }}
                                                            ({{ $chiTiet->gio_bat_dau }} - {{ $chiTiet->gio_ket_thuc }})
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">
                                                            Loại thay đổi
                                                        </label>

                                                        <select name="loai_thay_doi"
                                                            class="form-select schedule-change-type"
                                                            data-target="{{ $chiTiet->id }}"
                                                            required>
                                                            <option value="thay_the"
                                                                {{ $scheduleChange && $scheduleChange->loai_thay_doi === 'thay_the' ? 'selected' : '' }}>
                                                                Thay bằng hoạt động khác
                                                            </option>

                                                            <option value="doi_gio"
                                                                {{ $scheduleChange && $scheduleChange->loai_thay_doi === 'doi_gio' ? 'selected' : '' }}>
                                                                Chỉ đổi giờ
                                                            </option>

                                                            <option value="huy"
                                                                {{ $scheduleChange && $scheduleChange->loai_thay_doi === 'huy' ? 'selected' : '' }}>
                                                                Hủy hoạt động
                                                            </option>
                                                        </select>
                                                    </div>

                                                    <div class="schedule-fields-{{ $chiTiet->id }}">
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">
                                                                Tên hoạt động thực tế
                                                            </label>

                                                            <input type="text"
                                                                name="tieu_de_moi"
                                                                class="form-control"
                                                                value="{{ old('tieu_de_moi', $scheduleChange?->tieu_de_moi ?? $chiTiet->tieu_de) }}"
                                                                placeholder="Ví dụ: Nghỉ ngơi tại khách sạn">
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-semibold">
                                                                    Giờ bắt đầu mới
                                                                </label>

                                                                <input type="time"
                                                                    name="gio_bat_dau_moi"
                                                                    class="form-control"
                                                                    value="{{ old(
                                                                        'gio_bat_dau_moi',
                                                                        !empty($scheduleChange?->gio_bat_dau_moi)
                                                                            ? \Carbon\Carbon::parse($scheduleChange->gio_bat_dau_moi)->format('H:i')
                                                                            : (!empty($chiTiet->gio_bat_dau)
                                                                                ? \Carbon\Carbon::parse($chiTiet->gio_bat_dau)->format('H:i')
                                                                                : '')
                                                                    ) }}">
                                                            </div>

                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label fw-semibold">
                                                                    Giờ kết thúc mới
                                                                </label>

                                                                <input type="time"
                                                                    name="gio_ket_thuc_moi"
                                                                    class="form-control"
                                                                    value="{{ old(
                                                                        'gio_ket_thuc_moi',
                                                                        !empty($scheduleChange?->gio_ket_thuc_moi)
                                                                            ? \Carbon\Carbon::parse($scheduleChange->gio_ket_thuc_moi)->format('H:i')
                                                                            : (!empty($chiTiet->gio_ket_thuc)
                                                                                ? \Carbon\Carbon::parse($chiTiet->gio_ket_thuc)->format('H:i')
                                                                                : '')
                                                                    ) }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label fw-semibold">
                                                            Lý do <span class="text-danger">*</span>
                                                        </label>

                                                        <textarea name="ly_do"
                                                            class="form-control"
                                                            rows="4"
                                                            maxlength="1000"
                                                            required
                                                            placeholder="Ví dụ: Cả đoàn quá mệt và thống nhất nghỉ ngơi...">{{ old('ly_do', $scheduleChange?->ly_do ?? '') }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                        Hủy
                                                    </button>

                                                    <button type="submit"
                                                        class="btn btn-primary">
                                                        <i class="fas fa-save me-1"></i>
                                                        Lưu thay đổi
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @if($status['done'])
                            <div class="location-place-card mt-3">
                                <div class="location-place-main">
                                    <span class="location-place-icon">
                                        <i class="fas fa-flag-checkered"></i>
                                    </span>

                                    <div class="location-place-content">
                                        <h5 class="location-place-title">Chốt check-in ngày {{ $ngay->ngay_thu }}</h5>
                                    </div>
                                </div>

    <div class="location-place-action">
        @if($status['locked'])
            <button class="btn-location-checkin btn-success" disabled>
                Đã chốt
            </button>
        @else
            <form action="{{ route('Guide.checkin.saveLock', $lichKhoiHanh->id) }}" method="POST">
                @csrf
                <input type="hidden" name="ngay_thu" value="{{ $ngay->ngay_thu }}">
                <input type="hidden" name="action" value="CONFIRM_KET_THUC_NGAY">

                <button type="submit" class="btn-location-checkin">
                    Chốt ngày
                </button>
            </form>
        @endif
    </div>
</div>
@endif

                        </div>

                    @else
                        <div class="location-empty">
                            <div class="location-empty-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>

                            <div class="location-empty-title">Chưa có địa điểm</div>
                            <div class="location-empty-text">Ngày tham quan này chưa có địa điểm Check-in.</div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="location-day-card">
                <div class="location-empty">
                    <div class="location-empty-icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <div class="location-empty-title">Chưa có lịch trình</div>
                    <div class="location-empty-text">Tour này chưa được thiết lập lịch trình và địa điểm Check-in.</div>
                </div>
            </div>
        @endforelse

        <div class="location-day-card">
            <div class="location-day-header {{ $finishCanCheckIn ? '' : 'location-day-header-disabled' }}">
                <div class="location-day-title">
                    <span class="location-day-title-icon">
                        <i class="fas fa-calendar-day"></i>
                    </span>
                    Checkin Kết Thúc
                </div>

                <span class="location-day-count">1 địa điểm</span>
            </div>

            <div class="location-day-body">
                <div class="location-place-list">
                    <div class="location-place-card {{ $finishCanCheckIn ? '' : 'location-place-card-disabled' }}">
                        <div class="location-place-main">
                            <span class="location-place-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </span>

                            <div class="location-place-content">
                                <h5 class="location-place-title">Lúc Kết Thúc</h5>
                            </div>
                        </div>

                        @if($finishDone)

    <button class="btn-location-checkin btn-success" disabled>
        <i class="fas fa-lock"></i>
        Đã chốt
    </button>


@elseif($finishCanCheckIn)

    <form action="{{ route('Guide.checkin.finishTour', $lichKhoiHanh->id) }}" method="POST">
    @csrf

    <button type="submit" class="btn-location-checkin">
        <i class="fas fa-check"></i>
        Xác nhận kết thúc tour
    </button>
</form>


@else

    <button class="btn-location-checkin disabled" disabled>
        <i class="fas fa-clock"></i>
        Chưa đến giờ
    </button>

@endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function syncScheduleFields(select) {
                const id = select.dataset.target;
                const fields = document.querySelector('.schedule-fields-' + id);

                if (!fields) {
                    return;
                }

                fields.style.display = select.value === 'huy' ? 'none' : '';
            }

            document.querySelectorAll('.schedule-change-type').forEach(function (select) {
                syncScheduleFields(select);

                select.addEventListener('change', function () {
                    syncScheduleFields(this);
                });
            });
        });
    </script>
@endsection
