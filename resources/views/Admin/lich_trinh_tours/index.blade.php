@extends('layouts.admin')

@section('title', 'Quản lý Lịch trình Tour')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('Admin.tours.index') }}">
            Tour
        </a>
    </li>

    <li class="breadcrumb-item active">
        Lịch trình
    </li>
@endsection

@section('content')
    <style>
        :root {
            --schedule-primary: #315be8;
            --schedule-primary-dark: #244bd2;
            --schedule-primary-light: #edf4ff;
            --schedule-purple: #5b4dea;
            --schedule-cyan: #16c7e8;

            --schedule-text-dark: #172b4d;
            --schedule-text-main: #344563;
            --schedule-text-muted: #6b7895;
            --schedule-text-light: #98a2b3;

            --schedule-border: #dce6f5;
            --schedule-border-light: #e8eef8;

            --schedule-white: #ffffff;
            --schedule-hover: #f3f7ff;

            --schedule-success: #149963;
            --schedule-success-light: #eaf9f1;

            --schedule-warning: #c98212;
            --schedule-warning-light: #fff7e8;

            --schedule-danger: #dc4c64;
            --schedule-danger-light: #fff0f3;
        }

        .schedule-management-page {
            padding: 24px 0;
            color: var(--schedule-text-dark);
        }

        /* Tiêu đề trang */
        .schedule-page-top {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .schedule-page-heading {
            min-width: 0;
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
            color: #315be8;
            font-weight: 750;
        }

        .schedule-page-actions {
            display: flex;
            align-items: center;
            gap: 9px;
            flex-wrap: wrap;
        }

        .btn-page-action {
            min-height: 41px;
            padding: 9px 16px;
            border: 1px solid transparent;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition:
                color 0.18s ease,
                background 0.18s ease,
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.18s ease;
        }

        .btn-page-action:hover {
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-back-tour {
            color: #53698f;
            background: #f2f6fc;
            border-color: #d4dfef;
        }

        .btn-back-tour:hover {
            color: #304d83;
            background: #e7eef9;
            border-color: #bdcce3;
            box-shadow: 0 5px 13px rgba(41, 73, 132, 0.1);
        }

        .btn-add-schedule {
            color: var(--schedule-white);
            background: linear-gradient(
                135deg,
                #315be8 0%,
                #3c6df0 55%,
                #594bea 100%
            );
            border-color: #315be8;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.23);
        }

        .btn-add-schedule:hover {
            color: var(--schedule-white);
            background: linear-gradient(
                135deg,
                #264ed4 0%,
                #315edc 55%,
                #4d40d8 100%
            );
            border-color: #264ed4;
            box-shadow: 0 8px 20px rgba(49, 91, 232, 0.3);
        }

        /* Thống kê */
        .schedule-stats-grid {
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .schedule-stat-card {
            position: relative;
            min-height: 108px;
            padding: 17px;
            overflow: hidden;
            background: var(--schedule-white);
            border: 1px solid var(--schedule-border);
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(28, 65, 139, 0.07);
            display: flex;
            align-items: center;
            gap: 14px;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.18s ease;
        }

        .schedule-stat-card::after {
            position: absolute;
            right: -26px;
            bottom: -35px;
            width: 90px;
            height: 90px;
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

        .schedule-stat-primary .schedule-stat-icon {
            color: #315be8;
            background: #edf4ff;
            border-color: #cfe0ff;
        }

        .schedule-stat-success .schedule-stat-icon {
            color: #08754a;
            background: var(--schedule-success-light);
            border-color: #c5ead8;
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
        .schedule-card {
            position: relative;
            overflow: hidden;
            background: var(--schedule-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
        }

        .schedule-card::before {
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

        .schedule-header-content {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .schedule-header-icon {
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

        .schedule-header-icon i {
            font-size: 18px;
        }

        .schedule-card-header h4 {
            margin: 0;
            color: var(--schedule-white);
            font-size: 20px;
            font-weight: 750;
        }

        .schedule-card-header p {
            margin: 6px 0 0;
            max-width: 630px;
            overflow: hidden;
            color: rgba(255, 255, 255, 0.82);
            font-size: 12px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .schedule-total {
            position: relative;
            z-index: 2;
            min-width: 108px;
            padding: 12px 15px;
            color: var(--schedule-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 11px;
            text-align: center;
            backdrop-filter: blur(4px);
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
            background: var(--schedule-white);
        }

        /* Thanh thông tin */
        .tour-info-bar {
            margin-bottom: 18px;
            padding: 13px 15px;
            color: #536584;
            background: #f5f8ff;
            border: 1px solid #d8e4f6;
            border-radius: 10px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .tour-info-main {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .tour-info-main i {
            color: #315be8;
        }

        .tour-info-main strong {
            overflow: hidden;
            color: #29457d;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .tour-code {
            padding: 5px 9px;
            color: #3158ce;
            background: #ffffff;
            border: 1px solid #ccdcf7;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
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

        .schedule-table {
            width: 100%;
            min-width: 850px;
            margin-bottom: 0;
            color: var(--schedule-text-dark);
            vertical-align: middle;
        }

        .schedule-table thead th {
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

        .schedule-table tbody td {
            padding: 14px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--schedule-border-light);
            font-size: 13px;
            line-height: 1.5;
            vertical-align: middle;
        }

        .schedule-table tbody tr:last-child td {
            border-bottom: none;
        }

        .schedule-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .schedule-table tbody tr:hover {
            background: var(--schedule-hover);
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .schedule-table th:nth-child(1),
        .schedule-table td:nth-child(1) {
            width: 120px;
            text-align: center;
        }

        .schedule-table th:nth-child(2),
        .schedule-table td:nth-child(2) {
            width: 330px;
            text-align: left;
        }

        .schedule-table th:nth-child(3),
        .schedule-table td:nth-child(3) {
            width: 280px;
            text-align: left;
        }

        .schedule-table th:nth-child(4),
        .schedule-table td:nth-child(4) {
            width: 145px;
            text-align: center;
        }

        /* Badge ngày */
        .day-badge {
            min-width: 72px;
            padding: 6px 10px;
            color: #3158ce;
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 750;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .day-badge i {
            font-size: 8px;
        }

        /* Tiêu đề */
        .schedule-title-cell {
            min-width: 0;
        }

        .schedule-title {
            max-width: 300px;
            overflow: hidden;
            color: #233f7a;
            font-size: 13px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .schedule-subtitle {
            margin-top: 4px;
            color: #8b97aa;
            font-size: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Địa điểm */
        .schedule-location {
            max-width: 250px;
            color: #5b6b88;
            display: flex;
            align-items: flex-start;
            gap: 7px;
        }

        .schedule-location i {
            margin-top: 3px;
            flex-shrink: 0;
            color: #dc4c64;
            font-size: 11px;
        }

        .schedule-location span {
            overflow-wrap: anywhere;
        }

        .empty-value {
            color: var(--schedule-text-light);
            font-size: 11px;
            font-style: italic;
        }

        /* Nút hành động */
        .schedule-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            flex-wrap: nowrap;
        }

        .schedule-actions form {
            display: inline-flex;
            margin: 0;
        }

        .btn-table-action {
            width: 31px;
            height: 31px;
            padding: 0;
            border: 1px solid transparent;
            border-radius: 7px;
            font-size: 11px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition:
                background-color 0.16s ease,
                border-color 0.16s ease,
                color 0.16s ease,
                box-shadow 0.16s ease,
                transform 0.16s ease;
        }

        .btn-table-action:hover {
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-detail {
            color: #2d5fd7;
            background: #eaf2ff;
            border-color: #c7dafe;
        }

        .btn-detail:hover {
            color: var(--schedule-white);
            background: #3867e5;
            border-color: #3867e5;
            box-shadow: 0 5px 12px rgba(56, 103, 229, 0.25);
        }

        .btn-edit {
            color: #b87511;
            background: var(--schedule-warning-light);
            border-color: #f1dba9;
        }

        .btn-edit:hover {
            color: var(--schedule-white);
            background: #e39a25;
            border-color: #e39a25;
            box-shadow: 0 5px 12px rgba(227, 154, 37, 0.24);
        }

        .btn-delete {
            color: #cb4058;
            background: var(--schedule-danger-light);
            border-color: #f0c9d1;
        }

        .btn-delete:hover {
            color: var(--schedule-white);
            background: #df5067;
            border-color: #df5067;
            box-shadow: 0 5px 12px rgba(223, 80, 103, 0.23);
        }

        .btn-table-action:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.14);
        }

        /* Không có dữ liệu */
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

        .empty-add-link {
            margin-top: 13px;
            color: #315be8;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .empty-add-link:hover {
            color: #244bd2;
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .schedule-management-page {
                padding: 14px 0;
            }

            .schedule-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .schedule-page-heading h3 {
                font-size: 20px;
            }

            .schedule-page-actions {
                width: 100%;
            }

            .btn-page-action {
                flex: 1;
            }

            .schedule-stats-grid {
                grid-template-columns: 1fr;
            }

            .schedule-card {
                border-radius: 11px;
            }

            .schedule-card-header {
                min-height: 105px;
                padding: 20px 18px;
            }

            .schedule-card-body {
                padding: 16px;
            }
        }

        @media (max-width: 520px) {
            .schedule-page-actions {
                flex-direction: column;
            }

            .btn-page-action {
                width: 100%;
            }

            .schedule-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .schedule-card-header p {
                max-width: 260px;
            }

            .schedule-total {
                min-width: 100px;
                padding: 10px 13px;
            }

            .tour-info-bar {
                align-items: flex-start;
                flex-direction: column;
            }

            .tour-info-main strong {
                white-space: normal;
            }
        }
    </style>

    <div class="container-fluid schedule-management-page fade-in">
        <div class="schedule-page-top">
            <div class="schedule-page-heading">
                <h3>Quản lý Lịch trình Tour</h3>

                <p>
                    Tour:
                    <span class="schedule-tour-name">
                        {{ $tour->ten_tour }}
                    </span>
                </p>
            </div>

            <div class="schedule-page-actions">
                <a
                    href="{{ route('Admin.tours.index') }}"
                    class="btn-page-action btn-back-tour"
                >
                    <i class="fas fa-arrow-left"></i>
                    Danh sách Tour
                </a>

                <a
                    href="{{ route('Admin.lich_trinh_tours.create', ['tour_id' => $tour->id]) }}"
                    class="btn-page-action btn-add-schedule"
                >
                    <i class="fas fa-plus"></i>
                    Thêm lịch trình
                </a>
            </div>
        </div>

        <div class="schedule-stats-grid">
            <div class="schedule-stat-card schedule-stat-primary">
                <span class="schedule-stat-icon">
                    <i class="fas fa-calendar-alt"></i>
                </span>

                <div class="schedule-stat-content">
                    <div class="schedule-stat-value">
                        {{ $tongNgay }}
                    </div>

                    <div class="schedule-stat-label">
                        Tổng ngày lịch trình
                    </div>
                </div>
            </div>

            <div class="schedule-stat-card schedule-stat-success">
                <span class="schedule-stat-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </span>

                <div class="schedule-stat-content">
                    <div class="schedule-stat-value">
                        {{ $tongDiaDiem }}
                    </div>

                    <div class="schedule-stat-label">
                        Tổng số địa điểm
                    </div>
                </div>
            </div>
        </div>

        <div class="schedule-card">
            <div class="schedule-card-header">
                <div class="schedule-header-content">
                    <span class="schedule-header-icon">
                        <i class="fas fa-route"></i>
                    </span>

                    <div>
                        <h4>Danh sách lịch trình</h4>

                        <p>
                            Sắp xếp nội dung, địa điểm và hoạt động theo từng
                            ngày của Tour.
                        </p>
                    </div>
                </div>

                <div class="schedule-total">
                    <strong>{{ $lichTrinhs->count() }}</strong>
                    <span>Ngày lịch trình</span>
                </div>
            </div>

            <div class="schedule-card-body">
                <div class="tour-info-bar">
                    <div class="tour-info-main">
                        <i class="fas fa-map-marked-alt"></i>

                        <span>Đang quản lý lịch trình của:</span>

                        <strong title="{{ $tour->ten_tour }}">
                            {{ $tour->ten_tour }}
                        </strong>
                    </div>

                    <span class="tour-code">
                        Mã Tour: #{{ $tour->id }}
                    </span>
                </div>

                <div class="schedule-table-wrapper">
                    <table class="table schedule-table">
                        <thead>
                            <tr>
                                <th>Ngày</th>
                                <th>Tiêu đề</th>
                                <th>Địa điểm</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($lichTrinhs as $item)
                                <tr>
                                    <td>
                                        <span class="day-badge">
                                            <i class="fas fa-calendar-day"></i>
                                            Ngày {{ $item->ngay_thu }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="schedule-title-cell">
                                            <span
                                                class="schedule-title"
                                                title="{{ $item->tieu_de }}"
                                            >
                                                {{ $item->tieu_de }}
                                            </span>

                                            <span class="schedule-subtitle">
                                                <i class="fas fa-list-ol"></i>
                                                Lịch trình ngày
                                                {{ $item->ngay_thu }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        @if ($item->dia_diem)
                                            <div class="schedule-location">
                                                <i class="fas fa-map-marker-alt"></i>

                                                <span>
                                                    {{ $item->dia_diem }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="empty-value">
                                                Chưa cập nhật địa điểm
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="schedule-actions">
                                            <a
                                                href="{{ route('Admin.chi_tiet_lich_trinhs.index', $item->id) }}"
                                                class="btn-table-action btn-detail"
                                                title="Quản lý chi tiết lịch trình"
                                                data-bs-toggle="tooltip"
                                            >
                                                <i class="fas fa-list-ol"></i>
                                            </a>

                                            <a
                                                href="{{ route('Admin.lich_trinh_tours.edit', $item->id) }}"
                                                class="btn-table-action btn-edit"
                                                title="Chỉnh sửa lịch trình"
                                                data-bs-toggle="tooltip"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form
                                                action="{{ route('Admin.lich_trinh_tours.destroy', $item->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa lịch trình ngày {{ $item->ngay_thu }}?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn-table-action btn-delete"
                                                    title="Xóa lịch trình"
                                                    data-bs-toggle="tooltip"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="4"
                                        class="schedule-empty-row"
                                    >
                                        <div class="empty-state-icon">
                                            <i class="fas fa-folder-open"></i>
                                        </div>

                                        <div class="empty-state-title">
                                            Chưa có lịch trình nào
                                        </div>

                                        <div class="empty-state-text">
                                            Hãy thêm ngày đầu tiên cho Tour này.
                                        </div>

                                        <a
                                            href="{{ route('Admin.lich_trinh_tours.create', ['tour_id' => $tour->id]) }}"
                                            class="empty-add-link"
                                        >
                                            <i class="fas fa-plus"></i>
                                            Thêm lịch trình
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof bootstrap !== 'undefined') {
                document
                    .querySelectorAll('[data-bs-toggle="tooltip"]')
                    .forEach(function (element) {
                        new bootstrap.Tooltip(element);
                    });
            }
        });
    </script>
@endsection
