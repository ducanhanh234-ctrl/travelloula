@extends('Layouts.guide')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-success mb-1">
                <i class="fas fa-route"></i>
                Chọn địa điểm Check-in
            </h2>

            <small class="text-muted">
                {{ $lichKhoiHanh->tour->ten_tour }}
            </small>
        </div>

        <a href="{{ route('Guide.checkin.index') }}" class="btn btn-outline-success">
            <i class="fas fa-arrow-left"></i>
            Quay lại
        </a>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <strong>Ngày khởi hành</strong>
                    <br>
                    {{ $lichKhoiHanh->ngay_khoi_hanh->format('d/m/Y') }}
                </div>

                <div class="col-md-4">
                    <strong>Ngày kết thúc</strong>
                    <br>
                    {{ $lichKhoiHanh->ngay_ket_thuc->format('d/m/Y') }}
                </div>

                <div class="col-md-4">
                    <strong>Hướng dẫn viên</strong>
                    <br>
                    {{ $lichKhoiHanh->huongDanVien->ho_ten ?? 'Chưa phân công' }}
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row text-center">
                <div class="col">
                    <h3 class="text-success">
                        {{ $lichKhoiHanh->tour->lichTrinhTours->count() }}
                    </h3>
                    <small>Ngày tham quan</small>
                </div>

                <div class="col">
                    <h3 class="text-success">
                        {{ $lichKhoiHanh->tour->lichTrinhTours->sum(function ($n) {
        return $n->chiTiets->count();
    }) }}
                    </h3>
                    <small>Địa điểm</small>
                </div>
            </div>
        </div>
    </div>

    @foreach($lichKhoiHanh->tour->lichTrinhTours as $ngay)
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-success text-white">
                <i class="fas fa-calendar-day"></i>
                Ngày {{ $ngay->ngay_thu }}
            </div>

            <div class="card-body">
                @foreach($ngay->chiTiets as $chiTiet)
                    <div class="card border-success shadow-sm mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-2">
                                        {{ $chiTiet->tieu_de }}
                                    </h5>

                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i>
                                        {{ $chiTiet->gio_bat_dau }}
                                        -
                                        {{ $chiTiet->gio_ket_thuc }}
                                    </small>
                                </div>

                                <a href="{{ route('Guide.checkin.show', [
                        'lichKhoiHanh' => $lichKhoiHanh->id,
                        'chiTiet' => $chiTiet->id
                    ]) }}" class="btn btn-success">
                                    <i class="fas fa-user-check"></i>
                                    Check-in
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection
