@extends('Layouts.admin')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">
                <i class="fas fa-map-marked-alt text-primary"></i>
                Chi tiết Tour
            </h3>

            <a href="{{ route('Admin.tours.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Quay lại
            </a>
        </div>

        <div class="row">

            {{-- Ảnh --}}
            <div class="col-lg-5">

                <div class="card">

                    <div class="card-body text-center">

                        @if ($tour->anh_dai_dien)
                            <img src="{{ asset('storage/' . $tour->anh_dai_dien) }}" class="img-fluid rounded shadow"
                                style="width:100%;height:450px;object-fit:cover;">
                        @else
                            <img src="https://via.placeholder.com/600x450" class="img-fluid rounded shadow">
                        @endif

                    </div>

                </div>

            </div>

            {{-- Thông tin --}}
            <div class="col-lg-7">

                <div class="card">

                    <div class="card-header">
                        <strong>Thông tin cơ bản</strong>
                    </div>

                    <div class="card-body p-0">

                        <table class="table table-bordered mb-0">

                            <tr>
                                <th width="220">Tên tour</th>
                                <td>{{ $tour->ten_tour }}</td>
                            </tr>

                            <tr>
                                <th>Slug</th>
                                <td>{{ $tour->duong_dan }}</td>
                            </tr>

                            <tr>
                                <th>Danh mục</th>
                                <td>{{ $tour->danhMuc->ten_danh_muc ?? '' }}</td>
                            </tr>

                            <tr>
                                <th>Trạng thái</th>

                                <td>

                                    @if ($tour->trang_thai == 'active')
                                        <span class="badge badge-success">
                                            Hoạt động
                                        </span>
                                    @else
                                        <span class="badge badge-danger">
                                            Ngừng hoạt động
                                        </span>
                                    @endif

                                </td>

                            </tr>

                        </table>

                    </div>

                </div>

                {{-- Giá --}}

                <div class="card mt-3">

                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-money-bill-wave text-success"></i>
                            Bảng giá tour
                        </h5>
                    </div>

                    <div class="card-body p-0">

                        <table class="table table-bordered table-hover text-center mb-0">

                            <thead class="bg-light">

                                <tr>

                                    <th style="width:25%">Giá tour</th>

                                    <th style="width:25%">Người lớn</th>

                                    <th style="width:25%">Trẻ em</th>

                                    <th style="width:25%">Em bé</th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr>

                                    <td>

                                        <h5 class="text-danger mb-1">
                                            {{ number_format($tour->gia_tour) }}đ
                                        </h5>

                                        <small class="text-muted">
                                            Giá niêm yết
                                        </small>

                                    </td>

                                    <td>

                                        <h5 class="text-primary mb-1">
                                            {{ number_format($tour->gia_nguoi_lon) }}đ
                                        </h5>

                                        <small class="text-muted">
                                            Từ 12 tuổi
                                        </small>

                                    </td>

                                    <td>

                                        <h5 class="text-success mb-1">
                                            {{ number_format($tour->gia_tre_em) }}đ
                                        </h5>

                                        <small class="text-muted">
                                            5 - 11 tuổi
                                        </small>

                                    </td>

                                    <td>

                                        <h5 class="text-info mb-1">
                                            {{ number_format($tour->gia_em_be) }}đ
                                        </h5>

                                        <small class="text-muted">
                                            Dưới 5 tuổi
                                        </small>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

        {{-- Thông tin chi tiết --}}

        <div class="card">

            <div class="card-header">
                <strong>Thông tin chi tiết</strong>
            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4 mb-3">

                        <div class="border rounded p-3 h-100">

                            <strong>Thời lượng</strong>

                            <hr>

                            {{ $tour->thoi_luong }}

                        </div>

                    </div>

                    <div class="col-md-4 mb-3">

                        <div class="border rounded p-3 h-100">

                            <strong>Điểm khởi hành</strong>

                            <hr>

                            {{ $tour->dia_diem_khoi_hanh }}

                        </div>

                    </div>

                    <div class="col-md-4 mb-3">

                        <div class="border rounded p-3 h-100">

                            <strong>Điểm đến</strong>

                            <hr>

                            {{ $tour->diem_den }}

                        </div>

                    </div>

                    {{-- <div class="col-md-4 mb-3">

                        <div class="border rounded p-3 h-100">

                            <strong>Phương tiện</strong>

                            <hr>

                            {{ $tour->phuong_tien }}

                        </div>

                    </div> --}}

                    <div class="col-md-4 mb-3">

                        <div class="border rounded p-3 h-100">

                            <strong>Khách sạn</strong>

                            <hr>

                            {{ $tour->tieu_chuan_khach_san }}

                        </div>

                    </div>

                    <div class="col-md-4 mb-3">

                        <div class="border rounded p-3 h-100">

                            <strong>Số khách tối đa</strong>

                            <hr>

                            {{ $tour->so_khach_toi_da }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Mô tả --}}

        <div class="card">

            <div class="card-header bg-primary">

                <strong>Mô tả Tour</strong>

            </div>

            <div class="card-body">

                {!! nl2br(e($tour->mo_ta)) !!}

            </div>

        </div>

        {{-- Lịch trình --}}

        <div class="card">

            <div class="card-header bg-info">

                <strong>Tổng quan lịch trình</strong>

            </div>

            <div class="card-body">

                {!! nl2br(e($tour->tong_quan_lich_trinh)) !!}

            </div>

        </div>

        <div class="row">

            <div class="col-md-6">

                <div class="card card-success">

                    <div class="card-header">

                        <strong>Dịch vụ bao gồm</strong>

                    </div>

                    <div class="card-body">

                        {!! nl2br(e($tour->dich_vu_bao_gom)) !!}

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="card card-danger">

                    <div class="card-header">

                        <strong>Dịch vụ không bao gồm</strong>

                    </div>

                    <div class="card-body">

                        {!! nl2br(e($tour->dich_vu_khong_bao_gom)) !!}

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
