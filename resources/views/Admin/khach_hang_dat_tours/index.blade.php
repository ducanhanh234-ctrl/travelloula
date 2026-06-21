@extends('layouts.admin')
@section('content')

<style>
    .kh-page {
        background: #f8fafc;
        padding: 30px 16px 40px;
        min-height: 100vh;
        font-family: Inter, Arial, sans-serif;
        color: #0f172a;
    }

    .kh-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
    }

    .kh-title-wrap {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .kh-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: #eef2ff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
        line-height: 1;
    }

    .kh-title {
        font-size: 34px;
        font-weight: 850;
        margin: 0;
        letter-spacing: -0.8px;
        color: #020617;
    }

    .kh-subtitle {
        margin-top: 8px;
        color: #64748b;
        font-size: 16px;
    }

    .kh-add-btn {
        background: #3b82f6;
        color: white;
        min-height: 52px;
        padding: 0 26px;
        border-radius: 10px;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 10px 24px rgba(59, 130, 246, .25);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        transition: .18s ease;
    }

    .kh-add-btn:hover {
        color: white;
        background: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 12px 28px rgba(37, 99, 235, .32);
    }

    .kh-filter-card {
        background: white;
        border: 1px solid #dbe3ee;
        border-radius: 8px;
        margin-bottom: 28px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .06);
        overflow: hidden;
        padding: 0;
    }

    .kh-filter-title {
        padding: 20px 30px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 20px;
        font-weight: 850;
        display: flex;
        align-items: center;
        gap: 12px;
        color: #111827;
    }

    .kh-filter-title i {
        font-size: 18px;
        color: #111827;
    }

    .kh-filter-grid {
        display: grid;
        grid-template-columns: minmax(360px, 1fr) minmax(300px, 440px) 220px;
        gap: 18px;
        align-items: center;
        padding: 28px 30px;
    }

    .kh-input,
    .kh-select {
        height: 48px;
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 7px;
        padding: 0 16px;
        font-size: 16px;
        color: #111827;
        background: white;
    }

    .kh-input::placeholder {
        color: #6b7280;
    }

    .kh-input:focus,
    .kh-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, .18);
    }

    .kh-filter-actions {
        display: block;
    }

    .kh-filter-btn {
        height: 48px;
        background: #3b82f6;
        color: white;
        border: none;
        border-radius: 7px;
        font-size: 16px;
        font-weight: 850;
        cursor: pointer;
        width: 100%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        box-shadow: 0 6px 14px rgba(59, 130, 246, .22);
        transition: .18s ease;
    }

    .kh-filter-btn:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    .kh-alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 14px 18px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-weight: 700;
        border: 1px solid #bbf7d0;
    }

    .kh-table-card {
        background: white;
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #dbe3ee;
        box-shadow: 0 2px 8px rgba(15, 23, 42, .06);
    }

    .kh-table-title {
        padding: 20px 28px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 22px;
        font-weight: 850;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #020617;
    }

    .kh-count-badge {
        background: #eef2ff;
        color: #4f46e5;
        padding: 8px 16px;
        border-radius: 999px;
        font-size: 15px;
        font-weight: 850;
    }

    .kh-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .kh-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
    }

    .kh-table thead {
        background: #f8fafc;
    }

    .kh-table th {
        padding: 20px 22px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 14px;
        font-weight: 850;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #334155;
        text-align: left;
    }

    .kh-table td {
        padding: 26px 22px;
        border-bottom: 1px solid #edf2f7;
        vertical-align: middle;
        font-size: 16px;
        color: #0f172a;
    }

    .kh-table tr:nth-child(odd) td {
        background: #f8fafc;
    }

    .kh-table tr:hover td {
        background: #f1f5f9;
    }

    .kh-name {
        font-weight: 850;
        color: #0f172a;
    }

    .kh-contact-email {
        color: #0f172a;
        margin-bottom: 7px;
    }

    .kh-contact-phone {
        color: #64748b;
        font-size: 15px;
    }

    .kh-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 16px;
        border-radius: 999px;
        color: white;
        font-size: 13px;
        font-weight: 850;
        line-height: 1;
        white-space: nowrap;
        text-transform: none;
        letter-spacing: 0;
    }

    .kh-badge-new {
        background: #64748b;
    }

    .kh-badge-active {
        background: #10b981;
    }

    .kh-badge-vip {
        background: #f59e0b;
        color: #111827;
    }

    .kh-date-muted {
        display: block;
        color: #64748b;
        font-size: 14px;
        margin-top: 6px;
        margin-left: 0;
    }

    .kh-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .kh-action-form {
        margin: 0;
        padding: 0;
        display: inline-flex;
    }

    .kh-action {
        width: 34px;
        height: 34px;
        border: 0;
        border-radius: 9px;
        background: transparent;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        font-size: 16px;
        line-height: 1;
        text-decoration: none;
        cursor: pointer;
        transition: .18s ease;
    }

    .kh-action:hover {
        background: #f1f5f9;
        transform: translateY(-1px);
    }

    .kh-view {
        color: #06b6d4;
    }

    .kh-edit {
        color: #f97316;
    }

    .kh-delete {
        color: #ef4444;
    }

    .kh-empty {
        text-align: center;
        color: #64748b;
        padding: 46px;
        background: white !important;
    }

    .kh-pagination {
        padding: 20px 28px;
        background: white;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: center;
    }

    .kh-pagination nav {
        width: 100%;
    }

    .kh-pagination .flex.justify-between {
        align-items: center;
    }

    .kh-pagination a,
    .kh-pagination span {
        border-radius: 9px !important;
    }

    .kh-pagination a {
        transition: .18s ease;
    }

    .kh-pagination a:hover {
        background: #eff6ff !important;
        color: #2563eb !important;
    }

    .kh-pagination nav > div:last-child {
        display: flex;
        justify-content: center;
    }

    .kh-pagination nav span[aria-current="page"] span {
        background: #3b82f6 !important;
        color: white !important;
        border-color: #3b82f6 !important;
        font-weight: 850;
    }

    @media (max-width: 1100px) {
        .kh-page {
            padding: 24px 12px;
        }

        .kh-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 18px;
        }

        .kh-add-btn {
            width: 100%;
        }

        .kh-filter-grid {
            grid-template-columns: 1fr;
            gap: 16px;
            padding: 22px;
        }

        .kh-filter-actions {
            display: block;
        }

        .kh-table {
            min-width: 1050px;
        }
    }
