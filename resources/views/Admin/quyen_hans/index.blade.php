@extends('layouts.admin')
@section('content')
@php $currentUser = auth()->user(); @endphp
<style>
    .permission-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .permission-header {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 24px;
    }

    .permission-header h3 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
    }

    .permission-table {
        margin-bottom: 0;
    }

    .permission-table thead th {
        background: #f3f4f6;
        font-weight: 600;
        color: #374151;
        border-bottom: 2px solid #e5e7eb;
    }

    .permission-table tbody tr:hover {
        background: #f9fafb;
    }

    .module-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 4px;
        background: #fef3c7;
        color: #92400e;
        font-size: 12px;
        font-weight: 600;
    }

    .status-active {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        background: #d1fae5;
        color: #065f46;
        font-size: 12px;
        font-weight: 600;
    }

    .status-inactive {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        background: #fee2e2;
        color: #7f1d1d;
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
        background: #f59e0b;
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
        background: #d97706;
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
            <h3 style="margin: 0;">Danh sách quyền hạn</h3>
            <p style="margin: 4px 0 0 0; color: #6b7280; font-size: 14px;">Quản lý các quyền hạn trong hệ thống</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ route('Admin.role-permissions.matrix') }}" class="btn-matrix">📊 Bảng phân quyền</a>
            @if($currentUser && $currentUser->hasPermission('permissions.create'))
                <a href="{{ route('Admin.quyen-hans.create') }}" class="btn-primary-custom">+ Thêm quyền</a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card permission-card">
        <div class="permission-header">
            <h5 style="margin: 0; font-size: 14px; opacity: 0.9;">Tổng số quyền: <strong>{{ $quyenHans->total() }}</strong></h5>
        </div>

        <div class="table-responsive">
            <table class="table permission-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th style="width: 140px;">Tên kỹ thuật</th>
                        <th style="width: 160px;">Tên hiển thị</th>
                        <th style="width: 100px;">Mô đun</th>
                        <th>Mô tả</th>
                        <th style="width: 100px;">Trạng thái</th>
                        <th style="width: 200px;">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quyenHans as $quyenHan)
                        <tr>
                            <td><strong>{{ $quyenHan->id }}</strong></td>
                            <td>
                                <code style="background: #f3f4f6; padding: 2px 6px; border-radius: 4px; font-size: 12px;">{{ $quyenHan->ten }}</code>
                            </td>
                            <td><strong>{{ $quyenHan->ten_hien_thi }}</strong></td>
                            <td>
                                @if($quyenHan->mo_dun)
                                    <span class="module-badge">{{ $quyenHan->mo_dun }}</span>
                                @else
                                    <span style="color: #9ca3af; font-size: 13px;">-</span>
                                @endif
                            </td>
                            <td>{{ $quyenHan->mo_ta ?? '-' }}</td>
                            <td>
                                @if($quyenHan->trang_thai)
                                    <span class="status-active">✓ Kích hoạt</span>
                                @else
                                    <span class="status-inactive">✕ Tắt</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('Admin.quyen-hans.show', $quyenHan->id) }}" class="btn-view">Xem</a>
                                    @if($currentUser && $currentUser->hasPermission('permissions.edit'))
                                        <a href="{{ route('Admin.quyen-hans.edit', $quyenHan->id) }}" class="btn-edit">Sửa</a>
                                    @endif
                                    @if($currentUser && $currentUser->hasPermission('permissions.delete'))
                                        <form action="{{ route('Admin.quyen-hans.destroy', $quyenHan->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Bạn có chắc muốn xóa quyền này?');">
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
                            <td colspan="7" style="text-align: center; padding: 40px; color: #9ca3af;">
                                <i class="fas fa-inbox" style="font-size: 32px; margin-bottom: 12px; display: block;"></i>
                                Không có quyền nào. <a href="{{ route('Admin.quyen-hans.create') }}" style="color: #f59e0b; text-decoration: none;">Tạo quyền mới</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="padding: 20px; border-top: 1px solid #e5e7eb;">
            {{ $quyenHans->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
