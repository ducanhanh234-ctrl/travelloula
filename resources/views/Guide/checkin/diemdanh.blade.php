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
                                @php
                                    $diemDanh = $diemDanhs[$khach->id] ?? null;
                                @endphp
                                <tr>
                                    <td>{{ $stt++ }}</td>
                                    <td>{{ $khach->ho_ten }}</td>
                                    <td>{{ $khach->gioi_tinh }}</td>
                                    <td>{{ $khach->quoc_tich }}</td>
                                    <td>
                                        @if($daChot)
                                        @if($diemDanh && $diemDanh->trang_thai == 'co_mat')
                                            <span class="badge bg-success">Có mặt</span>
                                        @elseif($diemDanh && $diemDanh->trang_thai == 'vang_mat')
                                            <span class="badge bg-danger">Vắng mặt</span>
                                        @else
                                            <span class="badge bg-secondary">Chưa điểm danh</span>
                                        @endif
                                    @else

    <form action="{{ route('Guide.checkin.luuDiemDanh') }}" method="POST" class="attendance-form">
        @csrf
            <input type="hidden" name="khach_hang_dat_tour_id"value="{{ $khach->id }}">
            <input type="hidden" name="lich_khoi_hanh_id" value="{{ $lichKhoiHanhId }}">
            <input type="hidden" name="ngay_thu" value="{{ $ngayThu }}">
            <input type="hidden" name="trang_thai" value="{{ $diemDanh && $diemDanh->trang_thai == 'co_mat' ? 'co_mat' : 'vang_mat' }}" class="trang-thai-input">

    <div class="form-check form-switch">
       <input class="form-check-input attendance-switch" type="checkbox"
            {{ $diemDanh && $diemDanh->trang_thai == 'co_mat' ? 'checked' : '' }}
                onchange="
        this.closest('form').querySelector('.trang-thai-input').value =
            this.checked ? 'co_mat' : 'vang_mat';

        this.closest('form').submit();
    "
>
    </div>
</form>

@endif
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-header">
                <strong>Chốt điểm danh</strong>
            </div>

            <div class="card-body">
                <form action="{{ route('Guide.checkin.chotDiemDanh') }}" method="POST">
                    @csrf

                    <input type="hidden" name="lich_khoi_hanh_id" value="{{ $lichKhoiHanhId }}">

                    <input type="hidden" name="ngay_thu" value="{{ $ngayThu }}">

                    <div class="mb-3">
                        <label class="form-label">
                            Ghi chú
                        </label>

                        <textarea name="ghi_chu" class="form-control" rows="4"
                            placeholder="Nhập ghi chú nếu có..."></textarea>
                    </div>

                    @if(!$daChot)
    <button
        type="submit"
        class="btn btn-success btn-lg px-5"
    >
        <i class="fas fa-check-circle me-2"></i>
        Chốt điểm danh
    </button>
@else
    <button
        type="button"
        class="btn btn-secondary btn-lg px-5"
        disabled
    >
        <i class="fas fa-lock me-2"></i>
        Đã chốt điểm danh
    </button>
@endif
                </form>
            </div>
        </div>
    </div>
@endsection
