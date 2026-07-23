@extends('Layouts.guide')

@section('title', 'Chọn địa điểm Check-in')

@section('guide', 'Chọn địa điểm Check-in')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('Guide.checkin.index') }}">
        Check-in
    </a>
</li>

<li class="breadcrumb-item active">
    Chọn địa điểm
</li>
@endsection

@section('content')
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
$lichTrinhTours =
$lichKhoiHanh->tour->lichTrinhTours
?? collect();

$tongNgayThamQuan =
$lichTrinhTours->count();

$tongDiaDiem =
$lichTrinhTours->sum(function ($ngay) {
return $ngay->chiTiets->count();
});
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

                <p>
                    {{
                            $lichKhoiHanh->tour->ten_tour
                            ?? 'Không xác định'
                        }}
                </p>
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
                    <div class="location-info-label">
                        Ngày khởi hành
                    </div>

                    <div class="location-info-value">
                        @if ($lichKhoiHanh->ngay_khoi_hanh)
                        {{
                                    \Carbon\Carbon::parse(
                                        $lichKhoiHanh->ngay_khoi_hanh
                                    )->format('d/m/Y')
                                }}
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
                    <div class="location-info-label">
                        Ngày kết thúc
                    </div>

                    <div class="location-info-value">
                        @if ($lichKhoiHanh->ngay_ket_thuc)
                        {{
                                    \Carbon\Carbon::parse(
                                        $lichKhoiHanh->ngay_ket_thuc
                                    )->format('d/m/Y')
                                }}
                        @else
                        Chưa cập nhật
                        @endif
                    </div>
                </div>
            </div>

            <div class="location-info-item">
                <span class="location-info-icon">
                    <i class="fas fa-user-tie"></i>
                </span>

                <div class="location-info-content">
                    <div class="location-info-label">
                        Hướng dẫn viên
                    </div>

                    <div class="location-info-value">
                        {{
                                $lichKhoiHanh
                                    ->huongDanVien
                                    ->ho_ten
                                ?? 'Chưa phân công'
                            }}
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

                <div class="location-stat-label">
                    Ngày tham quan
                </div>
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

                <div class="location-stat-label">
                    Tổng địa điểm
                </div>
            </div>
        </div>
    </div>
    <div class="location-day-card">
        <div class="location-day-header">
            <div class="location-day-title">
                <span class="location-day-title-icon">
                    <i class="fas fa-calendar-day"></i>
                </span>

                Checkin Khởi Hành
            </div>

            <span class="location-day-count">
                1 địa điểm
            </span>
        </div>

        <div class="location-day-body">

            <div class="location-place-list">

                <div class="location-place-card">
                    <div class="location-place-main">
                        <span class="location-place-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>

                        <div class="location-place-content">
                            <h5 class="location-place-title">
                                Lúc khởi hành
                            </h5>


                        </div>
                    </div>

                    <div class="location-place-action">
                        <a href="{{ route(
    'Guide.checkin.xuatPhat',
    $lichKhoiHanh->id
) }}" class="btn-location-checkin">
                            <i class="fas fa-user-check"></i>
                            Check-in
                        </a>
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

            <span class="location-day-count">
                {{ $ngay->chiTiets->count() }} địa điểm
            </span>
        </div>

        <div class="location-day-body">
            @if ($ngay->chiTiets->isNotEmpty())
            <div class="location-place-list">
                @foreach ($ngay->chiTiets as $chiTiet)
                <div class="location-place-card">
                    <div class="location-place-main">
                        <span class="location-place-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>

                        <div class="location-place-content">
                            <h5 class="location-place-title">
                                {{
                                                    $chiTiet->tieu_de
                                                    ?? 'Địa điểm chưa có tên'
                                                }}
                            </h5>

                            <div class="location-place-time">
                                <i class="fas fa-clock"></i>

                                <span>
                                    {{
                                                        $chiTiet->gio_bat_dau
                                                        ?? '--:--'
                                                    }}

                                    -

                                    {{
                                                        $chiTiet->gio_ket_thuc
                                                        ?? '--:--'
                                                    }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="location-place-action">
                        @if ($ngay->ngay_thu == 1 && ! $lichKhoiHanh->da_checkin_khoi_hanh)
                        @if($firstDayOneActivity && $firstDayOneActivity->id === $chiTiet->id && $departureCanCheckIn)
                        <a href="{{ route('Guide.checkin.xuatPhat', $lichKhoiHanh->id) }}" class="btn-location-checkin" title="Check-in khởi hành">
                            <i class="fas fa-user-check"></i>
                            Check-in
                        </a>
                        @else
                        @if($departureExpired)
                        <a href="{{ route('Guide.checkin.xuatPhat', $lichKhoiHanh->id) }}" class="btn-location-checkin" title="Đã đóng">
                            <i class="fas fa-user-check"></i>
                            Đã đóng
                        </a>
                        @else
                        <button type="button" class="btn-location-checkin" disabled title="Chưa đến giờ check-in xuất phát">
                            <i class="fas fa-user-check"></i>
                            Chưa đến giờ
                        </button>
                        @endif
                        @endif
                        @else
                        @php $expired = $activityWindows[$chiTiet->id]['expired'] ?? false; @endphp
                        @if($activityWindows[$chiTiet->id]['can_checkin'] ?? false)
                        <a href="{{ route(
                                    'Guide.checkin.show',
                                    [
                                        'lichKhoiHanh' => $lichKhoiHanh->id,
                                        'chiTiet' => $chiTiet->id,
                                    ]
                                ) }}" class="btn-location-checkin">
                            <i class="fas fa-user-check"></i>
                            Check-in
                        </a>
                        @else
                        @if($expired)
                        <a href="{{ route(
                                    'Guide.checkin.show',
                                    [
                                        'lichKhoiHanh' => $lichKhoiHanh->id,
                                        'chiTiet' => $chiTiet->id,
                                    ]
                                ) }}" class="btn-location-checkin" title="Đã đóng">
                            <i class="fas fa-user-check"></i>
                            Đã đóng
                        </a>
                        @else
                        <button type="button" class="btn-location-checkin" disabled title="Chưa đến giờ check-in">
                            <i class="fas fa-user-check"></i>
                            Chưa đến giờ
                        </button>
                        @endif
                        @endif
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="location-empty">
                <div class="location-empty-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>

                <div class="location-empty-title">
                    Chưa có địa điểm
                </div>

                <div class="location-empty-text">
                    Ngày tham quan này chưa có địa điểm Check-in.
                </div>
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

            <div class="location-empty-title">
                Chưa có lịch trình
            </div>

            <div class="location-empty-text">
                Tour này chưa được thiết lập lịch trình và địa điểm Check-in.
            </div>
        </div>
    </div>
    @endforelse
</div>
@endsection