</style>

<div class="kh-page">

    <div class="kh-header">
        <div>
            <div class="kh-title-wrap">
                <div class="kh-icon">👥</div>

                <h1 class="kh-title">
                    Danh sách khách hàng
                </h1>
            </div>

            <div class="kh-subtitle">
                Quản lý thông tin, lịch sử đặt tour và trạng thái khách hàng
            </div>
        </div>

        <a href="{{ route('Admin.khach-hang.create') }}" class="kh-add-btn">
            + Thêm khách hàng
        </a>
    </div>

    <form method="GET" action="{{ route('Admin.khach-hang.index') }}" class="kh-filter-card">
        <div class="kh-filter-title">
            <i class="fa-solid fa-filter"></i>
            Bộ lọc tìm kiếm
        </div>

        <div class="kh-filter-grid">
            <div>
                <input
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    class="kh-input"
                    placeholder="Tìm tên, email hoặc số điện thoại..."
                >
            </div>

            <div>
                <select name="loai_hanh_khach" class="kh-select">
                    <option value="">Tất cả loại khách hàng</option>

                    <option value="adult" @selected(request('loai_hanh_khach') == 'adult')>
                        Người lớn
                    </option>

                    <option value="child" @selected(request('loai_hanh_khach') == 'child')>
                        Trẻ em
                    </option>

                    <option value="baby" @selected(request('loai_hanh_khach') == 'baby')>
                        Em bé
                    </option>
                </select>
            </div>

            <div class="kh-filter-actions">
                <button type="submit" class="kh-filter-btn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Tìm kiếm
                </button>
            </div>
        </div>
    </form>

    @if(session('success'))
        <div class="kh-alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="kh-table-card">
        <div class="kh-table-title">
            <span>👥 Danh sách khách hàng</span>

            <span class="kh-count-badge">
                {{ $khachHangs->total() }} khách
            </span>
        </div>

        <div class="kh-table-wrap">
            <table class="kh-table">
                <thead>
                    <tr>
                        <th style="width: 18%;">Tên khách hàng</th>
                        <th style="width: 22%;">Thông tin liên hệ</th>
                        <th style="width: 11%;">Hoạt động</th>
                        <th style="width: 16%;">Trạng thái</th>
                        <th style="width: 19%;">Ngày tham gia</th>
                        <th style="width: 14%;">Thao tác</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($khachHangs as $khachHang)
                        <tr>
                            <td>
                                <div class="kh-name">
                                    {{ $khachHang->ho_ten }}
                                </div>
                            </td>

                            <td>
                                <div class="kh-contact-email">
                                    {{ $khachHang->email ?? '-' }}
                                </div>

                                <div class="kh-contact-phone">
                                    {{ $khachHang->so_dien_thoai ?? '-' }}
                                </div>
                            </td>

                            <td>
                                {{ $khachHang->so_lan_dat }} lần đặt
                            </td>

                            <td>
                                @if($khachHang->so_lan_dat <= 1)
                                    <span class="kh-badge kh-badge-new">
                                        Khách mới
                                    </span>
                                @elseif($khachHang->so_lan_dat <= 3)
                                    <span class="kh-badge kh-badge-active">
                                        Đang hoạt động
                                    </span>
                                @else
                                    <span class="kh-badge kh-badge-vip">
                                        Khách thân thiết
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($khachHang->ngay_tham_gia)
                                    {{ \Carbon\Carbon::parse($khachHang->ngay_tham_gia)->format('d/m/Y') }}

                                    <span class="kh-date-muted">
                                        {{ \Carbon\Carbon::parse($khachHang->ngay_tham_gia)->diffForHumans() }}
                                    </span>
                                @else
                                    —
                                @endif
                            </td>

                            <td>
                                <div class="kh-actions">
                                    <a
                                        href="{{ route('Admin.khach-hang.show', $khachHang->id) }}"
                                        class="kh-action kh-view"
                                        title="Xem chi tiết"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <a
                                        href="{{ route('Admin.khach-hang.edit', $khachHang->id) }}"
                                        class="kh-action kh-edit"
                                        title="Chỉnh sửa"
                                    >
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <form
                                        action="{{ route('Admin.khach-hang.destroy', $khachHang->id) }}"
                                        method="POST"
                                        class="kh-action-form"
                                        onsubmit="return confirm('Bạn có chắc muốn xóa khách hàng này?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="kh-action kh-delete"
                                            title="Xóa"
                                        >
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="kh-empty">
                                Chưa có khách hàng nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="kh-pagination">
            {{ $khachHangs->onEachSide(1)->links() }}
        </div>
    </div>
</div>

@endsection