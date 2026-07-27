@extends('layouts.admin')

@section('title', 'Quản lý Bảng giá Tour')

@section('content')
    @php
        $currentUser = auth()->user();
    @endphp

    <style>
        :root {
            --tour-primary: #315be8;
            --tour-primary-dark: #244bd2;
            --tour-primary-light: #edf4ff;
            --tour-purple: #5b4dea;
            --tour-cyan: #16c7e8;

            --tour-text-dark: #172b4d;
            --tour-text-main: #344563;
            --tour-text-muted: #6b7895;
            --tour-text-light: #98a2b3;

            --tour-border: #dce6f5;
            --tour-border-light: #e8eef8;

            --tour-white: #ffffff;
            --tour-hover: #f3f7ff;

            --tour-success: #149963;
            --tour-success-light: #eaf9f1;

            --tour-warning: #c98212;
            --tour-warning-light: #fff7e8;

            --tour-danger: #dc4c64;
            --tour-danger-light: #fff0f3;

            --tour-neutral: #68758c;
            --tour-neutral-light: #f1f4f8;
        }

        .tour-management-page {
            padding: 24px 0;
            color: var(--tour-text-dark);
        }

        /* Tiêu đề trang */
        .tour-page-top {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .tour-page-heading h3 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .tour-page-heading p {
            margin: 6px 0 0;
            color: var(--tour-text-muted);
            font-size: 14px;
        }

        /* Nút thêm */
        .btn-add-tour {
            min-height: 41px;
            padding: 9px 16px;
            color: var(--tour-white);
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

        .btn-add-tour:hover {
            color: var(--tour-white);
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
        .tour-management-page .alert {
            margin-bottom: 18px;
            border: 1px solid transparent;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(16, 24, 40, 0.05);
            font-size: 13px;
            font-weight: 600;
        }

        .tour-management-page .alert-success {
            color: #087548;
            background: #eafaf2;
            border-color: #bfead3;
        }

        .tour-management-page .alert-danger {
            color: #a23449;
            background: #fff0f3;
            border-color: #f1cbd3;
        }

        /* Thống kê */
        .tour-stats-grid {
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .tour-stat-card {
            position: relative;
            min-height: 108px;
            padding: 17px;
            overflow: hidden;
            background: var(--tour-white);
            border: 1px solid var(--tour-border);
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

        .tour-stat-card::after {
            position: absolute;
            right: -26px;
            bottom: -35px;
            width: 90px;
            height: 90px;
            content: "";
            background: rgba(49, 91, 232, 0.045);
            border-radius: 50%;
        }

        .tour-stat-card:hover {
            border-color: #c4d7f6;
            box-shadow: 0 9px 24px rgba(38, 76, 148, 0.11);
            transform: translateY(-2px);
        }

        .tour-stat-icon {
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

        .stat-primary .tour-stat-icon {
            color: #315be8;
            background: #edf4ff;
            border-color: #cfe0ff;
        }

        .stat-success .tour-stat-icon {
            color: #08754a;
            background: var(--tour-success-light);
            border-color: #c5ead8;
        }

        .stat-danger .tour-stat-icon {
            color: #c13d55;
            background: var(--tour-danger-light);
            border-color: #f0c9d1;
        }

        .tour-stat-content {
            position: relative;
            z-index: 2;
            min-width: 0;
        }

        .tour-stat-value {
            color: #24417d;
            font-size: 23px;
            font-weight: 800;
            line-height: 1;
        }

        .tour-stat-label {
            margin-top: 7px;
            color: var(--tour-text-muted);
            font-size: 11px;
            font-weight: 650;
        }

        /* Card chính */
        .tour-card {
            position: relative;
            overflow: hidden;
            background: var(--tour-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
        }

        .tour-card::before {
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
        .tour-card-header {
            position: relative;
            min-height: 115px;
            padding: 24px;
            overflow: hidden;
            color: var(--tour-white);
            background: linear-gradient(120deg,
                    #2856df 0%,
                    #316cec 55%,
                    #5b49e8 100%);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .tour-card-header::before {
            position: absolute;
            right: -50px;
            bottom: -105px;
            width: 235px;
            height: 235px;
            content: "";
            border: 21px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .tour-card-header::after {
            position: absolute;
            top: -85px;
            right: 115px;
            width: 175px;
            height: 175px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .tour-header-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .tour-header-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            color: var(--tour-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            box-shadow: 0 7px 18px rgba(20, 43, 128, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .tour-header-icon i {
            font-size: 18px;
        }

        .tour-card-header h4 {
            margin: 0;
            color: var(--tour-white);
            font-size: 20px;
            font-weight: 750;
        }

        .tour-card-header p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 12px;
        }

        .tour-total {
            position: relative;
            z-index: 2;
            min-width: 108px;
            padding: 12px 15px;
            color: var(--tour-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 11px;
            text-align: center;
            backdrop-filter: blur(4px);
        }

        .tour-total strong {
            display: block;
            font-size: 22px;
            line-height: 1;
        }

        .tour-total span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.85;
        }

        .tour-card-body {
            padding: 22px;
            background: var(--tour-white);
        }

        /* Bộ lọc */
        .tour-filter-box {
            margin-bottom: 20px;
            padding: 16px;
            background: #f5f8ff;
            border: 1px solid #d8e4f6;
            border-radius: 11px;
        }

        .tour-filter-title {
            margin-bottom: 13px;
            color: #29457d;
            font-size: 13px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .tour-filter-title i {
            color: var(--tour-primary);
        }

        .tour-filter-form {
            display: grid;
            grid-template-columns:
                minmax(200px, 1fr) minmax(180px, 220px) minmax(160px, 190px) auto auto;
            gap: 10px;
            align-items: end;
        }

        .tour-filter-field label {
            margin-bottom: 6px;
            color: #40537a;
            font-size: 12px;
            font-weight: 700;
            display: block;
        }

        .tour-filter-control {
            position: relative;
        }

        .tour-filter-control .field-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            z-index: 2;
            color: #7686a5;
            font-size: 12px;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .tour-filter-form .form-control,
        .tour-filter-form .form-select {
            width: 100%;
            min-height: 40px;
            color: #344563;
            background-color: var(--tour-white);
            border: 1px solid #ccd9ed;
            border-radius: 8px;
            font-size: 13px;
            box-shadow: none;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .tour-filter-form .form-control {
            padding-left: 34px;
        }

        .tour-filter-form .form-control::placeholder {
            color: #9ca8bd;
        }

        .tour-filter-form .form-control:focus,
        .tour-filter-form .form-select:focus {
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
            color: var(--tour-white);
            background: linear-gradient(135deg,
                    #315be8,
                    #584be8);
            border-color: #315be8;
            box-shadow: 0 4px 11px rgba(49, 91, 232, 0.2);
        }

        .btn-filter:hover {
            color: var(--tour-white);
            background: linear-gradient(135deg,
                    #264ed4,
                    #4c40d7);
            box-shadow: 0 6px 14px rgba(49, 91, 232, 0.27);
        }

        .btn-reset {
            color: #53698f;
            background: var(--tour-white);
            border-color: #ccd9ed;
        }

        .btn-reset:hover {
            color: #304d83;
            background: #eaf1fb;
            border-color: #b9c9e0;
        }

        /* Bảng */
        .tour-table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--tour-border);
            border-radius: 11px;
        }

        .tour-table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .tour-table-wrapper::-webkit-scrollbar-track {
            background: #f2f5fa;
        }

        .tour-table-wrapper::-webkit-scrollbar-thumb {
            background: #c5d2e5;
            border-radius: 999px;
        }

        .tour-table {
            width: 100%;
            min-width: 1180px;
            margin-bottom: 0;
            color: var(--tour-text-dark);
            vertical-align: middle;
        }

        .tour-table thead th {
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

        .tour-table tbody td {
            padding: 13px 14px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--tour-border-light);
            font-size: 13px;
            line-height: 1.5;
            vertical-align: middle;
        }

        .tour-table tbody tr:last-child td {
            border-bottom: none;
        }

        .tour-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .tour-table tbody tr:hover {
            background: var(--tour-hover);
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        /* Alignments */
        .tour-table th:nth-child(1),
        .tour-table td:nth-child(1) {
            width: 55px;
            text-align: center;
        }

        .tour-table th:nth-child(2),
        .tour-table td:nth-child(2) {
            width: 200px;
            text-align: left;
        }

        .tour-table th:nth-child(3),
        .tour-table td:nth-child(3) {
            width: 180px;
            text-align: left;
        }

        .tour-table th:nth-child(4),
        .tour-table td:nth-child(4) {
            width: 110px;
            text-align: center;
        }

        .tour-table th:nth-child(5),
        .tour-table td:nth-child(5) {
            width: 110px;
            text-align: center;
        }

        .tour-table th:nth-child(6),
        .tour-table td:nth-child(6) {
            width: 90px;
            text-align: center;
        }

        .tour-table th:nth-child(7),
        .tour-table td:nth-child(7) {
            width: 130px;
            text-align: right;
        }

        .tour-table th:nth-child(8),
        .tour-table td:nth-child(8) {
            width: 130px;
            text-align: right;
        }

        .tour-table th:nth-child(9),
        .tour-table td:nth-child(9) {
            width: 120px;
            text-align: center;
        }

        .tour-table th:nth-child(10),
        .tour-table td:nth-child(10) {
            width: 100px;
            text-align: center;
        }

        /* Số thứ tự */
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

        /* Tên tour & Tên Bảng Giá */
        .tour-name-cell {
            min-width: 0;
        }

        .tour-name {
            max-width: 190px;
            overflow: hidden;
            color: #233f7a;
            font-size: 13px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .price-title {
            color: #2c426e;
            font-weight: 700;
        }

        .date-badge {
            padding: 4px 8px;
            color: #526385;
            background: #f1f5fc;
            border: 1px solid #d8e2f0;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 650;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .increase-badge {
            padding: 4px 8px;
            color: #117855;
            background: #e8f7f0;
            border: 1px solid #beebd5;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 750;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .tour-price {
            color: #24417d;
            font-size: 13px;
            font-weight: 800;
            white-space: nowrap;
        }

        /* Trạng thái */
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
            color: #08754a;
            background: var(--tour-success-light);
            border-color: #c5ead8;
        }

        .status-inactive {
            color: #c13d55;
            background: var(--tour-danger-light);
            border-color: #f0c9d1;
        }

        /* Hành động */
        .tour-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            flex-wrap: nowrap;
        }

        .tour-actions form {
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
            transition: all 0.16s ease;
        }

        .btn-table-action:hover {
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-edit {
            color: #b87511;
            background: var(--tour-warning-light);
            border-color: #f1dba9;
        }

        .btn-edit:hover {
            color: var(--tour-white);
            background: #e39a25;
            border-color: #e39a25;
            box-shadow: 0 5px 12px rgba(227, 154, 37, 0.24);
        }

        .btn-delete {
            color: #cb4058;
            background: var(--tour-danger-light);
            border-color: #f0c9d1;
        }

        .btn-delete:hover {
            color: var(--tour-white);
            background: #df5067;
            border-color: #df5067;
            box-shadow: 0 5px 12px rgba(223, 80, 103, 0.23);
        }

        /* Không có dữ liệu */
        .tour-empty-row {
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
        .tour-pagination {
            padding-top: 18px;
            display: flex;
            justify-content: center;
        }

        .tour-pagination .pagination {
            margin: 0;
            gap: 4px;
        }

        .tour-pagination .page-link {
            min-width: 34px;
            height: 34px;
            padding: 6px 10px;
            color: #3158ce;
            background: var(--tour-white);
            border: 1px solid #d6e1f2;
            border-radius: 7px !important;
            font-size: 12px;
            box-shadow: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tour-pagination .page-link:hover {
            color: var(--tour-white);
            background: #416ce5;
            border-color: #416ce5;
        }

        .tour-pagination .page-item.active .page-link {
            color: var(--tour-white);
            background: linear-gradient(135deg,
                    #315be8,
                    #584be8);
            border-color: #315be8;
        }

        .tour-pagination .page-item.disabled .page-link {
            color: #aab3c5;
            background: #f8f9fc;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .tour-filter-form {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .btn-filter-action {
                width: 100%;
            }
        }

        @media (max-width: 992px) {
            .tour-stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .tour-filter-form {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 768px) {
            .tour-management-page {
                padding: 14px 0;
            }

            .tour-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .tour-page-heading h3 {
                font-size: 20px;
            }

            .btn-add-tour {
                width: 100%;
            }

            .tour-card-header {
                min-height: 105px;
                padding: 20px 18px;
            }

            .tour-card-body {
                padding: 16px;
            }

            .tour-filter-form {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="container-fluid tour-management-page">
        <!-- Header -->
        <div class="tour-page-top">
            <div class="tour-page-heading">
                <h3>Quản lý Bảng giá Tour</h3>
                <p>Quản lý khung giá áp dụng theo thời điểm, tỷ lệ % tăng và đơn giá chi tiết cho từng Tour.</p>
            </div>

            @if ($currentUser && $currentUser->hasPermission('bang-gia-tours.create'))
                <a href="{{ route('Admin.bang-gia-tours.create') }}" class="btn-add-tour">
                    <i class="fas fa-plus"></i>
                    Thêm Bảng Giá
                </a>
            @else
                <a href="{{ route('Admin.bang-gia-tours.create') }}" class="btn-add-tour">
                    <i class="fas fa-plus"></i>
                    Thêm Bảng Giá
                </a>
            @endif
        </div>

        <!-- Session Alert -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Đóng"></button>
            </div>
        @endif

        <!-- Thống kê nhanh -->
        <div class="tour-stats-grid">
            <div class="tour-stat-card stat-primary">
                <span class="tour-stat-icon">
                    <i class="fas fa-tags"></i>
                </span>
                <div class="tour-stat-content">
                    <div class="tour-stat-value">
                        {{ $tongBangGia ?? ($bangGias->total() ?? 0) }}
                    </div>
                    <div class="tour-stat-label">
                        Tổng số bảng giá
                    </div>
                </div>
            </div>

            <div class="tour-stat-card stat-success">
                <span class="tour-stat-icon">
                    <i class="fas fa-check-circle"></i>
                </span>
                <div class="tour-stat-content">
                    <div class="tour-stat-value">
                        {{ $activeBangGia ?? 0 }}
                    </div>
                    <div class="tour-stat-label">
                        Đang áp dụng
                    </div>
                </div>
            </div>

            <div class="tour-stat-card stat-danger">
                <span class="tour-stat-icon">
                    <i class="fas fa-ban"></i>
                </span>
                <div class="tour-stat-content">
                    <div class="tour-stat-value">
                        {{ $inactiveBangGia ?? 0 }}
                    </div>
                    <div class="tour-stat-label">
                        Ngừng áp dụng
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="tour-card">
            <div class="tour-card-header">
                <div class="tour-header-content">
                    <span class="tour-header-icon">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </span>
                    <div>
                        <h4>Danh sách Bảng giá</h4>
                        <p>Theo dõi các khoảng thời gian điều chỉnh giá của hệ thống Tour.</p>
                    </div>
                </div>

                <div class="tour-total">
                    <strong>{{ method_exists($bangGias, 'total') ? $bangGias->total() : count($bangGias) }}</strong>
                    <span>Bảng giá</span>
                </div>
            </div>

            <div class="tour-card-body">
                <!-- Filter Box -->
                <div class="tour-filter-box">
                    <div class="tour-filter-title">
                        <i class="fas fa-filter"></i>
                        Bộ lọc tìm kiếm
                    </div>

                    <form method="GET" action="{{ route('Admin.bang-gia-tours.index') }}" class="tour-filter-form">
                        <div class="tour-filter-field">
                            <label for="keyword">Từ khóa</label>
                            <div class="tour-filter-control">
                                <i class="fas fa-search field-icon"></i>
                                <input type="text" name="keyword" id="keyword" class="form-control"
                                    value="{{ request('keyword') }}" placeholder="Nhập tên bảng giá hoặc tour..."
                                    autocomplete="off">
                            </div>
                        </div>

                        <div class="tour-filter-field">
                            <label for="trang_thai">Trạng thái</label>
                            <select name="trang_thai" id="trang_thai" class="form-select">
                                <option value="">Tất cả trạng thái</option>
                                <option value="active" @selected(request('trang_thai') === 'active')>Đang hoạt động</option>
                                <option value="inactive" @selected(request('trang_thai') === 'inactive')>Ngừng hoạt động</option>
                            </select>
                        </div>

                        <button type="submit" class="btn-filter-action btn-filter">
                            <i class="fas fa-filter"></i>
                            Lọc
                        </button>

                        <a href="{{ route('Admin.bang-gia-tours.index') }}" class="btn-filter-action btn-reset">
                            <i class="fas fa-redo-alt"></i>
                            Đặt lại
                        </a>
                    </form>
                </div>

                <!-- Table Wrapper -->
                <div class="tour-table-wrapper">
                    <table class="table tour-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tour áp dụng</th>
                                <th>Tên Bảng Giá</th>
                                <th>Từ ngày</th>
                                <th>Đến ngày</th>
                                <th>% Tăng</th>
                                <th>Giá Người Lớn</th>
                                <th>Giá Trẻ Em</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($bangGias as $item)
                                <tr>
                                    <td>
                                        <span class="tour-index">
                                            {{ method_exists($bangGias, 'currentPage')
                                                ? ($bangGias->currentPage() - 1) * $bangGias->perPage() + $loop->iteration
                                                : $loop->iteration }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="tour-name-cell">
                                            <span class="tour-name" title="{{ $item->tour->ten_tour ?? 'N/A' }}">
                                                {{ $item->tour->ten_tour ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="price-title">
                                            {{ $item->ten_bang_gia }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="date-badge">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ \Carbon\Carbon::parse($item->ngay_bat_dau)->format('d/m/Y') }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="date-badge">
                                            <i class="fas fa-calendar-check me-1"></i>
                                            {{ \Carbon\Carbon::parse($item->ngay_ket_thuc)->format('d/m/Y') }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="increase-badge">
                                            +{{ $item->phan_tram_tang }}%
                                        </span>
                                    </td>

                                    <td>
                                        <span class="tour-price">
                                            {{ number_format((float) $item->gia_nguoi_lon, 0, ',', '.') }} VNĐ
                                        </span>
                                    </td>

                                    <td>
                                        <span class="tour-price">
                                            {{ number_format((float) $item->gia_tre_em, 0, ',', '.') }} VNĐ
                                        </span>
                                    </td>

                                    <td>
                                        @if ($item->trang_thai === 'active')
                                            <span class="tour-status status-active">
                                                <span class="status-dot"></span>
                                                Hoạt động
                                            </span>
                                        @else
                                            <span class="tour-status status-inactive">
                                                <span class="status-dot"></span>
                                                Ngừng
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="tour-actions">
                                            <!-- Nút Sửa -->
                                            <a href="{{ route('Admin.bang-gia-tours.edit', $item) }}"
                                                class="btn-table-action btn-edit" title="Chỉnh sửa"
                                                data-bs-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <!-- Nút Xóa -->
                                            <form action="{{ route('Admin.bang-gia-tours.destroy', $item) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa Bảng giá này?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn-table-action btn-delete"
                                                    title="Xóa Bảng Giá" data-bs-toggle="tooltip">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="tour-empty-row">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </div>
                                        <div class="empty-state-title">
                                            Chưa có bảng giá nào
                                        </div>
                                        <div class="empty-state-text">
                                            Thay đổi bộ lọc hoặc thêm mới bảng giá tour.
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if (method_exists($bangGias, 'hasPages') && $bangGias->hasPages())
                    <div class="tour-pagination">
                        {{ $bangGias->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof bootstrap !== 'undefined') {
                document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function(element) {
                    new bootstrap.Tooltip(element);
                });
            }
        });
    </script>
@endsection
