@extends('layouts.admin')

@section('title', 'Gộp đoàn thủ công')

@section('content')
    <style>
        :root {
            --manual-primary: #315be8;
            --manual-primary-dark: #2348c7;
            --manual-purple: #5c42e7;

            --manual-text: #173b77;
            --manual-normal: #33496f;
            --manual-muted: #7484a3;
            --manual-border: #dce5f5;

            --manual-success: #14996e;
            --manual-success-dark: #0d825c;
            --manual-success-bg: #e9f8f2;

            --manual-warning: #d18a08;
            --manual-warning-bg: #fff6dd;

            --manual-danger: #d94c61;
            --manual-danger-bg: #fff0f2;

            --manual-info: #197ec1;
            --manual-info-bg: #eaf7ff;
        }

        .manual-merge-page {
            color: var(--manual-normal);
            padding-bottom: 35px;
        }

        /* =========================
           HEADER
        ========================= */
        .manual-page-heading h3 {
            color: var(--manual-text);
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .manual-page-heading h3 i {
            color: var(--manual-success);
        }

        .manual-page-heading small {
            color: var(--manual-muted);
            font-size: 13px;
        }

        .btn-manual-back {
            min-height: 42px;
            padding: 9px 17px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            color: var(--manual-primary);
            background: #fff;
            border: 1px solid #cedaf3;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-manual-back:hover {
            color: #fff;
            background: var(--manual-primary);
            border-color: var(--manual-primary);
            transform: translateY(-1px);
            box-shadow: 0 7px 17px rgba(49, 91, 232, 0.2);
        }

        /* =========================
           ALERT
        ========================= */
        .manual-alert {
            border: 0;
            border-radius: 11px;
            padding: 14px 16px;
            box-shadow: 0 5px 15px rgba(34, 61, 119, 0.07);
        }

        /* =========================
           THỐNG KÊ
        ========================= */
        .manual-stat-card {
            height: 100%;
            position: relative;
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--manual-border);
            border-radius: 13px;
            box-shadow: 0 4px 14px rgba(32, 62, 130, 0.05);
            transition: all 0.2s ease;
        }

        .manual-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 24px rgba(32, 62, 130, 0.1);
        }

        .manual-stat-card::after {
            content: "";
            position: absolute;
            width: 88px;
            height: 88px;
            right: -30px;
            bottom: -36px;
            border-radius: 50%;
            background: #f4f7ff;
        }

        .manual-stat-card .card-body {
            min-height: 102px;
            position: relative;
            z-index: 1;
            padding: 19px 18px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .manual-stat-icon {
            width: 44px;
            height: 44px;
            flex: 0 0 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            font-size: 17px;
        }

        .manual-stat-icon.primary {
            color: var(--manual-primary);
            background: #edf2ff;
            border: 1px solid #cfdbff;
        }

        .manual-stat-icon.success {
            color: var(--manual-success);
            background: var(--manual-success-bg);
            border: 1px solid #c5ebdc;
        }

        .manual-stat-icon.danger {
            color: var(--manual-danger);
            background: var(--manual-danger-bg);
            border: 1px solid #efcad1;
        }

        .manual-stat-value {
            color: #12366f;
            font-size: 23px;
            line-height: 1;
            font-weight: 800;
            margin-bottom: 7px;
        }

        .manual-stat-label {
            color: var(--manual-muted);
            font-size: 12px;
            font-weight: 600;
        }

        /* =========================
           KHỐI TOUR
        ========================= */
        .manual-tour-card {
            overflow: hidden;
            margin-bottom: 22px;
            background: #fff;
            border: 1px solid var(--manual-border);
            border-radius: 14px;
            box-shadow: 0 7px 22px rgba(37, 66, 129, 0.07);
        }

        .manual-tour-header {
            min-height: 78px;
            position: relative;
            overflow: hidden;
            padding: 17px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            color: #fff;
            background: linear-gradient(
                110deg,
                #315be8 0%,
                #2871ee 65%,
                #5c42e7 100%
            );
        }

        .manual-tour-header::before,
        .manual-tour-header::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.07);
        }

        .manual-tour-header::before {
            width: 135px;
            height: 135px;
            right: 55px;
            top: -82px;
        }

        .manual-tour-header::after {
            width: 95px;
            height: 95px;
            right: -25px;
            bottom: -47px;
        }

        .manual-tour-title {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .manual-tour-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 40px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.12);
            font-size: 17px;
        }

        .manual-tour-title strong {
            display: block;
            color: #fff;
            font-size: 17px;
            font-weight: 800;
            line-height: 1.35;
        }

        .manual-tour-title small {
            display: block;
            color: rgba(255, 255, 255, 0.82);
            margin-top: 3px;
            font-size: 11px;
        }

        .manual-tour-count {
            min-width: 76px;
            position: relative;
            z-index: 2;
            padding: 8px 12px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.12);
        }

        .manual-tour-count strong {
            display: block;
            color: #fff;
            font-size: 19px;
            line-height: 1;
        }

        .manual-tour-count span {
            font-size: 10px;
            font-weight: 600;
            opacity: 0.88;
        }

        .manual-tour-body {
            padding: 18px;
        }

        /* =========================
           CARD LỊCH KHỞI HÀNH
        ========================= */
        .departure-option {
            height: 100%;
            display: block;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            background: #fff;
            border: 1px solid var(--manual-border);
            border-radius: 12px;
            box-shadow: 0 4px 13px rgba(35, 64, 128, 0.05);
            transition: all 0.2s ease;
        }

        .departure-option:hover {
            border-color: #b9caf3;
            transform: translateY(-2px);
            box-shadow: 0 9px 20px rgba(35, 64, 128, 0.1);
        }

        .departure-option.selected {
            border-color: var(--manual-primary);
            background: #f8faff;
            box-shadow: 0 0 0 2px rgba(49, 91, 232, 0.1);
        }

        .departure-option.selected::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
            background: var(--manual-primary);
        }

        .departure-option .card-body {
            padding: 16px;
        }

        .departure-select-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 12px;
        }

        .departure-check-label {
            color: var(--manual-text);
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
        }

        .departure-option .form-check-input {
            width: 18px;
            height: 18px;
            margin-top: 0;
            border-color: #aebddd;
            cursor: pointer;
            box-shadow: none;
        }

        .departure-option .form-check-input:checked {
            background-color: var(--manual-primary);
            border-color: var(--manual-primary);
        }

        .main-departure-box {
            padding: 9px 10px;
            margin-bottom: 13px;
            background: var(--manual-success-bg);
            border: 1px solid #c5ebdc;
            border-radius: 8px;
        }

        .main-departure-box .form-check {
            min-height: auto;
            margin: 0;
        }

        .main-departure-label {
            color: #087956;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        .main-departure-box .form-check-input:checked {
            background-color: var(--manual-success);
            border-color: var(--manual-success);
        }

        .main-departure-box .form-check-input:disabled {
            opacity: 0.45;
            cursor: not-allowed;
        }

        .departure-divider {
            height: 1px;
            margin: 13px 0;
            background: #e5ebf6;
        }

        .departure-info-list {
            display: flex;
            flex-direction: column;
            gap: 9px;
        }

        .departure-info-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            color: #5d6f8e;
            font-size: 12px;
        }

        .departure-info-label {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .departure-info-label i {
            width: 16px;
            text-align: center;
        }

        .departure-info-item strong {
            color: #253f69;
            font-weight: 800;
            white-space: nowrap;
        }

        .departure-footer {
            margin-top: 14px;
            padding-top: 13px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            border-top: 1px solid #e5ebf6;
        }

        /* =========================
           BADGE
        ========================= */
        .manual-soft-badge {
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

        .manual-soft-primary {
            color: var(--manual-primary);
            background: #edf2ff;
            border: 1px solid #d1dcff;
        }

        .manual-soft-success {
            color: #087956;
            background: var(--manual-success-bg);
            border: 1px solid #c0e8d7;
        }

        .manual-soft-warning {
            color: #a66c00;
            background: var(--manual-warning-bg);
            border: 1px solid #efdaa0;
        }

        .manual-soft-danger {
            color: #c43d52;
            background: var(--manual-danger-bg);
            border: 1px solid #f0c9d0;
        }

        .manual-soft-info {
            color: #1573af;
            background: var(--manual-info-bg);
            border: 1px solid #c5e5f8;
        }

        /* =========================
           LÝ DO GỘP
        ========================= */
        .manual-reason-card {
            overflow: hidden;
            background: #fff;
            border: 1px solid var(--manual-border);
            border-radius: 14px;
            box-shadow: 0 7px 22px rgba(37, 66, 129, 0.07);
        }

        .manual-reason-header {
            padding: 16px 19px;
            display: flex;
            align-items: center;
            gap: 11px;
            color: var(--manual-text);
            background: #f6f8fd;
            border-bottom: 1px solid #e1e8f5;
        }

        .manual-reason-header-icon {
            width: 37px;
            height: 37px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--manual-primary);
            background: #edf2ff;
            border: 1px solid #d1dcff;
            border-radius: 9px;
        }

        .manual-reason-header strong {
            font-size: 15px;
            font-weight: 800;
        }

        .manual-reason-header small {
            display: block;
            color: var(--manual-muted);
            margin-top: 2px;
            font-size: 11px;
        }

        .manual-reason-body {
            padding: 18px;
        }

        .manual-reason-textarea {
            min-height: 120px;
            padding: 13px 14px;
            color: var(--manual-normal);
            background: #fbfcff;
            border: 1px solid #d5dff1;
            border-radius: 10px;
            font-size: 13px;
            line-height: 1.6;
            resize: vertical;
            box-shadow: none;
        }

        .manual-reason-textarea:focus {
            background: #fff;
            border-color: var(--manual-primary);
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.1);
        }

        .manual-reason-textarea::placeholder {
            color: #a0acc1;
        }

        .manual-reason-footer {
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            background: #f8faff;
            border-top: 1px solid #e1e8f5;
        }

        .selection-note {
            color: var(--manual-muted);
            font-size: 12px;
        }

        .selection-note strong {
            color: var(--manual-primary);
        }

        .btn-create-manual-request {
            min-height: 43px;
            padding: 10px 18px;
            color: #fff;
            background: var(--manual-success);
            border: 1px solid var(--manual-success);
            border-radius: 9px;
            font-size: 13px;
            font-weight: 800;
            transition: all 0.2s ease;
        }

        .btn-create-manual-request:hover {
            color: #fff;
            background: var(--manual-success-dark);
            border-color: var(--manual-success-dark);
            transform: translateY(-1px);
            box-shadow: 0 7px 17px rgba(20, 153, 110, 0.22);
        }

        /* =========================
           EMPTY
        ========================= */
        .manual-empty-state {
            padding: 45px 20px;
            text-align: center;
            background: #fff;
            border: 1px dashed #ccd8ed;
            border-radius: 13px;
        }

        .manual-empty-state i {
            display: block;
            color: #b5c2da;
            font-size: 38px;
            margin-bottom: 13px;
        }

        .manual-empty-state strong {
            display: block;
            color: var(--manual-text);
            margin-bottom: 5px;
            font-size: 15px;
        }

        .manual-empty-state span {
            color: var(--manual-muted);
            font-size: 12px;
        }

        /* =========================
           RESPONSIVE
        ========================= */
        @media (max-width: 767.98px) {
            .manual-page-top {
                align-items: flex-start !important;
                flex-direction: column;
                gap: 14px;
            }

            .btn-manual-back {
                width: 100%;
            }

            .manual-tour-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .manual-tour-count {
                width: 100%;
            }

            .manual-reason-footer {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-create-manual-request {
                width: 100%;
            }
        }
    </style>

    <div class="container-fluid manual-merge-page">

        {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show manual-alert">
                <i class="fas fa-circle-check me-2"></i>

                {{ session('success') }}

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show manual-alert">
                <i class="fas fa-circle-exclamation me-2"></i>

                {{ session('error') }}

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>
            </div>
        @endif

        {{-- Header --}}
        <div class="manual-page-top d-flex justify-content-between align-items-center mb-4">

            <div class="manual-page-heading">

                <h3>
                    <i class="fas fa-hand-paper me-2"></i>
                    Gộp đoàn thủ công
                </h3>

                <small>
                    Chủ động lựa chọn các lịch khởi hành phù hợp để tạo yêu cầu gộp đoàn.
                </small>

            </div>

            <a href="{{ route('Admin.gop-doan.index') }}"
                class="btn btn-manual-back">

                <i class="fas fa-arrow-left"></i>
                Quay lại

            </a>

        </div>

        {{-- Thống kê --}}
        <div class="row g-3 mb-4">

            <div class="col-lg-4 col-md-6">
                <div class="manual-stat-card">

                    <div class="card-body">

                        <div class="manual-stat-icon primary">
                            <i class="fas fa-map-location-dot"></i>
                        </div>

                        <div>

                            <div class="manual-stat-value">
                                {{ $tours->count() }}
                            </div>

                            <div class="manual-stat-label">
                                Tour có thể gộp
                            </div>

                        </div>

                    </div>

                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="manual-stat-card">

                    <div class="card-body">

                        <div class="manual-stat-icon success">
                            <i class="fas fa-calendar-check"></i>
                        </div>

                        <div>

                            <div class="manual-stat-value">
                                {{ $tours->sum(fn($t) => $t->lichHopLe->count()) }}
                            </div>

                            <div class="manual-stat-label">
                                Lịch khả dụng
                            </div>

                        </div>

                    </div>

                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="manual-stat-card">

                    <div class="card-body">

                        <div class="manual-stat-icon danger">
                            <i class="fas fa-list-check"></i>
                        </div>

                        <div>

                            <div class="manual-stat-value">
                                <span id="soLichDaChon">0</span>
                            </div>

                            <div class="manual-stat-label">
                                Lịch đã chọn
                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>

        <form action="{{ route('Admin.gop-doan.thu-cong.store') }}"
            method="POST"
            id="formThuCong">

            @csrf

            @forelse($tours as $tour)

                <div class="manual-tour-card">

                    {{-- Header tour --}}
                    <div class="manual-tour-header">

                        <div class="manual-tour-title">

                            <div class="manual-tour-icon">
                                <i class="fas fa-map-marked-alt"></i>
                            </div>

                            <div>

                                <strong>
                                    {{ $tour->ten_tour }}
                                </strong>

                                <small>
                                    Chọn tối thiểu hai lịch thuộc tour để thực hiện gộp.
                                </small>

                            </div>

                        </div>

                        <div class="manual-tour-count">

                            <strong>
                                {{ $tour->lichHopLe->count() }}
                            </strong>

                            <span>Lịch khả dụng</span>

                        </div>

                    </div>

                    {{-- Danh sách lịch --}}
                    <div class="manual-tour-body">

                        <div class="row g-3">

                            @foreach ($tour->lichHopLe as $lich)

                                @php
                                    $xe = 14;

                                    if (($lich->so_cho_da_dat ?? 0) > 14) {
                                        $xe = 27;
                                    }

                                    if (($lich->so_cho_da_dat ?? 0) > 27) {
                                        $xe = 43;
                                    }
                                @endphp

                                <div class="col-xl-4 col-lg-6">

                                    <div class="departure-option"
                                        id="departureCard{{ $lich->id }}">

                                        <div class="card-body">

                                            {{-- Chọn lịch --}}
                                            <div class="departure-select-row">

                                                <div class="form-check mb-0">

                                                    <input class="form-check-input lich-checkbox"
                                                        type="checkbox"
                                                        name="lich_ids[]"
                                                        value="{{ $lich->id }}"
                                                        id="lich{{ $lich->id }}">

                                                    <label class="form-check-label departure-check-label ms-1"
                                                        for="lich{{ $lich->id }}">

                                                        Lịch #{{ $lich->id }}

                                                    </label>

                                                </div>

                                                <span class="manual-soft-badge manual-soft-primary">

                                                    <i class="fas fa-users"></i>

                                                    {{ $lich->so_cho_da_dat ?? 0 }}
                                                    khách

                                                </span>

                                            </div>

                                            {{-- Chọn lịch chính --}}
                                            <div class="main-departure-box">

                                                <div class="form-check">

                                                    <input class="form-check-input lich-chinh-radio"
                                                        type="radio"
                                                        name="lich_chinh_id"
                                                        value="{{ $lich->id }}"
                                                        id="radio{{ $lich->id }}"
                                                        disabled>

                                                    <label class="form-check-label main-departure-label ms-1"
                                                        for="radio{{ $lich->id }}">

                                                        <i class="fas fa-star me-1"></i>
                                                        Chọn làm lịch chính

                                                    </label>

                                                </div>

                                            </div>

                                            <div class="departure-divider"></div>

                                            {{-- Thông tin --}}
                                            <div class="departure-info-list">

                                                <div class="departure-info-item">

                                                    <span class="departure-info-label">

                                                        <i class="fas fa-calendar-alt text-primary"></i>

                                                        Khởi hành

                                                    </span>

                                                    <strong>

                                                        {{ optional($lich->ngay_khoi_hanh)->format('d/m/Y') ?? '—' }}

                                                    </strong>

                                                </div>

                                                <div class="departure-info-item">

                                                    <span class="departure-info-label">

                                                        <i class="fas fa-calendar-check text-success"></i>

                                                        Kết thúc

                                                    </span>

                                                    <strong>

                                                        {{ optional($lich->ngay_ket_thuc)->format('d/m/Y') ?? '—' }}

                                                    </strong>

                                                </div>

                                                <div class="departure-info-item">

                                                    <span class="departure-info-label">

                                                        <i class="fas fa-user-group text-info"></i>

                                                        Đã đặt

                                                    </span>

                                                    <strong>

                                                        {{ $lich->so_cho_da_dat ?? 0 }}
                                                        /
                                                        {{ $lich->so_cho ?? 0 }}

                                                    </strong>

                                                </div>

                                                <div class="departure-info-item">

                                                    <span class="departure-info-label">

                                                        <i class="fas fa-chair text-warning"></i>

                                                        Còn lại

                                                    </span>

                                                    <strong>

                                                        {{ $lich->so_cho_con_lai ?? 0 }}

                                                    </strong>

                                                </div>

                                            </div>

                                            <div class="departure-footer">

                                                <span class="manual-soft-badge manual-soft-success">

                                                    <i class="fas fa-bus"></i>
                                                    Xe {{ $xe }} chỗ

                                                </span>

                                                <span class="manual-soft-badge manual-soft-info">

                                                    <i class="fas fa-circle-check"></i>
                                                    Khả dụng

                                                </span>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>

                </div>

            @empty

                <div class="manual-empty-state">

                    <i class="fas fa-calendar-xmark"></i>

                    <strong>
                        Không có lịch đủ điều kiện
                    </strong>

                    <span>
                        Hiện tại không còn lịch khởi hành nào có thể thực hiện gộp đoàn.
                    </span>

                </div>

            @endforelse

            {{-- Lý do gộp --}}
            @if ($tours->count())

                <div class="manual-reason-card">

                    <div class="manual-reason-header">

                        <div class="manual-reason-header-icon">
                            <i class="fas fa-pen-to-square"></i>
                        </div>

                        <div>

                            <strong>
                                Lý do gộp đoàn
                            </strong>

                            <small>
                                Nhập lý do hoặc quyết định điều hành liên quan đến yêu cầu gộp.
                            </small>

                        </div>

                    </div>

                    <div class="manual-reason-body">

                        <textarea class="form-control manual-reason-textarea"
                            rows="4"
                            name="ly_do_de_xuat"
                            placeholder="Ví dụ: Gộp theo quyết định điều hành, tối ưu phương tiện, tối ưu nhân sự..."
                            required>{{ old('ly_do_de_xuat') }}</textarea>

                    </div>

                    <div class="manual-reason-footer">

                        <div class="selection-note">

                            Đã chọn:

                            <strong>
                                <span id="soLichDaChonFooter">0</span> lịch
                            </strong>

                            · Hệ thống yêu cầu tối thiểu 2 lịch.

                        </div>

                        <button type="submit"
                            class="btn btn-create-manual-request">

                            <i class="fas fa-circle-check me-1"></i>

                            Tạo yêu cầu gộp

                        </button>

                    </div>

                </div>

            @endif

        </form>

    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll(".lich-checkbox");
            const counter = document.getElementById("soLichDaChon");
            const footerCounter = document.getElementById("soLichDaChonFooter");
            const form = document.getElementById("formThuCong");

            function updateSelection() {
                let count = 0;

                checkboxes.forEach(function(checkbox) {
                    const card = checkbox.closest(".departure-option");
                    const radio = card.querySelector(".lich-chinh-radio");

                    if (checkbox.checked) {
                        count++;
                        radio.disabled = false;
                        card.classList.add("selected");
                    } else {
                        radio.disabled = true;
                        radio.checked = false;
                        card.classList.remove("selected");
                    }
                });

                if (counter) {
                    counter.innerText = count;
                }

                if (footerCounter) {
                    footerCounter.innerText = count;
                }

                const selectedRadio = document.querySelector(
                    ".lich-chinh-radio:checked"
                );

                if (!selectedRadio) {
                    const firstEnabled = document.querySelector(
                        ".lich-chinh-radio:not(:disabled)"
                    );

                    if (firstEnabled) {
                        firstEnabled.checked = true;
                    }
                }
            }

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener("change", updateSelection);
            });

            document.querySelectorAll(".departure-option").forEach(function(card) {
                card.addEventListener("click", function(event) {
                    const interactiveElement = event.target.closest(
                        "input, label, button, a, textarea, select"
                    );

                    if (interactiveElement) {
                        return;
                    }

                    const checkbox = card.querySelector(".lich-checkbox");

                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event("change"));
                });
            });

            updateSelection();

            if (form) {
                form.addEventListener("submit", function(event) {
                    const checked = document.querySelectorAll(
                        ".lich-checkbox:checked"
                    );

                    if (checked.length < 2) {
                        event.preventDefault();

                        alert("Bạn phải chọn tối thiểu 2 lịch khởi hành.");

                        return;
                    }

                    const selectedRadio = document.querySelector(
                        ".lich-chinh-radio:checked"
                    );

                    if (!selectedRadio) {
                        event.preventDefault();

                        alert("Bạn phải chọn một lịch làm lịch chính.");

                        return;
                    }

                    const selectedTourCards = new Set();

                    checked.forEach(function(checkbox) {
                        const tourCard = checkbox.closest(".manual-tour-card");

                        if (tourCard) {
                            selectedTourCards.add(tourCard);
                        }
                    });

                    if (selectedTourCards.size > 1) {
                        event.preventDefault();

                        alert(
                            "Các lịch được chọn phải thuộc cùng một tour."
                        );

                        return;
                    }

                    const confirmed = confirm(
                        "Bạn có chắc chắn muốn tạo yêu cầu gộp các lịch đã chọn?"
                    );

                    if (!confirmed) {
                        event.preventDefault();
                    }
                });
            }
        });
    </script>
@endsection
