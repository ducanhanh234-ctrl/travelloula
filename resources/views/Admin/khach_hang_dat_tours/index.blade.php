@extends('layouts.admin')
@section('content')

<style>
    .kh-page {
        background: #f8fafc;
        padding: 70px 70px 40px;
        min-height: 100vh;
        font-family: Inter, Arial, sans-serif;
        color: #0f172a;
    }

    .kh-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 38px;
    }

    .kh-title-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .kh-icon {
        font-size: 42px;
        color: #2563eb;
        line-height: 1;
    }

    .kh-title {
        font-size: 38px;
        font-weight: 800;
        margin: 0;
        letter-spacing: -1px;
    }

    .kh-subtitle {
        margin-top: 10px;
        color: #64748b;
        font-size: 16px;
    }

    .kh-add-btn {
        background: #3b82f6;
        color: white;
        padding: 13px 26px;
        border-radius: 7px;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 5px 12px rgba(59, 130, 246, .25);
        display: inline-flex;
        align-items: center;
        gap: 9px;
    }

    .kh-add-btn:hover {
        color: white;
        background: #2563eb;
    }

    .kh-filter-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 9px;
        padding: 34px 16px 30px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, .05);
    }

    .kh-filter-grid {
        display: grid;
        grid-template-columns: 440px 320px 220px;
        gap: 36px;
        align-items: end;
    }

    .kh-label {
        display: block;
        font-size: 16px;
        font-weight: 800;
        margin-bottom: 7px;
        color: #0f172a;
    }

    .kh-input,
    .kh-select {
        height: 44px;
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 0 14px;
        font-size: 16px;
        color: #0f172a;
        background: white;
    }

    .kh-input::placeholder {
        color: #94a3b8;
    }

    .kh-input:focus,
    .kh-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
    }

    .kh-filter-btn {
        height: 40px;
        background: #3b82f6;
        color: white;
        border: none;
        border-radius: 7px;
        font-size: 16px;
        font-weight: 800;
        cursor: pointer;
        width: 100%;
    }

    .kh-filter-btn:hover {
        background: #2563eb;
    }

    .kh-table-card {
        background: white;
        border-radius: 4px;
        overflow: hidden;
        border: 1px solid #f1f5f9;
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
        padding: 17px 26px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 15px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #1e293b;
        text-align: left;
    }

    .kh-table td {
        padding: 28px 26px;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
        font-size: 16px;
        color: #0f172a;
    }

    .kh-table tr:hover td {
        background: #fbfdff;
    }

    .kh-name {
        font-weight: 800;
        color: #1e293b;
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
        display: inline-block;
        padding: 5px 15px;
        border-radius: 999px;
        color: white;
        font-size: 13px;
        font-weight: 900;
        text-transform: uppercase;
        line-height: 1;
        letter-spacing: .03em;
        white-space: nowrap;
    }

    .kh-badge-new {
        background: #6b7280;
    }

    .kh-badge-active {
        background: #10b981;
    }

    .kh-badge-vip {
        background: #f59e0b;
        color: #111827;
    }

    .kh-date-muted {
        display: inline-block;
        color: #64748b;
        font-size: 15px;
        margin-left: 4px;
    }

    .kh-actions {
        display: grid;
        grid-template-columns: 32px 32px;
        grid-template-rows: 28px 28px;
        gap: 8px 18px;
        align-items: center;
    }

    .kh-action {
        border: 0;
        background: transparent;
        padding: 0;
        font-size: 18px;
        line-height: 1;
        text-decoration: none;
        cursor: pointer;
    }

    .kh-view {
        color: #06b6d4;
    }

    .kh-edit {
        color: #f59e0b;
    }

    .kh-delete {
        color: #ef4444;
    }

    .kh-empty {
        text-align: center;
        color: #64748b;
        padding: 42px;
    }

    .kh-pagination {
        padding: 18px 24px;
        background: white;
    }

    @media (max-width: 1100px) {
        .kh-page {
            padding: 35px 22px;
        }

        .kh-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 18px;
        }

        .kh-filter-grid {
            grid-template-columns: 1fr;
            gap: 18px;
        }

        .kh-table-card {
            overflow-x: auto;
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
            ▷ Thêm khách hàng
        </a>
    </div>

    <form method="GET" action="{{ route('Admin.khach-hang.index') }}" class="kh-filter-card">
        <div class="kh-filter-grid">
            <div>
                <label class="kh-label">Tìm kiếm</label>
                <input
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    class="kh-input"
                    placeholder="Tên, email hoặc số điện thoại"
                >
            </div>

            <div>
                <label class="kh-label">Loại khách hàng</label>
                <select name="loai_hanh_khach" class="kh-select">
                    <option value="">Tất cả</option>
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

            <div>
                <button type="submit" class="kh-filter-btn">
                    🔍 Lọc
                </button>
            </div>
        </div>
    </form>

    @if(session('success'))
        <div style="background:#dcfce7;color:#166534;padding:14px 18px;border-radius:8px;margin-bottom:20px;font-weight:700;">
            {{ session('success') }}
        </div>
    @endif

    <div class="kh-table-card">
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
                                — —
                            @endif
                        </td>

                        <td>
                            <div class="kh-actions">
                                <a
                                    href="{{ route('Admin.khach-hang.show', $khachHang->id) }}"
                                    class="kh-action kh-view"
                                    title="Xem chi tiết"
                                >
                                    👁
                                </a>

                                <a
                                    href="{{ route('Admin.khach-hang.edit', $khachHang->id) }}"
                                    class="kh-action kh-edit"
                                    title="Chỉnh sửa"
                                >
                                    ✏️
                                </a>

                                <form
                                    action="{{ route('Admin.khach-hang.destroy', $khachHang->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Bạn có chắc muốn xóa khách hàng này?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="kh-action kh-delete"
                                        title="Xóa"
                                    >
                                        🧾
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

        <div class="kh-pagination">
            {{ $khachHangs->links() }}
        </div>
    </div>
</div>

@endsection