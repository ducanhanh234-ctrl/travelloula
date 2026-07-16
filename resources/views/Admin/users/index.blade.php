@extends('layouts.admin')

@section('content')
    @php
        $currentUser = auth()->user();
    @endphp

    <style>
        :root {
            --user-primary: #315be8;
            --user-primary-dark: #244bd2;
            --user-primary-light: #edf4ff;
            --user-purple: #5b4dea;
            --user-cyan: #16c7e8;

            --user-text-dark: #172b4d;
            --user-text-main: #344563;
            --user-text-muted: #6b7895;
            --user-text-light: #98a2b3;

            --user-border: #dce6f5;
            --user-border-light: #e8eef8;

            --user-white: #ffffff;
            --user-hover: #f3f7ff;

            --user-success: #149963;
            --user-success-light: #eaf9f1;

            --user-warning: #cc8317;
            --user-warning-light: #fff7e8;

            --user-danger: #dc4c64;
            --user-danger-light: #fff0f3;
        }

        .user-management-page {
            padding: 24px 0;
            color: var(--user-text-dark);
        }

        /* Tiêu đề trang */
        .user-page-top {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-heading h3 {
            margin: 0;
            color: #173576;
            font-size: 23px;
            font-weight: 750;
            letter-spacing: -0.2px;
        }

        .page-heading p {
            margin: 6px 0 0;
            color: var(--user-text-muted);
            font-size: 14px;
        }

        /* Card chính */
        .user-card {
            position: relative;
            overflow: hidden;
            background: var(--user-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
        }

        .user-card::before {
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

        /* Header */
        .user-card-header {
            position: relative;
            min-height: 115px;
            padding: 24px;
            overflow: hidden;
            color: var(--user-white);
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

        .user-card-header::before {
            position: absolute;
            right: -50px;
            bottom: -105px;
            width: 235px;
            height: 235px;
            content: "";
            border: 21px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .user-card-header::after {
            position: absolute;
            top: -85px;
            right: 115px;
            width: 175px;
            height: 175px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .user-header-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .user-header-icon {
            width: 46px;
            height: 46px;
            flex-shrink: 0;
            color: var(--user-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            box-shadow: 0 7px 18px rgba(20, 43, 128, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .user-header-icon i {
            font-size: 18px;
        }

        .user-card-header h3 {
            margin: 0;
            color: var(--user-white);
            font-size: 20px;
            font-weight: 750;
        }

        .user-card-header p {
            margin: 6px 0 0;
            color: rgba(255, 255, 255, 0.82);
            font-size: 12px;
        }

        .user-total {
            position: relative;
            z-index: 2;
            min-width: 108px;
            padding: 12px 15px;
            color: var(--user-white);
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 11px;
            text-align: center;
            backdrop-filter: blur(4px);
        }

        .user-total strong {
            display: block;
            font-size: 22px;
            line-height: 1;
        }

        .user-total span {
            display: block;
            margin-top: 5px;
            font-size: 10px;
            opacity: 0.85;
        }

        /* Body */
        .user-card-body {
            padding: 22px;
            background: var(--user-white);
        }

        /* Thông báo */
        .user-management-page .alert {
            margin-bottom: 18px;
            border: 1px solid transparent;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(16, 24, 40, 0.05);
        }

        .user-management-page .alert-success {
            color: #087548;
            background: var(--user-success-light);
            border-color: #bfead3;
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
            color: var(--user-primary);
        }

        .filter-form {
            display: grid;
            grid-template-columns:
                minmax(280px, 1fr)
                minmax(190px, 240px)
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
            background-color: var(--user-white);
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
            color: var(--user-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
            box-shadow: 0 4px 11px rgba(49, 91, 232, 0.2);
        }

        .btn-filter:hover {
            color: var(--user-white);
            background: linear-gradient(
                135deg,
                #264ed4,
                #4c40d7
            );
            box-shadow: 0 6px 14px rgba(49, 91, 232, 0.27);
        }

        .btn-reset {
            color: #53698f;
            background: #ffffff;
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
            border: 1px solid var(--user-border);
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

        .user-table {
            width: 100%;
            min-width: 980px;
            margin-bottom: 0;
            color: var(--user-text-dark);
            vertical-align: middle;
        }

        .user-table thead th {
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

        .user-table tbody td {
            padding: 13px 14px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--user-border-light);
            font-size: 13px;
            line-height: 1.5;
        }

        .user-table tbody tr:last-child td {
            border-bottom: none;
        }

        .user-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .user-table tbody tr:hover {
            background: var(--user-hover);
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .user-table th:nth-child(1),
        .user-table td:nth-child(1) {
            width: 70px;
            text-align: center;
        }

        .user-table th:nth-child(2),
        .user-table td:nth-child(2) {
            width: 190px;
            text-align: left;
        }

        .user-table th:nth-child(3),
        .user-table td:nth-child(3) {
            width: 260px;
            text-align: left;
        }

        .user-table th:nth-child(4),
        .user-table td:nth-child(4) {
            width: 150px;
            text-align: center;
        }

        .user-table th:nth-child(5),
        .user-table td:nth-child(5) {
            width: 230px;
            text-align: center;
        }

        .user-table th:nth-child(6),
        .user-table td:nth-child(6) {
            width: 120px;
            text-align: center;
        }

        /* ID */
        .user-id {
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

        /* Người dùng */
        .user-name-cell {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            flex-shrink: 0;
            color: var(--user-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #5b4dea
            );
            border-radius: 9px;
            font-size: 12px;
            font-weight: 750;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(49, 91, 232, 0.17);
        }

        .user-name {
            min-width: 0;
            overflow: hidden;
            color: #233f7a;
            font-size: 13px;
            font-weight: 750;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Email */
        .email-value {
            max-width: 240px;
            overflow: hidden;
            color: #5c6d8c;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: block;
        }

        .email-value i {
            margin-right: 6px;
            color: #6784cc;
            font-size: 11px;
        }

        /* Điện thoại */
        .phone-value {
            color: #5a6c8d;
            white-space: nowrap;
        }

        .phone-value i {
            margin-right: 5px;
            color: #6784cc;
            font-size: 10px;
        }

        .empty-value {
            color: var(--user-text-light);
            font-size: 12px;
            font-style: italic;
        }

        /* Vai trò */
        .role-list {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 5px;
        }

        .role-badge {
            max-width: 145px;
            padding: 5px 9px;
            overflow: hidden;
            color: #2855ce;
            background: #eaf2ff;
            border: 1px solid #bed5ff;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .role-badge i {
            font-size: 8px;
        }

        .role-badge-more {
            color: #5146d6;
            background: #efedff;
            border-color: #d4ceff;
        }

        .no-role {
            padding: 5px 9px;
            color: #8590a5;
            background: #f4f6f9;
            border: 1px solid #e2e7ef;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 650;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* Nút hành động */
        .action-btns {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            flex-wrap: nowrap;
        }

        .action-btns form {
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
            color: var(--user-white);
            background: #3867e5;
            border-color: #3867e5;
            box-shadow: 0 5px 12px rgba(56, 103, 229, 0.25);
        }

        .btn-edit {
            color: #b87511;
            background: var(--user-warning-light);
            border-color: #f1dba9;
        }

        .btn-edit:hover {
            color: var(--user-white);
            background: #e39a25;
            border-color: #e39a25;
            box-shadow: 0 5px 12px rgba(227, 154, 37, 0.24);
        }

        .btn-delete {
            color: #cb4058;
            background: var(--user-danger-light);
            border-color: #f0c9d1;
        }

        .btn-delete:hover {
            color: var(--user-white);
            background: #df5067;
            border-color: #df5067;
            box-shadow: 0 5px 12px rgba(223, 80, 103, 0.23);
        }

        .btn-table-action:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.14);
        }

        /* Rỗng */
        .empty-row {
            padding: 50px 20px !important;
            color: #8793aa !important;
            text-align: center;
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
        .pagination-footer {
            padding: 18px 0 0;
        }

        .pagination-footer .pagination {
            margin: 0;
            gap: 4px;
            justify-content: center;
        }

        .pagination-footer .page-link {
            min-width: 34px;
            height: 34px;
            padding: 6px 10px;
            color: #3158ce;
            background: var(--user-white);
            border: 1px solid #d6e1f2;
            border-radius: 7px !important;
            font-size: 12px;
            box-shadow: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pagination-footer .page-link:hover {
            color: var(--user-white);
            background: #416ce5;
            border-color: #416ce5;
        }

        .pagination-footer .page-item.active .page-link {
            color: var(--user-white);
            background: linear-gradient(
                135deg,
                #315be8,
                #584be8
            );
            border-color: #315be8;
        }

        .pagination-footer .page-item.disabled .page-link {
            color: #aab3c5;
            background: #f8f9fc;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .user-management-page {
                padding: 18px 0;
            }

            .filter-form {
                grid-template-columns: 1fr 1fr;
            }

            .btn-filter-action {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .user-management-page {
                padding: 14px 0;
            }

            .user-page-top {
                align-items: stretch;
                flex-direction: column;
            }

            .page-heading h3 {
                font-size: 20px;
            }

            .user-card {
                border-radius: 11px;
            }

            .user-card-header {
                min-height: 105px;
                padding: 20px 18px;
            }

            .user-card-body {
                padding: 16px;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

            .filter-box {
                padding: 14px;
            }
        }

        @media (max-width: 480px) {
            .user-card-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .user-total {
                min-width: 100px;
                padding: 10px 13px;
            }
        }
    </style>

    <div class="container-fluid user-management-page">
        <div class="user-page-top">
            <div class="page-heading">
                <h3>Quản lý người dùng</h3>

                <p>
                    Tìm kiếm, quản lý tài khoản và vai trò của người dùng.
                </p>
            </div>
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

        <div class="card user-card">
            <div class="user-card-header">
                <div class="user-header-content">
                    <span class="user-header-icon">
                        <i class="fas fa-users"></i>
                    </span>

                    <div>
                        <h3>Danh sách người dùng</h3>

                        <p>
                            Quản lý thông tin tài khoản và vai trò trong hệ thống.
                        </p>
                    </div>
                </div>

                <div class="user-total">
                    <strong>{{ $users->total() }}</strong>
                    <span>Người dùng</span>
                </div>
            </div>

            <div class="user-card-body">
                <div class="filter-box">
                    <div class="filter-box-title">
                        <i class="fas fa-filter"></i>
                        Bộ lọc người dùng
                    </div>

                    <form
                        method="GET"
                        action="{{ route('Admin.users.index') }}"
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
                                    placeholder="Nhập tên, email hoặc số điện thoại..."
                                    autocomplete="off"
                                >
                            </div>
                        </div>

                        <div class="filter-field">
                            <label for="vai_tro_id">Vai trò</label>

                            <select
                                name="vai_tro_id"
                                id="vai_tro_id"
                                class="form-select"
                            >
                                <option value="">Tất cả vai trò</option>

                                @foreach ($vaiTros as $vaiTro)
                                    <option
                                        value="{{ $vaiTro->id }}"
                                        {{ (string) request('vai_tro_id') === (string) $vaiTro->id ? 'selected' : '' }}
                                    >
                                        {{ $vaiTro->ten_vai_tro }}
                                    </option>
                                @endforeach
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
                            href="{{ route('Admin.users.index') }}"
                            class="btn-filter-action btn-reset"
                        >
                            <i class="fas fa-sync-alt"></i>
                            Đặt lại
                        </a>
                    </form>
                </div>

                <div class="table-wrapper">
                    <table class="table user-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Người dùng</th>
                                <th>Email</th>
                                <th>Điện thoại</th>
                                <th>Vai trò</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <td>
                                        <span class="user-id">
                                            {{ $user->id }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="user-name-cell">
                                            <span class="user-avatar">
                                                {{ mb_substr($user->name, 0, 1) }}
                                            </span>

                                            <span
                                                class="user-name"
                                                title="{{ $user->name }}"
                                            >
                                                {{ $user->name }}
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <span
                                            class="email-value"
                                            title="{{ $user->email }}"
                                        >
                                            <i class="fas fa-envelope"></i>
                                            {{ $user->email }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($user->phone)
                                            <span class="phone-value">
                                                <i class="fas fa-phone"></i>
                                                {{ $user->phone }}
                                            </span>
                                        @else
                                            <span class="empty-value">
                                                Chưa cập nhật
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($user->vaiTros->isEmpty())
                                            <span class="no-role">
                                                <i class="fas fa-user-lock"></i>
                                                Chưa có vai trò
                                            </span>
                                        @else
                                            <div class="role-list">
                                                @foreach ($user->vaiTros->take(2) as $vaiTro)
                                                    <span
                                                        class="role-badge"
                                                        title="{{ $vaiTro->ten_vai_tro }}"
                                                    >
                                                        <i class="fas fa-user-tag"></i>
                                                        {{ $vaiTro->ten_vai_tro }}
                                                    </span>
                                                @endforeach

                                                @if ($user->vaiTros->count() > 2)
                                                    <span
                                                        class="role-badge role-badge-more"
                                                        title="Còn {{ $user->vaiTros->count() - 2 }} vai trò khác"
                                                        data-bs-toggle="tooltip"
                                                    >
                                                        +{{ $user->vaiTros->count() - 2 }}
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="action-btns">
                                            <a
                                                href="{{ route('Admin.users.show', $user->id) }}"
                                                class="btn-table-action btn-view"
                                                title="Xem chi tiết"
                                                data-bs-toggle="tooltip"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if (
                                                $currentUser
                                                && $currentUser->hasPermission('users.edit')
                                            )
                                                <a
                                                    href="{{ route('Admin.users.edit', $user->id) }}"
                                                    class="btn-table-action btn-edit"
                                                    title="Chỉnh sửa"
                                                    data-bs-toggle="tooltip"
                                                >
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            @endif

                                            @if (
                                                $currentUser
                                                && $currentUser->hasPermission('users.delete')
                                            )
                                                <form
                                                    action="{{ route('Admin.users.destroy', $user->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản này?');"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="btn-table-action btn-delete"
                                                        title="Xóa người dùng"
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
                                    <td colspan="6" class="empty-row">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-user-slash"></i>
                                        </div>

                                        <div class="empty-state-title">
                                            Không tìm thấy người dùng
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

                @if ($users->hasPages())
                    <div class="pagination-footer">
                        {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
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
