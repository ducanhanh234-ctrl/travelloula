@extends('layouts.admin')

@section('title', 'Quản lý hướng dẫn viên')

@section('content')
    @php
        $currentUser = auth()->user();
    @endphp

    <style>
        :root {
            --guide-primary: #315be8;
            --guide-primary-dark: #244bd2;
            --guide-primary-light: #edf4ff;
            --guide-purple: #5b4dea;
            --guide-cyan: #16c7e8;

            --guide-text-dark: #172b4d;
            --guide-text-main: #344563;
            --guide-text-muted: #6b7895;
            --guide-text-light: #98a2b3;

            --guide-border: #dce6f5;
            --guide-border-light: #e8eef8;

            --guide-white: #ffffff;
            --guide-hover: #f3f7ff;

            --guide-success: #149963;
            --guide-success-light: #eaf9f1;

            --guide-info: #315be8;
            --guide-info-light: #edf4ff;

            --guide-warning: #ca8319;
            --guide-warning-light: #fff7e8;

            --guide-danger: #dc4c64;
            --guide-danger-light: #fff0f3;

            --guide-neutral: #6b7895;
            --guide-neutral-light: #f1f4f8;
        }

        .guide-management-page {
            padding: 24px 0;
            color: var(--guide-text-dark);
        }

        /* Tiêu đề trang */
        .guide-page-top {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .guide-page-heading h3 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .guide-page-heading p {
            margin: 6px 0 0;
            color: var(--guide-text-muted);
            font-size: 14px;
        }

        /* Nút thêm */
        .btn-add-guide {
            min-height: 41px;
            padding: 9px 16px;
            color: var(--guide-white);
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
            transition:
                background 0.18s ease,
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.18s ease;
        }

        .btn-add-guide:hover {
            color: var(--guide-white);
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
        .guide-management-page .alert {
            margin-bottom: 18px;
            border: 1px solid transparent;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(16, 24, 40, 0.05);
            font-size: 13px;
            font-weight: 600;
        }

        .guide-management-page .alert-success {
            color: #087548;
            background: #eafaf2;
            border-color: #bfead3;
        }

        .guide-management-page .alert-danger {
            color: #a23449;
            background: #fff0f3;
            border-color: #f1cbd3;
        }

        /* Card chính */
        .guide-card {
            position: relative;
            overflow: hidden;
            background: var(--guide-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
        }

        .guide-card::before {
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
        .guide-card-header {
            position: relative;
            min-height: 115px;
            padding: 24px;
            overflow: hidden;
            color: var(--guide-white);
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

        .guide-card-header::before {
            position: absolute;
            right: -50px;
            bottom: -105px;
            width: 235px;
            height: 235px;
            content: "";
            border: 21px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .guide-card-header::after {
            position: absolute;
            top: -85px;
            right: 115px;
            width: 175px;
            height: 175px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .guide-header-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .guide-header-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            color: var(--guide-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            box-shadow: 0 7px 18px rgba(20, 43, 128, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .guide-header-icon i {
            font-size: 18px;
        }

        .guide-card-header h4 {
            margin: 0;
            color: var(--guide-white);
            font-size: 20px;
            font-weight: 750;
        }

        .guide-card-header p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 12px;
        }

        .guide-total {
            position: relative;
            z-index: 2;
            min-width: 108px;
            padding: 12px 15px;
            color: var(--guide-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 11px;
            text-align: center;
            backdrop-filter: blur(4px);
        }

        .guide-total strong {
            display: block;
            font-size: 22px;
            line-height: 1;
        }

        .guide-total span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.85;
        }

        /* Body */
        .guide-card-body {
            padding: 22px;
            background: var(--guide-white);
        }

        /* Bộ lọc */
        .filter-box {
            margin-bottom: 20px;
            padding: 16px;
            background: #f5f8ff;
            border: 1px solid #d8e4f6;
            border-radius: 11px;
        }

        .filter-box-title {
            margin-bottom: 13px;
            color: #29457d;
            font-size: 13px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .filter-box-title i {
            color: var(--guide-primary);
        }

        .filter-form {
            display: grid;
            grid-template-columns:
                minmax(280px, 1fr)
                minmax(180px, 220px)
                minmax(170px, 210px)
                auto
                auto;
            gap: 10px;
            align-items: end;
        }

        .filter-field label {
            margin-bottom: 6px;
            color: #40537a;
            font-size: 12px;
            font-weight: 700;
            display: block;
        }

        .filter-control {
            position: relative;
        }

        .filter-control .field-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            z-index: 2;
            color: #7686a5;
            font-size: 12px;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .filter-form .form-control,
        .filter-form .form-select {
            width: 100%;
            min-height: 40px;
            color: #344563;
            background-color: var(--guide-white);
            border: 1px solid #ccd9ed;
            border-radius: 8px;
            font-size: 13px;
            box-shadow: none;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .filter-form .form-control {
            padding-left: 34px;
        }

        .filter-form .form-control::placeholder {
            color: #9ca8bd;
        }

        .filter-form .form-control:focus,
        .filter-form .form-select:focus {
            border-color: #4f78eb;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.1);
        }

        /* Nút lọc */
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
            color: var(--guide-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
            box-shadow: 0 4px 11px rgba(49, 91, 232, 0.2);
        }

        .btn-filter:hover {
            color: var(--guide-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #4c40d7
            );
            box-shadow: 0 6px 14px rgba(49, 91, 232, 0.27);
        }

        .btn-reset {
            color: #53698f;
            background: var(--guide-white);
            border-color: #ccd9ed;
        }

        .btn-reset:hover {
            color: #304d83;
            background: #eaf1fb;
            border-color: #b9c9e0;
        }

        /* Bảng */
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--guide-border);
            border-radius: 11px;
        }

        .table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .table-wrapper::-webkit-scrollbar-track {
            background: #f2f5fa;
        }

        .table-wrapper::-webkit-scrollbar-thumb {
            background: #c5d2e5;
            border-radius: 999px;
        }

        .guide-table {
            width: 100%;
            min-width: 1080px;
            margin-bottom: 0;
            color: var(--guide-text-dark);
            vertical-align: middle;
        }

        .guide-table thead th {
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

        .guide-table tbody td {
            padding: 13px 14px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--guide-border-light);
            font-size: 13px;
            line-height: 1.5;
            vertical-align: middle;
        }

        .guide-table tbody tr:last-child td {
            border-bottom: none;
        }

        .guide-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .guide-table tbody tr:hover {
            background: var(--guide-hover);
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .guide-table th:nth-child(1),
        .guide-table td:nth-child(1) {
            width: 65px;
            text-align: center;
        }

        .guide-table th:nth-child(2),
        .guide-table td:nth-child(2) {
            width: 210px;
            text-align: left;
        }

        .guide-table th:nth-child(3),
        .guide-table td:nth-child(3) {
            width: 230px;
            text-align: left;
        }

        .guide-table th:nth-child(4),
        .guide-table td:nth-child(4) {
            width: 150px;
            text-align: center;
        }

        .guide-table th:nth-child(5),
        .guide-table td:nth-child(5) {
            width: 130px;
            text-align: center;
        }

        .guide-table th:nth-child(6),
        .guide-table td:nth-child(6) {
            width: 145px;
            text-align: center;
        }

        .guide-table th:nth-child(7),
        .guide-table td:nth-child(7) {
            width: 120px;
            text-align: center;
        }

        /* ID */
        .guide-id {
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

        /* Hướng dẫn viên */
        .guide-user {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .guide-avatar {
            width: 35px;
            height: 35px;
            flex-shrink: 0;
            color: var(--guide-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #5b4dea
            );
            border-radius: 9px;
            box-shadow: 0 4px 10px rgba(49, 91, 232, 0.17);
            font-size: 13px;
            font-weight: 750;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .guide-name {
            min-width: 0;
            overflow: hidden;
            color: #233f7a;
            font-size: 13px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Email */
        .guide-email {
            max-width: 210px;
            overflow: hidden;
            color: #5c6d8c;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .guide-email i {
            margin-right: 6px;
            color: #6784cc;
            font-size: 10px;
        }

        /* Điện thoại */
        .guide-phone {
            color: #5a6c8d;
            white-space: nowrap;
        }

        .guide-phone i {
            margin-right: 5px;
            color: #6784cc;
            font-size: 10px;
        }

        /* Kinh nghiệm */
        .experience-badge {
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

        .experience-badge i {
            font-size: 9px;
        }

        .empty-value {
            color: var(--guide-text-light);
            font-size: 12px;
            font-style: italic;
        }

        /* Trạng thái */
        .status-badge {
            padding: 5px 9px;
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
            color: #08754a;
            background: var(--guide-success-light);
            border-color: #c5ead8;
        }

        .status-assigned {
            color: #2855ce;
            background: var(--guide-info-light);
            border-color: #c9dcff;
        }

        .status-inactive {
            color: #6f7d94;
            background: var(--guide-neutral-light);
            border-color: #dce2ea;
        }

        .status-locked {
            color: #b87511;
            background: var(--guide-warning-light);
            border-color: #f1dba9;
        }

        /* Nút hành động */
        .action-buttons {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            flex-wrap: nowrap;
        }

        .action-buttons form {
            display: inline-flex;
            margin: 0;
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

        .btn-view {
            color: #2d5fd7;
            background: #eaf2ff;
            border-color: #c7dafe;
        }

        .btn-view:hover {
            color: var(--guide-white);
            background: #3867e5;
            border-color: #3867e5;
            box-shadow: 0 5px 12px rgba(56, 103, 229, 0.25);
        }

        .btn-edit {
            color: #b87511;
            background: var(--guide-warning-light);
            border-color: #f1dba9;
        }

        .btn-edit:hover {
            color: var(--guide-white);
            background: #e39a25;
            border-color: #e39a25;
            box-shadow: 0 5px 12px rgba(227, 154, 37, 0.24);
        }

        .btn-delete {
            color: #cb4058;
            background: var(--guide-danger-light);
            border-color: #f0c9d1;
        }

        .btn-delete:hover {
            color: var(--guide-white);
            background: #df5067;
            border-color: #df5067;
            box-shadow: 0 5px 12px rgba(223, 80, 103, 0.23);
        }

        .btn-table-action:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.14);
        }

        /* Không có dữ liệu */
        .empty-row {
            padding: 50px 20px !important;
            color: #8793aa !important;
            text-align: center !important;
        }

        .empty-state-icon {
            width: 50px;
            height: 50px;
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

        /* Phân trang */
        .pagination-wrapper {
            padding-top: 18px;
            display: flex;
            justify-content: center;
        }

        .pagination-wrapper .pagination {
            margin: 0;
            gap: 4px;
        }

        .pagination-wrapper .page-link {
            min-width: 34px;
            height: 34px;
            padding: 6px 10px;
            color: #3158ce;
            background: var(--guide-white);
            border: 1px solid #d6e1f2;
            border-radius: 7px !important;
            font-size: 12px;
            box-shadow: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pagination-wrapper .page-link:hover {
            color: var(--guide-white);
            background: #416ce5;
            border-color: #416ce5;
        }

        .pagination-wrapper .page-item.active .page-link {
            color: var(--guide-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
        }

        .pagination-wrapper .page-item.disabled .page-link {
            color: #aab3c5;
            background: #f8f9fc;
        }

        /* Responsive */
        @media (max-width: 1100px) {
            .filter-form {
                grid-template-columns: 1fr 1fr 1fr;
            }

            .btn-filter-action {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .guide-management-page {
                padding: 14px 0;
            }

            .guide-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .guide-page-heading h3 {
                font-size: 20px;
            }

            .btn-add-guide {
                width: 100%;
            }

            .guide-card {
                border-radius: 11px;
            }

            .guide-card-header {
                min-height: 105px;
                padding: 20px 18px;
            }

            .guide-card-body {
                padding: 16px;
            }

            .filter-box {
                padding: 14px;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .guide-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .guide-total {
                min-width: 100px;
                padding: 10px 13px;
            }
        }
    </style>

    <div class="container-fluid guide-management-page">
        <div class="guide-page-top">
            <div class="guide-page-heading">
                <h3>Quản lý hướng dẫn viên</h3>

                <p>
                    Tìm kiếm, theo dõi trạng thái và quản lý hồ sơ hướng dẫn viên.
                </p>
            </div>

            @if (
                $currentUser
                && $currentUser->hasPermission('guides.create')
            )
                <a
                    href="{{ route('Admin.huong-dan-viens.create') }}"
                    class="btn-add-guide"
                >
                    <i class="fas fa-plus"></i>
                    Thêm hướng dẫn viên
                </a>
            @endif
        </div>

        @if (session('success'))
            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >
                <i class="fas fa-circle-check me-2"></i>

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Đóng"
                ></button>
            </div>
        @endif

        @if (session('error'))
            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert"
            >
                <i class="fas fa-circle-exclamation me-2"></i>

                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Đóng"
                ></button>
            </div>
        @endif

        <div class="guide-card">
            <div class="guide-card-header">
                <div class="guide-header-content">
                    <span class="guide-header-icon">
                        <i class="fas fa-person-walking-luggage"></i>
                    </span>

                    <div>
                        <h4>Danh sách hướng dẫn viên</h4>

                        <p>
                            Quản lý thông tin, kinh nghiệm và trạng thái làm việc.
                        </p>
                    </div>
                </div>

                <div class="guide-total">
                    <strong>{{ $guides->total() }}</strong>
                    <span>Hướng dẫn viên</span>
                </div>
            </div>

            <div class="guide-card-body">
                <div class="filter-box">
                    <div class="filter-box-title">
                        <i class="fas fa-filter"></i>
                        Bộ lọc hướng dẫn viên
                    </div>

                    <form
                        method="GET"
                        action="{{ route('Admin.huong-dan-viens.index') }}"
                        class="filter-form"
                    >
                        <div class="filter-field">
                            <label for="keyword">Tìm kiếm</label>

                            <div class="filter-control">
                                <i class="fas fa-search field-icon"></i>

                                <input
                                    type="text"
                                    id="keyword"
                                    name="keyword"
                                    class="form-control"
                                    value="{{ request('keyword') }}"
                                    placeholder="Họ tên, email, điện thoại hoặc CCCD..."
                                    autocomplete="off"
                                >
                            </div>
                        </div>

                        <div class="filter-field">
                            <label for="trang_thai">Trạng thái</label>

                            <select
                                name="trang_thai"
                                id="trang_thai"
                                class="form-select"
                            >
                                <option value="">Tất cả trạng thái</option>

                                <option
                                    value="hoat_dong"
                                    @selected(request('trang_thai') === 'hoat_dong')
                                >
                                    Hoạt động
                                </option>

                                <option
                                    value="san_sang"
                                    @selected(request('trang_thai') === 'san_sang')
                                >
                                    Sẵn sàng
                                </option>

                                <option
                                    value="dang_dan_tour"
                                    @selected(request('trang_thai') === 'dang_dan_tour')
                                >
                                    Đang dẫn tour
                                </option>

                                <option
                                    value="khong_hoat_dong"
                                    @selected(request('trang_thai') === 'khong_hoat_dong')
                                >
                                    Không hoạt động
                                </option>

                                <option
                                    value="bi_khoa"
                                    @selected(request('trang_thai') === 'bi_khoa')
                                >
                                    Bị khóa
                                </option>

                                <option
                                    value="nghi_viec"
                                    @selected(request('trang_thai') === 'nghi_viec')
                                >
                                    Nghỉ việc
                                </option>
                            </select>
                        </div>

                        <div class="filter-field">
                            <label for="kinh_nghiem">Kinh nghiệm</label>

                            <select
                                name="kinh_nghiem"
                                id="kinh_nghiem"
                                class="form-select"
                            >
                                <option value="">Tất cả kinh nghiệm</option>

                                <option
                                    value="0_1"
                                    @selected(request('kinh_nghiem') === '0_1')
                                >
                                    0 - 1 năm
                                </option>

                                <option
                                    value="2_5"
                                    @selected(request('kinh_nghiem') === '2_5')
                                >
                                    2 - 5 năm
                                </option>

                                <option
                                    value="6_plus"
                                    @selected(request('kinh_nghiem') === '6_plus')
                                >
                                    Từ 6 năm
                                </option>
                            </select>
                        </div>

                        <button
                            type="submit"
                            class="btn-filter-action btn-filter"
                        >
                            <i class="fas fa-filter"></i>
                            Lọc
                        </button>

                        <a
                            href="{{ route('Admin.huong-dan-viens.index') }}"
                            class="btn-filter-action btn-reset"
                        >
                            <i class="fas fa-rotate-left"></i>
                            Đặt lại
                        </a>
                    </form>
                </div>

                <div class="table-wrapper">
                    <table class="table guide-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Hướng dẫn viên</th>
                                <th>Email</th>
                                <th>Điện thoại</th>
                                <th>Kinh nghiệm</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($guides as $guide)
                                @php
                                    $statusClass = match ($guide->trang_thai) {
                                        'hoat_dong',
                                        'san_sang' => 'status-active',

                                        'dang_dan_tour' => 'status-assigned',

                                        'bi_khoa',
                                        'nghi_viec' => 'status-locked',

                                        default => 'status-inactive',
                                    };

                                    $statusLabel = match ($guide->trang_thai) {
                                        'hoat_dong' => 'Hoạt động',
                                        'san_sang' => 'Sẵn sàng',
                                        'dang_dan_tour' => 'Đang dẫn tour',
                                        'khong_hoat_dong' => 'Không hoạt động',
                                        'bi_khoa' => 'Bị khóa',
                                        'nghi_viec' => 'Nghỉ việc',
                                        default => 'Không xác định',
                                    };
                                @endphp

                                <tr>
                                    <td>
                                        <span class="guide-id">
                                            {{ $guide->id }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="guide-user">
                                            <span class="guide-avatar">
                                                {{ mb_strtoupper(
                                                    mb_substr(
                                                        $guide->ho_ten ?? '?',
                                                        0,
                                                        1
                                                    )
                                                ) }}
                                            </span>

                                            <span
                                                class="guide-name"
                                                title="{{ $guide->ho_ten }}"
                                            >
                                                {{ $guide->ho_ten }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        @if ($guide->email)
                                            <span
                                                class="guide-email"
                                                title="{{ $guide->email }}"
                                            >
                                                <i class="fas fa-envelope"></i>
                                                {{ $guide->email }}
                                            </span>
                                        @else
                                            <span class="empty-value">
                                                Chưa cập nhật
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($guide->so_dien_thoai)
                                            <span class="guide-phone">
                                                <i class="fas fa-phone"></i>
                                                {{ $guide->so_dien_thoai }}
                                            </span>
                                        @else
                                            <span class="empty-value">
                                                Chưa cập nhật
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($guide->so_nam_kinh_nghiem !== null)
                                            <span class="experience-badge">
                                                <i class="fas fa-briefcase"></i>

                                                {{ $guide->so_nam_kinh_nghiem }}
                                                năm
                                            </span>
                                        @else
                                            <span class="empty-value">
                                                Chưa cập nhật
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <span class="status-badge {{ $statusClass }}">
                                            <span class="status-dot"></span>
                                            {{ $statusLabel }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="action-buttons">
                                            @if (
                                                $currentUser
                                                && $currentUser->hasPermission('guides.view')
                                            )
                                                <a
                                                    href="{{ route('Admin.huong-dan-viens.show', $guide) }}"
                                                    class="btn-table-action btn-view"
                                                    title="Xem chi tiết"
                                                    data-bs-toggle="tooltip"
                                                >
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif

                                            @if (
                                                $currentUser
                                                && $currentUser->hasPermission('guides.edit')
                                            )
                                                <a
                                                    href="{{ route('Admin.huong-dan-viens.edit', $guide) }}"
                                                    class="btn-table-action btn-edit"
                                                    title="Chỉnh sửa"
                                                    data-bs-toggle="tooltip"
                                                >
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            @endif

                                            @if (
                                                $currentUser
                                                && $currentUser->hasPermission('guides.delete')
                                            )
                                                <form
                                                    action="{{ route('Admin.huong-dan-viens.destroy', $guide) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa hướng dẫn viên này?');"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn-table-action btn-delete"
                                                        title="Xóa hướng dẫn viên"
                                                        data-bs-toggle="tooltip"
                                                    >
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="empty-row">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-user-slash"></i>
                                        </div>

                                        <div class="empty-state-title">
                                            Không tìm thấy hướng dẫn viên
                                        </div>

                                        <div class="empty-state-text">
                                            Hãy thay đổi từ khóa hoặc điều kiện lọc.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($guides->hasPages())
                    <div class="pagination-wrapper">
                        {{ $guides->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>
                @endif
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
