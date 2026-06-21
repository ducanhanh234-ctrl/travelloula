@extends('layouts.admin')
@section('content')
@php $currentUser = auth()->user(); @endphp
<style>
    .role-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .role-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 24px;
    }

    .role-header h3 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
    }

    .role-table {
        margin-bottom: 0;
    }

    .role-table thead th {
        background: #f3f4f6;
        font-weight: 600;
        color: #374151;
        border-bottom: 2px solid #e5e7eb;
    }

    .role-table tbody tr:hover {
        background: #f9fafb;
    }

    .permission-list {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .permission-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        background: #dbeafe;
        color: #0c63e4;
        font-size: 12px;
        font-weight: 600;
    }

    .action-buttons {
        display: flex;
        gap: 6px;
    }

    .action-buttons form {
        margin: 0;
    }

    .btn-view {
        background: #3b82f6;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .btn-view:hover {
        background: #2563eb;
    }

    .btn-edit {
        background: #f59e0b;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .btn-edit:hover {
        background: #d97706;
    }

    .btn-delete {
        background: #ef4444;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-delete:hover {
        background: #dc2626;
    }

    .top-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        gap: 12px;
    }

    .btn-primary-custom {
        background: #667eea;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary-custom:hover {
        background: #5568d3;
    }

    .btn-matrix {
        background: #10b981;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .btn-matrix:hover {
        background: #059669;
    }
</style>

<div class="container-fluid py-4">
    <div class="top-actions">
        <div>
            <h3 style="margin: 0;">Danh sách vai trò</h3>
            <p style="margin: 4px 0 0 0; color: #6b7280; font-size: 14px;">Quản lý các vai trò trong hệ thống</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('Admin.role-permissions.matrix') }}" class="btn-matrix">📊 Bảng phân quyền</a>
            @if($currentUser && $currentUser->hasPermission('roles.create'))
                <a href="{{ route('Admin.vai-tros.create') }}" class="btn-primary-custom">+ Thêm vai trò</a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card role-card">
        <div class="role-header">
            <h5 style="margin: 0; font-size: 14px; opacity: 0.9;">Tổng số vai trò: <strong>{{ $vaiTros->total() }}</strong></h5>
        </div>

        <div class="table-responsive">
            <table class="table role-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th style="width: 150px;">Tên vai trò</th>
                        <th>Mô tả</th>
                        <th style="width: 300px;">Quyền</th>
                        <th style="width: 200px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vaiTros as $vaiTro)
                        <tr>
                            <td><strong>{{ $vaiTro->id }}</strong></td>
                            <td>
                                <strong style="color: #667eea;">{{ $vaiTro->ten_vai_tro }}</strong>
                            </td>
                            <td>{{ $vaiTro->mo_ta ?? '-' }}</td>
                            <td>
                                @if($vaiTro->quyenHans->isEmpty())
                                    <span style="color: #9ca3af; font-size: 13px;">Không có quyền</span>
                                @else
                                    <div class="permission-list">
                                        @foreach($vaiTro->quyenHans->take(3) as $quyenHan)
                                            <span class="permission-badge">{{ $quyenHan->ten_hien_thi }}</span>
                                        @endforeach
                                        @if($vaiTro->quyenHans->count() > 3)
                                            <span class="permission-badge" title="Và {{ $vaiTro->quyenHans->count() - 3 }} quyền khác">+{{ $vaiTro->quyenHans->count() - 3 }}</span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('Admin.vai-tros.show', $vaiTro->id) }}" class="btn-view">Xem</a>
                                    @if($currentUser && $currentUser->hasPermission('roles.edit'))
                                        <a href="{{ route('Admin.vai-tros.edit', $vaiTro->id) }}" class="btn-edit">Sửa</a>
                                    @endif
                                    @if($currentUser && $currentUser->hasPermission('roles.delete'))
                                        <form action="{{ route('Admin.vai-tros.destroy', $vaiTro->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn xóa vai trò này?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Xóa</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px; color: #9ca3af;">
                                <i class="fas fa-inbox" style="font-size: 32px; margin-bottom: 12px; display: block;"></i>
                                Không có vai trò nào. <a href="{{ route('Admin.vai-tros.create') }}" style="color: #667eea; text-decoration: none;">Tạo vai trò mới</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 20px; border-top: 1px solid #e5e7eb;">
            {{ $vaiTros->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
