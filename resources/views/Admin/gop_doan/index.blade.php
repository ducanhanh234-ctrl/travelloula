@extends('layouts.admin')

@section('title', 'Đề xuất gộp đoàn')

@section('content')
    <style>
        :root {
            --merge-primary: #315be8;
            --merge-primary-dark: #2348c7;
            --merge-purple: #5d48e8;
            --merge-text: #163b77;
            --merge-muted: #7484a3;
            --merge-border: #dce5f5;
            --merge-background: #f4f7ff;

            --merge-success: #14996e;
            --merge-success-bg: #e9f8f2;

            --merge-warning: #cf8500;
            --merge-warning-bg: #fff6dd;

            --merge-danger: #d94c61;
            --merge-danger-bg: #fff0f2;

            --merge-info: #197ec1;
            --merge-info-bg: #eaf7ff;
        }

        .merge-proposal-page {
            color: #263d66;
            padding-bottom: 35px;
        }

        /* =========================
           HEADER TRANG
        ========================= */
        .merge-page-heading h3 {
            color: var(--merge-text);
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .merge-page-heading h3 i {
            color: var(--merge-primary);
        }

        .merge-page-heading small {
            display: block;
            max-width: 780px;
            color: var(--merge-muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .merge-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-manual-merge,
        .btn-merge-history {
            min-height: 42px;
            padding: 9px 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-manual-merge {
            color: #fff;
            background: var(--merge-success);
            border: 1px solid var(--merge-success);
        }

        .btn-manual-merge:hover {
            color: #fff;
            background: #0d825c;
            border-color: #0d825c;
            transform: translateY(-1px);
            box-shadow: 0 7px 17px rgba(20, 153, 110, 0.2);
        }

        .btn-merge-history {
            color: var(--merge-primary);
            background: #fff;
            border: 1px solid #cedaf3;
        }

        .btn-merge-history:hover {
            color: #fff;
            background: var(--merge-primary);
            border-color: var(--merge-primary);
            transform: translateY(-1px);
            box-shadow: 0 7px 17px rgba(49, 91, 232, 0.2);
        }

        /* =========================
           ALERT
        ========================= */
        .merge-alert {
            border: 0;
            border-radius: 11px;
            padding: 14px 16px;
            box-shadow: 0 5px 15px rgba(34, 61, 119, 0.07);
        }

        /* =========================
           THỐNG KÊ
        ========================= */
        .merge-stat-card {
            height: 100%;
            position: relative;
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--merge-border);
            border-radius: 13px;
            box-shadow: 0 4px 14px rgba(32, 62, 130, 0.05);
            transition: all 0.2s ease;
        }

        .merge-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(32, 62, 130, 0.1);
        }

        .merge-stat-card::after {
            content: "";
            position: absolute;
            width: 88px;
            height: 88px;
            right: -30px;
            bottom: -36px;
            border-radius: 50%;
            background: #f4f7ff;
        }

        .merge-stat-card .card-body {
            min-height: 102px;
            position: relative;
            z-index: 1;
            padding: 19px 18px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .merge-stat-icon {
            width: 44px;
            height: 44px;
            flex: 0 0 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            font-size: 17px;
        }

        .merge-stat-icon.primary {
            color: var(--merge-primary);
            background: #edf2ff;
            border: 1px solid #cfdbff;
        }

        .merge-stat-icon.success {
            color: var(--merge-success);
            background: var(--merge-success-bg);
            border: 1px solid #c5ebdc;
        }

        .merge-stat-icon.warning {
            color: var(--merge-warning);
            background: var(--merge-warning-bg);
            border: 1px solid #efdca9;
        }

        .merge-stat-icon.danger {
            color: var(--merge-danger);
            background: var(--merge-danger-bg);
            border: 1px solid #efcad1;
        }

        .merge-stat-value {
            color: #12366f;
            font-size: 23px;
            line-height: 1;
            font-weight: 800;
            margin-bottom: 7px;
        }

        .merge-stat-label {
            color: var(--merge-muted);
            font-size: 12px;
            font-weight: 600;
        }

        /* =========================
           KHỐI DANH SÁCH
        ========================= */
        .proposal-list-card {
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--merge-border);
            border-radius: 14px;
            box-shadow: 0 7px 22px rgba(37, 66, 129, 0.07);
        }

        .proposal-list-header {
            position: relative;
            overflow: hidden;
            min-height: 94px;
            padding: 19px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #fff;
            background: linear-gradient(
                110deg,
                #315be8 0%,
                #2871ee 65%,
                #5c42e7 100%
            );
        }

        .proposal-list-header::before,
        .proposal-list-header::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.07);
        }

        .proposal-list-header::before {
            width: 145px;
            height: 145px;
            right: 65px;
            top: -83px;
        }

        .proposal-list-header::after {
            width: 108px;
            height: 108px;
            right: -27px;
            bottom: -48px;
        }

        .proposal-title-group {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .proposal-header-icon {
            width: 43px;
            height: 43px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 11px;
            background: rgba(255, 255, 255, 0.12);
            font-size: 18px;
        }

        .proposal-list-header h5 {
            color: #fff;
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .proposal-list-header p {
            color: rgba(255, 255, 255, 0.84);
            font-size: 13px;
            margin: 0;
        }

        .proposal-header-count {
            position: relative;
            z-index: 2;
            min-width: 87px;
            padding: 9px 14px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 11px;
            background: rgba(255, 255, 255, 0.12);
        }

        .proposal-header-count strong {
            display: block;
            font-size: 21px;
            line-height: 1.1;
        }

        .proposal-header-count span {
            font-size: 10px;
            font-weight: 600;
            opacity: 0.88;
        }

        /* =========================
           TABLE
        ========================= */
        .proposal-table-wrapper {
            padding: 17px;
        }

        .proposal-table-box {
            overflow: hidden;
            border: 1px solid var(--merge-border);
            border-radius: 11px;
        }

        .proposal-table {
            min-width: 1300px;
            margin: 0;
        }

        .proposal-table thead th {
            color: #193b76;
            background: #f6f8fd;
            border-color: #e1e8f5;
            padding: 14px 11px;
            font-size: 11px;
            font-weight: 800;
            text-align: center;
            text-transform: uppercase;
            vertical-align: middle;
            white-space: nowrap;
        }

        .proposal-table tbody td {
            color: #33496f;
            background: #fff;
            border-color: #e7edf7;
            padding: 15px 11px;
            font-size: 13px;
            vertical-align: middle;
        }

        .proposal-table tbody tr {
            transition: all 0.18s ease;
        }

        .proposal-table tbody tr:hover td {
            background: #f8faff;
        }

        .tour-name {
            color: #163b77;
            font-size: 14px;
            font-weight: 800;
        }

        /* =========================
           LỊCH KHỞI HÀNH CON
        ========================= */
        .departure-item {
            margin-bottom: 8px;
            overflow: hidden;
            border: 1px solid #dce5f5;
            border-left: 4px solid var(--merge-primary);
            border-radius: 9px;
            background: #fff;
            box-shadow: 0 3px 10px rgba(34, 63, 126, 0.05);
        }

        .departure-item:last-child {
            margin-bottom: 0;
        }

        .departure-item-body {
            padding: 10px 11px;
        }

        .departure-code {
            color: #173b78;
            font-weight: 800;
        }

        .departure-date {
            color: var(--merge-muted);
            font-size: 11px;
            line-height: 1.55;
        }

        .departure-empty-seat {
            color: #627291;
            font-size: 11px;
            margin-top: 5px;
        }

        /* =========================
           BADGE MỀM
        ========================= */
        .merge-soft-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .merge-soft-primary {
            color: var(--merge-primary);
            background: #edf2ff;
            border: 1px solid #d1dcff;
        }

        .merge-soft-success {
            color: #087956;
            background: var(--merge-success-bg);
            border: 1px solid #c0e8d7;
        }

        .merge-soft-warning {
            color: #a66c00;
            background: var(--merge-warning-bg);
            border: 1px solid #efdaa0;
        }

        .merge-soft-danger {
            color: #c43d52;
            background: var(--merge-danger-bg);
            border: 1px solid #f0c9d0;
        }

        .merge-soft-info {
            color: #1573af;
            background: var(--merge-info-bg);
            border: 1px solid #c5e5f8;
        }

        .merge-soft-secondary {
            color: #63708a;
            background: #f1f3f7;
            border: 1px solid #dde2ea;
        }

        /* =========================
           SỐ KHÁCH VÀ XE
        ========================= */
        .customer-total {
            color: var(--merge-primary);
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .vehicle-badge {
            padding: 7px 12px;
        }

        /* =========================
           ĐIỂM AI
        ========================= */
        .score-badge {
            min-width: 98px;
            padding: 8px 12px;
            font-size: 12px;
        }

        .score-progress {
            height: 6px;
            overflow: hidden;
            background: #edf1f7;
            border-radius: 20px;
            margin-top: 10px;
        }

        .score-progress .progress-bar {
            border-radius: 20px;
        }

        .score-progress .score-success {
            background: var(--merge-success);
        }

        .score-progress .score-warning {
            background: #e1a11c;
        }

        .score-progress .score-danger {
            background: var(--merge-danger);
        }

        /* =========================
           LÝ DO ĐỀ XUẤT
        ========================= */
        .reason-list {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .reason-item {
            display: block;
            padding: 8px 10px;
            color: #445879;
            background: #f7f9fd;
            border: 1px solid #dfe7f5;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            line-height: 1.45;
            text-align: left;
        }

        /* =========================
           BUTTON TẠO YÊU CẦU
        ========================= */
        .btn-create-request {
            min-width: 112px;
            padding: 8px 13px;
            color: #fff;
            background: var(--merge-success);
            border: 1px solid var(--merge-success);
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-create-request:hover {
            color: #fff;
            background: #0d825c;
            border-color: #0d825c;
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(20, 153, 110, 0.22);
        }

        /* =========================
           EMPTY
        ========================= */
        .proposal-empty-state {
            padding: 55px 15px !important;
            text-align: center;
        }

        .proposal-empty-state i {
            display: block;
            color: #b6c3dd;
            font-size: 35px;
            margin-bottom: 12px;
        }

        .proposal-empty-state span {
            color: var(--merge-muted);
            font-weight: 600;
        }

        /* =========================
           RESPONSIVE
        ========================= */
        @media (max-width: 991.98px) {
            .merge-page-top {
                align-items: flex-start !important;
                flex-direction: column;
                gap: 15px;
            }

            .merge-header-actions {
                width: 100%;
            }

            .btn-manual-merge,
            .btn-merge-history {
                flex: 1;
            }
        }

        @media (max-width: 767.98px) {
            .merge-header-actions {
                flex-direction: column;
            }

            .btn-manual-merge,
            .btn-merge-history {
                width: 100%;
            }

            .proposal-list-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 15px;
            }

            .proposal-header-count {
                width: 100%;
            }

            .proposal-table-wrapper {
                padding: 10px;
            }
        }
    </style>

    <div class="container-fluid merge-proposal-page">

        {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show merge-alert">
                <i class="fas fa-circle-check me-2"></i>

                {{ session('success') }}

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show merge-alert">
                <i class="fas fa-circle-exclamation me-2"></i>

                {{ session('error') }}

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>
            </div>
        @endif

        {{-- Header --}}
        <div class="merge-page-top d-flex justify-content-between align-items-center mb-4">

            <div class="merge-page-heading">
                <h3>
                    <i class="fas fa-object-group me-2"></i>
                    Đề xuất gộp đoàn tự động
                </h3>

                <small>
                    Các nhóm dưới đây được hệ thống đề xuất có thể gộp.
                    Sau khi tạo yêu cầu, việc quản lý và xử lý sẽ được thực hiện
                    tại trang Lịch sử gộp đoàn.
                </small>
            </div>

            <div class="merge-header-actions">

                <a href="{{ route('Admin.gop-doan.thu-cong') }}"
                    class="btn btn-manual-merge">

                    <i class="fas fa-hand-paper"></i>
                    Gộp đoàn thủ công

                </a>

                <a href="{{ route('Admin.gop-doan.lich-su') }}"
                    class="btn btn-merge-history">

                    <i class="fas fa-history"></i>
                    Lịch sử gộp đoàn

                </a>

            </div>

        </div>

        {{-- Thống kê --}}
        <div class="row g-3 mb-4">

            <div class="col-xl-3 col-md-6">
                <div class="merge-stat-card">

                    <div class="card-body">

                        <div class="merge-stat-icon primary">
                            <i class="fas fa-lightbulb"></i>
                        </div>

                        <div>
                            <div class="merge-stat-value">
                                {{ count($deXuats) }}
                            </div>

                            <div class="merge-stat-label">
                                Đề xuất gộp
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="merge-stat-card">

                    <div class="card-body">

                        <div class="merge-stat-icon success">
                            <i class="fas fa-users"></i>
                        </div>

                        <div>
                            <div class="merge-stat-value">
                                {{ collect($deXuats ?? [])->sum('tong_khach') }}
                            </div>

                            <div class="merge-stat-label">
                                Tổng khách
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="merge-stat-card">

                    <div class="card-body">

                        <div class="merge-stat-icon warning">
                            <i class="fas fa-bus"></i>
                        </div>

                        <div>
                            <div class="merge-stat-value">
                                {{ count($deXuats) }}
                            </div>

                            <div class="merge-stat-label">
                                Xe sau khi gộp
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="merge-stat-card">

                    <div class="card-body">

                        <div class="merge-stat-icon danger">
                            <i class="fas fa-star"></i>
                        </div>

                        <div>
                            <div class="merge-stat-value">
                                {{ count($deXuats)
                                    ? round(collect($deXuats)->avg('diem'))
                                    : 0 }}
                            </div>

                            <div class="merge-stat-label">
                                Điểm trung bình
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        {{-- Danh sách đề xuất --}}
        <div class="proposal-list-card">

            <div class="proposal-list-header">

                <div class="proposal-title-group">

                    <div class="proposal-header-icon">
                        <i class="fas fa-people-arrows"></i>
                    </div>

                    <div>
                        <h5>Danh sách đề xuất gộp đoàn</h5>

                        <p>
                            Xem xét các nhóm lịch khởi hành được hệ thống đề xuất.
                        </p>
                    </div>

                </div>

                <div class="proposal-header-count">
                    <strong>{{ count($deXuats) }}</strong>
                    <span>Đề xuất</span>
                </div>

            </div>

            <div class="proposal-table-wrapper">

                <div class="table-responsive proposal-table-box">

                    <table class="table table-hover align-middle proposal-table">

                        <thead>
                            <tr>
                                <th style="width: 20%">Tour</th>
                                <th style="width: 25%">Các lịch đề xuất gộp</th>
                                <th>Tổng khách</th>
                                <th>Điểm</th>
                                <th>Lý do</th>
                                <th style="width: 160px">Tạo yêu cầu</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($deXuats as $item)

                                @php
                                    $first = collect($item['nhom'])->first();
                                    $tour = $first?->tour;

                                    $scoreClass = 'merge-soft-danger';
                                    $progressClass = 'score-danger';

                                    if ($item['diem'] >= 90) {
                                        $scoreClass = 'merge-soft-success';
                                        $progressClass = 'score-success';
                                    } elseif ($item['diem'] >= 75) {
                                        $scoreClass = 'merge-soft-warning';
                                        $progressClass = 'score-warning';
                                    }

                                    $vehicleSeats = $item['tong_khach'] <= 14
                                        ? 14
                                        : ($item['tong_khach'] <= 27 ? 27 : 43);
                                @endphp

                                <tr>

                                    {{-- Tour --}}
                                    <td>

                                        <div class="tour-name">

                                            <i class="fas fa-map-marked-alt text-primary me-1"></i>

                                            {{ $tour?->ten_tour ?? 'Không có tour' }}

                                        </div>

                                        <div class="mt-2">

                                            <span class="merge-soft-badge merge-soft-info">

                                                <i class="fas fa-calendar-days"></i>

                                                {{ count($item['nhom']) }} lịch

                                            </span>

                                        </div>

                                    </td>

                                    {{-- Lịch khởi hành --}}
                                    <td>

                                        @foreach ($item['nhom'] as $lich)

                                            <div class="departure-item">

                                                <div class="departure-item-body">

                                                    <div class="d-flex justify-content-between gap-2">

                                                        <div>

                                                            <div class="departure-code">

                                                                <i class="fas fa-calendar-alt text-primary me-1"></i>

                                                                Lịch #{{ $lich->id }}

                                                            </div>

                                                            <div class="departure-date mt-1">

                                                                {{ \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->format('d/m/Y') }}

                                                                <i class="fas fa-arrow-right mx-1"></i>

                                                                {{ \Carbon\Carbon::parse($lich->ngay_ket_thuc)->format('d/m/Y') }}

                                                            </div>

                                                            <div class="departure-empty-seat">

                                                                <i class="fas fa-chair me-1"></i>

                                                                {{ $lich->so_cho_con_lai }}
                                                                chỗ còn trống

                                                            </div>

                                                        </div>

                                                        <div class="text-end">

                                                            <span class="merge-soft-badge merge-soft-success">

                                                                {{ $lich->so_cho_da_dat }}/{{ $lich->so_cho }}

                                                            </span>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        @endforeach

                                    </td>

                                    {{-- Tổng khách --}}
                                    <td class="text-center">

                                        <div class="customer-total">

                                            <i class="fas fa-users me-1"></i>

                                            {{ $item['tong_khach'] }}

                                        </div>

                                        <span class="merge-soft-badge merge-soft-primary vehicle-badge">

                                            <i class="fas fa-bus"></i>

                                            Xe {{ $vehicleSeats }} chỗ

                                        </span>

                                    </td>

                                    {{-- Điểm --}}
                                    <td class="text-center">

                                        <span class="merge-soft-badge {{ $scoreClass }} score-badge">

                                            <i class="fas fa-star"></i>

                                            AI {{ $item['diem'] }}/100

                                        </span>

                                        @if ($item['diem'] >= 90)

                                            <div class="mt-2">

                                                <span class="merge-soft-badge merge-soft-danger">

                                                    <i class="fas fa-fire"></i>

                                                    Ưu tiên

                                                </span>

                                            </div>

                                        @endif

                                        <div class="progress score-progress">

                                            <div class="progress-bar {{ $progressClass }}"
                                                role="progressbar"
                                                style="width: {{ min(100, max(0, $item['diem'])) }}%"
                                                aria-valuenow="{{ $item['diem'] }}"
                                                aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>

                                        </div>

                                        <div class="mt-2">

                                            @if ($item['diem'] >= 90)

                                                <span class="merge-soft-badge merge-soft-success">
                                                    Khuyến nghị cao
                                                </span>

                                            @elseif ($item['diem'] >= 75)

                                                <span class="merge-soft-badge merge-soft-warning">
                                                    Khuyến nghị
                                                </span>

                                            @else

                                                <span class="merge-soft-badge merge-soft-secondary">
                                                    Có thể gộp
                                                </span>

                                            @endif

                                        </div>

                                    </td>

                                    {{-- Lý do --}}
                                    <td>

                                        <div class="reason-list">

                                            @foreach ($item['ly_do'] as $lyDo)

                                                <span class="reason-item">

                                                    <i class="fas fa-circle-check text-success me-1"></i>

                                                    {{ $lyDo }}

                                                </span>

                                            @endforeach

                                        </div>

                                    </td>

                                    {{-- Tạo yêu cầu --}}
                                    <td class="text-center">

                                        <form action="{{ route('Admin.gop-doan.ai.store') }}"
                                            method="POST">

                                            @csrf

                                            @foreach ($item['nhom'] as $lich)

                                                <input type="hidden"
                                                    name="lich_ids[]"
                                                    value="{{ $lich->id }}">

                                            @endforeach

                                            <input type="hidden"
                                                name="ly_do_de_xuat"
                                                value="{{ implode(' | ', $item['ly_do']) }}">

                                            <button type="submit"
                                                class="btn btn-create-request"
                                                onclick="return confirm('Bạn có chắc chắn muốn tạo yêu cầu gộp đoàn này?')">

                                                <i class="fas fa-plus-circle me-1"></i>

                                                Tạo yêu cầu

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="proposal-empty-state">

                                        <i class="fas fa-folder-open"></i>

                                        <span>
                                            Hiện chưa có đề xuất gộp đoàn phù hợp.
                                        </span>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection
