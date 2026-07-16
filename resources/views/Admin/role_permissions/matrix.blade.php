@extends('layouts.admin')

@section('content')
<div class="container-fluid permission-matrix-page">
    <style>

        :root {
            --pm-primary: #2563eb;
            --pm-primary-dark: #1d4ed8;
            --pm-primary-soft: #eff6ff;
            --pm-indigo: #4f46e5;
            --pm-cyan: #06b6d4;
            --pm-success: #10b981;
            --pm-warning: #f59e0b;
            --pm-danger: #ef4444;
            --pm-text: #0f172a;
            --pm-muted: #64748b;
            --pm-border: #e2e8f0;
            --pm-surface: #ffffff;
            --pm-surface-soft: #f8fafc;
            --pm-shadow: 0 18px 50px rgba(15, 23, 42, .10);
            --pm-shadow-soft: 0 8px 24px rgba(15, 23, 42, .08);
            --pm-radius: 18px;
        }

        .permission-matrix-page {
            padding: 28px 0 36px;
            color: var(--pm-text);
        }

        .permission-matrix-container {
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(148, 163, 184, .22);
            border-radius: 22px;
            background: var(--pm-surface);
            box-shadow: var(--pm-shadow);
        }

        .permission-matrix-container::before {
            content: "";
            position: absolute;
            inset: 0 0 auto;
            height: 4px;
            background: linear-gradient(90deg, var(--pm-primary), var(--pm-indigo), var(--pm-cyan));
            z-index: 2;
        }

        .matrix-header {
            position: relative;
            overflow: hidden;
            padding: 28px 30px 30px;
            background:
                radial-gradient(circle at 85% 15%, rgba(255,255,255,.18), transparent 26%),
                linear-gradient(135deg, #1d4ed8 0%, #2563eb 48%, #4f46e5 100%);
            color: #fff;
        }

        .matrix-header::after {
            content: "";
            position: absolute;
            right: -70px;
            bottom: -90px;
            width: 260px;
            height: 260px;
            border-radius: 50%;
            border: 36px solid rgba(255,255,255,.08);
        }

        .matrix-header h3 {
            position: relative;
            z-index: 1;
            margin: 0;
            font-size: clamp(22px, 2vw, 30px);
            font-weight: 800;
            letter-spacing: -.02em;
        }

        .matrix-header p {
            position: relative;
            z-index: 1;
            max-width: 780px;
            margin: 9px 0 0;
            color: rgba(255,255,255,.88);
            font-size: 14px;
            line-height: 1.7;
        }

        .role-summary-grid {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 14px;
            margin-top: 22px;
        }

        .role-summary-card {
            padding: 16px;
            border: 1px solid rgba(255,255,255,.20);
            border-radius: 16px;
            background: rgba(255,255,255,.13);
            backdrop-filter: blur(10px);
            box-shadow: inset 0 1px 0 rgba(255,255,255,.14);
        }

        .role-summary-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .role-summary-name {
            overflow: hidden;
            font-size: 13px;
            font-weight: 800;
            text-overflow: ellipsis;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .role-summary-number {
            font-size: 13px;
            font-weight: 800;
        }

        .role-summary-progress {
            height: 8px;
            margin-top: 12px;
            overflow: hidden;
            border-radius: 999px;
            background: rgba(255,255,255,.22);
        }

        .role-summary-progress span {
            display: block;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #fff, #bfdbfe);
            box-shadow: 0 0 14px rgba(255,255,255,.45);
        }

        .role-summary-meta {
            margin-top: 8px;
            color: rgba(255,255,255,.78);
            font-size: 12px;
            font-weight: 600;
        }

        .table-wrapper {
            overflow-x: auto;
            padding: 26px;
            background:
                linear-gradient(180deg, #fff, #fbfdff);
        }

        .permission-matrix {
            width: 100%;
            min-width: 980px;
            margin: 0;
            overflow: hidden;
            border: 1px solid var(--pm-border);
            border-collapse: separate;
            border-spacing: 0;
            border-radius: 16px;
            background: #fff;
            box-shadow: var(--pm-shadow-soft);
        }

        .permission-matrix th,
        .permission-matrix td {
            padding: 15px 14px;
            border-right: 1px solid var(--pm-border);
            border-bottom: 1px solid var(--pm-border);
            text-align: center;
            vertical-align: middle;
            font-size: 14px;
        }

        .permission-matrix th:last-child,
        .permission-matrix td:last-child {
            border-right: 0;
        }

        .permission-matrix tbody tr:last-child td {
            border-bottom: 0;
        }

        .permission-matrix thead th {
            position: sticky;
            top: 0;
            z-index: 7;
            background: linear-gradient(180deg, #f8fafc, #f1f5f9);
            color: #334155;
            font-size: 13px;
            font-weight: 800;
            white-space: nowrap;
        }

        .permission-matrix th:first-child,
        .permission-matrix tbody td:first-child {
            position: sticky;
            left: 0;
            min-width: 300px;
            max-width: 360px;
            text-align: left;
        }

        .permission-matrix th:first-child {
            z-index: 10;
            background: linear-gradient(180deg, #f8fafc, #f1f5f9);
        }

        .permission-matrix tbody td:first-child {
            z-index: 4;
            background: #fff;
        }

        .permission-matrix tbody tr.permission-row {
            transition: background .18s ease, transform .18s ease;
        }

        .permission-matrix tbody tr.permission-row:hover {
            background: #f8fbff;
        }

        .permission-matrix tbody tr.permission-row:hover td:first-child {
            background: #f8fbff;
        }

        .module-row td {
            padding: 0 !important;
            background: #eef6ff !important;
        }

        .module-toggle {
            display: flex;
            width: 100%;
            align-items: center;
            justify-content: space-between;
            padding: 16px 18px;
            border: 0;
            background:
                linear-gradient(135deg, #eff6ff 0%, #dbeafe 62%, #e0e7ff 100%);
            color: #1e3a8a;
            font-size: 15px;
            font-weight: 800;
            text-align: left;
            cursor: pointer;
            transition: .22s ease;
        }

        .module-toggle:hover {
            background:
                linear-gradient(135deg, #dbeafe 0%, #bfdbfe 60%, #c7d2fe 100%);
        }

        .module-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .module-icon {
            display: flex;
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: linear-gradient(135deg, var(--pm-primary), var(--pm-indigo));
            color: #fff;
            box-shadow: 0 8px 18px rgba(37, 99, 235, .25);
        }

        .module-info {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .module-name {
            letter-spacing: .035em;
            text-transform: uppercase;
        }

        .module-count {
            padding: 4px 10px;
            border: 1px solid #bfdbfe;
            border-radius: 999px;
            background: rgba(255,255,255,.88);
            color: var(--pm-primary);
            font-size: 12px;
            font-weight: 800;
        }

        .module-arrow {
            display: flex;
            width: 30px;
            height: 30px;
            align-items: center;
            justify-content: center;
            border-radius: 9px;
            background: rgba(255,255,255,.65);
            transition: transform .22s ease;
        }

        .module-toggle.collapsed .module-arrow {
            transform: rotate(-90deg);
        }

        .permission-row.is-hidden {
            display: none;
        }

        .permission-title {
            margin-bottom: 5px;
            color: #1e293b;
            font-weight: 800;
        }

        .permission-code {
            display: inline-flex;
            margin-top: 3px;
            padding: 4px 9px;
            border: 1px solid #bfdbfe;
            border-radius: 999px;
            background: #eff6ff;
            color: var(--pm-primary-dark);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .02em;
        }

        .permission-module {
            margin-top: 6px;
            color: var(--pm-muted);
            font-size: 12px;
        }

        .role-header {
            min-width: 130px;
            text-align: center;
        }

        .role-header-name {
            color: #0f172a;
            font-size: 13px;
            font-weight: 800;
            text-transform: capitalize;
        }

        .role-header-count {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 7px;
            padding: 5px 9px;
            border: 1px solid #bfdbfe;
            border-radius: 999px;
            background: #eff6ff;
            color: var(--pm-primary-dark);
            font-size: 11px;
            font-weight: 800;
        }

        .permission-checkbox {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .permission-checkbox input[type="checkbox"] {
            width: 22px;
            height: 22px;
            border-radius: 6px;
            accent-color: var(--pm-primary);
            cursor: pointer;
            transition: transform .15s ease;
        }

        .permission-checkbox input[type="checkbox"]:hover {
            transform: scale(1.08);
        }

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            padding: 0 24px 22px;
        }

        .pagination-wrapper .pagination {
            margin-bottom: 0;
        }

        .matrix-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            flex-wrap: wrap;
            padding: 20px 26px;
            border-top: 1px solid var(--pm-border);
            background: linear-gradient(180deg, #f8fafc, #f1f5f9);
        }

        .stats {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .stat-item {
            display: flex;
            min-height: 42px;
            align-items: center;
            gap: 9px;
            padding: 7px 12px;
            border: 1px solid var(--pm-border);
            border-radius: 999px;
            background: #fff;
            color: #475569;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(15,23,42,.04);
        }

        .stat-icon {
            display: flex;
            min-width: 28px;
            height: 28px;
            align-items: center;
            justify-content: center;
            padding: 0 8px;
            border-radius: 999px;
            background: linear-gradient(135deg, #dbeafe, #e0e7ff);
            color: var(--pm-primary-dark);
            font-size: 12px;
            font-weight: 900;
        }

        .matrix-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .matrix-actions .btn,
        .btn-save {
            min-width: 145px;
            min-height: 44px;
            justify-content: center;
            border-radius: 11px;
            font-weight: 700;
            padding: 10px 17px;
            transition: .22s ease;
        }

        .btn-save {
            border: 0;
            background: linear-gradient(135deg, var(--pm-primary), var(--pm-indigo));
            color: #fff;
            box-shadow: 0 10px 22px rgba(37,99,235,.24);
        }

        .btn-save:hover {
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 14px 28px rgba(37,99,235,.30);
        }

        .alert-container {
            margin-bottom: 18px;
        }

        .alert {
            border: 0;
            border-radius: 14px;
            box-shadow: var(--pm-shadow-soft);
        }

        @media (max-width: 992px) {
            .matrix-header,
            .table-wrapper {
                padding-inline: 18px;
            }

            .role-summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .matrix-footer {
                align-items: stretch;
            }
        }

        @media (max-width: 640px) {
            .permission-matrix-page {
                padding-top: 14px;
            }

            .permission-matrix-container {
                border-radius: 16px;
            }

            .matrix-header {
                padding: 22px 16px 24px;
            }

            .role-summary-grid {
                grid-template-columns: 1fr;
            }

            .table-wrapper {
                padding: 14px;
            }

            .matrix-footer {
                padding: 16px;
            }

            .stats,
            .matrix-actions {
                width: 100%;
            }

            .matrix-actions {
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

            <div class="role-summary-grid">
                @foreach($vaiTros as $vaiTro)
                    @php
                        $assignedCount = count($rolePermissions[$vaiTro->id] ?? []);
                        $totalCount = max(1, $quyenHans->total());
                        $assignedPercent = min(100, round(($assignedCount / $totalCount) * 100));
                    @endphp

                    <div class="role-summary-card">
                        <div class="role-summary-top">
                            <div class="role-summary-name">{{ $vaiTro->ten_vai_tro }}</div>
                            <div class="role-summary-number">{{ $assignedCount }}/{{ $quyenHans->total() }}</div>
                        </div>

                        <div class="role-summary-progress">
                            <span style="width: {{ $assignedPercent }}%"></span>
                        </div>

                        <div class="role-summary-meta">
                            Đã cấp {{ $assignedPercent }}% tổng quyền
                        </div>
                    </div>
                @endforeach
            </div>

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
                                    @php
                                        $assignedCount = count($rolePermissions[$vaiTro->id] ?? []);
                                    @endphp

                                    <div class="role-header">
                                        <div class="role-header-name">
                                            {{ $vaiTro->ten_vai_tro }}
                                        </div>

                                        <div class="role-header-count">
                                            <i class="fas fa-shield-halved"></i>
                                            {{ $assignedCount }}/{{ $quyenHans->total() }} quyền
                                        </div>
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

                    @foreach($vaiTros as $vaiTro)
                        <div class="stat-item">
                            <div class="stat-icon">
                                {{ count($rolePermissions[$vaiTro->id] ?? []) }}
                            </div>
                            <span>{{ $vaiTro->ten_vai_tro }}</span>
                        </div>
                    @endforeach

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
