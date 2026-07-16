@extends('layouts.admin')

@section('title', 'Quản lý Phân công')

@section('breadcrumb')
    <li class="breadcrumb-item active">
        Quản lý Phân công
    </li>
@endsection

@section('content')
    <style>
        :root {
            --assignment-primary: #315be8;
            --assignment-primary-dark: #244bd2;
            --assignment-primary-light: #edf4ff;
            --assignment-purple: #5b4dea;

            --assignment-text-dark: #172b4d;
            --assignment-text-main: #344563;
            --assignment-text-muted: #6b7895;
            --assignment-text-light: #98a2b3;

            --assignment-border: #dce6f5;
            --assignment-border-light: #e8eef8;

            --assignment-white: #ffffff;
            --assignment-soft: #f5f8ff;
            --assignment-hover: #f3f7ff;

            --assignment-success: #08754a;
            --assignment-success-bg: #eaf9f1;

            --assignment-warning: #ae6c0d;
            --assignment-warning-bg: #fff7e8;

            --assignment-danger: #c13d55;
            --assignment-danger-bg: #fff0f3;
        }

        .assignment-page {
            padding: 24px 0;
            color: var(--assignment-text-dark);
        }

        /* Header trang */
        .assignment-page-top {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .assignment-page-heading {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .assignment-page-icon {
            width: 47px;
            height: 47px;
            flex-shrink: 0;
            color: var(--assignment-primary);
            background: var(--assignment-primary-light);
            border: 1px solid #cfe0ff;
            border-radius: 12px;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .assignment-page-heading h3 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .assignment-page-heading p {
            margin: 6px 0 0;
            color: var(--assignment-text-muted);
            font-size: 14px;
        }

        .btn-add-assignment {
            min-height: 41px;
            padding: 9px 16px;
            color: var(--assignment-white);
            background: linear-gradient(135deg,
                    #315be8 0%,
                    #3c6df0 55%,
                    #594bea 100%);
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

        .btn-add-assignment:hover {
            color: var(--assignment-white);
            background: linear-gradient(135deg,
                    #264ed4 0%,
                    #315edc 55%,
                    #4d40d8 100%);
            border-color: #264ed4;
            box-shadow: 0 8px 20px rgba(49, 91, 232, 0.3);
            text-decoration: none;
            transform: translateY(-1px);
        }

        /* Thông báo */
        .assignment-alert {
            margin-bottom: 18px;
            padding: 14px 16px;
            border: 1px solid transparent;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(16, 24, 40, 0.05);
            font-size: 13px;
            font-weight: 650;
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .assignment-alert-danger {
            color: #a33549;
            background: var(--assignment-danger-bg);
            border-color: #efc7cf;
        }

        /* Card chính */
        .assignment-card {
            position: relative;
            overflow: hidden;
            background: var(--assignment-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
        }

        .assignment-card::before {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            z-index: 3;
            height: 4px;
            content: "";
            background: linear-gradient(90deg,
                    #2458e7,
                    #3478ef,
                    #18c7e7,
                    #5947e9);
        }

        /* Header card */
        .assignment-card-header {
            position: relative;
            min-height: 115px;
            padding: 24px;
            overflow: hidden;
            color: var(--assignment-white);
            background: linear-gradient(120deg,
                    #2856df 0%,
                    #316cec 55%,
                    #5b49e8 100%);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .assignment-card-header::before {
            position: absolute;
            right: -50px;
            bottom: -105px;
            width: 235px;
            height: 235px;
            content: "";
            border: 21px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .assignment-card-header::after {
            position: absolute;
            top: -85px;
            right: 115px;
            width: 175px;
            height: 175px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .assignment-card-heading {
            position: relative;
            z-index: 2;
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .assignment-card-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            color: var(--assignment-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            box-shadow: 0 7px 18px rgba(20, 43, 128, 0.2);
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .assignment-card-heading h4 {
            margin: 0;
            color: var(--assignment-white);
            font-size: 20px;
            font-weight: 750;
        }

        .assignment-card-heading p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 12px;
        }

        .assignment-total {
            position: relative;
            z-index: 2;
            min-width: 105px;
            padding: 12px 15px;
            color: var(--assignment-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 11px;
            text-align: center;
        }

        .assignment-total strong {
            display: block;
            font-size: 22px;
            line-height: 1;
        }

        .assignment-total span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.85;
        }

        .assignment-card-body {
            padding: 22px;
        }

        /* Bộ lọc */
        .assignment-filter-box {
            margin-bottom: 20px;
            padding: 16px;
            background: var(--assignment-soft);
            border: 1px solid #d8e4f6;
            border-radius: 11px;
        }

        .assignment-filter-title {
            margin-bottom: 13px;
            color: #29457d;
            font-size: 13px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .assignment-filter-title i {
            color: var(--assignment-primary);
        }

        .assignment-filter-form {
            display: grid;
            grid-template-columns: minmax(280px, 1fr) auto auto;
            gap: 10px;
            align-items: end;
        }

        .assignment-filter-field label {
            margin-bottom: 6px;
            color: #40537a;
            font-size: 12px;
            font-weight: 700;
            display: block;
        }

        .assignment-filter-control {
            position: relative;
        }

        .assignment-filter-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            z-index: 2;
            color: #7686a5;
            font-size: 12px;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .assignment-filter-form .form-control {
            width: 100%;
            min-height: 40px;
            padding-left: 34px;
            color: #344563;
            background: var(--assignment-white);
            border: 1px solid #ccd9ed;
            border-radius: 8px;
            font-size: 13px;
            box-shadow: none;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .assignment-filter-form .form-control::placeholder {
            color: #9ca8bd;
        }

        .assignment-filter-form .form-control:focus {
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
            color: var(--assignment-white);
            background: linear-gradient(135deg,
                    #315be8,
                    #584be8);
            border-color: #315be8;
            box-shadow: 0 4px 11px rgba(49, 91, 232, 0.2);
        }

        .btn-filter:hover {
            color: var(--assignment-white);
            background: linear-gradient(135deg,
                    #264ed4,
                    #4c40d7);
            box-shadow: 0 6px 14px rgba(49, 91, 232, 0.27);
        }

        .btn-reset {
            color: #53698f;
            background: var(--assignment-white);
            border-color: #ccd9ed;
        }

        .btn-reset:hover {
            color: #304d83;
            background: #eaf1fb;
            border-color: #b9c9e0;
        }

        /* Bảng */
        .assignment-table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--assignment-border);
            border-radius: 11px;
        }

        .assignment-table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .assignment-table-wrapper::-webkit-scrollbar-track {
            background: #f2f5fa;
        }

        .assignment-table-wrapper::-webkit-scrollbar-thumb {
            background: #c5d2e5;
            border-radius: 999px;
        }

        .assignment-table {
            width: 100%;
            min-width: 1000px;
            margin-bottom: 0;
            color: var(--assignment-text-dark);
            vertical-align: middle;
        }

        .assignment-table thead th {
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

        .assignment-table tbody td {
            padding: 14px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--assignment-border-light);
            font-size: 12px;
            line-height: 1.55;
            vertical-align: middle;
        }

        .assignment-table tbody tr:last-child td {
            border-bottom: none;
        }

        .assignment-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .assignment-table tbody tr:hover {
            background: var(--assignment-hover);
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .assignment-table th:nth-child(1),
        .assignment-table td:nth-child(1) {
            width: 80px;
            text-align: center;
        }

        .assignment-table th:nth-child(2),
        .assignment-table td:nth-child(2) {
            width: 190px;
        }

        .assignment-table th:nth-child(3),
        .assignment-table td:nth-child(3) {
            width: 220px;
        }

        .assignment-table th:nth-child(4),
        .assignment-table td:nth-child(4) {
            width: 260px;
        }

        .assignment-table th:nth-child(5),
        .assignment-table td:nth-child(5) {
            width: 160px;
            text-align: center;
        }

        .assignment-table th:nth-child(6),
        .assignment-table td:nth-child(6) {
            width: 125px;
            text-align: center;
        }

        /* ID */
        .assignment-id {
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

        /* Lịch khởi hành */
        .departure-info {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .departure-icon {
            width: 35px;
            height: 35px;
            flex-shrink: 0;
            color: #315be8;
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 9px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .departure-code {
            color: #29457d;
            font-size: 12px;
            font-weight: 750;
        }

        .departure-label {
            margin-top: 3px;
            color: #8b97aa;
            font-size: 9px;
        }

        /* Hướng dẫn viên */
        .guide-info {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .guide-avatar {
            width: 35px;
            height: 35px;
            flex-shrink: 0;
            color: var(--assignment-white);
            background: linear-gradient(135deg,
                    #315be8,
                    #5b4dea);
            border-radius: 9px;
            box-shadow: 0 4px 10px rgba(49, 91, 232, 0.17);
            font-size: 12px;
            font-weight: 750;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .guide-name {
            max-width: 155px;
            overflow: hidden;
            color: #344563;
            font-size: 12px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .guide-label {
            margin-top: 3px;
            color: #8b97aa;
            font-size: 9px;
        }

        /* Phương tiện */
        .vehicle-info {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .vehicle-icon {
            width: 35px;
            height: 35px;
            flex-shrink: 0;
            color: #315be8;
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 9px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .vehicle-plate {
            color: #29457d;
            font-size: 12px;
            font-weight: 800;
        }

        .vehicle-type {
            margin-top: 3px;
            color: #8b97aa;
            font-size: 9px;
        }

        /* Ngày phân công */
        .assignment-date {
            padding: 6px 10px;
            color: #3158ce;
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .empty-value {
            color: var(--assignment-text-light);
            font-size: 10px;
            font-style: italic;
        }

        /* Hành động */
        .assignment-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            flex-wrap: nowrap;
        }

        .assignment-actions form {
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
            color: var(--assignment-white);
            background: #3867e5;
            border-color: #3867e5;
            box-shadow: 0 5px 12px rgba(56, 103, 229, 0.25);
        }

        .btn-edit {
            color: var(--assignment-warning);
            background: var(--assignment-warning-bg);
            border-color: #f1dba9;
        }

        .btn-edit:hover {
            color: var(--assignment-white);
            background: #e39a25;
            border-color: #e39a25;
            box-shadow: 0 5px 12px rgba(227, 154, 37, 0.24);
        }

        .btn-delete {
            color: var(--assignment-danger);
            background: var(--assignment-danger-bg);
            border-color: #f0c9d1;
        }

        .btn-delete:hover {
            color: var(--assignment-white);
            background: #df5067;
            border-color: #df5067;
            box-shadow: 0 5px 12px rgba(223, 80, 103, 0.23);
        }

        /* Không có dữ liệu */
        .assignment-empty-row {
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
        .assignment-card-footer {
            padding: 16px 22px;
            background: #fafcff;
            border-top: 1px solid var(--assignment-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .assignment-result-info {
            color: var(--assignment-text-muted);
            font-size: 11px;
        }

        .assignment-card-footer .pagination {
            margin: 0;
            gap: 4px;
        }

        .assignment-card-footer .page-link {
            min-width: 34px;
            height: 34px;
            padding: 6px 10px;
            color: #3158ce;
            background: var(--assignment-white);
            border: 1px solid #d6e1f2;
            border-radius: 7px !important;
            font-size: 12px;
            box-shadow: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .assignment-card-footer .page-link:hover {
            color: var(--assignment-white);
            background: #416ce5;
            border-color: #416ce5;
        }

        .assignment-card-footer .page-item.active .page-link {
            color: var(--assignment-white);
            background: linear-gradient(135deg,
                    #315be8,
                    #584be8);
            border-color: #315be8;
        }

        .assignment-card-footer .page-item.disabled .page-link {
            color: #aab3c5;
            background: #f8f9fc;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .assignment-filter-form {
                grid-template-columns: 1fr 1fr;
            }

            .assignment-filter-field {
                grid-column: 1 / -1;
            }

            .btn-filter-action {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .assignment-page {
                padding: 14px 0;
            }

            .assignment-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .assignment-page-heading h3 {
                font-size: 20px;
            }

            .btn-add-assignment {
                width: 100%;
            }

            .assignment-card {
                border-radius: 11px;
            }

            .assignment-card-header {
                min-height: 105px;
                padding: 20px 18px;
            }

            .assignment-card-body {
                padding: 16px;
            }

            .assignment-filter-form {
                grid-template-columns: 1fr;
            }

            .assignment-filter-field {
                grid-column: auto;
            }

            .assignment-card-footer {
                align-items: stretch;
                flex-direction: column;
            }

            .assignment-result-info {
                text-align: center;
            }
        }

        @media (max-width: 520px) {
            .assignment-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .assignment-total {
                min-width: 100px;
                padding: 10px 13px;
            }
        }
    </style>

    <div class="container-fluid assignment-page fade-in">
        <div class="assignment-page-top">
            <div class="assignment-page-heading">
                <span class="assignment-page-icon">
                    <i class="fas fa-clipboard-list"></i>
                </span>

                <div>
                    <h3>Quản lý Phân công</h3>

                    <p>
                        Quản lý hướng dẫn viên và phương tiện cho các lịch khởi
                        hành.
                    </p>
                </div>
            </div>

            <a href="{{ route('Admin.phan-cong.create') }}" class="btn-add-assignment">
                <i class="fas fa-plus"></i>
                Phân công mới
            </a>
        </div>

        @if (session('error'))
            <div class="assignment-alert assignment-alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="assignment-card">
            <div class="assignment-card-header">
                <div class="assignment-card-heading">
                    <span class="assignment-card-icon">
                        <i class="fas fa-user-check"></i>
                    </span>

                    <div>
                        <h4>Danh sách phân công</h4>

                        <p>
                            Theo dõi lịch khởi hành, hướng dẫn viên và phương
                            tiện được bố trí.
                        </p>
                    </div>
                </div>

                <div class="assignment-total">
                    <strong>{{ $phanCongs->total() }}</strong>
                    <span>Phân công</span>
                </div>
            </div>

            <div class="assignment-card-body">
                <div class="assignment-filter-box">
                    <div class="assignment-filter-title">
                        <i class="fas fa-filter"></i>
                        Bộ lọc tìm kiếm
                    </div>

                    <form method="GET" action="{{ route('Admin.phan-cong.index') }}" class="assignment-filter-form">
                        <div class="assignment-filter-field">
                            <label for="keyword">
                                Tìm kiếm phân công
                            </label>

                            <div class="assignment-filter-control">
                                <i class="fas fa-search assignment-filter-icon"></i>

                                <input type="text" name="keyword" id="keyword" class="form-control"
                                    value="{{ request('keyword') }}" placeholder="Tên hướng dẫn viên hoặc biển số xe..."
                                    autocomplete="off">
                            </div>
                        </div>

                        <button type="submit" class="btn-filter-action btn-filter">
                            <i class="fas fa-search"></i>
                            Tìm kiếm
                        </button>

                        <a href="{{ route('Admin.phan-cong.index') }}" class="btn-filter-action btn-reset"
                            title="Đặt lại bộ lọc">
                            <i class="fas fa-redo-alt"></i>
                            Đặt lại
                        </a>
                    </form>
                </div>

                <div class="assignment-table-wrapper">
                    <table class="table assignment-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Lịch khởi hành</th>
                                <th>Hướng dẫn viên</th>
                                <th>Phương tiện</th>
                                <th>Ngày phân công</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($phanCongs as $phanCong)
                                @php
                                    $guideName = $phanCong->hdv->ho_ten ?? null;
                                    $vehiclePlate = $phanCong->phuongTien->bien_so_xe ?? null;
                                    $vehicleType = $phanCong->phuongTien->loai_phuong_tien ?? null;
                                @endphp

                                <tr>
                                    <td>
                                        <span class="assignment-id">
                                            #{{ $phanCong->id }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($phanCong->lichKhoiHanh)
                                            <div class="departure-info">
                                                <span class="departure-icon">
                                                    <i class="fas fa-plane-departure"></i>
                                                </span>

                                                <div>
                                                    <div class="departure-code">
                                                        <i class="fas fa-calendar-alt"></i>

                                                        {{ $phanCong->lichKhoiHanh->ngay_khoi_hanh
                                                            ? \Carbon\Carbon::parse($phanCong->lichKhoiHanh->ngay_khoi_hanh)->format('d/m/Y')
                                                            : 'Chưa có ngày' }}
                                                    </div>

                                                    <div class="departure-label">
                                                        MKH #{{ $phanCong->lichKhoiHanh->id }}
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="empty-value">
                                                Không có lịch khởi hành
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($guideName)
                                            <div class="guide-info">
                                                <span class="guide-avatar">
                                                    {{ mb_strtoupper(mb_substr($guideName, 0, 1)) }}
                                                </span>

                                                <div>
                                                    <div class="guide-name" title="{{ $guideName }}">
                                                        {{ $guideName }}
                                                    </div>

                                                    <div class="guide-label">
                                                        Hướng dẫn viên
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="empty-value">
                                                Chưa phân công HDV
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($vehiclePlate)
                                            <div class="vehicle-info">
                                                <span class="vehicle-icon">
                                                    <i class="fas fa-bus"></i>
                                                </span>

                                                <div>
                                                    <div class="vehicle-plate">
                                                        {{ $vehiclePlate }}
                                                    </div>

                                                    <div class="vehicle-type">
                                                        {{ $vehicleType ?: 'Chưa cập nhật loại xe' }}
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="empty-value">
                                                Chưa phân công phương tiện
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($phanCong->ngay_phan_cong)
                                            <span class="assignment-date">
                                                <i class="fas fa-calendar-alt"></i>

                                                {{ \Carbon\Carbon::parse($phanCong->ngay_phan_cong)->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="empty-value">
                                                Chưa có ngày
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="assignment-actions">
                                            <a href="{{ route('Admin.phan-cong.show', $phanCong->id) }}"
                                                class="btn-table-action btn-view" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('Admin.phan-cong.edit', $phanCong->id) }}"
                                                class="btn-table-action btn-edit" title="Chỉnh sửa phân công">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('Admin.phan-cong.destroy', $phanCong->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa phân công này?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn-table-action btn-delete"
                                                    title="Xóa phân công">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="assignment-empty-row">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-clipboard-list"></i>
                                        </div>

                                        <div class="empty-state-title">
                                            Chưa có dữ liệu phân công
                                        </div>

                                        <div class="empty-state-text">
                                            Không tìm thấy phân công phù hợp với
                                            điều kiện tìm kiếm.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="assignment-card-footer">
                <div class="assignment-result-info">
                    @if ($phanCongs->total() > 0)
                        Hiển thị {{ $phanCongs->firstItem() }}
                        đến {{ $phanCongs->lastItem() }}
                        trong tổng số {{ $phanCongs->total() }} phân công
                    @else
                        Không có phân công nào
                    @endif
                </div>

                {{ $phanCongs->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
