@extends('layouts.admin')

@section('content')
<div class="container">

    <h3>
        Yêu cầu gộp:
        {{ $yeuCau->ma_yeu_cau }}
    </h3>

    @php
    $nhomLich = $yeuCau->chiTiets->groupBy('lich_khoi_hanh_id');
    @endphp

    @foreach ($nhomLich as $lichId => $chiTiets)
    @php
    $lich = $chiTiets->first()->lichKhoiHanh;
    @endphp

    @php
    $trangThaiLich = $chiTiets->pluck('trang_thai_lien_he');

    if ($trangThaiLich->contains('tu_choi')) {
    $trangThai = 'tu_choi';
    } elseif ($trangThaiLich->every(fn($x) => $x == 'dong_y')) {
    $trangThai = 'dong_y';
    } else {
    $trangThai = 'chua_lien_he';
    }
    @endphp

    <div class="card mb-4 shadow-sm">


        <div class="card-header">

            Lịch khởi hành #{{ $lich->id }}

            @if ($trangThai == 'chua_lien_he')
            <span class="badge bg-secondary">
                Chưa liên hệ
            </span>
            @elseif($trangThai == 'dong_y')
            <span class="badge bg-success">
                Khách đồng ý
            </span>
            @elseif($trangThai == 'tu_choi')
            <span class="badge bg-danger">
                Khách từ chối
            </span>
            @endif

            @if ($chiTiets->first()->la_lich_chinh)
            <span class="badge bg-success">
                Lịch chính
            </span>
            @endif


        </div>



        <div class="card-body">

            @foreach ($chiTiets as $ct)
            @php
            $booking = $ct->datTour;
            @endphp

            @if (!$booking)
            @continue
            @endif
            {{-- ================= BOOKING ================= --}}

            <div class="card mb-4 border-primary shadow-sm">


                <div class="card-header bg-primary text-white">

                    <h5 class="mb-0">

                        Booking:
                        {{ $booking->ma_dat_tour }}

                    </h5>

                </div>



                <div class="card-body">

                    <hr>

                    {{-- ================= NGUOI DAT TOUR ================= --}}

                    <h6 class="fw-bold text-primary">
                        Người đặt tour
                    </h6>

                    <div class="card mb-3 border-success mt-3">


                        <div class="card-header bg-light">

                            Người đặt booking

                        </div>

                        <div class="card-body">


                            <div class="row">



                                <div class="col-md-6">


                                    <p>
                                        <b>Tên người đặt:</b>

                                        {{ $booking->ten_nguoi_dat ?? 'Chưa có' }}

                                    </p>



                                    <p>
                                        <b>Số điện thoại:</b>

                                        {{ $booking->so_dien_thoai ?? 'Chưa có' }}

                                    </p>



                                    <p>
                                        <b>Email:</b>

                                        {{ $booking->email ?? 'Chưa có' }}

                                    </p>



                                    <p>
                                        <b>Ngày đặt:</b>

                                        {{ $booking->ngay_dat ? \Carbon\Carbon::parse($booking->ngay_dat)->format('d/m/Y H:i') : 'Chưa có' }}

                                    </p>


                                </div>

                                <div class="col-md-6">



                                    <p>
                                        <b>Số người lớn:</b>

                                        {{ $booking->so_nguoi_lon }}

                                    </p>



                                    <p>
                                        <b>Số trẻ em:</b>

                                        {{ $booking->so_tre_em }}

                                    </p>



                                    <p>
                                        <b>Số em bé:</b>

                                        {{ $booking->so_em_be }}

                                    </p>




                                    <p>
                                        <b>Tổng tiền booking:</b>

                                        {{ number_format($booking->tong_tien) }}

                                        VNĐ

                                    </p>



                                    <p>
                                        <b>Đã thanh toán:</b>

                                        {{ number_format($booking->so_tien_da_thanh_toan) }}

                                        VNĐ

                                    </p>




                                    <p>
                                        <b>Trạng thái:</b>

                                        @php
                                        $badge = match ($booking->trang_thai) {
                                        'da_thanh_toan' => 'success',
                                        'cho_thanh_toan' => 'warning',
                                        'da_huy' => 'danger',
                                        default => 'secondary',
                                        };
                                        @endphp

                                        <span class="badge bg-{{ $badge }}">
                                            {{ $booking->trang_thai }}
                                        </span>

                                    </p>



                                    <p>
                                        <b>Ghi chú:</b>

                                        {{ $booking->ghi_chu ?? 'Không có' }}

                                    </p>


                                </div>

                            </div>

                            @if ($ct->trang_thai_lien_he == 'chua_lien_he')
                            <form method="POST" action="{{ route('Admin.gop-doan.cap-nhat-trang-thai', $ct->id) }}" class="d-inline">

                                @csrf

                                <input type="hidden" name="trang_thai" value="dong_y">

                                <button class="btn btn-success">
                                    <i class="fa fa-check"></i>
                                    Khách đồng ý
                                </button>

                            </form>

                            <form method="POST" action="{{ route('Admin.gop-doan.cap-nhat-trang-thai', $ct->id) }}" class="d-inline">

                                @csrf

                                <input type="hidden" name="trang_thai" value="tu_choi">

                                <button class="btn btn-danger">
                                    <i class="fa fa-times"></i>
                                    Khách từ chối
                                </button>

                            </form>
                            @endif

                        </div>


                    </div>

                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        @php
        $choPhepGop = true;

        foreach ($nhomLich as $chiTiets) {
        $trangThaiLich = $chiTiets->pluck('trang_thai_lien_he');

        // ❌ Chỉ chặn nếu còn người chưa liên hệ
        if ($trangThaiLich->contains('chua_lien_he')) {
        $choPhepGop = false;
        break;
        }
        }
        @endphp



        @if ($choPhepGop)
        <form action="{{ route('Admin.gop-doan.chot', $yeuCau->id) }}" method="POST" class="d-inline">
            @csrf

            <button type="submit" class="btn btn-success" onclick="return confirm('Bạn chắc chắn muốn chốt gộp đoàn này?')">
                <i class="fa fa-check-circle"></i>
                Chốt gộp tour
            </button>

        </form>
        @else
        <div class="alert alert-warning">
            Cần khách xác nhận trước khi gộp
        </div>
        @endif


    </div>
    @endsection
