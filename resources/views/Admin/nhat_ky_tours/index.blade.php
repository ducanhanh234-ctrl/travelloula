@extends('Layouts.admin')

@section('title', 'Nhật ký Tour')

@section('content')
    <style>
        :root {
            --log-primary: #315be8;
            --log-primary-dark: #244bd2;
            --log-primary-light: #edf4ff;
            --log-purple: #5b4dea;

            --log-text-dark: #172b4d;
            --log-text-main: #344563;
            --log-text-muted: #6b7895;
            --log-text-light: #98a2b3;

            --log-border: #dce6f5;
            --log-border-light: #e8eef8;

            --log-white: #ffffff;
            --log-soft: #f5f8ff;
            --log-hover: #f3f7ff;

            --log-success: #08754a;
            --log-success-light: #eaf9f1;

            --log-warning: #ae6c0d;
            --log-warning-light: #fff7e8;

            --log-danger: #c13d55;
            --log-danger-light: #fff0f3;
        }

        .tour-log-page {
            padding: 24px 0;
            color: var(--log-text-dark);
        }

        /* Header trang */
        .log-page-top {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .log-page-heading {
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .log-page-icon {
            width: 47px;
            height: 47px;
            flex-shrink: 0;
            color: var(--log-primary);
            background: var(--log-primary-light);
            border: 1px solid #cfe0ff;
            border-radius: 12px;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .log-page-heading h3 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .log-page-heading p {
            margin: 6px 0 0;
            color: var(--log-text-muted);
            font-size: 14px;
        }

        /* Card chính */
        .log-card {
            position: relative;
            overflow: hidden;
            background: var(--log-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
        }

        .log-card::before {
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
        .log-card-header {
            position: relative;
            min-height: 115px;
            padding: 24px;
            overflow: hidden;
            color: var(--log-white);
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

        .log-card-header::before {
            position: absolute;
            right: -50px;
            bottom: -105px;
            width: 235px;
            height: 235px;
            content: "";
            border: 21px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .log-card-header::after {
            position: absolute;
            top: -85px;
            right: 115px;
            width: 175px;
            height: 175px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .log-card-heading {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .log-card-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            color: var(--log-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            box-shadow: 0 7px 18px rgba(20, 43, 128, 0.2);
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .log-card-heading h4 {
            margin: 0;
            color: var(--log-white);
            font-size: 20px;
            font-weight: 750;
        }

        .log-card-heading p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 12px;
        }

        .log-total {
            position: relative;
            z-index: 2;
            min-width: 105px;
            padding: 12px 15px;
            color: var(--log-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 11px;
            text-align: center;
        }

        .log-total strong {
            display: block;
            font-size: 22px;
            line-height: 1;
        }

        .log-total span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.85;
        }

        .log-card-body {
            padding: 22px;
        }

        /* Ghi chú */
        .log-note {
            margin-bottom: 20px;
            padding: 13px 15px;
            color: #40537a;
            background: var(--log-soft);
            border: 1px solid #d8e4f6;
            border-left: 4px solid var(--log-primary);
            border-radius: 9px;
            font-size: 12px;
            line-height: 1.6;
            display: flex;
            align-items: flex-start;
            gap: 9px;
        }

        .log-note i {
            margin-top: 2px;
            color: var(--log-primary);
        }

        /* Bảng */
        .log-table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--log-border);
            border-radius: 11px;
        }

        .log-table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .log-table-wrapper::-webkit-scrollbar-track {
            background: #f2f5fa;
        }

        .log-table-wrapper::-webkit-scrollbar-thumb {
            background: #c5d2e5;
            border-radius: 999px;
        }

        .log-table {
            width: 100%;
            min-width: 1100px;
            margin-bottom: 0;
            color: var(--log-text-dark);
            vertical-align: middle;
        }

        .log-table thead th {
            padding: 14px;
            color: #24417d;
            background: #f1f6ff;
            border-top: none;
            border-bottom: 1px solid #d8e5f8;
            font-size: 10px;
            font-weight: 750;
            letter-spacing: 0.025em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .log-table tbody td {
            padding: 14px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--log-border-light);
            font-size: 12px;
            line-height: 1.55;
            vertical-align: middle;
        }

        .log-table tbody tr:last-child td {
            border-bottom: none;
        }

        .log-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .log-table tbody tr:hover {
            background: var(--log-hover);
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .log-table th:nth-child(1),
        .log-table td:nth-child(1) {
            width: 75px;
            text-align: center;
        }

        .log-table th:nth-child(2),
        .log-table td:nth-child(2) {
            width: 240px;
            text-align: left;
        }

        .log-table th:nth-child(3),
        .log-table td:nth-child(3) {
            width: 190px;
            text-align: left;
        }

        .log-table th:nth-child(4),
        .log-table td:nth-child(4) {
            width: 220px;
            text-align: left;
        }

        .log-table th:nth-child(5),
        .log-table td:nth-child(5) {
            width: 155px;
            text-align: center;
        }

        .log-table th:nth-child(6),
        .log-table td:nth-child(6) {
            width: 180px;
            text-align: center;
        }

        .log-table th:nth-child(7),
        .log-table td:nth-child(7) {
            width: 100px;
            text-align: center;
        }

        /* ID */
        .log-id {
            min-width: 34px;
            height: 30px;
            padding: 0 8px;
            color: #3158ce;
            background: #edf3ff;
            border: 1px solid #d4e2ff;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 750;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Tour */
        .log-tour {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .log-tour-icon {
            width: 34px;
            height: 34px;
            flex-shrink: 0;
            color: #315be8;
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 9px;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .log-tour-name {
            max-width: 180px;
            overflow: hidden;
            color: #233f7a;
            font-size: 12px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .log-tour-code {
            margin-top: 3px;
            color: #8b97aa;
            font-size: 9px;
        }

        /* Người dùng */
        .log-user {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .log-user-avatar {
            width: 34px;
            height: 34px;
            flex-shrink: 0;
            color: var(--log-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #5b4dea
            );
            border-radius: 9px;
            box-shadow: 0 4px 10px rgba(49, 91, 232, 0.17);
            font-size: 12px;
            font-weight: 750;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .log-user-name {
            max-width: 130px;
            overflow: hidden;
            color: #344563;
            font-size: 12px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .log-user-label {
            margin-top: 2px;
            color: #8b97aa;
            font-size: 9px;
        }

        /* Hành động */
        .action-badge {
            max-width: 200px;
            padding: 6px 10px;
            overflow: hidden;
            color: #3158ce;
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 700;
            line-height: 1.5;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .action-badge i {
            flex-shrink: 0;
            font-size: 9px;
        }

        /* IP */
        .ip-address {
            padding: 5px 9px;
            color: #536584;
            background: #f4f7fc;
            border: 1px solid #dce4ef;
            border-radius: 999px;
            font-family: monospace;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* Thời gian */
        .log-time {
            color: #40537a;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .log-time i {
            margin-right: 5px;
            color: #5f7fd3;
            font-size: 9px;
        }

        .log-date {
            margin-top: 4px;
            color: #8b97aa;
            font-size: 9px;
            white-space: nowrap;
        }

        /* Nút chi tiết */
        .btn-view-log {
            width: 31px;
            height: 31px;
            padding: 0;
            color: #2d5fd7;
            background: #eaf2ff;
            border: 1px solid #c7dafe;
            border-radius: 7px;
            font-size: 11px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.16s ease;
        }

        .btn-view-log:hover {
            color: var(--log-white);
            background: #3867e5;
            border-color: #3867e5;
            box-shadow: 0 5px 12px rgba(56, 103, 229, 0.25);
            text-decoration: none;
            transform: translateY(-2px);
        }

        /* Empty */
        .log-empty-row {
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
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
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

        /* Footer */
        .log-card-footer {
            padding: 16px 22px;
            background: #fafcff;
            border-top: 1px solid var(--log-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .log-result-info {
            color: var(--log-text-muted);
            font-size: 11px;
        }

        .log-card-footer .pagination {
            margin: 0;
            gap: 4px;
        }

        .log-card-footer .page-link {
            min-width: 34px;
            height: 34px;
            padding: 6px 10px;
            color: #3158ce;
            background: var(--log-white);
            border: 1px solid #d6e1f2;
            border-radius: 7px !important;
            font-size: 12px;
            box-shadow: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .log-card-footer .page-link:hover {
            color: var(--log-white);
            background: #416ce5;
            border-color: #416ce5;
        }

        .log-card-footer .page-item.active .page-link {
            color: var(--log-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
        }

        .log-card-footer .page-item.disabled .page-link {
            color: #aab3c5;
            background: #f8f9fc;
        }

        @media (max-width: 768px) {
            .tour-log-page {
                padding: 14px 0;
            }

            .log-page-heading h3 {
                font-size: 20px;
            }

            .log-card {
                border-radius: 11px;
            }

            .log-card-header {
                min-height: 105px;
                padding: 20px 18px;
            }

            .log-card-body {
                padding: 16px;
            }

            .log-card-footer {
                align-items: stretch;
                flex-direction: column;
            }

            .log-result-info {
                text-align: center;
            }
        }

        @media (max-width: 520px) {
            .log-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .log-total {
                min-width: 100px;
                padding: 10px 13px;
            }
        }
    </style>

    <div class="container-fluid tour-log-page">
        <div class="log-page-top">
            <div class="log-page-heading">
                <span class="log-page-icon">
                    <i class="fas fa-history"></i>
                </span>

                <div>
                    <h3>Nhật ký Tour</h3>

                    <p>
                        Theo dõi lịch sử thao tác của người dùng trong hệ thống.
                    </p>
                </div>
            </div>
        </div>

        <div class="log-card">
            <div class="log-card-header">
                <div class="log-card-heading">
                    <span class="log-card-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </span>

                    <div>
                        <h4>Lịch sử hoạt động</h4>

                        <p>
                            Kiểm tra Tour, người thao tác, địa chỉ IP và thời
                            gian thực hiện.
                        </p>
                    </div>
                </div>

                <div class="log-total">
                    <strong>{{ $nhatKys->total() }}</strong>
                    <span>Bản ghi nhật ký</span>
                </div>
            </div>

            <div class="log-card-body">
                <div class="log-note">
                    <i class="fas fa-info-circle"></i>

                    <span>
                        Nhật ký giúp quản trị viên kiểm tra lịch sử thao tác và
                        truy vết các thay đổi liên quan đến Tour.
                    </span>
                </div>

                <div class="log-table-wrapper">
                    <table class="table log-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tour</th>
                                <th>Người dùng</th>
                                <th>Hành động</th>
                                <th>Địa chỉ IP</th>
                                <th>Thời gian</th>
                                <th>Chi tiết</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($nhatKys as $item)
                                @php
                                    $userName = $item->nguoiDung->name ?? 'N/A';
                                    $tourName = $item->tour->ten_tour ?? 'N/A';
                                @endphp

                                <tr>
                                    <td>
                                        <span class="log-id">
                                            #{{ $item->id }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="log-tour">
                                            <span class="log-tour-icon">
                                                <i class="fas fa-route"></i>
                                            </span>

                                            <div>
                                                <div
                                                    class="log-tour-name"
                                                    title="{{ $tourName }}"
                                                >
                                                    {{ $tourName }}
                                                </div>

                                                <div class="log-tour-code">
                                                    Nhật ký #{{ $item->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="log-user">
                                            <span class="log-user-avatar">
                                                {{ $userName !== 'N/A'
                                                    ? mb_strtoupper(mb_substr($userName, 0, 1))
                                                    : '?' }}
                                            </span>

                                            <div>
                                                <div
                                                    class="log-user-name"
                                                    title="{{ $userName }}"
                                                >
                                                    {{ $userName }}
                                                </div>

                                                <div class="log-user-label">
                                                    Người thực hiện
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        @if ($item->hanh_dong)
                                            <span
                                                class="action-badge"
                                                title="{{ $item->hanh_dong }}"
                                            >
                                                <i class="fas fa-bolt"></i>
                                                {{ $item->hanh_dong }}
                                            </span>
                                        @else
                                            <span class="text-muted">
                                                N/A
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($item->dia_chi_ip)
                                            <span class="ip-address">
                                                <i class="fas fa-network-wired"></i>
                                                {{ $item->dia_chi_ip }}
                                            </span>
                                        @else
                                            <span class="text-muted">
                                                N/A
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($item->created_at)
                                            <div class="log-time">
                                                <i class="fas fa-clock"></i>
                                                {{ $item->created_at->format('H:i:s') }}
                                            </div>

                                            <div class="log-date">
                                                {{ $item->created_at->format('d/m/Y') }}
                                            </div>
                                        @else
                                            <span class="text-muted">
                                                N/A
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <a
                                            href="{{ route('Admin.nhat_ky_tours.show', $item->id) }}"
                                            class="btn-view-log"
                                            title="Xem chi tiết nhật ký"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="7"
                                        class="log-empty-row"
                                    >
                                        <div class="empty-state-icon">
                                            <i class="fas fa-history"></i>
                                        </div>

                                        <div class="empty-state-title">
                                            Chưa có nhật ký Tour
                                        </div>

                                        <div class="empty-state-text">
                                            Các thao tác trong hệ thống sẽ được
                                            hiển thị tại đây.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="log-card-footer">
                <div class="log-result-info">
                    @if ($nhatKys->total() > 0)
                        Hiển thị {{ $nhatKys->firstItem() }}
                        đến {{ $nhatKys->lastItem() }}
                        trong tổng số {{ $nhatKys->total() }} nhật ký
                    @else
                        Không có nhật ký nào
                    @endif
                </div>

                {{ $nhatKys->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
