@extends('layouts.app')

@section('content')
<div class="container-fluid py-5 bg-light">
    <div class="container">
        <!-- FORM BAO NGOÀI -->
        <form id="bookingForm" method="POST" action="{{ route('store_dat_tour') }}">
            @csrf
            @if (session('error')

            )
            <div class="alert alert-danger">
                {{session('error')}}
            </div>
            @endif
            <input type="hidden" name="hanh_khach[1][ho_ten]" class="form-control" value="Nguyen Van A">
            <input type="hidden" name="hanh_khach[1][loai_hanh_khach]" value="adult">
            <input name="hanh_khach[1][gioi_tinh]" class="form-select" value="Nam">

            <input type="hidden" name="hanh_khach[1][ngay_sinh]" class="form-control" value="01/01/2026">
            <input type="hidden" name="hanh_khach[1][quoc_tich]" class="form-control" value="Việt Nam">
            <input type="hidden" name="hanh_khach[1][loai_giay_to]" class="form-select" value="CCCD">
            <input type="hidden" name="hanh_khach[1][so_giay_to]" class="form-control" value="00120588235">
            <input type="hidden" name="hanh_khach[1][so_dien_thoai]" class="form-control" value="0909090909">
            <input type="hidden" name="hanh_khach[1][yeu_cau_dac_biet]" class="form-control" value="05"></input>
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
                    <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                    <input type="hidden" name="trang_thai" value="cho_thanh_toan">
                    <input type="hidden" name="so_tien_da_thanh_toan" value="0">
                    <div class="card border-0 shadow-sm mb-5">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="{{ asset('storage/'.$tour->anh_dai_dien) }}" class="img-fluid h-100 w-100 object-fit-cover rounded-start" style="min-height: 220px;" alt="{{ $tour->ten_tour }}">
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
                        <label class="card border mb-3 p-4 cursor-pointer hover-shadow transition-all" style="cursor: pointer;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-3">
                                    <input class="form-check-input mt-0" type="radio" name="lich_khoi_hanh_id" value="{{ $lich->id }}" required @checked(old('lich_khoi_hanh_id')==$lich->id)>
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
                        <i class="fa fa-user me-2"></i>Thông tin người liên hệ (Người đặt)
                    </h4>
                    <div class="card border-0 shadow-sm p-4 mb-5">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Họ và tên</label>
                                <input type="text" class="form-control form-control-lg bg-light" value="{{ auth()->user()->name }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Email</label>
                                <input type="email" class="form-control form-control-lg bg-light" value="{{ auth()->user()->email }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Số điện thoại</label>
                                <input type="tel" name="nguoi_dat_phone" class="form-control form-control-lg bg-light" value="{{ auth()->user()->phone ?? '' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-medium">Địa Chỉ</label>
                                <input type="text" class="form-control form-control-lg bg-light" value="{{ auth()->user()->address ?? '' }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Bổ sung: Số lượng hành khách -->
                    <h4 class="fw-semibold mb-3 text-dark">
                        <i class="fa fa-users me-2"></i>Số lượng hành khách
                    </h4>
                    <div class="card border-0 shadow-sm p-4 mb-5">
                        <div class="row g-4 text-center">
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Người lớn (>12 tuổi)</label>
                                <input type="number" id="qty_adult" name="so_nguoi_lon" class="form-control form-control-lg text-center" value="1" min="1" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Trẻ em (2-11 tuổi)</label>
                                <input type="number" id="qty_child" name="so_tre_em" class="form-control form-control-lg text-center" value="0" min="0">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Em bé </label>
                                <input type="number" id="qty_baby" name="so_em_be" class="form-control form-control-lg text-center" value="0" min="0">
                            </div>
                        </div>
                    </div>

                    <!-- Bổ sung: Danh sách form hành khách -->
                    <h4 class="fw-semibold mb-3 text-dark">
                        <i class="fa fa-id-card me-2"></i>Thông tin hành khách chi tiết
                    </h4>
                    <!-- Vùng chứa các form sẽ được render bằng JS -->
                    <div id="passengers-container"></div>

                </div>

                <!-- RIGHT - Order Summary -->
                <div class="col-lg-5">
                    <div class="position-sticky" style="top: 85px; z-index: 990;">
                        <div class="card border-0 shadow-lg">
                            <div class="card-body p-5">
                                <h3 class="fw-bold mb-4">Tóm tắt đơn hàng</h3>

                                <div class="bg-light rounded-3 p-4 mb-4">
                                    <small class="text-muted">Tour đã chọn</small>
                                    <h2 class="fw-bold text-primary my-3">
                                        {{ $tour->ten_tour }}
                                    </h2>
                                </div>

                                <!-- Bảng giá chi tiết động -->
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Người lớn (<span id="txt_adult_count">1</span>)</span>
                                    <strong id="txt_adult_total">{{ number_format($tour->gia_nguoi_lon) }}đ</strong>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Trẻ em (<span id="txt_child_count">0</span>)</span>
                                    <strong id="txt_child_total">{{ number_format($tour->gia_tre_em) }}đ</strong>
                                </div>
                                <div class="d-flex justify-content-between py-2 border-bottom">
                                    <span class="text-muted">Em bé (<span id="txt_baby_count">0</span>)</span>
                                    <strong id="txt_baby_total">{{ number_format($tour->gia_em_be) }}đ</strong>
                                </div>
                                <div class="d-flex justify-content-between py-2">
                                    <span class="text-muted">Thuế & Phí</span>
                                    <strong class="text-success">Miễn phí</strong>
                                </div>

                                <hr class="my-4">

                                <div class="d-flex justify-content-between align-items-end">
                                    <h5 class="mb-0">Tổng thanh toán</h5>
                                    <div class="text-end">
                                        <!-- Tổng tiền được cập nhật bởi JS -->
                                        <h3 class="fw-bold text-danger mb-0" id="txt_grand_total">
                                            {{ number_format($tour->gia_nguoi_lon) }}đ
                                        </h3>
                                        <input type="hidden" name="tong_tien" id="input_grand_total" value="{{ $tour->gia_nguoi_lon }}">
                                        <small class="text-muted">Đã bao gồm VAT</small>
                                    </div>
                                </div>

                                <!-- Payment Method -->
                                <div class="mt-4">
                                    <label class="form-label fw-medium">Phương thức thanh toán</label>
                                    <select name="phuong_thuc_thanh_toan" class="form-select form-select-lg">
                                        <option value="Chuyen khoan">Chuyển khoản ngân hàng</option>
                                        <option value="VNPAY">Thanh toán VNPay</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-success btn-lg w-100 mt-4 py-3 fs-5 fw-semibold shadow-sm">
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

        </form> <!-- END FORM -->
    </div>

