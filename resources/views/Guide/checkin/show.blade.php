@extends('Layouts.guide')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-success mb-1">
                <i class="fas fa-user-check"></i>
                Check-in hành khách
            </h2>

            <small class="text-muted">
                {{ $chiTiet->tieu_de }}
            </small>
        </div>

        <a href="{{ route('Guide.checkin.dia-diem', $lichKhoiHanhId) }}" class="btn btn-outline-success">
            <i class="fas fa-arrow-left"></i>
            Quay lại
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row">

                <div class="col-md-3">
                    <strong>Tour</strong>
                    <br>
                    {{ $chiTiet->lichTrinh->tour->ten_tour }}
                </div>

                <div class="col-md-3">
                    <strong>Địa điểm</strong>
                    <br>
                    {{ $chiTiet->tieu_de }}
                </div>

                <div class="col-md-3">
                    <strong>Ngày tour</strong>
                    <br>
                    Ngày {{ $chiTiet->lichTrinh->ngay_thu }}
                </div>

                <div class="col-md-3">
                    <strong>Thời gian</strong>
                    <br>
                    {{ $chiTiet->gio_bat_dau }} - {{ $chiTiet->gio_ket_thuc }}
                </div>

            </div>
        </div>
    </div>

    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-success">{{ $tongKhach }}</h3>
                    <small class="text-muted">Tổng hành khách</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-primary">{{ $daCheck }}</h3>
                    <small class="text-muted">Đã check-in</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h3 class="text-danger">{{ $chuaCheck }}</h3>
                    <small class="text-muted">Chưa check-in</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between mb-2">

                <strong>Tiến độ Check-in</strong>

                <span>{{ $daCheck }}/{{ $tongKhach }} hành khách</span>

            </div>

            <div class="progress" style="height: 22px;">

                <div class="progress-bar bg-success" role="progressbar"
                    style="width: {{ $tongKhach > 0 ? ($daCheck / $tongKhach) * 100 : 0 }}%;">

                    {{ round($tongKhach > 0 ? ($daCheck / $tongKhach) * 100 : 0) }}%

                </div>

            </div>

        </div>

    </div>

    <div class="d-flex justify-content-end mb-3">

        <form action="{{ route('Guide.checkin.checkinTatCa') }}" method="POST" class="me-2">

            @csrf

            <input type="hidden" name="lich_khoi_hanh_id" value="{{ $lichKhoiHanhId }}">

            <input type="hidden" name="chi_tiet_lich_trinh_id" value="{{ $chiTiet->id }}">

            <button class="btn btn-success">

                <i class="fas fa-user-check"></i>

                Check-in tất cả

            </button>

        </form>

        <form action="{{ route('Guide.checkin.checkoutTatCa') }}" method="POST">

            @csrf

            <input type="hidden" name="chi_tiet_lich_trinh_id" value="{{ $chiTiet->id }}">

            <button class="btn btn-warning">

                <i class="fas fa-sign-out-alt"></i>

                Check-out tất cả

            </button>

        </form>

    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <table class="table table-bordered table-hover align-middle">
        <tr>
            <th>STT</th>
            <th>Họ tên</th>
            <th>SĐT</th>
            <th>Trạng thái</th>
            <th>Ghi chú</th>
            <th width="220">Thao tác</th>
        </tr>

        @php
            $stt = 1;
        @endphp

        @foreach($datTours as $datTour)
            @foreach($datTour->khachHangs as $khach)
                <tr>
                    <td>{{ $stt++ }}</td>
                    <td>{{ $khach->ho_ten }}</td>
                    <td>{{ $khach->so_dien_thoai }}</td>
                    <td>
                        @php
                            $checkIn = $checkIns[$khach->id] ?? null;
                        @endphp

                        <pre>
{{-- ID: {{ $khach->id }}
{{ print_r($checkIn->toArray(), true) }}
</pre> --}}

                        @if(!$checkIn || $checkIn->trang_thai == 'chua_check_in')
                            <span class="badge bg-danger">
                                Chưa check-in
                            </span>

                        @elseif($checkIn->trang_thai == 'da_check_in')
                            <span class="badge bg-success">
                                Đã check-in
                            </span>

                        @else
                            <span class="badge bg-primary">
                                Đã check-out
                            </span>
                        @endif
                    </td>

                    <td>
                        @if($checkIn && $checkIn->ghi_chu)
                            <span class="text-danger">
                                {{ $checkIn->ghi_chu }}
                            </span>
                        @else
                            <span class="text-muted">
                                Chưa có
                            </span>
                        @endif
                    </td>

                    <td>

                        @if(!$checkIn || $checkIn->trang_thai == 'chua_check_in')

                            <div class="d-flex gap-2">

                                <form action="{{ route('Guide.checkin.store') }}" method="POST">
                                    @csrf

                                    <input type="hidden" name="khach_hang_dat_tour_id" value="{{ $khach->id }}">
                                    <input type="hidden" name="lich_khoi_hanh_id" value="{{ $datTour->lich_khoi_hanh_id }}">
                                    <input type="hidden" name="chi_tiet_lich_trinh_id" value="{{ $chiTiet->id }}">

                                    <button class="btn btn-success btn-sm">
                                        <i class="fas fa-user-check"></i>
                                        Check-in
                                    </button>

                                </form>

                                <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#ghiChuModal{{ $khach->id }}">

                                    <i class="fas fa-pen"></i>

                                    {{ $checkIn && $checkIn->ghi_chu ? 'Sửa ghi chú' : 'Ghi chú' }}

                                </button>

                            </div>

                        @elseif($checkIn->trang_thai == 'da_check_in')

                            <div class="d-flex gap-2">

                                <form action="{{ route('Guide.checkout', $checkIn->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    <button class="btn btn-warning btn-sm">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Check-out
                                    </button>

                                </form>

                                <form action="{{ route('Guide.checkin.undo', $checkIn->id) }}" method="POST">
                                    @csrf

                                    <button class="btn btn-secondary btn-sm">
                                        <i class="fas fa-rotate-left"></i>
                                    </button>

                                </form>

                            </div>

                        @elseif($checkIn->trang_thai == 'da_check_out')

                            <form action="{{ route('Guide.checkout.undo', $checkIn->id) }}" method="POST">
                                @csrf

                                <button class="btn btn-info btn-sm">
                                    <i class="fas fa-rotate-left"></i>
                                    Hoàn tác
                                </button>

                            </form>

                        @endif

                    </td>
                </tr>

                <div class="modal fade" id="ghiChuModal{{ $khach->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('Guide.checkin.note') }}" method="POST">
                                @csrf
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title">
                                        Ghi chú hành khách
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <strong>{{ $khach->ho_ten }}</strong>
                                    <input type="hidden" name="khach_hang_dat_tour_id" value="{{ $khach->id }}">
                                    <input type="hidden" name="lich_khoi_hanh_id" value="{{ $datTour->lich_khoi_hanh_id }}">
                                    <input type="hidden" name="chi_tiet_lich_trinh_id" value="{{ $chiTiet->id }}">
                                    <textarea name="ghi_chu" class="form-control mt-3" rows="4"
                                        placeholder="Ví dụ: Khách đến muộn..." required></textarea>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Hủy
                                    </button>

                                    <button class="btn btn-success">
                                        Lưu ghi chú
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </table>
@endsection
