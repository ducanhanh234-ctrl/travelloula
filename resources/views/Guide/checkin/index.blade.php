@extends('Layouts.guide')

@section('title', 'Check-in hành khách')

@section('guide', 'Check-in hành khách')

@section('breadcrumb')
    <li class="breadcrumb-item active">
        Check-in hành khách
    </li>
@endsection

@section('content')
    <style>
        :root {
            --checkin-primary: #315be8;
            --checkin-primary-dark: #264ed4;
            --checkin-purple: #5b4dea;

            --checkin-dark: #173576;
            --checkin-text: #344563;
            --checkin-muted: #6b7895;
            --checkin-light: #98a2b3;

            --checkin-white: #ffffff;
            --checkin-soft: #f5f8ff;
            --checkin-hover: #f3f7ff;

            --checkin-border: #dce6f5;
            --checkin-border-light: #e8eef8;

            --checkin-success: #08754a;
            --checkin-success-bg: #eaf9f1;

            --checkin-warning: #ae6c0d;
            --checkin-warning-bg: #fff7e8;

            --checkin-danger: #c13d55;
            --checkin-danger-bg: #fff0f3;

            --checkin-info: #1975a8;
            --checkin-info-bg: #ebf8ff;
        }

        .checkin-index-page {
            padding: 4px 0 24px;
            color: var(--checkin-text);
        }

        /* Header */
        .checkin-index-header {
            margin-bottom: 20px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .checkin-index-heading {
            min-width: 0;

            display: flex;
            align-items: center;
            gap: 13px;
        }

        .checkin-index-heading-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;

            color: var(--checkin-white);

            background: linear-gradient(135deg,
                    var(--checkin-primary),
                    var(--checkin-purple));

            border-radius: 12px;

            box-shadow:
                0 7px 18px rgba(49, 91, 232, 0.22);

            font-size: 18px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .checkin-index-heading h2 {
            margin: 0;

            color: var(--checkin-dark);
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -0.2px;
        }

        .checkin-index-heading p {
            margin: 5px 0 0;

            color: var(--checkin-muted);
            font-size: 13px;
        }

        .btn-checkin-refresh {
            min-height: 41px;
            padding: 9px 15px;

            color: #53698f;
            background: var(--checkin-white);

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

        .btn-checkin-refresh:hover {
            color: var(--checkin-primary);
            background: var(--checkin-soft);
            border-color: #bfcff0;

            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Card */
        .checkin-index-card {
            position: relative;

            overflow: hidden;

            background: var(--checkin-white);
            border: 1px solid var(--checkin-border);
            border-radius: 15px;

            box-shadow:
                0 8px 28px rgba(28, 65, 139, 0.09);
        }

        .checkin-index-card::before {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 2;

            height: 4px;
            content: "";

            background: linear-gradient(90deg,
                    var(--checkin-primary),
                    #3b79ee,
                    var(--checkin-purple));
        }

        .checkin-index-card-header {
            min-height: 72px;
            padding: 20px;

            color: #24417d;
            background: #f1f6ff;
            border-bottom: 1px solid var(--checkin-border);

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .checkin-index-card-title {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .checkin-index-card-title-icon {
            width: 38px;
            height: 38px;
            flex-shrink: 0;

            color: var(--checkin-primary);
            background: #e7efff;

            border: 1px solid #cfdfff;
            border-radius: 9px;

            font-size: 13px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .checkin-index-card-title h4 {
            margin: 0;

            color: #24417d;
            font-size: 15px;
            font-weight: 750;
        }

        .checkin-index-card-title p {
            margin: 3px 0 0;

            color: #75839c;
            font-size: 10px;
        }

        .checkin-index-count {
            padding: 6px 11px;

            color: #3158ce;
            background: #e9f1ff;

            border: 1px solid #cfdeff;
            border-radius: 999px;

            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        /* Empty */
        .checkin-empty {
            padding: 65px 20px;

            color: var(--checkin-muted);
            text-align: center;
        }

        .checkin-empty-icon {
            width: 62px;
            height: 62px;
            margin: 0 auto 14px;

            color: var(--checkin-warning);
            background: var(--checkin-warning-bg);

            border: 1px solid #f1dba9;
            border-radius: 16px;

            font-size: 23px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .checkin-empty-title {
            color: #425474;
            font-size: 15px;
            font-weight: 750;
        }

        .checkin-empty-text {
            max-width: 440px;
            margin: 5px auto 0;

            color: #8793aa;
            font-size: 12px;
            line-height: 1.7;
        }

        /* Table */
        .checkin-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .checkin-index-table {
            width: 100%;
            min-width: 930px;
            margin: 0;

            vertical-align: middle;
        }

        .checkin-index-table thead th {
            padding: 14px 16px;

            color: #24417d;
            background: #f7f9fd;

            border-top: none;
            border-bottom: 1px solid #d8e5f8;

            font-size: 10px;
            font-weight: 750;
            letter-spacing: 0.025em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .checkin-index-table tbody td {
            padding: 15px 16px;

            color: #4d5d7d;

            border-bottom:
                1px solid var(--checkin-border-light);

            font-size: 12px;
            vertical-align: middle;
        }

        .checkin-index-table tbody tr:last-child td {
            border-bottom: none;
        }

        .checkin-index-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .checkin-index-table tbody tr:hover {
            background: var(--checkin-hover);

            box-shadow:
                inset 3px 0 0 var(--checkin-primary);
        }

        .checkin-index-table th:nth-child(1),
        .checkin-index-table td:nth-child(1) {
            width: 75px;
            text-align: center;
        }

        .checkin-index-table th:nth-child(2),
        .checkin-index-table td:nth-child(2) {
            min-width: 300px;
        }

        .checkin-index-table th:nth-child(3),
        .checkin-index-table td:nth-child(3),
        .checkin-index-table th:nth-child(4),
        .checkin-index-table td:nth-child(4) {
            width: 175px;
            text-align: center;
        }

        .checkin-index-table th:nth-child(5),
        .checkin-index-table td:nth-child(5) {
            width: 190px;
            text-align: center;
        }

        .checkin-stt {
            min-width: 34px;
            height: 31px;
            padding: 0 8px;

            color: #3158ce;
            background: #edf3ff;

            border: 1px solid #d4e2ff;
            border-radius: 8px;

            font-size: 10px;
            font-weight: 800;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        /* Tour */
        .checkin-tour-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkin-tour-icon {
            width: 40px;
            height: 40px;
            flex-shrink: 0;

            color: var(--checkin-purple);
            background: #f0efff;

            border: 1px solid #ddd9ff;
            border-radius: 10px;

            font-size: 13px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .checkin-tour-name {
            max-width: 320px;

            color: #233f7a;
            font-size: 12px;
            font-weight: 750;
            line-height: 1.55;
            overflow-wrap: anywhere;
        }

        .checkin-tour-label {
            margin-top: 2px;

            color: #8b97aa;
            font-size: 9px;
        }

        /* Date */
        .checkin-date {
            color: #506181;
            font-size: 11px;
            font-weight: 650;
            white-space: nowrap;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .checkin-date i {
            color: var(--checkin-primary);
        }

        /* Action */
        .btn-select-location {
            min-height: 35px;
            padding: 7px 11px;

            color: var(--checkin-white);

            background: linear-gradient(135deg,
                    var(--checkin-primary),
                    var(--checkin-purple));

            border: 1px solid var(--checkin-primary);
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
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .btn-select-location:hover {
            color: var(--checkin-white);

            background: linear-gradient(135deg,
                    var(--checkin-primary-dark),
                    #4c40d7);

            border-color: var(--checkin-primary-dark);

            box-shadow:
                0 7px 16px rgba(49, 91, 232, 0.26);

            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Footer */
        .checkin-index-footer {
            padding: 16px 20px;

            background: #fafcff;
            border-top: 1px solid var(--checkin-border);

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .checkin-result-info {
            color: var(--checkin-muted);
            font-size: 11px;
        }

        .checkin-index-footer .pagination {
            margin: 0;
            gap: 4px;
        }

        .checkin-index-footer .page-link {
            min-width: 34px;
            height: 34px;
            padding: 6px 10px;

            color: #3158ce;
            background: var(--checkin-white);

            border: 1px solid #d6e1f2;
            border-radius: 7px !important;

            font-size: 12px;
            box-shadow: none;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .checkin-index-footer .page-link:hover {
            color: var(--checkin-white);
            background: var(--checkin-primary);
            border-color: var(--checkin-primary);
        }

        .checkin-index-footer .page-item.active .page-link {
            color: var(--checkin-white);

            background: linear-gradient(135deg,
                    var(--checkin-primary),
                    var(--checkin-purple));

            border-color: var(--checkin-primary);
        }

        .checkin-index-footer .page-item.disabled .page-link {
            color: #aab3c5;
            background: #f8f9fc;
        }

        @media (max-width: 768px) {
            .checkin-index-header {
                align-items: stretch;
                flex-direction: column;
            }

            .checkin-index-heading h2 {
                font-size: 20px;
            }

            .btn-checkin-refresh {
                width: 100%;
            }

            .checkin-index-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .checkin-index-footer {
                align-items: stretch;
                flex-direction: column;
            }

            .checkin-result-info {
                text-align: center;
            }

            .checkin-disabled-row {
    opacity: .45;
    background: #f5f5f5;
}

.checkin-disabled-row:hover {
    background: #f5f5f5 !important;
}

.btn-checkin-disabled {
    background: #bdbdbd !important;
    border-color: #bdbdbd !important;
    color: #fff !important;
    cursor: not-allowed;
}

.btn-checkin-disabled:hover {
    background: #bdbdbd !important;
    transform: none;
    box-shadow: none;
}
        }
    </style>

    <div class="checkin-index-page fade-in">
        {{-- Header trang --}}
        <div class="checkin-index-header">
            <div class="checkin-index-heading">
                <span class="checkin-index-heading-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </span>

                <div>
                    <h2>Check-in hành khách</h2>

                    <p>
                        Theo dõi các Tour được phân công và thực hiện điểm danh.
                    </p>
                </div>
            </div>

            <a href="{{ route('Guide.checkin.index') }}" class="btn-checkin-refresh">
                <i class="fas fa-rotate-right"></i>
                Làm mới
            </a>
        </div>

        {{-- Danh sách --}}
        <div class="checkin-index-card">
            <div class="checkin-index-card-header">
                <div class="checkin-index-card-title">
                    <span class="checkin-index-card-title-icon">
                        <i class="fas fa-calendar-check"></i>
                    </span>

                    <div>
                        <h4>Danh sách lịch khởi hành</h4>

                        <p>
                            Chọn lịch khởi hành để tiếp tục chọn địa điểm Check-in.
                        </p>
                    </div>
                </div>

                <span class="checkin-index-count">
                    {{ $lichKhoiHanhs->total() }} lịch khởi hành
                </span>
            </div>

            @if ($lichKhoiHanhs->isEmpty())
                <div class="checkin-empty">
                    <div class="checkin-empty-icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>

                    <div class="checkin-empty-title">
                        Chưa có lịch khởi hành
                    </div>

                    <div class="checkin-empty-text">
                        Hiện tại bạn chưa được phân công lịch khởi hành nào.
                        Các lịch được phân công sẽ xuất hiện tại đây.
                    </div>
                </div>
            @else
                <div class="checkin-table-wrapper">
                    <table class="table checkin-index-table">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tour</th>
                                <th>Ngày khởi hành</th>
                                <th>Ngày kết thúc</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($lichKhoiHanhs as $lich)
                                        @php
                                            $chuaDienRa = \Carbon\Carbon::today()->lt(
                                                \Carbon\Carbon::parse($lich->ngay_khoi_hanh)
                                            );
                                        @endphp
                                        <tr class="{{ $chuaDienRa ? 'checkin-disabled-row' : '' }}">
                                            <td>
                                                <span class="checkin-stt">
                                                    {{
                                $lichKhoiHanhs->firstItem()
                                + $loop->index
                                                                }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="checkin-tour-info">
                                                    <span class="checkin-tour-icon">
                                                        <i class="fas fa-route"></i>
                                                    </span>

                                                    <div>
                                                        <div class="checkin-tour-name">
                                                            {{
                                $lich->tour->ten_tour
                                ?? 'Không xác định'
                                                                        }}
                                                        </div>

                                                        <div class="checkin-tour-label">
                                                            Lịch khởi hành #{{ $lich->id }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <span class="checkin-date">
                                                    <i class="fas fa-plane-departure"></i>

                                                    @if ($lich->ngay_khoi_hanh)
                                                                        {{
                                                        \Carbon\Carbon::parse(
                                                            $lich->ngay_khoi_hanh
                                                        )->format('d/m/Y')
                                                                                        }}
                                                    @else
                                                        Chưa cập nhật
                                                    @endif
                                                </span>
                                            </td>

                                            <td>
                                                <span class="checkin-date">
                                                    <i class="fas fa-flag-checkered"></i>

                                                    @if ($lich->ngay_ket_thuc)
                                                                        {{
                                                        \Carbon\Carbon::parse(
                                                            $lich->ngay_ket_thuc
                                                        )->format('d/m/Y')
                                                                                        }}
                                                    @else
                                                        Chưa cập nhật
                                                    @endif
                                                </span>
                                            </td>

                                            <td>
                                                @if ($chuaDienRa)
                                                    <button class="btn-select-location btn-checkin-disabled" disabled>
                                                        <i class="fas fa-lock"></i>
                                                        Chưa đến ngày khởi hành
                                                    </button>
                                                @else
                                                    <a href="{{ route('Guide.checkin.dia-diem', $lich->id) }}" class="btn-select-location">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        Chọn địa điểm
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="checkin-index-footer">
                    <div class="checkin-result-info">
                        Hiển thị
                        {{ $lichKhoiHanhs->firstItem() }}
                        đến
                        {{ $lichKhoiHanhs->lastItem() }}
                        trong tổng số
                        {{ $lichKhoiHanhs->total() }}
                        lịch khởi hành
                    </div>

                    {{ $lichKhoiHanhs->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
