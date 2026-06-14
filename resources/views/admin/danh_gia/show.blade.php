@extends('layouts.admin')

@section('title', 'Chi tiết đánh giá')

@section('breadcrumb')
<li class="breadcrumb-item">
    <a href="{{ route('admin.danh_gias.index') }}">
        Quản lý Đánh giá
    </a>
</li>
<li class="breadcrumb-item active">
    Chi tiết đánh giá
</li>
@endsection

@section('content')

<div class="fade-in">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Chi tiết đánh giá
            </h3>

            <p class="text-muted mb-0">
                Xem thông tin chi tiết đánh giá của khách hàng
            </p>
        </div>

        <a href="{{ route('admin.danh_gias.index') }}" class="btn btn-secondary">

            <i class="fas fa-arrow-left"></i>
            Quay lại

        </a>

    </div>

    <div class="row">

        {{-- Nội dung chính --}}
        <div class="col-lg-8">

            {{-- Đánh giá --}}
            <div class="card mb-4">

                <div class="card-header">
                    <i class="fas fa-star me-2"></i>
                    Nội dung đánh giá
                </div>

                <div class="card-body">

                    <div class="mb-3">

                        @for ($i = 1; $i <= 5; $i++) <i class="fas fa-star fs-4 {{ $i <= $danh_gia->so_sao ? 'text-warning' : 'text-secondary' }}">
                            </i>
                            @endfor

                            <span class="ms-2 fw-bold">
                                {{ $danh_gia->so_sao }}/5
                            </span>

                    </div>

                    <div class="border rounded p-3 bg-light">

                        {{ $danh_gia->noi_dung_danh_gia ?? 'Không có nội dung đánh giá.' }}

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
                            <label class="text-muted">
                                Họ tên
                            </label>

                            <div class="fw-semibold">
                                {{ $danh_gia->khachHangDatTour->ho_ten ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="text-muted">
                                Số điện thoại
                            </label>

                            <div class="fw-semibold">
                                {{ $danh_gia->khachHangDatTour->so_dien_thoai ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted">
                                Email
                            </label>

                            <div class="fw-semibold">
                                {{ $danh_gia->khachHangDatTour->email ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted">
                                Loại hành khách
                            </label>

                            <div class="fw-semibold">
                                {{ $danh_gia->khachHangDatTour->loai_hanh_khach ?? 'N/A' }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Sidebar --}}
        <div class="col-lg-4">

            {{-- Thông tin tour --}}
            <div class="card mb-4">

                <div class="card-header">
                    <i class="fas fa-map-marked-alt me-2"></i>
                    Thông tin Tour
                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <label class="text-muted">
                            Tên tour
                        </label>

                        <div class="fw-semibold">
                            {{ $danh_gia->tour->ten_tour ?? 'N/A' }}
                        </div>

                    </div>

                    <div>

                        <label class="text-muted">
                            Mã tour
                        </label>

                        <div class="fw-semibold">
                            #{{ $danh_gia->tour->id ?? 'N/A' }}
                        </div>

                    </div>

                </div>

            </div>

            {{-- Thông tin đánh giá --}}
            <div class="card mb-4">

                <div class="card-header">
                    <i class="fas fa-info-circle me-2"></i>
                    Thông tin đánh giá
                </div>

                <div class="card-body">

                    <div class="mb-3">

                        <label class="text-muted">
                            Mã đánh giá
                        </label>

                        <div class="fw-semibold">
                            #DG{{ $danh_gia->id }}
                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="text-muted">
                            Ngày đánh giá
                        </label>

                        <div class="fw-semibold">
                            {{ strtotime($danh_gia->thoi_gian_danh_gia) ? date('d/m/Y H:i:s', strtotime($danh_gia->thoi_gian_danh_gia)) : 'N/A' }}
                        </div>

                    </div>



                </div>

            </div>

            {{-- Thao tác --}}
            <div class="card">

                <div class="card-header">
                    <i class="fas fa-cogs me-2"></i>
                    Thao tác
                </div>

                <div class="card-body">

                    <a href="{{ route('admin.danh_gias.index') }}" class="btn btn-secondary w-100 mb-2">

                        <i class="fas fa-arrow-left"></i>
                        Quay lại danh sách

                    </a>

                    <form action="{{ route('admin.danh_gias.destroy', $danh_gia->id) }}" method="POST">

                        @csrf
                        @method('DELETE')

                        <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa đánh giá này?')" class="btn btn-danger w-100">

                            <i class="fas fa-trash"></i>
                            Xóa đánh giá

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
