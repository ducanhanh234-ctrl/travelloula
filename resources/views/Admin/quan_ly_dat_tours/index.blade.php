@extends('layouts.admin')

@section('content')

    <style>
        body {
            background: #f5f7fb;
        }

        .page-title {
            font-size: 32px;
            font-weight: 700;
        }

        .page-desc {
            color: #6c757d;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
            height: 100%;
        }

        .stat-title {
            color: #888;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .stat-number {
            font-size: 32px;
            font-weight: 700;
        }

        .search-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }

        .table-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }

        .table th {
            font-size: 14px;
            font-weight: 600;
            background: #f8f9fa;
            vertical-align: middle;
        }

        .table td {
            vertical-align: middle;
        }

        .btn-booking {
            background: #16b9ff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
        }

        .btn-search {
            width: 100%;
            background: #16b9ff;
            color: white;
            border: none;
            border-radius: 8px;
            height: 38px;
        }

        .empty-data {
            text-align: center;
            padding: 60px 0;
            color: #999;
        }

        .badge-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-cho_xac_nhan {
            background: #fff3cd;
            color: #856404;
        }

        .badge-da_xac_nhan {
            background: #cce5ff;
            color: #004085;
        }

        .badge-da_thanh_toan {
            background: #d4edda;
            color: #155724;
        }

        .badge-da_huy {
            background: #f8d7da;
            color: #721c24;
        }

        .badge-hoan_thanh {
            background: #e2e3e5;
            color: #383d41;
        }

        .badge-nguon {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-website {
            background: #e8f4fd;
            color: #0d6efd;
        }

        .badge-sale {
            background: #fce8ff;
            color: #9b59b6;
        }

        .tour-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .booking-code {
            font-size: 12px;
            color: #888;
        }

        .customer-name {
            font-size: 13px;
            color: #555;
        }

        .passenger-count {
            font-weight: 600;
            font-size: 15px;
        }

        .revenue-amount {
            font-weight: 600;
            color: #16a34a;
        }

        .action-btn {
            padding: 4px 8px;
            font-size: 12px;
            border-radius: 6px;
        }
    </style>

    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="page-title">
                    Quản lý Đặt Tour
                </h2>
                <p class="page-desc">
                    Quản lý tất cả các đặt tour trong hệ thống
                </p>
            </div>
            <div class="d-flex gap-2">

                <a href="{{ route('Admin.dat-tours.create') }}" class="btn-booking text-decoration-none">
                    + Thêm booking thủ công
                </a>

                <a href="{{ route('Admin.dat_tours.trash') }}" class="btn btn-outline-danger">
                    <i class="fas fa-trash"></i>
                    Thùng rác
                </a>

            </div>

        </div>

        <!-- Thống kê -->
        <div class="row g-3">
            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-title">Tổng booking</div>
                    <div class="stat-number">{{ $totalBookings ?? 0 }}</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-title">Từ Website</div>
                    <div class="stat-number">{{ $websiteBookings ?? 0 }}</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-title">Từ Sale</div>
                    <div class="stat-number">{{ $saleBookings ?? 0 }}</div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card">
                    <div class="stat-title">Doanh thu</div>
                    <div class="stat-number" style="font-size: 24px;">{{ $revenue ?? '0 đ' }}</div>
                </div>
            </div>
        </div>

        <!-- Tìm kiếm -->
        <div class="search-card">
            <form action="{{ route('Admin.quan_ly_dat_tour.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-6">
                        <label class="fw-bold mb-2">Tìm kiếm</label>
                        <input type="text" name="keyword" class="form-control" placeholder="Tên tour, mã booking..."
                            value="{{ $filters['keyword'] ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold mb-2">
                            Trạng thái
                        </label>
                        <select name="status" class="form-select">
                            <option value="">
                                Tất cả
                            </option>
                            @foreach($statuses as $value => $label)
                                <option value="{{ $value }}" @selected(($filters['status'] ?? '') == $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn-search">
                            Tìm
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Danh sách booking -->
        <div class="table-card">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>NGÀY KHỞI HÀNH</th>
                        <th>TOUR & KHÁCH</th>
                        <th>SỐ LƯỢNG (L/T/E)</th>
                        <th>DOANH THU</th>
                        <th>PHỤ TRÁCH / HDV</th>
                        <th>NGUỒN BOOKING</th>
                        <th>TRẠNG THÁI</th>
                        <th>THAO TÁC</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($bookings) && $bookings->count())
                        @foreach($bookings as $booking)
                            <tr>
                                <td>
                                    <div>{{ $booking->departure_date ?? '—' }}</div>
                                    <small class="text-muted">
                                        Đặt: {{ $booking->ngay_dat?->format('d/m/Y') }}
                                    </small>
                                </td>

                                <td>
                                    <div class="tour-name">{{ $booking->tour?->ten_tour ?? '—' }}</div>
                                    <div class="booking-code">{{ $booking->ma_dat_tour }}</div>
                                    <div class="customer-name">
                                        <i class="fas fa-user fa-sm"></i> {{ $booking->ten_khach_chinh }}
                                    </div>
                                </td>

                                <td>
                                    <span class="passenger-count">
                                        {{ $booking->so_nguoi_lon }}/{{ $booking->so_tre_em }}/{{ $booking->so_em_be }}
                                    </span>
                                </td>

                                <td>
                                    <div class="revenue-amount">
                                        {{ number_format($booking->tong_tien, 0, ',', '.') }} đ
                                    </div>
                                    @if($booking->so_tien_da_thanh_toan < $booking->tong_tien)
                                        <small class="text-muted">
                                            Đã TT: {{ number_format($booking->so_tien_da_thanh_toan, 0, ',', '.') }} đ
                                        </small>
                                    @endif
                                </td>

                                <td>{{ $booking->lichKhoiHanh?->huongDanVien?->ho_ten ?? 'Chưa phân công' }}</td>

                                <td>
                                    <span class="badge-nguon badge-{{ $booking->nguon_booking ?? 'website' }}">
                                        {{ $booking->nguon_booking_label }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge-status badge-{{ $booking->trang_thai }}">
                                        {{ $booking->trangThaiDatTour() }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex gap-1">

                                        {{-- Xem chi tiết --}}
                                        <a href="{{ route('Admin.dat_tours.show', $booking->id) }}"
                                            class="btn btn-sm btn-outline-info" title="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Xóa mềm --}}
                                        <form action="{{ route('Admin.dat_tours.destroy', $booking->id) }}" method="POST"
                                            onsubmit="return confirm('Chuyển booking vào thùng rác?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-warning" title="Xóa mềm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                        {{-- Xóa cứng
                                        <form action="{{ route('Admin.dat_tours.forceDelete', $booking->id) }}" method="POST"
                                            onsubmit="return confirm('XÓA VĨNH VIỄN booking này? Không thể khôi phục!')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Xóa vĩnh viễn">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form> --}}

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8">
                                <div class="empty-data">
                                    Chưa có dữ liệu booking
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            @if(isset($bookings) && $bookings->hasPages())
                <div class="p-3">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
