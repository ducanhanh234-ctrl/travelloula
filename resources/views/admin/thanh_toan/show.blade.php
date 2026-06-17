@extends('layouts.admin')

@section('title', 'Chi tiết thanh toán')

@section('breadcrumb')
<li class="breadcrumb-item">

    <a href="{{ route('Admin.thanh_toans.index') }}">

        Quản lý Thanh toán
    </a>
</li>
<li class="breadcrumb-item active">
    Chi tiết giao dịch
</li>
@endsection

@section('content')

<div class="fade-in">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Chi tiết giao dịch #{{ $thanh_toan->ma_giao_dich }}
            </h3>

            <p class="text-muted mb-0">
                Theo dõi và kiểm tra thông tin giao dịch thanh toán
            </p>
        </div>

        <div class="d-flex gap-2">




            <a href="{{ route('Admin.thanh_toans.edit_status', $thanh_toan->id) }}" class="btn btn-success">

                <i class="fas fa-edit"></i>
                Cập Nhật Trạng Thái
            </a>


            <a href="{{ route('Admin.thanh_toans.index') }}" class="btn btn-secondary">

                <i class="fas fa-arrow-left"></i>
                Quay lại
            </a>

        </div>

    </div>

    <div class="row">

        {{-- Cột trái --}}
        <div class="col-lg-8">

            {{-- Thông tin giao dịch --}}
            <div class="card mb-4">

                <div class="card-header">
                    <i class="fas fa-receipt me-2"></i>
                    Thông tin giao dịch
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">
                                Mã giao dịch
                            </label>
                            <h6>{{ $thanh_toan->ma_giao_dich }}</h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">
                                Trạng thái
                            </label>
                            <div>
                                @if ($thanh_toan->trang_thai == 1)
                                <span class="badge badge-success">Đã thanh toán</span>
                                @elseif ($thanh_toan->trang_thai == 2)
                                <span class="badge badge-warning">Chờ xử lý</span>
                                @elseif ($thanh_toan->trang_thai == 3)
                                <span class="badge badge-danger">Thất bại</span>
                                @elseif ($thanh_toan->trang_thai == 4)
                                <span class="badge badge-info">Hoàn tiền</span>
                                @else
                                <span class="badge badge-secondary">Không xác định</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">
                                Số tiền
                            </label>
                            <h5 class="text-success fw-bold">
                                {{ number_format($thanh_toan->so_tien, 0, ',', '.') }}đ
                            </h5>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">
                                Phương thức
                            </label>
                            <h6>{{ $thanh_toan->phuong_thuc_thanh_toan }}</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">
                                Ngày thanh toán
                            </label>
                            <h6>{{ $thanh_toan->thoi_gian_thanh_toan ? date('d/m/Y H:i:s', strtotime($thanh_toan->thoi_gian_thanh_toan)) : 'Không xác định' }}</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">
                                Mã giao dịch
                            </label>
                            <h6>{{ $thanh_toan->ma_giao_dich }}</h6>
                        </div>

                    </div>

                </div>

            </div>

            {{-- Thông tin khách hàng --}}
            <div class="card mb-4">

                <div class="card-header">
                    <i class="fas fa-user me-2"></i>
                    Thông tin khách hàng
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">
                                Họ tên
                            </label>
                            <h6>{{ $thanh_toan->nguoiDung->name }}</h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">
                                Số điện thoại
                            </label>
                            <h6>{{ $thanh_toan->nguoiDung->phone }}</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">
                                Email
                            </label>
                            <h6>{{ $thanh_toan->nguoiDung->email }}</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">
                                Số người đi
                            </label>
                            <h6>{{ $thanh_toan->so_nguoi_di }} người</h6>
                        </div>

                    </div>

                </div>

            </div>

            {{-- Thông tin tour --}}
            <div class="card">

                <div class="card-header">
                    <i class="fas fa-map-marked-alt me-2"></i>
                    Thông tin Tour
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">
                                Tên tour
                            </label>
                            <h6>{{ $thanh_toan->datTour->tour->ten_tour }}</h6>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted">
                                Mã đơn đặt
                            </label>
                            <h6>{{ $thanh_toan->datTour->ma_don_dat }}</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">
                                Ngày khởi hành
                            </label>
                            <h6>{{ $thanh_toan->datTour->tour->ngay_khoi_hanh }}</h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted">
                                Điểm đến
                            </label>
                            <h6>{{ $thanh_toan->datTour->tour->diem_den }}</h6>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Cột phải --}}
        <div class="col-lg-4">

            {{-- Trạng thái --}}
            <div class="card mb-4">

                <div class="card-header">
                    <i class="fas fa-chart-line me-2"></i>
                    Trạng thái thanh toán
                </div>

                <div class="card-body text-center">

                    <div class="mb-3">
                        @if($thanh_toan->trang_thai == 1)
                        <i class="fas fa-check-circle text-success" style="font-size:60px"></i>
                        @elseif($thanh_toan->trang_thai == 2)
                        <i class="fas fa-hourglass-half text-warning" style="font-size:60px"></i>
                        @elseif($thanh_toan->trang_thai == 3)
                        <i class="fas fa-times-circle text-danger" style="font-size:60px"></i>
                        @elseif($thanh_toan->trang_thai == 4)
                        <i class="fas fa-undo text-info" style="font-size:60px"></i>
                        @else
                        <i class="fas fa-question-circle text-secondary" style="font-size:60px"></i>
                        @endif
                    </div>

                    <h5 class="fw-bold">
                        @if ($thanh_toan->trang_thai == 1)
                        <span class="badge badge-success">
                            Đã thanh toán
                        </span>
                        @elseif ($thanh_toan->trang_thai == 2)
                        <span class="badge badge-warning">
                            Chờ xử lý
                        </span>
                        @elseif ($thanh_toan->trang_thai == 3)
                        <span class="badge badge-danger">
                            Thất bại
                        </span>
                        @elseif ($thanh_toan->trang_thai == 4)
                        <span class="badge badge-info">
                            Hoàn tiền
                        </span>
                        @else
                        <span class="badge badge-secondary">
                            Không xác định
                        </span>
                        @endif
                    </h5>

                    <p class="text-muted">
                        Giao dịch đã được xác nhận bởi hệ thống.
                    </p>

                </div>

            </div>

            {{-- Timeline --}}
            <div class="card">

                <div class="card-header">
                    <i class="fas fa-history me-2"></i>
                    Lịch sử giao dịch
                </div>

                <div class="card-body">

                    <div class="border-start ps-3">

                        {{-- <div class="mb-4">
                            <h6 class="mb-1">
                                Tạo giao dịch
                            </h6>

                            <small class="text-muted">
                                10/06/2026 - 15:20
                            </small>
                        </div>

                        <div class="mb-4">
                            <h6 class="mb-1 text-primary">
                                Chuyển tới VNPay
                            </h6>

                            <small class="text-muted">
                                10/06/2026 - 15:25
                            </small>
                        </div>

                        <div>
                            <h6 class="mb-1">
                                @if ($thanh_toan->trang_thai == 1)
                                <span class="badge badge-success">
                                    Đã thanh toán
                                </span>
                                @elseif ($thanh_toan->trang_thai == 2)
                                <span class="badge badge-warning">
                                    Chờ xử lý
                                </span>
                                @elseif ($thanh_toan->trang_thai == 3)
                                <span class="badge badge-danger">
                                    Thất bại
                                </span>
                                @elseif ($thanh_toan->trang_thai == 4)
                                <span class="badge badge-info">
                                    Hoàn tiền
                                </span>
                                @else
                                <span class="badge badge-secondary">
                                    Không xác định
                                </span>
                                @endif
                            </h6>

                            <small class="text-muted">
                                10/06/2026 - 15:30
                            </small>
                        </div> --}}

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
