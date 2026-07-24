@extends('layouts.guide')

@section('title', 'Chi tiết Tour')

@section('guide', 'Chi tiết Tour')

@section('page-title', 'Chi tiết Tour')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('Guide.tour-phan-cong.index') }}">
        Tour được phân công
    </a>
</li>

<li class="breadcrumb-item active">
    Chi tiết Tour
</li>
@endsection

@section('content')
<style>
    :root {
        --tour-detail-primary: #315be8;
        --tour-detail-primary-dark: #264ed4;
        --tour-detail-purple: #5b4dea;

        --tour-detail-dark: #173576;
        --tour-detail-text: #344563;
        --tour-detail-muted: #6b7895;
        --tour-detail-light: #98a2b3;

        --tour-detail-white: #ffffff;
        --tour-detail-soft: #f5f8ff;
        --tour-detail-hover: #f3f7ff;

        --tour-detail-border: #dce6f5;
        --tour-detail-border-light: #e8eef8;

        --tour-detail-success: #08754a;
        --tour-detail-success-bg: #eaf9f1;

        --tour-detail-warning: #ae6c0d;
        --tour-detail-warning-bg: #fff7e8;

        --tour-detail-danger: #c13d55;
        --tour-detail-danger-bg: #fff0f3;

        --tour-detail-info: #1975a8;
        --tour-detail-info-bg: #ebf8ff;
    }

    .tour-detail-page {
        padding: 4px 0 24px;
        color: var(--tour-detail-text);
    }

    /* Header */
    .tour-detail-header {
        margin-bottom: 20px;

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .tour-detail-heading {
        min-width: 0;

        display: flex;
        align-items: center;
        gap: 13px;
    }

    .tour-detail-heading-icon {
        width: 48px;
        height: 48px;
        flex-shrink: 0;

        color: var(--tour-detail-white);

        background: linear-gradient(135deg,
                var(--tour-detail-primary),
                var(--tour-detail-purple));

        border-radius: 12px;

        box-shadow:
            0 7px 18px rgba(49, 91, 232, 0.22);

        font-size: 18px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .tour-detail-heading h2 {
        margin: 0;

        color: var(--tour-detail-dark);
        font-size: 23px;
        font-weight: 800;
        letter-spacing: -0.2px;
    }

    .tour-detail-heading p {
        margin: 5px 0 0;

        color: var(--tour-detail-muted);
        font-size: 13px;
    }

    .btn-tour-detail-back {
        min-height: 41px;
        padding: 9px 15px;

        color: #53698f;
        background: var(--tour-detail-white);

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

    .btn-tour-detail-back:hover {
        color: var(--tour-detail-primary);
        background: var(--tour-detail-soft);
        border-color: #bfcff0;

        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Layout */
    .tour-detail-layout {
        display: grid;
        grid-template-columns:
            minmax(0, 2fr) minmax(300px, 0.9fr);
        gap: 20px;
        align-items: start;
    }

    .tour-detail-main,
    .tour-detail-sidebar {
        min-width: 0;
    }

    /* Card */
    .tour-detail-card {
        margin-bottom: 20px;

        overflow: hidden;

        background: var(--tour-detail-white);
        border: 1px solid var(--tour-detail-border);
        border-radius: 15px;

        box-shadow:
            0 8px 28px rgba(28, 65, 139, 0.09);
    }

    .tour-detail-card:last-child {
        margin-bottom: 0;
    }

    .tour-detail-card-header {
        min-height: 64px;
        padding: 16px 18px;

        color: #24417d;
        background: #f1f6ff;
        border-bottom: 1px solid var(--tour-detail-border);

        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }

    .tour-detail-card-title {
        min-width: 0;

        display: flex;
        align-items: center;
        gap: 10px;
    }

    .tour-detail-card-title-icon {
        width: 37px;
        height: 37px;
        flex-shrink: 0;

        color: var(--tour-detail-primary);
        background: #e7efff;

        border: 1px solid #cfdfff;
        border-radius: 9px;

        font-size: 13px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .tour-detail-card-title h3,
    .tour-detail-card-title h4 {
        margin: 0;

        color: #24417d;
        font-size: 15px;
        font-weight: 780;
        line-height: 1.5;
    }

    .tour-detail-card-title p {
        margin: 3px 0 0;

        color: var(--tour-detail-muted);
        font-size: 10px;
    }

    .tour-detail-card-body {
        padding: 20px;
    }

    /* Trạng thái */
    .tour-detail-status {
        padding: 6px 11px;

        color: var(--tour-detail-success);
        background: var(--tour-detail-success-bg);

        border: 1px solid #c5ead8;
        border-radius: 999px;

        font-size: 9px;
        font-weight: 800;
        white-space: nowrap;

        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .tour-detail-status-dot {
        width: 6px;
        height: 6px;

        background: currentColor;
        border-radius: 50%;
    }

    /* Thông tin */
    .tour-detail-info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .tour-detail-info-item {
        min-width: 0;
        padding: 14px;

        background: #fafcff;
        border: 1px solid var(--tour-detail-border);
        border-radius: 10px;

        display: flex;
        align-items: flex-start;
        gap: 10px;

        transition:
            border-color 0.18s ease,
            background-color 0.18s ease,
            transform 0.18s ease;
    }

    .tour-detail-info-item:hover {
        background: var(--tour-detail-hover);
        border-color: #bfd0ec;
        transform: translateY(-1px);
    }

    .tour-detail-info-icon {
        width: 36px;
        height: 36px;
        flex-shrink: 0;

        color: var(--tour-detail-primary);
        background: #edf3ff;

        border: 1px solid #d4e2ff;
        border-radius: 9px;

        font-size: 12px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .tour-detail-info-content {
        min-width: 0;
    }

    .tour-detail-info-label {
        margin-bottom: 4px;

        color: var(--tour-detail-muted);
        font-size: 9px;
        font-weight: 750;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .tour-detail-info-value {
        color: #29457d;
        font-size: 12px;
        font-weight: 750;
        line-height: 1.55;
        overflow-wrap: anywhere;
    }

    /* Sức chứa */
    .tour-detail-capacity {
        margin-top: 7px;
    }

    .tour-detail-capacity-track {
        width: 100%;
        height: 6px;

        overflow: hidden;

        background: #e5eaf3;
        border-radius: 999px;
    }

    .tour-detail-capacity-bar {
        height: 100%;

        background: linear-gradient(90deg,
                var(--tour-detail-primary),
                var(--tour-detail-purple));

        border-radius: inherit;
    }

    /* Mô tả */
    .tour-detail-description {
        color: #4d5d7d;
        font-size: 13px;
        line-height: 1.8;
    }

    .tour-detail-description img {
        max-width: 100%;
        height: auto;

        border-radius: 10px;
    }

    .tour-detail-description p:last-child {
        margin-bottom: 0;
    }

    .tour-detail-description:empty::before {
        content: "Tour chưa có mô tả.";

        color: var(--tour-detail-light);
        font-style: italic;
    }

    /* Thao tác */
    .tour-detail-actions {
        display: grid;
        gap: 10px;
    }

    .tour-detail-action {
        min-height: 44px;
        padding: 10px 13px;

        border: 1px solid transparent;
        border-radius: 9px;

        font-size: 11px;
        font-weight: 750;
        text-decoration: none;

        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 9px;

        transition:
            color 0.18s ease,
            background-color 0.18s ease,
            border-color 0.18s ease,
            transform 0.18s ease,
            box-shadow 0.18s ease;
    }

    .tour-detail-action:hover {
        text-decoration: none;
        transform: translateY(-1px);
    }

    .tour-detail-action-icon {
        width: 28px;
        height: 28px;
        flex-shrink: 0;

        border-radius: 7px;

        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .tour-action-primary {
        color: var(--tour-detail-white);

        background: linear-gradient(135deg,
                var(--tour-detail-primary),
                var(--tour-detail-purple));

        border-color: var(--tour-detail-primary);

        box-shadow:
            0 5px 13px rgba(49, 91, 232, 0.2);
    }

    .tour-action-primary:hover {
        color: var(--tour-detail-white);

        background: linear-gradient(135deg,
                var(--tour-detail-primary-dark),
                #4c40d7);
    }

    .tour-action-primary .tour-detail-action-icon {
        background: rgba(255, 255, 255, 0.15);
    }

    .tour-action-success {
        color: var(--tour-detail-success);
        background: var(--tour-detail-success-bg);
        border-color: #c5ead8;
    }

    .tour-action-success:hover {
        color: var(--tour-detail-white);
        background: #12935f;
        border-color: #12935f;
    }

    .tour-action-success .tour-detail-action-icon {
        background: rgba(8, 117, 74, 0.08);
    }

    .tour-action-warning {
        color: var(--tour-detail-warning);
        background: var(--tour-detail-warning-bg);
        border-color: #f1dba9;
    }

    .tour-action-warning:hover {
        color: var(--tour-detail-white);
        background: #dc941e;
        border-color: #dc941e;
    }

    .tour-action-warning .tour-detail-action-icon {
        background: rgba(174, 108, 13, 0.08);
    }

    .tour-action-danger {
        color: var(--tour-detail-danger);
        background: var(--tour-detail-danger-bg);
        border-color: #f0c9d1;
    }

    .tour-action-danger:hover {
        color: var(--tour-detail-white);
        background: var(--tour-detail-danger);
        border-color: var(--tour-detail-danger);
    }

    .tour-action-danger .tour-detail-action-icon {
        background: rgba(193, 61, 85, 0.08);
    }

    .tour-action-secondary {
        color: #53698f;
        background: var(--tour-detail-white);
        border-color: #ccd9ed;
    }

    .tour-action-secondary:hover {
        color: #304d83;
        background: #edf3fb;
        border-color: #b9c9e0;
    }

    .tour-action-secondary .tour-detail-action-icon {
        background: #eef2f8;
    }

    .tour-action-disabled {
        cursor: not-allowed;
        opacity: 0.55;
    }

    .tour-action-disabled:hover {
        color: inherit;
        transform: none;
    }

    /* Thông tin nhanh */
    .tour-quick-list {
        display: flex;
        flex-direction: column;
    }

    .tour-quick-item {
        padding: 12px 0;

        border-bottom: 1px solid var(--tour-detail-border-light);

        display: grid;
        grid-template-columns: 105px minmax(0, 1fr);
        gap: 12px;
        align-items: start;
    }

    .tour-quick-item:first-child {
        padding-top: 0;
    }

    .tour-quick-item:last-child {
        padding-bottom: 0;
        border-bottom: none;
    }

    .tour-quick-label {
        color: var(--tour-detail-muted);
        font-size: 10px;
        font-weight: 700;
    }

    .tour-quick-value {
        color: #29457d;
        font-size: 11px;
        font-weight: 750;
        line-height: 1.55;
        text-align: right;
        overflow-wrap: anywhere;
    }

    @media (max-width: 1100px) {
        .tour-detail-layout {
            grid-template-columns: 1fr;
        }

        .tour-detail-sidebar {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .tour-detail-sidebar .tour-detail-card {
            margin-bottom: 0;
        }
    }

    @media (max-width: 768px) {
        .tour-detail-header {
            align-items: stretch;
            flex-direction: column;
        }

        .tour-detail-heading h2 {
            font-size: 20px;
        }

        .btn-tour-detail-back {
            width: 100%;
        }

        .tour-detail-info-grid,
        .tour-detail-sidebar {
            grid-template-columns: 1fr;
        }

        .tour-detail-card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .tour-quick-item {
            grid-template-columns: 95px minmax(0, 1fr);
        }
    }

</style>

@php
$lichKhoiHanh = $tour->lichKhoiHanh;
$tourInfo = $lichKhoiHanh->tour ?? null;
$huongDanVien = $tour->hdv;

$soChoDaDat = (int) (
$lichKhoiHanh->so_cho_da_dat ?? 0
);

$tongSoCho = (int) (
$lichKhoiHanh->so_cho ?? 0
);

$phanTramCho = $tongSoCho > 0
? round(($soChoDaDat / $tongSoCho) * 100)
: 0;

$phanTramCho = min(
max($phanTramCho, 0),
100
);
@endphp

<div class="tour-detail-page fade-in">
    {{-- Header --}}
    <div class="tour-detail-header">
        <div class="tour-detail-heading">
            <span class="tour-detail-heading-icon">
                <i class="fas fa-route"></i>
            </span>

            <div>
                <h2>Chi tiết Tour</h2>

                <p>
                    {{
                            $tourInfo->ten_tour
                            ?? 'Tour không xác định'
                        }}
                </p>
            </div>
        </div>

        <a href="{{ route('Guide.tour-phan-cong.index') }}" class="btn-tour-detail-back">
            <i class="fas fa-arrow-left"></i>
            Quay lại danh sách
        </a>
    </div>

    <div class="tour-detail-layout">
        {{-- Nội dung chính --}}
        <div class="tour-detail-main">
            <section class="tour-detail-card">
                <div class="tour-detail-card-header">
                    <div class="tour-detail-card-title">
                        <span class="tour-detail-card-title-icon">
                            <i class="fas fa-map-marked-alt"></i>
                        </span>

                        <div>
                            <h3>
                                {{
                                        $tourInfo->ten_tour
                                        ?? 'Tour không xác định'
                                    }}
                            </h3>

                            <p>
                                Mã phân công #{{ $tour->id }}
                            </p>
                        </div>
                    </div>

                    <span class="tour-detail-status">
                        <span class="tour-detail-status-dot"></span>
                        Đã phân công
                    </span>
                </div>

                <div class="tour-detail-card-body">
                    <div class="tour-detail-info-grid">
                        <div class="tour-detail-info-item">
                            <span class="tour-detail-info-icon">
                                <i class="fas fa-plane-departure"></i>
                            </span>

                            <div class="tour-detail-info-content">
                                <div class="tour-detail-info-label">
                                    Ngày khởi hành
                                </div>

                                <div class="tour-detail-info-value">
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

                        <div class="tour-detail-info-item">
                            <span class="tour-detail-info-icon">
                                <i class="fas fa-flag-checkered"></i>
                            </span>

                            <div class="tour-detail-info-content">
                                <div class="tour-detail-info-label">
                                    Ngày kết thúc
                                </div>

                                <div class="tour-detail-info-value">
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

                        <div class="tour-detail-info-item">
                            <span class="tour-detail-info-icon">
                                <i class="fas fa-user-tie"></i>
                            </span>

                            <div class="tour-detail-info-content">
                                <div class="tour-detail-info-label">
                                    Hướng dẫn viên
                                </div>

                                <div class="tour-detail-info-value">
                                    {{
                                            $huongDanVien->ho_ten
                                            ?? 'Chưa phân công'
                                        }}
                                </div>
                            </div>
                        </div>

                        <div class="tour-detail-info-item">
                            <span class="tour-detail-info-icon">
                                <i class="fas fa-bus"></i>
                            </span>

                            <div class="tour-detail-info-content">
                                <div class="tour-detail-info-label">
                                    Phương tiện
                                </div>

                                <div class="tour-detail-info-value">
                                    @forelse($tour->dsPhuongTien as $xe)
                                    <div>
                                        {{ $xe->loai_phuong_tien == 'xe_45_cho' ? 'Xe 45 chỗ'  : ($xe->loai_phuong_tien == 'xe_29_cho' ? 'Xe 29 chỗ' : ($xe->loai_phuong_tien == 'xe_16_cho' ? 'Xe 16 chỗ' : ($xe->loai_phuong_tien == 'xe_7_cho' ? 'Xe 7 chỗ' : 'Xe khác'))) }}
                                    </div>
                                    @empty
                                    Chưa phân công
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="tour-detail-info-item">
                            <span class="tour-detail-info-icon">
                                <i class="fas fa-id-card"></i>
                            </span>

                            <div class="tour-detail-info-content">
                                <div class="tour-detail-info-label">
                                    Biển số xe
                                </div>

                                <div class="tour-detail-info-value">
                                    @forelse($tour->dsPhuongTien as $xe)
                                    <div>{{ $xe->bien_so_xe }}</div>
                                    @empty
                                    Chưa cập nhật
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div class="tour-detail-info-item">
                            <span class="tour-detail-info-icon">
                                <i class="fas fa-users"></i>
                            </span>

                            <div class="tour-detail-info-content">
                                <div class="tour-detail-info-label">
                                    Số khách
                                </div>

                                <div class="tour-detail-info-value">
                                    {{ $soChoDaDat }}/{{ $tongSoCho }} khách
                                </div>

                                <div class="tour-detail-capacity">
                                    <div class="tour-detail-capacity-track">
                                        <div class="tour-detail-capacity-bar" style="width: {{ $phanTramCho }}%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Mô tả --}}
            <section class="tour-detail-card">
                <div class="tour-detail-card-header">
                    <div class="tour-detail-card-title">
                        <span class="tour-detail-card-title-icon">
                            <i class="fas fa-align-left"></i>
                        </span>

                        <div>
                            <h4>Mô tả Tour</h4>

                            <p>
                                Thông tin giới thiệu và nội dung Tour
                            </p>
                        </div>
                    </div>
                </div>

                <div class="tour-detail-card-body">
                    <div class="tour-detail-description">
                        @if (!empty($tourInfo->mo_ta))
                        {!! $tourInfo->mo_ta !!}
                        @else
                        <p class="text-muted fst-italic mb-0">
                            Tour chưa có nội dung mô tả.
                        </p>
                        @endif
                    </div>
                </div>
            </section>
        </div>

        {{-- Sidebar bên phải --}}
        <aside class="tour-detail-sidebar">
            {{-- Thao tác --}}
            <section class="tour-detail-card">
                <div class="tour-detail-card-header">
                    <div class="tour-detail-card-title">
                        <span class="tour-detail-card-title-icon">
                            <i class="fas fa-bolt"></i>
                        </span>

                        <div>
                            <h4>Thao tác</h4>

                            <p>
                                Truy cập nhanh nghiệp vụ Tour
                            </p>
                        </div>
                    </div>
                </div>

                <div class="tour-detail-card-body">
                    <div class="tour-detail-actions">
                        <a href="{{ route(
                                    'Guide.danh-sach-khach',
                                    $tour->id
                                ) }}" class="tour-detail-action tour-action-primary">
                            <span class="tour-detail-action-icon">
                                <i class="fas fa-users"></i>
                            </span>

                            Danh sách khách
                        </a>



                        <a href="{{ route(
                                    'Guide.lich-trinh',
                                    $tour->id
                                ) }}" class="tour-detail-action tour-action-warning">
                            <span class="tour-detail-action-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </span>

                            Lịch trình Tour
                        </a>

                        <a href="{{ route('Guide.baocaosuco.index') }}" class="tour-detail-action tour-action-danger">
                            <span class="tour-detail-action-icon">
                                <i class="fas fa-triangle-exclamation"></i>
                            </span>

                            Báo cáo sự cố
                        </a>

                        <a href="{{ route('Guide.tour-phan-cong.index') }}" class="tour-detail-action tour-action-secondary">
                            <span class="tour-detail-action-icon">
                                <i class="fas fa-arrow-left"></i>
                            </span>

                            Quay lại
                        </a>
                    </div>
                </div>
            </section>

            {{-- Thông tin nhanh --}}
            <section class="tour-detail-card">
                <div class="tour-detail-card-header">
                    <div class="tour-detail-card-title">
                        <span class="tour-detail-card-title-icon">
                            <i class="fas fa-circle-info"></i>
                        </span>

                        <div>
                            <h4>Thông tin nhanh</h4>

                            <p>
                                Tóm tắt Tour được phân công
                            </p>
                        </div>
                    </div>
                </div>

                <div class="tour-detail-card-body">
                    <div class="tour-quick-list">
                        <div class="tour-quick-item">
                            <div class="tour-quick-label">
                                Tour
                            </div>

                            <div class="tour-quick-value">
                                {{
                                        $tourInfo->ten_tour
                                        ?? 'Không xác định'
                                    }}
                            </div>
                        </div>

                        <div class="tour-quick-item">
                            <div class="tour-quick-label">
                                Xe
                            </div>

                            <div class="tour-detail-info-value">
                                @forelse($tour->dsPhuongTien as $xe)
                                <div>
                                    {{ $xe->loai_phuong_tien == 'xe_45_cho' ? 'Xe 45 chỗ'  : ($xe->loai_phuong_tien == 'xe_29_cho' ? 'Xe 29 chỗ' : ($xe->loai_phuong_tien == 'xe_16_cho' ? 'Xe 16 chỗ' : ($xe->loai_phuong_tien == 'xe_7_cho' ? 'Xe 7 chỗ' : 'Xe khác'))) }}
                                </div>
                                @empty
                                Chưa phân công
                                @endforelse
                            </div>
                        </div>

                        <div class="tour-quick-item">
                            <div class="tour-quick-label">
                                Biển số
                            </div>

                            <div class="tour-detail-info-value">
                                @forelse($tour->dsPhuongTien as $xe)
                                <div>{{ $xe->bien_so_xe }}</div>
                                @empty
                                Chưa cập nhật
                                @endforelse
                            </div>
                        </div>

                        <div class="tour-quick-item">
                            <div class="tour-quick-label">
                                Khách
                            </div>

                            <div class="tour-quick-value">
                                {{ $soChoDaDat }}/{{ $tongSoCho }}
                            </div>
                        </div>

                        <div class="tour-quick-item">
                            <div class="tour-quick-label">
                                Trạng thái
                            </div>

                            <div class="tour-quick-value">
                                <span class="tour-detail-status">
                                    <span class="tour-detail-status-dot"></span>
                                    Đã phân công
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </aside>
    </div>
</div>
@endsection
