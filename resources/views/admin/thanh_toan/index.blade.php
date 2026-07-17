@extends('layouts.admin')

@section('title', 'Quản lý Thanh toán')

@section('breadcrumb')
    <li class="breadcrumb-item active">
        Quản lý Thanh toán
    </li>
@endsection

@section('content')
    <style>
        :root {
            --payment-primary: #315be8;
            --payment-purple: #5b4dea;
            --payment-dark: #173576;
            --payment-text: #344563;
            --payment-muted: #6b7895;
            --payment-light: #98a2b3;
            --payment-border: #dce6f5;
            --payment-border-light: #e8eef8;
            --payment-white: #ffffff;
            --payment-soft: #f5f8ff;
            --payment-hover: #f3f7ff;

            --payment-success: #08754a;
            --payment-success-bg: #eaf9f1;

            --payment-warning: #ae6c0d;
            --payment-warning-bg: #fff7e8;

            --payment-danger: #c13d55;
            --payment-danger-bg: #fff0f3;

            --payment-info: #1975a8;
            --payment-info-bg: #ebf8ff;
        }

        .payment-page {
            padding: 24px 0;
            color: var(--payment-text);
        }

        /* Header trang */
        .payment-page-header {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .payment-page-heading {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .payment-page-icon {
            width: 47px;
            height: 47px;
            flex-shrink: 0;
            color: var(--payment-primary);
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 12px;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .payment-page-heading h3 {
            margin: 0;
            color: var(--payment-dark);
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .payment-page-heading p {
            margin: 6px 0 0;
            color: var(--payment-muted);
            font-size: 14px;
        }

        /* Thống kê */
        .payment-stats-grid {
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .payment-stat-card {
            position: relative;
            overflow: hidden;
            min-height: 126px;
            padding: 19px;
            background: var(--payment-white);
            border: 1px solid var(--payment-border);
            border-radius: 14px;
            box-shadow: 0 7px 24px rgba(28, 65, 139, 0.08);
            display: flex;
            align-items: center;
            gap: 14px;
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .payment-stat-card:hover {
            box-shadow: 0 10px 28px rgba(28, 65, 139, 0.13);
            transform: translateY(-2px);
        }

        .payment-stat-card::after {
            position: absolute;
            right: -30px;
            bottom: -43px;
            width: 120px;
            height: 120px;
            content: "";
            background: rgba(49, 91, 232, 0.04);
            border-radius: 50%;
        }

        .payment-stat-icon {
            width: 52px;
            height: 52px;
            flex-shrink: 0;
            border: 1px solid transparent;
            border-radius: 13px;
            font-size: 19px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .payment-stat-primary {
            color: var(--payment-primary);
            background: #edf3ff;
            border-color: #d2e0ff;
        }

        .payment-stat-success {
            color: var(--payment-success);
            background: var(--payment-success-bg);
            border-color: #c5ead8;
        }

        .payment-stat-warning {
            color: var(--payment-warning);
            background: var(--payment-warning-bg);
            border-color: #f1dba9;
        }

        .payment-stat-info {
            color: var(--payment-info);
            background: var(--payment-info-bg);
            border-color: #c8e8f5;
        }

        .payment-stat-content {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .payment-stat-value {
            color: #203e78;
            font-size: 24px;
            font-weight: 800;
            line-height: 1.2;
            overflow-wrap: anywhere;
        }

        .payment-stat-value.payment-revenue {
            font-size: 20px;
        }

        .payment-stat-label {
            margin-top: 5px;
            color: var(--payment-muted);
            font-size: 11px;
            font-weight: 650;
        }

        /* Card */
        .payment-card {
            position: relative;
            overflow: hidden;
            background: var(--payment-white);
            border: 1px solid #d8e4f6;
            border-radius: 14px;
            box-shadow: 0 8px 28px rgba(28, 65, 139, 0.09);
        }

        .payment-filter-card {
            margin-bottom: 20px;
        }

        .payment-card-header {
            min-height: 58px;
            padding: 15px 19px;
            color: #24417d;
            background: #f1f6ff;
            border-bottom: 1px solid var(--payment-border);
            font-size: 14px;
            font-weight: 750;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
        }

        .payment-card-title {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .payment-card-title i {
            color: var(--payment-primary);
        }

        .payment-total-badge {
            padding: 6px 11px;
            color: #3158ce;
            background: #e9f1ff;
            border: 1px solid #cfdeff;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 750;
            white-space: nowrap;
        }

        .payment-card-body {
            padding: 19px;
        }

        /* Bộ lọc */
        .payment-filter-form {
            display: grid;
            grid-template-columns: minmax(280px, 1fr) 240px auto auto;
            gap: 10px;
            align-items: end;
        }

        .payment-filter-group {
            min-width: 0;
        }

        .payment-filter-label {
            margin-bottom: 6px;
            color: #40537a;
            font-size: 12px;
            font-weight: 700;
            display: block;
        }

        .payment-input-wrapper {
            position: relative;
        }

        .payment-input-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            z-index: 2;
            color: #7686a5;
            font-size: 12px;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .payment-filter-form .form-control,
        .payment-filter-form .form-select {
            width: 100%;
            min-height: 41px;
            color: var(--payment-text);
            background-color: var(--payment-white);
            border: 1px solid #ccd9ed;
            border-radius: 8px;
            font-size: 13px;
            box-shadow: none;
        }

        .payment-filter-form .form-control {
            padding-left: 34px;
        }

        .payment-filter-form .form-control::placeholder {
            color: #9ca8bd;
        }

        .payment-filter-form .form-control:focus,
        .payment-filter-form .form-select:focus {
            border-color: #4f78eb;
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.1);
        }

        .btn-payment-filter {
            min-height: 41px;
            padding: 9px 14px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.18s ease;
        }

        .btn-payment-filter:hover {
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-payment-search {
            color: var(--payment-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
            box-shadow: 0 4px 12px rgba(49, 91, 232, 0.2);
        }

        .btn-payment-search:hover {
            color: var(--payment-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #4c40d7
            );
        }

        .btn-payment-reset {
            color: #53698f;
            background: var(--payment-white);
            border-color: #ccd9ed;
        }

        .btn-payment-reset:hover {
            color: #304d83;
            background: #eaf1fb;
            border-color: #b9c9e0;
        }

        /* Bảng */
        .payment-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .payment-table {
            width: 100%;
            min-width: 1320px;
            margin-bottom: 0;
            vertical-align: middle;
        }

        .payment-table thead th {
            padding: 14px;
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

        .payment-table tbody td {
            padding: 14px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--payment-border-light);
            font-size: 12px;
            line-height: 1.6;
            vertical-align: middle;
        }

        .payment-table tbody tr:last-child td {
            border-bottom: none;
        }

        .payment-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .payment-table tbody tr:hover {
            background: var(--payment-hover);
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .payment-table th:nth-child(1),
        .payment-table td:nth-child(1) {
            width: 155px;
        }

        .payment-table th:nth-child(2),
        .payment-table td:nth-child(2) {
            width: 205px;
        }

        .payment-table th:nth-child(3),
        .payment-table td:nth-child(3) {
            min-width: 250px;
        }

        .payment-table th:nth-child(4),
        .payment-table td:nth-child(4) {
            width: 155px;
            text-align: center;
        }

        .payment-table th:nth-child(5),
        .payment-table td:nth-child(5) {
            width: 145px;
            text-align: right;
        }

        .payment-table th:nth-child(6),
        .payment-table td:nth-child(6) {
            width: 175px;
            text-align: center;
        }

        .payment-table th:nth-child(7),
        .payment-table td:nth-child(7) {
            width: 150px;
            text-align: center;
        }

        .payment-table th:nth-child(8),
        .payment-table td:nth-child(8) {
            width: 115px;
            text-align: center;
        }

        /* Mã giao dịch */
        .payment-code {
            padding: 6px 9px;
            color: #3158ce;
            background: #edf3ff;
            border: 1px solid #d4e2ff;
            border-radius: 7px;
            font-family: Consolas, Monaco, monospace;
            font-size: 10px;
            font-weight: 750;
            overflow-wrap: anywhere;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* Khách hàng */
        .payment-customer {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .payment-customer-avatar {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            color: var(--payment-primary);
            background: #edf3ff;
            border: 1px solid #d3e1ff;
            border-radius: 50%;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .payment-customer-name {
            max-width: 160px;
            overflow: hidden;
            color: #233f7a;
            font-size: 12px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .payment-customer-label {
            margin-top: 2px;
            color: #8b97aa;
            font-size: 9px;
        }

        /* Tour */
        .payment-tour {
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .payment-tour-icon {
            width: 31px;
            height: 31px;
            flex-shrink: 0;
            color: #5c51d8;
            background: #f0efff;
            border: 1px solid #dcd9ff;
            border-radius: 8px;
            font-size: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .payment-tour-name {
            max-width: 285px;
            color: #4b5b79;
            font-size: 12px;
            font-weight: 650;
            line-height: 1.55;
            overflow-wrap: anywhere;
        }

        /* Phương thức */
        .payment-method {
            padding: 5px 10px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 750;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .payment-method-cash {
            color: var(--payment-success);
            background: var(--payment-success-bg);
            border-color: #c5ead8;
        }

        .payment-method-transfer {
            color: #3158ce;
            background: #edf3ff;
            border-color: #d1dfff;
        }

        .payment-method-vnpay {
            color: #7a48b7;
            background: #f5edff;
            border-color: #e1cff6;
        }

        .payment-method-unknown {
            color: #697894;
            background: #f2f4f8;
            border-color: #dde3ec;
        }

        /* Số tiền */
        .payment-amount {
            color: var(--payment-success);
            font-size: 13px;
            font-weight: 800;
            white-space: nowrap;
        }

        /* Ngày thanh toán */
        .payment-date {
            color: #506181;
            font-size: 11px;
            font-weight: 650;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .payment-date i {
            color: #6380c8;
        }

        .payment-date-empty {
            color: var(--payment-light);
            font-size: 10px;
            font-style: italic;
        }

        /* Trạng thái */
        .payment-status {
            padding: 5px 10px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 9px;
            font-weight: 750;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .payment-status-dot {
            width: 6px;
            height: 6px;
            flex-shrink: 0;
            border-radius: 50%;
            background: currentColor;
        }

        .payment-status-paid {
            color: var(--payment-success);
            background: var(--payment-success-bg);
            border-color: #c5ead8;
        }

        .payment-status-pending {
            color: var(--payment-warning);
            background: var(--payment-warning-bg);
            border-color: #f1dba9;
        }

        .payment-status-failed {
            color: var(--payment-danger);
            background: var(--payment-danger-bg);
            border-color: #f0c9d1;
        }

        .payment-status-refund {
            color: var(--payment-info);
            background: var(--payment-info-bg);
            border-color: #c8e8f5;
        }

        .payment-status-unknown {
            color: #697894;
            background: #f2f4f8;
            border-color: #dde3ec;
        }

        /* Thao tác */
        .payment-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .btn-payment-action {
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

        .btn-payment-action:hover {
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-payment-view {
            color: #2d5fd7;
            background: #eaf2ff;
            border-color: #c7dafe;
        }

        .btn-payment-view:hover {
            color: var(--payment-white);
            background: #3867e5;
            border-color: #3867e5;
            box-shadow: 0 5px 12px rgba(56, 103, 229, 0.24);
        }

        .btn-payment-edit {
            color: var(--payment-warning);
            background: var(--payment-warning-bg);
            border-color: #f1dba9;
        }

        .btn-payment-edit:hover {
            color: var(--payment-white);
            background: #e39a25;
            border-color: #e39a25;
            box-shadow: 0 5px 12px rgba(227, 154, 37, 0.24);
        }

        /* Không có dữ liệu */
        .payment-empty-row {
            padding: 52px 20px !important;
            color: #8793aa !important;
            text-align: center !important;
        }

        .payment-empty-icon {
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

        .payment-empty-title {
            color: #506181;
            font-size: 14px;
            font-weight: 700;
        }

        .payment-empty-text {
            margin-top: 4px;
            font-size: 12px;
        }

        /* Footer */
        .payment-card-footer {
            padding: 16px 20px;
            background: #fafcff;
            border-top: 1px solid var(--payment-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .payment-result-info {
            color: var(--payment-muted);
            font-size: 11px;
        }

        .payment-card-footer .pagination {
            margin: 0;
            gap: 4px;
        }

        .payment-card-footer .page-link {
            min-width: 34px;
            height: 34px;
            padding: 6px 10px;
            color: #3158ce;
            background: var(--payment-white);
            border: 1px solid #d6e1f2;
            border-radius: 7px !important;
            font-size: 12px;
            box-shadow: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .payment-card-footer .page-link:hover {
            color: var(--payment-white);
            background: #416ce5;
            border-color: #416ce5;
        }

        .payment-card-footer .page-item.active .page-link {
            color: var(--payment-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
        }

        .payment-card-footer .page-item.disabled .page-link {
            color: #aab3c5;
            background: #f8f9fc;
        }

        @media (max-width: 1200px) {
            .payment-stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 992px) {
            .payment-filter-form {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 768px) {
            .payment-page {
                padding: 14px 0;
            }

            .payment-page-header {
                align-items: stretch;
                flex-direction: column;
            }

            .payment-page-heading h3 {
                font-size: 20px;
            }

            .payment-stats-grid,
            .payment-filter-form {
                grid-template-columns: 1fr;
            }

            .btn-payment-filter {
                width: 100%;
            }

            .payment-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .payment-card-body {
                padding: 15px;
            }

            .payment-card-footer {
                align-items: stretch;
                flex-direction: column;
            }

            .payment-result-info {
                text-align: center;
            }
        }
    </style>

    <div class="container-fluid payment-page">
        <div class="payment-page-header">
            <div class="payment-page-heading">
                <span class="payment-page-icon">
                    <i class="fas fa-credit-card"></i>
                </span>

                <div>
                    <h3>Quản lý Thanh toán</h3>

                    <p>
                        Theo dõi và quản lý các giao dịch thanh toán của khách hàng.
                    </p>
                </div>
            </div>
        </div>

        {{-- Thống kê --}}
        <div class="payment-stats-grid">
            <div class="payment-stat-card">
                <span class="payment-stat-icon payment-stat-primary">
                    <i class="fas fa-money-bill-wave"></i>
                </span>

                <div class="payment-stat-content">
                    <div class="payment-stat-value payment-revenue">
                        {{ number_format($tongDoanhThu, 0, ',', '.') }}đ
                    </div>

                    <div class="payment-stat-label">
                        Tổng doanh thu
                    </div>
                </div>
            </div>

            <div class="payment-stat-card">
                <span class="payment-stat-icon payment-stat-success">
                    <i class="fas fa-check-circle"></i>
                </span>

                <div class="payment-stat-content">
                    <div class="payment-stat-value">
                        {{ $daThanhToan }}
                    </div>

                    <div class="payment-stat-label">
                        Thanh toán thành công
                    </div>
                </div>
            </div>

            <div class="payment-stat-card">
                <span class="payment-stat-icon payment-stat-warning">
                    <i class="fas fa-clock"></i>
                </span>

                <div class="payment-stat-content">
                    <div class="payment-stat-value">
                        {{ $dangXuLy }}
                    </div>

                    <div class="payment-stat-label">
                        Chờ thanh toán
                    </div>
                </div>
            </div>

            <div class="payment-stat-card">
                <span class="payment-stat-icon payment-stat-info">
                    <i class="fas fa-undo-alt"></i>
                </span>

                <div class="payment-stat-content">
                    <div class="payment-stat-value">
                        {{ $hoanTien }}
                    </div>

                    <div class="payment-stat-label">
                        Hoàn tiền
                    </div>
                </div>
            </div>
        </div>

        {{-- Bộ lọc --}}
        <div class="payment-card payment-filter-card">
            <div class="payment-card-header">
                <div class="payment-card-title">
                    <i class="fas fa-filter"></i>
                    Bộ lọc tìm kiếm
                </div>
            </div>

            <div class="payment-card-body">
                <form
                    method="GET"
                    action="{{ route('Admin.thanh_toans.index') }}"
                    class="payment-filter-form"
                >
                    <div class="payment-filter-group">
                        <label
                            for="search"
                            class="payment-filter-label"
                        >
                            Mã giao dịch
                        </label>

                        <div class="payment-input-wrapper">
                            <i class="fas fa-search payment-input-icon"></i>

                            <input
                                type="text"
                                name="search"
                                id="search"
                                class="form-control"
                                value="{{ request('search') }}"
                                placeholder="Nhập mã giao dịch..."
                                autocomplete="off"
                            >
                        </div>
                    </div>

                    <div class="payment-filter-group">
                        <label
                            for="status"
                            class="payment-filter-label"
                        >
                            Trạng thái
                        </label>

                        <select
                            class="form-select"
                            name="status"
                            id="status"
                        >
                            <option value="">
                                Tất cả trạng thái
                            </option>

                            <option
                                value="da_thanh_toan"
                                @selected(request('status') === 'da_thanh_toan')
                            >
                                Đã thanh toán
                            </option>

                            <option
                                value="cho_thanh_toan"
                                @selected(request('status') === 'cho_thanh_toan')
                            >
                                Chờ thanh toán
                            </option>

                            <option
                                value="that_bai"
                                @selected(request('status') === 'that_bai')
                            >
                                Thất bại
                            </option>

                            <option
                                value="hoan_tien"
                                @selected(request('status') === 'hoan_tien')
                            >
                                Hoàn tiền
                            </option>
                        </select>
                    </div>

                    <button
                        type="submit"
                        class="btn-payment-filter btn-payment-search"
                    >
                        <i class="fas fa-search"></i>
                        Tìm kiếm
                    </button>

                    <a
                        href="{{ route('Admin.thanh_toans.index') }}"
                        class="btn-payment-filter btn-payment-reset"
                    >
                        <i class="fas fa-redo-alt"></i>
                        Đặt lại
                    </a>
                </form>
            </div>
        </div>

        {{-- Danh sách giao dịch --}}
        <div class="payment-card">
            <div class="payment-card-header">
                <div class="payment-card-title">
                    <i class="fas fa-credit-card"></i>
                    Danh sách giao dịch
                </div>

                <span class="payment-total-badge">
                    {{ $thanh_toans->total() }} giao dịch
                </span>
            </div>

            <div class="payment-table-wrapper">
                <table class="table payment-table">
                    <thead>
                        <tr>
                            <th>Mã giao dịch</th>
                            <th>Khách hàng</th>
                            <th>Tour</th>
                            <th>Phương thức</th>
                            <th>Số tiền</th>
                            <th>Ngày thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($thanh_toans as $thanh_toan)
                            @php
                                $datTour = $thanh_toan->datTour;

                                $khachHang = $datTour
                                    ? $datTour->khachHangs->first()
                                    : null;

                                $tenKhachHang = $khachHang->ho_ten
                                    ?? 'Không xác định';

                                $tenTour = $datTour->tour->ten_tour
                                    ?? 'Không xác định';

                                $paymentMethodClass =
                                    'payment-method-unknown';

                                $paymentMethodIcon = 'fa-question-circle';
                                $paymentMethodText = 'Không xác định';

                                if (
                                    $thanh_toan->phuong_thuc_thanh_toan
                                    === 'Tien mat'
                                ) {
                                    $paymentMethodClass =
                                        'payment-method-cash';

                                    $paymentMethodIcon = 'fa-money-bill-wave';
                                    $paymentMethodText = 'Tiền mặt';
                                } elseif (
                                    $thanh_toan->phuong_thuc_thanh_toan
                                    === 'Chuyen khoan'
                                ) {
                                    $paymentMethodClass =
                                        'payment-method-transfer';

                                    $paymentMethodIcon = 'fa-university';
                                    $paymentMethodText = 'Chuyển khoản';
                                } elseif (
                                    $thanh_toan->phuong_thuc_thanh_toan
                                    === 'VNPAY'
                                ) {
                                    $paymentMethodClass =
                                        'payment-method-vnpay';

                                    $paymentMethodIcon = 'fa-credit-card';
                                    $paymentMethodText = 'VNPay';
                                }
                            @endphp

                            <tr>
                                <td>
                                    <span class="payment-code">
                                        <i class="fas fa-receipt"></i>

                                        {{ $thanh_toan->ma_giao_dich ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="payment-customer">
                                        <span class="payment-customer-avatar">
                                            <i class="fas fa-user"></i>
                                        </span>

                                        <div>
                                            <div
                                                class="payment-customer-name"
                                                title="{{ $tenKhachHang }}"
                                            >
                                                {{ $tenKhachHang }}
                                            </div>

                                            <div class="payment-customer-label">
                                                Khách hàng
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="payment-tour">
                                        <span class="payment-tour-icon">
                                            <i class="fas fa-map-marked-alt"></i>
                                        </span>

                                        <div class="payment-tour-name">
                                            {{ $tenTour }}
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span
                                        class="payment-method {{ $paymentMethodClass }}"
                                    >
                                        <i class="fas {{ $paymentMethodIcon }}"></i>
                                        {{ $paymentMethodText }}
                                    </span>
                                </td>

                                <td>
                                    <span class="payment-amount">
                                        {{ number_format(
                                            $thanh_toan->so_tien ?? 0,
                                            0,
                                            ',',
                                            '.'
                                        ) }}đ
                                    </span>
                                </td>

                                <td>
                                    @if ($thanh_toan->thoi_gian_thanh_toan)
                                        <span class="payment-date">
                                            <i class="fas fa-calendar-alt"></i>

                                            {{ \Carbon\Carbon::parse(
                                                $thanh_toan->thoi_gian_thanh_toan
                                            )->format('d/m/Y H:i:s') }}
                                        </span>
                                    @else
                                        <span class="payment-date-empty">
                                            Chưa thanh toán
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if ($thanh_toan->trang_thai === 'da_thanh_toan')
                                        <span class="payment-status payment-status-paid">
                                            <span class="payment-status-dot"></span>
                                            Đã thanh toán
                                        </span>
                                    @elseif ($thanh_toan->trang_thai === 'cho_thanh_toan')
                                        <span class="payment-status payment-status-pending">
                                            <span class="payment-status-dot"></span>
                                            Chờ thanh toán
                                        </span>
                                    @elseif ($thanh_toan->trang_thai === 'that_bai')
                                        <span class="payment-status payment-status-failed">
                                            <span class="payment-status-dot"></span>
                                            Thất bại
                                        </span>
                                    @elseif ($thanh_toan->trang_thai === 'hoan_tien')
                                        <span class="payment-status payment-status-refund">
                                            <span class="payment-status-dot"></span>
                                            Hoàn tiền
                                        </span>
                                    @else
                                        <span class="payment-status payment-status-unknown">
                                            <span class="payment-status-dot"></span>
                                            Không xác định
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="payment-actions">
                                        <a
                                            href="{{ route(
                                                'Admin.thanh_toans.show',
                                                $thanh_toan->id
                                            ) }}"
                                            class="btn-payment-action btn-payment-view"
                                            title="Xem chi tiết"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a
                                            href="{{ route(
                                                'Admin.thanh_toans.edit_status',
                                                $thanh_toan->id
                                            ) }}"
                                            class="btn-payment-action btn-payment-edit"
                                            title="Cập nhật trạng thái"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="8"
                                    class="payment-empty-row"
                                >
                                    <div class="payment-empty-icon">
                                        <i class="fas fa-receipt"></i>
                                    </div>

                                    <div class="payment-empty-title">
                                        Chưa có giao dịch
                                    </div>

                                    <div class="payment-empty-text">
                                        Không tìm thấy giao dịch phù hợp với điều kiện tìm kiếm.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="payment-card-footer">
                <div class="payment-result-info">
                    @if ($thanh_toans->total() > 0)
                        Hiển thị {{ $thanh_toans->firstItem() }}
                        đến {{ $thanh_toans->lastItem() }}
                        trong tổng số {{ $thanh_toans->total() }} giao dịch
                    @else
                        Không có giao dịch nào
                    @endif
                </div>

                {{ $thanh_toans->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
