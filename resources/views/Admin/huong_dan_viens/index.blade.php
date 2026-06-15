@extends('layouts.admin')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>Quản lý hướng dẫn viên</h3>
            <a href="{{ route('Admin.huong-dan-viens.create') }}" class="btn btn-primary">Thêm hướng dẫn viên</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Điện thoại</th>
                        <th>Kinh nghiệm</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($guides as $guide)
                        <tr>
                            <td>{{ $guide->id }}</td>
                            <td>{{ $guide->ho_ten }}</td>
                            <td>{{ $guide->email }}</td>
                            <td>{{ $guide->so_dien_thoai }}</td>
                            <td>{{ $guide->so_nam_kinh_nghiem }} Năm</td>
                            <td>
                                <span
                                    class="status-badge {{ $guide->trang_thai == 'hoat_dong' ? 'status-active' : ($guide->trang_thai == 'bi_khoa' ? 'status-locked' : 'status-inactive') }}">
                                    {{ $guide->trang_thai == 'hoat_dong'
                                        ? 'Hoạt động'
                                        : ($guide->trang_thai == 'khong_hoat_dong'
                                            ? 'Không hoạt động'
                                            : 'Bị khóa') }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('Admin.huong-dan-viens.show', $guide->id) }}"
                                    class="btn btn-sm btn-info">Xem</a>
                                <a href="{{ route('Admin.huong-dan-viens.edit', $guide->id) }}"
                                    class="btn btn-sm btn-secondary">Sửa</a>
                                <form action="{{ route('Admin.huong-dan-viens.destroy', $guide->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Xóa hướng dẫn viên này?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Chưa có hướng dẫn viên nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $guides->links() }}
    </div>
    <style>
        /* Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .page-title {
            font-size: 28px;
            font-weight: 800;
            color: #111827;
        }

        .btn-add-guide {
            background: linear-gradient(135deg, #2563eb, #4f46e5);
            border: none;
            color: white;
            padding: 12px 18px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: .3s;
        }

        .btn-add-guide:hover {
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 10px 20px rgba(37, 99, 235, .25);
        }

        /* Card */
        .guide-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 35px rgba(15, 23, 42, .08);
            border: 1px solid #e5e7eb;
        }

        /* Table */
        .guide-table {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        .guide-table thead th {
            border: none;
            background: transparent;
            color: #6b7280;
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 700;
            padding-bottom: 15px;
        }

        .guide-table tbody tr {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .04);
            transition: .25s;
        }

        .guide-table tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
        }

        .guide-table tbody td {
            vertical-align: middle;
            border-top: 1px solid #eef2f7;
            border-bottom: 1px solid #eef2f7;
            padding: 16px;
        }

        .guide-table tbody td:first-child {
            border-left: 1px solid #eef2f7;
            border-radius: 12px 0 0 12px;
        }

        .guide-table tbody td:last-child {
            border-right: 1px solid #eef2f7;
            border-radius: 0 12px 12px 0;
        }

        /* Avatar */
        .guide-user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .guide-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* Status */
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-active {
            background: #dcfce7;
            color: #15803d;
        }

        .status-inactive {
            background: #fee2e2;
            color: #dc2626;
        }

        /* Buttons */
        .action-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            margin-right: 5px;
            transition: .25s;
        }

        .btn-view {
            background: #dbeafe;
            color: #2563eb;
        }

        .btn-edit {
            background: #fef3c7;
            color: #d97706;
        }

        .btn-delete {
            background: #fee2e2;
            color: #dc2626;
        }

        .action-btn:hover {
            transform: scale(1.08);
        }

        /* Alert */
        .alert-success {
            border: none;
            border-radius: 12px;
            background: #dcfce7;
            color: #166534;
            font-weight: 600;
        }

        /* Pagination */
        .pagination {
            justify-content: center;
            margin-top: 25px;
        }
    </style>
@endsection
