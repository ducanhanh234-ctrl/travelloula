@extends('layouts.admin')

@section('content')
@php $currentUser = auth()->user(); @endphp

<div class="container guide-management">
    <div class="page-header">
        <h3 class="page-title">Quản lý hướng dẫn viên</h3>

        @if($currentUser && $currentUser->hasPermission('guides.create'))
            <a href="{{ route('Admin.huong-dan-viens.create') }}" class="btn-add-guide">
                Thêm hướng dẫn viên
            </a>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="guide-card">
        <div class="filter-box">
            <form method="GET" action="{{ route('Admin.huong-dan-viens.index') }}" class="filter-form">
                <div>
                    <label for="keyword">Tìm kiếm</label>
                    <input
                        type="text"
                        id="keyword"
                        name="keyword"
                        class="form-control"
                        value="{{ request('keyword') }}"
                        placeholder="Nhập họ tên, email hoặc điện thoại..."
                    >
                </div>

                <div>
                    <label for="trang_thai">Trạng thái</label>
                    <select name="trang_thai" id="trang_thai" class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="hoat_dong" {{ request('trang_thai') == 'hoat_dong' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="san_sang" {{ request('trang_thai') == 'san_sang' ? 'selected' : '' }}>Sẵn sàng</option>
                        <option value="dang_dan_tour" {{ request('trang_thai') == 'dang_dan_tour' ? 'selected' : '' }}>Đang dẫn tour</option>
                        <option value="khong_hoat_dong" {{ request('trang_thai') == 'khong_hoat_dong' ? 'selected' : '' }}>Không hoạt động</option>
                        <option value="bi_khoa" {{ request('trang_thai') == 'bi_khoa' ? 'selected' : '' }}>Bị khóa</option>
                        <option value="nghi_viec" {{ request('trang_thai') == 'nghi_viec' ? 'selected' : '' }}>Nghỉ việc</option>
                    </select>
                </div>

                <div>
                    <label for="kinh_nghiem">Kinh nghiệm</label>
                    <select name="kinh_nghiem" id="kinh_nghiem" class="form-select">
                        <option value="">Tất cả kinh nghiệm</option>
                        <option value="0_1" {{ request('kinh_nghiem') == '0_1' ? 'selected' : '' }}>0 - 1 năm</option>
                        <option value="2_5" {{ request('kinh_nghiem') == '2_5' ? 'selected' : '' }}>2 - 5 năm</option>
                        <option value="6_plus" {{ request('kinh_nghiem') == '6_plus' ? 'selected' : '' }}>Từ 6 năm</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Lọc</button>

                <a href="{{ route('Admin.huong-dan-viens.index') }}" class="btn btn-secondary">
                    Đặt lại
                </a>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table guide-table">
                <thead>
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
                            <td>
                                <strong>{{ $guide->id }}</strong>
                            </td>

                            <td>
                                <div class="guide-user">
                                    <div class="guide-avatar">
                                        {{ strtoupper(mb_substr($guide->ho_ten, 0, 1)) }}
                                    </div>

                                    <div>
                                        <strong>{{ $guide->ho_ten }}</strong>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $guide->email }}</td>

                            <td>{{ $guide->so_dien_thoai }}</td>

                            <td>{{ $guide->so_nam_kinh_nghiem }} năm</td>

                            <td>
                                <span class="status-badge
                                    @switch($guide->trang_thai)
                                        @case('hoat_dong')
                                        @case('san_sang')
                                            status-active
                                            @break

                                        @case('dang_dan_tour')
                                            status-assigned
                                            @break

                                        @case('khong_hoat_dong')
                                            status-inactive
                                            @break

                                        @case('bi_khoa')
                                        @case('nghi_viec')
                                            status-locked
                                            @break

                                        @default
                                            status-inactive
                                    @endswitch
                                ">
                                    @switch($guide->trang_thai)
                                        @case('hoat_dong')
                                            Hoạt động
                                            @break

                                        @case('san_sang')
                                            Sẵn sàng
                                            @break

                                        @case('dang_dan_tour')
                                            Đang dẫn tour
                                            @break

                                        @case('khong_hoat_dong')
                                            Không hoạt động
                                            @break

                                        @case('bi_khoa')
                                            Bị khóa
                                            @break

                                        @case('nghi_viec')
                                            Nghỉ việc
                                            @break

                                        @default
                                            Không xác định
                                    @endswitch
                                </span>
                            </td>

                            <td>
                                <div class="action-buttons">
                                    @if($currentUser && $currentUser->hasPermission('guides.view'))
                                        <a href="{{ route('Admin.huong-dan-viens.show', $guide->id) }}"
                                           class="btn btn-sm btn-info text-white">
                                            Xem
                                        </a>
                                    @endif

                                    @if($currentUser && $currentUser->hasPermission('guides.edit'))
                                        <a href="{{ route('Admin.huong-dan-viens.edit', $guide->id) }}"
                                           class="btn btn-sm btn-secondary">
                                            Sửa
                                        </a>
                                    @endif

                                    @if($currentUser && $currentUser->hasPermission('guides.delete'))
                                        <form action="{{ route('Admin.huong-dan-viens.destroy', $guide->id) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Xóa hướng dẫn viên này?');">
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
                    @empty
                        <tr>
                            <td colspan="7" class="text-center empty-row">
                                Không tìm thấy hướng dẫn viên phù hợp.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $guides->withQueryString()->links() }}
        </div>
    </div>
