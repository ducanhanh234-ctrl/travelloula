@extends('layouts.admin')
@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                Chi tiết đặt tour
            </h2>
            <p class="text-muted mb-0">
                Mã booking: {{ $booking->ma_dat_tour }}
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('Admin.dat_tours.edit', $booking->id) }}"
               class="btn btn-warning">
                <i class="fas fa-edit me-1"></i>
                Sửa
            </a>
            <a href="{{ route('Admin.quan_ly_dat_tour.index') }}"
               class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>
                Quay lại
            </a>
        </div>
    </div>

<div class="card shadow border-0"></div>
    <div class="card-body">

        {{-- Thông tin người đặt --}}
        <h4 class="mb-3 text-primary">
            <i class="fas fa-user me-2"></i>
                Thông tin người đặt
        </h4>
        @if($booking->nguoiDung)
            <div class="row mb-4">
                <div class="col-md-4">
                    <strong>Họ tên:</strong>
                    <br>
                    {{ $booking->nguoiDung->name }}
                </div>

                <div class="col-md-4">
                    <strong>Email:</strong>
                    <br>
                    {{ $booking->nguoiDung->email }}
                </div>

                <div class="col-md-4">
                    <strong>Loại khách:</strong>
                    <br>
                    Thành viên hệ thống
                </div>
            </div>

        @else
            <div class="row mb-4">
                <div class="col-md-4">
                    <strong>Họ tên:</strong>
                    <br>
                    {{ $booking->ten_nguoi_dat ?? 'Chưa có' }}
                </div>

                <div class="col-md-4">
                    <strong>Số điện thoại:</strong>
                    <br>
                    {{ $booking->so_dien_thoai ?? 'Chưa có' }}
                </div>

                <div class="col-md-4">
                    <strong>Email:</strong>
                    <br>
                    {{ $booking->email ?? 'Chưa có' }}
                </div>
            </div>
        @endif
    <hr>

        {{-- Thông tin tour --}}
        <h4 class="mb-3 text-success">
            <i class="fas fa-map-marked-alt me-2"></i>
                Thông tin tour
        </h4>

        <div class="row mb-4">
            <div class="col-md-4">
                <strong>Tên tour:</strong>
                <br>
                {{ $booking->tour->ten_tour ?? 'Không có dữ liệu' }}
            </div>

            <div class="col-md-4">
                <strong>Danh mục:</strong>
                <br>
                {{ $booking->tour?->danhMuc?->ten_danh_muc ?? 'Chưa có' }}
            </div>

            <div class="col-md-4">
                <strong>Ngày đặt:</strong>
                <br>
                {{ $booking->ngay_dat?->format('d/m/Y H:i') }}
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <strong>Ngày khởi hành:</strong>
                <br>
                {{ $booking->lichKhoiHanh?->ngay_khoi_hanh?->format('d/m/Y') }}
            </div>

            <div class="col-md-4">
                <strong>Ngày kết thúc:</strong>
                <br>
                {{ $booking->lichKhoiHanh?->ngay_ket_thuc?->format('d/m/Y') }}
            </div>

        </div>

        <hr>

        {{-- Thông tin đoàn --}}
        <div class="accordion mb-4" id="bookingAccordion">

    <div class="accordion-item">

        <h2 class="accordion-header">

            <button class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapsePassengers"
                    aria-expanded="true">

                <div class="d-flex justify-content-between align-items-center w-100 me-3">
    <div>
        <i class="fas fa-users me-2 text-primary"></i>
        <strong>Thông tin đoàn</strong>
    </div>

    <span class="badge bg-primary">
        {{ $booking->khachHangDatTour->count() }} hành khách
    </span>
