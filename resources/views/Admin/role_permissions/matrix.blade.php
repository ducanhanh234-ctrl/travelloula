@extends('layouts.admin')

@section('content')
<div class="container-fluid permission-matrix-page">
    <style>
        .permission-matrix-page {
            padding: 24px 0;
        }

        .permission-matrix-container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .matrix-header {
            background: linear-gradient(135deg, #0d6efd, #5b9dff);
            color: #fff;
            padding: 22px 26px;
        }

        .matrix-header h3 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
        }

        .matrix-header p {
            margin: 8px 0 0;
            font-size: 14px;
            opacity: .9;
        }

        .table-wrapper {
            overflow-x: auto;
            padding: 24px;
            background: #fff;
        }

        .permission-matrix {
            width: 100%;
            min-width: 900px;
            border-collapse: separate;
            border-spacing: 0;
            margin: 0;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }

        .permission-matrix th,
        .permission-matrix td {
            padding: 14px 12px;
            border-bottom: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
            text-align: center;
            vertical-align: middle;
            font-size: 14px;
        }

        .permission-matrix th:last-child,
        .permission-matrix td:last-child {
            border-right: none;
        }

        .permission-matrix tbody tr:last-child td {
            border-bottom: none;
        }

        .permission-matrix thead th {
            background: #f1f5f9;
            color: #334155;
            font-weight: 700;
            white-space: nowrap;
        }

        .permission-matrix th:first-child,
        .permission-matrix tbody td:first-child {
            position: sticky;
            left: 0;
            z-index: 5;
            text-align: left;
            min-width: 260px;
            max-width: 320px;
        }

        .permission-matrix th:first-child {
            background: #f1f5f9;
            z-index: 8;
        }

        .permission-matrix tbody td:first-child {
            background: #fff;
            font-weight: 600;
            color: #334155;
        }

        .permission-matrix tbody tr.permission-row:hover {
            background: #f8fbff;
        }

        .permission-matrix tbody tr.permission-row:hover td:first-child {
            background: #f8fbff;
        }

        .module-row td {
            background: #eef6ff !important;
            padding: 0 !important;
        }

        .module-toggle {
            width: 100%;
            border: none;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: #1e3a8a;
            padding: 14px 18px;
            font-weight: 800;
            font-size: 15px;
            text-align: left;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            transition: .25s;
        }

        .module-toggle:hover {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        }

        .module-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .module-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #2563eb;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .module-info {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .module-name {
            text-transform: uppercase;
            letter-spacing: .04em;
        }

        .module-count {
            background: #fff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
            border-radius: 999px;
            padding: 4px 10px;
            font-size: 12px;
            font-weight: 800;
        }

        .module-arrow {
            transition: .25s;
        }

        .module-toggle.collapsed .module-arrow {
            transform: rotate(-90deg);
        }

        .permission-row.is-hidden {
            display: none;
        }

        .permission-title {
            font-weight: 700;
            color: #334155;
            margin-bottom: 4px;
        }

        .permission-code {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 999px;
            background: #e7f1ff;
            color: #0d6efd;
            font-size: 12px;
            font-weight: 700;
            margin-top: 4px;
        }

        .permission-module {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
        }

        .role-header {
            min-width: 90px;
            font-weight: 700;
            color: #334155;
        }

        .permission-checkbox {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .permission-checkbox input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #0d6efd;
        }

        .pagination-wrapper {
            padding: 0 24px 20px;
            display: flex;
            justify-content: center;
        }

        .pagination-wrapper .pagination {
            margin-bottom: 0;
        }

        .matrix-footer {
            padding: 18px 24px;
            background: #f8fafc;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .stats {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 999px;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: 600;
            color: #475569;
        }

        .stat-icon {
            min-width: 26px;
            height: 26px;
            padding: 0 8px;
            background: #e7f1ff;
            color: #0d6efd;
            border-radius: 999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 800;
        }

        .matrix-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .matrix-actions .btn,
        .btn-save {
            min-width: 140px;
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 16px;
        }

        .btn-save {
            background: #0d6efd;
            color: #fff;
            border: none;
        }

        .btn-save:hover {
            background: #0b5ed7;
            color: #fff;
        }

        .alert-container {
            margin-bottom: 18px;
        }

        .alert {
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .table-wrapper {
                padding: 16px;
            }

            .matrix-header {
                padding: 18px;
            }

            .matrix-footer {
                align-items: stretch;
            }

            .matrix-actions {
                width: 100%;
                flex-direction: column;
            }

            .matrix-actions .btn,
            .btn-save {
                width: 100%;
            }
        }
    </style>

    @if(session('success'))
        <div class="alert-container">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <div class="permission-matrix-container">
        <div class="matrix-header">
            <h3>Bảng phân quyền vai trò</h3>
            <p>Quản lý quyền hạn theo từng nhóm chức năng. Bấm vào từng mục để xổ hoặc ẩn các quyền con.</p>
        </div>

        <form method="POST" action="{{ route('Admin.role-permissions.update-matrix') }}">
            @csrf

            @foreach($quyenHans as $permission)
                <input type="hidden" name="visible_permission_ids[]" value="{{ $permission->id }}">
            @endforeach

            <div class="table-wrapper">
                <table class="permission-matrix">
                    <thead>
                        <tr>
                            <th>Quyền hạn</th>

                            @foreach($vaiTros as $vaiTro)
                                <th>
                                    <div class="role-header">
                                        {{ $vaiTro->ten_vai_tro }}
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($quyenHans->getCollection()->groupBy('mo_dun') as $module => $permissions)
                            @php
                                $moduleKey = $module ?: 'system';

                                $moduleNames = [
                                    'users' => 'Người dùng',
                                    'roles' => 'Vai trò',
                                    'permissions' => 'Quyền hạn',
                                    'tours' => 'Tour',
                                    'bookings' => 'Đặt tour',
                                    'guides' => 'Hướng dẫn viên',
                                    'banners' => 'Banner',
                                    'danh_mucs' => 'Danh mục',
                                    'phuong_tiens' => 'Phương tiện',
                                    'phan_cong' => 'Phân công',
                                    'lich_khoi_hanh' => 'Lịch khởi hành',
                                    'gop_doan' => 'Gộp đoàn',
                                    'payments' => 'Thanh toán',
                                    'reports' => 'Báo cáo',
                                    'customers' => 'Khách hàng',
                                    'lich_trinh_tours' => 'Lịch trình tour',
                                    'chi_tiet_lich_trinhs' => 'Chi tiết lịch trình',
                                    'nhat_ky_tours' => 'Nhật ký tour',
                                    'reviews' => 'Đánh giá',
                                    'terms' => 'Điều khoản',
                                    'favorites' => 'Tour yêu thích',
                                    'system' => 'Hệ thống',
                                ];

                                $moduleIcons = [
                                    'users' => 'fa-user',
                                    'roles' => 'fa-user-tag',
                                    'permissions' => 'fa-key',
                                    'tours' => 'fa-map-marked-alt',
                                    'bookings' => 'fa-calendar-check',
                                    'guides' => 'fa-users',
                                    'banners' => 'fa-image',
                                    'danh_mucs' => 'fa-tags',
                                    'phuong_tiens' => 'fa-bus',
                                    'phan_cong' => 'fa-user-friends',
                                    'lich_khoi_hanh' => 'fa-plane-departure',
                                    'gop_doan' => 'fa-object-group',
                                    'payments' => 'fa-credit-card',
                                    'reports' => 'fa-chart-bar',
                                    'customers' => 'fa-user-check',
                                    'lich_trinh_tours' => 'fa-calendar-alt',
                                    'chi_tiet_lich_trinhs' => 'fa-list',
                                    'nhat_ky_tours' => 'fa-book',
                                    'reviews' => 'fa-star',
                                    'terms' => 'fa-file-contract',
                                    'favorites' => 'fa-heart',
                                    'system' => 'fa-gear',
                                ];

                                $moduleLabel = $moduleNames[$moduleKey] ?? ucfirst(str_replace('_', ' ', $moduleKey));
                                $moduleIcon = $moduleIcons[$moduleKey] ?? 'fa-folder';
                                $groupId = 'module_' . md5($moduleKey);
                            @endphp

                            <tr class="module-row">
                                <td colspan="{{ count($vaiTros) + 1 }}">
                                    <button type="button" class="module-toggle collapsed" data-target="{{ $groupId }}">
                                        <span class="module-left">
                                            <span class="module-icon">
                                                <i class="fas {{ $moduleIcon }}"></i>
                                            </span>

                                            <span class="module-info">
                                                <span class="module-name">{{ $moduleLabel }}</span>
                                                <span class="module-count">{{ count($permissions) }} quyền</span>
                                            </span>
                                        </span>

                                        <span class="module-arrow">
                                            <i class="fas fa-chevron-down"></i>
                                        </span>
                                    </button>
                                </td>
                            </tr>

                            @foreach($permissions as $permission)
                                <tr class="permission-row {{ $groupId }} is-hidden">
                                    <td>
                                        <div class="permission-title">
                                            {{ $permission->ten_hien_thi }}
                                        </div>

                                        <div class="permission-code">
                                            {{ $permission->ten }}
                                        </div>

                                        <div class="permission-module">
                                            {{ $moduleLabel }}
                                        </div>
                                    </td>

                                    @foreach($vaiTros as $vaiTro)
                                        <td>
                                            <div class="permission-checkbox">
                                                <input
                                                    type="checkbox"
                                                    name="role_permissions[{{ $vaiTro->id }}][]"
                                                    value="{{ $permission->id }}"
                                                    {{ in_array($permission->id, $rolePermissions[$vaiTro->id] ?? []) ? 'checked' : '' }}
                                                >
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="{{ count($vaiTros) + 1 }}">
                                    Chưa có quyền hạn nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                {{ $quyenHans->withQueryString()->links() }}
            </div>

            <div class="matrix-footer">
                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-icon">{{ count($vaiTros) }}</div>
                        <span>Vai trò</span>
                    </div>

                    <div class="stat-item">
                        <div class="stat-icon">{{ $quyenHans->total() }}</div>
                        <span>Quyền</span>
                    </div>

                    <div class="stat-item">
                        <div class="stat-icon">{{ $quyenHans->currentPage() }}/{{ $quyenHans->lastPage() }}</div>
                        <span>Trang</span>
                    </div>
                </div>

                <div class="matrix-actions">
                    <a href="{{ route('Admin.vai-tros.index') }}" class="btn btn-secondary">
                        Quản lý vai trò
                    </a>

                    <button type="submit" class="btn-save">
                        Lưu thay đổi
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.module-toggle').forEach(function (button) {
                button.addEventListener('click', function () {
                    const target = this.dataset.target;
                    const rows = document.querySelectorAll('.' + target);

                    rows.forEach(function (row) {
                        row.classList.toggle('is-hidden');
                    });

                    this.classList.toggle('collapsed');
                });
            });
        });
    </script>
</div>
@endsection