</div>

<style>
    .guide-management {
        padding: 24px 0;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 16px;
        flex-wrap: wrap;
    }

    .page-title {
        font-size: 28px;
        font-weight: 800;
        color: #111827;
        margin: 0;
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

    .guide-card {
        background: white;
        border-radius: 20px;
        padding: 20px;
        box-shadow: 0 10px 35px rgba(15, 23, 42, .08);
        border: 1px solid #e5e7eb;
    }

    .filter-box {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 16px;
        margin-bottom: 20px;
    }

    .filter-form {
        display: grid;
        grid-template-columns: 1fr 200px 200px auto auto;
        gap: 12px;
        align-items: end;
    }

    .filter-form label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 6px;
    }

    .filter-form .form-control,
    .filter-form .form-select {
        border-radius: 10px;
        min-height: 40px;
        font-size: 14px;
    }

    .filter-form .btn {
        min-height: 40px;
        border-radius: 10px;
        font-weight: 600;
        white-space: nowrap;
    }

    .guide-table {
        margin-bottom: 0;
        border-collapse: separate;
        border-spacing: 0 10px;
        min-width: 950px;
    }

    .guide-table thead th {
        border: none;
        background: transparent;
        color: #6b7280;
        font-size: 13px;
        text-transform: uppercase;
        font-weight: 700;
        padding-bottom: 15px;
        white-space: nowrap;
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
        white-space: nowrap;
    }

    .guide-table tbody td:first-child {
        border-left: 1px solid #eef2f7;
        border-radius: 12px 0 0 12px;
    }

    .guide-table tbody td:last-child {
        border-right: 1px solid #eef2f7;
        border-radius: 0 12px 12px 0;
    }

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
        flex-shrink: 0;
    }

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

    .status-assigned {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-inactive {
        background: #fee2e2;
        color: #dc2626;
    }

    .status-locked {
        background: #fef3c7;
        color: #b45309;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: nowrap;
    }

    .action-buttons form {
        margin: 0;
    }

    .action-buttons .btn {
        border-radius: 8px;
        font-weight: 600;
        min-width: 52px;
    }

    .alert-success {
        border: none;
        border-radius: 12px;
        background: #dcfce7;
        color: #166534;
        font-weight: 600;
    }

    .empty-row {
        padding: 28px 12px !important;
        color: #64748b;
        font-weight: 600;
    }

    .pagination-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination {
        justify-content: center;
        margin-bottom: 0;
    }

    @media (max-width: 992px) {
        .filter-form {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 768px) {
        .guide-card {
            padding: 16px;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }

        .page-title {
            font-size: 22px;
        }

        .btn-add-guide {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endsection
