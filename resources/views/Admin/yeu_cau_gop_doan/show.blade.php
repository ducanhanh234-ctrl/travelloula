@extends('layouts.admin')

@section('content')

    @php

        $nhomLich = $yeuCau->chiTiets->groupBy('lich_khoi_hanh_id');

        $tongLich = $nhomLich->count();

        $tongBooking = $yeuCau->chiTiets->count();

        $dongY = $yeuCau->chiTiets->where('trang_thai_lien_he', 'dong_y')->count();

        $tuChoi = $yeuCau->chiTiets->where('trang_thai_lien_he', 'tu_choi')->count();

        $chuaLienHe = $yeuCau->chiTiets->where('trang_thai_lien_he', 'chua_lien_he')->count();

        $daXuLy = $dongY + $tuChoi;

        $phanTram = $tongBooking ? round(($daXuLy / $tongBooking) * 100) : 0;

    @endphp

    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h3 class="fw-bold">

                    <i class="fas fa-object-group text-primary"></i>

                    Chi tiết yêu cầu gộp đoàn

                </h3>

                <div class="text-muted">

                    {{ $yeuCau->ma_yeu_cau }}

                </div>

            </div>

            <a href="{{ route('Admin.yeu-cau-gop-doan.index') }}" class="btn btn-outline-secondary">

                <i class="fas fa-arrow-left"></i>

                Quay lại

            </a>

        </div>


        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <div class="row">

                    <div class="col-md-3">

                        <b>Mã yêu cầu</b>

                        <div>{{ $yeuCau->ma_yeu_cau }}</div>

                    </div>

                    <div class="col-md-3">

                        <b>Loại</b>

                        <div>

                            @if ($yeuCau->loai_de_xuat == 'tu_dong')
                                <span class="badge bg-primary">

                                    AI

                                </span>
                            @else
                                <span class="badge bg-secondary">

                                    Thủ công

                                </span>
                            @endif

                        </div>

                    </div>

                    <div class="col-md-3">

                        <b>Trạng thái</b>

                        <div>

                            @if ($yeuCau->trang_thai == 'cho_xu_ly')
                                <span class="badge bg-warning">

                                    Chờ xử lý

                                </span>
                            @else
                                <span class="badge bg-success">

                                    Hoàn tất

                                </span>
                            @endif

                        </div>

                    </div>

                    <div class="col-md-3">

                        <b>Ngày tạo</b>

                        <div>

                            {{ $yeuCau->created_at->format('d/m/Y H:i') }}

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <div class="row mb-4">

            <div class="col">

                <div class="card">

                    <div class="card-body text-center">

                        <h3>{{ $tongLich }}</h3>

                        <small>Lịch</small>

                    </div>

                </div>

            </div>

            <div class="col">

                <div class="card">

                    <div class="card-body text-center">

                        <h3>{{ $tongBooking }}</h3>

                        <small>Booking</small>

                    </div>

                </div>

            </div>

            <div class="col">

                <div class="card">

                    <div class="card-body text-center">

                        <h3 class="text-success">

                            {{ $dongY }}

                        </h3>

                        <small>Đồng ý</small>

                    </div>

                </div>

            </div>

            <div class="col">

                <div class="card">

                    <div class="card-body text-center">

                        <h3 class="text-danger">

                            {{ $tuChoi }}

                        </h3>

                        <small>Từ chối</small>

                    </div>

                </div>

            </div>

            <div class="col">

                <div class="card">

                    <div class="card-body text-center">

                        <h3 class="text-warning">

                            {{ $chuaLienHe }}

                        </h3>

                        <small>Chưa liên hệ</small>

                    </div>

                </div>

            </div>

        </div>


        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <strong>Tiến độ xử lý</strong>

                    <strong>

                        {{ $daXuLy }}/{{ $tongBooking }}

                    </strong>

                </div>

                <div class="progress mt-2" style="height:25px">

                    <div class="progress-bar bg-success" style="width:{{ $phanTram }}%">

                        {{ $phanTram }}%

                    </div>

                </div>

            </div>

        </div>



        @foreach ($nhomLich as $lichId => $chiTiets)
            @php

                $lich = $chiTiets->first()->lichKhoiHanh;

            @endphp

            <div class="card shadow mb-4">

                <div class="card-header bg-primary text-white">

                    <div class="d-flex justify-content-between">

                        <div>

                            Lịch #{{ $lich->id }}

                            @if ($chiTiets->first()->la_lich_chinh)
                                <span class="badge bg-success">

                                    Lịch chính

                                </span>
                            @endif

                        </div>

                        <div>

                            {{ optional($lich->tour)->ten_tour }}

                        </div>

                    </div>

                </div>

                <div class="card-body">
                    @foreach ($chiTiets as $ct)
                        @php
                            $booking = $ct->datTour;
                        @endphp

                        @if (!$booking)
                            @continue
                        @endif

                        <div class="card border mb-3 shadow-sm">

                            <div class="card-header bg-light d-flex justify-content-between align-items-center">

                                <div>

                                    <strong class="text-primary">
                                        {{ $booking->ma_dat_tour }}
                                    </strong>

                                </div>

                                <div>

                                    @switch($ct->trang_thai_lien_he)
                                        @case('dong_y')
                                            <span class="badge bg-success">

                                                Khách đồng ý

                                            </span>
                                        @break

                                        @case('tu_choi')
                                            <span class="badge bg-danger">

                                                Khách từ chối

                                            </span>
                                        @break

                                        @default
                                            <span class="badge bg-warning text-dark">

                                                Chưa liên hệ

                                            </span>
                                    @endswitch

                                </div>

                            </div>

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-md-6">

                                        <table class="table table-sm table-borderless">

                                            @php
                                                $info = $booking->thong_tin_nguoi_dat;
                                            @endphp

                                            <tr>
                                                <th width="170">Người đặt</th>
                                                <td>{{ $info['ten'] }}</td>
                                            </tr>

                                            <tr>
                                                <th>Loại khách</th>
                                                <td>
                                                    <span class="badge bg-{{ $info['badge'] }}">
                                                        {{ $info['loai'] }}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>SĐT</th>
                                                <td>{{ $info['phone'] }}</td>
                                            </tr>

                                            <tr>
                                                <th>Email</th>
                                                <td>{{ $info['email'] }}</td>
                                            </tr>

                                            <tr>
                                                <th>Ngày đặt</th>
                                                <td>{{ $info['ngay_dat'] }}</td>
                                            </tr>

                                        </table>

                                    </div>

                                    <div class="col-md-6">

                                        <table class="table table-sm table-borderless">

                                            <tr>
                                                <th width="170">Người lớn</th>
                                                <td>{{ $booking->so_nguoi_lon }}</td>
                                            </tr>

                                            <tr>
                                                <th>Trẻ em</th>
                                                <td>{{ $booking->so_tre_em }}</td>
                                            </tr>

                                            <tr>
                                                <th>Em bé</th>
                                                <td>{{ $booking->so_em_be }}</td>
                                            </tr>

                                            <tr>

                                                <th>Tổng khách</th>

                                                <td class="fw-bold text-primary">

                                                    {{ $booking->tong_so_khach }}

                                                </td>

                                            </tr>

                                            <tr>
                                                <th>Trạng thái booking</th>
                                                <td>
                                                    <span class="badge bg-{{ $booking->trang_thai_badge }}">
                                                        {{ $booking->trang_thai_text }}
                                                    </span>
                                                </td>
                                            </tr>

                                            {{-- <tr>
                                                <th>Trạng thái booking</th>
                                                <td>

                                                    {{ $booking->trangThaiDatTour() }}
                                                    <br>
                                                    {{ $booking->trang_thai_badge }}

                                                </td>
                                            </tr> --}}

                                        </table>

                                    </div>

                                </div>

                                @if ($yeuCau->trang_thai == 'cho_xu_ly' && $ct->trang_thai_lien_he == 'chua_lien_he')
                                    <hr>

                                    <div class="d-flex gap-2">

                                        <form method="POST"
                                            action="{{ route('Admin.yeu-cau-gop-doan.cap-nhat-trang-thai', $ct->id) }}">

                                            @csrf

                                            <input type="hidden" name="trang_thai" value="dong_y">

                                            <button class="btn btn-success"
                                                onclick="return confirm('Xác nhận khách đồng ý?')">

                                                <i class="fas fa-check"></i>

                                                Khách đồng ý

                                            </button>

                                        </form>

                                        <form method="POST"
                                            action="{{ route('Admin.yeu-cau-gop-doan.cap-nhat-trang-thai', $ct->id) }}">

                                            @csrf

                                            <input type="hidden" name="trang_thai" value="tu_choi">

                                            <button class="btn btn-danger" onclick="return confirm('Khách từ chối gộp?')">

                                                <i class="fas fa-times"></i>

                                                Khách từ chối

                                            </button>

                                        </form>

                                    </div>
                                @endif

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>
        @endforeach

        @php

            $conChoLienHe = $yeuCau->chiTiets->where('trang_thai_lien_he', 'chua_lien_he')->count();

        @endphp

        <div class="card shadow">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center flex-wrap">

                    <div>

                        @if ($conChoLienHe > 0)
                            <div class="alert alert-warning mb-0">

                                <i class="fas fa-exclamation-circle"></i>

                                Còn

                                <strong>

                                    {{ $conChoLienHe }}

                                </strong>

                                booking chưa liên hệ.

                            </div>
                        @else
                            <div class="alert alert-success mb-0">

                                <i class="fas fa-check-circle"></i>

                                Tất cả booking đã được xử lý.

                            </div>
                        @endif

                    </div>

                    <div class="d-flex gap-2">

                        <a href="{{ route('Admin.yeu-cau-gop-doan.index') }}" class="btn btn-secondary">

                            <i class="fas fa-arrow-left"></i>

                            Quay lại

                        </a>

                        @if ($yeuCau->trang_thai == 'cho_xu_ly')
                            <form action="{{ route('Admin.yeu-cau-gop-doan.destroy', $yeuCau->id) }}" method="POST">

                                @csrf

                                <button class="btn btn-outline-danger" onclick="return confirm('Hủy yêu cầu này?')">

                                    <i class="fas fa-times"></i>

                                    Hủy yêu cầu

                                </button>

                            </form>

                            @if ($conChoLienHe == 0)
                                <form action="{{ route('Admin.yeu-cau-gop-doan.chot', $yeuCau->id) }}" method="POST">

                                    @csrf

                                    <button class="btn btn-success" onclick="return confirm('Xác nhận chốt gộp đoàn?')">

                                        <i class="fas fa-check-circle"></i>

                                        Chốt gộp đoàn

                                    </button>

                                </form>
                            @endif
                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
