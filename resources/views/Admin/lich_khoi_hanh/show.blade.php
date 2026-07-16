@extends('layouts.admin')

@section('title', 'Chi tiết lịch khởi hành')

@section('content')

    <link rel="stylesheet" href="{{ asset('admin-assets/css/lich-khoi-hanh-show.css') }}">

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold">
                    <i class="fas fa-eye text-info"></i>
                    Chi tiết lịch khởi hành
                </h3>
            </div>

            <a href="{{ route('Admin.lich-khoi-hanh.index') }}" class="btn btn-secondary">

                <i class="fas fa-arrow-left"></i>
                Quay lại

            </a>

        </div>

        {{-- THÔNG TIN TOUR --}}
        <div class="card shadow-sm mb-4">

            <div class="card-header section-header">
                <h5 class="mb-0">
                    <i class="fas fa-map-marked-alt"></i>
                    Thông tin tour
                </h5>
            </div>

            <div class="card-body">

                <div class="row align-items-center">

                    {{-- Ảnh --}}
                    <div class="col-md-5">

                        @if ($item->tour->anh_dai_dien)
                            <img src="{{ asset('images/avt_tour/' . $item->tour->anh_dai_dien) }}"
                                alt="{{ $item->tour->ten_tour }}" class="img-fluid rounded shadow tour-image">
                        @else
                            <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                                style="height:320px">

                                <span class="text-muted">
                                    Chưa có ảnh tour
                                </span>

                            </div>
                        @endif

                    </div>

                    {{-- Thông tin --}}
                    <div class="col-md-7">

                        <h2 class="fw-bold mb-2">
                            {{ $item->tour->ten_tour }}
                        </h2>

                        <div class="mb-3">
                            @switch($item->trang_thai_hien_thi)
                                @case('Mở bán')
                                    <span class="status-pill status-open">
                                        <i class="fas fa-check-circle"></i>
                                        Mở bán
                                    </span>
                                @break

                                @case('Đang diễn ra')
                                    <span class="status-pill status-running">
                                        <i class="fas fa-route"></i>
                                        Đang diễn ra
                                    </span>
                                @break

                                @case('Đã đóng')
                                    <span class="status-pill status-closed">
                                        <i class="fas fa-lock"></i>
                                        Đã đóng
                                    </span>
                                @break

                                @case('Hết chỗ')
                                    <span class="status-pill status-full">
                                        <i class="fas fa-users-slash"></i>
                                        Hết chỗ
                                    </span>
                                @break

                                @case('Đã kết thúc')
                                    <span class="status-pill status-ended">
                                        <i class="fas fa-flag-checkered"></i>
                                        Đã kết thúc
                                    </span>
                                @break

                                @case('Đã hủy')
                                    <span class="status-pill status-cancel">
                                        <i class="fas fa-times-circle"></i>
                                        Đã hủy
                                    </span>
                                @break
                            @endswitch
                        </div>



                        <div class="row g-3">

                            <div class="col-md-6">
                                <div class="info-box">
                                    <small>Danh mục</small>
                                    <div class="fw-semibold">
                                        {{ $item->tour->danhMuc->ten_danh_muc ?? 'Chưa có' }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-box">
                                    <small>Thời lượng</small>
                                    <div class="fw-semibold">
                                        {{ $item->tour->thoi_luong }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-box">
                                    <small>Điểm khởi hành</small>
                                    <div class="fw-semibold">
                                        {{ $item->tour->dia_diem_khoi_hanh }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-box">
                                    <small>Điểm đến</small>
                                    <div class="fw-semibold">
                                        {{ $item->tour->diem_den }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-box">
                                    <small>Phương tiện</small>
                                    <div class="fw-semibold">
                                        {{ $item->tour->phuong_tien }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-box">
                                    <small>Khách sạn</small>
                                    <div class="fw-semibold">
                                        {{ $item->tour->tieu_chuan_khach_san }}
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>

        {{-- THÔNG TIN KHỞI HÀNH --}}
        <div class="card shadow-sm mb-4">

            <div class="card-header section-header">
                <h5 class="mb-0">
                    <i class="fas fa-plane-departure"></i>
                    Thông tin khởi hành
                </h5>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    {{-- Ngày khởi hành --}}
                    <div class="col-md-4 col-lg-2">
                        <div class="kpi-card">
                            <i class="fas fa-plane-departure kpi-icon text-primary"></i>

                            <div class="kpi-title">
                                Khởi hành
                            </div>

                            <div class="kpi-value">
                                {{ \Carbon\Carbon::parse($item->ngay_khoi_hanh)->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>

                    {{-- Ngày kết thúc --}}
                    <div class="col-md-4 col-lg-2">
                        <div class="kpi-card">
                            <i class="fas fa-flag-checkered kpi-icon text-success"></i>

                            <div class="kpi-title">
                                Kết thúc
                            </div>

                            <div class="kpi-value">
                                {{ \Carbon\Carbon::parse($item->ngay_ket_thuc)->format('d/m/Y') }}
                            </div>
                        </div>
                    </div>

                    {{-- Giá người lớn --}}
                    <div class="col-md-4 col-lg-2">
                        <div class="kpi-card">
                            <i class="fas fa-user kpi-icon text-primary"></i>

                            <div class="kpi-title">
                                Người lớn
                            </div>

                            <div class="kpi-value text-primary">
                                {{ number_format($item->gia_nguoi_lon, 0, ',', '.') }}₫
                            </div>
                        </div>
                    </div>

                    {{-- Giá trẻ em --}}
                    <div class="col-md-4 col-lg-2">
                        <div class="kpi-card">
                            <i class="fas fa-child kpi-icon text-success"></i>

                            <div class="kpi-title">
                                Trẻ em
                            </div>

                            <div class="kpi-value text-success">
                                {{ number_format($item->gia_tre_em, 0, ',', '.') }}₫
                            </div>
                        </div>
                    </div>

                    {{-- Đã đặt --}}
                    <div class="col-md-4 col-lg-2">
                        <div class="kpi-card">
                            <i class="fas fa-users kpi-icon text-warning"></i>

                            <div class="kpi-title">
                                Đã đặt
                            </div>

                            <div class="kpi-value">
                                {{ $item->so_cho_da_dat }}
                            </div>
                        </div>
                    </div>

                    {{-- Còn lại --}}
                    <div class="col-md-4 col-lg-2">
                        <div class="kpi-card">
                            <i class="fas fa-chair kpi-icon text-danger"></i>

                            <div class="kpi-title">
                                Còn lại
                            </div>

                            <div class="kpi-value">
                                {{ $item->so_cho_con_lai }}
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Progress đặt chỗ --}}
                <div class="mt-4">

                    @php
                        $phanTramDat = $item->so_cho > 0 ? round(($item->so_cho_da_dat / $item->so_cho) * 100) : 0;
                    @endphp

                    <div class="d-flex justify-content-between mb-2">
                        <strong>Tình trạng đặt chỗ</strong>

                        <span>
                            {{ $item->so_cho_da_dat }}/{{ $item->so_cho }}
                            khách
                        </span>
                    </div>

                    <div class="progress" style="height: 12px">

                        <div class="progress-bar
                            @if ($phanTramDat < 50) bg-success
                            @elseif($phanTramDat < 80)
                            bg-warning
                            @else
                            bg-danger @endif"
                            style="width: {{ $phanTramDat }}%">
                        </div>

                    </div>

                    <small class="text-muted">
                        Đã lấp đầy {{ $phanTramDat }}% số chỗ
                    </small>

                </div>

                {{-- HƯỚNG DẪN VIÊN --}}
                <div class="card shadow-sm mb-4">

                    <div class="card-header section-header">
                        <h5 class="mb-0">
                            <i class="fas fa-route me-2"></i>
                            Hướng dẫn viên phụ trách
                        </h5>
                    </div>

                    <div class="card-body">

                        @if ($item->huongDanVien)
                            <div class="guide-card">

                                @if ($item->huongDanVien->anh_dai_dien)
                                    <img src="{{ asset('images/avt_hdv/' . $item->huongDanVien->anh_dai_dien) }}"
                                        alt="{{ $item->huongDanVien->ho_ten }}" class="guide-avatar-img">
                                @else
                                    <div class="guide-avatar">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                @endif

                                <div class="guide-info">

                                    <h5 class="guide-name">
                                        {{ $item->huongDanVien->ho_ten }}
                                    </h5>

                                    <span class="badge {{ $item->huongDanVien->trang_thai_hien_thi['class'] }}">
                                        {{ $item->huongDanVien->trang_thai_hien_thi['text'] }}
                                    </span>

                                    @if ($item->huongDanVien->mo_ta)
                                        <div class="guide-description">
                                            <h6>
                                                <i class="fas fa-id-card me-2"></i>
                                                Giới thiệu
                                            </h6>
                                            <p>
                                                {{ $item->huongDanVien->mo_ta }}
                                            </p>
                                        </div>
                                    @endif

                                    <div class="guide-meta">

                                        <div class="guide-item">
                                            <small>Email</small>
                                            <div class="guide-content">
                                                <i class="fas fa-envelope text-primary"></i>
                                                <span>{{ $item->huongDanVien->email }}</span>
                                            </div>
                                        </div>

                                        <div class="guide-item">
                                            <small>Số điện thoại</small>
                                            <div class="guide-content">
                                                <i class="fas fa-phone text-primary"></i>
                                                <span>{{ $item->huongDanVien->so_dien_thoai }}</span>
                                            </div>
                                        </div>

                                        <div class="guide-item">
                                            <small>Giới tính</small>
                                            <div class="guide-content">
                                                <i class="fas fa-venus-mars text-info"></i>
                                                <span>
                                                    {{ $item->huongDanVien->gioi_tinh == 'nam' ? 'Nam' : 'Nữ' }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="guide-item">
                                            <small>Tuổi</small>
                                            <div class="guide-content">
                                                <i class="fas fa-user-clock text-info"></i>
                                                <span>
                                                    {{ \Carbon\Carbon::parse($item->huongDanVien->ngay_sinh)->age }}
                                                    tuổi
                                                </span>
                                            </div>
                                        </div>

                                        <div class="guide-item">
                                            <small>Kinh nghiệm</small>
                                            <div class="guide-content">
                                                <i class="fas fa-briefcase text-warning"></i>
                                                <span>{{ $item->huongDanVien->so_nam_kinh_nghiem }}</span>
                                                năm kinh nghiệm
                                            </div>
                                        </div>

                                        <div class="guide-item">
                                            <small>Địa chỉ</small>
                                            <div class="guide-content">
                                                <i class="fas fa-map-marker-alt text-danger"></i>
                                                <span>{{ $item->huongDanVien->dia_chi }}</span>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        @else
                            <div class="alert alert-warning mb-0">
                                Chưa phân công hướng dẫn viên
                            </div>
                        @endif

                    </div>

                </div>

            </div>

        </div>

        {{-- MÔ TẢ --}}
        <div class="card shadow-sm mb-4">

            <div class="card-header section-header">
                <h5 class="mb-0">
                    <i class="fas fa-file-alt"></i>
                    Mô tả tour
                </h5>
            </div>

            <div class="card-body">
                {!! nl2br(e($item->tour->mo_ta)) !!}
            </div>

        </div>

        {{-- LỊCH TRÌNH --}}
        <div class="card shadow-sm mb-4">

            <div class="card-header section-header">
                <h5 class="mb-0">
                    <i class="fas fa-route"></i>
                    Tổng quan lịch trình
                </h5>
            </div>

            <div class="card-body">
                {!! nl2br(e($item->tour->tong_quan_lich_trinh)) !!}
            </div>

        </div>

        {{-- DỊCH VỤ --}}
        <div class="row">

            <div class="col-md-6">

                <div class="card shadow-sm">

                    <div class="card-header section-header">
                        Dịch vụ bao gồm
                    </div>

                    <div class="card-body">
                        {!! nl2br(e($item->tour->dich_vu_bao_gom)) !!}
                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="card shadow-sm">

                    <div class="card-header section-header">
                        Dịch vụ không bao gồm
                    </div>

                    <div class="card-body">
                        {!! nl2br(e($item->tour->dich_vu_khong_bao_gom)) !!}
                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- @push('styles')
        <style>
            .tour-image {
                width: 100%;
                height: 320px;
                object-fit: cover;
                border-radius: 12px;
                transition: .3s;
            }

            .tour-image:hover {
                transform: scale(1.02);
            }

            .card {
                border: none;
                border-radius: 12px;
            }

            .card-header {
                font-weight: 600;
            }

            .info-label {
                color: #6c757d;
                font-size: 14px;
            }

            .info-value {
                font-weight: 600;
                font-size: 16px;
            }

            .info-box {
                background: #f8fafc;
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                padding: 14px 16px;
                height: 100%;
            }

            .info-box small {
                display: block;
                color: #6b7280;
                margin-bottom: 4px;
                font-size: 13px;
            }

            .info-box .fw-semibold {
                font-size: 15px;
                color: #111827;
            }

            .tour-image {
                width: 100%;
                height: 320px;
                object-fit: cover;
                border-radius: 16px;
                transition: .3s;
            }

            .card {
                border: none;
                border-radius: 16px;
                overflow: hidden;
            }

            .card-header {
                padding: 16px 24px;
            }

            .card-body {
                padding: 24px;
            }

            .section-header {
                background: #fff;
                border-bottom: 1px solid #e5e7eb;
            }

            .card {
                border: none;
                border-radius: 16px;
                overflow: hidden;
            }

            .card-body {
                padding: 24px;
            }

            .info-box {
                background: #f8fafc;
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                padding: 14px 16px;
                height: 100%;
            }

            .info-box small {
                color: #6b7280;
                display: block;
                margin-bottom: 5px;
            }

            .stat-box {
                background: #f8fafc;
                border-radius: 12px;
                padding: 18px;
                text-align: center;
                border: 1px solid #e5e7eb;
            }

            .stat-box span {
                color: #6b7280;
                font-size: 13px;
            }

            .stat-box h5 {
                margin-top: 8px;
                margin-bottom: 0;
                font-weight: 700;
            }

            .price-box {
                background: #f8fafc;
                border-radius: 12px;
                padding: 20px;
                border: 1px solid #e5e7eb;
            }

            .price-box small {
                color: #6b7280;
                display: block;
                margin-bottom: 8px;
            }

            .tour-image {
                width: 100%;
                height: 320px;
                object-fit: cover;
                border-radius: 16px;
                transition: .3s;
            }

            .tour-image:hover {
                transform: scale(1.02);
            }

            .status-pill {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 8px 14px;
                border-radius: 999px;
                font-size: 13px;
                font-weight: 600;
            }

            .status-open {
                background: #e8f7ee;
                color: #198754;
            }

            .status-running {
                background: #fff7e6;
                color: #fd7e14;
            }

            .status-closed {
                background: #eef2ff;
                color: #4f46e5;
            }

            .status-full {
                background: #fdecec;
                color: #dc3545;
            }

            .status-ended {
                background: #f1f3f5;
                color: #6c757d;
            }

            .status-cancel {
                background: #212529;
                color: #fff;
            }

            .category-pill {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 8px 14px;
                border-radius: 999px;
                font-size: 13px;
                font-weight: 600;
                margin-left: 8px;
            }

            .category-domestic {
                background: #e7f5ff;
                color: #0d6efd;
            }

            .category-international {
                background: #f3e8ff;
                color: #7c3aed;
            }

            .info-card {
                background: #fff;
                border-radius: 12px;
                padding: 20px;
                border: 1px solid #e9ecef;
                box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
            }

            .info-title {
                font-size: 13px;
                color: #6c757d;
                margin-bottom: 8px;
            }

            .info-value {
                font-size: 22px;
                font-weight: 700;
            }

            .price-box {
                background: #fff;
                border: 1px solid #e9ecef;
                border-radius: 12px;
                padding: 20px;
            }

            .price-title {
                font-weight: 700;
                margin-bottom: 16px;
                color: #343a40;
            }

            .price-row {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 12px;
            }

            .price-label {
                min-width: 90px;
                color: #6c757d;
            }

            .price-adult {
                font-size: 24px;
                font-weight: 700;
                color: #0d6efd;
            }

            .price-child {
                font-size: 22px;
                font-weight: 600;
                color: #198754;
            }

            .kpi-card {
                background: #fff;
                border: 1px solid #edf2f7;
                border-radius: 14px;
                padding: 20px;
                text-align: center;
                transition: .3s;
                height: 100%;
            }

            .kpi-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
            }

            .kpi-icon {
                font-size: 22px;
                margin-bottom: 10px;
            }

            .kpi-title {
                color: #6b7280;
                font-size: 13px;
                margin-bottom: 6px;
            }

            .kpi-value {
                font-size: 18px;
                font-weight: 700;
            }
        </style>
    @endpush --}}
@endsection
