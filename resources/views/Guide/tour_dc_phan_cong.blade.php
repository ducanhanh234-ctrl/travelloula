@extends('layouts.guide')

@section('title','Tour được phân công')

@section('page-title','Tour được phân công')

@section('content')

<div class="row mb-4">

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <h6 class="text-muted">
                    Tổng tour
                </h6>

                <h2 class="fw-bold text-success">
                    {{ $tours->count() }}
                </h2>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <h6 class="text-muted">
                    Đang thực hiện
                </h6>

                <h2 class="fw-bold text-primary">
                    {{ $tours->where('trang_thai','dang_dien_ra')->count() }}
                </h2>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <h6 class="text-muted">
                    Hoàn thành
                </h6>

                <h2 class="fw-bold text-success">
                    {{ $tours->where('trang_thai','hoan_thanh')->count() }}
                </h2>

            </div>
        </div>
    </div>

</div>

<div class="row">

    @forelse($tours as $tour)

    <div class="col-lg-6 mb-4">

        <div class="card h-100">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>

                        <h4 class="fw-bold mb-2">
                            {{ $tour->lichKhoiHanh->tour->ten_tour }}
                        </h4>

                        <span class="badge bg-success">
                            {{ ucfirst($tour->lichKhoiHanh->trang_thai == 2 ? 'Đã Phân Công' : 'Chưa Diễn Ra') }}
                        </span>

                    </div>

                    <div>

                        <i class="fa-solid fa-route fa-2x text-success"></i>

                    </div>

                </div>

                <hr>

                <div class="row gy-3">

                    <div class="col-6">

                        <small class="text-muted">
                            Ngày khởi hành
                        </small>

                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($tour->lichKhoiHanh->ngay_khoi_hanh)->format('d/m/Y') }}
                        </div>

                    </div>

                    <div class="col-6">

                        <small class="text-muted">
                            Phương tiện
                        </small>

                        <div class="fw-semibold">
                            {{ $tour->phuongTien->ten_phuong_tien ?? '---' }} ({{ $tour->phuongTien->bien_so_xe ?? '---' }})
                        </div>

                    </div>

                    <div class="col-6">

                        <small class="text-muted">
                            Ngày kết thúc
                        </small>

                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($tour->lichKhoiHanh->ngay_ket_thuc)->format('d/m/Y') }}
                        </div>

                    </div>

                    <div class="col-6">

                        <small class="text-muted">
                            Số chỗ
                        </small>

                        <div class="fw-semibold">
                            {{ $tour->lichKhoiHanh->so_cho_da_dat }}
                            /
                            {{ $tour->lichKhoiHanh->so_cho }}
                        </div>

                    </div>

                </div>

            </div>

            <div class="card-footer bg-white border-0">

                <a href="{{ route('Guide.tour-phan-cong.show', $tour->id) }}" class="btn btn-success">

                    <i class="fa-solid fa-eye"></i>

                    Chi tiết

                </a>

            </div>

        </div>

    </div>

    @empty

    <div class="col-12">

        <div class="card">

            <div class="card-body text-center py-5">

                <i class="fa-solid fa-map-location-dot fa-4x text-secondary mb-3"></i>

                <h4>Chưa có tour nào được phân công</h4>

                <p class="text-muted">
                    Khi quản trị viên phân công tour, tour sẽ hiển thị tại đây.
                </p>

            </div>

        </div>

    </div>

    @endforelse

</div>

@endsection
