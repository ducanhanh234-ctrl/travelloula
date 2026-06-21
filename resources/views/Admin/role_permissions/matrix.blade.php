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

        .permission-matrix tbody tr:hover {
            background: #f8fbff;
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

        .permission-matrix tbody tr:hover td:first-child {
            background: #f8fbff;
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
            <p>Quản lý quyền hạn cho từng vai trò. Tích chọn ô để gán quyền cho vai trò tương ứng.</p>
        </div>

        <form method="POST" action="{{ route('Admin.role-permissions.update-matrix') }}">
            @csrf

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
                        @foreach($quyenHans->groupBy('mo_dun') as $module => $permissions)
                            @foreach($permissions as $permission)
                                <tr>
                                    <td>
                                        <div class="permission-title">
                                            {{ $permission->ten_hien_thi }}
                                        </div>

                                        <div class="permission-code">
                                            {{ $permission->ten }}
                                        </div>

                                        <div class="permission-module">
                                            {{ $module ?: 'System' }}
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
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="matrix-footer">
                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-icon">{{ count($vaiTros) }}</div>
                        <span>Vai trò</span>
                    </div>

                    <div class="stat-item">
                        <div class="stat-icon">{{ count($quyenHans) }}</div>
                        <span>Quyền</span>
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
</div>
@endsection
