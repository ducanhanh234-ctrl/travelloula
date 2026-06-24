@extends('layouts.admin_pro')

@section('content')
<style>
    .customer-detail-page {
        background: #f8fafc;
        padding: 40px 48px;
        min-height: 100vh;
        color: #0f172a;
    }

    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 28px;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        font-size: 15px;
        font-weight: 600;
        margin-bottom: 12px;
        transition: .2s;
    }

    .back-btn:hover {
        color: #2563eb;
    }

    .customer-name-title {
        font-size: 38px;
        font-weight: 800;
        margin: 0;
        letter-spacing: -0.8px;
        color: #020617;
    }

    .customer-subtitle {
        color: #64748b;
        margin-top: 8px;
        font-size: 16px;
    }

    .edit-btn {
        margin-top: 34px;
        background: #3b82f6;
        color: white;
        padding: 13px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 800;
        box-shadow: 0 8px 18px rgba(59, 130, 246, .25);
        transition: .2s;
    }

    .edit-btn:hover {
        background: #2563eb;
        color: white;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
        margin-bottom: 26px;
    }

    .stat-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 24px 26px;
        box-shadow: 0 1px 4px rgba(15, 23, 42, .05);
    }

    .stat-label {
        color: #64748b;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .stat-value {
        font-size: 34px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 26px;
        margin-bottom: 26px;
    }

    .info-card,
    .profile-card,
    .history-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 1px 4px rgba(15, 23, 42, .05);
        overflow: hidden;
    }

    .card-title {
        padding: 18px 24px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 17px;
        font-weight: 800;
        background: #ffffff;
    }

    .info-body {
        padding: 26px 24px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 26px 42px;
    }

    .info-item label {
        display: block;
        font-weight: 800;
        margin-bottom: 7px;
        color: #0f172a;
    }

    .info-item div {
        color: #334155;
        line-height: 1.5;
    }

    .profile-card {
        text-align: center;
        padding-bottom: 24px;
    }

    .avatar-circle {
        width: 118px;
        height: 118px;
        border-radius: 50%;
        background: #3b82f6;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        font-weight: 800;
        margin: 30px auto 16px;
        box-shadow: 0 8px 18px rgba(59, 130, 246, .25);
    }

    .profile-name {
        font-size: 22px;
        font-weight: 800;
        margin-bottom: 6px;
    }

    .profile-contact {
        color: #64748b;
        font-size: 15px;
        margin-bottom: 18px;
    }

    .badge-status {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
        text-transform: uppercase;
        color: white;
    }

    .badge-active {
        background: #10b981;
    }

    .badge-new {
        background: #6b7280;
    }

    .history-table {
        width: 100%;
        border-collapse: collapse;
    }

    .history-table thead {
        background: #f8fafc;
    }

    .history-table th {
        padding: 16px 18px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 13px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #334155;
        text-align: left;
    }

    .history-table td {
        padding: 18px;
        border-bottom: 1px solid #edf2f7;
        font-size: 15px;
        color: #0f172a;
        vertical-align: middle;
    }

    .history-table tr:hover td {
        background: #fbfdff;
    }

    .tour-name {
        font-weight: 800;
        color: #1e293b;
    }

    .money {
        font-weight: 800;
        color: #0f172a;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
    }

    .badge-success-custom {
        background: #10b981;
        color: white;
    }

    .badge-secondary-custom {
        background: #64748b;
        color: white;
    }

    .empty-row {
        text-align: center;
        color: #64748b;
        padding: 34px;
    }

    @media (max-width: 1100px) {
        .customer-detail-page {
            padding: 28px 22px;
        }

        .detail-header {
            flex-direction: column;
            gap: 16px;
        }

        .edit-btn {
            margin-top: 0;
        }

        .stats-grid,
        .content-grid {
            grid-template-columns: 1fr;
        }

        .info-body {
            grid-template-columns: 1fr;
        }

        .history-card {
            overflow-x: auto;
        }

        .history-table {
            min-width: 1000px;
        }
    }

</style>