</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
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

    .passenger-card {
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

</style>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Lấy giá cơ bản từ Tour truyền qua Blade
        const priceAdult = {
            {
                $tour - > gia_nguoi_lon ? ? 0
            }
        };
        const priceChild = {
            {
                $tour - > gia_tre_em ? ? 0
            }
        };
        const priceBaby = {
            {
                $tour - > gia_em_be ? ? 0
            }
        };

        // DOM elements form inputs
        const elQtyAdult = document.getElementById('qty_adult');
        const elQtyChild = document.getElementById('qty_child');
        const elQtyBaby = document.getElementById('qty_baby');

        // DOM elements for Order Summary
        const elTxtAdultCount = document.getElementById('txt_adult_count');
        const elTxtChildCount = document.getElementById('txt_child_count');
        const elTxtBabyCount = document.getElementById('txt_baby_count');

        const elTxtAdultTotal = document.getElementById('txt_adult_total');
        const elTxtChildTotal = document.getElementById('txt_child_total');
        const elTxtBabyTotal = document.getElementById('txt_baby_total');

        const elTxtGrandTotal = document.getElementById('txt_grand_total');
        const elInputGrandTotal = document.getElementById('input_grand_total');

        const passengersContainer = document.getElementById('passengers-container');

        // Hàm format tiền tệ (VNĐ)
        function formatVND(amount) {
            return new Intl.NumberFormat('vi-VN').format(amount) + 'đ';
        }

        // Tạo template HTML hành khách theo chuẩn thiết kế ảnh
        function getPassengerFormTemplate(index, label, typeValue) {
            return `
                <div class="passenger-card shadow-sm">
                    <h5 class="fw-bold mb-3 border-bottom pb-2">${label} #${index + 1}</h5>
                    <input type="hidden" name="hanh_khach[${index}][loai_hanh_khach]" value="${typeValue}">
                    <div class="row g-3">
                        <div class="col-md-5">
                            <label class="form-label text-muted small">Họ tên <span class="text-danger">*</span></label>
                            <input type="text" name="hanh_khach[${index}][ho_ten]" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted small">Giới tính</label>
                            <select name="hanh_khach[${index}][gioi_tinh]" class="form-select">
                                <option value="Nam">Nam</option>
                                <option value="Nữ">Nữ</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Ngày sinh</label>
                            <input type="date" name="hanh_khach[${index}][ngay_sinh]" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-muted small">Quốc tịch</label>
                            <input type="text" name="hanh_khach[${index}][quoc_tich]" class="form-control" value="Việt Nam">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Loại giấy tờ <span class="text-danger">*</span></label>
                            <select name="hanh_khach[${index}][loai_giay_to]" class="form-select" required>
                                <option value="CCCD">CCCD</option>
                                <option value="Hộ chiếu">Hộ chiếu</option>
                                <option value="Giấy khai sinh">Giấy khai sinh</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Số giấy tờ</label>
                            <input type="text" name="hanh_khach[${index}][so_giay_to]" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label text-muted small">Số điện thoại</label>
                            <input type="tel" name="hanh_khach[${index}][so_dien_thoai]" class="form-control">
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label text-muted small">Yêu cầu đặc biệt</label>
                            <textarea name="hanh_khach[${index}][yeu_cau_dac_biet]" class="form-control" rows="2" placeholder="Ăn chay, dị ứng, yêu cầu khác..."></textarea>
                        </div>
                    </div>
                </div>
            `;
        }

        function updateBookingDetails() {
            // Get Current Values
            let adults = parseInt(elQtyAdult.value) || 0;
            let children = parseInt(elQtyChild.value) || 0;
            let babies = parseInt(elQtyBaby.value) || 0;

            // Đảm bảo có ít nhất 1 người lớn
            if (adults < 1) {
                adults = 1;
                elQtyAdult.value = 1;
            }

            // Update Summary Counts
            elTxtAdultCount.textContent = adults;
            elTxtChildCount.textContent = children;
            elTxtBabyCount.textContent = babies;

            // Calculate Totals
            let totalAdult = adults * priceAdult;
            let totalChild = children * priceChild;
            let totalBaby = babies * priceBaby;
            let grandTotal = totalAdult + totalChild + totalBaby;

            // Update Summary Display
            elTxtAdultTotal.textContent = formatVND(totalAdult);
            elTxtChildTotal.textContent = formatVND(totalChild);
            elTxtBabyTotal.textContent = formatVND(totalBaby);

            elTxtGrandTotal.textContent = formatVND(grandTotal);
            elInputGrandTotal.value = grandTotal;

            // RENDER PASSENGER FORMS
            let formsHTML = '';
            let passengerIndex = 0;

            // Render Adults
            for (let i = 0; i < adults; i++) {
                formsHTML += getPassengerFormTemplate(passengerIndex, 'Người lớn', 'adult');
                passengerIndex++;
            }
            // Render Children
            for (let i = 0; i < children; i++) {
                formsHTML += getPassengerFormTemplate(passengerIndex, 'Trẻ em', 'child');
                passengerIndex++;
            }
            // Render Babies
            for (let i = 0; i < babies; i++) {
                formsHTML += getPassengerFormTemplate(passengerIndex, 'Em bé', 'baby');
                passengerIndex++;
            }

            passengersContainer.innerHTML = formsHTML;
        }

        // Gắn sự kiện lắng nghe khi thay đổi số lượng
        elQtyAdult.addEventListener('input', updateBookingDetails);
        elQtyChild.addEventListener('input', updateBookingDetails);
        elQtyBaby.addEventListener('input', updateBookingDetails);

        // Khởi chạy lần đầu để render
        updateBookingDetails();
    });

</script>

@endpush

