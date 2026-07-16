@extends('layouts.admin')

@section('title', 'Quản lý Lịch trình Tour')

@section('breadcrumb')
    <li class="breadcrumb-item active">
        Quản lý Lịch trình Tour
    </li>
@endsection

@section('content')
    <style>
        :root {
            --schedule-primary: #315be8;
            --schedule-primary-dark: #244bd2;
            --schedule-purple: #5b4dea;
            --schedule-cyan: #16c7e8;

            --schedule-text-dark: #172b4d;
            --schedule-text-main: #344563;
            --schedule-text-muted: #6b7895;
            --schedule-text-light: #98a2b3;

            --schedule-border: #dce6f5;
            --schedule-border-light: #e8eef8;

            --schedule-white: #ffffff;
            --schedule-soft: #f5f8ff;
            --schedule-hover: #f3f7ff;

            --schedule-success: #08754a;
            --schedule-success-bg: #eaf9f1;

            --schedule-danger: #c13d55;
            --schedule-danger-bg: #fff0f3;

            --schedule-warning: #ae6c0d;
            --schedule-warning-bg: #fff7e8;
        }

        .tour-schedule-page {
            padding: 24px 0;
            color: var(--schedule-text-dark);
        }

        /* Header trang */
        .schedule-page-top {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
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

        /* Thống kê */
        .schedule-stats-grid {
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        .schedule-stat-card {
            position: relative;
            min-height: 105px;
            padding: 17px;
            overflow: hidden;
            background: var(--schedule-white);
            border: 1px solid var(--schedule-border);
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(28, 65, 139, 0.07);
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.18s ease;
        }

        .schedule-stat-card::after {
            position: absolute;
            right: -27px;
            bottom: -38px;
            width: 92px;
            height: 92px;
            content: "";
            background: rgba(49, 91, 232, 0.045);
            border-radius: 50%;
        }

        .schedule-stat-card:hover {
            border-color: #c4d7f6;
            box-shadow: 0 9px 24px rgba(38, 76, 148, 0.11);
            transform: translateY(-2px);
        }

        .schedule-stat-icon {
            position: relative;
            z-index: 2;
            width: 45px;
            height: 45px;
            flex-shrink: 0;
            border: 1px solid transparent;
            border-radius: 12px;
            font-size: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .stat-primary .schedule-stat-icon {
            color: #315be8;
            background: #edf4ff;
            border-color: #cfe0ff;
        }

        .stat-success .schedule-stat-icon {
            color: var(--schedule-success);
            background: var(--schedule-success-bg);
            border-color: #c5ead8;
        }

        .stat-danger .schedule-stat-icon {
            color: var(--schedule-danger);
            background: var(--schedule-danger-bg);
            border-color: #f0c9d1;
        }

        .stat-info .schedule-stat-icon {
            color: #24669e;
            background: #ebf7ff;
            border-color: #c9e7fa;
        }

        .schedule-stat-content {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .schedule-stat-value {
            color: #24417d;
            font-size: 23px;
            font-weight: 800;
            line-height: 1;
        }

        .schedule-stat-label {
            margin-top: 7px;
            color: var(--schedule-text-muted);
            font-size: 11px;
            font-weight: 650;
        }

        /* Card chính */
        .schedule-main-card {
            position: relative;
            overflow: hidden;
            background: var(--schedule-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
        }

        .schedule-main-card::before {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 3;
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
        .schedule-card-header {
            position: relative;
            min-height: 115px;
            padding: 24px;
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
            gap: 16px;
        }

        .schedule-card-header::before {
            position: absolute;
            right: -50px;
            bottom: -105px;
            width: 235px;
            height: 235px;
            content: "";
            border: 21px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .schedule-card-header::after {
            position: absolute;
            top: -85px;
            right: 115px;
            width: 175px;
            height: 175px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .schedule-card-heading {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .schedule-card-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            color: var(--schedule-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            box-shadow: 0 7px 18px rgba(20, 43, 128, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .schedule-card-icon i {
            font-size: 18px;
        }

        .schedule-card-heading h4 {
            margin: 0;
            color: var(--schedule-white);
            font-size: 20px;
            font-weight: 750;
        }

        .schedule-card-heading p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 12px;
        }

        .schedule-total {
            position: relative;
            z-index: 2;
            min-width: 105px;
            padding: 12px 15px;
            color: var(--schedule-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 11px;
            text-align: center;
        }

        .schedule-total strong {
            display: block;
            font-size: 22px;
            line-height: 1;
        }

        .schedule-total span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.85;
        }

        .schedule-card-body {
            padding: 22px;
        }

        /* Bộ lọc */
        .schedule-filter-box {
            margin-bottom: 20px;
            padding: 16px;
            background: var(--schedule-soft);
            border: 1px solid #d8e4f6;
            border-radius: 11px;
        }

        .schedule-filter-title {
            margin-bottom: 13px;
            color: #29457d;
            font-size: 13px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .schedule-filter-title i {
            color: var(--schedule-primary);
        }

        .schedule-filter-form {
            display: grid;
            grid-template-columns:
                minmax(270px, 1fr)
                minmax(200px, 280px)
                auto
                auto;
            gap: 10px;
            align-items: end;
        }

        .schedule-filter-field label {
            margin-bottom: 6px;
            color: #40537a;
            font-size: 12px;
            font-weight: 700;
            display: block;
        }

        .schedule-filter-control {
            position: relative;
        }

        .schedule-filter-control .field-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            z-index: 2;
            color: #7686a5;
            font-size: 12px;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .schedule-filter-form .form-control,
        .schedule-filter-form .form-select {
            width: 100%;
            min-height: 40px;
            color: #344563;
            background: var(--schedule-white);
            border: 1px solid #ccd9ed;
            border-radius: 8px;
            font-size: 13px;
            box-shadow: none;
        }

        .schedule-filter-form .form-control {
            padding-left: 34px;
        }

        .schedule-filter-form .form-control::placeholder {
            color: #9ca8bd;
        }

        .schedule-filter-form .form-control:focus,
        .schedule-filter-form .form-select:focus {
            border-color: #4f78eb;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.1);
        }

        .btn-filter-action {
            min-height: 40px;
            padding: 8px 14px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            text-decoration: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.18s ease;
        }

        .btn-filter-action:hover {
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-filter {
            color: var(--schedule-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
            box-shadow: 0 4px 11px rgba(49, 91, 232, 0.2);
        }

        .btn-filter:hover {
            color: var(--schedule-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #4c40d7
            );
            box-shadow: 0 6px 14px rgba(49, 91, 232, 0.27);
        }

        .btn-reset {
            color: #53698f;
            background: var(--schedule-white);
            border-color: #ccd9ed;
        }

        .btn-reset:hover {
            color: #304d83;
            background: #eaf1fb;
            border-color: #b9c9e0;
        }

        /* Bảng */
        .schedule-table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--schedule-border);
            border-radius: 11px;
        }

        .schedule-table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .schedule-table-wrapper::-webkit-scrollbar-track {
            background: #f2f5fa;
        }

        .schedule-table-wrapper::-webkit-scrollbar-thumb {
            background: #c5d2e5;
            border-radius: 999px;
        }

        .schedule-tour-table {
            width: 100%;
            min-width: 950px;
            margin-bottom: 0;
            color: var(--schedule-text-dark);
            vertical-align: middle;
        }

        .schedule-tour-table thead th {
            padding: 14px;
            color: #24417d;
            background: #f1f6ff;
            border-top: none;
            border-bottom: 1px solid #d8e5f8;
            font-size: 11px;
            font-weight: 750;
            letter-spacing: 0.025em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .schedule-tour-table tbody td {
            padding: 13px 14px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--schedule-border-light);
            font-size: 13px;
            line-height: 1.5;
            vertical-align: middle;
        }

        .schedule-tour-table tbody tr:last-child td {
            border-bottom: none;
        }

        .schedule-tour-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .schedule-tour-table tbody tr:hover {
            background: var(--schedule-hover);
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .schedule-tour-table th:nth-child(1),
        .schedule-tour-table td:nth-child(1) {
            width: 70px;
            text-align: center;
        }

        .schedule-tour-table th:nth-child(2),
        .schedule-tour-table td:nth-child(2) {
            width: 120px;
            text-align: center;
        }

        .schedule-tour-table th:nth-child(3),
        .schedule-tour-table td:nth-child(3) {
            width: 320px;
            text-align: left;
        }

        .schedule-tour-table th:nth-child(4),
        .schedule-tour-table td:nth-child(4) {
            width: 160px;
            text-align: center;
        }

        .schedule-tour-table th:nth-child(5),
        .schedule-tour-table td:nth-child(5) {
            width: 170px;
            text-align: center;
        }

        .schedule-tour-table th:nth-child(6),
        .schedule-tour-table td:nth-child(6) {
            width: 110px;
            text-align: center;
        }

        .tour-index {
            min-width: 30px;
            height: 30px;
            padding: 0 8px;
            color: #3158ce;
            background: #edf3ff;
            border: 1px solid #d4e2ff;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 750;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Ảnh tour */
        .tour-image-box {
            width: 88px;
            height: 62px;
            margin: 0 auto;
            overflow: hidden;
            background: #f4f7fc;
            border: 1px solid #dce6f5;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tour-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.22s ease;
        }

        .tour-image-box:hover img {
            transform: scale(1.06);
        }

        .tour-name-cell {
            min-width: 0;
        }

        .tour-name {
            max-width: 290px;
            overflow: hidden;
            color: #233f7a;
            font-size: 13px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .tour-id {
            margin-top: 4px;
            color: #8b97aa;
            font-size: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .duration-badge {
            padding: 5px 9px;
            color: #596b8e;
            background: #f4f7fc;
            border: 1px solid #dce4ef;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .duration-badge i {
            color: #6b83c3;
            font-size: 8px;
        }

        .tour-status {
            padding: 5px 10px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .status-dot {
            width: 6px;
            height: 6px;
            flex-shrink: 0;
            border-radius: 50%;
            background: currentColor;
        }

        .status-active {
            color: var(--schedule-success);
            background: var(--schedule-success-bg);
            border-color: #c5ead8;
        }

        .status-inactive {
            color: var(--schedule-danger);
            background: var(--schedule-danger-bg);
            border-color: #f0c9d1;
        }

        /* Nút xem */
        .btn-view-schedule {
            width: 34px;
            height: 34px;
            padding: 0;
            color: #2d5fd7;
            background: #eaf2ff;
            border: 1px solid #c7dafe;
            border-radius: 8px;
            font-size: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.18s ease;
        }

        .btn-view-schedule:hover {
            color: var(--schedule-white);
            background: #3867e5;
            border-color: #3867e5;
            box-shadow: 0 5px 12px rgba(56, 103, 229, 0.25);
            text-decoration: none;
            transform: translateY(-2px);
        }

        /* Empty state */
        .schedule-empty-row {
            padding: 52px 20px !important;
            color: #8793aa !important;
            text-align: center !important;
        }

        .empty-state-icon {
            width: 52px;
            height: 52px;
            margin: 0 auto 12px;
            color: #3664dd;
            background: #edf3ff;
            border: 1px solid #d3e1ff;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-state-icon i {
            font-size: 20px;
        }

        .empty-state-title {
            color: #506181;
            font-size: 14px;
            font-weight: 700;
        }

        .empty-state-text {
            margin-top: 4px;
            font-size: 12px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .schedule-stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .schedule-filter-form {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .btn-filter-action {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .tour-schedule-page {
                padding: 14px 0;
            }

            .schedule-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .schedule-page-heading h3 {
                font-size: 20px;
            }

            .schedule-main-card {
                border-radius: 11px;
            }

            .schedule-card-header {
                min-height: 105px;
                padding: 20px 18px;
            }

            .schedule-card-body {
                padding: 16px;
            }

            .schedule-filter-form {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 520px) {
            .schedule-stats-grid {
                grid-template-columns: 1fr;
            }

            .schedule-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .schedule-total {
                min-width: 100px;
                padding: 10px 13px;
            }
        }
    </style>

    <div class="container-fluid tour-schedule-page fade-in">
        <div class="schedule-page-top">
            <div class="schedule-page-heading">
                <h3>Quản lý Lịch trình Tour</h3>

                <p>
                    Chọn Tour để xem và quản lý lịch trình chi tiết theo từng
                    ngày.
                </p>
            </div>
        </div>

        <div class="schedule-stats-grid">
            <div class="schedule-stat-card stat-primary">
                <span class="schedule-stat-icon">
                    <i class="fas fa-route"></i>
                </span>

                <div class="schedule-stat-content">
                    <div class="schedule-stat-value">
                        {{ $tongTour }}
                    </div>

                    <div class="schedule-stat-label">
                        Tổng số Tour
                    </div>
                </div>
            </div>

            <div class="schedule-stat-card stat-success">
                <span class="schedule-stat-icon">
                    <i class="fas fa-check-circle"></i>
                </span>

                <div class="schedule-stat-content">
                    <div class="schedule-stat-value">
                        {{ $activeTour }}
                    </div>

                    <div class="schedule-stat-label">
                        Tour đang hoạt động
                    </div>
                </div>
            </div>

            <div class="schedule-stat-card stat-danger">
                <span class="schedule-stat-icon">
                    <i class="fas fa-ban"></i>
                </span>

                <div class="schedule-stat-content">
                    <div class="schedule-stat-value">
                        {{ $inactiveTour }}
                    </div>

                    <div class="schedule-stat-label">
                        Tour ngừng hoạt động
                    </div>
                </div>
            </div>

            <div class="schedule-stat-card stat-info">
                <span class="schedule-stat-icon">
                    <i class="fas fa-list"></i>
                </span>

                <div class="schedule-stat-content">
                    <div class="schedule-stat-value">
                        {{ $tours->count() }}
                    </div>

                    <div class="schedule-stat-label">
                        Tour đang hiển thị
                    </div>
                </div>
            </div>
        </div>

        <div class="schedule-main-card">
            <div class="schedule-card-header">
                <div class="schedule-card-heading">
                    <span class="schedule-card-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </span>

                    <div>
                        <h4>Danh sách Tour</h4>

                        <p>
                            Chọn một Tour để quản lý các ngày và hoạt động trong
                            lịch trình.
                        </p>
                    </div>
                </div>

                <div class="schedule-total">
                    <strong>{{ $tours->count() }}</strong>
                    <span>Tour hiển thị</span>
                </div>
            </div>

            <div class="schedule-card-body">
                <div class="schedule-filter-box">
                    <div class="schedule-filter-title">
                        <i class="fas fa-filter"></i>
                        Bộ lọc tìm kiếm
                    </div>

                    <form
                        method="GET"
                        action="{{ route('Admin.lich_trinh_tours.index') }}"
                        class="schedule-filter-form"
                    >
                        <div class="schedule-filter-field">
                            <label for="keyword">Tên Tour</label>

                            <div class="schedule-filter-control">
                                <i class="fas fa-search field-icon"></i>

                                <input
                                    type="text"
                                    name="keyword"
                                    id="keyword"
                                    class="form-control"
                                    placeholder="Nhập tên Tour..."
                                    value="{{ request('keyword') }}"
                                    autocomplete="off"
                                >
                            </div>
                        </div>

                        <div class="schedule-filter-field">
                            <label for="trang_thai">Trạng thái</label>

                            <select
                                name="trang_thai"
                                id="trang_thai"
                                class="form-select"
                            >
                                <option value="">
                                    Tất cả trạng thái
                                </option>

                                <option
                                    value="active"
                                    @selected(request('trang_thai') === 'active')
                                >
                                    Đang hoạt động
                                </option>

                                <option
                                    value="inactive"
                                    @selected(request('trang_thai') === 'inactive')
                                >
                                    Ngừng hoạt động
                                </option>
                            </select>
                        </div>

                        <button
                            type="submit"
                            class="btn-filter-action btn-filter"
                        >
                            <i class="fas fa-search"></i>
                            Tìm kiếm
                        </button>

                        <a
                            href="{{ route('Admin.lich_trinh_tours.index') }}"
                            class="btn-filter-action btn-reset"
                            title="Đặt lại bộ lọc"
                        >
                            <i class="fas fa-redo-alt"></i>
                            Đặt lại
                        </a>
                    </form>
                </div>

                <div class="schedule-table-wrapper">
                    <table class="table schedule-tour-table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Ảnh</th>
                                <th>Tên Tour</th>
                                <th>Thời lượng</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($tours as $tour)
                                <tr>
                                    <td>
                                        <span class="tour-index">
                                            {{ $loop->iteration }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="tour-image-box">
                                            @if ($tour->anh_dai_dien)
                                                <img
                                                    src="{{ asset('storage/' . $tour->anh_dai_dien) }}"
                                                    alt="{{ $tour->ten_tour }}"
                                                    loading="lazy"
                                                >
                                            @else
                                                <img
                                                    src="{{ asset('images/no-image.png') }}"
                                                    alt="Chưa có ảnh Tour"
                                                >
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        <div class="tour-name-cell">
                                            <span
                                                class="tour-name"
                                                title="{{ $tour->ten_tour }}"
                                            >
                                                {{ $tour->ten_tour }}
                                            </span>

                                            <span class="tour-id">
                                                <i class="fas fa-hashtag"></i>
                                                Mã Tour: {{ $tour->id }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        @if ($tour->thoi_luong)
                                            <span class="duration-badge">
                                                <i class="fas fa-clock"></i>
                                                {{ $tour->thoi_luong }}
                                            </span>
                                        @else
                                            <span class="text-muted">
                                                Chưa cập nhật
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($tour->trang_thai === 'active')
                                            <span class="tour-status status-active">
                                                <span class="status-dot"></span>
                                                Đang hoạt động
                                            </span>
                                        @else
                                            <span class="tour-status status-inactive">
                                                <span class="status-dot"></span>
                                                Ngừng hoạt động
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <a
                                            href="{{ route('Admin.lich_trinh_tours.tour', $tour->id) }}"
                                            class="btn-view-schedule"
                                            title="Xem lịch trình Tour"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="6"
                                        class="schedule-empty-row"
                                    >
                                        <div class="empty-state-icon">
                                            <i class="fas fa-folder-open"></i>
                                        </div>

                                        <div class="empty-state-title">
                                            Không tìm thấy Tour
                                        </div>

                                        <div class="empty-state-text">
                                            Hãy thay đổi từ khóa hoặc điều kiện
                                            lọc để tìm kiếm lại.
                                        </div>
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
