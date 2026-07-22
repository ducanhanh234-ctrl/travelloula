@extends('layouts.admin')

@section('content')
    @php
        $currentUser = auth()->user();
    @endphp

    <style>
        :root {
            --primary: #315be8;
            --primary-hover: #244bd2;
            --primary-light: #edf4ff;
            --primary-border: #c9dcff;

            --purple: #5b4dea;
            --cyan: #16c7e8;

            --text-main: #18336f;
            --text-dark: #172b4d;
            --text-muted: #6b7895;

            --border: #dce6f5;
            --border-light: #e8eef8;

            --white: #ffffff;
            --page-bg: #f4f7fc;
            --row-hover: #f3f7ff;

            --success: #16a36a;
            --success-bg: #e9f9f1;

            --danger: #dc4c64;
            --danger-bg: #fff0f3;

            --warning: #d28b19;
            --warning-bg: #fff7e6;
        }

        .permission-list-page {
            padding: 24px 0;
            color: var(--text-dark);
        }

        /* Tiêu đề trang */
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
        }

        .page-heading p {
            margin: 5px 0 0;
            color: var(--text-muted);
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
            font-weight: 650;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: all 0.2s ease;
        }

        .btn-page-action:hover {
            transform: translateY(-1px);
            text-decoration: none;
        }

        .btn-matrix {
            background: #edf4ff;
            border-color: #bdd4ff;
            color: #2754d7;
        }

        .btn-matrix:hover {
            background: #dfeaff;
            border-color: #9ebeff;
            color: #1e46bd;
            box-shadow: 0 5px 14px rgba(49, 91, 232, 0.14);
        }

        .btn-create {
            background: linear-gradient(
                135deg,
                #315be8 0%,
                #3c6df0 55%,
                #594bea 100%
            );
            border-color: #315be8;
            color: var(--white);
            box-shadow: 0 6px 16px rgba(49, 91, 232, 0.24);
        }

        .btn-create:hover {
            background: linear-gradient(
                135deg,
                #264ed4 0%,
                #315edc 55%,
                #4d40d8 100%
            );
            color: var(--white);
            box-shadow: 0 8px 20px rgba(49, 91, 232, 0.3);
        }

        /* Thông báo */
        .alert {
            margin-bottom: 18px;
            border-radius: 10px;
            border: 1px solid transparent;
        }

        .alert-success {
            color: #087548;
            background: #eafaf2;
            border-color: #bfead3;
        }

        /* Card danh sách */
        .permission-card {
            position: relative;
            background: var(--white);
            border: 1px solid #d8e4f6;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(28, 65, 139, 0.1);
            overflow: hidden;
        }

        .permission-card::before {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            content: "";
            z-index: 2;
            background: linear-gradient(
                90deg,
                #2458e7,
                #3478ef,
                #18c7e7,
                #5947e9
            );
        }

        /* Header card giống trang phân quyền */
        .permission-header {
            position: relative;
            min-height: 96px;
            padding: 25px 24px;
            overflow: hidden;
            color: var(--white);
            background: linear-gradient(
                120deg,
                #2856df 0%,
                #316cec 55%,
                #5b49e8 100%
            );
        }

        .permission-header::before {
            position: absolute;
            right: -45px;
            bottom: -75px;
            width: 190px;
            height: 190px;
            content: "";
            border: 18px solid rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .permission-header::after {
            position: absolute;
            right: 70px;
            top: -70px;
            width: 140px;
            height: 140px;
            content: "";
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.04);
        }

        .permission-header-content {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .permission-header-icon {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 11px;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 5px 14px rgba(20, 43, 128, 0.18);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .permission-header-icon i {
            font-size: 17px;
        }

        .permission-header h5 {
            position: relative;
            z-index: 1;
            margin: 0;
            color: var(--white);
            font-size: 14px;
            font-weight: 500;
            opacity: 1 !important;
        }

        .permission-header strong {
            margin-left: 4px;
            font-size: 18px;
            font-weight: 750;
        }

        /* Bảng */
        .table-responsive {
            background: #ffffff;
        }

        .permission-table {
            width: 100%;
            min-width: 1050px;
            margin-bottom: 0;
            color: var(--text-dark);
            vertical-align: middle;
        }

        .permission-table thead th {
            padding: 14px 14px;
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

        .permission-table thead th:first-child {
            padding-left: 20px;
        }

        .permission-table tbody td {
            padding: 13px 14px;
            color: #4d5d7d;
            border-bottom: 1px solid var(--border-light);
            font-size: 13px;
            line-height: 1.5;
        }

        .permission-table tbody td:first-child {
            padding-left: 20px;
        }

        .permission-table tbody tr {
            transition:
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .permission-table tbody tr:hover {
            background: #f3f7ff;
            box-shadow: inset 3px 0 0 #3a67ea;
        }

        .permission-table tbody tr:last-child td {
            border-bottom: none;
        }

        .permission-id {
            display: inline-flex;
            min-width: 29px;
            height: 29px;
            padding: 0 7px;
            color: #3158ce;
            background: #edf3ff;
            border: 1px solid #d4e2ff;
            border-radius: 7px;
            font-size: 11px;
            font-weight: 750;
            align-items: center;
            justify-content: center;
        }

        .permission-display-name {
            color: #233c72;
            font-weight: 700;
        }

        .permission-description {
            max-width: 350px;
            color: #6c7891;
            line-height: 1.55;
        }

        /* Tên kỹ thuật */
        .permission-code {
            display: inline-block;
            max-width: 200px;
            padding: 4px 8px;
            overflow: hidden;
            color: #2d59cf;
            background: #edf4ff;
            border: 1px solid #cee0ff;
            border-radius: 6px;
            font-family: Consolas, Monaco, monospace;
            font-size: 11px;
            font-weight: 650;
            text-overflow: ellipsis;
            white-space: nowrap;
            vertical-align: middle;
        }

        /* Module */
        .module-badge {
            display: inline-flex;
            padding: 4px 10px;
            color: #2555cc;
            background: #eaf2ff;
            border: 1px solid #bed5ff;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
            align-items: center;
        }

        .empty-value {
            color: #a0a9bd;
        }

        /* Trạng thái */
        .status-badge {
            display: inline-flex;
            padding: 5px 9px;
            border: 1px solid transparent;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
            align-items: center;
            gap: 5px;
        }

        .status-badge i {
            font-size: 8px;
        }

        .status-active {
            color: #08754a;
            background: var(--success-bg);
            border-color: #c5ead8;
        }

        .status-inactive {
            color: #b33b50;
            background: var(--danger-bg);
            border-color: #f1cbd3;
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
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.18s ease;
        }

        .btn-table-action i {
            font-size: 11px;
        }

        .btn-table-action:hover {
            transform: translateY(-2px);
            text-decoration: none;
        }

        .btn-view {
            color: #2d5fd7;
            background: #eaf2ff;
            border-color: #c7dafe;
        }

        .btn-view:hover {
            color: var(--white);
            background: #3867e5;
            border-color: #3867e5;
            box-shadow: 0 5px 12px rgba(56, 103, 229, 0.25);
        }

        .btn-edit {
            color: #be7810;
            background: var(--warning-bg);
            border-color: #f1dba9;
        }

        .btn-edit:hover {
            color: var(--white);
            background: #e39a25;
            border-color: #e39a25;
            box-shadow: 0 5px 12px rgba(227, 154, 37, 0.24);
        }

        .btn-delete {
            color: #cb4058;
            background: var(--danger-bg);
            border-color: #f0c9d1;
        }

        .btn-delete:hover {
            color: var(--white);
            background: #df5067;
            border-color: #df5067;
            box-shadow: 0 5px 12px rgba(223, 80, 103, 0.23);
        }

        .btn-table-action:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(49, 91, 232, 0.14);
        }

        /* Rỗng */
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

        .empty-state a {
            color: #315be8;
            font-weight: 650;
            text-decoration: none;
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
            background: var(--white);
            border: 1px solid #d6e1f2;
            border-radius: 7px !important;
            font-size: 12px;
            box-shadow: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pagination-footer .page-link:hover {
            color: #ffffff;
            background: #416ce5;
            border-color: #416ce5;
        }

        .pagination-footer .page-item.active .page-link {
            color: var(--white);
            background: linear-gradient(135deg, #315be8, #584be8);
            border-color: #315be8;
        }

        .pagination-footer .page-item.disabled .page-link {
            color: #aab3c5;
            background: #f8f9fc;
        }

        @media (max-width: 768px) {
            .permission-list-page {
                padding: 15px 0;
            }

            .top-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .top-action-buttons {
                width: 100%;
            }

            .btn-page-action {
                flex: 1;
            }

            .permission-card {
                border-radius: 11px;
            }

            .permission-header {
                padding: 20px 18px;
            }
        }

        @media (max-width: 480px) {
            .top-action-buttons {
                flex-direction: column;
            }

            .btn-page-action {
                width: 100%;
            }
        }
    </style>

    <div class="container-fluid permission-list-page">
        <div class="top-actions">
            <div class="page-heading">
                <h3>Danh sách quyền hạn</h3>

                <p>Quản lý các quyền hạn trong hệ thống.</p>
            </div>

            <div class="top-action-buttons">
                <a
                    href="{{ route('Admin.role-permissions.matrix') }}"
                    class="btn-page-action btn-matrix"
                >
                    <i class="fas fa-th-large"></i>
                    Bảng phân quyền
                </a>

                @if ($currentUser && $currentUser->hasPermission('permissions.create'))
                    <a
                        href="{{ route('Admin.quyen-hans.create') }}"
                        class="btn-page-action btn-create"
                    >
                        <i class="fas fa-plus"></i>
                        Thêm quyền
                    </a>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
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

        <div class="card permission-card">
            <div class="permission-header">
                <div class="permission-header-content">
                    <span class="permission-header-icon">
                        <i class="fas fa-key"></i>
                    </span>

                    <h5>
                        Tổng số quyền:
                        <strong>{{ $quyenHans->total() }}</strong>
                    </h5>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table permission-table">
                    <thead>
                        <tr>
                            <th style="width: 65px;">#</th>
                            <th style="width: 180px;">Tên kỹ thuật</th>
                            <th style="width: 190px;">Tên hiển thị</th>
                            <th style="width: 140px;">Mô đun</th>
                            <th>Mô tả</th>
                            <th style="width: 125px;">Trạng thái</th>
                            <th style="width: 120px;">Hành động</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($quyenHans as $quyenHan)
                            <tr>
                                <td>
                                    <span class="permission-id">
                                        {{ $quyenHan->id }}
                                    </span>
                                </td>

                                <td>
                                    <code
                                        class="permission-code"
                                        title="{{ $quyenHan->ten }}"
                                    >
                                        {{ $quyenHan->ten }}
                                    </code>
                                </td>

                                <td>
                                    <span class="permission-display-name">
                                        {{ $quyenHan->ten_hien_thi }}
                                    </span>
                                </td>

                                <td>
                                    @if ($quyenHan->mo_dun)
                                        <span class="module-badge">
                                            {{ $quyenHan->mo_dun }}
                                        </span>
                                    @else
                                        <span class="empty-value">—</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="permission-description">
                                        {{ $quyenHan->mo_ta ?? '—' }}
                                    </div>
                                </td>

                                <td>
                                    @if ($quyenHan->trang_thai)
                                        <span class="status-badge status-active">
                                            <i class="fas fa-circle"></i>
                                            Kích hoạt
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive">
                                            <i class="fas fa-circle"></i>
                                            Đã tắt
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <div class="action-buttons">
                                        <a
                                            href="{{ route('Admin.quyen-hans.show', $quyenHan->id) }}"
                                            class="btn-table-action btn-view"
                                            title="Xem chi tiết"
                                            data-bs-toggle="tooltip"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        @if ($currentUser && $currentUser->hasPermission('permissions.edit'))
                                            <a
                                                href="{{ route('Admin.quyen-hans.edit', $quyenHan->id) }}"
                                                class="btn-table-action btn-edit"
                                                title="Chỉnh sửa"
                                                data-bs-toggle="tooltip"
                                            >
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        @endif

                                        @if ($currentUser && $currentUser->hasPermission('permissions.delete'))
                                            <form
                                                action="{{ route('Admin.quyen-hans.destroy', $quyenHan->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Bạn có chắc muốn xóa quyền này?');"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn-table-action btn-delete"
                                                    title="Xóa quyền"
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
                                <td colspan="7" class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-inbox"></i>
                                    </div>

                                    <div>Không có quyền hạn nào.</div>

                                    @if ($currentUser && $currentUser->hasPermission('permissions.create'))
                                        <div class="mt-2">
                                            <a href="{{ route('Admin.quyen-hans.create') }}">
                                                Tạo quyền mới
                                            </a>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($quyenHans->hasPages())
                <div class="pagination-footer">
                    {{ $quyenHans->links('pagination::bootstrap-5') }}
                </div>
            @endif
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