<div class="customer-detail-page">

    <div class="detail-header">
        <div>
            <a href="{{ route('Admin.khach-hang.index') }}" class="back-btn">
                ← Quay lại danh sách
            </a>

            <h1 class="customer-name-title">
                {{ $khachHang->ho_ten }}
            </h1>

            <div class="customer-subtitle">
                Chi tiết khách hàng và lịch sử đặt tour
            </div>
        </div>

        <a href="{{ route('Admin.khach-hang.edit', $khachHang->id) }}" class="edit-btn">
            ✏ Chỉnh sửa
        </a>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Tổng số tour</div>
            <h2 class="stat-value">{{ $tongSoTour }}</h2>
        </div>

        <div class="stat-card">
            <div class="stat-label">Tổng chi tiêu</div>
            <h2 class="stat-value">{{ number_format($tongChiTieu) }}đ</h2>
        </div>

        <div class="stat-card">
            <div class="stat-label">Số lần check-in</div>
            <h2 class="stat-value">{{ $soLanCheckIn }}</h2>
        </div>
    </div>

    <div class="content-grid">
        <div class="info-card">
            <div class="card-title">Thông tin khách hàng</div>

            <div class="info-body">
                <div class="info-item">
                    <label>Họ tên</label>
                    <div>{{ $khachHang->ho_ten }}</div>
                </div>

                <div class="info-item">
                    <label>Email</label>
                    <div>{{ $khachHang->email ?? '-' }}</div>
                </div>

                <div class="info-item">
                    <label>Số điện thoại</label>
                    <div>{{ $khachHang->so_dien_thoai ?? '-' }}</div>
                </div>

                <div class="info-item">
                    <label>Giới tính</label>
                    <div>{{ $khachHang->gioi_tinh ?? '-' }}</div>
                </div>

                <div class="info-item">
                    <label>Năm sinh</label>
                    <div>{{ $khachHang->nam_sinh ?? '-' }}</div>
                </div>

                <div class="info-item">
                    <label>Giấy tờ</label>
                    <div>
                        {{ $khachHang->loai_giay_to ?? '-' }}
                        @if($khachHang->so_giay_to)
                        - {{ $khachHang->so_giay_to }}
                        @endif
                    </div>
                </div>

                <div class="info-item">
                    <label>Yêu cầu đặc biệt</label>
                    <div>{{ $khachHang->yeu_cau_dac_biet ?? '-' }}</div>
                </div>

                <div class="info-item">
                    <label>Ghi chú</label>
                    <div>{{ $khachHang->ghi_chu ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="profile-card">
            <div class="avatar-circle">
                {{ mb_substr($khachHang->ho_ten, 0, 1) }}
            </div>

            <div class="profile-name">
                {{ $khachHang->ho_ten }}
            </div>

            <div class="profile-contact">
                {{ $khachHang->email ?? 'Chưa có email' }}
            </div>

            @if($tongSoTour <= 1) <span class="badge-status badge-new">Khách mới</span>
                @else
                <span class="badge-status badge-active">Đang hoạt động</span>
                @endif
        </div>
    </div>

    <div class="history-card">
        <div class="card-title">Lịch sử đặt tour</div>

        <table class="history-table">
            <thead>
                <tr>
                    <th>Mã đặt tour</th>
                    <th>Tour</th>
                    <th>Ngày khởi hành</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Thanh toán</th>
                    <th>Check-in</th>
                    <th>Trạng thái tour</th>
                </tr>
            </thead>

            <tbody>
                @forelse($lichSuDatTours as $item)
                <tr>
                    <td>{{ $item->datTour->ma_dat_tour ?? '-' }}</td>

                    <td>
                        <div class="tour-name">
                            {{ $item->datTour->tour->ten_tour ?? '-' }}
                        </div>
                    </td>

                    <td>
                        {{ optional($item->datTour->lichKhoiHanh?->ngay_khoi_hanh)->format('d/m/Y') ?? '-' }}
                    </td>

                    <td>
                        {{-- {{ optional($item->datTour?->ngay_dat)->format('d/m/Y') ?? '-' }} --}}
                        {{ optional($item->created_at)->format('d/m/Y') ?? '-' }}
                    </td>

                    <td class="money">
                        {{ number_format($item->tong_tien) }}đ
                    </td>

                    <td>
                        {{ $item->trang_thai_thanh_toan }}
                    </td>

                    <td>
                        @if($item->da_check_in)
                        <span class="badge badge-success-custom">Đã check-in</span>
                        @else
                        <span class="badge badge-secondary-custom">Chưa check-in</span>
                        @endif
                    </td>

                    <td>{{ $item->datTour->trang_thai ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="empty-row">
                        Chưa có lịch sử đặt tour.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
