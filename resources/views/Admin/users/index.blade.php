@extends('layouts.admin')

@section('content')
    <style>
        .user-management {
            padding: 24px 0;
        }

        .user-card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .user-card-header {
            background: linear-gradient(135deg, #0d6efd, #5b9dff);
            color: #fff;
            padding: 18px 24px;
        }

        .user-card-header h3 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
        }

        .user-card-body {
            padding: 24px;
            background: #fff;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .user-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 0;
        }

        .user-table th,
        .user-table td {
            vertical-align: middle;
            text-align: center;
            padding: 14px 12px;
            font-size: 14px;
            white-space: nowrap;
        }

        .user-table thead th {
            background: #f1f5f9;
            color: #334155;
            font-weight: 700;
            border-bottom: 1px solid #dee2e6;
        }

        .user-table tbody td {
            border-bottom: 1px solid #edf2f7;
            color: #334155;
        }

        .user-table tbody tr:hover {
            background: #f8fbff;
            transition: 0.2s;
        }

        .user-table th:nth-child(1),
        .user-table td:nth-child(1) {
            width: 70px;
        }

        .user-table th:nth-child(2),
        .user-table td:nth-child(2) {
            width: 180px;
            text-align: left;
        }

        .user-table th:nth-child(3),
        .user-table td:nth-child(3) {
            width: 260px;
            text-align: left;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-table th:nth-child(4),
        .user-table td:nth-child(4) {
            width: 150px;
        }

        .user-table th:nth-child(5),
        .user-table td:nth-child(5) {
            width: 140px;
        }

        .user-table th:nth-child(6),
        .user-table td:nth-child(6) {
            width: 230px;
        }

        .role-badge {
            display: inline-block;
            min-width: 90px;
            padding: 6px 12px;
            border-radius: 999px;
            background: #e7f1ff;
            color: #0d6efd;
            font-size: 13px;
            font-weight: 700;
        }

        .action-btns {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            flex-wrap: nowrap;
        }

        .action-btns form {
            margin: 0;
        }

        .action-btns .btn {
            min-width: 62px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        .alert {
            border-radius: 10px;
            margin-bottom: 18px;
        }

        .pagination {
            justify-content: center;
            margin-top: 22px;
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .user-card-body {
                padding: 16px;
            }

            .user-table {
                min-width: 950px;
            }
        }
    </style>

    <div class="container user-management">
        <div class="card user-card">
            <div class="user-card-header">
                <h3>Quản lý người dùng</h3>
            </div>

            <div class="user-card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

@php $currentUser = auth()->user(); @endphp
        <div class="table-wrapper">
                    <table class="table user-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Điện thoại</th>
                                <th>Loại</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <strong>{{ $user->id }}</strong>
                                    </td>

                                    <td>
                                        <strong>{{ $user->name }}</strong>
                                    </td>

                                    <td title="{{ $user->email }}">
                                        {{ $user->email }}
                                    </td>

                                    <td>
                                        {{ $user->phone }}
                                    </td>

                                    <td>
                                        <span class="role-badge">
                                            {{ $user->vaiTros->pluck('ten_vai_tro')->join(', ') ?: 'Chưa có vai trò' }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="action-btns">
                                            <a class="btn btn-sm btn-info text-white"
                                                href="{{ route('Admin.users.show', $user->id) }}">
                                                Xem
                                            </a>

                                            @if($currentUser && $currentUser->hasPermission('users.edit'))
                                                <a class="btn btn-sm btn-secondary"
                                                    href="{{ route('Admin.users.edit', $user->id) }}">
                                                    Sửa
                                                </a>
                                            @endif

                                            @if($currentUser && $currentUser->hasPermission('users.delete'))
                                                <form action="{{ route('Admin.users.destroy', $user->id) }}" method="POST"
                                                    onsubmit="return confirm('Xóa tài khoản này?')">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Xóa
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
