@extends('layouts.admin')

@section('title', 'Quản lý khách hàng')

@section('content')
    @php
        $currentUser = auth()->user();
    @endphp

    <style>
        :root {
            --customer-primary: #315be8;
            --customer-primary-dark: #244bd2;
            --customer-primary-light: #edf4ff;
            --customer-purple: #5b4dea;
            --customer-cyan: #16c7e8;

            --customer-text-dark: #172b4d;
            --customer-text-main: #344563;
            --customer-text-muted: #6b7895;
            --customer-text-light: #98a2b3;

            --customer-border: #dce6f5;
            --customer-border-light: #e8eef8;

            --customer-white: #ffffff;
            --customer-hover: #f3f7ff;

            --customer-success: #149963;
            --customer-success-light: #eaf9f1;

            --customer-warning: #c98212;
            --customer-warning-light: #fff7e8;

            --customer-danger: #dc4c64;
            --customer-danger-light: #fff0f3;

            --customer-neutral: #69758b;
            --customer-neutral-light: #f1f4f8;
        }

        .customer-management-page {
            padding: 24px 0;
            color: var(--customer-text-dark);
        }

        /* Tiêu đề trang */
        .customer-page-top {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .customer-page-heading h3 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .customer-page-heading p {
            margin: 6px 0 0;
            color: var(--customer-text-muted);
            font-size: 14px;
        }

        /* Nút thêm khách hàng */
        .btn-add-customer {
            min-height: 41px;
            padding: 9px 16px;
            color: var(--customer-white);
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

        .btn-add-customer:hover {
            color: var(--customer-white);
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
        .customer-management-page .alert {
            margin-bottom: 18px;
            border: 1px solid transparent;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(16, 24, 40, 0.05);
            font-size: 13px;
            font-weight: 600;
        }

        .customer-management-page .alert-success {
            color: #087548;
            background: #eafaf2;
            border-color: #bfead3;
        }

        .customer-management-page .alert-danger {
            color: #a23449;
            background: #fff0f3;
            border-color: #f1cbd3;
        }

        /* Card chính */
        .customer-card {
            position: relative;
            overflow: hidden;
            background: var(--customer-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
        }

        .customer-card::before {
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
        .customer-card-header {
            position: relative;
            min-height: 115px;
            padding: 24px;
            overflow: hidden;
            color: var(--customer-white);
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

        .customer-card-header::before {
            position: absolute;
            right: -50px;
            bottom: -105px;
            width: 235px;
            height: 235px;
            content: "";
            border: 21px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .customer-card-header::after {
            position: absolute;
            top: -85px;
            right: 115px;
            width: 175px;
            height: 175px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .customer-header-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .customer-header-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            color: var(--customer-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            box-shadow: 0 7px 18px rgba(20, 43, 128, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .customer-header-icon i {
            font-size: 18px;
        }

        .customer-card-header h4 {
            margin: 0;
            color: var(--customer-white);
            font-size: 20px;
            font-weight: 750;
        }

        .customer-card-header p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 12px;
        }

        .customer-total {
            position: relative;
            z-index: 2;
            min-width: 108px;
            padding: 12px 15px;
            color: var(--customer-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 11px;
            text-align: center;
            backdrop-filter: blur(4px);
        }

        .customer-total strong {
            display: block;
            font-size: 22px;
            line-height: 1;
        }

        .customer-total span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.85;
        }

        /* Body */
        .customer-card-body {
            padding: 22px;
            background: var(--customer-white);
        }

        /* Bộ lọc */
        .customer-filter-box {
            margin-bottom: 20px;
            padding: 16px;
            background: #f5f8ff;
            border: 1px solid #d8e4f6;
            border-radius: 11px;
        }

        .customer-filter-title {
            margin-bottom: 13px;
            color: #29457d;
            font-size: 13px;
            font-weight: 750;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .customer-filter-title i {
            color: var(--customer-primary);
        }

        .customer-filter-form {
            display: grid;
            grid-template-columns:
                minmax(280px, 1fr)
                minmax(190px, 240px)
                auto
                auto;
            gap: 10px;
            align-items: end;
        }

        .customer-filter-field label {
            margin-bottom: 6px;
            color: #40537a;
            font-size: 12px;
            font-weight: 700;
            display: block;
        }

        .customer-filter-control {
            position: relative;
        }

        .customer-filter-control .field-icon {
            position: absolute;
            top: 50%;
            left: 12px;
            z-index: 2;
            color: #7686a5;
            font-size: 12px;
            pointer-events: none;
            transform: translateY(-50%);
        }

        .customer-filter-form .form-control,
        .customer-filter-form .form-select {
            width: 100%;
            min-height: 40px;
            color: #344563;
            background-color: var(--customer-white);
            border: 1px solid #ccd9ed;
            border-radius: 8px;
            font-size: 13px;
            box-shadow: none;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .customer-filter-form .form-control {
            padding-left: 34px;
        }

        .customer-filter-form .form-control::placeholder {
            color: #9ca8bd;
        }

        .customer-filter-form .form-control:focus,
        .customer-filter-form .form-select:focus {
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
            color: var(--customer-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
            box-shadow: 0 4px 11px rgba(49, 91, 232, 0.2);
        }

        .btn-filter:hover {
            color: var(--customer-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #4c40d7
            );
            box-shadow: 0 6px 14px rgba(49, 91, 232, 0.27);
        }

        .btn-reset {
            color: #53698f;
            background: var(--customer-white);
            border-color: #ccd9ed;
        }

        .btn-reset:hover {
            color: #304d83;
            background: #eaf1fb;
            border-color: #b9c9e0;
        }

        /* Bảng */
        .customer-table-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--customer-border);
            border-radius: 11px;
        }

        .customer-table-wrapper::-webkit-scrollbar {
            height: 8px;
        }

        .customer-table-wrapper::-webkit-scrollbar-track {
            background: #f2f5fa;
        }

        .customer-table-wrapper::-webkit-scrollbar-thumb {
            background: #c5d2e5;
            border-radius: 999px;
        }

        .customer-table {
            width: 100%;
            min-width: 1050px;
            margin-bottom: 0;
            color: var(--customer-text-dark);
            vertical-align: middle;
        }

        .customer-table thead th {
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

        .customer-table tbody td {
            padding: 13px 14px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--customer-border-light);
            font-size: 13px;
            line-height: 1.5;
            vertical-align: middle;
        }

        .customer-table tbody tr:last-child td {
            border-bottom: none;
        }

        .customer-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .customer-table tbody tr:hover {
            background: var(--customer-hover);
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .customer-table th:nth-child(1),
        .customer-table td:nth-child(1) {
            width: 220px;
            text-align: left;
        }

        .customer-table th:nth-child(2),
        .customer-table td:nth-child(2) {
            width: 260px;
            text-align: left;
        }

        .customer-table th:nth-child(3),
        .customer-table td:nth-child(3) {
            width: 125px;
            text-align: center;
        }

        .customer-table th:nth-child(4),
        .customer-table td:nth-child(4) {
            width: 165px;
            text-align: center;
        }

        .customer-table th:nth-child(5),
        .customer-table td:nth-child(5) {
            width: 200px;
            text-align: center;
        }

        .customer-table th:nth-child(6),
        .customer-table td:nth-child(6) {
            width: 120px;
            text-align: center;
        }

        /* Thông tin khách hàng */
        .customer-user {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .customer-avatar {
            width: 36px;
            height: 36px;
            flex-shrink: 0;
            color: var(--customer-white);
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

        .customer-name-content {
            min-width: 0;
        }

        .customer-name {
            max-width: 170px;
            overflow: hidden;
            color: #233f7a;
            font-size: 13px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .customer-id {
            margin-top: 2px;
            color: #8b97aa;
            font-size: 10px;
            display: block;
        }

        /* Liên hệ */
        .contact-list {
            min-width: 0;
        }

        .contact-item {
            max-width: 230px;
            overflow: hidden;
            color: #5c6d8c;
            font-size: 12px;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .contact-item + .contact-item {
            margin-top: 5px;
        }

        .contact-item i {
            width: 13px;
            flex-shrink: 0;
            color: #6784cc;
            font-size: 10px;
            text-align: center;
        }

        .empty-value {
            color: var(--customer-text-light);
            font-size: 12px;
            font-style: italic;
        }

        /* Số lần đặt */
        .booking-count {
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
            justify-content: center;
            gap: 5px;
        }

        .booking-count i {
            font-size: 9px;
        }

        /* Trạng thái */
        .customer-status {
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

        .status-new {
            color: #66738b;
            background: var(--customer-neutral-light);
            border-color: #dce2ea;
        }

        .status-active {
            color: #08754a;
            background: var(--customer-success-light);
            border-color: #c5ead8;
        }

        .status-vip {
            color: #ae6c0d;
            background: var(--customer-warning-light);
            border-color: #f1dba9;
        }

        /* Ngày tham gia */
        .joined-date {
            color: #455a80;
            font-size: 12px;
            font-weight: 700;
        }

        .joined-relative {
            margin-top: 3px;
            color: #8b97aa;
            font-size: 10px;
        }

        /* Nút hành động */
        .customer-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            flex-wrap: nowrap;
        }

        .customer-actions form {
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
            color: var(--customer-white);
            background: #3867e5;
            border-color: #3867e5;
            box-shadow: 0 5px 12px rgba(56, 103, 229, 0.25);
        }

        .btn-edit {
            color: #b87511;
            background: var(--customer-warning-light);
            border-color: #f1dba9;
        }

        .btn-edit:hover {
            color: var(--customer-white);
            background: #e39a25;
            border-color: #e39a25;
            box-shadow: 0 5px 12px rgba(227, 154, 37, 0.24);
        }

        .btn-delete {
            color: #cb4058;
            background: var(--customer-danger-light);
            border-color: #f0c9d1;
        }

        .btn-delete:hover {
            color: var(--customer-white);
            background: #df5067;
            border-color: #df5067;
            box-shadow: 0 5px 12px rgba(223, 80, 103, 0.23);
        }

        .btn-table-action:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.14);
        }

        /* Không có dữ liệu */
        .customer-empty-row {
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
        .customer-pagination {
            padding-top: 18px;
            display: flex;
            justify-content: center;
        }

        .customer-pagination .pagination {
            margin: 0;
            gap: 4px;
        }

        .customer-pagination .page-link {
            min-width: 34px;
            height: 34px;
            padding: 6px 10px;
            color: #3158ce;
            background: var(--customer-white);
            border: 1px solid #d6e1f2;
            border-radius: 7px !important;
            font-size: 12px;
            box-shadow: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .customer-pagination .page-link:hover {
            color: var(--customer-white);
            background: #416ce5;
            border-color: #416ce5;
        }

        .customer-pagination .page-item.active .page-link {
            color: var(--customer-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
        }

        .customer-pagination .page-item.disabled .page-link {
            color: #aab3c5;
            background: #f8f9fc;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .customer-filter-form {
                grid-template-columns: 1fr 1fr;
            }

            .btn-filter-action {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .customer-management-page {
                padding: 14px 0;
            }

            .customer-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .customer-page-heading h3 {
                font-size: 20px;
            }

            .btn-add-customer {
                width: 100%;
            }

            .customer-card {
                border-radius: 11px;
            }

            .customer-card-header {
                min-height: 105px;
                padding: 20px 18px;
            }

            .customer-card-body {
                padding: 16px;
            }

            .customer-filter-box {
                padding: 14px;
            }

            .customer-filter-form {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .customer-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .customer-total {
                min-width: 100px;
                padding: 10px 13px;
            }
        }
    </style>

    <div class="container-fluid customer-management-page">
        <div class="customer-page-top">
            <div class="customer-page-heading">
                <h3>Quản lý khách hàng</h3>

                <p>
                    Quản lý thông tin, lịch sử đặt tour và mức độ hoạt động của
                    khách hàng.
                </p>
            </div>

            <a
                href="{{ route('Admin.khach-hang.create') }}"
                class="btn-add-customer"
            >
                <i class="fas fa-plus"></i>
                Thêm khách hàng
            </a>
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

        <div class="customer-card">
            <div class="customer-card-header">
                <div class="customer-header-content">
                    <span class="customer-header-icon">
                        <i class="fas fa-users"></i>
                    </span>

                    <div>
                        <h4>Danh sách khách hàng</h4>

                        <p>
                            Theo dõi thông tin liên hệ và số lần đặt tour.
                        </p>
                    </div>
                </div>

                <div class="customer-total">
                    <strong>{{ $khachHangs->total() }}</strong>
                    <span>Khách hàng</span>
                </div>
            </div>

            <div class="customer-card-body">
                <div class="customer-filter-box">
                    <div class="customer-filter-title">
                        <i class="fas fa-filter"></i>
                        Bộ lọc khách hàng
                    </div>

                    <form
                        method="GET"
                        action="{{ route('Admin.khach-hang.index') }}"
                        class="customer-filter-form"
                    >
                        <div class="customer-filter-field">
                            <label for="keyword">Tìm kiếm</label>

                            <div class="customer-filter-control">
                                <i class="fas fa-search field-icon"></i>

                                <input
                                    type="text"
                                    name="keyword"
                                    id="keyword"
                                    value="{{ request('keyword') }}"
                                    class="form-control"
                                    placeholder="Tên, email hoặc số điện thoại..."
                                    autocomplete="off"
                                >
                            </div>
                        </div>

                        <div class="customer-filter-field">
                            <label for="loai_hanh_khach">
                                Loại hành khách
                            </label>

                            <select
                                name="loai_hanh_khach"
                                id="loai_hanh_khach"
                                class="form-select"
                            >
                                <option value="">
                                    Tất cả loại hành khách
                                </option>

                                <option
                                    value="adult"
                                    @selected(request('loai_hanh_khach') === 'adult')
                                >
                                    Người lớn
                                </option>

                                <option
                                    value="child"
                                    @selected(request('loai_hanh_khach') === 'child')
                                >
                                    Trẻ em
                                </option>

                                <option
                                    value="baby"
                                    @selected(request('loai_hanh_khach') === 'baby')
                                >
                                    Em bé
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
                            href="{{ route('Admin.khach-hang.index') }}"
                            class="btn-filter-action btn-reset"
                        >
                            <i class="fas fa-rotate-left"></i>
                            Đặt lại
                        </a>
                    </form>
                </div>

                <div class="customer-table-wrapper">
                    <table class="table customer-table">
                        <thead>
                            <tr>
                                <th>Khách hàng</th>
                                <th>Thông tin liên hệ</th>
                                <th>Hoạt động</th>
                                <th>Trạng thái</th>
                                <th>Ngày tham gia</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($khachHangs as $khachHang)
                                @php
                                    $bookingCount = (int) ($khachHang->so_lan_dat ?? 0);

                                    if ($bookingCount <= 1) {
                                        $customerStatusClass = 'status-new';
                                        $customerStatusLabel = 'Khách mới';
                                    } elseif ($bookingCount <= 3) {
                                        $customerStatusClass = 'status-active';
                                        $customerStatusLabel = 'Đang hoạt động';
                                    } else {
                                        $customerStatusClass = 'status-vip';
                                        $customerStatusLabel = 'Khách thân thiết';
                                    }

                                    $customerInitial = mb_strtoupper(
                                        mb_substr(
                                            $khachHang->ho_ten ?: 'K',
                                            0,
                                            1
                                        )
                                    );

                                    $joinedDate = $khachHang->ngay_tham_gia
                                        ? \Carbon\Carbon::parse($khachHang->ngay_tham_gia)
                                        : null;
                                @endphp

                                <tr>
                                    <td>
                                        <div class="customer-user">
                                            <span class="customer-avatar">
                                                {{ $customerInitial }}
                                            </span>

                                            <span class="customer-name-content">
                                                <span
                                                    class="customer-name"
                                                    title="{{ $khachHang->ho_ten }}"
                                                >
                                                    {{ $khachHang->ho_ten }}
                                                </span>

                                                <span class="customer-id">
                                                    Mã khách hàng:
                                                    #{{ $khachHang->id }}
                                                </span>
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="contact-list">
                                            @if ($khachHang->email)
                                                <div
                                                    class="contact-item"
                                                    title="{{ $khachHang->email }}"
                                                >
                                                    <i class="fas fa-envelope"></i>
                                                    <span>{{ $khachHang->email }}</span>
                                                </div>
                                            @else
                                                <div class="contact-item empty-value">
                                                    <i class="fas fa-envelope"></i>
                                                    <span>Chưa có email</span>
                                                </div>
                                            @endif

                                            @if ($khachHang->so_dien_thoai)
                                                <div class="contact-item">
                                                    <i class="fas fa-phone"></i>
                                                    <span>
                                                        {{ $khachHang->so_dien_thoai }}
                                                    </span>
                                                </div>
                                            @else
                                                <div class="contact-item empty-value">
                                                    <i class="fas fa-phone"></i>
                                                    <span>Chưa có số điện thoại</span>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        <span class="booking-count">
                                            <i class="fas fa-calendar-check"></i>

                                            {{ $bookingCount }} lần đặt
                                        </span>
                                    </td>

                                    <td>
                                        <span class="customer-status {{ $customerStatusClass }}">
                                            <span class="status-dot"></span>
                                            {{ $customerStatusLabel }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($joinedDate)
                                            <div class="joined-date">
                                                {{ $joinedDate->format('d/m/Y') }}
                                            </div>

                                            <div class="joined-relative">
                                                {{ $joinedDate->diffForHumans() }}
                                            </div>
                                        @else
                                            <span class="empty-value">
                                                Chưa xác định
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="customer-actions">
                                            <a
                                                href="{{ route('Admin.khach-hang.show', $khachHang->id) }}"
                                                class="btn-table-action btn-view"
                                                title="Xem chi tiết"
                                                data-bs-toggle="tooltip"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a
                                                href="{{ route('Admin.khach-hang.edit', $khachHang->id) }}"
                                                class="btn-table-action btn-edit"
                                                title="Chỉnh sửa"
                                                data-bs-toggle="tooltip"
                                            >
                                                <i class="fas fa-pen"></i>
                                            </a>

                                            <form
                                                action="{{ route('Admin.khach-hang.destroy', $khachHang->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa khách hàng này?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn-table-action btn-delete"
                                                    title="Xóa khách hàng"
                                                    data-bs-toggle="tooltip"
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
                                        colspan="6"
                                        class="customer-empty-row"
                                    >
                                        <div class="empty-state-icon">
                                            <i class="fas fa-user-slash"></i>
                                        </div>

                                        <div class="empty-state-title">
                                            Không tìm thấy khách hàng
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

                @if ($khachHangs->hasPages())
                    <div class="customer-pagination">
                        {{ $khachHangs
                            ->withQueryString()
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
