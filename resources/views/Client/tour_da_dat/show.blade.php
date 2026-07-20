@extends('layouts.app')

@section('title','Chi tiết đặt tour')

@section('content')

<div class="container py-5">

    <div class="mb-4">
        <a href="{{ route('tour_da_dat.index') }}" class="btn btn-secondary">
            ← Quay lại
        </a>
    </div>

    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">
                Chi tiết đơn đặt tour
            </h3>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">

                    <table class="table">

                        <tr>
                            <th>Mã đặt tour</th>
                            <td>{{ $datTour->ma_dat_tour }}</td>
                        </tr>

                        <tr>
                            <th>Tên tour</th>
                            <td>{{ $datTour->tour->ten_tour }}</td>
                        </tr>

                        <tr>
                            <th>Ngày khởi hành</th>
                            <td>
                                {{ \Carbon\Carbon::parse($datTour->lichKhoiHanh->ngay_khoi_hanh)->format('d/m/Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th>Ngày kết thúc</th>
                            <td>
                                {{ \Carbon\Carbon::parse($datTour->lichKhoiHanh->ngay_ket_thuc)->format('d/m/Y') }}
                            </td>
                        </tr>

                        <tr>
                            <th>Người lớn</th>
                            <td>{{ $datTour->so_nguoi_lon }}</td>
                        </tr>

                        <tr>
                            <th>Trẻ em</th>
                            <td>{{ $datTour->so_tre_em }}</td>
                        </tr>

                        

                        <tr>
                            <th>Tổng tiền</th>
                            <td class="text-danger fw-bold">
                                {{ number_format($datTour->tong_tien,0,',','.') }} đ
                            </td>
                        </tr>

                        <tr>
                            <th>Trạng thái</th>
                            <td>

                                @switch($datTour->trang_thai)

                                    @case('cho_xac_nhan')
                                        <span class="badge bg-warning">
                                            Chờ xác nhận
                                        </span>
                                    @break

                                    @case('da_xac_nhan')
                                        <span class="badge bg-info">
                                            Đã xác nhận
                                        </span>
                                    @break

                                    @case('da_thanh_toan')
                                        <span class="badge bg-success">
                                            Đã thanh toán
                                        </span>
                                    @break

                                    @case('da_huy')
                                        <span class="badge bg-danger">
                                            Đã hủy
                                        </span>
                                    @break

                                    @default
                                        <span class="badge bg-secondary">
                                            {{ $datTour->trang_thai }}
                                        </span>

                                @endswitch

                            </td>
                        </tr>

                    </table>

                </div>

                <div class="col-md-6">

                    <h5>Thông tin thanh toán</h5>

                    @if($datTour->thanhToans)

                        <table class="table">

                            @foreach($datTour->thanhToans as $thanhToan)

<tr>
    <th>Phương thức</th>
    <td>{{ $thanhToan->phuong_thuc_thanh_toan }}</td>
</tr>

<tr>
    <th>Mã giao dịch</th>
    <td>{{ $thanhToan->ma_giao_dich }}</td>
</tr>

<tr>
    <th>Trạng thái</th>
    <td> @switch($thanhToan->trang_thai)

                                    @case('cho_thanh_toan')
                                        <span class="badge bg-warning">
                                            Chờ thanh toán
                                        </span>
                                    @break

                                    @case('da_xac_nhan')
                                        <span class="badge bg-info">
                                            Đã xác nhận
                                        </span>
                                    @break

                                    @case('da_thanh_toan')
                                        <span class="badge bg-success">
                                            Đã thanh toán
                                        </span>
                                    @break

                                    @case('da_huy')
                                        <span class="badge bg-danger">
                                            Đã hủy
                                        </span>
                                    @break

                                    @default
                                        <span class="badge bg-secondary">
                                            {{ $thanhToan->trang_thai }}
                                        </span>

                                @endswitch</td>
</tr>
<tr>
                                <th>Thời gian</th>
                                <td>{{ $thanhToan->thoi_gian_thanh_toan }}</td>
                            </tr>
@endforeach

                            

                        </table>

                    @else

                        <div class="alert alert-warning">
                            Chưa có thông tin thanh toán.
                        </div>

                    @endif

                </div>

            </div>

            <hr>

            <h4>Danh sách khách</h4>

            @if($datTour->khachHangs->count())

                <table class="table table-bordered">

                    <thead class="table-light">

                    <tr>
                        <th>#</th>
                        <th>Họ tên</th>
                        <th>Ngày sinh</th>
                        <th>Giới tính</th>
                    </tr>

                    </thead>

                    <tbody>

                    @foreach($datTour->khachHangs as $index => $khach)

                        <tr>

                            <td>{{ $index+1 }}</td>

                            <td>{{ $khach->ho_ten }}</td>

                            <td>{{ $khach->ngay_sinh }}</td>

                            <td>{{ $khach->gioi_tinh }}</td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            @else

                <div class="alert alert-info">
                    Không có danh sách khách.
                </div>

            @endif

            <div class="mt-4">

                @if($datTour->trang_thai != 'da_thanh_toan')

                    <form action="{{ route('tour_da_dat.destroy',$datTour->id) }}"
                          method="POST"
                          onsubmit="return confirm('Bạn có chắc chắn muốn hủy tour?')">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger">
                            Hủy tour
                        </button>

                    </form>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection