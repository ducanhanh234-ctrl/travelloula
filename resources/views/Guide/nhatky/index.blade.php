@extends('layouts.guide')

@section('title', 'Nhật ký Tour')

@section('guide', 'Nhật ký Tour')

@section('page-title', 'Nhật ký Tour')

@section('content')
    <style>
        :root {
            --tour-log-primary: #315be8;
            --tour-log-primary-dark: #264ed4;
            --tour-log-purple: #5b4dea;

            --tour-log-dark: #173576;
            --tour-log-text: #344563;
            --tour-log-muted: #6b7895;
            --tour-log-light: #98a2b3;

            --tour-log-white: #ffffff;
            --tour-log-soft: #f5f8ff;
            --tour-log-hover: #f3f7ff;

            --tour-log-border: #dce6f5;
            --tour-log-border-light: #e8eef8;

            --tour-log-success: #08754a;
            --tour-log-success-bg: #eaf9f1;

            --tour-log-warning: #ae6c0d;
            --tour-log-warning-bg: #fff7e8;

            --tour-log-info: #1975a8;
            --tour-log-info-bg: #ebf8ff;

            --tour-log-danger: #c13d55;
            --tour-log-danger-bg: #fff0f3;
        }

        .tour-log-page {
            padding: 4px 0 28px;
            color: var(--tour-log-text);
        }

        /* Header */
        .tour-log-header {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .tour-log-heading {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .tour-log-heading-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            color: var(--tour-log-white);
            background: linear-gradient(
                135deg,
                var(--tour-log-primary),
                var(--tour-log-purple)
            );
            border-radius: 13px;
            box-shadow: 0 8px 20px rgba(49, 91, 232, 0.23);
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .tour-log-heading h2 {
            margin: 0;
            color: var(--tour-log-dark);
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -0.25px;
        }

        .tour-log-heading p {
            margin: 5px 0 0;
            color: var(--tour-log-muted);
            font-size: 13px;
            line-height: 1.55;
        }

        .btn-tour-log-refresh {
            min-height: 42px;
            padding: 9px 15px;
            color: var(--tour-log-primary);
            background: var(--tour-log-white);
            border: 1px solid #c7d5f0;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 750;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition:
                color 0.18s ease,
                background-color 0.18s ease,
                border-color 0.18s ease,
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .btn-tour-log-refresh:hover {
            color: var(--tour-log-white);
            background: linear-gradient(
                135deg,
                var(--tour-log-primary),
                var(--tour-log-purple)
            );
            border-color: var(--tour-log-primary);
            text-decoration: none;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(49, 91, 232, 0.2);
        }

        /* Statistics */
        .tour-log-stats {
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .tour-log-stat-card {
            position: relative;
            min-width: 0;
            padding: 18px;
            overflow: hidden;
            background: var(--tour-log-white);
            border: 1px solid var(--tour-log-border);
            border-radius: 14px;
            box-shadow: 0 7px 23px rgba(28, 65, 139, 0.08);
            display: flex;
            align-items: center;
            gap: 14px;
            transition:
                transform 0.18s ease,
                border-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .tour-log-stat-card::after {
            content: "";
            position: absolute;
            right: -26px;
            bottom: -30px;
            width: 90px;
            height: 90px;
            background: currentColor;
            border-radius: 50%;
            opacity: 0.055;
            pointer-events: none;
        }

        .tour-log-stat-card:hover {
            border-color: #bdcdeb;
            transform: translateY(-2px);
            box-shadow: 0 11px 28px rgba(28, 65, 139, 0.12);
        }

        .tour-log-stat-card.is-total {
            color: var(--tour-log-primary);
        }

        .tour-log-stat-card.is-checkin {
            color: var(--tour-log-success);
        }

        .tour-log-stat-card.is-checkout {
            color: var(--tour-log-warning);
        }

        .tour-log-stat-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            border-radius: 12px;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .is-total .tour-log-stat-icon {
            color: var(--tour-log-primary);
            background: #edf3ff;
            border: 1px solid #d4e2ff;
        }

        .is-checkin .tour-log-stat-icon {
            color: var(--tour-log-success);
            background: var(--tour-log-success-bg);
            border: 1px solid #caead9;
        }

        .is-checkout .tour-log-stat-icon {
            color: var(--tour-log-warning);
            background: var(--tour-log-warning-bg);
            border: 1px solid #f0dbad;
        }

        .tour-log-stat-content {
            min-width: 0;
        }

        .tour-log-stat-number {
            margin: 0 0 3px;
            color: currentColor;
            font-size: 24px;
            font-weight: 850;
            line-height: 1.1;
        }

        .tour-log-stat-label {
            color: var(--tour-log-muted);
            font-size: 11px;
            font-weight: 750;
        }

        /* Shared card */
        .tour-log-card {
            margin-bottom: 20px;
            overflow: hidden;
            background: var(--tour-log-white);
            border: 1px solid var(--tour-log-border);
            border-radius: 15px;
            box-shadow: 0 8px 28px rgba(28, 65, 139, 0.09);
        }

        .tour-log-card:last-child {
            margin-bottom: 0;
        }

        .tour-log-card-header {
            min-height: 61px;
            padding: 15px 18px;
            color: #24417d;
            background: #f1f6ff;
            border-bottom: 1px solid var(--tour-log-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .tour-log-card-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .tour-log-card-title-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            color: var(--tour-log-primary);
            background: #e7efff;
            border: 1px solid #cfdfff;
            border-radius: 9px;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .tour-log-card-title h3 {
            margin: 0;
            color: #24417d;
            font-size: 15px;
            font-weight: 800;
        }

        .tour-log-card-title p {
            margin: 3px 0 0;
            color: var(--tour-log-muted);
            font-size: 10px;
        }

        .tour-log-card-body {
            padding: 18px;
        }

        /* Filter */
        .tour-log-filter-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.35fr) minmax(210px, 0.8fr) auto;
            gap: 12px;
            align-items: end;
        }

        .tour-log-field label {
            margin-bottom: 7px;
            color: #304d83;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.035em;
            text-transform: uppercase;
        }

        .tour-log-input-wrap {
            position: relative;
        }

        .tour-log-input-icon {
            position: absolute;
            top: 50%;
            left: 13px;
            z-index: 2;
            color: #7f8ba3;
            font-size: 12px;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .tour-log-field .form-control,
        .tour-log-field .form-select {
            min-height: 43px;
            color: var(--tour-log-text);
            background-color: var(--tour-log-white);
            border: 1px solid #ccd9ed;
            border-radius: 9px;
            font-size: 12px;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                background-color 0.18s ease;
        }

        .tour-log-field .form-control {
            padding-left: 38px;
        }

        .tour-log-field .form-control::placeholder {
            color: #98a3b8;
        }

        .tour-log-field .form-control:hover,
        .tour-log-field .form-select:hover {
            border-color: #b7c8e8;
        }

        .tour-log-field .form-control:focus,
        .tour-log-field .form-select:focus {
            background-color: #fbfdff;
            border-color: var(--tour-log-primary);
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.11);
        }

        .btn-tour-log-search {
            min-height: 43px;
            padding: 9px 19px;
            color: var(--tour-log-white);
            background: linear-gradient(
                135deg,
                var(--tour-log-primary),
                var(--tour-log-purple)
            );
            border: 1px solid var(--tour-log-primary);
            border-radius: 9px;
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 5px 13px rgba(49, 91, 232, 0.2);
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease,
                filter 0.18s ease;
        }

        .btn-tour-log-search:hover {
            color: var(--tour-log-white);
            filter: brightness(0.96);
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(49, 91, 232, 0.24);
        }

        /* Empty */
        .tour-log-empty {
            padding: 42px 20px;
            text-align: center;
            background: var(--tour-log-white);
            border: 1px dashed #c8d6ed;
            border-radius: 15px;
        }

        .tour-log-empty-icon {
            width: 58px;
            height: 58px;
            margin: 0 auto 12px;
            color: var(--tour-log-info);
            background: var(--tour-log-info-bg);
            border: 1px solid #cbe7f4;
            border-radius: 50%;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tour-log-empty h3 {
            margin: 0 0 5px;
            color: var(--tour-log-dark);
            font-size: 15px;
            font-weight: 800;
        }

        .tour-log-empty p {
            margin: 0;
            color: var(--tour-log-muted);
            font-size: 12px;
        }

        /* Table */
        .tour-log-table-wrap {
            overflow-x: auto;
        }

        .tour-log-table {
            width: 100%;
            min-width: 1050px;
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .tour-log-table thead th {
            padding: 13px 14px;
            color: #365181;
            background: #f4f7fd;
            border: 0;
            border-bottom: 1px solid var(--tour-log-border);
            font-size: 9px;
            font-weight: 850;
            letter-spacing: 0.045em;
            text-transform: uppercase;
            white-space: nowrap;
            vertical-align: middle;
        }

        .tour-log-table tbody td {
            padding: 14px;
            color: var(--tour-log-text);
            background: var(--tour-log-white);
            border: 0;
            border-bottom: 1px solid var(--tour-log-border-light);
            font-size: 11px;
            line-height: 1.55;
            vertical-align: middle;
        }

        .tour-log-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .tour-log-table tbody tr:hover td {
            background: var(--tour-log-hover);
        }

        .tour-log-index {
            width: 32px;
            height: 32px;
            margin: 0 auto;
            color: var(--tour-log-primary);
            background: #edf3ff;
            border: 1px solid #d4e2ff;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 850;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .tour-log-time {
            min-width: 120px;
        }

        .tour-log-time-date {
            color: #29457d;
            font-size: 11px;
            font-weight: 800;
        }

        .tour-log-time-hour {
            margin-top: 2px;
            color: var(--tour-log-muted);
            font-size: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .tour-log-main-text {
            color: #29457d;
            font-weight: 750;
        }

        .tour-log-sub-text {
            margin-top: 2px;
            color: var(--tour-log-muted);
            font-size: 10px;
        }

        .tour-log-badge {
            padding: 6px 10px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 850;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .tour-log-badge.is-checkin {
            color: var(--tour-log-success);
            background: var(--tour-log-success-bg);
            border-color: #c5ead8;
        }

        .tour-log-badge.is-checkout {
            color: var(--tour-log-warning);
            background: var(--tour-log-warning-bg);
            border-color: #f1dba9;
        }

        .tour-log-badge.is-other {
            color: #5f6f8c;
            background: #f0f3f8;
            border-color: #dbe2ec;
        }

        .btn-tour-log-view {
            min-height: 33px;
            padding: 7px 11px;
            color: var(--tour-log-primary);
            background: #edf3ff;
            border: 1px solid #cfddf8;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 800;
            text-decoration: none;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition:
                color 0.18s ease,
                background-color 0.18s ease,
                border-color 0.18s ease,
                transform 0.18s ease;
        }

        .btn-tour-log-view:hover {
            color: var(--tour-log-white);
            background: var(--tour-log-primary);
            border-color: var(--tour-log-primary);
            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Pagination */
        .tour-log-pagination {
            margin-top: 18px;
        }

        .tour-log-pagination .pagination {
            margin-bottom: 0;
            gap: 4px;
            flex-wrap: wrap;
        }

        .tour-log-pagination .page-link {
            min-width: 35px;
            min-height: 35px;
            padding: 7px 10px;
            color: #4a628d;
            background: var(--tour-log-white);
            border: 1px solid #d5dfef;
            border-radius: 8px !important;
            font-size: 10px;
            font-weight: 750;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: none;
        }

        .tour-log-pagination .page-link:hover {
            color: var(--tour-log-primary);
            background: #edf3ff;
            border-color: #c7d7f4;
        }

        .tour-log-pagination .page-item.active .page-link {
            color: var(--tour-log-white);
            background: linear-gradient(
                135deg,
                var(--tour-log-primary),
                var(--tour-log-purple)
            );
            border-color: var(--tour-log-primary);
        }

        .tour-log-pagination .page-item.disabled .page-link {
            color: #a3adbd;
            background: #f7f9fc;
        }

        @media (max-width: 992px) {
            .tour-log-filter-grid {
                grid-template-columns: 1fr 1fr;
            }

            .tour-log-filter-submit {
                grid-column: 1 / -1;
            }

            .btn-tour-log-search {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .tour-log-header {
                align-items: stretch;
                flex-direction: column;
            }

            .tour-log-heading h2 {
                font-size: 20px;
            }

            .btn-tour-log-refresh {
                width: 100%;
            }

            .tour-log-stats {
                grid-template-columns: 1fr;
            }

            .tour-log-filter-grid {
                grid-template-columns: 1fr;
            }

            .tour-log-filter-submit {
                grid-column: auto;
            }

            .tour-log-card-header {
                align-items: flex-start;
            }
        }

        @media (max-width: 480px) {
            .tour-log-heading {
                align-items: flex-start;
            }

            .tour-log-heading-icon {
                width: 43px;
                height: 43px;
            }

            .tour-log-stat-card,
            .tour-log-card-body {
                padding: 15px;
            }
        }
    </style>

    <div class="tour-log-page fade-in">
        {{-- Header --}}
        <div class="tour-log-header">
            <div class="tour-log-heading">
                <span class="tour-log-heading-icon">
                    <i class="fas fa-book-open"></i>
                </span>

                <div>
                    <h2>Nhật ký Tour</h2>

                    <p>
                        Theo dõi toàn bộ hoạt động Check-in và Check-out của hành khách.
                    </p>
                </div>
            </div>

            <a
                href="{{ route('Guide.nhatky.index') }}"
                class="btn-tour-log-refresh"
            >
                <i class="fas fa-rotate-right"></i>
                Làm mới dữ liệu
            </a>
        </div>

        {{-- Thống kê --}}
        <div class="tour-log-stats">
            <article class="tour-log-stat-card is-total">
                <span class="tour-log-stat-icon">
                    <i class="fas fa-list-check"></i>
                </span>

                <div class="tour-log-stat-content">
                    <div class="tour-log-stat-number">
                        {{ number_format($tongHoatDong ?? 0) }}
                    </div>

                    <div class="tour-log-stat-label">
                        Tổng hoạt động
                    </div>
                </div>
            </article>

            <article class="tour-log-stat-card is-checkin">
                <span class="tour-log-stat-icon">
                    <i class="fas fa-right-to-bracket"></i>
                </span>

                <div class="tour-log-stat-content">
                    <div class="tour-log-stat-number">
                        {{ number_format($tongCheckIn ?? 0) }}
                    </div>

                    <div class="tour-log-stat-label">
                        Lượt Check-in
                    </div>
                </div>
            </article>

            <article class="tour-log-stat-card is-checkout">
                <span class="tour-log-stat-icon">
                    <i class="fas fa-right-from-bracket"></i>
                </span>

                <div class="tour-log-stat-content">
                    <div class="tour-log-stat-number">
                        {{ number_format($tongCheckOut ?? 0) }}
                    </div>

                    <div class="tour-log-stat-label">
                        Lượt Check-out
                    </div>
                </div>
            </article>
        </div>

        {{-- Bộ lọc --}}
        <section class="tour-log-card">
            <div class="tour-log-card-header">
                <div class="tour-log-card-title">
                    <span class="tour-log-card-title-icon">
                        <i class="fas fa-filter"></i>
                    </span>

                    <div>
                        <h3>Tìm kiếm nhật ký</h3>
                        <p>Lọc theo tên khách hàng và loại hoạt động</p>
                    </div>
                </div>
            </div>

            <div class="tour-log-card-body">
                <form
                    action="{{ route('Guide.nhatky.index') }}"
                    method="GET"
                >
                    <div class="tour-log-filter-grid">
                        <div class="tour-log-field">
                            <label for="keyword">Khách hàng</label>

                            <div class="tour-log-input-wrap">
                                <span class="tour-log-input-icon">
                                    <i class="fas fa-user"></i>
                                </span>

                                <input
                                    id="keyword"
                                    type="text"
                                    name="keyword"
                                    class="form-control"
                                    placeholder="Nhập tên khách hàng..."
                                    value="{{ request('keyword') }}"
                                >
                            </div>
                        </div>

                        <div class="tour-log-field">
                            <label for="hanh_dong">Hoạt động</label>

                            <select
                                id="hanh_dong"
                                name="hanh_dong"
                                class="form-select"
                            >
                                <option value="">
                                    Tất cả hoạt động
                                </option>

                                <option
                                    value="CHECK_IN"
                                    {{ request('hanh_dong') === 'CHECK_IN' ? 'selected' : '' }}
                                >
                                    Check-in
                                </option>

                                <option
                                    value="CHECK_OUT"
                                    {{ request('hanh_dong') === 'CHECK_OUT' ? 'selected' : '' }}
                                >
                                    Check-out
                                </option>
                            </select>
                        </div>

                        <div class="tour-log-filter-submit">
                            <button
                                type="submit"
                                class="btn-tour-log-search"
                            >
                                <i class="fas fa-search"></i>
                                Tìm kiếm
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </section>

        @if ($logs->isEmpty())
            <div class="tour-log-empty">
                <div class="tour-log-empty-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>

                <h3>Chưa có nhật ký</h3>

                <p>
                    Không tìm thấy hoạt động Check-in hoặc Check-out phù hợp.
                </p>
            </div>
        @else
            {{-- Danh sách nhật ký --}}
            <section class="tour-log-card">
                <div class="tour-log-card-header">
                    <div class="tour-log-card-title">
                        <span class="tour-log-card-title-icon">
                            <i class="fas fa-clock-rotate-left"></i>
                        </span>

                        <div>
                            <h3>Danh sách hoạt động</h3>
                            <p>Chi tiết lịch sử Check-in và Check-out hành khách</p>
                        </div>
                    </div>
                </div>

                <div class="tour-log-table-wrap">
                    <table class="tour-log-table">
                        <thead>
                            <tr>
                                <th class="text-center" width="70">STT</th>
                                <th width="150">Thời gian</th>
                                <th width="140">Hành động</th>
                                <th>Tour</th>
                                <th>Khách hàng</th>
                                <th>Địa điểm Check-in</th>
                                <th class="text-center" width="110">Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($logs as $log)
                                @php
                                    $hanhDong = strtoupper(
                                        (string) ($log->hanh_dong ?? '')
                                    );

                                    $tenTour = data_get(
                                        $log,
                                        'chiTiet.lichTrinh.tour.ten_tour',
                                        '-'
                                    );

                                    $tenKhachHang = data_get(
                                        $log,
                                        'khachHang.ho_ten',
                                        '-'
                                    );

                                    $diaDiem = data_get(
                                        $log,
                                        'chiTiet.tieu_de',
                                        '-'
                                    );
                                @endphp

                                <tr>
                                    <td class="text-center">
                                        <span class="tour-log-index">
                                            {{
                                                ($logs->currentPage() - 1)
                                                * $logs->perPage()
                                                + $loop->iteration
                                            }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="tour-log-time">
                                            <div class="tour-log-time-date">
                                                {{ optional($log->created_at)->format('d/m/Y') ?? '-' }}
                                            </div>

                                            <div class="tour-log-time-hour">
                                                <i class="far fa-clock"></i>

                                                {{ optional($log->created_at)->format('H:i') ?? '-' }}
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        @if ($hanhDong === 'CHECK_IN')
                                            <span class="tour-log-badge is-checkin">
                                                <i class="fas fa-right-to-bracket"></i>
                                                Check-in
                                            </span>
                                        @elseif ($hanhDong === 'CHECK_OUT')
                                            <span class="tour-log-badge is-checkout">
                                                <i class="fas fa-right-from-bracket"></i>
                                                Check-out
                                            </span>
                                        @else
                                            <span class="tour-log-badge is-other">
                                                <i class="fas fa-circle-info"></i>
                                                {{ $log->hanh_dong ?: 'Không xác định' }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="tour-log-main-text">
                                            {{ $tenTour }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="tour-log-main-text">
                                            {{ $tenKhachHang }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="tour-log-main-text">
                                            {{ $diaDiem }}
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <a
                                            href="{{ route('Guide.nhatky.show', $log->id) }}"
                                            class="btn-tour-log-view"
                                        >
                                            <i class="fas fa-eye"></i>
                                            Xem
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>

            <div class="tour-log-pagination">
                {{ $logs->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection
