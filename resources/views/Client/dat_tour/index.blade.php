@extends('layouts.app')

@section('content')
<div class="container-fluid py-5 bg-light">
    <div class="container">
        <div class="row g-5">
            
            <!-- LEFT - Thông tin chính -->
            <div class="col-lg-7">
                <div class="mb-5">
                    <h2 class="fw-bold text-dark mb-2">
                        <i class="fa fa-plane me-3 text-primary"></i>Đặt Tour
                    </h2>
                    <p class="text-muted fs-5">
                        Vui lòng kiểm tra thông tin trước khi thanh toán
                    </p>
                </div>

                <!-- Thông tin Tour -->
                <h4 class="fw-semibold mb-3 text-dark">
                    <i class="fa fa-info-circle me-2"></i>Thông tin Tour
                </h4>
                <div class="card border-0 shadow-sm mb-5">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="{{ asset('storage/'.$tour->anh_dai_dien) }}"
                                 class="img-fluid h-100 w-100 object-fit-cover rounded-start"
                                 style="min-height: 220px;" alt="{{ $tour->ten_tour }}">
                        </div>
                        <div class="col-md-8 p-4">
                            <h4 class="fw-bold">{{ $tour->ten_tour }}</h4>
                            <p class="mb-2 text-muted">
                                <i class="fa fa-location-dot text-danger"></i> 
                                {{ $tour->dia_diem_khoi_hanh }}
                            </p>
                            <p class="mb-3">
                                <i class="fa fa-clock text-primary"></i> 
                                {{ $tour->thoi_luong }} 
                            </p>
                            <h4 class="text-primary fw-bold mb-0">
                                {{ number_format($tour->gia_nguoi_lon) }}đ <small class="fs-6 text-muted">/người lớn</small>
                            </h4>
                        </div>
                    </div>
                </div>

                <!-- Lịch khởi hành -->
                <h4 class="fw-semibold mb-3 text-dark">
                    <i class="fa fa-calendar-alt me-2"></i>Lịch khởi hành
                </h4>
                <div class="mb-5">
                    @foreach($lichKhoiHanhs as $lich)
                    <label class="card border mb-3 p-4 cursor-pointer hover-shadow transition-all"
                           style="cursor: pointer;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <input class="form-check-input mt-0" 
                                       type="radio" 
                                       name="lich_khoi_hanh_id" 
                                       value="{{ $lich->id }}"
                                       @checked(old('lich_khoi_hanh_id') == $lich->id)>
                                <div>
                                    <strong class="fs-5">
                                        {{ \Carbon\Carbon::parse($lich->ngay_khoi_hanh)->format('d/m/Y') }}
                                    </strong>
                                    <br>
                                    <small class="text-success">
                                        <i class="fa fa-users"></i> 
                                        Còn <strong>{{ $lich->so_cho }}</strong> chỗ
                                    </small>
                                </div>
                            </div>
                            <div class="text-end">
                                <h5 class="text-primary fw-bold mb-0">
                                    {{ number_format($lich->tour->gia_nguoi_lon) }}đ
                                </h5>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>

                <!-- Thông tin người đặt -->
                <h4 class="fw-semibold mb-3 text-dark">
                    <i class="fa fa-user me-2"></i>Thông tin người đặt
                </h4>
                <div class="card border-0 shadow-sm p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Họ và tên</label>
                            <input type="text" class="form-control form-control-lg" 
                                   value="{{ auth()->user()->name }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Email</label>
                            <input type="email" class="form-control form-control-lg" 
                                   value="{{ auth()->user()->email }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium">Số điện thoại</label>
                            <input type="tel" class="form-control form-control-lg" 
                                   value="{{ auth()->user()->phone ?? 'Chưa cập nhật' }}" readonly>
                        </div>
                        <div class="row">
                            <label class="form-label fw-medium">Địa Chỉ</label>
                            <textarea  class="form-control form-control-lg" 
                                    >{{ auth()->user()->address ?? 'Chưa cập nhật' }}
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT - Order Summary -->
            <!-- RIGHT - Order Summary -->
<!-- RIGHT - Order Summary -->
<div class="col-lg-5">
    <div class="position-sticky" style="top: 85px; z-index: 990;">
        <div class="card border-0 shadow-lg">
            <div class="card-body p-5">
                <h3 class="fw-bold mb-4">Tóm tắt đơn hàng</h3>
                
                <div class="bg-light rounded-3 p-4 mb-4">
                    <small class="text-muted">Tour đã chọn</small>
                    <h2 class="fw-bold text-primary my-3">
                        {{ number_format($tour->gia_nguoi_lon) }}đ
                    </h2>
                    <button class="btn btn-outline-primary w-100 py-2">
                        <i class="fa fa-exchange-alt me-2"></i>Đổi lịch khởi hành
                    </button>
                </div>

                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Giá tour (1 người lớn)</span>
                    <strong>{{ number_format($tour->gia_nguoi_lon) }}đ</strong>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Giá tour (1 trẻ em)</span>
                    <strong>{{ number_format($tour->gia_tre_em) }}đ</strong>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Giá tour (1 em bé)</span>
                    <strong>{{ number_format($tour->gia_em_be) }}đ</strong>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Thuế & Phí</span>
                    <strong class="text-success">Miễn phí</strong>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-end">
                    <h5 class="mb-0">Tổng thanh toán</h5>
                    <div class="text-end">
                        <h3 class="fw-bold text-dark mb-0">
                            {{ number_format($lichDuocChon['tong_tien']) }}đ
                        </h3>
                        <small class="text-muted">Đã bao gồm VAT</small>
                    </div>
                </div>

                <button class="btn btn-success btn-lg w-100 mt-5 py-4 fs-5 fw-semibold shadow-sm">
                    <i class="fa fa-lock me-2"></i>
                    Xác nhận & Thanh toán
                </button>

                <p class="text-center text-muted small mt-4 mb-0">
                    Bằng việc thanh toán, bạn đồng ý với 
                    <a href="#" class="text-decoration-underline">Điều khoản dịch vụ</a> của Travelloula.
                </p>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

<style>
.hover-shadow:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
    transition: all 0.3s ease;
}
.cursor-pointer:hover {
    background-color: #f8f9fa;
}
.order-summary {
    position: sticky;
    top: 110px;
    z-index: 1020;
}
</style>
@endsection