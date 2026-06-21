@extends('layouts.admin')
@section('content')

<div class="container-fluid">
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold">Chi tiết đặt tour</h2>
        <p class="text-muted">
            Mã booking: {{ $booking->ma_dat_tour }}
        </p>
    </div>

    <a href="{{ route('Admin.quan_ly_dat_tour.index') }}"
       class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Quay lại
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        {{-- Thông tin người đặt --}}
        <h4 class="mb-3">
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

        <hr>

        {{-- Thông tin tour --}}
        <h4 class="mb-3">
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
        <h4 class="mb-3">
            Thông tin đoàn
        </h4>

        <div class="row mb-4">

            <div class="col-md-4">
                <strong>Người lớn:</strong>
                <br>
                {{ $booking->so_nguoi_lon }}
            </div>

            <div class="col-md-4">
                <strong>Trẻ em:</strong>
                <br>
                {{ $booking->so_tre_em }}
            </div>

            <div class="col-md-4">
                <strong>Em bé:</strong>
                <br>
                {{ $booking->so_em_be }}
            </div>
        </div>
        <hr>

        {{-- Danh sách hành khách --}}
        <h4 class="mb-3">
            Danh sách hành khách
        </h4>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Họ tên</th>
                        <th>Giới tính</th>
                        <th>Năm sinh</th>
                        <th>Loại khách</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($booking->khachHangDatTour as $index => $khach)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $khach->ho_ten }}</td>
                            <td>{{ $khach->gioi_tinh }}</td>
                            <td>{{ $khach->nam_sinh }}</td>
                            <td>
                                @switch($khach->loai_hanh_khach)
                                    @case('adult')
                                        Người lớn
                                        @break
                                    @case('child')
                                        Trẻ em
                                        @break
                                    @case('baby')
                                        Em bé
                                        @break
                                    @default
                                        {{ $khach->loai_hanh_khach }}
                                @endswitch
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Chưa có hành khách
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <hr>

        {{-- Thanh toán --}}
        <h4 class="mb-3">
            Thanh toán
        </h4>

        <div class="row">
            <div class="col-md-3">
                <strong>Tổng tiền:</strong>
                <br>
                {{ number_format($booking->tong_tien, 0, ',', '.') }} đ
            </div>

            <div class="col-md-3">
                <strong>Đã thanh toán:</strong>
                <br>
                {{ number_format($booking->so_tien_da_thanh_toan, 0, ',', '.') }} đ
            </div>

            <div class="col-md-3">
                <strong>Còn lại:</strong>
                <br>
                {{ number_format(
                    $booking->tong_tien - $booking->so_tien_da_thanh_toan,
                    0,
                    ',',
                    '.'
                ) }} đ

            </div>
            <div class="col-md-3">
                <strong>Trạng thái:</strong>
                <br>
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
                @elseif($booking->trang_thai == 'hoan_thanh')
                    <span class="badge bg-primary">
                        Hoàn thành
                    </span>
                @endif
            </div>
        </div>
        @if($booking->ghi_chu)
            <hr>
            <h4>Ghi chú</h4>
            <p>
                {{ $booking->ghi_chu }}
            </p>
        @endif
    </div>
</div>
</div>
@endsection
