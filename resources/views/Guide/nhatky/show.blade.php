@extends('Layouts.guide')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold text-success">
                <i class="fas fa-book-open"></i>
                Chi tiết nhật ký
            </h2>

            <small class="text-muted">
                Thông tin chi tiết hoạt động của hướng dẫn viên.
            </small>

        </div>

        <a href="{{ route('Guide.nhatky.index') }}"
           class="btn btn-outline-success">

            <i class="fas fa-arrow-left"></i>

            Quay lại

        </a>

    </div>


    <div class="card shadow-sm border-0">

        <div class="card-body">

            <div class="row mb-4">

                <div class="col-md-6">

                    <strong>Thời gian</strong>

                    <p>
                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                    </p>

                </div>

                <div class="col-md-6">

                    <strong>Hành động</strong>

                    <p>

                        @if($log->hanh_dong == 'CHECK_IN')

                            <span class="badge bg-success">
                                Check-in
                            </span>

                        @elseif($log->hanh_dong == 'CHECK_OUT')

                            <span class="badge bg-warning text-dark">
                                Check-out
                            </span>

                        @else

                            <span class="badge bg-secondary">
                                {{ $log->hanh_dong }}
                            </span>

                        @endif

                    </p>

                </div>

            </div>


            <hr>


            <div class="row">

                <div class="col-md-6 mb-3">

                    <strong>Tour</strong>

                    <p>
                        {{ $log->chiTiet->lichTrinh->tour->ten_tour ?? '-' }}
                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Địa điểm</strong>

                    <p>
                        {{ $log->chiTiet->tieu_de ?? '-' }}
                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Khách hàng</strong>

                    <p>
                        {{ $log->khachHang->ho_ten ?? '-' }}
                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <strong>Hướng dẫn viên</strong>

                    <p>
                        {{ $log->huongDanVien->ho_ten ?? '-' }}
                    </p>

                </div>

            </div>


            <hr>


            <strong>Nội dung</strong>

            <div class="alert alert-light border mt-2">

                {{ $log->noi_dung }}

            </div>

        </div>

    </div>

</div>

@endsection
