@extends('Layouts.guide')

@section('title', 'Điểm danh đầu ngày')
@section('guide', 'Điểm danh đầu ngày')

@section('content')
    <div class="container-fluid">

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4>
                    Điểm danh trước khi bắt đầu Ngày {{ $ngayThu }}
                </h4>

                <p class="text-muted mb-0">
                    Tổng hành khách: <strong>{{ $tongKhach }}</strong>
                </p>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">
                <strong>Danh sách hành khách</strong>
            </div>

            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="60">STT</th>
                            <th>Họ tên</th>
                            <th>Giới tính</th>
                            <th>Quốc tịch</th>
                            <th width="180">Trạng thái</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $stt = 1;
                        @endphp

                        @foreach ($datTours as $datTour)
                            @foreach ($datTour->khachHangs as $khach)
                                <tr>
                                    <td>{{ $stt++ }}</td>
                                    <td>{{ $khach->ho_ten }}</td>
                                    <td>{{ $khach->gioi_tinh }}</td>
                                    <td>{{ $khach->quoc_tich }}</td>
                                    <td>
                                        <form action="{{ route('Guide.checkin.luuDiemDanh') }}" method="POST" class="d-inline">
                                            @csrf

                                            <input type="hidden" name="khach_hang_dat_tour_id" value="{{ $khach->id }}">
                                            <input type="hidden" name="lich_khoi_hanh_id" value="{{ $lichKhoiHanhId }}">
                                            <input type="hidden" name="ngay_thu" value="{{ $ngayThu }}">
                                            <input type="hidden" name="trang_thai" value="co_mat">

                                            <button type="submit" class="btn btn-success btn-sm">
                                                Có mặt
                                            </button>
                                        </form>

                                        <form action="{{ route('Guide.checkin.luuDiemDanh') }}" method="POST" class="d-inline">
                                            @csrf

                                            <input type="hidden" name="khach_hang_dat_tour_id" value="{{ $khach->id }}">
                                            <input type="hidden" name="lich_khoi_hanh_id" value="{{ $lichKhoiHanhId }}">
                                            <input type="hidden" name="ngay_thu" value="{{ $ngayThu }}">
                                            <input type="hidden" name="trang_thai" value="vang">

                                            <button type="submit" class="btn btn-danger btn-sm">
                                                Vắng
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
