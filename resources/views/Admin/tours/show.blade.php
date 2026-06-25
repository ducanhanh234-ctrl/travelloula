@extends('layouts/admin_pro')
@section('title', 'Quản Lý Tour - Chi tiết')

@section('vendor-style')
@vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
@vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('page-script')
@vite('resources/assets/js/dashboards-analytics.js')
@endsection
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-1">Chi tiết Tour</h4>
        <p class="text-muted mb-0">
            Xem thông tin chi tiết tour du lịch
        </p>
    </div>

    <div>
        <a href="{{ route('Admin.tours.edit', $tour) }}" class="btn btn-warning me-2">
            <i class="bx bx-edit-alt"></i>
            Chỉnh sửa
        </a>

        <a href="{{ route('Admin.tours.index') }}" class="btn btn-outline-secondary">
            <i class="bx bx-arrow-back"></i>
            Quay lại
        </a>
    </div>
</div>
<div class="row">

    <div class="col-lg-4">

        <div class="card">
            <div class="card-body text-center">

                @if($tour->anh_dai_dien)
                <img src="{{ asset('storage/'.$tour->anh_dai_dien) }}" class="img-fluid rounded" style="max-height:300px; object-fit:cover;">
                @endif

                <h5 class="mt-3 mb-1">
                    {{ $tour->ten_tour }}
                </h5>

                @if($tour->trang_thai == 'active')
                <span class="badge bg-label-success">
                    Đang hoạt động
                </span>
                @else
                <span class="badge bg-label-danger">
                    Ngừng hoạt động
                </span>
                @endif

            </div>
        </div>

    </div>

    <div class="col-lg-8">

        <div class="card">

            <div class="card-header">
                <h5 class="mb-0">
                    Thông tin Tour
                </h5>
            </div>

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6">
                        <small class="text-muted">Danh mục</small>
                        <div class="fw-semibold">
                            {{ $tour->danhMuc?->ten_danh_muc }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted">Giá Tour</small>
                        <div class="fw-semibold text-primary">
                            {{ number_format($tour->gia_tour) }} VNĐ
                        </div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted">Thời lượng</small>
                        <div class="fw-semibold">
                            {{ $tour->thoi_luong }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted">Số khách tối đa</small>
                        <div class="fw-semibold">
                            {{ $tour->so_khach_toi_da }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted">Khởi hành</small>
                        <div class="fw-semibold">
                            {{ $tour->dia_diem_khoi_hanh }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted">Điểm đến</small>
                        <div class="fw-semibold">
                            {{ $tour->diem_den }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted">Phương tiện</small>
                        <div class="fw-semibold">
                            {{ $tour->phuong_tien }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <small class="text-muted">Khách sạn</small>
                        <div class="fw-semibold">
                            {{ $tour->tieu_chuan_khach_san }}
                        </div>
                    </div>

                    <div class="col-12">
                        <small class="text-muted">Slug</small>
                        <div class="fw-semibold">
                            {{ $tour->duong_dan }}
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Mô tả Tour</h5>
    </div>

    <div class="card-body">
        {!! nl2br(e($tour->mo_ta)) !!}
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Tổng quan lịch trình</h5>
    </div>

    <div class="card-body">
        {!! nl2br(e($tour->tong_quan_lich_trinh)) !!}
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Dịch vụ bao gồm</h5>
    </div>

    <div class="card-body">
        {!! nl2br(e($tour->dich_vu_bao_gom)) !!}
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Dịch vụ không bao gồm</h5>
    </div>

    <div class="card-body">
        {!! nl2br(e($tour->dich_vu_khong_bao_gom)) !!}
    </div>
</div>

@endsection
