@extends('layouts.admin')

@section('title', 'Lịch sử gộp đoàn')

@section('content')
    <style>
        :root {
            --history-primary: #315be8;
            --history-primary-dark: #2348c7;
            --history-purple: #5c42e7;

            --history-text: #173b77;
            --history-text-normal: #33496f;
            --history-muted: #7484a3;
            --history-border: #dce5f5;

            --history-success: #14996e;
            --history-success-bg: #e9f8f2;

            --history-warning: #d18a08;
            --history-warning-bg: #fff6dd;

            --history-danger: #d94c61;
            --history-danger-bg: #fff0f2;

            --history-info: #197ec1;
            --history-info-bg: #eaf7ff;

            --history-secondary: #66738d;
            --history-secondary-bg: #f1f3f7;
        }

        .merge-history-page {
            color: var(--history-text-normal);
            padding-bottom: 35px;
        }

        /* =========================
           HEADER
        ========================= */
        .history-page-heading h3 {
            color: var(--history-text);
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .history-page-heading h3 i {
            color: var(--history-primary);
        }

        .history-page-heading small {
            color: var(--history-muted);
            font-size: 13px;
        }

        .btn-history-back {
            min-height: 42px;
            padding: 9px 17px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            color: var(--history-primary);
            background: #fff;
            border: 1px solid #cedaf3;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-history-back:hover {
            color: #fff;
            background: var(--history-primary);
            border-color: var(--history-primary);
            box-shadow: 0 7px 17px rgba(49, 91, 232, 0.2);
            transform: translateY(-1px);
        }

        /* =========================
           THỐNG KÊ
        ========================= */
        .history-stat-card {
            height: 100%;
            position: relative;
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--history-border);
            border-radius: 13px;
            box-shadow: 0 4px 14px rgba(32, 62, 130, 0.05);
            transition: all 0.2s ease;
        }

        .history-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(32, 62, 130, 0.1);
        }

        .history-stat-card::after {
            content: "";
            position: absolute;
            width: 88px;
            height: 88px;
            right: -30px;
            bottom: -36px;
            border-radius: 50%;
            background: #f4f7ff;
        }

        .history-stat-card .card-body {
            min-height: 102px;
            position: relative;
            z-index: 1;
            padding: 19px 18px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .history-stat-icon {
            width: 44px;
            height: 44px;
            flex: 0 0 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            font-size: 17px;
        }

        .history-stat-icon.primary {
            color: var(--history-primary);
            background: #edf2ff;
            border: 1px solid #cfdbff;
        }

        .history-stat-icon.success {
            color: var(--history-success);
            background: var(--history-success-bg);
            border: 1px solid #c5ebdc;
        }

        .history-stat-icon.info {
            color: var(--history-info);
            background: var(--history-info-bg);
            border: 1px solid #c5e5f8;
        }

        .history-stat-icon.danger {
            color: var(--history-danger);
            background: var(--history-danger-bg);
            border: 1px solid #efcad1;
        }

        .history-stat-value {
            color: #12366f;
            font-size: 23px;
            line-height: 1;
            font-weight: 800;
            margin-bottom: 7px;
        }

        .history-stat-label {
            color: var(--history-muted);
            font-size: 12px;
            font-weight: 600;
        }

        /* =========================
           KHỐI DANH SÁCH
        ========================= */
        .history-list-card {
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--history-border);
            border-radius: 14px;
            box-shadow: 0 7px 22px rgba(37, 66, 129, 0.07);
        }

        .history-list-header {
            min-height: 94px;
            position: relative;
            overflow: hidden;
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

        .history-list-header::before,
        .history-list-header::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.07);
        }

        .history-list-header::before {
            width: 145px;
            height: 145px;
            right: 65px;
            top: -83px;
        }

        .history-list-header::after {
            width: 108px;
            height: 108px;
            right: -27px;
            bottom: -48px;
        }

        .history-title-group {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .history-header-icon {
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

        .history-list-header h5 {
            color: #fff;
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .history-list-header p {
            color: rgba(255, 255, 255, 0.84);
            font-size: 13px;
            margin: 0;
        }

        .history-header-count {
            min-width: 87px;
            position: relative;
            z-index: 2;
            padding: 9px 14px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 11px;
            background: rgba(255, 255, 255, 0.12);
        }

        .history-header-count strong {
            display: block;
            font-size: 21px;
            line-height: 1.1;
        }

        .history-header-count span {
            font-size: 10px;
            font-weight: 600;
            opacity: 0.88;
        }

        /* =========================
           BẢNG LỊCH SỬ
        ========================= */
        .history-table-wrapper {
            padding: 17px;
        }

        .history-table-box {
            overflow: hidden;
            border: 1px solid var(--history-border);
            border-radius: 11px;
        }

        .history-table {
            min-width: 1500px;
            margin: 0;
        }

        .history-table thead th {
            color: #193b76;
            background: #f6f8fd;
            border-color: #e1e8f5;
            padding: 14px 10px;
            font-size: 11px;
            font-weight: 800;
            text-align: center;
            text-transform: uppercase;
            vertical-align: middle;
            white-space: nowrap;
        }

        .history-table tbody td {
            color: var(--history-text-normal);
            background: #fff;
            border-color: #e7edf7;
            padding: 14px 10px;
            font-size: 13px;
            vertical-align: middle;
        }

        .history-table tbody tr.history-main-row {
            transition: all 0.18s ease;
        }

        .history-table tbody tr.history-main-row:hover td {
            background: #f8faff;
        }

        .history-index {
            min-width: 31px;
            height: 31px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--history-primary);
            background: #edf2ff;
            border: 1px solid #d1dcff;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 800;
        }

        .history-request-code {
            color: #173b78;
            font-weight: 800;
        }

        .history-copy-btn {
            color: var(--history-primary);
            text-decoration: none;
            border: 0;
        }

        .history-copy-btn:hover {
            color: var(--history-primary-dark);
        }

        /* =========================
           BADGE
        ========================= */
        .history-soft-badge {
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

        .history-soft-primary {
            color: var(--history-primary);
            background: #edf2ff;
            border: 1px solid #d1dcff;
        }

        .history-soft-success {
            color: #087956;
            background: var(--history-success-bg);
            border: 1px solid #c0e8d7;
        }

        .history-soft-warning {
            color: #a66c00;
            background: var(--history-warning-bg);
            border: 1px solid #efdaa0;
        }

        .history-soft-danger {
            color: #c43d52;
            background: var(--history-danger-bg);
            border: 1px solid #f0c9d0;
        }

        .history-soft-info {
            color: #1573af;
            background: var(--history-info-bg);
            border: 1px solid #c5e5f8;
        }

        .history-soft-secondary {
            color: var(--history-secondary);
            background: var(--history-secondary-bg);
            border: 1px solid #dde2ea;
        }

        /* =========================
           NÚT XEM CHI TIẾT
        ========================= */
        .btn-history-view {
            min-width: 76px;
            padding: 7px 11px;
            color: var(--history-primary);
            background: #edf3ff;
            border: 1px solid #cad9ff;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-history-view:hover,
        .btn-history-view[aria-expanded="true"] {
            color: #fff;
            background: var(--history-primary);
            border-color: var(--history-primary);
            box-shadow: 0 5px 13px rgba(49, 91, 232, 0.22);
        }

        /* =========================
           CHI TIẾT COLLAPSE
        ========================= */
        .history-detail-row > td {
            padding: 0 !important;
            background: #f5f8ff !important;
        }

        .history-detail-content {
            padding: 20px;
            border-top: 1px solid #dce5f5;
        }

        .history-detail-heading {
            color: var(--history-text);
            font-size: 17px;
            font-weight: 800;
            margin-bottom: 16px;
        }

        .history-departure-card {
            overflow: hidden;
            margin-bottom: 18px;
            background: #fff;
            border: 1px solid var(--history-border);
            border-radius: 11px;
            box-shadow: 0 4px 13px rgba(35, 64, 128, 0.06);
        }

        .history-departure-card:last-child {
            margin-bottom: 0;
        }

        .history-departure-header {
            padding: 13px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            color: #294772;
            background: #f4f7fd;
            border-bottom: 1px solid #e0e7f4;
        }

        .history-departure-header strong {
            color: var(--history-text);
        }

        .history-departure-body {
            padding: 15px;
        }

        /* =========================
           BOOKING CARD
        ========================= */
        .history-booking-card {
            height: 100%;
            overflow: hidden;
            padding: 14px;
            background: #fff;
            border: 1px solid #dce5f5;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .history-booking-card:hover {
            border-color: #bfd0f5;
            box-shadow: 0 6px 16px rgba(40, 73, 142, 0.08);
        }

        .history-booking-code {
            color: var(--history-primary);
            font-weight: 800;
        }

        .history-booking-table {
            margin-bottom: 0;
        }

        .history-booking-table td {
            padding: 5px 4px;
            color: #526583;
            background: transparent !important;
            border: 0;
            font-size: 12px;
        }

        .history-booking-table td:first-child {
            width: 125px;
            color: #374e72;
        }

        .history-booking-table .total-row td {
            padding-top: 8px;
            padding-bottom: 8px;
            color: var(--history-text);
            background: #f4f7fd !important;
            border-top: 1px solid #e1e8f5;
            font-weight: 800;
        }

        /* =========================
           EMPTY
        ========================= */
        .history-empty-state {
            padding: 55px 15px !important;
            text-align: center;
        }

        .history-empty-state i {
            display: block;
            color: #b6c3dd;
            font-size: 35px;
            margin-bottom: 12px;
        }

        .history-empty-state span {
            color: var(--history-muted);
            font-weight: 600;
        }

        /* =========================
           PHÂN TRANG
        ========================= */
        .history-pagination {
            margin-top: 18px;
        }

        .history-pagination .pagination {
            gap: 5px;
            margin-bottom: 0;
        }

        .history-pagination .page-link {
            min-width: 35px;
            height: 35px;
            padding: 5px 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--history-primary);
            background: #fff;
            border: 1px solid #d7e0f2;
            border-radius: 8px !important;
            font-size: 13px;
            font-weight: 700;
            box-shadow: none;
        }

        .history-pagination .page-item.active .page-link {
            color: #fff;
            background: var(--history-primary);
            border-color: var(--history-primary);
        }

        .history-pagination .page-item.disabled .page-link {
            color: #aeb9cd;
            background: #f5f7fb;
        }

        /* =========================
           RESPONSIVE
        ========================= */
        @media (max-width: 767.98px) {
            .history-page-top {
                align-items: flex-start !important;
                flex-direction: column;
                gap: 14px;
            }

            .btn-history-back {
                width: 100%;
            }

            .history-list-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 15px;
            }

            .history-header-count {
                width: 100%;
            }

            .history-table-wrapper {
                padding: 10px;
            }

            .history-detail-content {
                padding: 12px;
            }

            .history-departure-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <div class="container-fluid merge-history-page">

        {{-- Header --}}
        <div class="history-page-top d-flex justify-content-between align-items-center mb-4">

            <div class="history-page-heading">
                <h3>
                    <i class="fas fa-history me-2"></i>
                    Lịch sử gộp đoàn
                </h3>

                <small>
                    Theo dõi toàn bộ yêu cầu và kết quả gộp đoàn trong hệ thống.
                </small>
            </div>

            <a href="{{ route('Admin.gop-doan.index') }}"
                class="btn btn-history-back">

                <i class="fas fa-arrow-left"></i>
                Quay lại

            </a>

        </div>

        {{-- Thống kê --}}
        <div class="row g-3 mb-4">

            <div class="col-xl-3 col-md-6">
                <div class="history-stat-card">

                    <div class="card-body">

                        <div class="history-stat-icon primary">
                            <i class="fas fa-list-check"></i>
                        </div>

                        <div>
                            <div class="history-stat-value">
                                {{ $data->total() }}
                            </div>

                            <div class="history-stat-label">
                                Tổng yêu cầu
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="history-stat-card">

                    <div class="card-body">

                        <div class="history-stat-icon success">
                            <i class="fas fa-calendar-check"></i>
                        </div>

                        <div>
                            <div class="history-stat-value">
                                {{ $data->sum('soLich') }}
                            </div>

                            <div class="history-stat-label">
                                Lịch đã gộp
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="history-stat-card">

                    <div class="card-body">

                        <div class="history-stat-icon info">
                            <i class="fas fa-people-arrows"></i>
                        </div>

                        <div>
                            <div class="history-stat-value">
                                {{ $data->sum('khachDaChuyen') }}
                            </div>

                            <div class="history-stat-label">
                                Khách đã chuyển
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="history-stat-card">

                    <div class="card-body">

                        <div class="history-stat-icon danger">
                            <i class="fas fa-user-clock"></i>
                        </div>

                        <div>
                            <div class="history-stat-value">
                                {{ $data->sum('khachBoLai') }}
                            </div>

                            <div class="history-stat-label">
                                Khách ở lại
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        {{-- Danh sách --}}
        <div class="history-list-card">

            <div class="history-list-header">

                <div class="history-title-group">

                    <div class="history-header-icon">
                        <i class="fas fa-clock-rotate-left"></i>
                    </div>

                    <div>
                        <h5>Danh sách yêu cầu gộp đoàn</h5>

                        <p>
                            Xem lịch sử, kết quả và thông tin booking của từng yêu cầu.
                        </p>
                    </div>

                </div>

                <div class="history-header-count">
                    <strong>{{ $data->total() }}</strong>
                    <span>Yêu cầu</span>
                </div>

            </div>

            <div class="history-table-wrapper">

                <div class="table-responsive history-table-box">

                    <table class="table table-hover align-middle history-table">

                        <thead>
                            <tr>
                                <th style="width: 60px">STT</th>
                                <th>Mã yêu cầu</th>
                                <th>Loại</th>
                                <th>Trạng thái</th>
                                <th>Tour</th>
                                <th>Lịch chính</th>
                                <th>Lịch gộp</th>
                                <th>Số lịch</th>
                                <th>Booking</th>
                                <th>Đã chuyển</th>
                                <th>Ở lại</th>
                                <th>Hoàn tất</th>
                                <th style="width: 120px">Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($data as $index => $yeuCau)

                                <tr class="history-main-row">

                                    {{-- STT --}}
                                    <td class="text-center">

                                        <span class="history-index">
                                            {{ $data->firstItem() + $index }}
                                        </span>

                                    </td>

                                    {{-- Mã yêu cầu --}}
                                    <td>

                                        <strong class="history-request-code"
                                            title="{{ $yeuCau->ma_yeu_cau }}"
                                            style="cursor: help;">

                                            {{ $yeuCau->ma_hien_thi }}

                                        </strong>

                                        <button type="button"
                                            class="btn btn-link btn-sm p-0 ms-1 history-copy-btn"
                                            onclick="navigator.clipboard.writeText(@js($yeuCau->ma_yeu_cau))"
                                            title="Sao chép mã">

                                            <i class="fas fa-copy"></i>

                                        </button>

                                    </td>

                                    {{-- Loại --}}
                                    <td class="text-center">

                                        @if ($yeuCau->loai_de_xuat === 'tu_dong')

                                            <span class="history-soft-badge history-soft-primary">

                                                <i class="fas fa-wand-magic-sparkles"></i>
                                                AI

                                            </span>

                                        @else

                                            <span class="history-soft-badge history-soft-secondary">

                                                <i class="fas fa-hand-pointer"></i>
                                                Thủ công

                                            </span>

                                        @endif

                                    </td>

                                    {{-- Trạng thái --}}
                                    <td class="text-center">

                                        @if ($yeuCau->trang_thai === 'cho_xu_ly')

                                            <span class="history-soft-badge history-soft-warning">

                                                <i class="fas fa-clock"></i>
                                                Chờ xử lý

                                            </span>

                                        @else

                                            <span class="history-soft-badge history-soft-success">

                                                <i class="fas fa-circle-check"></i>
                                                Hoàn tất

                                            </span>

                                        @endif

                                    </td>

                                    {{-- Tour --}}
                                    <td>

                                        <strong class="text-dark">
                                            {{ $yeuCau->tenTour }}
                                        </strong>

                                    </td>

                                    {{-- Lịch chính --}}
                                    <td class="text-center">

                                        @if ($yeuCau->lichChinh)

                                            <span class="history-soft-badge history-soft-primary">

                                                #{{ $yeuCau->lichChinh->lich_khoi_hanh_id }}

                                            </span>

                                        @else

                                            <span class="text-muted">—</span>

                                        @endif

                                    </td>

                                    {{-- Lịch gộp --}}
                                    <td class="text-center">

                                        @forelse($yeuCau->lich_bi_gop as $lich)

                                            <span class="history-soft-badge history-soft-info mb-1">

                                                #{{ $lich }}

                                            </span>

                                        @empty

                                            <span class="text-muted">—</span>

                                        @endforelse

                                    </td>

                                    {{-- Số lịch --}}
                                    <td class="text-center">

                                        <span class="history-soft-badge history-soft-primary">

                                            {{ $yeuCau->soLich }}

                                        </span>

                                    </td>

                                    {{-- Booking --}}
                                    <td class="text-center fw-bold">

                                        {{ $yeuCau->tongBooking }}

                                    </td>

                                    {{-- Đã chuyển --}}
                                    <td class="text-center">

                                        <span class="history-soft-badge history-soft-success">

                                            {{ $yeuCau->khachDaChuyen }}

                                        </span>

                                    </td>

                                    {{-- Ở lại --}}
                                    <td class="text-center">

                                        <span class="history-soft-badge history-soft-danger">

                                            {{ $yeuCau->khachBoLai }}

                                        </span>

                                    </td>

                                    {{-- Hoàn tất --}}
                                    <td class="text-center">

                                        @if ($yeuCau->trang_thai === 'hoan_tat')

                                            <span class="history-soft-badge history-soft-secondary">

                                                <i class="fas fa-calendar-check"></i>

                                                {{ optional($yeuCau->updated_at)->format('d/m/Y H:i') }}

                                            </span>

                                        @else

                                            <span class="text-muted">—</span>

                                        @endif

                                    </td>

                                    {{-- Thao tác --}}
                                    <td class="text-center">

                                        <button type="button"
                                            class="btn btn-history-view"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#detail{{ $yeuCau->id }}"
                                            aria-expanded="false"
                                            aria-controls="detail{{ $yeuCau->id }}">

                                            <i class="fas fa-eye me-1"></i>
                                            Xem

                                        </button>

                                    </td>

                                </tr>

                                {{-- Chi tiết --}}
                                <tr class="collapse history-detail-row"
                                    id="detail{{ $yeuCau->id }}">

                                    <td colspan="13">

                                        <div class="history-detail-content">

                                            <h5 class="history-detail-heading">

                                                <i class="fas fa-circle-info text-primary me-2"></i>

                                                Chi tiết yêu cầu
                                                {{ $yeuCau->ma_hien_thi }}

                                            </h5>

                                            @forelse($yeuCau->danhSachLich as $lichId => $chiTiets)

                                                @php
                                                    $lich = optional($chiTiets->first())->lichKhoiHanh;
                                                @endphp

                                                <div class="history-departure-card">

                                                    <div class="history-departure-header">

                                                        <div>

                                                            <strong>
                                                                <i class="fas fa-calendar-alt text-primary me-1"></i>
                                                                Lịch khởi hành #{{ $lichId }}
                                                            </strong>

                                                            @if (optional($chiTiets->first())->la_lich_chinh)

                                                                <span class="history-soft-badge history-soft-success ms-2">

                                                                    <i class="fas fa-star"></i>
                                                                    Lịch chính

                                                                </span>

                                                            @endif

                                                        </div>

                                                        <div>

                                                            <span class="text-muted">
                                                                Khởi hành:
                                                            </span>

                                                            <strong>

                                                                {{ optional($lich?->ngay_khoi_hanh)->format('d/m/Y') ?? 'Chưa xác định' }}

                                                            </strong>

                                                        </div>

                                                    </div>

                                                    <div class="history-departure-body">

                                                        <div class="row g-3">

                                                            @foreach ($chiTiets as $ct)

                                                                @php
                                                                    $booking = $ct->datTour;
                                                                @endphp

                                                                @if ($booking)

                                                                    <div class="col-xl-6">

                                                                        <div class="history-booking-card">

                                                                            <div class="d-flex justify-content-between align-items-center gap-2 mb-3">

                                                                                <strong class="history-booking-code">

                                                                                    <i class="fas fa-ticket me-1"></i>

                                                                                    {{ $booking->ma_dat_tour }}

                                                                                </strong>

                                                                                @switch($ct->trang_thai_lien_he)

                                                                                    @case('dong_y')

                                                                                        <span class="history-soft-badge history-soft-success">

                                                                                            <i class="fas fa-check"></i>
                                                                                            Đồng ý

                                                                                        </span>

                                                                                    @break

                                                                                    @case('tu_choi')

                                                                                        <span class="history-soft-badge history-soft-danger">

                                                                                            <i class="fas fa-xmark"></i>
                                                                                            Từ chối

                                                                                        </span>

                                                                                    @break

                                                                                    @default

                                                                                        <span class="history-soft-badge history-soft-warning">

                                                                                            <i class="fas fa-phone-slash"></i>
                                                                                            Chưa liên hệ

                                                                                        </span>

                                                                                @endswitch

                                                                            </div>

                                                                            <div class="table-responsive">

                                                                                <table class="table table-sm history-booking-table">

                                                                                    <tr>
                                                                                        <td>
                                                                                            <strong>Người đặt</strong>
                                                                                        </td>

                                                                                        <td>
                                                                                            {{ $booking->ten_nguoi_dat ?? '—' }}
                                                                                        </td>
                                                                                    </tr>

                                                                                    <tr>
                                                                                        <td>
                                                                                            <strong>Số điện thoại</strong>
                                                                                        </td>

                                                                                        <td>
                                                                                            {{ $booking->so_dien_thoai ?? '—' }}
                                                                                        </td>
                                                                                    </tr>

                                                                                    <tr>
                                                                                        <td>
                                                                                            <strong>Email</strong>
                                                                                        </td>

                                                                                        <td>
                                                                                            {{ $booking->email ?? '—' }}
                                                                                        </td>
                                                                                    </tr>

                                                                                    <tr>
                                                                                        <td>
                                                                                            <strong>Ngày đặt</strong>
                                                                                        </td>

                                                                                        <td>
                                                                                            {{ optional($booking->ngay_dat)->format('d/m/Y H:i') ?? '—' }}
                                                                                        </td>
                                                                                    </tr>

                                                                                    <tr>
                                                                                        <td>
                                                                                            <strong>Người lớn</strong>
                                                                                        </td>

                                                                                        <td>
                                                                                            {{ $booking->so_nguoi_lon ?? 0 }}
                                                                                        </td>
                                                                                    </tr>

                                                                                    <tr>
                                                                                        <td>
                                                                                            <strong>Trẻ em</strong>
                                                                                        </td>

                                                                                        <td>
                                                                                            {{ $booking->so_tre_em ?? 0 }}
                                                                                        </td>
                                                                                    </tr>

                                                                                    <tr>
                                                                                        <td>
                                                                                            <strong>Em bé</strong>
                                                                                        </td>

                                                                                        <td>
                                                                                            {{ $booking->so_em_be ?? 0 }}
                                                                                        </td>
                                                                                    </tr>

                                                                                    <tr class="total-row">

                                                                                        <td>
                                                                                            Tổng khách
                                                                                        </td>

                                                                                        <td>

                                                                                            <i class="fas fa-users me-1"></i>

                                                                                            {{ ($booking->so_nguoi_lon ?? 0)
                                                                                                + ($booking->so_tre_em ?? 0)
                                                                                                + ($booking->so_em_be ?? 0) }}

                                                                                        </td>

                                                                                    </tr>

                                                                                </table>

                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                @endif

                                                            @endforeach

                                                        </div>

                                                    </div>

                                                </div>

                                            @empty

                                                <div class="text-center py-4">

                                                    <i class="fas fa-folder-open text-muted fs-3 mb-2"></i>

                                                    <div class="text-muted">
                                                        Không có dữ liệu lịch khởi hành.
                                                    </div>

                                                </div>

                                            @endforelse

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="13" class="history-empty-state">

                                        <i class="fas fa-folder-open"></i>

                                        <span>
                                            Chưa có dữ liệu gộp đoàn.
                                        </span>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        {{-- Phân trang --}}
        @if ($data->hasPages())

            <div class="history-pagination">

                {{ $data->links() }}

            </div>

        @endif

    </div>
@endsection
