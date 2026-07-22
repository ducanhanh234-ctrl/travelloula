@extends('Layouts.guide')

@section('title', 'Check-in hành khách')

@section('guide', 'Check-in hành khách')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('Guide.checkin.index') }}">
            Check-in
        </a>
    </li>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong>Tour</strong>
                    <br>
                    {{ $chiTiet->lichTrinh->tour->ten_tour }}
                </div>

    <li class="breadcrumb-item active">
        {{ $chiTiet->tieu_de ?? 'Danh sách hành khách' }}
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

                <div class="col-md-3">
                    <strong>Thời gian</strong>
                    <br>
                    {{ $chiTiet->gio_bat_dau }} - {{ $chiTiet->gio_ket_thuc }}
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-success">{{ $tongKhach }}</h3>
                    <small class="text-muted">Tổng hành khách</small>

            /* --checkin-border: #dce6f5;
            --checkin-border-light: #e8eef8;

            --checkin-success: #08754a;
            --checkin-success-bg: #eaf9f1;

            --checkin-warning: #ae6c0d;
            --checkin-warning-bg: #fff7e8;

            --checkin-danger: #c13d55;
            --checkin-danger-bg: #fff0f3;

            --checkin-info: #1975a8;
            --checkin-info-bg: #ebf8ff; */
        }

        .checkin-page {
            padding: 4px 0 24px;
            color: var(--checkin-text);
        }

        /* Header */
        .checkin-page-header {
            margin-bottom: 20px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .checkin-page-heading {
            min-width: 0;

            display: flex;
            align-items: center;
            gap: 13px;
        }

        .checkin-page-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;

            color: var(--checkin-white);

            background: linear-gradient(
                135deg,
                var(--checkin-primary),
                var(--checkin-purple)
            );

            border-radius: 12px;

            box-shadow:
                0 7px 18px rgba(49, 91, 232, 0.22);

            font-size: 18px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .checkin-page-heading h2 {
            margin: 0;

            color: var(--checkin-dark);
            font-size: 23px;
            font-weight: 800;
            letter-spacing: -0.2px;
        }

        .checkin-page-heading p {
            margin: 5px 0 0;

            color: var(--checkin-muted);
            font-size: 13px;
        }

        .btn-checkin-back {
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

        .btn-checkin-back:hover {
            color: var(--checkin-primary);
            background: var(--checkin-soft);
            border-color: #bfcff0;
            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Thông tin Tour */
        .checkin-info-card {
            position: relative;

            margin-bottom: 20px;

            overflow: hidden;

            background: var(--checkin-white);
            border: 1px solid var(--checkin-border);
            border-radius: 14px;

            box-shadow:
                0 7px 24px rgba(28, 65, 139, 0.08);
        }

        .checkin-info-card::before {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;

            height: 4px;
            content: "";

            background: linear-gradient(
                90deg,
                var(--checkin-primary),
                #3b79ee,
                var(--checkin-purple)
            );
        }

        .checkin-info-grid {
            padding: 23px 21px 19px;

            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }

        .checkin-info-item {
            min-width: 0;
            padding: 14px;

            background: #fafcff;
            border: 1px solid var(--checkin-border);
            border-radius: 10px;

            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .checkin-info-icon {
            width: 36px;
            height: 36px;
            flex-shrink: 0;

            color: var(--checkin-primary);
            background: #edf3ff;

            border: 1px solid #d4e2ff;
            border-radius: 9px;

            font-size: 12px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .checkin-info-content {
            min-width: 0;
        }

        .checkin-info-label {
            margin-bottom: 4px;

            color: var(--checkin-muted);
            font-size: 9px;
            font-weight: 750;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .checkin-info-value {
            color: #29457d;
            font-size: 12px;
            font-weight: 750;
            line-height: 1.55;
            overflow-wrap: anywhere;
        }

        /* Thống kê */
        .checkin-stats-grid {
            margin-bottom: 20px;

            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 15px;
        }

        .checkin-stat-card {
            position: relative;

            min-height: 120px;
            padding: 19px;

            overflow: hidden;

            background: var(--checkin-white);
            border: 1px solid var(--checkin-border);
            border-radius: 14px;

            box-shadow:
                0 7px 24px rgba(28, 65, 139, 0.08);

            display: flex;
            align-items: center;
            gap: 14px;

            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .checkin-stat-card:hover {
            box-shadow:
                0 10px 29px rgba(28, 65, 139, 0.13);

            transform: translateY(-2px);
        }

        .checkin-stat-card::after {
            position: absolute;
            right: -28px;
            bottom: -42px;

            width: 115px;
            height: 115px;

            content: "";

            background: rgba(49, 91, 232, 0.04);
            border-radius: 50%;
        }

        .checkin-stat-icon {
            position: relative;
            z-index: 2;

            width: 50px;
            height: 50px;
            flex-shrink: 0;

            border: 1px solid transparent;
            border-radius: 13px;

            font-size: 18px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .checkin-stat-total {
            color: var(--checkin-primary);
            background: #edf3ff;
            border-color: #d2e0ff;
        }

        .checkin-stat-checked {
            color: var(--checkin-success);
            background: var(--checkin-success-bg);
            border-color: #c5ead8;
        }

        .checkin-stat-unchecked {
            color: var(--checkin-danger);
            background: var(--checkin-danger-bg);
            border-color: #f0c9d1;
        }

        .checkin-stat-content {
            position: relative;
            z-index: 2;
        }

        .checkin-stat-value {
            color: #203e78;
            font-size: 25px;
            font-weight: 800;
            line-height: 1.15;
        }

        .checkin-stat-label {
            margin-top: 5px;

            color: var(--checkin-muted);
            font-size: 11px;
            font-weight: 650;
        }

        /* Tiến độ */
        .checkin-progress-card {
            margin-bottom: 20px;
            padding: 18px 20px;

            background: var(--checkin-white);
            border: 1px solid var(--checkin-border);
            border-radius: 14px;

            box-shadow:
                0 7px 24px rgba(28, 65, 139, 0.08);
        }

        .checkin-progress-header {
            margin-bottom: 12px;

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .checkin-progress-title {
            color: #29457d;
            font-size: 12px;
            font-weight: 750;

            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .checkin-progress-title i {
            color: var(--checkin-primary);
        }

        .checkin-progress-number {
            color: var(--checkin-muted);
            font-size: 11px;
            font-weight: 650;
        }

        .checkin-progress-track {
            width: 100%;
            height: 17px;

            overflow: hidden;

            background: #e9eef7;
            border-radius: 999px;
        }

        .checkin-progress-bar {
            min-width: 0;
            height: 100%;

            color: var(--checkin-white);

            background: linear-gradient(
                90deg,
                var(--checkin-primary),
                var(--checkin-purple)
            );

            border-radius: inherit;

            font-size: 9px;
            font-weight: 800;

            display: flex;
            align-items: center;
            justify-content: center;

            transition: width 0.4s ease;
        }

        /* Alert */
        .checkin-alert {
            margin-bottom: 18px;
            padding: 13px 15px;

            border: 1px solid transparent;
            border-radius: 10px;

            font-size: 12px;
            font-weight: 650;

            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkin-alert-success {
            color: var(--checkin-success);
            background: var(--checkin-success-bg);
            border-color: #bfe7d2;
        }

        .checkin-alert-danger {
            color: var(--checkin-danger);
            background: var(--checkin-danger-bg);
            border-color: #f0c9d1;
        }

        .checkin-alert-close {
            margin-left: auto;
            padding: 0;

            color: currentColor;
            background: transparent;
            border: none;

            font-size: 13px;
            cursor: pointer;
        }

        /* Nút thao tác chung */
        .checkin-main-actions {
            margin-bottom: 16px;

            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 9px;
            flex-wrap: wrap;
        }

        .checkin-main-actions form {
            margin: 0;
        }

        .btn-checkin {
            min-height: 39px;
            padding: 8px 13px;

            border: 1px solid transparent;
            border-radius: 8px;

            font-size: 11px;
            font-weight: 750;
            white-space: nowrap;
            cursor: pointer;

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

        .btn-checkin:hover {
            transform: translateY(-1px);
        }

        .btn-checkin-all {
            color: var(--checkin-white);

            background: linear-gradient(
                135deg,
                var(--checkin-primary),
                var(--checkin-purple)
            );

            border-color: var(--checkin-primary);

            box-shadow:
                0 5px 14px rgba(49, 91, 232, 0.2);
        }

        .btn-checkin-all:hover {
            color: var(--checkin-white);
            background: linear-gradient(
                135deg,
                var(--checkin-primary-dark),
                #4c40d7
            );
        }

        .btn-checkout-all {
            color: #704609;
            background: var(--checkin-warning-bg);
            border-color: #efd79f;
        }

        .btn-checkout-all:hover {
            color: var(--checkin-white);
            background: #dc941e;
            border-color: #dc941e;
        }

        /* Card danh sách */
        .checkin-list-card {
            overflow: hidden;

            background: var(--checkin-white);
            border: 1px solid var(--checkin-border);
            border-radius: 14px;

            box-shadow:
                0 8px 28px rgba(28, 65, 139, 0.09);
        }

        .checkin-list-header {
            min-height: 59px;
            padding: 15px 18px;

            color: #24417d;
            background: #f1f6ff;
            border-bottom: 1px solid var(--checkin-border);

            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 13px;
        }

        .checkin-list-title {
            font-size: 14px;
            font-weight: 750;

            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .checkin-list-title i {
            color: var(--checkin-primary);
        }

        .checkin-list-count {
            padding: 5px 10px;

            color: #3158ce;
            background: #e9f1ff;

            border: 1px solid #cfdeff;
            border-radius: 999px;

            font-size: 9px;
            font-weight: 800;
        }

        .checkin-table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .checkin-table {
            width: 100%;
            min-width: 1050px;
            margin: 0;

            vertical-align: middle;
        }

        .checkin-table thead th {
            padding: 13px 14px;

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

        .checkin-table tbody td {
            padding: 13px 14px;

            color: #4d5d7d;

            border-bottom:
                1px solid var(--checkin-border-light);

            font-size: 12px;
            vertical-align: middle;
        }

        .checkin-table tbody tr:last-child td {
            border-bottom: none;
        }

        .checkin-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .checkin-table tbody tr:hover {
            background: var(--checkin-hover);

            box-shadow:
                inset 3px 0 0 var(--checkin-primary);
        }

        .checkin-table th:nth-child(1),
        .checkin-table td:nth-child(1) {
            width: 70px;
            text-align: center;
        }

        .checkin-table th:nth-child(2),
        .checkin-table td:nth-child(2) {
            width: 230px;
        }

        .checkin-table th:nth-child(3),
        .checkin-table td:nth-child(3) {
            width: 155px;
        }

        .checkin-table th:nth-child(4),
        .checkin-table td:nth-child(4) {
            width: 150px;
            text-align: center;
        }

        .checkin-table th:nth-child(5),
        .checkin-table td:nth-child(5) {
            min-width: 190px;
        }

        .checkin-table th:nth-child(6),
        .checkin-table td:nth-child(6) {
            width: 235px;
            text-align: center;
        }

        .checkin-number {
            min-width: 32px;
            height: 30px;
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

        /* Khách hàng */
        .checkin-customer {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .checkin-customer-avatar {
            width: 36px;
            height: 36px;
            flex-shrink: 0;

            color: var(--checkin-primary);
            background: #edf3ff;

            border: 1px solid #d3e1ff;
            border-radius: 50%;

            font-size: 12px;

            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .checkin-customer-name {
            max-width: 180px;

            overflow: hidden;

            color: #233f7a;
            font-size: 12px;
            font-weight: 750;

            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .checkin-customer-label {
            margin-top: 2px;

            color: #8b97aa;
            font-size: 9px;
        }

        .checkin-phone {
            color: #4f6080;
            font-size: 11px;
            font-weight: 650;
            white-space: nowrap;

            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .checkin-phone i {
            color: var(--checkin-primary);
        }

        /* Trạng thái */
        .checkin-status {
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

        .checkin-status-dot {
            width: 6px;
            height: 6px;
            flex-shrink: 0;

            background: currentColor;
            border-radius: 50%;
        }

        .checkin-status-waiting {
            color: var(--checkin-danger);
            background: var(--checkin-danger-bg);
            border-color: #f0c9d1;
        }

        .checkin-status-checked {
            color: var(--checkin-success);
            background: var(--checkin-success-bg);
            border-color: #c5ead8;
        }

        .checkin-status-checkout {
            color: var(--checkin-info);
            background: var(--checkin-info-bg);
            border-color: #c8e8f5;
        }

        /* Ghi chú */
        .checkin-note {
            max-width: 240px;

            color: var(--checkin-danger);
            font-size: 11px;
            font-weight: 650;
            line-height: 1.55;
            overflow-wrap: anywhere;
        }

        .checkin-note-empty {
            color: var(--checkin-light);
            font-size: 10px;
            font-style: italic;
        }

        /* Action */
        .checkin-row-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .checkin-row-actions form {
            margin: 0;
        }

        .btn-checkin-row {
            min-height: 31px;
            padding: 6px 9px;

            border: 1px solid transparent;
            border-radius: 7px;

            font-size: 9px;
            font-weight: 750;
            white-space: nowrap;
            cursor: pointer;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;

            transition:
                color 0.16s ease,
                background-color 0.16s ease,
                border-color 0.16s ease,
                transform 0.16s ease;
        }

        .btn-checkin-row:hover {
            transform: translateY(-1px);
        }

        .btn-row-checkin {
            color: var(--checkin-success);
            background: var(--checkin-success-bg);
            border-color: #c5ead8;
        }

        .btn-row-checkin:hover {
            color: var(--checkin-white);
            background: #139461;
            border-color: #139461;
        }

        .btn-row-note {
            color: var(--checkin-warning);
            background: var(--checkin-warning-bg);
            border-color: #f1dba9;
        }

        .btn-row-note:hover {
            color: var(--checkin-white);
            background: #dc941e;
            border-color: #dc941e;
        }

        .btn-row-checkout {
            color: #704609;
            background: var(--checkin-warning-bg);
            border-color: #efd79f;
        }

        .btn-row-checkout:hover {
            color: var(--checkin-white);
            background: #dc941e;
            border-color: #dc941e;
        }

        .btn-row-undo {
            width: 31px;
            padding: 0;

            color: #53698f;
            background: #f4f6fa;
            border-color: #d7dfeb;
        }

        .btn-row-undo:hover {
            color: var(--checkin-white);
            background: #64748b;
            border-color: #64748b;
        }

        .btn-row-checkout-undo {
            color: var(--checkin-info);
            background: var(--checkin-info-bg);
            border-color: #c8e8f5;
        }

        .btn-row-checkout-undo:hover {
            color: var(--checkin-white);
            background: var(--checkin-info);
            border-color: var(--checkin-info);
        }

        /* Empty */
        .checkin-empty-row {
            padding: 50px 20px !important;
            text-align: center !important;
        }

        .checkin-empty-icon {
            width: 52px;
            height: 52px;
            margin: 0 auto 11px;

            color: var(--checkin-primary);
            background: #edf3ff;

            border: 1px solid #d3e1ff;
            border-radius: 13px;

            font-size: 19px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .checkin-empty-title {
            color: #506181;
            font-size: 13px;
            font-weight: 750;
        }

        .checkin-empty-text {
            margin-top: 3px;

            color: #8b97aa;
            font-size: 11px;
        }

        /* Modal */
        .checkin-modal .modal-content {
            overflow: hidden;

            border: 1px solid var(--checkin-border);
            border-radius: 14px;

            box-shadow:
                0 18px 50px rgba(28, 65, 139, 0.2);
        }

        .checkin-modal .modal-header {
            padding: 16px 18px;

            color: var(--checkin-white);

            background: linear-gradient(
                135deg,
                var(--checkin-primary),
                var(--checkin-purple)
            );

            border-bottom: none;
        }

        .checkin-modal .modal-title {
            font-size: 15px;
            font-weight: 750;

            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .checkin-modal .modal-body {
            padding: 20px;
        }

        .checkin-modal-customer {
            padding: 12px 14px;
            margin-bottom: 15px;

            color: #29457d;
            background: var(--checkin-soft);

            border: 1px solid var(--checkin-border);
            border-radius: 9px;

            font-size: 12px;
            font-weight: 750;

            display: flex;
            align-items: center;
            gap: 8px;
        }

        .checkin-modal-customer i {
            color: var(--checkin-primary);
        }

        .checkin-modal textarea {
            min-height: 120px;

            color: var(--checkin-text);

            border: 1px solid #cfdaec;
            border-radius: 9px;

            font-size: 12px;
            resize: vertical;
            box-shadow: none;
        }

        .checkin-modal textarea:focus {
            border-color: var(--checkin-primary);

            box-shadow:
                0 0 0 4px rgba(49, 91, 232, 0.1);
        }

        .checkin-modal .modal-footer {
            padding: 14px 18px;

            background: #fafcff;
            border-top: 1px solid var(--checkin-border);
        }

        .btn-modal-cancel,
        .btn-modal-save {
            min-height: 38px;
            padding: 8px 14px;

            border: 1px solid transparent;
            border-radius: 8px;

            font-size: 11px;
            font-weight: 750;

            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .btn-modal-cancel {
            color: #53698f;
            background: var(--checkin-white);
            border-color: #ccd9ed;
        }

        .btn-modal-save {
            color: var(--checkin-white);

            background: linear-gradient(
                135deg,
                var(--checkin-primary),
                var(--checkin-purple)
            );

            border-color: var(--checkin-primary);
        }

        @media (max-width: 1100px) {
            .checkin-info-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .checkin-page-header {
                align-items: stretch;
                flex-direction: column;
            }

            .checkin-page-heading h2 {
                font-size: 20px;
            }

            .btn-checkin-back {
                width: 100%;
            }

            .checkin-info-grid,
            .checkin-stats-grid {
                grid-template-columns: 1fr;
            }

            .checkin-main-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .checkin-main-actions form,
            .checkin-main-actions .btn-checkin {
                width: 100%;
            }

            .checkin-list-header {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    @php
        $phanTramCheckIn = $tongKhach > 0
            ? round(($daCheck / $tongKhach) * 100)
            : 0;

        $phanTramCheckIn = min(
            max($phanTramCheckIn, 0),
            100
        );
    @endphp

    <div class="checkin-page fade-in">
        {{-- Header --}}
        <div class="checkin-page-header">
            <div class="checkin-page-heading">
                <span class="checkin-page-icon">
                    <i class="fas fa-user-check"></i>
                </span>

                <div>
                    <h2>Check-in hành khách</h2>

                    <p>
                        {{ $chiTiet->tieu_de ?? 'Điểm tham quan' }}
                    </p>
>>>>>>> origin/main
                </div>
            </div>

            <a
                href="{{ route(
                    'Guide.checkin.dia-diem',
                    $lichKhoiHanhId
                ) }}"
                class="btn-checkin-back"
            >
                <i class="fas fa-arrow-left"></i>
                Quay lại
            </a>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-primary">{{ $daCheck }}</h3>
                    <small class="text-muted">Đã check-in</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-danger">{{ $chuaCheck }}</h3>
                    <small class="text-muted">Chưa check-in</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <strong>Tiến độ Check-in</strong>
                <span>{{ $daCheck }}/{{ $tongKhach }} hành khách</span>
            </div>

            <div class="progress" style="height: 22px;">
                <div class="progress-bar bg-success" role="progressbar"
                    style="width: {{ $tongKhach > 0 ? ($daCheck / $tongKhach) * 100 : 0 }}%;">
                    {{ round($tongKhach > 0 ? ($daCheck / $tongKhach) * 100 : 0) }}%
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mb-3">
        <form action="{{ route('Guide.checkin.checkinTatCa') }}" method="POST" class="me-2">
            @csrf
            <input type="hidden" name="lich_khoi_hanh_id" value="{{ $lichKhoiHanhId }}">
            <input type="hidden" name="chi_tiet_lich_trinh_id" value="{{ $chiTiet->id }}">
            <button class="btn btn-success">
                <i class="fas fa-user-check"></i>
                Check-in tất cả
            </button>
        </form>

        <form action="{{ route('Guide.checkin.checkoutTatCa') }}" method="POST">
            @csrf
            <input type="hidden" name="chi_tiet_lich_trinh_id" value="{{ $chiTiet->id }}">
            <button class="btn btn-warning">
                <i class="fas fa-sign-out-alt"></i>
                Check-out tất cả
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <table class="table table-bordered table-hover align-middle">
        <tr>
            <th width="60">STT</th>
            <th width="220">Họ tên</th>
            <th width="140">SĐT</th>
            <th width="160" class="text-center">Trạng thái</th>
            <th>Ghi chú</th>
            <th width="220" class="text-center">Thao tác</th>
        </tr>

        @php
            $stt = 1;
        @endphp

        @foreach($datTours as $datTour)
            @foreach($datTour->khachHangs as $khach)
                <tr>
                    <td>{{ $stt++ }}</td>
                    <td>{{ $khach->ho_ten }}</td>
                    <td>{{ $khach->so_dien_thoai }}</td>
                    <td class="text-center">
                        @php
                            $checkIn = $checkIns[$khach->id] ?? null;
                        @endphp

                        @if(!$checkIn || $checkIn->trang_thai == 'chua_check_in')
                            <span class="badge badge-check bg-danger">
                                Chưa check-in
                            </span>

                        @elseif($checkIn->trang_thai == 'da_check_in')
                            <span class="badge badge-check bg-success">
                                Đã check-in
                            </span>

                        @else
                            <span class="badge badge-check bg-primary">
                                Đã check-out
                            </span>

                        @endif
                    </td>

                    <td>
                        @if($checkIn && $checkIn->ghi_chu)
                            <span class="text-danger">
                                {{ $checkIn->ghi_chu }}
                            </span>
                        @else
                            <span class="text-muted">
                                Chưa có
                            </span>
                        @endif
                    </td>

                    <td class="text-center">
                        @if(!$checkIn || $checkIn->trang_thai == 'chua_check_in')
                            <div class="d-flex gap-2 justify-content-center flex-nowrap">
                                <form action="{{ route('Guide.checkin.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="khach_hang_dat_tour_id" value="{{ $khach->id }}">
                                    <input type="hidden" name="lich_khoi_hanh_id" value="{{ $datTour->lich_khoi_hanh_id }}">
                                    <input type="hidden" name="chi_tiet_lich_trinh_id" value="{{ $chiTiet->id }}">

                                    <button class="btn btn-success btn-sm">
                                        <i class="fas fa-user-check"></i>
                                        Check-in
                                    </button>
                                </form>

                                <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#ghiChuModal{{ $khach->id }}">
                                    <i class="fas fa-pen"></i>
                                    {{ $checkIn && $checkIn->ghi_chu ? 'Sửa' : 'Ghi chú' }}
                                </button>
                            </div>

                        @elseif($checkIn->trang_thai == 'da_check_in')
                            <div class="d-flex gap-2">
                                <form action="{{ route('Guide.checkout', $checkIn->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button class="btn btn-warning btn-sm">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Check-out
                                    </button>
                                </form>

                                <form action="{{ route('Guide.checkin.undo', $checkIn->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-secondary btn-sm">
                                        <i class="fas fa-rotate-left"></i>
                                    </button>
                                </form>
                            </div>

                        @elseif($checkIn->trang_thai == 'da_check_out')
                            <form action="{{ route('Guide.checkout.undo', $checkIn->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-info btn-sm">
                                    <i class="fas fa-rotate-left"></i>
                                    Hoàn tác
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>

                <div class="modal fade" id="ghiChuModal{{ $khach->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('Guide.checkin.note') }}" method="POST">
                                @csrf
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title">
                                        Ghi chú hành khách
                                    </h5>

                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <strong>{{ $khach->ho_ten }}</strong>
                                    <input type="hidden" name="khach_hang_dat_tour_id" value="{{ $khach->id }}">
                                    <input type="hidden" name="lich_khoi_hanh_id" value="{{ $datTour->lich_khoi_hanh_id }}">
                                    <input type="hidden" name="chi_tiet_lich_trinh_id" value="{{ $chiTiet->id }}">
                                    <textarea name="ghi_chu" class="form-control mt-3" rows="4"
                                        placeholder="Ví dụ: Khách đến muộn..." required>{{ $checkIn->ghi_chu ?? '' }}</textarea>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Hủy
                                    </button>

                                    <button class="btn btn-success">
                                        Lưu ghi chú
                                    </button>
                                </div>
                            </form>

        {{-- Thông tin lịch trình --}}
        <div class="checkin-info-card">
            <div class="checkin-info-grid">
                <div class="checkin-info-item">
                    <span class="checkin-info-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </span>

                    <div class="checkin-info-content">
                        <div class="checkin-info-label">
                            Tour
                        </div>

                        <div class="checkin-info-value">
                            {{
                                $chiTiet
                                    ->lichTrinh
                                    ->tour
                                    ->ten_tour
                                ?? 'Không xác định'
                            }}

                        </div>
                    </div>
                </div>

                <div class="checkin-info-item">
                    <span class="checkin-info-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </span>

                    <div class="checkin-info-content">
                        <div class="checkin-info-label">
                            Địa điểm
                        </div>

                        <div class="checkin-info-value">
                            {{ $chiTiet->tieu_de ?? 'Không xác định' }}
                        </div>
                    </div>
                </div>

                <div class="checkin-info-item">
                    <span class="checkin-info-icon">
                        <i class="fas fa-calendar-day"></i>
                    </span>

                    <div class="checkin-info-content">
                        <div class="checkin-info-label">
                            Ngày Tour
                        </div>

                        <div class="checkin-info-value">
                            Ngày {{
                                $chiTiet
                                    ->lichTrinh
                                    ->ngay_thu
                                ?? '-'
                            }}
                        </div>
                    </div>
                </div>

                <div class="checkin-info-item">
                    <span class="checkin-info-icon">
                        <i class="fas fa-clock"></i>
                    </span>

                    <div class="checkin-info-content">
                        <div class="checkin-info-label">
                            Thời gian
                        </div>

                        <div class="checkin-info-value">
                            {{ $chiTiet->gio_bat_dau ?? '--:--' }}
                            -
                            {{ $chiTiet->gio_ket_thuc ?? '--:--' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Thống kê --}}
        <div class="checkin-stats-grid">
            <div class="checkin-stat-card">
                <span class="checkin-stat-icon checkin-stat-total">
                    <i class="fas fa-users"></i>
                </span>

                <div class="checkin-stat-content">
                    <div class="checkin-stat-value">
                        {{ $tongKhach }}
                    </div>

                    <div class="checkin-stat-label">
                        Tổng hành khách
                    </div>
                </div>
            </div>

            <div class="checkin-stat-card">
                <span class="checkin-stat-icon checkin-stat-checked">
                    <i class="fas fa-user-check"></i>
                </span>

                <div class="checkin-stat-content">
                    <div class="checkin-stat-value">
                        {{ $daCheck }}
                    </div>

                    <div class="checkin-stat-label">
                        Đã Check-in
                    </div>
                </div>
            </div>

            <div class="checkin-stat-card">
                <span class="checkin-stat-icon checkin-stat-unchecked">
                    <i class="fas fa-user-clock"></i>
                </span>

                <div class="checkin-stat-content">
                    <div class="checkin-stat-value">
                        {{ $chuaCheck }}
                    </div>

                    <div class="checkin-stat-label">
                        Chưa Check-in
                    </div>
                </div>
            </div>
        </div>

        {{-- Tiến độ --}}
        <div class="checkin-progress-card">
            <div class="checkin-progress-header">
                <div class="checkin-progress-title">
                    <i class="fas fa-chart-line"></i>
                    Tiến độ Check-in
                </div>

                <div class="checkin-progress-number">
                    {{ $daCheck }}/{{ $tongKhach }} hành khách
                </div>
            </div>

            <div class="checkin-progress-track">
                <div
                    class="checkin-progress-bar"
                    role="progressbar"
                    style="width: {{ $phanTramCheckIn }}%;"
                    aria-valuenow="{{ $phanTramCheckIn }}"
                    aria-valuemin="0"
                    aria-valuemax="100"
                >
                    @if ($phanTramCheckIn >= 10)
                        {{ $phanTramCheckIn }}%
                    @endif
                </div>
            </div>
        </div>

        {{-- Thông báo --}}
        @if (session('success'))
            <div
                class="checkin-alert checkin-alert-success"
                role="alert"
            >
                <i class="fas fa-check-circle"></i>

                <span>
                    {{ session('success') }}
                </span>

                <button
                    type="button"
                    class="checkin-alert-close"
                    onclick="this.parentElement.remove();"
                    aria-label="Đóng"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div
                class="checkin-alert checkin-alert-danger"
                role="alert"
            >
                <i class="fas fa-exclamation-circle"></i>

                <span>
                    {{ session('error') }}
                </span>

                <button
                    type="button"
                    class="checkin-alert-close"
                    onclick="this.parentElement.remove();"
                    aria-label="Đóng"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        {{-- Thao tác tất cả --}}
        <div class="checkin-main-actions">
            <form
                action="{{ route('Guide.checkin.checkinTatCa') }}"
                method="POST"
                onsubmit="return confirm('Bạn có chắc muốn Check-in tất cả hành khách?');"
            >
                @csrf

                <input
                    type="hidden"
                    name="lich_khoi_hanh_id"
                    value="{{ $lichKhoiHanhId }}"
                >

                <input
                    type="hidden"
                    name="chi_tiet_lich_trinh_id"
                    value="{{ $chiTiet->id }}"
                >

                <button
                    type="submit"
                    class="btn-checkin btn-checkin-all"
                    {{ $tongKhach <= 0 ? 'disabled' : '' }}
                >
                    <i class="fas fa-user-check"></i>
                    Check-in tất cả
                </button>
            </form>

            <form
                action="{{ route('Guide.checkin.checkoutTatCa') }}"
                method="POST"
                onsubmit="return confirm('Bạn có chắc muốn Check-out tất cả hành khách?');"
            >
                @csrf

                <input
                    type="hidden"
                    name="chi_tiet_lich_trinh_id"
                    value="{{ $chiTiet->id }}"
                >

                <button
                    type="submit"
                    class="btn-checkin btn-checkout-all"
                    {{ $tongKhach <= 0 ? 'disabled' : '' }}
                >
                    <i class="fas fa-sign-out-alt"></i>
                    Check-out tất cả
                </button>
            </form>
        </div>

        {{-- Danh sách hành khách --}}
        <div class="checkin-list-card">
            <div class="checkin-list-header">
                <div class="checkin-list-title">
                    <i class="fas fa-users"></i>
                    Danh sách hành khách
                </div>

                <span class="checkin-list-count">
                    {{ $tongKhach }} hành khách
                </span>
            </div>

            <div class="checkin-table-wrapper">
                <table class="table checkin-table">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Họ tên</th>
                            <th>Số điện thoại</th>
                            <th>Trạng thái</th>
                            <th>Ghi chú</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $stt = 1;
                        @endphp

                        @if ($tongKhach > 0)
                            @foreach ($datTours as $datTour)
                                @foreach ($datTour->khachHangs as $khach)
                                    @php
                                        $checkIn =
                                            $checkIns[$khach->id]
                                            ?? null;
                                    @endphp

                                    <tr>
                                        <td>
                                            <span class="checkin-number">
                                                {{ $stt++ }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="checkin-customer">
                                                <span class="checkin-customer-avatar">
                                                    <i class="fas fa-user"></i>
                                                </span>

                                                <div>
                                                    <div
                                                        class="checkin-customer-name"
                                                        title="{{ $khach->ho_ten }}"
                                                    >
                                                        {{ $khach->ho_ten }}
                                                    </div>

                                                    <div class="checkin-customer-label">
                                                        Hành khách
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="checkin-phone">
                                                <i class="fas fa-phone-alt"></i>

                                                {{
                                                    $khach->so_dien_thoai
                                                    ?: 'Chưa cập nhật'
                                                }}
                                            </span>
                                        </td>

                                        <td>
                                            @if (
                                                !$checkIn ||
                                                $checkIn->trang_thai
                                                === 'chua_check_in'
                                            )
                                                <span class="checkin-status checkin-status-waiting">
                                                    <span class="checkin-status-dot"></span>
                                                    Chưa Check-in
                                                </span>
                                            @elseif (
                                                $checkIn->trang_thai
                                                === 'da_check_in'
                                            )
                                                <span class="checkin-status checkin-status-checked">
                                                    <span class="checkin-status-dot"></span>
                                                    Đã Check-in
                                                </span>
                                            @else
                                                <span class="checkin-status checkin-status-checkout">
                                                    <span class="checkin-status-dot"></span>
                                                    Đã Check-out
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            @if (
                                                $checkIn &&
                                                $checkIn->ghi_chu
                                            )
                                                <div class="checkin-note">
                                                    <i class="fas fa-sticky-note me-1"></i>
                                                    {{ $checkIn->ghi_chu }}
                                                </div>
                                            @else
                                                <span class="checkin-note-empty">
                                                    Chưa có ghi chú
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            @if (
                                                !$checkIn ||
                                                $checkIn->trang_thai
                                                === 'chua_check_in'
                                            )
                                                <div class="checkin-row-actions">
                                                    <form
                                                        action="{{ route('Guide.checkin.store') }}"
                                                        method="POST"
                                                    >
                                                        @csrf

                                                        <input
                                                            type="hidden"
                                                            name="khach_hang_dat_tour_id"
                                                            value="{{ $khach->id }}"
                                                        >

                                                        <input
                                                            type="hidden"
                                                            name="lich_khoi_hanh_id"
                                                            value="{{ $datTour->lich_khoi_hanh_id }}"
                                                        >

                                                        <input
                                                            type="hidden"
                                                            name="chi_tiet_lich_trinh_id"
                                                            value="{{ $chiTiet->id }}"
                                                        >

                                                        <button
                                                            type="submit"
                                                            class="btn-checkin-row btn-row-checkin"
                                                        >
                                                            <i class="fas fa-user-check"></i>
                                                            Check-in
                                                        </button>
                                                    </form>

                                                    <button
                                                        type="button"
                                                        class="btn-checkin-row btn-row-note"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#ghiChuModal{{ $khach->id }}"
                                                    >
                                                        <i class="fas fa-pen"></i>

                                                        {{
                                                            $checkIn &&
                                                            $checkIn->ghi_chu
                                                                ? 'Sửa ghi chú'
                                                                : 'Ghi chú'
                                                        }}
                                                    </button>
                                                </div>
                                            @elseif (
                                                $checkIn->trang_thai
                                                === 'da_check_in'
                                            )
                                                <div class="checkin-row-actions">
                                                    <form
                                                        action="{{ route(
                                                            'Guide.checkout',
                                                            $checkIn->id
                                                        ) }}"
                                                        method="POST"
                                                    >
                                                        @csrf
                                                        @method('PATCH')

                                                        <button
                                                            type="submit"
                                                            class="btn-checkin-row btn-row-checkout"
                                                        >
                                                            <i class="fas fa-sign-out-alt"></i>
                                                            Check-out
                                                        </button>
                                                    </form>

                                                    <form
                                                        action="{{ route(
                                                            'Guide.checkin.undo',
                                                            $checkIn->id
                                                        ) }}"
                                                        method="POST"
                                                    >
                                                        @csrf

                                                        <button
                                                            type="submit"
                                                            class="btn-checkin-row btn-row-undo"
                                                            title="Hoàn tác Check-in"
                                                            onclick="return confirm('Hoàn tác trạng thái Check-in của hành khách này?');"
                                                        >
                                                            <i class="fas fa-rotate-left"></i>
                                                        </button>
                                                    </form>

                                                    <button
                                                        type="button"
                                                        class="btn-checkin-row btn-row-note"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#ghiChuModal{{ $khach->id }}"
                                                    >
                                                        <i class="fas fa-pen"></i>
                                                        Ghi chú
                                                    </button>
                                                </div>
                                            @elseif (
                                                $checkIn->trang_thai
                                                === 'da_check_out'
                                            )
                                                <div class="checkin-row-actions">
                                                    <form
                                                        action="{{ route(
                                                            'Guide.checkout.undo',
                                                            $checkIn->id
                                                        ) }}"
                                                        method="POST"
                                                    >
                                                        @csrf

                                                        <button
                                                            type="submit"
                                                            class="btn-checkin-row btn-row-checkout-undo"
                                                            onclick="return confirm('Hoàn tác trạng thái Check-out của hành khách này?');"
                                                        >
                                                            <i class="fas fa-rotate-left"></i>
                                                            Hoàn tác
                                                        </button>
                                                    </form>

                                                    <button
                                                        type="button"
                                                        class="btn-checkin-row btn-row-note"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#ghiChuModal{{ $khach->id }}"
                                                    >
                                                        <i class="fas fa-pen"></i>
                                                        Ghi chú
                                                    </button>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        @else
                            <tr>
                                <td
                                    colspan="6"
                                    class="checkin-empty-row"
                                >
                                    <div class="checkin-empty-icon">
                                        <i class="fas fa-users-slash"></i>
                                    </div>

                                    <div class="checkin-empty-title">
                                        Chưa có hành khách
                                    </div>

                                    <div class="checkin-empty-text">
                                        Chưa có hành khách trong lịch khởi hành này.
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal ghi chú đặt ngoài Table để HTML hợp lệ --}}
    @foreach ($datTours as $datTour)
        @foreach ($datTour->khachHangs as $khach)
            @php
                $checkIn = $checkIns[$khach->id] ?? null;
            @endphp

            <div
                class="modal fade checkin-modal"
                id="ghiChuModal{{ $khach->id }}"
                tabindex="-1"
                aria-labelledby="ghiChuModalLabel{{ $khach->id }}"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form
                            action="{{ route('Guide.checkin.note') }}"
                            method="POST"
                        >
                            @csrf

                            <div class="modal-header">
                                <h5
                                    class="modal-title"
                                    id="ghiChuModalLabel{{ $khach->id }}"
                                >
                                    <i class="fas fa-sticky-note"></i>
                                    Ghi chú hành khách
                                </h5>

                                <button
                                    type="button"
                                    class="btn-close btn-close-white"
                                    data-bs-dismiss="modal"
                                    aria-label="Đóng"
                                ></button>
                            </div>

                            <div class="modal-body">
                                <div class="checkin-modal-customer">
                                    <i class="fas fa-user"></i>
                                    {{ $khach->ho_ten }}
                                </div>

                                <input
                                    type="hidden"
                                    name="khach_hang_dat_tour_id"
                                    value="{{ $khach->id }}"
                                >

                                <input
                                    type="hidden"
                                    name="lich_khoi_hanh_id"
                                    value="{{ $datTour->lich_khoi_hanh_id }}"
                                >

                                <input
                                    type="hidden"
                                    name="chi_tiet_lich_trinh_id"
                                    value="{{ $chiTiet->id }}"
                                >

                                <label
                                    for="ghi_chu_{{ $khach->id }}"
                                    class="form-label fw-semibold"
                                >
                                    Nội dung ghi chú
                                </label>

                                <textarea
                                    name="ghi_chu"
                                    id="ghi_chu_{{ $khach->id }}"
                                    class="form-control"
                                    rows="4"
                                    placeholder="Ví dụ: Khách đến muộn, cần hỗ trợ đặc biệt..."
                                    required
                                >{{ $checkIn->ghi_chu ?? '' }}</textarea>
                            </div>

                            <div class="modal-footer">
                                <button
                                    type="button"
                                    class="btn-modal-cancel"
                                    data-bs-dismiss="modal"
                                >
                                    <i class="fas fa-times"></i>
                                    Hủy
                                </button>

                                <button
                                    type="submit"
                                    class="btn-modal-save"
                                >
                                    <i class="fas fa-save"></i>
                                    Lưu ghi chú
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach
@endsection
