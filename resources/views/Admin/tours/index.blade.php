@extends('layouts.admin')

@section('title', 'Quản lý Tour')

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

        .btn-add-tour:hover {
            color: var(--tour-white);
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
            grid-template-columns: repeat(4, minmax(0, 1fr));
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

        .stat-warning .tour-stat-icon {
            color: #ae6c0d;
            background: var(--tour-warning-light);
            border-color: #f1dba9;
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
            background: linear-gradient(
                90deg,
                #2458e7,
                #3478ef,
                #18c7e7,
                #5947e9
            );
        }

        /* Header card */
        .tour-card-header {
            position: relative;
            min-height: 115px;
            padding: 24px;
            overflow: hidden;
            color: var(--tour-white);
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
                minmax(230px, 1fr)
                minmax(180px, 230px)
                minmax(170px, 210px)
                minmax(160px, 190px)
                auto
                auto;
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
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
            box-shadow: 0 4px 11px rgba(49, 91, 232, 0.2);
        }

        .btn-filter:hover {
            color: var(--tour-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #4c40d7
            );
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

        .tour-table th:nth-child(1),
        .tour-table td:nth-child(1) {
            width: 65px;
            text-align: center;
        }

        .tour-table th:nth-child(2),
        .tour-table td:nth-child(2) {
            width: 125px;
            text-align: center;
        }

        .tour-table th:nth-child(3),
        .tour-table td:nth-child(3) {
            width: 260px;
            text-align: left;
        }

        .tour-table th:nth-child(4),
        .tour-table td:nth-child(4) {
            width: 155px;
            text-align: right;
        }

        .tour-table th:nth-child(5),
        .tour-table td:nth-child(5) {
            width: 175px;
            text-align: center;
        }

        .tour-table th:nth-child(6),
        .tour-table td:nth-child(6) {
            width: 130px;
            text-align: center;
        }

        .tour-table th:nth-child(7),
        .tour-table td:nth-child(7) {
            width: 155px;
            text-align: center;
        }

        .tour-table th:nth-child(8),
        .tour-table td:nth-child(8) {
            width: 120px;
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

        /* Ảnh */
        .tour-image-box {
            width: 92px;
            height: 62px;
            margin: 0 auto;
            overflow: hidden;
            background: #f4f7fc;
            border: 1px solid #dce6f5;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .tour-image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.22s ease;
        }

        .tour-image-box:hover img {
            transform: scale(1.06);
        }

        .tour-image-empty {
            color: #8795ad;
            font-size: 10px;
            text-align: center;
        }

        .tour-image-empty i {
            margin-bottom: 4px;
            font-size: 18px;
            display: block;
        }

        /* Tên tour */
        .tour-name-cell {
            min-width: 0;
        }

        .tour-name {
            max-width: 235px;
            overflow: hidden;
            color: #233f7a;
            font-size: 13px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .tour-code {
            margin-top: 4px;
            color: #8b97aa;
            font-size: 10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Giá */
        .tour-price {
            color: #24417d;
            font-size: 13px;
            font-weight: 800;
            white-space: nowrap;
        }

        /* Danh mục */
        .category-badge {
            max-width: 145px;
            padding: 5px 9px;
            overflow: hidden;
            color: #3158ce;
            background: #edf4ff;
            border: 1px solid #cfe0ff;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .category-badge i {
            font-size: 8px;
        }

        .category-empty {
            color: var(--tour-text-light);
            font-size: 11px;
            font-style: italic;
        }

        /* Thời lượng */
        .duration-badge {
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

        .duration-badge i {
            color: #6b83c3;
            font-size: 8px;
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
            color: var(--tour-white);
            background: #3867e5;
            border-color: #3867e5;
            box-shadow: 0 5px 12px rgba(56, 103, 229, 0.25);
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

        .btn-table-action:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.14);
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
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
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

            .tour-card {
                border-radius: 11px;
            }

            .tour-card-header {
                min-height: 105px;
                padding: 20px 18px;
            }

            .tour-card-body {
                padding: 16px;
            }

            .tour-filter-box {
                padding: 14px;
            }

            .tour-filter-form {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 520px) {
            .tour-stats-grid {
                grid-template-columns: 1fr;
            }

            .tour-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .tour-total {
                min-width: 100px;
                padding: 10px 13px;
            }
        }
    </style>

    <div class="container-fluid tour-management-page">
        <div class="tour-page-top">
            <div class="tour-page-heading">
                <h3>Quản lý Tour</h3>

                <p>
                    Quản lý danh sách, giá bán, danh mục và trạng thái các tour
                    du lịch trong hệ thống.
                </p>
            </div>

            @if (
                $currentUser
                && $currentUser->hasPermission('tours.create')
            )
                <a
                    href="{{ route('Admin.tours.create') }}"
                    class="btn-add-tour"
                >
                    <i class="fas fa-plus"></i>
                    Thêm Tour
                </a>
            @endif
        </div>

        @if (session('success'))
            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >
                <i class="fas fa-check-circle me-2"></i>

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
                <i class="fas fa-exclamation-circle me-2"></i>

                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Đóng"
                ></button>
            </div>
        @endif

        <div class="tour-stats-grid">
            <div class="tour-stat-card stat-primary">
                <span class="tour-stat-icon">
                    <i class="fas fa-route"></i>
                </span>

                <div class="tour-stat-content">
                    <div class="tour-stat-value">
                        {{ $tongTour ?? 0 }}
                    </div>

                    <div class="tour-stat-label">
                        Tổng số Tour
                    </div>
                </div>
            </div>

            <div class="tour-stat-card stat-success">
                <span class="tour-stat-icon">
                    <i class="fas fa-check-circle"></i>
                </span>

                <div class="tour-stat-content">
                    <div class="tour-stat-value">
                        {{ $activeTour ?? 0 }}
                    </div>

                    <div class="tour-stat-label">
                        Đang hoạt động
                    </div>
                </div>
            </div>

            <div class="tour-stat-card stat-danger">
                <span class="tour-stat-icon">
                    <i class="fas fa-ban"></i>
                </span>

                <div class="tour-stat-content">
                    <div class="tour-stat-value">
                        {{ $inactiveTour ?? 0 }}
                    </div>

                    <div class="tour-stat-label">
                        Ngừng hoạt động
                    </div>
                </div>
            </div>

            <div class="tour-stat-card stat-warning">
                <span class="tour-stat-icon">
                    <i class="fas fa-list"></i>
                </span>

                <div class="tour-stat-content">
                    <div class="tour-stat-value">
                        {{ $tongDanhMuc ?? 0 }}
                    </div>

                    <div class="tour-stat-label">
                        Danh mục Tour
                    </div>
                </div>
            </div>
        </div>

        <div class="tour-card">
            <div class="tour-card-header">
                <div class="tour-header-content">
                    <span class="tour-header-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </span>

                    <div>
                        <h4>Danh sách Tour</h4>

                        <p>
                            Theo dõi thông tin, giá bán và trạng thái hoạt động.
                        </p>
                    </div>
                </div>

                <div class="tour-total">
                    <strong>{{ $tours->total() }}</strong>
                    <span>Tour du lịch</span>
                </div>
            </div>

            <div class="tour-card-body">
                <div class="tour-filter-box">
                    <div class="tour-filter-title">
                        <i class="fas fa-filter"></i>
                        Bộ lọc tìm kiếm
                    </div>

                    <form
                        method="GET"
                        action="{{ route('Admin.tours.index') }}"
                        class="tour-filter-form"
                    >
                        <div class="tour-filter-field">
                            <label for="keyword">Tên Tour</label>

                            <div class="tour-filter-control">
                                <i class="fas fa-search field-icon"></i>

                                <input
                                    type="text"
                                    name="keyword"
                                    id="keyword"
                                    class="form-control"
                                    value="{{ request('keyword') }}"
                                    placeholder="Nhập tên Tour..."
                                    autocomplete="off"
                                >
                            </div>
                        </div>

                        <div class="tour-filter-field">
                            <label for="danh_muc_id">Danh mục</label>

                            <select
                                name="danh_muc_id"
                                id="danh_muc_id"
                                class="form-select"
                            >
                                <option value="">
                                    Tất cả danh mục
                                </option>

                                @foreach ($danhMucs as $item)
                                    <option
                                        value="{{ $item->id }}"
                                        @selected(
                                            (string) request('danh_muc_id')
                                            === (string) $item->id
                                        )
                                    >
                                        {{ $item->ten_danh_muc }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="tour-filter-field">
                            <label for="trang_thai">Trạng thái</label>

                            <select
                                name="trang_thai"
                                id="trang_thai"
                                class="form-select"
                            >
                                <option value="">
                                    Tất cả trạng thái
                                </option>

                                <option
                                    value="active"
                                    @selected(request('trang_thai') === 'active')
                                >
                                    Đang hoạt động
                                </option>

                                <option
                                    value="inactive"
                                    @selected(request('trang_thai') === 'inactive')
                                >
                                    Ngừng hoạt động
                                </option>
                            </select>
                        </div>

                        <div class="tour-filter-field">
                            <label for="sort_price">Sắp xếp giá</label>

                            <select
                                name="sort_price"
                                id="sort_price"
                                class="form-select"
                            >
                                <option value="">
                                    Mặc định
                                </option>

                                <option
                                    value="asc"
                                    @selected(request('sort_price') === 'asc')
                                >
                                    Giá tăng dần
                                </option>

                                <option
                                    value="desc"
                                    @selected(request('sort_price') === 'desc')
                                >
                                    Giá giảm dần
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
                            href="{{ route('Admin.tours.index') }}"
                            class="btn-filter-action btn-reset"
                        >
                            <i class="fas fa-redo-alt"></i>
                            Đặt lại
                        </a>
                    </form>
                </div>

                <div class="tour-table-wrapper">
                    <table class="table tour-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ảnh</th>
                                <th>Tên Tour</th>
                                <th>Giá Tour</th>
                                <th>Danh mục</th>
                                <th>Thời lượng</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($tours as $tour)
                                <tr>
                                    <td>
                                        <span class="tour-index">
                                            {{ ($tours->currentPage() - 1)
                                                * $tours->perPage()
                                                + $loop->iteration }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="tour-image-box">
                                            @if ($tour->anh_dai_dien)
                                                <img
                                                    src="{{ asset('storage/' . $tour->anh_dai_dien) }}"
                                                    alt="{{ $tour->ten_tour }}"
                                                    loading="lazy"
                                                >
                                            @else
                                                <span class="tour-image-empty">
                                                    <i class="fas fa-image"></i>
                                                    Chưa có ảnh
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        <div class="tour-name-cell">
                                            <span
                                                class="tour-name"
                                                title="{{ $tour->ten_tour }}"
                                            >
                                                {{ $tour->ten_tour }}
                                            </span>

                                            <span class="tour-code">
                                                <i class="fas fa-hashtag"></i>
                                                Tour {{ $tour->id }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="tour-price">
                                            {{ number_format(
                                                (float) $tour->gia_tour,
                                                0,
                                                ',',
                                                '.'
                                            ) }}
                                            VNĐ
                                        </span>
                                    </td>

                                    <td>
                                        @if ($tour->danhMuc)
                                            <span
                                                class="category-badge"
                                                title="{{ $tour->danhMuc->ten_danh_muc }}"
                                            >
                                                <i class="fas fa-tag"></i>

                                                {{ $tour->danhMuc->ten_danh_muc }}
                                            </span>
                                        @else
                                            <span class="category-empty">
                                                Chưa có danh mục
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($tour->thoi_luong)
                                            <span class="duration-badge">
                                                <i class="fas fa-clock"></i>
                                                {{ $tour->thoi_luong }}
                                            </span>
                                        @else
                                            <span class="category-empty">
                                                Chưa cập nhật
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($tour->trang_thai === 'active')
                                            <span class="tour-status status-active">
                                                <span class="status-dot"></span>
                                                Đang hoạt động
                                            </span>
                                        @else
                                            <span class="tour-status status-inactive">
                                                <span class="status-dot"></span>
                                                Ngừng hoạt động
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="tour-actions">
                                            @if (
                                                $currentUser
                                                && $currentUser->hasPermission('tours.view')
                                            )
                                                <a
                                                    href="{{ route('Admin.tours.show', $tour) }}"
                                                    class="btn-table-action btn-view"
                                                    title="Xem chi tiết"
                                                    data-bs-toggle="tooltip"
                                                >
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif

                                            @if (
                                                $currentUser
                                                && $currentUser->hasPermission('tours.edit')
                                            )
                                                <a
                                                    href="{{ route('Admin.tours.edit', $tour) }}"
                                                    class="btn-table-action btn-edit"
                                                    title="Chỉnh sửa"
                                                    data-bs-toggle="tooltip"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif

                                            @if (
                                                $currentUser
                                                && $currentUser->hasPermission('tours.delete')
                                            )
                                                <form
                                                    action="{{ route('Admin.tours.destroy', $tour) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa Tour này?');"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn-table-action btn-delete"
                                                        title="Xóa Tour"
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
                                    <td
                                        colspan="8"
                                        class="tour-empty-row"
                                    >
                                        <div class="empty-state-icon">
                                            <i class="fas fa-route"></i>
                                        </div>

                                        <div class="empty-state-title">
                                            Không tìm thấy Tour phù hợp
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

                @if ($tours->hasPages())
                    <div class="tour-pagination">
                        {{ $tours
                            ->appends(request()->query())
                            ->links('pagination::bootstrap-5') }}
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
