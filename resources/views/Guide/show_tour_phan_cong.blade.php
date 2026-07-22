@extends('layouts.guide')

@section('title','Chi tiết tour')

@section('page-title','Chi tiết tour')

@section('content')

<div class="row">

    <div class="col-lg-8">

        <div class="card mb-4">

            <div class="card-header d-flex justify-content-between align-items-center">

                <div>

                    <h4 class="mb-1 fw-bold">
                        {{ $tour->lichKhoiHanh->tour->ten_tour }}
                    </h4>

                    <small class="text-muted">
                        Mã phân công #{{ $tour->id }}
                    </small>

                </div>

                <span class="badge bg-success fs-6">
                    Đã phân công
                </span>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Ngày khởi hành
                        </label>

                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($tour->lichKhoiHanh->ngay_khoi_hanh)->format('d/m/Y') }}
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Ngày kết thúc
                        </label>

                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($tour->lichKhoiHanh->ngay_ket_thuc)->format('d/m/Y') }}
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Hướng dẫn viên
                        </label>

                        <div class="fw-semibold">
                            {{ $tour->hdv->ho_ten }}
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Phương tiện
                        </label>

                        <div class="fw-semibold">
                            {{ $tour->phuongTien->ten_phuong_tien }}
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Biển số xe
                        </label>

                        <div class="fw-semibold">
                            {{ $tour->phuongTien->bien_so_xe }}
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="text-muted">
                            Số khách
                        </label>

                        <div class="fw-semibold">
                            {{ $tour->lichKhoiHanh->so_cho_da_dat }}
                            /
                            {{ $tour->lichKhoiHanh->so_cho }}
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="card">

            <div class="card-header">

                <h5 class="mb-0">
                    Mô tả tour
                </h5>

            </div>

            <div class="card-body">

                {!! $tour->lichKhoiHanh->tour->mo_ta !!}

            </div>

        </div>

    </div>

    <div class="col-lg-4">

        <div class="card mb-4">

            <div class="card-header">

                Thao tác

            </div>

            <div class="card-body d-grid gap-2">

                <a href="{{ route('Guide.danh-sach-khach', $tour->id) }}" class="btn btn-primary">
                    <i class="fas fa-users me-2"></i>
                    Danh sách khách
                </a>

                <a href="" class="btn btn-success">
                    <i class="fas fa-user-check me-2"></i>
                    Check-in khách
                </a>

                <a href="{{ route('Guide.lich-trinh', $tour->id) }}" class="btn btn-warning text-white">
                    <i class="fas fa-calendar-alt me-2"></i>
                    lịch trình tour
                </a>

                <a href="" class="btn btn-danger">
                    <i class="fas fa-triangle-exclamation me-2"></i>
                    Báo cáo sự cố
                </a>
                <a href="javascript:history.back()" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Quay lại
                </a>
            </div>

        </div>

        <div class="card">

            <div class="card-header">
                Thông tin nhanh
            </div>

            <div class="card-body">

                <table class="table table-borderless mb-0">

                    <tr>
                        <th>Tour</th>
                        <td>{{ $tour->lichKhoiHanh->tour->ten_tour }}</td>
                    </tr>

                    <tr>
                        <th>Xe</th>
                        <td>{{ $tour->phuongTien->ten_phuong_tien }}</td>
                    </tr>

                    <tr>
                        <th>Biển số</th>
                        <td>{{ $tour->phuongTien->bien_so_xe }}</td>
                    </tr>

                    <tr>
                        <th>Khách</th>
                        <td>{{ $tour->lichKhoiHanh->so_cho_da_dat }}</td>
                    </tr>

                    <tr>
                        <th>Trạng thái</th>
                        <td>
                            <span class="badge bg-success">
                                Đã phân công
                            </span>
                        </td>
                    </tr>

                </table>

            </div>

        </div>
    </div>
@endsection
