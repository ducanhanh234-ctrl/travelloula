@extends('layouts.admin')

@section('title', 'Quản lý xe')

@section('content')
    <style>
        :root {
            --vehicle-primary: #315be8;
            --vehicle-primary-dark: #244bd2;
            --vehicle-primary-light: #edf4ff;
            --vehicle-purple: #5b4dea;

            --vehicle-text-dark: #172b4d;
            --vehicle-text-main: #344563;
            --vehicle-text-muted: #6b7895;
            --vehicle-text-light: #98a2b3;

            --vehicle-border: #dce6f5;
            --vehicle-border-light: #e8eef8;

            --vehicle-white: #ffffff;
            --vehicle-soft: #f5f8ff;
            --vehicle-hover: #f3f7ff;

            --vehicle-success: #08754a;
            --vehicle-success-bg: #eaf9f1;

            --vehicle-info: #2763d9;
            --vehicle-info-bg: #edf4ff;

            --vehicle-warning: #ae6c0d;
            --vehicle-warning-bg: #fff7e8;

            --vehicle-danger: #c13d55;
            --vehicle-danger-bg: #fff0f3;

            --vehicle-neutral: #66738b;
            --vehicle-neutral-bg: #f1f4f8;
        }

        .vehicle-management-page {
            padding: 24px 0;
            color: var(--vehicle-text-dark);
        }

        /* Header trang */
        .vehicle-page-top {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .vehicle-page-heading {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .vehicle-page-icon {
            width: 47px;
            height: 47px;
            flex-shrink: 0;
            color: var(--vehicle-primary);
            background: var(--vehicle-primary-light);
            border: 1px solid #cfe0ff;
            border-radius: 12px;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .vehicle-page-heading h3 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .vehicle-page-heading p {
            margin: 6px 0 0;
            color: var(--vehicle-text-muted);
            font-size: 14px;
        }

        .btn-add-vehicle {
            min-height: 41px;
            padding: 9px 16px;
            color: var(--vehicle-white);
            background: linear-gradient(
                135deg,
                #315be8 0%,
                #3c6df0 55%,
                #594bea 100%
            );
            border: 1px solid #315be8;
            border-radius: 9px;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.23);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.18s ease;
        }

        .btn-add-vehicle:hover {
            color: var(--vehicle-white);
            background: linear-gradient(
                135deg,
                #264ed4 0%,
                #315edc 55%,
                #4d40d8 100%
            );
            border-color: #264ed4;
            box-shadow: 0 8px 20px rgba(49, 91, 232, 0.3);
            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Thông báo */
        .vehicle-alert {
            margin-bottom: 18px;
            padding: 14px 16px;
            color: var(--vehicle-success);
            background: var(--vehicle-success-bg);
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
        .vehicle-card {
            position: relative;
            overflow: hidden;
            background: var(--vehicle-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
        }

        .vehicle-card::before {
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
        .vehicle-card-header {
            position: relative;
            min-height: 115px;
            padding: 24px;
            overflow: hidden;
            color: var(--vehicle-white);
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

        .vehicle-card-header::before {
            position: absolute;
            right: -50px;
            bottom: -105px;
            width: 235px;
            height: 235px;
            content: "";
            border: 21px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .vehicle-card-header::after {
            position: absolute;
            top: -85px;
            right: 115px;
            width: 175px;
            height: 175px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .vehicle-card-heading {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .vehicle-card-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            color: var(--vehicle-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            box-shadow: 0 7px 18px rgba(20, 43, 128, 0.2);
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .vehicle-card-heading h4 {
            margin: 0;
            color: var(--vehicle-white);
            font-size: 20px;
            font-weight: 750;
        }

        .vehicle-card-heading p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 12px;
        }

        .vehicle-total {
            position: relative;
            z-index: 2;
            min-width: 105px;
            padding: 12px 15px;
            color: var(--vehicle-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 11px;
            text-align: center;
        }

        .vehicle-total strong {
            display: block;
            font-size: 22px;
            line-height: 1;
        }

        .vehicle-total span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.85;
        }

        .vehicle-card-body {
            padding: 22px;
        }

        /* Bộ lọc */
        .vehicle-filter-box {
            margin-bottom: 20px;
            padding: 16px;
            background: var(--vehicle-soft);
            border: 1px solid #d8e4f6;
            border-radius: 11px;
        }

        .vehicle-filter-title {
            margin-bottom: 13px;
            color: #29457d;
            font-size: 13px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .vehicle-filter-title i {
            color: var(--vehicle-primary);
        }

        .vehicle-filter-form {
            display: grid;
            grid-template-columns:
                minmax(280px, 1fr)
                minmax(210px, 280px)
                auto
                auto;
            gap: 10px;
            align-items: end;
        }

        .vehicle-filter-field label {
            margin-bottom: 6px;
            color: #40537a;
            font-size: 12px;
            font-weight: 700;
            display: block;
        }

        .vehicle-filter-control {
            position: relative;
        }

        .vehicle-filter-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            z-index: 2;
            color: #7686a5;
            font-size: 12px;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .vehicle-filter-form .form-control,
        .vehicle-filter-form .form-select {
            width: 100%;
            min-height: 40px;
            color: #344563;
            background: var(--vehicle-white);
            border: 1px solid #ccd9ed;
            border-radius: 8px;
            font-size: 13px;
            box-shadow: none;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .vehicle-filter-form .vehicle-filter-control .form-control {
            padding-left: 34px;
        }

        .vehicle-filter-form .form-control::placeholder {
            color: #9ca8bd;
        }

        .vehicle-filter-form .form-control:focus,
        .vehicle-filter-form .form-select:focus {
            border-color: #4f78eb;
            outline: none;
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
            cursor: pointer;
            text-decoration: none;
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
            color: var(--vehicle-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
            box-shadow: 0 4px 11px rgba(49, 91, 232, 0.2);
        }

        .btn-filter:hover {
            color: var(--vehicle-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #4c40d7
            );
            box-shadow: 0 6px 14px rgba(49, 91, 232, 0.27);
        }

        .btn-reset {
            color: #53698f;
            background: var(--vehicle-white);
            border-color: #ccd9ed;
        }

        .btn-reset:hover {
            color: #304d83;
            background: #eaf1fb;
            border-color: #b9c9e0;
        }

        /* Bảng */
        .vehicle-table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--vehicle-border);
            border-radius: 11px;
        }

        .vehicle-table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .vehicle-table-wrapper::-webkit-scrollbar-track {
            background: #f2f5fa;
        }

        .vehicle-table-wrapper::-webkit-scrollbar-thumb {
            background: #c5d2e5;
            border-radius: 999px;
        }

        .vehicle-table {
            width: 100%;
            min-width: 1080px;
            margin-bottom: 0;
            color: var(--vehicle-text-dark);
            vertical-align: middle;
        }

        .vehicle-table thead th {
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

        .vehicle-table tbody td {
            padding: 14px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--vehicle-border-light);
            font-size: 12px;
            line-height: 1.55;
            vertical-align: middle;
        }

        .vehicle-table tbody tr:last-child td {
            border-bottom: none;
        }

        .vehicle-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .vehicle-table tbody tr:hover {
            background: var(--vehicle-hover);
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .vehicle-table th:nth-child(1),
        .vehicle-table td:nth-child(1) {
            width: 150px;
            text-align: left;
        }

        .vehicle-table th:nth-child(2),
        .vehicle-table td:nth-child(2) {
            width: 155px;
            text-align: center;
        }

        .vehicle-table th:nth-child(3),
        .vehicle-table td:nth-child(3) {
            width: 145px;
            text-align: center;
        }

        .vehicle-table th:nth-child(4),
        .vehicle-table td:nth-child(4) {
            width: 125px;
            text-align: center;
        }

        .vehicle-table th:nth-child(5),
        .vehicle-table td:nth-child(5) {
            width: 230px;
            text-align: left;
        }

        .vehicle-table th:nth-child(6),
        .vehicle-table td:nth-child(6) {
            width: 165px;
            text-align: center;
        }

        .vehicle-table th:nth-child(7),
        .vehicle-table td:nth-child(7) {
            width: 125px;
            text-align: center;
        }

        /* Biển số */
        .vehicle-plate {
            color: #233f7a;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.02em;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .vehicle-plate i {
            color: #4f70d6;
            font-size: 10px;
        }

        .vehicle-color {
            margin-top: 4px;
            color: #8b97aa;
            font-size: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Loại xe */
        .vehicle-type-badge {
            padding: 5px 9px;
            color: #3158ce;
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .vehicle-type-badge i {
            font-size: 8px;
        }

        .vehicle-brand {
            color: #40537a;
            font-size: 12px;
            font-weight: 700;
        }

        .vehicle-year {
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

        /* Tài xế */
        .driver-info {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .driver-avatar {
            width: 35px;
            height: 35px;
            flex-shrink: 0;
            color: var(--vehicle-white);
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

        .driver-name {
            max-width: 160px;
            overflow: hidden;
            color: #344563;
            font-size: 12px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .driver-phone {
            margin-top: 3px;
            color: #8b97aa;
            font-size: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .empty-value {
            color: var(--vehicle-text-light);
            font-size: 11px;
            font-style: italic;
        }

        /* Trạng thái */
        .vehicle-status {
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

        .status-dot {
            width: 6px;
            height: 6px;
            flex-shrink: 0;
            border-radius: 50%;
            background: currentColor;
        }

        .status-active {
            color: var(--vehicle-success);
            background: var(--vehicle-success-bg);
            border-color: #c5ead8;
        }

        .status-running {
            color: var(--vehicle-info);
            background: var(--vehicle-info-bg);
            border-color: #c9dcff;
        }

        .status-maintenance {
            color: var(--vehicle-warning);
            background: var(--vehicle-warning-bg);
            border-color: #f1dba9;
        }

        .status-repair {
            color: var(--vehicle-danger);
            background: var(--vehicle-danger-bg);
            border-color: #f0c9d1;
        }

        .status-inactive {
            color: var(--vehicle-neutral);
            background: var(--vehicle-neutral-bg);
            border-color: #dce2ea;
        }

        /* Hành động */
        .vehicle-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            flex-wrap: nowrap;
        }

        .vehicle-actions form {
            margin: 0;
            display: inline-flex;
        }

        .btn-table-action {
            width: 30px;
            height: 30px;
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

        .btn-view {
            color: #2d5fd7;
            background: #eaf2ff;
            border-color: #c7dafe;
        }

        .btn-view:hover {
            color: var(--vehicle-white);
            background: #3867e5;
            border-color: #3867e5;
            box-shadow: 0 5px 12px rgba(56, 103, 229, 0.25);
        }

        .btn-edit {
            color: var(--vehicle-warning);
            background: var(--vehicle-warning-bg);
            border-color: #f1dba9;
        }

        .btn-edit:hover {
            color: var(--vehicle-white);
            background: #e39a25;
            border-color: #e39a25;
            box-shadow: 0 5px 12px rgba(227, 154, 37, 0.24);
        }

        .btn-delete {
            color: var(--vehicle-danger);
            background: var(--vehicle-danger-bg);
            border-color: #f0c9d1;
        }

        .btn-delete:hover {
            color: var(--vehicle-white);
            background: #df5067;
            border-color: #df5067;
            box-shadow: 0 5px 12px rgba(223, 80, 103, 0.23);
        }

        /* Không có dữ liệu */
        .vehicle-empty-row {
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
        .vehicle-card-footer {
            padding: 16px 22px;
            background: #fafcff;
            border-top: 1px solid var(--vehicle-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .vehicle-result-info {
            color: var(--vehicle-text-muted);
            font-size: 11px;
        }

        .vehicle-card-footer .pagination {
            margin: 0;
            gap: 4px;
        }

        .vehicle-card-footer .page-link {
            min-width: 34px;
            height: 34px;
            padding: 6px 10px;
            color: #3158ce;
            background: var(--vehicle-white);
            border: 1px solid #d6e1f2;
            border-radius: 7px !important;
            font-size: 12px;
            box-shadow: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vehicle-card-footer .page-link:hover {
            color: var(--vehicle-white);
            background: #416ce5;
            border-color: #416ce5;
        }

        .vehicle-card-footer .page-item.active .page-link {
            color: var(--vehicle-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
        }

        .vehicle-card-footer .page-item.disabled .page-link {
            color: #aab3c5;
            background: #f8f9fc;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .vehicle-filter-form {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .btn-filter-action {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .vehicle-management-page {
                padding: 14px 0;
            }

            .vehicle-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .vehicle-page-heading h3 {
                font-size: 20px;
            }

            .btn-add-vehicle {
                width: 100%;
            }

            .vehicle-card {
                border-radius: 11px;
            }

            .vehicle-card-header {
                min-height: 105px;
                padding: 20px 18px;
            }

            .vehicle-card-body {
                padding: 16px;
            }

            .vehicle-filter-form {
                grid-template-columns: 1fr;
            }

            .vehicle-card-footer {
                align-items: stretch;
                flex-direction: column;
            }

            .vehicle-result-info {
                text-align: center;
            }
        }

        @media (max-width: 520px) {
            .vehicle-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .vehicle-total {
                min-width: 100px;
                padding: 10px 13px;
            }
        }
    </style>

    <div class="container-fluid vehicle-management-page">
        <div class="vehicle-page-top">
            <div class="vehicle-page-heading">
                <span class="vehicle-page-icon">
                    <i class="fas fa-bus"></i>
                </span>

                <div>
                    <h3>Quản lý xe</h3>

                    <p>
                        Theo dõi phương tiện, tài xế và trạng thái vận hành.
                    </p>
                </div>
            </div>

            <a
                href="{{ route('Admin.phuong-tiens.create') }}"
                class="btn-add-vehicle"
            >
                <i class="fas fa-plus"></i>
                Thêm xe
            </a>
        </div>

        @if (session('success'))
            <div class="vehicle-alert">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="vehicle-card">
            <div class="vehicle-card-header">
                <div class="vehicle-card-heading">
                    <span class="vehicle-card-icon">
                        <i class="fas fa-bus"></i>
                    </span>

                    <div>
                        <h4>Danh sách phương tiện</h4>

                        <p>
                            Quản lý thông tin xe, tài xế và tình trạng vận hành.
                        </p>
                    </div>
                </div>

                <div class="vehicle-total">
                    <strong>{{ $phuongTiens->total() }}</strong>
                    <span>Phương tiện</span>
                </div>
            </div>

            <div class="vehicle-card-body">
                <div class="vehicle-filter-box">
                    <div class="vehicle-filter-title">
                        <i class="fas fa-filter"></i>
                        Bộ lọc tìm kiếm
                    </div>

                    <form
                        method="GET"
                        action="{{ route('Admin.phuong-tiens.index') }}"
                        class="vehicle-filter-form"
                    >
                        <div class="vehicle-filter-field">
                            <label for="keyword">Tìm kiếm phương tiện</label>

                            <div class="vehicle-filter-control">
                                <i class="fas fa-search vehicle-filter-icon"></i>

                                <input
                                    type="text"
                                    name="keyword"
                                    id="keyword"
                                    value="{{ request('keyword') }}"
                                    class="form-control"
                                    placeholder="Biển số, hãng xe, tài xế hoặc số điện thoại..."
                                    autocomplete="off"
                                >
                            </div>
                        </div>

                        <div class="vehicle-filter-field">
                            <label for="trang_thai">Trạng thái</label>

                            <select
                                name="trang_thai"
                                id="trang_thai"
                                class="form-select"
                            >
                                <option value="">
                                    Tất cả trạng thái
                                </option>

                                @foreach (\App\Models\PhuongTien::trangThaiList() as $key => $value)
                                    <option
                                        value="{{ $key }}"
                                        @selected(
                                            (string) request('trang_thai')
                                            === (string) $key
                                        )
                                    >
                                        {{ $value }}
                                    </option>
                                @endforeach
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
                            href="{{ route('Admin.phuong-tiens.index') }}"
                            class="btn-filter-action btn-reset"
                        >
                            <i class="fas fa-redo-alt"></i>
                            Đặt lại
                        </a>
                    </form>
                </div>

                <div class="vehicle-table-wrapper">
                    <table class="table vehicle-table">
                        <thead>
                            <tr>
                                <th>Biển số</th>
                                <th>Loại xe</th>
                                <th>Hãng xe</th>
                                <th>Năm sản xuất</th>
                                <th>Tài xế</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($phuongTiens as $phuongTien)
                                <tr>
                                    <td>
                                        <div class="vehicle-plate">
                                            <i class="fas fa-id-card"></i>

                                            {{ $phuongTien->bien_so_xe ?: 'Chưa cập nhật' }}
                                        </div>

                                        @if ($phuongTien->mau_xe)
                                            <div class="vehicle-color">
                                                <i class="fas fa-palette"></i>
                                                {{ $phuongTien->mau_xe }}
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="vehicle-type-badge">
                                            <i class="fas fa-bus"></i>
                                            {{ $phuongTien->loai_phuong_tien_text }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($phuongTien->hang_xe)
                                            <span class="vehicle-brand">
                                                {{ $phuongTien->hang_xe }}
                                            </span>
                                        @else
                                            <span class="empty-value">
                                                Chưa cập nhật
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($phuongTien->nam_san_xuat)
                                            <span class="vehicle-year">
                                                <i class="fas fa-calendar-alt"></i>
                                                {{ $phuongTien->nam_san_xuat }}
                                            </span>
                                        @else
                                            <span class="empty-value">
                                                Chưa cập nhật
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($phuongTien->ten_tai_xe)
                                            <div class="driver-info">
                                                <span class="driver-avatar">
                                                    {{ mb_strtoupper(
                                                        mb_substr(
                                                            $phuongTien->ten_tai_xe,
                                                            0,
                                                            1
                                                        )
                                                    ) }}
                                                </span>

                                                <div>
                                                    <div
                                                        class="driver-name"
                                                        title="{{ $phuongTien->ten_tai_xe }}"
                                                    >
                                                        {{ $phuongTien->ten_tai_xe }}
                                                    </div>

                                                    @if ($phuongTien->so_dien_thoai_tai_xe)
                                                        <div class="driver-phone">
                                                            <i class="fas fa-phone"></i>
                                                            {{ $phuongTien->so_dien_thoai_tai_xe }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <span class="empty-value">
                                                Chưa phân công tài xế
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @switch($phuongTien->trang_thai)
                                            @case(1)
                                                <span class="vehicle-status status-active">
                                                    <span class="status-dot"></span>
                                                    Hoạt động
                                                </span>
                                            @break

                                            @case(2)
                                                <span class="vehicle-status status-running">
                                                    <span class="status-dot"></span>
                                                    Đang chạy Tour
                                                </span>
                                            @break

                                            @case(3)
                                                <span class="vehicle-status status-maintenance">
                                                    <span class="status-dot"></span>
                                                    Bảo trì
                                                </span>
                                            @break

                                            @case(4)
                                                <span class="vehicle-status status-repair">
                                                    <span class="status-dot"></span>
                                                    Đang sửa chữa
                                                </span>
                                            @break

                                            @default
                                                <span class="vehicle-status status-inactive">
                                                    <span class="status-dot"></span>
                                                    Ngừng hoạt động
                                                </span>
                                        @endswitch
                                    </td>

                                    <td>
                                        <div class="vehicle-actions">
                                            <a
                                                href="{{ route('Admin.phuong-tiens.show', $phuongTien->id) }}"
                                                class="btn-table-action btn-view"
                                                title="Xem chi tiết"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a
                                                href="{{ route('Admin.phuong-tiens.edit', $phuongTien->id) }}"
                                                class="btn-table-action btn-edit"
                                                title="Chỉnh sửa"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form
                                                action="{{ route('Admin.phuong-tiens.destroy', $phuongTien->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa xe này?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn-table-action btn-delete"
                                                    title="Xóa phương tiện"
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
                                        colspan="7"
                                        class="vehicle-empty-row"
                                    >
                                        <div class="empty-state-icon">
                                            <i class="fas fa-bus"></i>
                                        </div>

                                        <div class="empty-state-title">
                                            Chưa có phương tiện nào
                                        </div>

                                        <div class="empty-state-text">
                                            Không tìm thấy xe phù hợp với điều
                                            kiện tìm kiếm.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="vehicle-card-footer">
                <div class="vehicle-result-info">
                    @if ($phuongTiens->total() > 0)
                        Hiển thị {{ $phuongTiens->firstItem() }}
                        đến {{ $phuongTiens->lastItem() }}
                        trong tổng số {{ $phuongTiens->total() }} phương tiện
                    @else
                        Không có phương tiện nào
                    @endif
                </div>

                {{ $phuongTiens->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
