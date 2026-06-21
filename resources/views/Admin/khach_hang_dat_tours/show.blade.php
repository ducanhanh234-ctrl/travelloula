@extends('layouts.admin')

@section('content')
    <style>
        .customer-detail-page {
            background: #f8fafc;
            padding: 30px 16px 40px;
            min-height: 100vh;
            color: #0f172a;
            font-family: Inter, Arial, sans-serif;
        }

        .detail-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 28px;
            gap: 20px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            text-decoration: none;
            font-size: 15px;
            font-weight: 750;
            margin-bottom: 12px;
            transition: .18s ease;
        }

        .back-btn:hover {
            color: #2563eb;
            transform: translateX(-2px);
        }

        .customer-title-wrap {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .customer-icon {
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

        .customer-name-title {
            font-size: 34px;
            font-weight: 850;
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
            min-height: 52px;
            background: #3b82f6;
            color: white;
            padding: 0 26px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 850;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            box-shadow: 0 10px 24px rgba(59, 130, 246, .25);
            transition: .18s ease;
            white-space: nowrap;
        }

        .edit-btn:hover {
            background: #2563eb;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 12px 28px rgba(37, 99, 235, .32);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: white;
            border: 1px solid #dbe3ee;
            border-radius: 14px;
            padding: 24px 26px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .06);
            transition: .18s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(15, 23, 42, .08);
        }

        .stat-label {
            color: #64748b;
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 850;
            color: #0f172a;
            margin: 0;
            letter-spacing: -0.6px;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 26px;
            margin-bottom: 28px;
        }

        .info-card,
        .profile-card,
        .history-card {
            background: white;
            border: 1px solid #dbe3ee;
            border-radius: 14px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .06);
            overflow: hidden;
        }

        .card-title {
            padding: 20px 28px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 20px;
            font-weight: 850;
            background: #ffffff;
            color: #020617;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-body {
            padding: 26px 28px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 26px 42px;
        }

        .info-item label {
            display: block;
            font-weight: 850;
            margin-bottom: 8px;
            color: #0f172a;
            font-size: 15px;
        }

        .info-item div {
            color: #334155;
            line-height: 1.5;
            font-size: 15.5px;
        }

        .profile-card {
            text-align: center;
            padding-bottom: 26px;
        }

        .avatar-circle {
            width: 118px;
            height: 118px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            font-weight: 850;
            margin: 32px auto 16px;
            box-shadow: 0 10px 24px rgba(59, 130, 246, .28);
        }

        .profile-name {
            font-size: 22px;
            font-weight: 850;
            margin-bottom: 6px;
            color: #020617;
        }

        .profile-contact {
            color: #64748b;
            font-size: 15px;
            margin-bottom: 18px;
            word-break: break-word;
            padding: 0 18px;
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 850;
            color: white;
            line-height: 1;
            white-space: nowrap;
        }

        .badge-active {
            background: #10b981;
        }

        .badge-new {
            background: #64748b;
        }

        .history-table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .history-table thead {
            background: #f8fafc;
        }

        .history-table th {
            padding: 18px 18px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
            font-weight: 850;
            text-transform: uppercase;
            letter-spacing: .06em;
            color: #334155;
            text-align: left;
            white-space: nowrap;
        }

        .history-table td {
            padding: 20px 18px;
            border-bottom: 1px solid #edf2f7;
            font-size: 15px;
            color: #0f172a;
            vertical-align: middle;
        }

        .history-table tr:nth-child(odd) td {
            background: #f8fafc;
        }

        .history-table tr:hover td {
            background: #f1f5f9;
        }

        .tour-code {
            font-weight: 850;
            color: #0f172a;
        }

        .tour-name {
            font-weight: 850;
            color: #1e293b;
            line-height: 1.4;
        }

        .money {
            font-weight: 850;
            color: #0f172a;
            white-space: nowrap;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 13px;
            border-radius: 999px;
            font-size: 12.5px;
            font-weight: 850;
            line-height: 1;
            white-space: nowrap;
        }

        .badge-success-custom {
            background: #10b981;
            color: white;
        }

        .badge-secondary-custom {
            background: #64748b;
            color: white;
        }

        .payment-text {
            font-weight: 750;
            color: #334155;
        }

        .tour-status {
            font-weight: 750;
            color: #334155;
        }

        .empty-row {
            text-align: center;
            color: #64748b;
            padding: 42px !important;
            background: white !important;
            font-weight: 700;
        }

        @media (max-width: 1100px) {
            .customer-detail-page {
                padding: 24px 12px;
            }

            .detail-header {
                flex-direction: column;
                gap: 16px;
            }

            .edit-btn {
                margin-top: 0;
                width: 100%;
            }

            .stats-grid,
            .content-grid {
                grid-template-columns: 1fr;
            }

            .info-body {
                grid-template-columns: 1fr;
            }

            .history-table {
                min-width: 1100px;
            }
        }

        @media (max-width: 640px) {
            .customer-title-wrap {
                align-items: flex-start;
            }

            .customer-icon {
                width: 46px;
                height: 46px;
                font-size: 23px;
            }

            .customer-name-title {
                font-size: 28px;
            }

            .card-title {
                padding: 18px 20px;
                font-size: 18px;
            }

            .info-body {
                padding: 22px 20px;
            }

            .stat-card {
                padding: 22px;
            }

            .stat-value {
                font-size: 28px;
            }
        }
    </style>

    <div class="customer-detail-page">

        <div class="detail-header">
            <div>
                <a href="{{ route('Admin.khach-hang.index') }}" class="back-btn">
                    ← Quay lại danh sách
                </a>

                <div class="customer-title-wrap">
                    <div class="customer-icon">👤</div>

                    <div>
                        <h1 class="customer-name-title">
                            {{ $khachHang->ho_ten }}
                        </h1>

                        <div class="customer-subtitle">
                            Chi tiết khách hàng và lịch sử đặt tour
                        </div>
                    </div>
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
                <div class="card-title">
                    📋 Thông tin khách hàng
                </div>

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

                    {{-- <div class="info-item">
                    <label>Giới tính</label>
                    <div>{{ $khachHang->gioi_tinh ?? '-' }}</div>
                </div> --}}
                    <div class="info-item">
                        <label>Giới tính</label>
                        <div>
                            {{ [
                                'nam' => 'Nam',
                                'nu' => 'Nữ',
                                'khac' => 'Khác',
                            ][$khachHang->gioi_tinh] ?? '-' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <label>Năm sinh</label>
                        <div>{{ $khachHang->nam_sinh ?? '-' }}</div>
                    </div>

                    <div class="info-item">
                        <label>Giấy tờ</label>
                        <div>
                            {{ $khachHang->loai_giay_to ?? '-' }}

                            @if ($khachHang->so_giay_to)
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
                <div class="card-title">
                    👤 Hồ sơ khách hàng
                </div>

                <div class="avatar-circle">
                    {{ mb_strtoupper(mb_substr($khachHang->ho_ten, 0, 1)) }}
                </div>

                <div class="profile-name">
                    {{ $khachHang->ho_ten }}
                </div>

                <div class="profile-contact">
                    {{ $khachHang->email ?? 'Chưa có email' }}
                </div>

                @if ($tongSoTour <= 1)
                    <span class="badge-status badge-new">
                        Khách mới
                    </span>
                @else
                    <span class="badge-status badge-active">
                        Đang hoạt động
                    </span>
                @endif
            </div>
        </div>

        <div class="history-card">
            <div class="card-title">
                🧾 Lịch sử đặt tour
            </div>

            <div class="history-table-wrap">
                <table class="history-table">
                    <thead>
                        <tr>
                            <th style="width: 13%;">Mã đặt tour</th>
                            <th style="width: 22%;">Tour</th>
                            <th style="width: 13%;">Ngày khởi hành</th>
                            <th style="width: 12%;">Ngày đặt</th>
                            <th style="width: 13%;">Tổng tiền</th>
                            <th style="width: 12%;">Thanh toán</th>
                            <th style="width: 13%;">Check-in</th>
                            <th style="width: 12%;">Trạng thái tour</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($lichSuDatTours as $item)
                            <tr>
                                <td>
                                    <span class="tour-code">
                                        {{ $item->datTour->ma_dat_tour ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="tour-name">
                                        {{ $item->datTour->tour->ten_tour ?? '-' }}
                                    </div>
                                </td>

                                <td>
                                    {{ optional($item->datTour->lichKhoiHanh?->ngay_khoi_hanh)->format('d/m/Y') ?? '-' }}
                                </td>

                                <td>
                                    {{ optional($item->created_at)->format('d/m/Y') ?? '-' }}
                                </td>

                                <td class="money">
                                    {{ number_format($item->tong_tien) }}đ
                                </td>

                                <td>
                                    <span class="payment-text">
                                        {{ $item->trang_thai_thanh_toan ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    @if ($item->da_check_in)
                                        <span class="badge badge-success-custom">
                                            Đã check-in
                                        </span>
                                    @else
                                        <span class="badge badge-secondary-custom">
                                            Chưa check-in
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    <span class="tour-status">
                                        {{ $item->datTour->trang_thai ?? '-' }}
                                    </span>
                                </td>
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
    </div>
@endsection
