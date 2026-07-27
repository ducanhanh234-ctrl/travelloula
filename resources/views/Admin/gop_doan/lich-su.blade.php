@extends('layouts.admin')

@section('content')
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3 class="fw-bold mb-1">
                    <i class="fas fa-history text-primary me-2"></i>
                    Lịch sử gộp đoàn
                </h3>

                <small class="text-muted">
                    Danh sách toàn bộ yêu cầu gộp đoàn.
                </small>
            </div>

            <a href="{{ route('Admin.gop-doan.index') }}" class="btn btn-outline-primary">

                <i class="fas fa-arrow-left me-1"></i>
                Quay lại

            </a>

        </div>

        {{-- Thống kê --}}
        <div class="row mb-4">

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">

                        <small class="text-muted">
                            Tổng yêu cầu
                        </small>

                        <h2 class="fw-bold text-primary mb-0">
                            {{ $data->total() }}
                        </h2>

                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">

                        <small class="text-muted">
                            Lịch đã gộp
                        </small>

                        <h2 class="fw-bold text-success mb-0">
                            {{ $data->sum('soLich') }}
                        </h2>

                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">

                        <small class="text-muted">
                            Khách chuyển
                        </small>

                        <h2 class="fw-bold text-info mb-0">
                            {{ $data->sum('khachDaChuyen') }}
                        </h2>

                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">

                        <small class="text-muted">
                            Khách ở lại
                        </small>

                        <h2 class="fw-bold text-danger mb-0">
                            {{ $data->sum('khachBoLai') }}
                        </h2>

                    </div>
                </div>
            </div>

        </div>

        {{-- Danh sách --}}
        <div class="card shadow border-0">

            <div class="card-header bg-white">

                <strong>
                    Danh sách yêu cầu gộp đoàn
                </strong>

            </div>

            <div class="table-responsive">

                <table class="table table-hover table-bordered align-middle mb-0">

                    <thead class="table-light text-center">

                        <tr>

                            <th width="60">#</th>

                            <th>Mã yêu cầu</th>

                            <th>Loại</th>

                            <th>Trạng thái</th>

                            <th>Tour</th>

                            <th>Lịch chính</th>

                            <th>Lịch gộp</th>

                            <th>Số lịch</th>

                            <th>Booking</th>

                            <th>Đã chuyển</th>

                            <th>Ở lại</th>

                            <th>Hoàn tất</th>

                            <th width="140">Thao tác</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($data as $index => $yeuCau)
                            <tr>

                                <td class="text-center">
                                    {{ $data->firstItem() + $index }}
                                </td>

                                <td>
                                    <strong title="{{ $yeuCau->ma_yeu_cau }}" style="cursor: help;">

                                        {{ $yeuCau->ma_hien_thi }}

                                    </strong>

                                    <button class="btn btn-link btn-sm p-0 ms-1"
                                        onclick="navigator.clipboard.writeText('{{ $yeuCau->ma_yeu_cau }}')"
                                        title="Sao chép mã">

                                        <i class="fas fa-copy"></i>

                                    </button>
                                </td>


                                <td class="text-center">

                                    @if ($yeuCau->loai_de_xuat == 'tu_dong')
                                        <span class="badge bg-primary">
                                            AI
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            Thủ công
                                        </span>
                                    @endif

                                </td>

                                <td class="text-center">

                                    @if ($yeuCau->trang_thai == 'cho_xu_ly')
                                        <span class="badge bg-warning text-dark">
                                            Chờ xử lý
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            Hoàn tất
                                        </span>
                                    @endif

                                </td>

                                <td>

                                    {{ $yeuCau->tenTour }}

                                </td>

                                <td class="text-center">

                                    @if ($yeuCau->lichChinh)
                                        #{{ $yeuCau->lichChinh->lich_khoi_hanh_id }}
                                    @else
                                        -
                                    @endif

                                </td>

                                <td class="text-center">

                                    @forelse($yeuCau->lich_bi_gop as $lich)
                                        <span class="badge bg-info me-1">

                                            #{{ $lich }}

                                        </span>

                                    @empty

                                        -
                                    @endforelse

                                </td>

                                <td class="text-center">

                                    <span class="badge bg-primary">

                                        {{ $yeuCau->soLich }}

                                    </span>

                                </td>

                                <td class="text-center">

                                    {{ $yeuCau->tongBooking }}

                                </td>

                                <td class="text-center">

                                    <span class="badge bg-success">

                                        {{ $yeuCau->khachDaChuyen }}

                                    </span>

                                </td>

                                <td class="text-center">

                                    <span class="badge bg-danger">

                                        {{ $yeuCau->khachBoLai }}

                                    </span>

                                </td>

                                <td class="text-center">

                                    @if ($yeuCau->trang_thai == 'hoan_tat')
                                        {{ optional($yeuCau->updated_at)->format('d/m/Y H:i') }}
                                    @else
                                        -
                                    @endif

                                </td>

                                <td class="text-center">

                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse"
                                        data-bs-target="#detail{{ $yeuCau->id }}">

                                        Xem

                                    </button>

                                </td>

                            </tr>

                            <tr class="collapse" id="detail{{ $yeuCau->id }}">

                                <td colspan="12">

                                    <div class="p-3">

                                        <h5 class="fw-bold text-primary mb-3">

                                            Chi tiết yêu cầu {{ $yeuCau->ma_yeu_cau }}

                                        </h5>

                                        @foreach ($yeuCau->danhSachLich as $lichId => $chiTiets)
                                            @php
                                                $lich = $chiTiets->first()->lichKhoiHanh;
                                            @endphp

                                            <div class="card shadow-sm mb-4">

                                                <div
                                                    class="card-header bg-light d-flex justify-content-between align-items-center">

                                                    <div>

                                                        <strong>

                                                            Lịch khởi hành #{{ $lichId }}

                                                        </strong>

                                                        @if ($chiTiets->first()->la_lich_chinh)
                                                            <span class="badge bg-success ms-2">

                                                                Lịch chính

                                                            </span>
                                                        @endif

                                                    </div>

                                                    <div>

                                                        Khởi hành:

                                                        <strong>

                                                            {{ optional($lich->ngay_khoi_hanh)->format('d/m/Y') }}

                                                        </strong>

                                                    </div>

                                                </div>

                                                <div class="card-body">

                                                    <div class="row">

                                                        @foreach ($chiTiets as $ct)
                                                            @php
                                                                $booking = $ct->datTour;
                                                            @endphp

                                                            @if ($booking)
                                                                <div class="col-lg-6 mb-3">

                                                                    <div class="border rounded h-100 p-3">

                                                                        <div
                                                                            class="d-flex justify-content-between align-items-center mb-3">

                                                                            <strong class="text-primary">

                                                                                {{ $booking->ma_dat_tour }}

                                                                            </strong>

                                                                            @switch($ct->trang_thai_lien_he)
                                                                                @case('dong_y')
                                                                                    <span class="badge bg-success">

                                                                                        Đồng ý

                                                                                    </span>
                                                                                @break

                                                                                @case('tu_choi')
                                                                                    <span class="badge bg-danger">

                                                                                        Từ chối

                                                                                    </span>
                                                                                @break

                                                                                @default
                                                                                    <span class="badge bg-warning text-dark">

                                                                                        Chưa liên hệ

                                                                                    </span>
                                                                            @endswitch

                                                                        </div>

                                                                        <table class="table table-borderless table-sm mb-0">

                                                                            <tr>

                                                                                <td width="130">

                                                                                    <strong>Người đặt</strong>

                                                                                </td>

                                                                                <td>

                                                                                    {{ $booking->ten_nguoi_dat }}

                                                                                </td>

                                                                            </tr>

                                                                            <tr>

                                                                                <td>

                                                                                    <strong>SĐT</strong>

                                                                                </td>

                                                                                <td>

                                                                                    {{ $booking->so_dien_thoai }}

                                                                                </td>

                                                                            </tr>

                                                                            <tr>

                                                                                <td>

                                                                                    <strong>Email</strong>

                                                                                </td>

                                                                                <td>

                                                                                    {{ $booking->email }}

                                                                                </td>

                                                                            </tr>

                                                                            <tr>

                                                                                <td>

                                                                                    <strong>Ngày đặt</strong>

                                                                                </td>

                                                                                <td>

                                                                                    {{ optional($booking->ngay_dat)->format('d/m/Y H:i') }}

                                                                                </td>

                                                                            </tr>

                                                                            <tr>

                                                                                <td>

                                                                                    <strong>Người lớn</strong>

                                                                                </td>

                                                                                <td>

                                                                                    {{ $booking->so_nguoi_lon }}

                                                                                </td>

                                                                            </tr>

                                                                            <tr>

                                                                                <td>

                                                                                    <strong>Trẻ em</strong>

                                                                                </td>

                                                                                <td>

                                                                                    {{ $booking->so_tre_em }}

                                                                                </td>

                                                                            </tr>

                                                                            <tr>

                                                                                <td>

                                                                                    <strong>Em bé</strong>

                                                                                </td>

                                                                                <td>

                                                                                    {{ $booking->so_em_be }}

                                                                                </td>

                                                                            </tr>

                                                                            <tr class="table-light">

                                                                                <td>

                                                                                    <strong>Tổng khách</strong>

                                                                                </td>

                                                                                <td class="fw-bold text-primary">

                                                                                    {{ ($booking->so_nguoi_lon ?? 0) + ($booking->so_tre_em ?? 0) + ($booking->so_em_be ?? 0) }}

                                                                                </td>

                                                                            </tr>

                                                                        </table>

                                                                    </div>

                                                                </div>
                                                            @endif
                                                        @endforeach

                                                    </div>

                                                </div>

                                            </div>
                                        @endforeach

                                    </div>

                                </td>

                            </tr>

                            @empty

                                <tr>

                                    <td colspan="12" class="text-center py-5">

                                        <span class="text-muted">

                                            Chưa có dữ liệu gộp đoàn.

                                        </span>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="mt-4">

                {{ $data->links() }}

            </div>

        </div>

    @endsection