</div>

            </button>

        </h2>

        <div id="collapsePassengers"
     class="accordion-collapse collapse show">

    <div class="accordion-body">

    <div class="row g-3 mb-4">

    <div class="col-md-6">
        <div class="card border-primary shadow-sm h-100">
            <div class="card-body text-center">

                <i class="fas fa-user fa-2x text-primary mb-2"></i>

                <h6 class="text-muted mb-1">
                    Người lớn
                </h6>

                <h3 class="fw-bold text-primary mb-0">
                    {{ $booking->so_nguoi_lon }}
                </h3>

            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-success shadow-sm h-100">
            <div class="card-body text-center">

                <i class="fas fa-child fa-2x text-success mb-2"></i>

                <h6 class="text-muted mb-1">
                    Trẻ em
                </h6>

                <h3 class="fw-bold text-success mb-0">
                    {{ $booking->so_tre_em }}
                </h3>

            </div>
        </div>
    </div>

</div>

<hr class="mb-4">

        {{-- Danh sách hành khách --}}


     <div class="table-responsive">
    <table class="table table-hover table-striped align-middle">

        <thead class="table-primary">
            <tr>
                <th width="60">#</th>
                <th>Họ tên</th>
                <th>Giới tính</th>
                <th>Ngày sinh</th>
                <th>Quốc tịch</th>
                <th>Loại giấy tờ</th>
                <th>Số giấy tờ</th>
                <th>Số điện thoại</th>
                <th>Loại khách</th>
                <th>Yêu cầu đặc biệt</th>
            </tr>
        </thead>

        <tbody>
            @forelse($booking->khachHangDatTour as $index => $khach)
                <tr>
                    <td>
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $khach->ho_ten }}
                    </td>

                    <td>
                        {{ $khach->gioi_tinh ?? '-' }}
                    </td>

                    <td>
                        {{ $khach->ngay_sinh
                            ? $khach->ngay_sinh->format('d/m/Y')
                            : '-'
                        }}
                    </td>

                    <td>
                        {{ $khach->quoc_tich ?? '-' }}
                    </td>

                    <td> {{ $khach->loai_giay_to ?? '-' }} </td>

                    <td>
                        {{ $khach->so_giay_to ?? '-' }}
                    </td>

                    <td>
                        {{ $khach->so_dien_thoai ?? '-' }}
                    </td>

                    <td>
                        @switch($khach->loai_hanh_khach)
                            @case('adult')
                                Người lớn
                                @break
                            @case('child')
                                Trẻ em
                                @break
                            @default
                                {{ $khach->loai_hanh_khach }}
                        @endswitch
                    </td>

                    <td>
                        {{ $khach->yeu_cau_dac_biet ?? '-' }}
                    </td>
                </tr>

                        @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    Chưa có hành khách
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

                    </div> {{-- accordion-body --}}
        </div> {{-- accordion-collapse --}}
    </div> {{-- accordion-item --}}
</div> {{-- accordion --}}

<hr>

        {{-- Thanh toán --}}
        <h4 class="mb-3 text-danger">
            <i class="fas fa-money-bill-wave me-2"></i>
                Thanh toán
        </h4>

        <div class="row g-3">
            <div class="col-md-3">
                <div class="card border-primary">
                    <div class="card-body text-center">
                <h6>Tổng tiền</h6>
                <h5 class="text-primary">
                    {{ number_format($booking->tong_tien,0,',','.') }} đ
                </h5>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-success">
            <div class="card-body text-center">
                <h6>Đã thanh toán</h6>
                <h5 class="text-success">
                    {{ number_format($booking->so_tien_da_thanh_toan,0,',','.') }} đ
                </h5>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-warning">
            <div class="card-body text-center">
                <h6>Còn lại</h6>
                <h5 class="text-warning">
                    {{ number_format($booking->tong_tien - $booking->so_tien_da_thanh_toan,0,',','.') }} đ
                </h5>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-info">
            <div class="card-body text-center">
                <h6>Trạng thái</h6>

                @if($booking->trang_thai == 'cho_xac_nhan')
                    <span class="badge bg-warning">
                        Chờ xác nhận
                    </span>
                @elseif($booking->trang_thai == 'da_xac_nhan')
                    <span class="badge bg-info">
                        Đã xác nhận
                    </span>
                @elseif($booking->trang_thai == 'da_thanh_toan')
                    <span class="badge bg-success">
                        Đã thanh toán
                    </span>
                @elseif($booking->trang_thai == 'da_huy')
                    <span class="badge bg-danger">
                        Đã hủy
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
