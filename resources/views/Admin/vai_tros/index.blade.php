@extends('layouts.admin')

@section('content')
    @php
        $currentUser = auth()->user();
    @endphp

    <style>
        :root {
            --role-primary: #315be8;
            --role-primary-dark: #244bd2;
            --role-primary-light: #edf4ff;
            --role-purple: #5b4dea;
            --role-cyan: #16c7e8;

            --role-text-dark: #172b4d;
            --role-text-main: #344563;
            --role-text-muted: #6b7895;
            --role-text-light: #98a2b3;

            --role-border: #dce6f5;
            --role-border-light: #e8eef8;

            --role-white: #ffffff;
            --role-hover: #f3f7ff;

            --role-success: #149963;
            --role-success-light: #eaf9f1;

            --role-warning: #cc8317;
            --role-warning-light: #fff7e8;

            --role-danger: #dc4c64;
            --role-danger-light: #fff0f3;
        }

        .role-list-page {
            padding: 24px 0;
            color: var(--role-text-dark);
        }

        /* Header trang */
        .top-actions {
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
            color: var(--role-text-muted);
            font-size: 14px;
        }

        .top-action-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Nút phía trên */
        .btn-page-action {
            min-height: 40px;
            padding: 9px 16px;
            border: 1px solid transparent;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition:
                background-color 0.18s ease,
                border-color 0.18s ease,
                color 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.18s ease;
        }

        .btn-page-action:hover {
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-matrix {
            color: #2855ce;
            background: #edf4ff;
            border-color: #bdd4ff;
        }

        .btn-matrix:hover {
            color: #1e46bd;
            background: #dfeaff;
            border-color: #9ebeff;
            box-shadow: 0 5px 14px rgba(49, 91, 232, 0.14);
        }

        .btn-create {
            color: var(--role-white);
            background: linear-gradient(
                135deg,
                #315be8 0%,
                #3c6df0 55%,
                #594bea 100%
            );
            border-color: #315be8;
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.24);
        }

        .btn-create:hover {
            color: var(--role-white);
            background: linear-gradient(
                135deg,
                #264ed4 0%,
                #315edc 55%,
                #4d40d8 100%
            );
            border-color: #264ed4;
            box-shadow: 0 8px 20px rgba(49, 91, 232, 0.3);
        }

        /* Thông báo */
        .role-list-page .alert {
            margin-bottom: 18px;
            border: 1px solid transparent;
            border-radius: 10px;
            box-shadow: 0 4px 14px rgba(16, 24, 40, 0.05);
        }

        .role-list-page .alert-success {
            color: #087548;
            background: #eafaf2;
            border-color: #bfead3;
        }

        /* Card */
        .role-card {
            position: relative;
            overflow: hidden;
            background: var(--role-white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
        }

        .role-card::before {
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
        .role-header {
            position: relative;
            min-height: 105px;
            padding: 24px;
            overflow: hidden;
            color: var(--role-white);
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

        .role-header::before {
            position: absolute;
            right: -50px;
            bottom: -100px;
            width: 230px;
            height: 230px;
            content: "";
            border: 21px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .role-header::after {
            position: absolute;
            top: -80px;
            right: 120px;
            width: 170px;
            height: 170px;
            content: "";
            background: rgba(255, 255, 255, 0.045);
            border-radius: 50%;
        }

        .role-header-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .role-header-icon {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            color: var(--role-white);
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            box-shadow: 0 7px 18px rgba(20, 43, 128, 0.2);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .role-header-icon i {
            font-size: 18px;
        }

        .role-header h5 {
            margin: 0;
            color: var(--role-white);
            font-size: 14px;
            font-weight: 500;
        }

        .role-header strong {
            margin-left: 4px;
            font-size: 18px;
            font-weight: 750;
        }

        .role-header-description {
            margin: 5px 0 0;
            color: rgba(255, 255, 255, 0.8);
            font-size: 12px;
        }

        /* Bảng */
        .role-card .table-responsive {
            background: var(--role-white);
        }

        .role-table {
            width: 100%;
            min-width: 980px;
            margin-bottom: 0;
            color: var(--role-text-dark);
            vertical-align: middle;
        }

        .role-table thead th {
            padding: 14px;
            color: #24417d;
            background: #f1f6ff;
            border-top: none;
            border-bottom: 1px solid #d8e5f8;
            font-size: 12px;
            font-weight: 750;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .role-table thead th:first-child {
            padding-left: 20px;
        }

        .role-table tbody td {
            padding: 14px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--role-border-light);
            font-size: 13px;
            line-height: 1.5;
        }

        .role-table tbody td:first-child {
            padding-left: 20px;
        }

        .role-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .role-table tbody tr:hover {
            background: var(--role-hover);
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .role-table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ID */
        .role-id {
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

        /* Tên vai trò */
        .role-name {
            color: #233f7a;
            font-size: 14px;
            font-weight: 750;
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .role-name-icon {
            width: 27px;
            height: 27px;
            color: #315be8;
            background: #eaf2ff;
            border: 1px solid #cfe0ff;
            border-radius: 7px;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .role-description {
            max-width: 360px;
            color: #68758e;
            line-height: 1.55;
        }

        .empty-value {
            color: var(--role-text-light);
            font-size: 12px;
            font-style: italic;
        }

        /* Danh sách quyền */
        .permission-list {
            max-width: 390px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 5px;
        }

        .permission-badge {
            max-width: 165px;
            padding: 4px 9px;
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

        .permission-badge i {
            font-size: 8px;
        }

        .permission-more {
            color: #5146d6;
            background: #efedff;
            border-color: #d4ceff;
            cursor: help;
        }

        .no-permission {
            padding: 5px 9px;
            color: #8590a5;
            background: #f4f6f9;
            border: 1px solid #e2e7ef;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        /* Nút hành động nhỏ */
        .action-buttons {
            display: flex;
            align-items: center;
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
            color: var(--role-white);
            background: #3867e5;
            border-color: #3867e5;
            box-shadow: 0 5px 12px rgba(56, 103, 229, 0.25);
        }

        .btn-edit {
            color: #b87511;
            background: var(--role-warning-light);
            border-color: #f1dba9;
        }

        .btn-edit:hover {
            color: var(--role-white);
            background: #e39a25;
            border-color: #e39a25;
            box-shadow: 0 5px 12px rgba(227, 154, 37, 0.24);
        }

        .btn-delete {
            color: #cb4058;
            background: var(--role-danger-light);
            border-color: #f0c9d1;
        }

        .btn-delete:hover {
            color: var(--role-white);
            background: #df5067;
            border-color: #df5067;
            box-shadow: 0 5px 12px rgba(223, 80, 103, 0.23);
        }

        .btn-table-action:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.14);
        }

        /* Trạng thái rỗng */
        .empty-state {
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
            font-weight: 650;
        }

        .empty-state a {
            color: #315be8;
            font-weight: 700;
            text-decoration: none;
        }

        .empty-state a:hover {
            color: #244bd2;
            text-decoration: underline;
        }

        /* Phân trang */
        .pagination-footer {
            padding: 18px 22px;
            background: #f7f9fd;
            border-top: 1px solid #dfe8f6;
        }

        .pagination-footer .pagination {
            margin: 0;
            gap: 4px;
        }

        .pagination-footer .page-link {
            min-width: 34px;
            height: 34px;
            padding: 6px 10px;
            color: #3158ce;
            background: var(--role-white);
            border: 1px solid #d6e1f2;
            border-radius: 7px !important;
            font-size: 12px;
            box-shadow: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pagination-footer .page-link:hover {
            color: var(--role-white);
            background: #416ce5;
            border-color: #416ce5;
        }

        .pagination-footer .page-item.active .page-link {
            color: var(--role-white);
            background: linear-gradient(135deg, #315be8, #584be8);
            border-color: #315be8;
        }

        .pagination-footer .page-item.disabled .page-link {
            color: #aab3c5;
            background: #f8f9fc;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .role-list-page {
                padding: 18px 0;
            }

            .role-table {
                min-width: 1050px;
            }
        }

        @media (max-width: 768px) {
            .role-list-page {
                padding: 14px 0;
            }

            .top-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .page-heading h3 {
                font-size: 20px;
            }

            .top-action-buttons {
                width: 100%;
            }

            .btn-page-action {
                flex: 1;
            }

            .role-card {
                border-radius: 11px;
            }

            .role-header {
                min-height: 95px;
                padding: 20px 18px;
            }

            .role-table thead th,
            .role-table tbody td {
                padding: 12px;
            }

            .pagination-footer {
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            .top-action-buttons {
                flex-direction: column;
            }

            .btn-page-action {
                width: 100%;
            }

            .role-header-description {
                display: none;
            }
        }
    </style>

    <div class="container-fluid role-list-page">
        <div class="top-actions">
            <div class="page-heading">
                <h3>Danh sách vai trò</h3>

                <p>
                    Quản lý các vai trò và quyền hạn trong hệ thống.
                </p>
            </div>

            <div class="top-action-buttons">
                <a
                    href="{{ route('Admin.role-permissions.matrix') }}"
                    class="btn-page-action btn-matrix"
                >
                    <i class="fas fa-th-large"></i>
                    Bảng phân quyền
                </a>

                @if ($currentUser && $currentUser->hasPermission('roles.create'))
                    <a
                        href="{{ route('Admin.vai-tros.create') }}"
                        class="btn-page-action btn-create"
                    >
                        <i class="fas fa-plus"></i>
                        Thêm vai trò
                    </a>
                @endif
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

        <div class="card role-card">
            <div class="role-header">
                <div class="role-header-content">
                    <span class="role-header-icon">
                        <i class="fas fa-user-shield"></i>
                    </span>

                    <div>
                        <h5>
                            Tổng số vai trò:
                            <strong>{{ $vaiTros->total() }}</strong>
                        </h5>

                        <p class="role-header-description">
                            Danh sách vai trò và các quyền được cấp trong hệ thống.
                        </p>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table role-table">
                    <thead>
                        <tr>
                            <th style="width: 65px;">#</th>
                            <th style="width: 190px;">Tên vai trò</th>
                            <th>Mô tả</th>
                            <th style="width: 390px;">Quyền hạn</th>
                            <th style="width: 120px;">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($vaiTros as $vaiTro)
                            <tr>
                                <td>
                                    <span class="role-id">
                                        {{ $vaiTro->id }}
                                    </span>
                                </td>

                                <td>
                                    <span class="role-name">
                                        <span class="role-name-icon">
                                            <i class="fas fa-user-tag"></i>
                                        </span>

                                        {{ $vaiTro->ten_vai_tro }}
                                    </span>
                                </td>

                                <td>
                                    @if ($vaiTro->mo_ta)
                                        <div class="role-description">
                                            {{ $vaiTro->mo_ta }}
                                        </div>
                                    @else
                                        <span class="empty-value">
                                            Chưa có mô tả
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    @if ($vaiTro->quyenHans->isEmpty())
                                        <span class="no-permission">
                                            <i class="fas fa-lock"></i>
                                            Chưa có quyền
                                        </span>
                                    @else
                                        <div class="permission-list">
                                            @foreach ($vaiTro->quyenHans->take(3) as $quyenHan)
                                                <span
                                                    class="permission-badge"
                                                    title="{{ $quyenHan->ten_hien_thi }}"
                                                >
                                                    <i class="fas fa-key"></i>

                                                    {{ $quyenHan->ten_hien_thi }}
                                                </span>
                                            @endforeach

                                            @if ($vaiTro->quyenHans->count() > 3)
                                                <span
                                                    class="permission-badge permission-more"
                                                    title="Còn {{ $vaiTro->quyenHans->count() - 3 }} quyền khác"
                                                    data-bs-toggle="tooltip"
                                                >
                                                    +{{ $vaiTro->quyenHans->count() - 3 }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    <div class="action-buttons">
                                        <a
                                            href="{{ route('Admin.vai-tros.show', $vaiTro->id) }}"
                                            class="btn-table-action btn-view"
                                            title="Xem chi tiết"
                                            data-bs-toggle="tooltip"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if ($currentUser && $currentUser->hasPermission('roles.edit'))
                                            <a
                                                href="{{ route('Admin.vai-tros.edit', $vaiTro->id) }}"
                                                class="btn-table-action btn-edit"
                                                title="Chỉnh sửa"
                                                data-bs-toggle="tooltip"
                                            >
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        @endif

                                        @if ($currentUser && $currentUser->hasPermission('roles.delete'))
                                            <form
                                                action="{{ route('Admin.vai-tros.destroy', $vaiTro->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa vai trò này?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn-table-action btn-delete"
                                                    title="Xóa vai trò"
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
                                <td colspan="5" class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-user-shield"></i>
                                    </div>

                                    <div class="empty-state-title">
                                        Không có vai trò nào trong hệ thống.
                                    </div>

                                    @if ($currentUser && $currentUser->hasPermission('roles.create'))
                                        <div class="mt-2">
                                            <a href="{{ route('Admin.vai-tros.create') }}">
                                                Tạo vai trò mới
                                            </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($vaiTros->hasPages())
                <div class="pagination-footer">
                    {{ $vaiTros->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof bootstrap !== 'undefined') {
                const tooltipElements = document.querySelectorAll(
                    '[data-bs-toggle="tooltip"]'
                );

                tooltipElements.forEach(function (element) {
                    new bootstrap.Tooltip(element);
                });
            }
        });
    </script>
@endsection
