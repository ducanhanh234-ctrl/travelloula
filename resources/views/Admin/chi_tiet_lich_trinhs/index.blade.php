@extends('Layouts.admin')

@section('title', 'Hoạt động theo giờ')

@section('content')
    <style>
        :root {
            --activity-primary: #315be8;
            --activity-primary-dark: #244bd2;
            --activity-primary-light: #edf4ff;
            --activity-purple: #5b4dea;
            --activity-cyan: #16c7e8;

            --activity-text-dark: #172b4d;
            --activity-text-main: #344563;
            --activity-text-muted: #6b7895;
            --activity-text-light: #98a2b3;

            --activity-border: #dce6f5;
            --activity-border-light: #e8eef8;

            --activity-white: #ffffff;
            --activity-soft-bg: #f5f8ff;
            --activity-hover: #f3f7ff;

            --activity-success: #08754a;
            --activity-success-bg: #eaf9f1;

            --activity-warning: #ae6c0d;
            --activity-warning-bg: #fff7e8;

            --activity-danger: #c13d55;
            --activity-danger-bg: #fff0f3;
        }

        .activity-page {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            padding: 24px 0;
            color: var(--activity-text-dark);
        }

        /* Tiêu đề trang */
        .activity-page-top {
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .activity-page-heading h3 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .activity-page-heading p {
            margin: 6px 0 0;
            color: var(--activity-text-muted);
            font-size: 14px;
        }

        .activity-schedule-name {
            color: var(--activity-primary);
            font-weight: 750;
        }

        .activity-page-actions {
            display: flex;
            align-items: center;
            gap: 9px;
            flex-wrap: wrap;
        }

        .btn-page-action {
            min-height: 40px;
            padding: 8px 15px;
            border: 1px solid transparent;
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

        .btn-page-action:hover {
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-back-schedule {
            color: #53698f;
            background: #f2f6fc;
            border-color: #d4dfef;
        }

        .btn-back-schedule:hover {
            color: #304d83;
            background: #e7eef9;
            border-color: #bdcce3;
            box-shadow: 0 5px 13px rgba(41, 73, 132, 0.1);
        }

        .btn-add-activity {
            color: var(--activity-white);
            background: linear-gradient(
                135deg,
                #315be8 0%,
                #3b6dee 55%,
                #594bea 100%
            );
            border-color: #315be8;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.23);
        }

        .btn-add-activity:hover {
            color: var(--activity-white);
            background: linear-gradient(
                135deg,
                #264ed4 0%,
                #315edc 55%,
                #4d40d8 100%
            );
            border-color: #264ed4;
            box-shadow: 0 8px 19px rgba(49, 91, 232, 0.3);
        }

        /* Thông báo */
        .activity-alert {
            margin-bottom: 18px;
            padding: 14px 16px;
            color: var(--activity-success);
            background: var(--activity-success-bg);
            border: 1px solid #bfead3;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(16, 24, 40, 0.05);
            font-size: 13px;
            font-weight: 650;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Card chính */
        .activity-card {
            position: relative;
            overflow: hidden;
            background: var(--activity-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 10px 32px rgba(28, 65, 139, 0.11);
        }

        .activity-card::before {
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

        /* Header */
        .activity-card-header {
            position: relative;
            min-height: 150px;
            padding: 27px 30px;
            overflow: hidden;
            color: var(--activity-white);
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

        .activity-card-header::before {
            position: absolute;
            right: -60px;
            bottom: -125px;
            width: 280px;
            height: 280px;
            content: "";
            border: 23px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .activity-card-header::after {
            position: absolute;
            top: -100px;
            right: 125px;
            width: 195px;
            height: 195px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .activity-header-content {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .activity-header-icon {
            width: 58px;
            height: 58px;
            flex-shrink: 0;
            color: var(--activity-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.32);
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(20, 43, 128, 0.2);
            font-size: 21px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .activity-header-info {
            min-width: 0;
        }

        .activity-header-info h4 {
            margin: 0;
            color: var(--activity-white);
            font-size: 22px;
            font-weight: 750;
        }

        .activity-header-info p {
            margin: 7px 0 0;
            max-width: 560px;
            overflow: hidden;
            color: rgba(255, 255, 255, 0.84);
            font-size: 13px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .activity-header-info p i {
            margin-right: 6px;
        }

        .activity-total {
            position: relative;
            z-index: 2;
            min-width: 112px;
            padding: 13px 16px;
            color: var(--activity-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.26);
            border-radius: 12px;
            text-align: center;
            backdrop-filter: blur(5px);
        }

        .activity-total strong {
            display: block;
            font-size: 22px;
            line-height: 1;
        }

        .activity-total span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.84;
        }

        /* Nội dung */
        .activity-card-body {
            padding: 24px;
        }

        /* Thông tin lịch trình */
        .schedule-summary {
            margin-bottom: 20px;
            padding: 14px 16px;
            background: var(--activity-soft-bg);
            border: 1px solid var(--activity-border);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .schedule-summary-main {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .schedule-summary-icon {
            width: 37px;
            height: 37px;
            flex-shrink: 0;
            color: var(--activity-primary);
            background: var(--activity-white);
            border: 1px solid #cfe0ff;
            border-radius: 9px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .schedule-summary-content {
            min-width: 0;
        }

        .schedule-summary-content span {
            display: block;
            color: #7c899f;
            font-size: 10px;
            font-weight: 650;
        }

        .schedule-summary-content strong {
            display: block;
            margin-top: 3px;
            overflow: hidden;
            color: #29457d;
            font-size: 13px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .schedule-day-badge {
            padding: 6px 10px;
            color: #3158ce;
            background: var(--activity-white);
            border: 1px solid #ccdcf7;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* Bảng */
        .activity-table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--activity-border);
            border-radius: 11px;
        }

        .activity-table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .activity-table-wrapper::-webkit-scrollbar-track {
            background: #f2f5fa;
        }

        .activity-table-wrapper::-webkit-scrollbar-thumb {
            background: #c5d2e5;
            border-radius: 999px;
        }

        .activity-table {
            width: 100%;
            min-width: 900px;
            margin-bottom: 0;
            color: var(--activity-text-dark);
            vertical-align: middle;
        }

        .activity-table thead th {
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

        .activity-table tbody td {
            padding: 14px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--activity-border-light);
            font-size: 13px;
            line-height: 1.6;
            vertical-align: middle;
        }

        .activity-table tbody tr:last-child td {
            border-bottom: none;
        }

        .activity-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .activity-table tbody tr:hover {
            background: var(--activity-hover);
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .activity-table th:nth-child(1),
        .activity-table td:nth-child(1) {
            width: 190px;
            text-align: center;
        }

        .activity-table th:nth-child(2),
        .activity-table td:nth-child(2) {
            width: 250px;
            text-align: left;
        }

        .activity-table th:nth-child(3),
        .activity-table td:nth-child(3) {
            text-align: left;
        }

        .activity-table th:nth-child(4),
        .activity-table td:nth-child(4) {
            width: 125px;
            text-align: center;
        }

        /* Khung giờ */
        .activity-time {
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
            gap: 6px;
        }

        .activity-time i {
            font-size: 9px;
        }

        /* Tiêu đề hoạt động */
        .activity-title {
            max-width: 220px;
            overflow: hidden;
            color: #233f7a;
            font-size: 13px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .activity-order {
            margin-top: 4px;
            color: #8b97aa;
            font-size: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Nội dung */
        .activity-description {
            max-width: 470px;
            color: #5b6b88;
            line-height: 1.7;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        .empty-value {
            color: var(--activity-text-light);
            font-size: 11px;
            font-style: italic;
        }

        /* Hành động */
        .activity-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            flex-wrap: nowrap;
        }

        .activity-actions form {
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
            transition: all 0.16s ease;
        }

        .btn-table-action:hover {
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-edit {
            color: var(--activity-warning);
            background: var(--activity-warning-bg);
            border-color: #f1dba9;
        }

        .btn-edit:hover {
            color: var(--activity-white);
            background: #e39a25;
            border-color: #e39a25;
            box-shadow: 0 5px 12px rgba(227, 154, 37, 0.24);
        }

        .btn-delete {
            color: var(--activity-danger);
            background: var(--activity-danger-bg);
            border-color: #f0c9d1;
        }

        .btn-delete:hover {
            color: var(--activity-white);
            background: #df5067;
            border-color: #df5067;
            box-shadow: 0 5px 12px rgba(223, 80, 103, 0.23);
        }

        .btn-table-action:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.14);
        }

        /* Không có dữ liệu */
        .activity-empty-row {
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
            color: var(--activity-primary);
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .empty-add-link:hover {
            color: var(--activity-primary-dark);
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .activity-page {
                padding: 15px 0;
            }

            .activity-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .activity-page-actions {
                width: 100%;
            }

            .btn-page-action {
                flex: 1;
            }

            .activity-card {
                border-radius: 11px;
            }

            .activity-card-header {
                min-height: 130px;
                padding: 23px 20px;
                align-items: flex-start;
                flex-direction: column;
            }

            .activity-card-body {
                padding: 18px;
            }
        }

        @media (max-width: 520px) {
            .activity-page-heading h3 {
                font-size: 20px;
            }

            .activity-page-actions {
                flex-direction: column;
            }

            .btn-page-action {
                width: 100%;
            }

            .activity-header-content {
                align-items: flex-start;
            }

            .activity-header-icon {
                width: 50px;
                height: 50px;
                border-radius: 13px;
            }

            .activity-header-info h4 {
                font-size: 19px;
            }

            .activity-header-info p {
                max-width: 230px;
            }

            .activity-total {
                min-width: 100px;
                padding: 10px 13px;
            }

            .schedule-summary {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <div class="container-fluid activity-page">
        <div class="activity-page-top">
            <div class="activity-page-heading">
                <h3>Hoạt động theo giờ</h3>

                <p>
                    Lịch trình:
                    <span class="activity-schedule-name">
                        {{ $lichTrinh->tieu_de }}
                    </span>
                </p>
            </div>

            <div class="activity-page-actions">
                <a
                    href="{{ route('Admin.lich_trinh_tours.tour', $lichTrinh->tour_id) }}"
                    class="btn-page-action btn-back-schedule"
                >
                    <i class="fas fa-arrow-left"></i>
                    Quay lại lịch trình
                </a>

                <a
                    href="{{ route('Admin.chi_tiet_lich_trinhs.create', $lichTrinh->id) }}"
                    class="btn-page-action btn-add-activity"
                >
                    <i class="fas fa-plus"></i>
                    Thêm hoạt động
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="activity-alert">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="activity-card">
            <div class="activity-card-header">
                <div class="activity-header-content">
                    <span class="activity-header-icon">
                        <i class="fas fa-clock"></i>
                    </span>

                    <div class="activity-header-info">
                        <h4>Danh sách hoạt động trong ngày</h4>

                        <p>
                            <i class="fas fa-calendar-day"></i>
                            Ngày {{ $lichTrinh->ngay_thu }}:
                            {{ $lichTrinh->tieu_de }}
                        </p>
                    </div>
                </div>

                <div class="activity-total">
                    <strong>{{ $lichTrinh->chiTiets->count() }}</strong>
                    <span>Hoạt động</span>
                </div>
            </div>

            <div class="activity-card-body">
                <div class="schedule-summary">
                    <div class="schedule-summary-main">
                        <span class="schedule-summary-icon">
                            <i class="fas fa-route"></i>
                        </span>

                        <div class="schedule-summary-content">
                            <span>Lịch trình đang quản lý</span>

                            <strong title="{{ $lichTrinh->tieu_de }}">
                                {{ $lichTrinh->tieu_de }}
                            </strong>
                        </div>
                    </div>

                    <span class="schedule-day-badge">
                        <i class="fas fa-calendar-alt"></i>
                        Ngày {{ $lichTrinh->ngay_thu }}
                    </span>
                </div>

                <div class="activity-table-wrapper">
                    <table class="table activity-table">
                        <thead>
                            <tr>
                                <th>Khung giờ</th>
                                <th>Tiêu đề</th>
                                <th>Nội dung</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($lichTrinh->chiTiets as $item)
                                <tr>
                                    <td>
                                        <span class="activity-time">
                                            <i class="fas fa-clock"></i>

                                            {{ \Carbon\Carbon::parse($item->gio_bat_dau)->format('H:i') }}

                                            <span>–</span>

                                            {{ \Carbon\Carbon::parse($item->gio_ket_thuc)->format('H:i') }}
                                        </span>
                                    </td>

                                    <td>
                                        <span
                                            class="activity-title"
                                            title="{{ $item->tieu_de }}"
                                        >
                                            {{ $item->tieu_de }}
                                        </span>

                                        <span class="activity-order">
                                            <i class="fas fa-list-ol"></i>
                                            Hoạt động {{ $loop->iteration }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($item->noi_dung)
                                            <div class="activity-description">
                                                {{ $item->noi_dung }}
                                            </div>
                                        @else
                                            <span class="empty-value">
                                                Chưa cập nhật nội dung
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="activity-actions">
                                            <a
                                                href="{{ route('Admin.chi_tiet_lich_trinhs.edit', $item->id) }}"
                                                class="btn-table-action btn-edit"
                                                title="Chỉnh sửa hoạt động"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form
                                                action="{{ route('Admin.chi_tiet_lich_trinhs.destroy', $item->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa hoạt động này?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn-table-action btn-delete"
                                                    title="Xóa hoạt động"
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
                                        class="activity-empty-row"
                                    >
                                        <div class="empty-state-icon">
                                            <i class="fas fa-clock"></i>
                                        </div>

                                        <div class="empty-state-title">
                                            Chưa có hoạt động nào
                                        </div>

                                        <div class="empty-state-text">
                                            Hãy thêm hoạt động đầu tiên cho ngày
                                            lịch trình này.
                                        </div>

                                        <a
                                            href="{{ route('Admin.chi_tiet_lich_trinhs.create', $lichTrinh->id) }}"
                                            class="empty-add-link"
                                        >
                                            <i class="fas fa-plus"></i>
                                            Thêm hoạt động
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
@endsection
